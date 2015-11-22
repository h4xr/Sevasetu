$(document).ready(function(){
    count('#stat1')
    count('#stat2');
	count('#stat3');
});

function count(id)
{
    var $count=$(id).attr("data-counter");
    var $curr=0;
    var $interval=setInterval(function(){
        if($curr>$count)
        {
            clearInterval($interval);
        }
        else
        {
            $(id+" > .stat-count").text($curr);
            $curr++;
        }
    },0.1);
}
