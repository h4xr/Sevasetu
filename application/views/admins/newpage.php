<div id="new-slide-container" class="container-fluid admin-block">
    <?php
        if(!isset($message))
        {
            echo<<<_END
<form enctype="multipart/form-data" id="slider-form" method="post" action="/admins/newpage">
        <input type="text" id="post_title" class="arrow-input" name="post_title" placeholder="Page Title(Required)">
        <textarea id="post_description" class="arrow-textarea" name="post_description" placeholder="Page Description"></textarea>
        <select id="post_category" class="arrow-select" name="post_category">
            <option value="Program">Program</option>
            <option value="Service">Service</option>
            <option value="News">News</option>
            <option value="Page">Page</option>
        </select>
        <input type="file" id="featured_image" class="arrow-input" name="featured_image">
        <label for="multiple_image" class="arrow-label">Upload Multiple Images For Page</label>
        <input type="file" id="multiple_image" class="arrow-input" name="multiple_image[]" multiple>
        <input type="submit" class="arrow-button" id="post_page" name="post_page" value="Post Slide">
    </form>
_END;

        }
        else
        {
            echo "<div class='container-fluid'>$message</div>";
        }
    ?>
</div>