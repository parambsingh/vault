<?php
/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link      https://cakephp.org CakePHP(tm) Project
 * @since     0.2.9
 * @license   https://opensource.org/licenses/mit-license.php MIT License
 */

namespace App\Controller;

use Cake\Controller\Controller;
use Cake\Event\Event;
use Cake\ORM\TableRegistry;
use Cake\Core\Configure;

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @link https://book.cakephp.org/3.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller {
    
    /**
     * Initialization hook method.
     *
     * Use this method to add common initialization code like loading components.
     *
     * e.g. `$this->loadComponent('Security');`
     *
     * @return void
     */
    public function initialize() {
        parent::initialize();
        
        $this->loadComponent('Flash');
        
        $this->loadComponent('RequestHandler');
        $this->loadComponent('Flash');
        $this->loadComponent('Cookie');
        
        $this->loadComponent('Auth', [
            'userModel' => 'Users',
            'authenticate' => [
                'Form' => [
                    'fields' => ['username' => 'email', 'password' => 'password']
                ]
            ],
            'loginAction' => [
                'controller' => 'Users',
                'action' => 'login'
            ],
            'loginRedirect' => [
                'controller' => 'Users',
                'action' => 'dashboard'
            ],
            'logoutRedirect' => [
                'controller' => 'Users',
                'action' => 'login'
            ],
        ]);
        
        if ($this->Auth->user()) {
            $this->set('authUser', $this->Auth->user());
            $memosTable = TableRegistry::get('Memos');
            $memo_count = $memosTable->find()->where(['Memos.user_id' => $this->Auth->user('id'), 'Memos.exported' => false])->count();
            $this->set('memo_count', $memo_count);
    
            if(empty($this->Cookie->read('raidaEcho'))){
              //  $this->echoRiada();
            }
    
            $this->set('raidaStatus', $this->Cookie->read('raidaEcho'));
        } else {
            $this->viewBuilder()->setLayout('login_register');
        }
        
        
    }
    
    public function responseFormat() {
        $returnArray = [
            "code" => $this->responseCode,
            "message" => $this->responseMessage,
        ];
        if ($this->currentPage > 0) {
            $this->responseData['currentPage'] = $this->currentPage;
        }
        
        if (isset($this->responseData['total'])) {
            $this->responseData['pages'] = ceil($this->responseData['total'] / PAGE_LIMIT);
        }
        
        $returnArray['data'] = !empty($this->responseData) ? $this->responseData : ['message' => 'Data not found'];
        
        return json_encode($returnArray);
    }
    
    public function getErrorMessage($errors, $show = false, $field = []) {
        if (is_array($errors)) {
            foreach ($errors as $key => $error) {
                $field[$key] = "[" . $key . "]";
                $this->getErrorMessage($error, $show, $field);
                break;
            }
        } else {
            $this->responseMessage = ($show) ? implode(" >> ", $field) . " >> " . $errors : $errors;
        }
    }
    
    public function getCurrentPage() {
        $this->currentPage = (!empty($this->request->query['page']) && $this->request->query['page'] > 0) ? $this->request->query['page'] : 1;
        return $this->currentPage;
    }
    
    public function verifyRecatpcha($aData) {
        if (!$aData) {
            return true;
        }
        $recaptcha_secret = Configure::read('GoogleRecatpcha.secret_key');
        $url = "https://www.google.com/recaptcha/api/siteverify?secret=" . $recaptcha_secret . "&response=" . $aData['g-recaptcha-response'];
        $response = json_decode(@file_get_contents($url));
        
        return ($response->success == true) ? true : false;
    }
    
    public function echoRiada(){
    
        $serverStatus = "up";
        
        try {
            //cURL starts
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, ECHO_RAIDA_API);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPGET, true);
            $result = curl_exec($ch);
            
            //error handling for cURL
            if ($result === false) {
                $serverStatus = "down";
            } else {
                $cc = json_decode($result, true);
                if ((isset($cc['status']) && in_array($cc['status'], ["fail", "error"]))) {
                    $serverStatus = "down";
                }
            }
            curl_close($ch);
        
        } catch (Exception $e) {
            //Do SomeThing
        }
    
    
        $this->Cookie->write('raidaEcho', $serverStatus);
        
    }
}
