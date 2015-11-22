<div id="new-slide-container" class="container-fluid admin-block">
    <?php
        if(!isset($message))
        {
            $titled=$slide['slides_title'];
            $description=$slide['slides_description'];
            $img=$slide['slides_image'];
            echo<<<_END
<form enctype="multipart/form-data" id="slider-form" method="post">
        <input type="text" id="title" class="arrow-input" name="title" value='$titled'>
        <textarea id="description" class="arrow-textarea" name="description">$description</textarea>
        <img src='$img'>
    </form>
_END;

        }
        else
        {
            echo "<div class='container-fluid'>$message</div>";
        }
    ?>
</div>