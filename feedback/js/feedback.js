/**
 * Created by Kanika on 3/18/2015.
 */
$(document).ready(function(){

    $("#feedback").submit(function(e){
        e.preventDefault();
        $errors=0;
        $NameLength=$("input#Name").val();
        $CollegeLength=$("input#CollegeName").val();
        $EmailLength=$("input#email-id").val();
        $ContactLength=$("input#number").val();
        $SuggestionsLength=$("#suggestion").val();
        $LocationLength=$("#location").val();
        $IdeasLength=$("#ideas").val();
        if($NameLength.length<3)
        {
            $("input#Name").addClass("error").focus();
            $errors++;
        }
        if($CollegeLength.length<3)
        {
            $("input#CollegeName").addClass("error").focus();
            $errors++;
        }
        if($EmailLength.length<5)
        {
            $("input#email-id").addClass("error").focus();
            $errors++;
        }
        if($ContactLength.length<10)
        {
            $("input#number").addClass("error").focus();
            $errors++;
        }
        if($SuggestionsLength.length<2)
        {
            $("#suggestions").addClass("error").focus();
            $errors++;
        }
        if($LocationLength.length<1)
        {
            $("#location").addClass("error").focus();
            $errors++;
        }
        if($IdeasLength.length<2)
        {
            console.log("Ideas error");
            $("#ideas").addClass("error").focus();
            $errors++;
        }
        if($errors>0)
        {
            return;
        }
        else
        {
            $ismember=$("input[name=member]:checked").val();
            $course=$("select[name=Course]").val();
            $branch=$("select[name=Branch]").val();
            $studyshift=$("select[name=Shift]").val();
            $year=$("select[name=year]").val();
            $eventRating=$("input[name=rate]:checked").val();
            $knowIEEE=$("input[name=heard]:checked").val();
            $joinIEEE=$("input[name=joinIEEE]:checked").val();
            $.post("feedback.php",{name: $NameLength,course: $course,branch: $branch,studyShift: $studyshift,year: $year,college: $CollegeLength,email: $EmailLength,contact: $ContactLength,eventRating: $eventRating,member: $ismember,know: $knowIEEE,wjoin: $joinIEEE,suggestion: $SuggestionsLength,location: $LocationLength,ideas: $IdeasLength}).done(function(data){
                $("#feedback").html(data);
            });
        }
    });
});
