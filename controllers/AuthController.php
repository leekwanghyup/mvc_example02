<?php 

namespace app\controllers;

use app\core\Request;
use app\models\RegisterModel;

class AuthController extends Controller
{

    public function login(Request $reqeust)
    {
        $this->setLayout('auth');
        if($reqeust->isPost()){
            return 'handle submitted data';
        }
        return $this->render('login');
    }

    public function register(Request $reqeust)
    {
        $this->setLayout('auth');
        $registerModel = new RegisterModel(); 
        if($reqeust->isPost())
        {
            $registerModel->dataload($reqeust->getBody());
            
            if($registerModel->validate() && $registerModel->register())
            {
                return "Success"; 
            }

            return $this->render('register', ['model'=> $registerModel]);
        }
        
        return $this->render('register', ['model'=> $registerModel]);
    }
}

?>