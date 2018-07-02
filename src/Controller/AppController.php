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
        } else {
            //die('1');
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
}
