<?php
/**
 * Created by PhpStorm.
 * User: saurabh
 * Date: 26/3/15
 * Time: 1:21 PM
 */

class UsersController extends Controller{

    /*
     * New user
     */
    public function newuser()
    {
        $this->set("title","New User Registration");
    }

    /*
     * Register a new user
     */
    public function register(){
        $name=filter_input(INPUT_POST,$_POST['name'],FILTER_SANITIZE_STRING);
        $username=filter_input(INPUT_POST,$_POST['username'],FILTER_SANITIZE_STRING);
        $password=filter_input(INPUT_POST,$_POST['password'],FILTER_SANITIZE_STRING);
        $email=filter_input(INPUT_POST,$_POST['email'],FILTER_SANITIZE_STRING);
        $dob=filter_input(INPUT_POST,$_POST['DOB'],FILTER_SANITIZE_STRING);
        $dor=date("Y-m-d H:i:s");
        $salt=generateSalt();
        $password=generateHash($password.$salt);

        if(verifyEmail($email)==true)
        {
            if($this->User->insertUser($name,$email,$username,$password,$salt,$dob,$dor)==true)
            {
                $this->set("title","Registration successful");
                $this->set("message","Thank you for registering. Please check your mail to activate your account.");
            }
            else
            {
                $this->set("title","Registration failed");
                $this->set("message","Sorry, we are experiencing some problems. Try again later.");
                error_log("Unable to register the user with the database");
            }
        }
        else
        {
            $this->set("title","Registration failed");
            $this->set("message","Sorry, the E-Mail ID provided doesn't appear to be valid.");
        }
    }

    /*
     * Activate user account
     */
    public function activate()
    {
        $id=filter_input(INPUT_GET,'key',FILTER_SANITIZE_STRING);
        $username=filter_input(INPUT_GET,'user',FILTER_SANITIZE_STRING);
        if($id==md5($this->User->getUserID($username)))
        {
            $this->User->updateUserStatus($username,1);
            $this->set("title","Success");
            $this->set("message","Account has been activated successfully.");
        }
        else
        {
            $this->set("title","Failed");
            $this->set("message","Account activation has failed. Please try again after some time.");
        }
    }

    /*
     * authenticate the user
     */
    public function authenticate()
    {
        $this->set("title","User Login");
    }

    /*
     * log the user in
     */
    public function login()
    {
        $username=filter_input(INPUT_POST,'username',FILTER_SANITIZE_STRING);
        $password=filter_input(INPUT_POST,'password',FILTER_SANITIZE_STRING);

        $data=$this->User->getUserEncryption($username);
        if(generateHash($password.$data['users_salt'])==$data['users_password'])
        {
            session_start();
            $_SESSION['identification_string']=$_SERVER['HTTP_USER_AGENT'];
            $_SESSION['user']=md5($this->User->getUserID($username));
            $_SESSION['username']=$username;
            $this->set("title","Login Successful");
            $this->set("message","Login was successful. Wait while we redirect you.");
        }
        else
        {
            $this->set("title","Login failed.");
            $this->set("message","Login has failed. Please check your username/password combination.");
        }
    }

    /*
     * log the user out of the system
     */
    public function logout()
    {
        session_start();
        session_destroy();
        $this->set("title","Logged out");
        $this->set("message","You have been logged out successfully from the system.");
    }

    /*
     * View user profile
     */
    public function profile()
    {
        session_start();
        $username=filter_input(INPUT_SESSION,'username',FILTER_SANITIZE_STRING);
        $this->set("title","Profile");
        $this->set("user",$this->User->getUser($username));
    }
} 