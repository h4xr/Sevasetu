<?php
/**
 * Created by PhpStorm.
 * User: saurabh
 * Date: 11/9/15
 * Time: 4:41 PM
 */

class Program extends Model
{
    /**
     * @var String $program_name The name of the program
     */
    public $program_name;

    public function getProgram($name)
    {
        $this->program_name=$name;
        $query="SELECT * FROM arrow_pages WHERE pages_title LIKE '%".$this->program_name."%'";
        $this->_result=$this->_dbHandle->query($query);

        if($this->_result===FALSE)
        {
            $this->watchdog->logError("Unable to get program page",500,__CLASS__);
            return false;
        }
        else
        {
            $data=array();
            foreach($this->_result as $result)
            {
                $data=$result;
            }
            return $data;
        }
    }
}