<?php
/**
 * Defines the template class for the framework
 *
 * @author Saurabh Badhwar
 */

    /**
     * Class Template
     *
     * Defines the class to be worked for the templating engine of the framework
     */
    class Template
    {
        /**
         * @access protected
         * @var array
         */
        protected $variables=array();
        /**
         * @access protected
         * @var String The name of the controller
         */
        protected $_controller;
        /**
         * @access protected
         * @var String The name of the action
         */
        protected $_action;

        /**
         * Constructor for the class
         *
         * @param String $controller The name of the controller
         * @param String $action The name of the action
         */
        function __construct($controller,$action)
        {
            $this->_controller=$controller;
            $this->_action=$action;
        }

        /**
         * Set the value for the given field
         *
         * @param String $name The name of the field
         * @param String $value The value for the field
         *
         * @returns void
         */
        function set($name,$value)
        {
            $this->variables[$name]=$value;
        }

        /**
         * Render the final output to the user
         *
         * @return void
         */
        public function render()
        {
            extract($this->variables);
            if(file_exists(ROOT.DS.'application'.DS.'views'.DS.$this->_controller.DS.'header.php'))
            {
                include_once(ROOT.DS.'application'.DS.'views'.DS.$this->_controller.DS.'header.php');
            }
            else
            {
                include_once(ROOT.DS.'application'.DS.'views'.DS.'header.php');
            }

            include_once(ROOT.DS.'application'.DS.'views'.DS.$this->_controller.DS.$this->_action.'.php');

            if(file_exists(ROOT.DS.'application'.DS.'views'.DS.$this->_controller.DS.'footer.php'))
            {
                include_once(ROOT.DS.'application'.DS.'views'.DS.$this->_controller.DS.'footer.php');
            }
            else
            {
                include_once(ROOT.DS.'application'.DS.'views'.DS.'footer.php');
            }
        }
    }