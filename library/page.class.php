<?php
/**
 * Provides functionality for pages for the arrow
 *
 * @description In arrow we treat everything as a new page
 *              be it a blog post or news or a service page
 *              it is represented as a page sorted and grouped by
 *              the category it was created in.
 *
 * @author Saurabh Badhwar
 */

    /**
     * Class Page
     *
     * Provides the functionality of creating pages
     */
    class Page extends Model
    {
        /**
         * @access protected
         * @var Int $page_id The ID of the page
         */
        protected $page_id;
        /**
         * @access protected
         * @var String $page_title The title of the page
         */
        protected $page_title;
        /**
         * @access protected
         * @var String $page_description The description of the page
         */
        protected $page_description;
        /**
         * @access protected
         * @var String $page_category The category of the page
         */
        protected $page_category;
        /**
         * @access protected
         * @var Media $page_image The featured image for the page
         */
        protected $page_image;
        /**
         * @access protected
         * @var DateTime $page_date The date of creation of the page
         */
        protected $page_date;
        /**
         * @access protected
         * @var string $page_status The publishing status of the page
         */
        protected $page_status;

        /**
         * Inserts the new page into the database
         *
         * @param String $title
         * @param String $description
         * @param String $category
         * @param String $image
         * @param DateTime $date
         * @param String $status
         * @param String $multiimage
         * @returns bool
         */
        public function newPage($title,$description,$category,$image,$date,$status,$multiimage)
        {
            $this->page_title=$title;
            $this->page_description=$description;
            $this->page_category=$category;
            $this->page_image=$image;
            $this->page_date=$date;
            $this->page_status=$status;

            $query="INSERT INTO arrow_pages(pages_title,pages_description,pages_category,pages_image,pages_date,pages_status,pages_multiple_image) VALUES('$this->page_title','$this->page_description','$this->page_category','$this->page_image','$this->page_date','$this->page_status','$multiimage')";
            $this->_result=$this->_dbHandle->exec($query);
            if($this->_result===FALSE)
            {
                $this->watchdog->logError("Error storing the page into database",400,__CLASS__);
                return false;
            }
            return true;
        }

        /**
         * Removes the specified page from the database
         * @param Int $id The page id to be removed
         * @returns bool
         */
        public function removePage($id)
        {
            $this->page_id=$id;
            $query="DELETE FROM arrow_pages WHERE pages_id='$this->page_id'";
            $this->_result=$this->_dbHandle->exec($query);
            if($this->_result===FALSE)
            {
                $this->watchdog->logError("Unable to remove the page from the database",401,__CLASS__);
                return false;
            }
            return true;
        }

        /**
         * Returns the list of pages
         *
         * @returns Array|false
         */
        public function getPages()
        {
            $query="SELECT * FROM arrow_pages";
            $this->_result=$this->_dbHandle->query($query);
            if($this->_result===FALSE)
            {
                $this->watchdog->logError("Error retrieving pages",402,__CLASS__);
                return false;
            }
            $data=array();
            foreach($this->_result as $result)
            {
                $data[]=$result;
            }

            return $data;
        }

        /**
         * Get Pages by category
         *
         * @param String $category The category of the pages to be retrieved
         *
         * @returns Array|false
         */
        public function getPagesByCategory($category)
        {
            $query="SELECT * FROM arrow_pages WHERE pages_category='$category'";
            $this->_result=$this->_dbHandle->query($query);
            if($this->_result===FALSE)
            {
                $this->watchdog->logError("Error retrieving pages",402,__CLASS__);
                return false;
            }
            $data=array();
            foreach($this->_result as $result)
            {
                $data[]=$result;
            }

            return $data;
        }
    }