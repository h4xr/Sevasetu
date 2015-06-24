<?php
/**
 * Sets some global parameters for the framework
 *
 * @author Saurabh Badhwar
 */

    /**
     * Check if the environment is set to DEVELOPMENT and display errors
     *
     * @return void
     */
    function setReporting()
    {
        if(DEVELOPMENT_ENVIRONMENT==true)
        {
            error_reporting(E_ALL);
            ini_set("display_errors",'On');
        }
        else
        {
            error_reporting(E_ALL);
            ini_set('display_errors','Off');
            ini_set('log_errors','On');
            ini_set('error_log',ROOT.DS.'tmp'.DS.'log'.DS.'error.log');
        }
    }

    /**
     * Remove the slashes
     *
     * @param string $value The value from which slashes has to be removed
     *
     * @return string
     */
    function stripSlashesDeep($value)
    {
        $value=is_array($value)? array_map('stripSlashesDeep',$value) : stripslashes($value);
        return $value;
    }

    /**
     * Check the magic quotes and remove them
     *
     * @return void
     */
    function removeMagicQuotes()
    {
        if(get_magic_quotes_gpc())
        {
            $_GET=stripSlashesDeep($_GET);
            $_POST=stripSlashesDeep($_POST);
            $_COOKIE=stripSlashesDeep($_COOKIE);
        }
    }

    /**
     * Check for register globals and remove them
     *
     * @return void
     */
    function unregisterGlobals()
    {
        if(ini_get('register_globals')){
            $array=array('_SESSION','_POST','_GET','_COOKIE','_REQUEST');
            foreach($array as $value)
            {
                foreach($GLOBALS[$value] as $key=>$var)
                {
                    if($var === $GLOBALS[$key])
                    {
                        unset($GLOBALS[$key]);
                    }
                }
            }
        }
    }

    /**
     * The URL parser
     *
     * Parses the URL into appropriate controller,model and view and calls the appropriate function
     *
     * @return void
     */
    function parser()
    {
        global $request;

        $requestArray=array();
        $requestArray=explode('/',$requestArray);

        $controller=$requestArray[0];
        array_shift($requestArray);
        $action=$requestArray[0];
        array_shift($requestArray);
        $queryString=$requestArray;

        $controllerName=$controller;
        $controller=ucwords($controller);
        $model=rtrim($controller,'s');
        $controller.='Controller';
        $dispatch=new $controller($model,$controllerName,$action);

        if((int)method_exists($controller,$action))
        {
            call_user_func_array(array($dispatch,$action),$queryString);
        }
        else
        {
            die("Server Parse Error");
        }
    }

    /**
     * Autoloads the classes being instantiated
     *
     * @param String $className The name of the class to be loaded
     *
     * @return void
     */
    function __autoload($className)
    {
        if (file_exists(ROOT . DS . 'library' . DS . strtolower($className) . '.class.php')) {
            require_once(ROOT . DS . 'library' . DS . strtolower($className) . '.class.php');
        } else if (file_exists(ROOT . DS . 'application' . DS . 'controllers' . DS . strtolower($className) . '.php')) {
            require_once(ROOT . DS . 'application' . DS . 'controllers' . DS . strtolower($className) . '.php');
        } else if (file_exists(ROOT . DS . 'application' . DS . 'models' . DS . strtolower($className) . '.php')) {
            require_once(ROOT . DS . 'application' . DS . 'models' . DS . strtolower($className) . '.php');
        } else {
            die("Server Parse Error");
        }
    }

setReporting();
removeMagicQuotes();
unregisterGlobals();
parser();