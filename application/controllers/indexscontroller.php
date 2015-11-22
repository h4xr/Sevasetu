<?php
/**
 * Provides functionality to control the content that is displayed on the
 * Front page
 */

include_once(ROOT.DS.'library'.DS.'security.php');
include_once(ROOT.DS.'library'.DS.'session.php');
class IndexsController extends Controller
{
    function home()
    {
        initiateSession();
        $this->set("title","Sevasetu | Home");
        $this->set("slides",$this->Index->getSlides());

    }
}