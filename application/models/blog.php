<?php
/**
 * Blog controller
 * Provides the functionality for controlling blog posts
 * in the framework. Functions include posting of new posts
 * or storing them as drafts.
 *
 * @author Saurabh Badhwar
 */

    /**
     * Class Blog
     * Provides methods for managing blog posts
     */
    class Blog extends Model
    {
        /**
         * @var Int $blog_post_id The post id
         */
        private $blog_post_id;
        /**
         * @var String $blog_post_name The post name
         */
        private $blog_post_name;
        /**
         * @var String $blog_post_content The contents of the blog post
         */
        private $blog_post_content;
        /**
         * @var DateTime $blog_post_date The post date
         */
        private $blog_post_date;
        /**
         * @var DateTime $blog_post_pubdate The publishing date of the blog post
         */
        private $blog_post_pubdate;
        /**
         * @var String $blog_post_author The author of the blog post
         */
        private $blog_post_author;
        /**
         * @var String $blog_post_category The category in which the post has been published
         */
        private $blog_post_category;
        /**
         * @var String $blog_post_status The publishing status of the blog post
         */
        private $blog_post_status;

        //Support functions

        /**
         * Returns the posts with the given name
         *
         * @param String $name The name with which the post should be searched
         *
         * @returns Array|false
         */
        function getPostByName($name)
        {
            $data=array();
            $query="SELECT * FROM blogs WHERE blogs_post_name='$name'";
            $this->_result=$this->_dbHandle->query($query);
            if($this->_result===FALSE)
            {
                $this->watchdog->logError("Unable to get posts by name",200,__CLASS__);
                return false;
            }
            else
            {
                foreach($this->_result as $results)
                {
                    $data[]=$results;
                }
                return $data;
            }
        }

        /**
         * Returns the posts with the given ID
         *
         * @param String $id The ID with which the post should be searched
         *
         * @returns Array|false
         */
        function getPostByID($id)
        {
            $data=array();
            $query="SELECT * FROM blogs WHERE blogs_post_id='$id'";
            $this->_result=$this->_dbHandle->query($query);
            if($this->_result===FALSE)
            {
                $this->watchdog->logError("Unable to get posts by ID",200,__CLASS__);
                return false;
            }
            else
            {
                foreach($this->_result as $results)
                {
                    $data[]=$results;
                }
                return $data;
            }
        }

        /**
         * Returns the posts with the given author name
         *
         * @param String $name The author name with which the post should be searched
         *
         * @returns Array|false
         */
        function getPostByAuthor($name)
        {
            $data=array();
            $query="SELECT * FROM blogs WHERE blogs_post_author='$name'";
            $this->_result=$this->_dbHandle->query($query);
            if($this->_result===FALSE)
            {
                $this->watchdog->logError("Unable to get posts by name",200,__CLASS__);
                return false;
            }
            else
            {
                foreach($this->_result as $results)
                {
                    $data[]=$results;
                }
                return $data;
            }
        }

        /**
         * Returns the posts with the given post status
         *
         * @param String $status The status with which the post should be searched
         *
         * @returns Array|false
         */
        function getPostByStatus($status)
        {
            $data=array();
            $query="SELECT * FROM blogs WHERE blogs_post_status='$status'";
            $this->_result=$this->_dbHandle->query($query);
            if($this->_result===FALSE)
            {
                $this->watchdog->logError("Unable to get posts by post status",200,__CLASS__);
                return false;
            }
            else
            {
                foreach($this->_result as $results)
                {
                    $data[]=$results;
                }
                return $data;
            }
        }

        /**
         * Returns the posts with the given category name
         *
         * @param String $name The category name with which the post should be searched
         *
         * @returns Array|false
         */
        function getPostByCategory($name)
        {
            $data=array();
            $query="SELECT * FROM blogs WHERE blogs_post_category='$name'";
            $this->_result=$this->_dbHandle->query($query);
            if($this->_result===FALSE)
            {
                $this->watchdog->logError("Unable to get posts by category name",200,__CLASS__);
                return false;
            }
            else
            {
                foreach($this->_result as $results)
                {
                    $data[]=$results;
                }
                return $data;
            }
        }

        /**
         * Gets all the posts from the database
         *
         * @param Int $limit The no. of posts to get in 1 query (optional)
         *
         * @returns Array|false
         */
        function getPosts($limit=0)
        {
            $query="SELECT * FROM blogs";
            $data=array();
            if($limit>0)
            {
                $query.=" LIMIT $limit";
            }
            $this->_result=$this->_dbHandle->query($query);
            if($this->_result===FALSE)
            {
                return false;
            }
            foreach($this->_result as $results)
            {
                $data[]=$results;
            }
            return $data;
        }

        /**
         * Updates the post publishing status
         *
         * @param Int $id The ID of the post
         * @param String $status The new status of the post
         *
         * @returns Int
         */
        function updatePostStatus($id,$status)
        {
            $query="UPDATE blogs SET blogs_post_status='$status' WHERE blogs_post_id='$id'";
            $this->_result=$this->_dbHandle->exec($query);
            if($this->_result===FALSE)
            {
                $this->watchdog->logError("Unable to update post status",201,__CLASS__);
                return false;
            }
            return true;
        }

        /**
         * Updates the post contents
         *
         * @param Int $id The ID of the post
         * @param String $contents The updated contents of the post
         *
         * @returns Int
         */
        function updatePostContent($id,$contents)
        {
            $query="UPDATE blogs SET blogs_post_content='$contents' WHERE blogs_post_id='$id'";
            $this->_result=$this->_dbHandle->exec($query);
            if($this->_result===FALSE)
            {
                $this->watchdog->logError("Unable to update post contents",201,__CLASS__);
                return false;
            }
            return true;
        }

        /**
         * Updates the post publishing date
         *
         * @param Int $id The ID of the post
         * @param String $pubdate The publication date of the post
         *
         * @returns Int
         */
        function updatePubDate($id,$pubdate)
        {
            $query="UPDATE blogs SET blogs_post_pubdate='$pubdate' WHERE blogs_post_id='$id'";
            $this->_result=$this->_dbHandle->exec($query);
            if($this->_result===FALSE)
            {
                $this->watchdog->logError("Unable to update post publication date",201,__CLASS__);
                return false;
            }
            return true;
        }

        //Core Functions

        /**
         * Inserts a new post into the database
         *
         * @param String $name The name of the post
         * @param String $content The contents of the post
         * @param DateTime $date The date of the post
         * @param DateTime $pubdate The date when the post was published
         * @param String $author The author of the post
         * @param String $category The category in which the post was published
         * @param String $status The status of the post
         *
         * @returns Int
         */
        function insertPost($name,$content,$date,$pubdate,$author,$category,$status)
        {
            $this->blog_post_name=$name;
            $this->blog_post_content=$content;
            $this->blog_post_date=$date;
            $this->blog_post_pubdate=$pubdate;
            $this->blog_post_author=$author;
            $this->blog_post_category=$category;
            $this->blog_post_status=$status;

            //Create Query
            $query="INSERT INTO blogs(blogs_post_name,blogs_post_content,blogs_post_date,blogs_post_pubdate,blogs_post_author,blogs_post_category,blogs_post_status) VALUES('$this->blog_post_name','$this->blog_post_content','$this->blog_post_date','$this->blog_post_pubdate','$this->blog_post_author','$this->blog_post_category','$this->blog_post_status')";
            $this->_result=$this->_dbHandle->exec($query);
            if($this->_result===FALSE)
            {
                $this->watchdog->logError("Unable to insert a new post",201,__CLASS__);
                return -1;
            }
            return $this->_result;
        }

        /**
         * Remove the post from the database
         *
         * @param Int $id The ID of the post
         *
         * @returns bool
         */
        function removePost($id)
        {
            $query="DELETE FROM blogs WHERE blogs_post_id='$id'";
            $this->_result=$this->_dbHandle->exec($query);
            if($this->_result===FALSE)
            {
                return false;
            }
            return true;
        }

    }