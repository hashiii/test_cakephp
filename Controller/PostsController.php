<?php

class PostsController extends AppController{
    //ヘルパーを使えるようにします
    public $helpoers = array('Html','Form','Flash');
    public $componets = array('Flash');
    //アクションを追加
    public function index(){
        //set?ビューにセットするっつーことです
        $this->set('posts',$this->Post->find('all'));
         echo "welcome to" . $this->Auth->user('id');
    }
    
    public function view($id = null){
        if(!$id){
            throw new NotFoundException(__('invalid post'));
        }
        $post = $this->Post->findById($id);
        if(!$post){
            throw new NotFoundException(__('Invalid post'));
        }
        $this->set('post',$post);
    }
    
    public function add(){
        if($this->request->is('post')){
            //モデルの状況をリセット
            $this -> Post->create();
            //認証者の情報
            $this->request->data['Post']['user_id'] = $this->Auth->user('id');
            //requstの中にリクエストされたものが入ってる
            if($this->Post->save($this->request->data)){
                $this->Flash->success(__('Your post has been saved'));
                return $this->redirect(array('action'=>index));
            }
            //saveじゃなかったら？
            $this->Flash->error(__('unable to add your post'));
        }
    }
    
    public function delete ($id){
        if ($this->request->is('get')) {
        throw new MethodNotAllowedException();
        }
    
        if ($this->Post->delete($id)) {
            $this->Flash->success(
                __('The post with id: %s has been deleted.', h($id))
            );
        } else {
            $this->Flash->error(
                __('The post with id: %s could not be deleted.', h($id))
            );
        }
    
        return $this->redirect(array('action' => 'index'));
    }
}