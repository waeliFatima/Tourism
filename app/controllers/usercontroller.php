<?php namespace App\Controllers;
use App\Controller;
use App\User;
class UserController extends Controller {
    public function showAction()
    {
        $this->render('user.show',['name'=>'fatima']);
    }
    public function updateAction($name){
        $this -> render('user.update',compact('name'));
    }
}