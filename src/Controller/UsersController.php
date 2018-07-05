<?php

namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;
use Cake\Core\Configure;

/**
 * Users Controller
 *
 * @property \App\Model\Table\UsersTable $Users
 *
 * @method \App\Model\Entity\User[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class UsersController extends AppController {
    
    public function initialize() {
        parent::initialize();
        
        $this->Auth->allow(['register', 'isUniqueEmail', 'dashboard', 'login', 'add', 'forgotPassword', 'forgotPasswordApi', 'resetPassword', 'resetPasswordApi']);
    }
    
    
    public function dashboard() {
        
        if (!$this->Auth->user()) {
            return $this->redirect(['action' => 'login']);
        }
        
        $memosTable = TableRegistry::get('Memos');
        $memos = $memosTable->find()->where(['Memos.user_id' => $this->Auth->user('id'), 'Memos.exported' => false])->hydrate(false)->all()->toArray();
        
        $finalMemos = $memos;
        
        if (count($memos) < 12) {
            for ($i = count($memos); $i < (12 - count($memos)); $i++) {
                $finalMemos[] = [
                    'thumb' => '/img/cropped-fav-192x192.png',
                    'serial_no' => 0
                ];
            }
        }
        
        $this->set('memos', $finalMemos);
        
    }
    
    public function login() {
        //if already logged-in, redirect
        if ($this->Auth->user()) {
            return $this->redirect($this->Auth->redirectUrl());
        }
        //pr($this->request->session()->read('Auth.User'));
        if ($this->request->is('post') || $this->request->query('provider')) {
            $user = $this->Auth->identify();
            if ($user) {
                $this->Auth->setUser($user);
                $this->Flash->success(__('Hi ' . $user['name']));
                return $this->redirect($this->Auth->redirectUrl());
            } else {
                $this->Flash->error(__('Invalid username or password, try again'));
            }
        }
    }
    
    /**
     * logout method
     */
    public function logout() {
        return $this->redirect($this->Auth->logout());
    }
    
    public function register() {
        //if already logged-in, redirect
        if ($this->Auth->user()) {
            return $this->redirect($this->Auth->redirectUrl());
        }
        
        
        $user = $this->Users->newEntity();
        if ($this->request->is('post')) {
            $user = $this->Users->patchEntity($user, $this->request->getData(), ['validate' => 'newUser']);
            
            if (!$this->verifyRecatpcha($this->request->data)) {
                $this->Flash->error(__('Incorrect Captcha.'));
            } else {
                if ($this->Users->save($user)) {
                    
                    $options = [
                        'template' => 'welcome',
                        'to' => $user->email,
                        'subject' => _('Welcome to ' . SITE_TITLE),
                        'viewVars' => [
                            'name' => $user->first_name,
                            'email' => $user->email
                        ]
                    ];
                    
                    $this->loadComponent('EmailManager');
                    $this->EmailManager->sendEmail($options);
                    
                    $this->Auth->setUser($user);
                    $this->Flash->success(__('You have successfully registered.'));
                    return $this->redirect($this->Auth->redirectUrl());
                } else {
                    if (is_array($user->errors())) {
                        foreach ($user->errors() as $errors) {
                            foreach ($errors as $err) {
                                $error = $err;
                            }
                        }
                    }
                    $this->Flash->error(__($error));
                }
            }
        }
        
        $googleRecatpcha = Configure::read('GoogleRecatpcha');
        
        $this->set(compact('user', 'googleRecatpcha'));
    }
    
    public function forgotPassword() {
        if ($this->Auth->user()) {
            return $this->redirect($this->Auth->redirectUrl());
        }
    }
    
    public function forgotPasswordApi() {
        $this->autoRender = false;
        $this->responseCode = CODE_BAD_REQUEST;
        if ($this->request->is(['patch', 'post', 'put'])) {
            $user = $this->Users->findByEmail($this->request->data['email'])->first();
            
            if (!empty($user)) {
                $user->forgot_password_token = md5(uniqid(rand(), true));
                //$resetUrl = $this->request->scheme() . '://' . $this->request->host() . '/users/reset-password/' . $user->forgot_password_token;
                $resetUrl = SITE_URL . '/users/reset-password/' . $user->forgot_password_token;
                if ($this->Users->save($user)) {
                    $options = [
                        'template' => 'forgot_password',
                        'to' => $this->request->data['email'],
                        'subject' => _('Reset Password'),
                        'viewVars' => [
                            'name' => $user->first_name,
                            'resetUrl' => $resetUrl,
                        ]
                    ];
                    
                    $this->loadComponent('EmailManager');
                    $this->EmailManager->sendEmail($options);
                    $this->responseCode = SUCCESS_CODE;
                    $this->responseMessage = __('A link to reset the password with the instruction has been sent to your inbox');
                }
            } else {
                $this->responseCode = EMAIL_DOESNOT_REGISTERED;
                $this->responseMessage = __('Email does not exists');
            }
        }
        
        echo $this->responseFormat();
    }
    
    public function resetPassword($forgotPasswordToken) {
        if ($this->Auth->user()) {
            return $this->redirect($this->Auth->redirectUrl());
        }
        $user = $this->Users->findByForgotPasswordToken($forgotPasswordToken)->first();
        if (!empty($user)) {
            $this->set('forgotPasswordToken', $forgotPasswordToken);
        } else {
            $this->Flash->error(__('Forgot password token has been expired. Please, try again.'));
            return $this->redirect(['controller' => 'Users', 'action' => 'login']);
        }
    }
    
    public function resetPasswordApi() {
        $this->autoRender = false;
        $this->responseCode = CODE_BAD_REQUEST;
        if ($this->request->is(['patch', 'post', 'put'])) {
            $user = $this->Users->findByForgotPasswordToken($this->request->data['forgot_password_token'])->first();
            if ($user) {
                /*
                 * Restrict user to edit only while listed fields
                 */
                $editableFields = ['password', 'verify_password', 'forgot_password_token'];
                foreach ($this->request->data as $field => $val) {
                    if (!in_array($field, $editableFields)) {
                        unset($this->request->data[$field]);
                    }
                }
                $user['forgot_password_token'] = "";
                $user = $this->Users->patchEntity($user, $this->request->getData());
                if ($this->Users->save($user)) {
                    $this->responseMessage = __('Your password has been updated.');
                    $this->responseCode = SUCCESS_CODE;
                } else {
                    $this->responseMessage = __('Something went wrong. Please, try again.');
                }
            } else {
                $this->responseMessage = __('Forgot password token has been expired. Please, try again.');
            }
        }
        echo $this->responseFormat();
    }
    
    public function isUniqueEmail($id = null) {
        $this->autoRender = false;
        if ($id === null) {
            if ($this->Users->findByEmail($this->request->query['email'])->count()) {
                $alreadyExists = "false";
            } else {
                $alreadyExists = "true";
            }
        } else {
            $count = $this->Users->find()
                ->where(['id !=' => $id, 'email' => $this->request->query['email']])
                ->count();
            if ($count) {
                $alreadyExists = "false";
            } else {
                $alreadyExists = "true";
            }
        }
        echo $alreadyExists;
    }
    
    
    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index() {
        if ($this->Auth->user()) {
            return $this->redirect($this->Auth->redirectUrl());
        }
    }
    
    /**
     * View method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null) {
        $user = $this->Users->get($id, [
            'contain' => []
        ]);
        
        $this->set('user', $user);
    }
    
    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add() {
        $user = $this->Users->newEntity();
        
        if ($this->request->is('post')) {
            
            $user = $this->Users->patchEntity($user, $this->request->getData(), ['validate' => 'newUser']);
            
            if ($this->Users->save($user)) {
                
                //                $options = [
                //					'template' => 'welcome',
                //					'to' => $user->email,
                //					'subject' => _('Welcome to '. SITE_TITLE),
                //					'viewVars' => [
                //						'name' => $user->first_name,
                //						'email' => $user->email
                //					]
                //				];
                //
                //				$this->loadComponent('EmailManager');
                //				$this->EmailManager->sendEmail($options);
                $this->Auth->setUser($user);
                $this->Flash->success(__('You have successfully registered.'));
                return $this->redirect($this->Auth->redirectUrl());
            } else {
                if (is_array($user->errors())) {
                    foreach ($user->errors() as $errors) {
                        foreach ($errors as $err) {
                            $error = $err;
                        }
                    }
                }
                $this->Flash->error(__($error));
                return $this->redirect(['action' => 'register']);
            }
        }
        
        $this->set(compact('user'));
    }
    
    /**
     * Edit method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null) {
        $user = $this->Users->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $user = $this->Users->patchEntity($user, $this->request->getData());
            if ($this->Users->save($user)) {
                $this->Flash->success(__('The user has been saved.'));
                
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The user could not be saved. Please, try again.'));
        }
        $this->set(compact('user'));
    }
    
    /**
     * Delete method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null) {
        $this->request->allowMethod(['post', 'delete']);
        $user = $this->Users->get($id);
        if ($this->Users->delete($user)) {
            $this->Flash->success(__('The user has been deleted.'));
        } else {
            $this->Flash->error(__('The user could not be deleted. Please, try again.'));
        }
        
        return $this->redirect(['action' => 'index']);
    }
    
    public function addMemos() {
    
    }
    
    public function backupMemos() {
        $memosTable = TableRegistry::get('Memos');
        $memos = $memosTable->find()->where(['Memos.user_id' => $this->Auth->user('id'), 'Memos.exported' => false])->hydrate(false)->all()->toArray();
        $this->set('memos', $memos);
        
    }
    
    public function exportMemos() {
        $memosTable = TableRegistry::get('Memos');
        $memos = $memosTable->find()->where(['Memos.user_id' => $this->Auth->user('id'), 'Memos.exported' => false])->hydrate(false)->all()->toArray();
        $this->set('memos', $memos);
        
    }
    
    
    public function yourActivity() {
    
    }
    
    public function customerSupport() {
    
    }
}
