<?php
/**
 * Class for managing the database
 * abstraction for index page
 */

class Index extends Model
{

    /**
     * Get the slides from the database
     *
     * @returns Array|false
     */
    function getSlides()
    {
        $query="SELECT * FROM arrow_slides";
        $this->_result=$this->_dbHandle->query($query);
        if($this->_result==FALSE)
        {
            $this->watchdog->logError("Unable to get slides from the database",200,__CLASS__);
            return false;
        }
        $data=array();
        foreach($this->_result as $results)
        {
            $data[]=$results;
        }
        return $data;
    }
}