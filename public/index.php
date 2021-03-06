<?php
/**
 * Defines the entry point into the website
 *
 * All the requests are passed through the index decomposing them
 * into proper controller,model and views and calling the appropriate classes
 *
 * @author Saurabh Badhwar
 */

/**
 * The Directory Separator constant.
 * Defines the type of directory separator being used by the OS
 */
define('DS', DIRECTORY_SEPARATOR);

/**
 * The Project Root constant
 * Defines the root of the project
 */
define('ROOT',dirname(dirname(__FILE__)));

/**
 * The request parameter. Stores the request URL.
 */
$request=$_GET['url'];
    if(!isset($_GET['url']))
    {
        $request="indexs/home";
    }

require_once(ROOT.DS.'library'.DS.'bootstrap.php');

