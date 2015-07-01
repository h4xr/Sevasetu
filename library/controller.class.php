<?php
/**
 * Controller Class
 * Defines the routing model of the controller for the
 * Framework.
 *
 * @author Saurabh Badhwar
 */

    /**
     * Class Controller
     * Defines the data routing for the framework
     */
class Controller
{
    /**
     * @var String Name of the model
     */
    protected $_model;
    /**
     * @var String Name of the action
     */
    protected $_action;
    /**
     * @var String Name of the controller
     */
    protected $_controller;
    /**
     * @var Object Reference to the newly created template object
     */
    protected $_template;

    /**
     * Default constructor for the Controller class
     *
     * @param $model Name of the model
     * @param $controller Name of the controller
     * @param $action Name of the action
     */
    function __construct($model,$controller,$action)
    {
        $this->_model=$model;
        $this->_controller=$controller;
        $this->_action=$action;

        //Create a new instance of the model
        $this->$model=new $model;
        //Create a new template object
        $this->_template=new Template($controller,$action);
    }

    /**
     * Sets the property value of variables for the template
     *
     * @param $name Name of the property
     * @param $value The value of the property
     *
     * @return void
     */
    function set($name,$value)
    {
        $this->_template->set($name,$value);
    }

    /**
     * Destructor for the Controller class
     *
     * Destroys the class and renders the template to the user
     */
    function __destruct()
    {
        $this->_template->render();
    }
}