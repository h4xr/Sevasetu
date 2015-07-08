<?php
/**
 * User Controller
 * Controls the routing for the User management application
 * in the framework.
 *
 * @author Saurabh Badhwar
 */

    include_once(ROOT.DS.'library'.DS.'security.php');
    /**
     * Class UsersController
     *
     * Provides methods to execute the user management features in the
     * framework.
     */
    class UsersController extends Controller
    {
        /**
         * Sets the content for New User registration form
         */
        function newuser()
        {
            $this->set("title","New User Registration");
        }

        /**
         * Sets the contents for the processing of user registration form
         */
        function register()
        {
            $name=sqlSafe($_POST['name']);
            $username=sqlSafe($_POST['username']);
            $password=sqlSafe($_POST['password']);
            $password2=sqlSafe($_POST['password2']);
            $salt=generateSalt();
            $email=sqlSafe($_POST['email']);
            $dor=date("Y-m-d H:i:s");
            $dob=sqlSafe($_POST['dob']);
            $profilepicPath=ROOT.DS.'public'.DS.'uploads'.DS.'dp'.DS.'default.jpg';
            if($password===$password2)
            {
                $password=generateHash($password.$salt);
            }
            else
            {
                $this->set("message","Password doesn't match");
            }
            $profilepic=new Image($_FILES['profile_picture']);
            $profilepic->setUploadPath(ROOT.DS.'public'.DS.'uploads'.DS.'dp');
            if($profilepic->validate()==false)
            {
                $this->set("message","Unsupported Image Format for profile picture. Try again.");
            }
            else
            {
                if($profilepic->moveUploadedImage()==true)
                {
                    $profilepicPath=$profilepic->getUploadLocation();
                    $profilepic=null;
                }
                else
                {
                    $this->set("message","Error uploading profile picture. Try again after some time.");
                }
            }
            if($this->User->insertUser($name,$username,$password,$salt,$email,$dob,$dor,$profilepicPath)==-1)
            {
                $this->set("message","There was some error processing your request. Try again later.");
            }
            else
            {
                $this->set("message","Registration Successful. Please check your mail to activate your account.");
            }
        }

        /**
         * Sends the activation mail
         *
         * @param String $username
         */
        function sendActivationMail($username)
        {
            $mail=new Email();
            $activationhash=md5($this->User->getUserSalt($username));
            $to=$this->User->getUserEmail($username);
            $subject="Activate your account";
            $content="Hey there,"."\r\n"."Thank you for registering at ".HOST."\r\n"."Click on the link below to activate your account \r\n ".HOST."users\\activate\\".$username."\\".$activationhash;
            $mail->prepareMail($to,$subject,$content);
            $mail->sendTextMail();
        }
    }