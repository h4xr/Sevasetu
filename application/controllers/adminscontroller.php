<?php
/**
 * provides routing for the admin panel
 */

include_once(ROOT.DS.'library'.DS.'security.php');
include_once(ROOT.DS.'library'.DS.'session.php');

class AdminsController extends Controller
{
    /**
     * Index Page
     */
    function index($mode="login")
    {
        initiateSession();
        $this->set("title","Sevasetu | Admin");
        $this->set("mode",$mode);
        if(isset($_SESSION['admin_hash']))
        {
            header("LOCATION: /admins/dashboard");
        }
    }



    /**
     * Register Admin
     */
    function register()
    {
        initiateSession();
        $this->set("title","Sevasetu | New Admin");
        if(isset($_SESSION['admin_hash']))
        {
            header("LOCATION: /admins/dashboard");
        }
        $name=sqlSafe($_POST['name']);
        $username=sqlSafe($_POST['username']);
        $password=sqlSafe($_POST['password']);
        $password2=sqlSafe($_POST['password2']);
        $salt=generateSalt();
        $email=sqlSafe($_POST['email']);
        if($password===$password2)
        {
            $password=generateHash($password.$salt);
        }
        else
        {
            $this->set("message","Password doesn't match");
            return false;
        }
        if($this->Admin->insertAdmin($name,$username,$email,$salt,$password)==true)
        {
            $this->set("message","Administrator Registered.");
        }
        else
        {
            $this->set("message","Unable to register admin");
        }
    }

    /**
     * Login processor for admin panel
     */
    function login()
    {
        $this->set("title","Sevasetu | Login Processor");
        initiateSession();
        $username=sqlSafe($_POST['username']);
        $password=sqlSafe($_POST['password']);
        $adminData=$this->Admin->getAdminByUsername($username);
        if($adminData==false)
        {
            $this->set("message","Database error");
            return;
        }
        if(generateHash($password.$adminData['admins_salt'])==$adminData['admins_password'])
        {
            setSessionData("admin_hash",md5($adminData['admins_salt']));
            $this->set("message","Login Successful. You will be redirected in a moment... If not then click here");
        }
        else
        {
            $this->set("message","Username/Password Incorrect");
        }
    }

    /**
     * Presents the admin dashboard
     */
    function dashboard()
    {
        initiateSession();
        $this->set("title","Dashboard");
        if(!isset($_SESSION['admin_hash']))
        {
            header("LOCATION: /admins/index");
        }
    }

    /**
     * Featured content changes
     */
    function slider()
    {
        initiateSession();
        if(!isset($_SESSION['admin_hash']))
        {
            header("LOCATION: /admins/index");
        }
        $this->set("title","Arrow | Featured Content Slider");
        $data=$this->Admin->getSlides();
        if($data==false)
        {
            $this->set("message","No slides to display. Add a new one maybe.");
        }
        else
        {
            $this->set("slides",$data);
        }
    }

    /**
     * View slide
     *
     * @param Int $id The ID of the slide
     */
    function viewslide($id)
    {
        initiateSession();
        if(!isset($_SESSION['admin_hash']))
        {
            header("LOCATION: /admins/index");
        }
        $this->set("title","Arrow | Featured Slide");
        $id=sqlSafe($id);
        $slide=$this->Admin->getSlide($id);
        if($slide==false)
        {
            $this->set("message","No slide to display");
        }
        else
        {
            $this->set("slide",$slide);
        }
    }

    /**
     * Insert new Slide into database
     */
    function newslide()
    {
        initiateSession();
        if(!isset($_SESSION['admin_hash']))
        {
            header("LOCATION: /admins/index");
        }
        $this->set("title","Arrow | Featured Slide");
        if(isset($_POST['post_slide']))
        {
            if(!isset($_POST['title']) || !isset($_FILES['featured_image']))
            {
                $this->set("message","Please complete all the required fields");
                return;
            }
            else
            {
                $title=sqlSafe($_POST['title']);
                if(isset($_POST['description']))
                {
                    $description=sqlSafe($_POST['description']);
                }
                else
                {
                    $description=null;
                }
                $image=new Media($_FILES['featured_image']);
                if($image->validate()==false)
                {
                    $this->set("message","Media File format not supported");
                }
                else
                {
                    if($image->setUploadPath(ROOT.DS.'public'.DS.'uploads'.DS.'slides')==false)
                    {
                        $this->set("message","path error");
                        return;
                    }
                    if($image->moveUploadedMedia()==false)
                    {
                        $this->set("message","Unable to upload media");
                        return;
                    }
                    else
                    {
                        $imageData=$image->getUploadData();
                        $imagePath=$imageData['upload_path'];
                    }
                }
                if($this->Admin->insertSlide($title,$description,$imagePath)==false)
                {
                    $this->set("message","Unable to insert slide");
                }
                else
                {
                    $this->set("message","Upload Successful. <a href='/admins/slider'>View Slides</a>");
                }
            }
        }
    }

    /**
     * Remove Slide
     *
     * @param Int $id The ID of the slide to be removed
     */
    function removeslide($id)
    {
        initiateSession();
        if(!isset($_SESSION['admin_hash']))
        {
            header("LOCATION: /admins/index");
        }
        $this->set("title","Remove Slide | Sevasetu");
        $id=sqlSafe($id);
        if($this->Admin->removeSlide($id)==false)
        {
            $this->set("message","Unable to remove slide");
            return;
        }
        $this->set("message","Slide Deleted. <a href='/admins/slider/'>Go Back</a>");

    }

    /**
     * Pages display
     */
    function pages()
    {
        initiateSession();
        if(!isset($_SESSION['admin_hash']))
        {
            header("LOCATION: /admins/index");
        }
        $this->set("title","Arrow | Pages");
        $data=$this->Admin->getPages();
        if($data==false)
        {
            $this->set("message","No pages to display. Add a new one maybe.");
        }
        else
        {
            $this->set("pages",$data);
        }
    }

    /**
     * Create new page
     */
    function newpage()
    {
        initiateSession();
        if(!isset($_SESSION['admin_hash']))
        {
            header("LOCATION: /admins/index");
        }
        $this->set("title","New Page");
        if(isset($_POST['post_page']))
        {
            if(!isset($_POST['post_title']))
            {
                $this->set("message","Title is required");
                return;
            }
            else if(!isset($_POST['post_category']))
            {
                $this->set("message","Page category is required");
            }
            else if(!isset($_FILES['featured_image']) && !isset($_FILES['multiple_image']))
            {
                $this->set("message","A feature image and supporting images must be uploaded");
            }
            else
            {
                $title=sqlSafe($_POST['post_title']);
                if(isset($_POST['post_description']))
                {
                    $description=sqlSafe($_POST['post_description']);
                }
                else
                {
                    $description=null;
                }
                $category=sqlSafe($_POST['post_category']);
                $date=date("Y-m-d H:i:s");
                $status="published";
                $image=new Media($_FILES['featured_image']);
                if($image->validate()==false)
                {
                    $this->set("message","Media File format not supported");
                }
                else
                {
                    if($image->setUploadPath(ROOT.DS.'public'.DS.'uploads'.DS.'pages')==false)
                    {
                        $this->set("message","path error");
                        return;
                    }
                    if($image->moveUploadedMedia()==false)
                    {
                        $this->set("message","Unable to upload media");
                        return;
                    }
                    else
                    {
                        $imageData=$image->getUploadData();
                        $imagePath=$imageData['upload_path'];
                    }
                    $moreImages=$this->uploadMultipleImage($_FILES['multiple_image']);
                    //echo $moreImages;
                }

                if($this->Admin->newPage($title,$description,$category,$imagePath,$date,$status,$moreImages)==false)
                {
                    $this->set("message","Unable to add new page");
                }
                else
                {
                    $this->set("message","New Page added successfully");
                }
            }
        }

    }

    /**
     * Upload multiple images
     */
    function uploadMultipleImage($imageArray)
    {
        $file_ary = array();
        $file_count = count($imageArray['name']);
        $file_keys = array_keys($imageArray);

        for ($i=0; $i<$file_count; $i++) {
            foreach ($file_keys as $key) {
                $file_ary[$i][$key] = $imageArray[$key][$i];
            }
        }
        $paths=array();
        foreach($file_ary as $tmpname)
        {
            $image=new Media($tmpname);
            if($image->validate()==false)
            {
                $this->set("message","Media File format not supported");
            }
            else
            {
                if($image->setUploadPath(ROOT.DS.'public'.DS.'uploads'.DS.'pages')==false)
                {
                    $this->set("message","path error");
                    return;
                }
                if($image->moveUploadedMedia()==false)
                {
                    $this->set("message","Unable to upload media");
                    return;
                }
                else
                {
                    $imageData=$image->getUploadData();
                    $paths[]=$imageData['upload_path'];
                }
            }
        }
        return implode(",",$paths);
    }

    /**
     * Logout processor for admin panel
     */
    function logout()
    {
        initiateSession();
        $this->set("title","Admin Logout");
        if(!isset($_SESSION['admin_hash']))
        {
            header("LOCATION: /admins/index");
        }
        closeSession();
        header("LOCATION: /admins/index");
    }


}