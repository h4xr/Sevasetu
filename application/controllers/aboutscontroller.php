<?php
/**
 * Provides routing for the about page
 *
 * @author Saurabh Badhwar
 */

    include_once(ROOT.DS.'library'.DS.'security.php');
    include_once(ROOT.DS.'library'.DS.'session.php');

class AboutsController extends Controller
{
    /*
     * About IEEE
     */
    function ieee()
    {
        initiateSession();
        $this->set("title","IEEE NIEC | About IEEE");
    }

    /*
     * About IEEE NIEC
     */
    function niec()
    {
            initiateSession();
            $this->set("title","IEEE NIEC | About IEEE NIEC");

    }

    /*
     * Team Page
     */
    function team()
    {
            initiateSession();
            $this->set("title","IEEE NIEC | Team");

    }
}