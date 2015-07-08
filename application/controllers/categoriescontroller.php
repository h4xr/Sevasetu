<?php
/**
 * Manages the blog categories
 *
 * @author Saurabh Badhwar
 */
    include_once(ROOT.DS.'library'.DS.'security.php');
    include_once(ROOT.DS.'library'.DS.'session.php');
    /**
     * Class CategoriesController
     * Provides functionality to update blog post categories
     */
    class CategoriesController extends Controller
    {
        /**
         * Add new category
         */
        function add()
        {
            $this->set("title","Add category");
            initiateSession();
            if(!isset($_SESSION['user_id']))
            {
                $this->set("message","User not logged in");
            }
        }

        /**
         * Process addition of category
         */
        function addcategory()
        {
            $this->set("title","New category");
            initiateSession();
            $this->watchdog->logError("Category error: ".print_r($_GET,true),500,__CLASS__);
            $category=sqlSafe($_POST['category_name']);
            if(!isset($_SESSION['user_id']))
            {
                $this->set("message","User not logged in");
            }
            else
            {
                if($this->Categorie->addCategory($category)==false)
                {
                    $this->set("message","Unable to add new category.");
                }
                else
                {
                    $this->set("message","New category inserted");
                }
            }
        }

        /**
         * Get all the categories
         */
        function getcategories()
        {
            initiateSession();
            if(!isset($_SESSION['user_id']))
            {
                $this->set("message","User is not logged in");
            }
            else
            {
                $data=$this->Categorie->getCategories();
                if($data==false)
                {
                    $this->set("message","Unable to retrieve categories");
                }
                else
                {
                    $this->set("categories",$data);
                    $this->set("message","Categories retrieved successfully");
                }
            }
        }

        /**
         * Remove the category
         *
         * @param String $name The name of the category to be removed
         */
        function remove($name)
        {
            $this->set("title","Remove category");
            $name=sqlSafe($name);
            if($this->Categorie->removeCategory($name)==false)
            {
                $this->set("message","Unable to remove category");
            }
            else
            {
                $this->set("message","Category removed");
            }
        }
    }