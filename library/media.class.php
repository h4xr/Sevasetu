<?php
/**
 * Provides functionality for Media Management
 * for the arrow platform.
 *
 * @author Saurabh Badhwar
 */

    /**
     * Class Media
     * Provides functionality for media upload and management
     */
    class Media
    {
        /**
         * @access private
         * @var Array $mimeType The valid mime types for the media to be accepted
         */
        private $mimeType=array(
            'image/gif'=>"gif",
            'image/jpeg'=>"jpeg",
            'image/pjpeg'=>"jpeg",
            'image/png'=>"png",
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
         * @var Array $validExtensions The valid extensions of the file to be accepted
         */
        private $validExtensions=array(
            "gif","jpeg","jpg","png","avi","mp4","3gp","mov"
        );

        /**
         * @access protected
         * @var Mixed $media The media file uploaded by the user
         */
        protected $media;

        /**
         * @access protected
         * @var Mixed $mediaData The data associated with the media file
         */
        protected $mediaData;

        /**
         * @access protected
         * @var String $uploadPath The path where the file is to be uploaded
         */
        protected $uploadPath;

        /**
         * @access protected
         * @var String $filePath The path where the file has been saved
         */
        protected $filePath;

        /**
         * @access protected
         * @var Watchdog $watchdog The watchdog object for error control
         */
        protected $watchdog;

        /**
         * @access protected
         * @var bool $error Denotes if their was an error or not
         */
        protected $error;

        /**
         * Initialises the class with the uploaded media file
         *
         * @param Mixed $file The resource pointer to the uploaded file
         */
        public function __construct($file)
        {
            $this->media=$file;
            $this->error=false;
            $this->watchdog=new Watchdog(1);
            $this->watchdog->startBacktrace("Media Manager");
        }

        /**
         * Validates the uploaded file against the valid mime types and supported upload files
         *
         * @returns bool
         */
        function validate()
        {
            $this->watchdog->logBacktraceMessage("Starting media file validation");
            $extension=strtolower(end(explode('.',$this->media['name'])));
            $this->watchdog->logBacktraceMessage("Got the media file extension $extension");
            if(!in_array($extension,$this->validExtensions))
            {
                $this->error=true;
                $this->watchdog->logBacktraceMessage("Media file validation failed");
                return false;
            }
            if($extension=="avi" || $extension=="mp4" || $extension=="3gp" || $extension=="mov")
            {
                if(!in_array($this->media['mime_type'],$this->mimeType))
                {
                    $this->error=true;
                    $this->watchdog->logBacktraceMessage("Video file validation failed");
                    return false;
                }
                else
                {
                    $this->error=false;
                    $this->watchdog->logBacktraceMessage("Video file validated");
                    $this->mediaData['file_type']="video";
                    return true;
                }
            }
            else
            {
                $imagedata=getimagesize($this->media['tmp_name']);
                $this->watchdog->logBacktraceMessage("Called getimagesize");
                $this->mediaData['width']=$imagedata[0];
                $this->mediaData['height']=$imagedata[1];
                $this->mediaData['mime']=$imagedata['mime'];
                if(array_key_exists(strtolower($this->mediaData['mime']),$this->mimeType) && $this->mediaData['width']!=0 && $this->mediaData['height']!=0)
                {
                    $this->watchdog->logBacktraceMessage("Image file validated successfully");
                    $this->mediaData['file_type']="image";
                    return true;
                }
                else
                {
                    $this->error=true;
                    $this->watchdog->logBacktraceMessage("Image file validation failed");
                    return false;
                }
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
            if($this->mimeType[strtolower($this->mediaData['mime'])]=="jpeg")
            {
                $src=imagecreatefromjpeg($this->media['tmp_name']);
            }
            else if($this->mimeType[strtolower($this->mediaData['mime'])]=="png")
            {
                $src=imagecreatefrompng($this->media['tmp_name']);
            }
            else if($this->mimeType[strtolower($this->mediaData['mime'])]=="gif")
            {
                $src=imagecreatefromgif($this->media['tmp_name']);
            }
            else
            {

                $this->watchdog->logBacktraceMessage("Incompatible format received for image recreation in module recreateImage");
                return false;
            }

            if(imagecopyresized($thumb,$src,0,0,0,0,IMAGE_WIDTH,IMAGE_HEIGHT,$this->mediaData['width'],$this->mediaData['height'])==TRUE)
            {
                $this->watchdog->logBacktraceMessage("Image recreated from specified format");
                $this->filePath=$this->uploadPath.DS.md5(date("Y-m-d H:i:s"))."_".str_replace(' ','',$this->media['name']).'.jpg';
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
        function moveUploadedMedia()
        {
            $this->watchdog->logBacktraceMessage("Call to module moveUploadedMedia");
            $this->filePath=$this->uploadPath.DS.md5(date("Y-m-d H:i:s"))."_".str_replace(' ','',$this->media['name']);
            if(move_uploaded_file($this->media['tmp_name'],$this->filePath)==TRUE)
            {
                $this->watchdog->logBacktraceMessage("Media moved successfully");
                return true;
            }
            else
            {
                $this->error=1;
                $this->watchdog->logBacktraceMessage("Unable to move media in module moveUploadedMedia");
                return false;
            }
        }

        /**
         * Returns the data of uploaded file
         *
         * @returns Array
         */
        function getUploadData()
        {
            $this->mediaData['upload_path']=str_replace(ROOT,'',$this->filePath);
            return $this->mediaData;
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
            $this->media=null;
        }
    }