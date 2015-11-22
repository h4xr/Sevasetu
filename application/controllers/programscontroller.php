<?php
/**
 * Created by PhpStorm.
 * User: saurabh
 * Date: 11/9/15
 * Time: 4:36 PM
 */

    include_once(ROOT.DS.'library'.DS.'security.php');

class ProgramsController extends Controller
{
    public function view($page_name)
    {
        $page_name=sqlSafe($page_name);
        $data=$this->Program->getProgram($page_name);
        $this->set("title",$data['pages_title']);
        $this->set("program",$data);
    }
}