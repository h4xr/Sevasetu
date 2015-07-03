<?php
/**
 * Manage the Cookie handling for the framework
 *
 * @author Saurabh Badhwar
 */

    /**
     * Class Cookie
     *
     * Manages the cookie handling functionality for the framework
     * by providing methods to set and retrieve the cookie contents
     */
    class Cookie
    {
        /**
         * @access protected
         * @var String $cookieName The name of the cookie
         */
        protected $cookieName;
        /**
         * @access Protected
         * @var Mixed $cookieValue The value to be stored in the cookie
         */
        protected $contentValue;
        /**
         * @access Protected
         * @var DateTime $cookieLifeTime The lifetime for the cookie
         */
        protected $cookieLifeTime;
        /**
         * @access Protected
         * @var String $cookiePath The path where cookie will be available
         */
        protected $cookiePath;

        /**
         * The constructor for the class
         *
         * Sets the name of the new cookie and retrieves the value if the cookie already exists
         *
         * @param String $name The name of the cookie
         */
        function __construct($name)
        {
            $this->cookieName=$name;
            if(isset($_COOKIE[$name])==TRUE)
            {
                $this->contentValue=$_COOKIE[$name];
            }
        }

        /**
         * Builds a new cookie to be set
         *
         * The methods builds a new cookie to be stored and calls the internal set function
         * to set the cookie
         *
         * @param Mixed $value The value to be stored in the cookie
         * @param DateTime $time The time for which the cookie needs to be set
         * @param String $path The path where the cookie should be made available. Default to /
         *
         * @returns void
         */
        function buildCookie($value,$time,$path='/')
        {
            $this->cookieLifeTime=$time;
            $this->contentValue=$value;
            $this->cookiePath=$path;
            if($this->set()==false)
            {
                error_log("Unable to set a new cookie");
            }
        }

        /**
         * Sets a new cookie
         *
         * @access private
         *
         * @returns bool
         */
        private function set()
        {
            if(setcookie($this->cookieName,$this->contentValue,time()+$this->cookieLifeTime,$this->cookiePath)==TRUE)
            {
                return true;
            }
            else
            {
                return false;
            }
        }

        /**
         * Returns the value stored in the cookie
         *
         * @return Mixed
         */
        function getCookie()
        {
            return $this->contentValue;
        }

        function __destruct()
        {

        }
    }