<?php
/**
 * Defines the model class for the database
 *
 * @author Saurabh Badhwar
 */


    /**
     * Class Model
     *
     * Defines the class to be extended for database abstraction
     */
    class Model extends ModelBase
    {
        /**
         * @access protected
         * @var String The name of the class
         */
        protected $_model;

        /**
         * @access protected
         * @var Watchdog $watchdog The watchdog object
         */
        protected $watchdog;

        /**
         * Construtor for the Model Class
         *
         * Calls the connect function and sets the model and table name
         */
        function __construct(){
            $this->connect(DB_HOST,DB_USER,DB_PASS,DB_NAME);
            $this->_model=get_class($this);
            $this->_table=strtolower($this->_model)."s";
            $this->watchdog=new Watchdog();
        }

        /**
         * Destructor for the class
         */
        function __destruct(){

        }
    }