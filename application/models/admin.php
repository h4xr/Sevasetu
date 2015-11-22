<?php
/**
 * Manages the database abstraction for the admin space
 *
 * @author Saurabh Badhwar
 */

class Admin extends Model
{
    /**
     * @access private
     * @var Int $admin_id The ID of the admin
     */
    private $admin_id;
    /**
     * @access private
     * @var Int $admin_name The Name of the admin
     */
    private $admin_name;
    /**
     * @access private
     * @var Int $admin_username The username of the admin
     */
    private $admin_username;
    /**
     * @access private
     * @var String $admin_email The email ID of the admin
     */
    private $admin_email;
    /**
     * @access private
     * @var String $admin_salt The password salt for the admin
     */
    private $admin_salt;
    /**
     * @access private
     * @var String $admin_password The password for the admin account
     */
    private $admin_password;

    /**
     * Retrieves the data from the user table and inserts it to admin table
     *
     * @param String $name The name of the admin
     * @param String $username The username of the user to be promoted to admin
     * @param String $email The mail id of the user
     * @param String $salt The password salt
     * @param String $password The password of the admin
     *
     * @returns bool
     */
    function insertAdmin($name,$username,$email,$salt,$password)
    {
        $this->admin_name=$name;
        $this->admin_username=$username;
        $this->admin_email=$email;
        $this->admin_salt=$salt;
        $this->admin_password=$password;

        $query="INSERT INTO arrow_admins(admins_name,admins_username,admins_email,admins_salt,admins_password) VALUES('$this->admin_name','$this->admin_username','$this->admin_email','$this->admin_salt','$this->admin_password')";

        $this->_result=$this->_dbHandle->exec($query);
        if($this->_result===FALSE)
        {
            $this->watchdog->logError("Unable to Insert the data to database",201,__CLASS__);
            return false;
        }
        return true;
    }

    /**
     * Remove the admin from the database
     *
     * @param String $username
     *
     * @returns Bool
     */
    function removeAdmin($username)
    {
        $query="DELETE FROM arrow_admins WHERE admins_username='$username'";
        $this->_result=$this->_dbHandle->exec($query);
        if($this->_result===FALSE)
        {
            $this->watchdog->logError("Unable to remove the specified admin",201,__CLASS__);
            return false;
        }
        return true;
    }

    /**
     * Get admin from username
     *
     * @param String $username
     *
     * @returns Mixed
     */
    function getAdminByUsername($username)
    {
        $this->admin_username=$username;
        $this->_result=$this->_dbHandle->query("SELECT admins_salt,admins_password FROM arrow_admins WHERE admins_username='$this->admin_username'");
        if($this->_result==FALSE)
        {
            $this->watchdog->logError("Unable to execute the getUser query successfully",200,__CLASS__);
            return false;
        }
        $data=array();
        foreach($this->_result as $result)
        {
            $data=$result;
        }
        return $data;
    }

    /**
     * Insert new slide into the database
     *
     * @param String $title The title of the slide
     * @param String $description The description of the slide
     * @param String $image The path where the image has been stored
     *
     * @returns bool
     */
    function insertSlide($title,$description,$image)
    {
        $query="INSERT INTO arrow_slides(slides_title,slides_description,slides_image) VALUES('$title','$description','$image')";
        $this->_result=$this->_dbHandle->exec($query);
        if($this->_result===FALSE)
        {
            $this->watchdog->logError("Unable to execute insert slide query",201,__CLASS__);
            return false;
        }
        return true;
    }

    /**
     * Remove the slide associated with the given ID
     * @param Int $id The ID of the inserted slide
     * @returns bool
     */
    function removeSlide($id)
    {
        $query="DELETE FROM arrow_slides WHERE slides_id='$id'";
        $this->_result=$this->_dbHandle->exec($query);
        if($this->_result===FALSE)
        {
            $this->watchdog->logError("Unable to remove the slide from the database",201,__CLASS__);
            return false;
        }
        return true;
    }

    /**
     * Get the slides from the database
     *
     * @returns Array|false
     */
    function getSlides()
    {
        $query="SELECT * FROM arrow_slides";
        $this->_result=$this->_dbHandle->query($query);
        if($this->_result==FALSE)
        {
            $this->watchdog->logError("Unable to get slides from the database",200,__CLASS__);
            return false;
        }
        $data=array();
        foreach($this->_result as $results)
        {
            $data[]=$results;
        }
        return $data;
    }

    /**
     * Get the slides from the database with specified ID
     *
     * @param Int $id The ID of the slide
     * @returns Array|false
     */
    function getSlide($id)
    {
        $query="SELECT * FROM arrow_slides WHERE slides_id='$id'";
        $this->_result=$this->_dbHandle->query($query);
        if($this->_result==FALSE)
        {
            $this->watchdog->logError("Unable to get slide from the database",200,__CLASS__);
            return false;
        }
        $data=array();
        foreach($this->_result as $results)
        {
            $data=$results;
        }
        return $data;
    }

    //Programs page

    /**
     * Create a new page
     *
     * @param String $title Title of the page
     * @param String $description Description of the page
     * @param String $category Category to which the page belongs
     * @param String $image The link to the image
     * @param DateTime $date The date of creation of page
     * @param Int $status The publishing status of the page
     * @param String $multiimage Comma seperated multiple image paths
     * @return bool
     */
    function newPage($title,$description,$category,$image,$date,$status,$multiimage)
    {
        $program=new Page();
        if($program->newPage($title,$description,$category,$image,$date,$status,$multiimage)==false)
        {
            return false;
        }
        return true;
    }

    /**
     * Get the pages
     *
     * @return Array|false
     */
    function getPages()
    {
        $program=new Page();
        return $program->getPages();
    }

    /**
     * Get the program pages
     *
     * @return Array|false
     */
    function getPrograms()
    {
        $program=new Page();
        return $program->getPagesByCategory("program");
    }
}