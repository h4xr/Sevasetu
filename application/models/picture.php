<?php
/**
 * Provides database abstraction for image
 * upload and retrieval.
 *
 * @author Saurabh Badhwar
 */

    /**
     * Class Picture
     * Provides methods to support the image data
     * abstraction from the database
     */
    class Picture extends Model
    {
        /**
         * @var Int $image_id The ID of the image as in the database
         */
        private $picture_id;
        /**
         * @var String $image_path The path where the image has been stored
         */
        private $picture_path;
        /**
         * @var String $image_caption The description of the image
         */
        private $picture_caption;
        /**
         * @var Int $image_uploader The ID of the person who uploaded the image
         */
        private $picture_uploader;
        /**
         * @var DateTime $image_date The date when the image was uploaded
         */
        private $picture_date;

        //Support functions
        /**
         * Returns the image by its ID
         *
         * @param Int $id The ID of the image to be retrieved
         *
         * @return Array | false
         */
        function getPictureById($id)
        {
            $data=null;
            $this->picture_id=$id;
            $query="SELECT * FROM pictures WHERE pictures_id='$this->picture_id'";
            $this->_result=$this->_dbHandle->query($query);
            if($this->_result===FALSE)
            {
                $this->watchdog->logError("Unable to retrieve image by id",200,__CLASS__);
                return false;
            }
            else
            {
                foreach($this->_result as $results)
                {
                    $data=$results;
                }
                return $data;
            }
        }

        /**
         * Retrieves the images from the database
         *
         * @param Int $limit No. of images to be retrieved(Optional)
         *
         * @returns Array | false
         */
        function getPictures($limit=0)
        {
            $data=array();
            $query="SELECT * FROM pictures";
            if($limit>0)
            {
                $query.=" LIMIT $limit";
            }
            $this->_result=$this->_dbHandle->query($query);
            if($this->_result===FALSE)
            {
                $this->watchdog->logError("Unable to retrieve images from the database",200,__CLASS__);
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

        //Core functions
        /**
         * Insert new image in database
         * @param $path
         * @param $caption
         * @param $uploader
         * @param $date
         * @returns bool
         */
        function insertPicture($path,$caption,$uploader,$date)
        {
            $this->picture_path=$path;
            $this->picture_caption=$caption;
            $this->picture_uploader=$uploader;
            $this->picture_date=$date;
            $query="INSERT INTO pictures(pictures_path,pictures_caption,pictures_uploader,pictures_date) VALUES('$this->picture_path','$this->picture_caption','$this->picture_uploader','$this->picture_date')";
            $this->_result=$this->_dbHandle->exec($query);
            if($this->_result===FALSE)
            {
                $this->watchdog->logError("Unable to insert a new image in the database",201,__CLASS__);
                return false;
            }
            else
            {
                return true;
            }
        }

        /**
         * Removes an image from the database
         * @param Int $id The image id of the image to be removed from the database
         * @returns bool
         */
        function removePicture($id)
        {
            $this->picture_id=$id;
            $query="DELETE FROM pictures WHERE pictures_id='$this->picture_id'";
            $this->_result=$this->_dbHandle->exec($query);
            if($this->_result===FALSE)
            {
                $this->watchdog->logError("Unable  to remove the image from the database",201,__CLASS__);
                return false;
            }
            return true;
        }
    }