<?php
/**
 * Provides functionality for managing the blog posts
 * in the framework
 *
 * @author Saurabh Badhwar
 */
    include_once(ROOT.DS.'library'.DS.'security.php');
    include_once(ROOT.DS.'library'.DS.'session.php');

    /**
     * Class BlogsController
     * Provides methods to manipulate the blogs
     *
     */
    class BlogsController extends Controller
    {

        /**
         * New blog post
         */
        function newpost()
        {
            $this->set("title","New Blog post");
        }

        /**
         * Save the new blog post
         */
        function save()
        {
            initiateSession();
            if(!isset($_SESSION['user_id']))
            {
                $this->set("message","User is not logged In");
                return;
            }
            $name=null;
            $content=null;
            $author=null;
            $date=null;
            $pubdate=null;
            $category=null;
            $status="publish";
            if(!isset($_POST['post_name']))
            {
                $this->set("message","Post name cannot be empty");
            }
            else if(!isset($_POST['post_content']))
            {
                $this->set("message","Post content cannot be empty");
            }
            else if(!isset($_POST['post_category']))
            {
                $this->set("message","Post category must be given");
            }
            else
            {
                $name=sqlSafe($_POST['post_name']);
                $content=sqlSafe($_POST['post_content']);
                $author=sqlSafe($_SESSION['user_username']);
                $date=date("Y-m-d H:i:s");
                $status=$_POST['post_status'];
                if($status=="publish")
                    $pubdate=$date;
                else
                    $pubdate=null;
                $category=sqlSafe($_POST['post_category']);
            }
            if($this->Blog->insertPost($name,$content,$date,$pubdate,$author,$category,$status)==-1)
            {
                $this->set("message","There was an error storing the post");
            }
            else
            {
                $this->set("message","Post stored successfully");
            }
        }

        /**
         * Show posts
         */
        function view()
        {
            $this->set("title","Blog");
            $data=$this->Blog->getPosts();
            if($data==false)
            {
                $this->set("message","No blog posts to display");
                return;
            }
            else
            {
                $this->set("data",$data);
            }
        }

        /**
         * Show Individual post with given ID
         *
         * @param Int $id The ID of the post to be viewed
         */
        function viewpost($id)
        {
            $this->set("title","Blog");
            $data=$this->Blog->getPostByID(sqlSafe($id));
            if($data==false)
            {
                $this->set("message","No blog posts to display");
                return;
            }
            else
            {
                $this->set("data",$data);
            }
        }

        /**
         * Remove the post from the database
         *
         * @param Int $id The ID of the post to be removed
         */
        function remove($id)
        {
            $this->set("title","Blog");
            initiateSession();
            if(!isset($_SESSION['user_id']))
            {
                $this->set("message","No permission to remove post");
            }
            else
            {
                if($this->Blog->removePost(sqlSafe($id))==false)
                {
                    $this->set("message","Unable to remove post");
                }
                else
                {
                    $this->set("message","Post removed");
                }
            }
        }
    }
