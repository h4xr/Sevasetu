<?php
    if($response==false)
    {
        echo<<<_END
<div id="form">
    <form action="/contacts/index" method="post">
        <label>Name<br>
            <input type="text" name="Name">
        </label><br><br>
        <label>Email Address<br>
            <input type="email" name="Email">
        </label><br><br>
        <label>Message<br>
            <textarea name="Message"></textarea>
        </label><br><br>
        <input type="submit" value="Submit" name="contact_submit">
    </form>
</div>
<div id="part2">
    <a href="#"><div class="button transition" id="do-bu">Donate</div></a>
    <a href="#"><div class="button transition" id="pro-bu">Start A Project</div></a>
</div>

_END;

    }
    else
    {
        echo $response;
    }
?>
