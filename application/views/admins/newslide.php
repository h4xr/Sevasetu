<div id="new-slide-container" class="container-fluid admin-block">
    <?php
        if(!isset($message))
        {
            echo<<<_END
<form enctype="multipart/form-data" id="slider-form" method="post" action="/admins/newslide">
        <input type="text" id="title" class="arrow-input" name="title" placeholder="Slide Title(Required)">
        <textarea id="description" class="arrow-textarea" name="description" placeholder="Slide Description"></textarea>
        <input type="file" id="featured_image" class="arrow-input" name="featured_image">
        <input type="submit" class="arrow-button" id="post_slide" name="post_slide" value="Post Slide">
    </form>
_END;

        }
        else
        {
            echo "<div class='container-fluid'>$message</div>";
        }
    ?>
</div>