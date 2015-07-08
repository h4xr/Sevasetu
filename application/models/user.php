<?php
/**
 * Created by PhpStorm.
 * User: saurabh
 * Date: 26/3/15
 * Time: 11:19 AM
 */

class User extends Model{

    /**
     * @var Int $user_id The user id identifier of the user
     */
    private $user_id;
    /**
     * @var String $user_name The name of the user
     */
    private $user_name;
    /**
     * @var String $user_username The username of the user
     */
    private $user_username;
    /**
     * @var String $user_email The email address of the user
     */
    private $user_email;
    /**
     * @var String $user_password The password of the user
     */
    private $user_password;
    /**
     * @var String $user_salt The password salt of the user
     */
    private $user_salt;
    /**
     * @var String $user_pic The path to user profile picture
     */
    private $user_pic;
    /**
     * @var DateTime $user_dob The date of birth of user
     */
    private $user_dob;
    /**
     * @var DateTime $user_dor The date of registration of user
     */
    private $user_dor;
    /**
     * @var Int $user_status The activation status of the user
     */
    private $user_status;

    //Support functions
    /**
     * Returns the password salt of the user
     *
     * @param String $username The username of the user
     *
     * @returns String|false
     */
    function getUserSalt($username)
    {
        $this->user_username=$username;
        $this->_result=$this->_dbHandle->query("SELECT users_salt FROM users WHERE 'users_username'='$this->user_username'");
        if($this->_result==FALSE)
        {
            $this->watchdog->logError("Unable to execute the getUserSalt query successfully",200,__CLASS__);
            return false;
        }
        foreach($this->_result as $result)
        {
            $this->user_salt=$result['users_salt'];
        }
        return $this->user_salt;
    }

    /**
     * Returns the profile picture path of the user
     *
     * @param String $username The username of the user
     *
     * @returns String|false
     */
    function getUserPic($username)
    {
        $this->user_username=$username;
        $this->_result=$this->_dbHandle->query("SELECT users_pic FROM users WHERE 'users_username'='$this->user_username'");
        if($this->_result==FALSE)
        {
            $this->watchdog->logError("Unable to execute the getUserPic query successfully",200,__CLASS__);
            return false;
        }
        foreach($this->_result as $result)
        {
            $this->user_pic=$result['users_pic'];
        }
        return $this->user_pic;
    }

    /**
     * Returns the activation status of the user
     *
     * @param String $username The username of the user
     *
     * @returns Int
     */
    function getUserStatus($username)
    {
        $this->user_username=$username;
        $this->_result=$this->_dbHandle->query("SELECT users_status FROM users WHERE 'users_username'='$this->user_username'");
        if($this->_result==FALSE)
        {
            $this->watchdog->logError("Unable to execute the getUserStatus query successfully",200,__CLASS__);
            return -1;
        }
        foreach($this->_result as $result)
        {
            $this->user_status=$result['users_status'];
        }
        return $this->user_status;
    }

    /**
     * Returns the password of the user
     *
     * @param String $username The username of the user
     *
     * @returns String|false
     */
    function getUserPassword($username)
    {
        $this->user_username=$username;
        $this->_result=$this->_dbHandle->query("SELECT users_password FROM users WHERE 'users_username'='$this->user_username'");
        if($this->_result==FALSE)
        {
            $this->watchdog->logError("Unable to execute the getUserPassword query successfully",200,__CLASS__);
            return false;
        }
        foreach($this->_result as $result)
        {
            $this->user_password=$result['users_password'];
        }
        return $this->user_password;
    }

    /**
     * Returns the ID of the user
     *
     * @param String $username The username of the user
     *
     * @returns INT|false
     */
    function getUserID($username)
    {
        $this->user_username=$username;
        $this->_result=$this->_dbHandle->query("SELECT users_salt FROM users WHERE 'users_username'='$this->user_username'");
        if($this->_result==FALSE)
        {
            $this->watchdog->logError("Unable to execute the getUserID query successfully",200,__CLASS__);
            return false;
        }
        foreach($this->_result as $result)
        {
            $this->user_id=$result['users_id'];
        }
        return $this->user_id;
    }

    /**
     * Returns the Email of the user
     *
     * @param String $username The username of the user
     *
     * @returns String|false
     */
    function getUserEmail($username)
    {
        $this->user_username=$username;
        $this->_result=$this->_dbHandle->query("SELECT users_email FROM users WHERE 'users_username'='$this->user_username'");
        if($this->_result==FALSE)
        {
            $this->watchdog->logError("Unable to execute the getUserEmail query successfully",200,__CLASS__);
            return false;
        }
        foreach($this->_result as $result)
        {
            $this->user_email=$result['users_email'];
        }
        return $this->user_email;
    }

    /**
     * Stores the data of the user in the class
     *
     * @param String $username The username of the user
     *
     * @returns Bool
     */
    function getUser($username)
    {
        $this->user_username=$username;
        $this->_result=$this->_dbHandle->query("SELECT * FROM users WHERE 'users_username'='$this->user_username'");
        if($this->_result==FALSE)
        {
            $this->watchdog->logError("Unable to execute the getUser query successfully",200,__CLASS__);
            return false;
        }
        foreach($this->_result as $result)
        {
            $this->user_id=$result['users_id'];
            $this->user_name=$result['users_name'];
            $this->user_password=$result['users_username'];
            $this->user_password=$result['users_password'];
            $this->user_email=$result['users_email'];
            $this->user_salt=$result['users_salt'];
            $this->user_status=$result['users_status'];
            $this->user_dor=$result['users_dor'];
            $this->user_dob=$result['users_dob'];

        }

        return true;
    }

    /**
     * Updates the user activation status
     *
     * @param String $username The username of the user
     * @param Int $status The new status of the user
     *
     * @returns Int
     */
    function updateStatus($username,$status)
    {
        $this->user_username=$username;
        $this->_result=$this->_dbHandle->exec("UPDATE users SET 'users_status'=$status WHERE 'users_username'='$this->user_username'");
        if($this->_result===FALSE)
        {
            $this->watchdog->logError("Unable to perform update query updateStatus",201,__CLASS__);
            return -1;
        }
        return $this->_result;
    }

    /**
     * Updates the user password
     *
     * @param String $username The username of the user
     * @param String $password The new password of the user
     *
     * @returns Int
     */
    function updatePassword($username,$password)
    {
        $this->user_username=$username;
        $this->_result=$this->_dbHandle->exec("UPDATE users SET 'users_password'=$password WHERE 'users_username'='$this->user_username'");
        if($this->_result===FALSE)
        {
            $this->watchdog->logError("Unable to perform update query updatePassword",201,__CLASS__);
            return -1;
        }
        return $this->_result;
    }

    //Core functions

    /**
     * Inserts a new user record in the database
     *
     * @param String $name
     * @param String $username
     * @param String $password
     * @param String $salt
     * @param String $email
     * @param DateTime $dob
     * @param DateTime $dor
     * @param String $pic
     *
     * @returns Int
     */
    function insertUser($name,$username,$password,$salt,$email,$dob,$dor,$pic)
    {
        $this->user_name=$name;
        $this->user_username=$username;
        $this->user_password=$password;
        $this->user_salt=$salt;
        $this->user_email=$email;
        $this->user_dob=$dob;
        $this->user_dor=$dor;
        $this->user_pic=$pic;
        $query="INSERT INTO users(users_name,users_username,users_email,users_password,users_salt,users_dob,users_dor,users_status,users_pic) VALUES('$this->user_name','$this->user_username','$this->user_email','$this->user_password','$this->user_salt','$this->user_dob','$this->user_dor','$this->user_status','$this->user_pic')";
        $this->_result=$this->_dbHandle->exec($query);
        if($this->_result===FALSE)
        {
            $this->watchdog->logError("Unable to insert a new user record: ".print_r($this->_dbHandle->errorInfo(),true),201,__CLASS__);
            return -1;
        }
        return $this->_result;
    }

    /**
     * Removes the user from the database
     *
     * @param String $username The username of the user to be removed from the database
     *
     * @returns Int
     */
    function removeUser($username)
    {
        $this->user_username=$username;
        $this->_result=$this->_dbHandle->exec("DELETE FROM users WHERE 'users_username'='$this->user_username'");
    }
}