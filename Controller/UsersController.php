<?php

App::uses('AppController','Controller');

class UsersController extends AppController{
    
    public function beforeFilter(){
        parent::beforeFilter();
        //$this->Aath->allow('add');
        // ユーザー自身による登録とログアウトを許可する
        $this->Auth->allow('add', 'logout');
    }
    
    public function login() {
        if ($this->request->is('post')) {
            if ($this->Auth->login()) {
                $this->redirect($this->Auth->redirect());
            } else {
                $this->Flash->error(__('Invalid username or password, try again'));
            }
        }
    }
    
    public function logout() {
        $this->redirect($this->Auth->logout());
    }

    public function index(){
        $this->User->recursive=0;
        $this->set('users',$this->paginate());
    }
    
    public function view($id = null){
        $this->User->id = $id;
        if(!$this->User->exist()){
            throw new NotFoundException(__('Invalid user'));            
        }
        $this->set('user',$this->User->findById($id));
    }
    
    public function add(){
        if($this->request->is('post')){
            $this->User->create();
            if($this->User->save($this->request->data)){
                $this->Flash->success(__('the user has been saved'));
                return $this->redirect(array('action'=>'index'));
            }
            $this->Flash->error(
                __('the user cluld not be saved , please , try agin.')
                );
        }
    }
    public function edit($id = null){
        $this->User->id = $id;
        if(!$this->User->exist()){
            throw new NotFoundException(__('Invalid user'));
        }
        if($this->request->is('post')|| $this->request->is('put')){
            if($this->User->save($this->request->data)){
                $this->Flash->success(__('the user bash been saved!'));
                return $this->redirect(array('action'=>'index'));
            }
            $this->Flash->error(
                __('the user could not be saved ,please , try agin')
                );
            
        }else{
            $this->request->data = $this->User->findById();
            unset($this->request->data['User']['password']);
        }
        
    }
    
    public function delete($id = null){
        $this->request->allowMethod('post');
        
        $this->User->id = $id;
        if(!$this->User->exist()){
            throw new NotFoundException(__('Invalid user'));
        }
        if($this->User->delete()){
            $this->Flash->success(__('user deleted'));
            return $this->redirect(array('action' => 'index'));
        }
        $this->Flash->error(__('User was not deleted...'));
        return $this->redirect(array('action' => 'index'));
    }
    
}