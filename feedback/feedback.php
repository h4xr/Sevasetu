<?php
    
    $name=$_POST['name'];
    $course=$_POST['course'];
    $branch=$_POST['branch'];
    $year=$_POST['year'];
    $shift=$_POST['studyShift'];
    $college=$_POST['college'];
    $email=$_POST['email'];
    $contact=$_POST['contact'];
    $eventRating=$_POST['eventRating'];
    $ismember=$_POST['member'];
    $knowIEEE=$_POST['know'];
    $joinIEEE=$_POST['wjoin'];
    $suggestions=$_POST['suggestion'];
    $location=$_POST['location'];
    $ideas=$_POST['ideas'];
    
    $db=new mysqli("localhost","root","MYNET696","ieee_feedback");
    if($db->connect_error)
    {
        echo "Error recording feedback";
    }
    else
    {
        $sql="INSERT INTO feedback(Participant_Name,Course,Branch,Year,Shift,College,EMail,Mobile_Number,Event_Rating,IEEE_Member,Know_IEEE,Join_IEEE,Suggestions,Location_Review,Ideas) VALUES('$name','$course','$branch',$year,$shift,'$college','$email','$contact','$eventRating','$ismember','$knowIEEE','$joinIEEE','$suggestions','$location','$ideas')";
        if($db->query($sql)==TRUE)
        {
            echo "Thank you for the feedback.";
        }
        else
        {
            echo "Error recording feedback";
        }
    }
    
