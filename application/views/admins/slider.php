<div id="featured-content-container" class="container-fluid admin-block">
    <div class="inner-title">Featured Slides | <a class="inner-link" href="/admins/newslide">Add New</a> </div>
    <table class="table table-responsive pull-right">
        <thead>
            <tr>
                <th>ID</th>
                <th>Title</th>
                <th>Options</th>
            </tr>
        </thead>
        <?php
            if(isset($message))
            {
                echo<<<_END
<tr>
    <td></td>
    <td>$message</td>
    <td></td>
</tr>
_END;

            }
            else
            {
                foreach($slides as $slide)
                {
                    $id=$slide['slides_id'];
                    $title=$slide['slides_title'];
                    echo<<<_END
<tr>
    <td>$id</td>
    <td><a href='/admins/viewslide/$id'>$title</a></td>
    <td><a href='/admins/removeslide/$id'>Delete Slide</a></td>
</tr>
_END;

                }
            }
        ?>
    </table>
</div>