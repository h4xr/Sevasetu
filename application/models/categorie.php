<?php
/**
 * Database abstraction layer for categories
 *
 * @author Saurabh Badhwar
 */

    /**
     * Class Categorie
     * Provides the abstraction layer for categories
     */
    class Categorie extends Model
    {
        /**
         * @access private
         * @var Int $category_id The ID of the category
         */
        private $category_id;
        /**
         * @access private
         * @var Int $category_name The ID of the category
         */
        private $category_name;

        /**
         * Adds a new category to the database
         * @param String $name The name of category to be added
         *
         * @returns Int
         */
        function addCategory($name)
        {
            $this->category_name=$name;
            $query="INSERT INTO categories(category_name) VALUES('$this->category_name')";
            $this->_result=$this->_dbHandle->query($query);
            if($this->_result===FALSE)
            {
                $this->watchdog->logError("Unable to insert a new category into the database",201,__CLASS__);
                return -1;
            }
            return $this->_result;
        }

        /**
         * Returns all the categories from the table
         *
         * @return Array|false
         */
        function getCategories()
        {
            $query="SELECT * FROM categories";
            $data=array();
            $this->_result=$this->_dbHandle->query($query);
            if($this->_result===FALSE)
            {
                $this->watchdog->logError("Unable to get the list of categories from the database",200,__CLASS__);
                return false;
            }
            else
            {
                foreach($this->_result as $result)
                {
                    $data[]=$result['category_name'];
                }
                return $data;
            }
        }

        /**
         * Removes the category from the database
         * @param String $name The name of the category to be removed
         *
         * @returns Int
         */
        function removeCategory($name)
        {
            $this->category_name=$name;
            $query="DELETE FROM categories WHERE category_name='$this->category_name'";
            $this->_result=$this->_dbHandle->query($query);
            if($this->_result===FALSE)
            {
                $this->watchdog->logError("Unable to delete the category from database",202,__CLASS__);
                return -1;
            }
            else
            {
                return $this->_result;
            }
        }
    }