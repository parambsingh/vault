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
    
    
    /**
     * Story method
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
     * @param string|null $id Memo id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function add($serialNo = null) {
    
    }
    
    /**
     * upload method
     *
     * @param string|null $id Memo id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function upload() {
        $this->autoRender = false;
        $this->responseCode = CODE_BAD_REQUEST;
        $alreadyPowned = false;
        $failed = false;
        $this->loadComponent('ActivityManager');
        $activity['user_id'] = $this->Auth->user('id');
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
                    
                    if ($template['error']) {
                        
                        $activity['type'] = "Added Celebrium Failed";
                        $activity['on'] = $file['name'];
                        $activity['status'] = 'Failed';
                        
                        $failed = true;
                        
                    } else {
                        
                        
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
                        
                        $activity['type'] = "Added Celebrium";
                        $activity['on'] = $file['name'];
                        $activity['status'] = 'Success';
                        
                    }
                    
                } else {
                    $alreadyPowned = true;
                    $meta = json_decode($memo->meta_json, true);
                    $activity['type'] = "Added Celebrium Already Exists";
                    $activity['on'] = $file['name'];
                    $activity['status'] = 'Already';
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
                        
                        //                        if ($this->request->session()->read('template')) {
                        //                            $template = $this->request->session()->read('template');
                        //                        } else {
                        $template = $this->Celebrium->getTemplate($coin);
                        //                            $this->request->session()->write('template', $template);
                        //                        }
                        
                        if ($template['error'] || $template['status'] == "error") {
                            $activity['type'] = "Added Memo Failed";
                            $activity['on'] = $file['name'];
                            $activity['status'] = 'Failed';
                            $failed = true;
                        } else {
                            
                            
                            $memoName = $file['name'];
                            $memoAbsolutePath = '/files/memos/' . $this->Auth->user('id') . '/' . $memoName;
                            
                            $memoPath = WWW_ROOT . 'files/memos/' . $this->Auth->user('id') . '/';
                            
                            if (!file_exists($memoPath)) {
                                mkdir($memoPath, 0777, true);
                            }
                            
                            move_uploaded_file($file['tmp_name'], $memoPath . $memoName);
                            
                            $activity['type'] = "Added Memo";
                            $activity['on'] = $file['name'];
                            $activity['status'] = 'Success';
                        }
                        
                    } else {
                        $activity['type'] = "Added Memo Failed";
                        $activity['on'] = $file['name'];
                        $activity['status'] = 'Failed';
                        $failed = true;
                    }
                    
                } else {
                    $alreadyPowned = true;
                    
                    $meta = json_decode($memo->meta_json, true);
                    $activity['type'] = "Added Memo Already Exists";
                    $activity['on'] = $file['name'];
                    $activity['status'] = 'Already';
                }
                
            }
            
            
            if (!$alreadyPowned) {
                if (!$failed) {
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
                        $this->responseMessage = __('<b>' . $file['name'] . '</b> - Thank you for powning the memo');
                        $this->responseCode = SUCCESS_CODE;
                    } else {
                        $this->getErrorMessage($memo->errors());
                    }
                } else {
                    $this->responseMessage = __('<b>' . $file['name'] . '</b> - is not a verified Memo, please try some another Memo');
                }
            } else {
                $this->responseMessage = __('<b>' . $file['name'] . '</b> - Memo has already pown');
            }
    
            $this->ActivityManager->create($activity);
            
        } else {
            $this->responseMessage = __('Something went wrong, please try again');
        }
        
        echo $this->responseFormat();
    }
    
    public function addBackup($serialNo){
        $this->autoRender = false;
        $this->request->session()->write('backupMemo', $serialNo);
        exit;
    }
    
    public function backup(){
        $serialNo = $this->request->session()->read('backupMemo');
        $memo = $this->Memos->find('all')->where(['serial_no' => $serialNo])->first();
        
        $fileContent = @file_get_contents(WWW_ROOT.ltrim($memo->file, '/'));
    
        $activity['type'] = "Memo Backed up";
        $activity['on'] = $memo->name;
        $activity['status'] = 'Success';
        $this->loadComponent('ActivityManager');
        $activity['user_id'] = $this->Auth->user('id');
        $this->ActivityManager->create($activity);
        
        #setting headers
        header('Content-Description: File Transfer');
        header('Cache-Control: public');
        header('Content-Type: image/jpeg');
        header('Content-Type: application/octet-stream');
        header("Content-Transfer-Encoding: binary");
        header('Content-Disposition: attachment; filename=' . basename($memo->file));
        header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
        header('Content-length: ' . filesize(WWW_ROOT.ltrim($memo->file)));
    
        echo $fileContent;
        
    }
    
    public function addExport($serialNo){
        $this->autoRender = false;
        $this->request->session()->write('backupMemo', $serialNo);
        exit;
    }
    
    public function export(){
        $serialNo = $this->request->session()->read('backupMemo');
        $memo = $this->Memos->find('all')->where(['serial_no' => $serialNo])->first();
        
        $fileContent = @file_get_contents(WWW_ROOT.ltrim($memo->file, '/'));
    
        $memo->exported = true;
        
        $this->Memos->save($memo);
        
        $activity['type'] = "Memo Exported";
        $activity['on'] = $memo->name;
        $activity['status'] = 'Success';
        $this->loadComponent('ActivityManager');
        $activity['user_id'] = $this->Auth->user('id');
        $this->ActivityManager->create($activity);
        
        #setting headers
        header('Content-Description: File Transfer');
        header('Cache-Control: public');
        header('Content-Type: image/jpeg');
        header('Content-Type: application/octet-stream');
        header("Content-Transfer-Encoding: binary");
        header('Content-Disposition: attachment; filename=' . basename($memo->file));
        header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
        header('Content-length: ' . filesize(WWW_ROOT.ltrim($memo->file)));
        
        echo $fileContent;
        
    }
}
