<?php

namespace App\Controller;

use App\Controller\AppController;

/**
 * Memos Controller
 *
 * @property \App\Model\Table\MemosTable $Memos
 *
 * @method \App\Model\Entity\Memo[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class MemosController extends AppController {
    
    
    public function initialize() {
        parent::initialize();
    }
    
    public function test() {
        $this->loadComponent('Thumb');
        
        $memoPath = WWW_ROOT . 'files/memos/' . $this->Auth->user('id') . '/thumbs/';
        
        $options = [
            'destinationPath' => $memoPath,
            'image' => ['type' => "image/jpeg"],
            'tmpname' => SITE_URL . '/files/memos/' . $this->Auth->user('id') . '/1.Celebrium.1374657.1.naomi.jpeg',
            'name' => '1.Celebrium.1374657.1.naomi.jpeg',
            'width' => 300,
            'argHeight' => 214
        ];
        $this->Thumb->create($options);
        
        die;
    }
    
    
    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index() {
        $this->paginate = [
            'contain' => ['Users']
        ];
        $memos = $this->paginate($this->Memos);
        
        $this->set(compact('memos'));
    }
    
    /**
     * View method
     *
     * @param string|null $id Memo id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function story($serialNo = null) {
        $memo = $this->Memos->findBySerialNo($serialNo)->first();
        $this->set('memo', $memo);
    }
    
    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add() {
        $memo = $this->Memos->newEntity();
        if ($this->request->is('post')) {
            $memo = $this->Memos->patchEntity($memo, $this->request->getData());
            if ($this->Memos->save($memo)) {
                $this->Flash->success(__('The memo has been saved.'));
                
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The memo could not be saved. Please, try again.'));
        }
        $users = $this->Memos->Users->find('list', ['limit' => 200]);
        $this->set(compact('memo', 'users'));
    }
    
    /**
     * Edit method
     *
     * @param string|null $id Memo id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null) {
        $memo = $this->Memos->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $memo = $this->Memos->patchEntity($memo, $this->request->getData());
            if ($this->Memos->save($memo)) {
                $this->Flash->success(__('The memo has been saved.'));
                
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The memo could not be saved. Please, try again.'));
        }
        $users = $this->Memos->Users->find('list', ['limit' => 200]);
        $this->set(compact('memo', 'users'));
    }
    
    /**
     * Delete method
     *
     * @param string|null $id Memo id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null) {
        $this->request->allowMethod(['post', 'delete']);
        $memo = $this->Memos->get($id);
        if ($this->Memos->delete($memo)) {
            $this->Flash->success(__('The memo has been deleted.'));
        } else {
            $this->Flash->error(__('The memo could not be deleted. Please, try again.'));
        }
        
        return $this->redirect(['action' => 'index']);
    }
    
    public function upload() {
        $this->autoRender = false;
        $this->responseCode = CODE_BAD_REQUEST;
        $alreadyPowned = false;
        if ($this->request->is(['patch', 'post', 'put'])) {
            $this->loadComponent('Celebrium');
            $file = $this->request->data['file'];
            $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
            
            if (strtolower($ext) == "celebrium") {
            
//                if ($this->request->session()->read('coin')) {
//                    $coin = $this->request->session()->read('coin');
//                } else {
                    $coin = $this->Celebrium->readCelebrium($file['tmp_name']);
//                    $this->request->session()->write('coin', $coin);
//                }
                
                $memo = $this->Memos->find('all')->where(['serial_no' => $coin['sn']])->first();
                
                if (empty($memo)) {
                
                
//                    if ($this->request->session()->read('template')) {
//                        $template = $this->request->session()->read('template');
//                    } else {
                        $template = $this->Celebrium->getTemplate($coin);
//                        $this->request->session()->write('template', $template);
//                    }
                    
                    
                    $memoName = str_replace(CELEB_EXTENSION, MEMO_EXTENSION, $file['name']);
                    $memoRawPath = WWW_ROOT . 'files/raw/' . $memoName;
                    $memoAbsolutePath = '/files/memos/' . $this->Auth->user('id') . '/' . $memoName;
                    
                    $this->Celebrium->base64ToJpeg($template['jpeg'], $memoRawPath);
                    
                    $this->Celebrium->writeInfo($memoRawPath, $memoRawPath, $template['meta'], $coin['sn']);
                    
                    $rawImage = file_get_contents($memoRawPath);
                    
                    $coinStr = $this->Celebrium->buildCloudCoinString($coin);
                    
                    $imageHex = substr_replace(bin2hex($rawImage), $coinStr, 8, 0);
                    
                    $memoPath = WWW_ROOT . 'files/memos/' . $this->Auth->user('id') . '/';
                    
                    if (!file_exists($memoPath)) {
                        mkdir($memoPath, 0777, true);
                    }
                    
                    $this->Celebrium->binaryDataToJpeg(hex2bin($imageHex), $memoPath . $memoName);
                    
                    //unlinking Raw Image
                    unlink($memoRawPath);
                    
                } else {
                    $alreadyPowned = true;
                }
                
            } else if (strtolower($ext) == "jpeg" || strtolower($ext) == "jpg") {
                $coin = $this->Celebrium->readMemo($file['tmp_name']);
                $memo = $this->Memos->find('all')->where(['serial_no' => $coin['sn']])->first();
                
                if (empty($memo)) {
                    
                    $verified = true;
                    $verifiedAns = [];
                    
                    foreach ($coin['an'] as $serverNo => $an) {
                        
                        if ($serverNo == 0) {
                            $verifiedAns[$serverNo] = $this->Celebrium->verifyMemo($coin['sn'], $coin['nn'], $serverNo, $an);
                            
                            if ($verifiedAns[$serverNo]['status'] != "pass") {
                                $verified = false;
                            }
                        }
                    }
                    
                    if ($verified) {
                        
                        if ($this->request->session()->read('template')) {
                            $template = $this->request->session()->read('template');
                        } else {
                            $template = $this->Celebrium->getTemplate($coin);
                            $this->request->session()->write('template', $template);
                        }
                        
                        $memoName = $file['name'];
                        $memoAbsolutePath = '/files/memos/' . $this->Auth->user('id') . '/' . $memoName;
                        
                        $memoPath = WWW_ROOT . 'files/memos/' . $this->Auth->user('id') . '/';
                        
                        if (!file_exists($memoPath)) {
                            mkdir($memoPath, 0777, true);
                        }
                        
                        move_uploaded_file($file['tmp_name'], $memoPath . $memoName);
                        
                    }
                    
                } else {
                    $alreadyPowned = true;
                }
                
            } else {
                //FILE TYPE ERROR
            }
            if (!$alreadyPowned) {
                $this->loadComponent('Thumb');
                
                $thumbPath = WWW_ROOT . 'files/memos/' . $this->Auth->user('id') . '/thumbs/';
                $thumbAbsolutePath = '/files/memos/' . $this->Auth->user('id') . '/thumbs/';
                
                if (!file_exists($thumbPath)) {
                    mkdir($thumbPath, 0777, true);
                }
                
                $options = [
                    'destinationPath' => $thumbPath,
                    'image' => ['type' => "image/jpeg"],
                    'tmpname' => SITE_URL . $memoAbsolutePath,
                    'name' => $memoName,
                    'width' => 300,
                    'argHeight' => 214
                ];
                $this->Thumb->create($options);
                
                
                $memo = $this->Memos->newEntity();
                
                
                $memo->serial_no = $coin['sn'];
                $memo->name = str_replace(MEMO_EXTENSION, "", $memoName);
                $memo->user_id = $this->Auth->user('id');
                $memo->file = $memoAbsolutePath;
                $memo->thumb = $thumbAbsolutePath . $memoName;
                $memo->celebrium_file = '';
                $memo->celebrium_json = json_encode($coin);
                $memo->meta_json = json_encode($template['meta']);
                
                if ($this->Memos->save($memo)) {
                    $this->responseMessage = __('<b>' . $memo->name . '</b> - Thank you for powning the memo');
                    $this->responseCode = SUCCESS_CODE;
                } else {
                    $this->getErrorMessage($memo->errors());
                }
            } else {
                $this->responseMessage = __('<b>' . $memo->name . '</b> - Memo has already pown');
            }
            
        } else {
            $this->responseCode = RECORD_NOT_FOUND;
            $this->responseMessage = __('<b>' . $memo->name . '</b> - Something went wrong, please try again');
        }
        
        echo $this->responseFormat();
    }
}
