<div id="pages-content-container" class="container-fluid admin-block">
    <div class="inner-title">Pages | <a class="inner-link" href="/admins/newpage">Add New</a> </div>
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
                foreach($pages as $page)
                {
                    $id=$page['pages_id'];
                    $title=$page['pages_title'];
                    echo<<<_END
<tr>
    <td>$id</td>
    <td><a href='/admins/viewpage/$id'>$title</a></td>
    <td><a href='/admins/removepage/$id'>Delete Page</a></td>
</tr>
_END;

                }
            }
        ?>
    </table>
</div>