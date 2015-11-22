<?php
    /**
     * Provides functionality for Video upload and management
     * for the framework. Provides functionality like validation
     * of video, regeneration, upload support and renaming.
     *
     * @author Saurabh Badhwar
     */

    /**
     * Class Video
     * Provides the functionality for Image management
     */
    class Video
    {
        /**
         * @access private
         * @var Array $mimeType The valid MIME types of images to be accepted
         */
        private $mimeType=array(
            'application/x-troff-msvideo'=>"avi",
            'video/avi'=>"avi",
            'video/msvideo'=>"avi",
            'video/x-msvideo'=>"avi",
            'video/mp4'=>"mp4",
            'video/3gpp'=>"3gp",
            'video/quicktime'=>"mov"
        );

        /**
         * @access private
         * @var Array $validExtension The valid extension for the images
         */
        private $validExtension=array('avi','mp4','3gp','mov');

        /**
         * @access protected
         * @var Mixed $video The uploaded video array
         */
        protected $video;

        /**
         * @access protected
         * @var Int $width The width of the video
         */
        protected $width;

        /**
         * @access protected
         * @var Int $height The height of the video
         */
        protected $height;

        /**
         * @access protected
         * @var String $videoMime The mime type of the video
         */
        protected $videoMime;

        /**
         * @access protected
         * @var String $uploadPath The path where the video is to be uploaded
         */
        protected $uploadPath;

        /**
         * @access protected
         * @var String $filePath The path where file has been saved
         */
        protected $filePath;

        /**
         * @access protected
         * @var Watchdog $watchdog The watchdog object for error management
         */
        protected $watchdog;

        /**
         * @access private
         * @var Bool $error Holds boolean to denote if there was some error or not
         */
        private $error;

        /**
         * Constructor for the class
         * Sets the image array with the contents of uploaded file
         *
         * @param Array $file The uploaded file
         */
        function __construct($file)
        {
            $this->image=$file;
            $this->error=0;
            $this->watchdog=new Watchdog(1); //enable watchdog to perform backtrace
            $this->watchdog->startBacktrace("Image"); //start the backtrace

        }

        /**
         * Validate the Image to check if it is really an image or not
         *
         * @returns bool
         */
        function validate()
        {
            $this->watchdog->logBacktraceMessage("Started image validation");
            $extension=end(explode('.',$this->image['name']));
            $this->watchdog->logBacktraceMessage("Got the image extension $extension");
            $imagedata=getimagesize($this->image['tmp_name']);
            $this->watchdog->logBacktraceMessage("Called getimagesize");
            $this->width=$imagedata[0];
            $this->height=$imagedata[1];
            $this->imageMime=$imagedata['mime'];
            if(in_array(strtolower($extension),$this->validExtension)==TRUE && array_key_exists(strtolower($this->imageMime),$this->mimeType)==TRUE
                && $this->width!=0 && $this->height!=0)
            {
                $this->watchdog->logBacktraceMessage("Image validated successfully");
                return true;
            }
            else
            {
                $this->error=1;
                $this->watchdog->logBacktraceMessage("Image validation failed/Format not supported");
                return false;
            }
        }

        /**
         * Sets the upload path
         *
         * @param String $path The path where to upload the file
         *
         * @returns bool
         */
        function setUploadPath($path)
        {
            if(file_exists($path)==TRUE)
            {
                $this->uploadPath=$path;
                return true;
            }
            return false;
        }

        /**
         * Recreate the uploaded image
         *
         * @returns bool
         */
        function recreateImage()
        {
            $this->watchdog->logBacktraceMessage("Recreating image");
            $thumb=imagecreatetruecolor(IMAGE_WIDTH,IMAGE_HEIGHT);
            $this->watchdog->logBacktraceMessage("Canvas created");
            if($this->mimeType[strtolower($this->imageMime)]=="jpeg")
            {
                $src=imagecreatefromjpeg($this->image['tmp_name']);
            }
            else if($this->mimeType[strtolower($this->imageMime)]=="png")
            {
                $src=imagecreatefrompng($this->image['tmp_name']);
            }
            else if($this->mimeType[strtolower($this->imageMime)]=="gif")
            {
                $src=imagecreatefromgif($this->image['tmp_name']);
            }
            else
            {

                $this->watchdog->logBacktraceMessage("Incompatible format received for image recreation in module recreateImage");
                return false;
            }

            if(imagecopyresized($thumb,$src,0,0,0,0,IMAGE_WIDTH,IMAGE_HEIGHT,$this->width,$this->height)==TRUE)
            {
                $this->watchdog->logBacktraceMessage("Image recreated from specified format");
                $this->filePath=$this->uploadPath.DS.md5(date("Y-m-d H:i:s"))."_".str_replace(' ','',$this->image['name']).'.jpg';
                if(imagejpeg($thumb,$this->filePath)==TRUE)
                {
                    $this->watchdog->logBacktraceMessage("Image created");
                    return true;
                }
                else
                {
                    $this->watchdog->logBacktraceMessage("Image saving failed in module recreateImage");
                    $this->error=1;
                    return false;
                }
            }
            else
            {
                $this->watchdog->logBacktraceMessage("Unable to recreate image in module recreateImage");
                $this->error=1;
                return false;
            }
        }

        /**
         * Moves the uploaded file to the storage location
         *
         * @returns bool
         */
        function moveUploadedImage()
        {
            $this->watchdog->logBacktraceMessage("Call to module moveUploadedImage");
            $this->filePath=$this->uploadPath.DS.md5(date("Y-m-d H:i:s"))."_".str_replace(' ','',$this->image['name']);
            if(move_uploaded_file($this->image['tmp_name'],$this->filePath)==TRUE)
            {
                $this->watchdog->logBacktraceMessage("Image moved successfully");
                return true;
            }
            else
            {
                $this->error=1;
                $this->watchdog->logBacktraceMessage("Unable to move image in module moveUploadedImage");
                return false;
            }
        }

        /**
         * Returns the path to the upload directory
         *
         * @returns String
         */
        function getUploadLocation()
        {
            return $this->filePath;
        }

        /**
         * Destructor for the class
         */
        function __destruct()
        {
            if($this->error==0)
            {
                $this->watchdog->stopBacktrace(0);
            }
            else
            {
                $this->watchdog->stopBacktrace(1);
            }
            $this->image=null;
        }
    }