<?php
/**
 * User Controller
 * Controls the routing for the User management application
 * in the framework.
 *
 * @author Saurabh Badhwar
 */

    include_once(ROOT.DS.'library'.DS.'security.php');
    include_once(ROOT.DS.'library'.DS.'session.php');
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
            initiateSession();
            $this->set("title","IEEE NIEC | New User Registration");
            if(isset($_SESSION['user_id']))
            {
                header("LOCATION: /indexs/home");
            }
        }

        /**
         * Sets the contents for the processing of user registration form
         */
        function register()
        {
            initiateSession();
            $this->set("title","IEEE NIEC | New User Registration");
            if(isset($_SESSION['user_id']))
            {
                header("LOCATION: /indexs/home");
            }
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
                $this->sendActivationMail($username);
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
            initiateSession();
            $mail=new Email();
            $activationhash=md5($this->User->getUserSalt($username));
            $to=$this->User->getUserEmail($username);
            $subject="Activate your account";
            $content="Hey there,"."\r\n"."Thank you for registering at ".HOST."\r\n"."Click on the link below to activate your account \r\n ".HOST."users\\activate\\".$username."\\".$activationhash;
            $mail->prepareMail($to,$subject,$content);
            $mail->sendTextMail();
        }

        /**
         * Activate The user account
         *
         * @param String $username The username of the user to be activated
         * @param String $activationhash The activation hash of the user
         */
        function activate($username,$activationhash)
        {
            initiateSession();
            if(isset($_SESSION['user_id']))
            {
                header("LOCATION: /indexs/home");
            }
            $this->set("title","IEEE NIEC | Account Activation");
            $username=sqlSafe($username);
            $activationhash=sqlSafe($activationhash);


            $salt=$this->User->getUserSalt($username);

            if($salt==false)
            {
                $this->set("message","Invalid account");
            }
            else
            {
                if($activationhash==md5($salt))
                {
                    $this->User->updateStatus($username,1);
                    $this->set("message","Account activated");
                }
                else
                {
                    $this->set("message","Invalid activation hash");
                }
            }
        }

        /**
         * Logs the user in
         */
        function login()
        {
            initiateSession();
            $this->set("title","Login");
            if(isset($_SESSION['user_id']))
            {
                header("LOCATION: /indexs/home");
            }
        }

        /**
         * Log in processor
         *
         * Starts the session if the user is validated
         */
        function loginauth()
        {
            $this->set("title","IEEE NIEC | User Login");
            $username=sqlSafe($_POST['username']);
            $password=sqlSafe($_POST['password']);

            $salt=$this->User->getUserSalt($username);
            if($salt==false)
            {
                $this->set("message","Username/Password Invalid");
            }
            else
            {
                $inPass=$this->User->getUserPassword($username);
                if($inPass==generateHash($password.$salt) && $this->User->getUserStatus($username)==1)
                {
                    $userID=$this->User->getUserID($username);
                    initiateSession();
                    setSessionData("user_id",md5($userID));
                    setSessionData("user_username",$username);
                    setSessionData("user_identifier",md5($_SERVER['HTTP_USER_AGENT'].$_SERVER['REMOTE_ADDR']));
                    $this->set("message","Login successful");
                    header("LOCATION: /indexs/home");
                }
                else
                {
                    $this->set("message","Username/Password Invalid or Account not activate.");
                }
            }
        }

        /**
         * Logs the user out
         */
        function logout()
        {
            initiateSession();
            $this->set("title","IEEE NIEC");

            if(isset($_SESSION['user_id']))
            {
                foreach($_SESSION as $vals)
                {
                    $vals=null;
                }
                closeSession();
                $this->set("message","You have been logged out");
            }
            else
            {
                $this->set("message","User not logged in");
            }
        }

        /**
         * Forgot password page
         */
        function forgotpassword()
        {
            $this->set("title","Forgot Password");
        }

        /**
         * Password reset confirmation
         */
        function processreset()
        {
            $this->set("title","IEEE NIEC | Password Reset");
            $username=sqlSafe($_POST['username']);
            $passwordResetCode=$this->User->getUserPassword($username);
            if($passwordResetCode==false)
            {
                $this->set("message","No user found with the specified Username");
            }
            else
            {
                $mail=new Email();
                $activationhash=md5($passwordResetCode);
                $to=$this->User->getUserEmail($username);
                $subject="Reset your password";
                $content="Hey there,"."\r\n"."You have requested a password reset at ".HOST."\r\n"."Click on the link below to reset your password \r\n ".HOST."users\\reset\\".$username."\\".$activationhash;
                $mail->prepareMail($to,$subject,$content);
                if($mail->sendTextMail()==true)
                {
                    $this->set("message","A mail with the reset code has been sent to your mail ID");
                }
                else
                {
                    $this->set("message","There was an error resetting the password. Try again later.");
                }

            }
        }

        /**
         * Reset Password
         *
         * @param String $username The username for password reset
         * @param String $activationhash The reset code
         *
         */
        function reset($username,$activationhash)
        {
            $this->set("title","IEEE NIEC | New Password");
            $username=sqlSafe($username);
            $activationhash=sqlSafe($activationhash);


            $hash=$this->User->getUserPassword($username);

            if($hash==false)
            {
                $this->set("message","Invalid account");
            }
            else
            {
                if($activationhash==md5($hash))
                {
                    $this->User->updateStatus($username,1);
                    $this->set("message","Reset Your password");
                }
                else
                {
                    $this->set("message","Invalid activation hash");
                }
            }
        }
    }