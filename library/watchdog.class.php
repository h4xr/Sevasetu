<?php
/**
 * Watchdog handles the error and exception management
 * for the framework. It controls the script logging and error
 * reporting for the framework.
 * Watchdog may be used to create backtrace in critical portions of the
 * framework code for debugging purposes if something goes wrong.
 *
 * @author Saurabh Badhwar
 */

    /**
     * Class Watchdog
     *
     * Implements the Watchdog API for the framework to
     * be utilized by the framework for error and backtrace
     * management.
     *
     * Other classes can extend the Watchdog API to implement more features
     * as per the requirement.
     *
     * It is recommended that the constructor of the derived class calls
     * the parent constructor through parent::__construct()
     */
    class Watchdog
    {
        /**
         * @access private
         * @var Mixed $fileHandle The file handle acquired by the Watchdog
         */
        private $fileHandle;
        /**
         * @access protected
         * @var String $message The error or exception message
         */
        protected $message;
        /**
         * @access protected
         * @var INT $messageCode The error or exception code
         */
        protected $messageCode;
        /**
         * @access protected
         * @var String $messageOrigin The file which caused the generation of message
         */
        protected $messageOrigin;
        /**
         * @access protected
         * @var DateTime $backTraceTimeStamp The timestamp of the backtrace
         */
        protected $backTraceTimeStamp;
        /**
         * @access public
         * @var array $backTraceMessage The message being logged during the backtrace
         */
        public $backTraceMessage=array();

        /**
         * The constructor for the class
         * Opens the error log file if the backtrace parameter is not set
         *
         * @param INT $backtrace If the class is being instantiated for the backtrace
         */
        function __construct($backtrace=0)
        {
            if($backtrace==0)
            {
                $this->fileHandle=@fopen(ROOT.DS.'tmp'.DS.'log'.DS.'watchdog.log',"a+");
                if($this->fileHandle==FALSE)
                {
                    die("Critical Error:Unable to initiate Framework Watchdog.");
                }
            }
            else
            {
                $this->backTraceTimeStamp=date("Y-m-d H:i:s");
                $backtraceFile="watchdog_".md5($this->backTraceTimeStamp);
                $backtraceFile=ROOT.DS.'tmp'.DS.'log'.DS.$backtraceFile;
                $this->fileHandle=@fopen($backtraceFile,"a+");
                if($this->fileHandle==FALSE)
                {
                    die("Unable to initiate the backtrace");
                }
            }
        }

        /**
         * Log a new error in the file
         *
         * The function logs a new error in the file
         * The functions calls the flock to get a exclusive lock over the file
         * for the purpose of writing
         *
         * @param String $message The message to be logged
         * @param INT $code The code of the message
         * @param String $origin The file path where the message was created
         *
         * @returns bool
         */
        function logError($message,$code,$origin)
        {
            $this->message=$message;
            $this->messageCode=$code;
            $this->messageOrigin=$origin;
            $errorString=date("Y-m-d H:i:s")."($this->messageOrigin): $this->messageCode :: ".$this->message.'\n';
            if(flock($this->fileHandle,LOCK_EX)==TRUE)
            {
                fwrite($this->fileHandle,$errorString);
                flock($this->fileHandle,LOCK_UN);
                return true;
            }
            else
            {
                echo "Unable to acquire the file lock";
                return false;
            }
        }

        /**
         * Starts the backtrace for the application
         * The messages must be logged for backtrace to work properly
         *
         * @param String $block The name of the block for which the backtrace is being done
         *
         * @returns void
         */
        function startBacktrace($block)
        {
            $message=date("Y-m-d H:i:s")." Backtrace started for block $block";
            $this->backTraceMessage[]=$message;
        }

        /**
         * Logs a new message for the backtrace
         *
         * @param String $msg The message to be logged
         *
         * @returns void
         */
        function logBacktraceMessage($msg)
        {
            $message=date("Y-m-d H:i:s").": $msg";
            $this->backTraceMessage[]=$message;
        }

        /**
         * Retrieves the backtrace messages
         *
         * @returns array
         */
        function getBacktrace()
        {
            return $this->backTraceMessage;
        }

        /**
         * Stops the backtrace and writes the data to the file
         *
         * @returns void
         */
        function stopBacktrace()
        {
            $message=date("Y-m-d H:i:s").": Backtrace stopped";
            $this->backTraceMessage[]=$message;
            foreach($this->backTraceMessage as $msg)
            {
                $str=$msg.'\n';
                fwrite($this->fileHandle,$str);
            }
        }

        /**
         * Clear the backtrace log
         *
         * @returns void
         */
        function clearBacktrace()
        {
            while(array_pop($this->backTraceMessage)!=NULL);
        }

        /**
         * Get last error
         *
         * Returns an array containing the last error message, error code and error origin
         *
         * @returns Mixed
         */
        function getLastError()
        {
            $error=array(
                'message'=>$this->message,
                'code'=>$this->messageCode,
                'origin'=>$this->messageOrigin
            );
            return $error;
        }

        /**
         * Destructor for the class
         *
         * Releases the file handle to free resources
         */
        function __destruct()
        {
            fclose($this->fileHandle);
        }
    }
