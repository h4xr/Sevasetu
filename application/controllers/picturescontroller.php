<?php
/**
 * Provides the framework with image upload interface
 *
 * @author Saurabh Badhwar
 */
    include_once(ROOT.DS.'library'.DS.'security.php');
    include_once(ROOT.DS.'library'.DS.'session.php');

    /**
     * Class PicturesController
     * Provides functionality to upload, view,delete images
     */
    class PicturesController extends Controller
    {
        /**
         * Upload a new image
         */
        function upload()
        {
            $this->set("title","Image Upload");
        }

        /**
         * Store the uploaded image
         */
        function store()
        {
            initiateSession();
            $this->set("title","Image Upload");
            if(!isset($_SESSION['user_id']))
            {
                $this->set("message","User is not logged in");
                return;
            }
            $img=new Image($_FILES['content_image']);
            if($img->validate()==false)
            {
                $this->set("message","Not an valid image file");
            }
            else
            {
                $img->setUploadPath(ROOT.DS.'public'.DS.'uploads'.DS.'users');
                if(isset($_POST['content_caption']))
                {
                    $caption=sqlSafe($_POST['content_caption']);
                }
                else
                {
                    $caption=null;
                }
                $author=sqlSafe($_SESSION['user_username']);
                $date=date("Y-m-d H:i:s");
                $img->moveUploadedImage();
                $path=$img->getUploadLocation();
                if($this->Picture->insertPicture($path,$caption,$author,$date))
                {
                    $this->set("message","Upload successful");
                }
                else
                {
                    $this->set("message","Upload failed");
                }
            }
        }

        /**
         * View all the images
         */
        function view()
        {
            $this->set("title","View images");
            $data=$this->Picture->getPictures(10);
            if($data==false)
            {
                $this->set("message","Error getting images from database.");
            }
            else
            {
                $this->set("data",$data);
            }
        }

        /**
         * View by ID
         *
         * @param Int $id The ID of the image to be viewed
         */
        function show($id)
        {
            $this->set("title","Show Images");
            $id=sqlSafe($id);
            $data=$this->Picture->getPictureById($id);
            if($data==false)
            {
                $this->set("message","Image does not exist");
            }
            else
            {
                $this->set("data",$data);
            }
        }

        /**
         * Remove Image
         *
         * @param Int $id The ID of the image to be removed
         */
        function remove($id)
        {
            initiateSession();
            if(!isset($_SESSION['user_id']))
            {
                $this->set("message","User not logged in");
            }
            else
            {
                $id=sqlSafe($id);
                if($this->Picture->removePicture($id)==false)
                {
                    $this->set("message","Unable to remove picture");
                }
                else
                {
                    $this->set("message","Picture removed");
                }
            }
        }
    }