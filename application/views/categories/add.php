<form  method="GET" action="../categories/addcategory">
    Category Name: <input type="text" name="category_name" /><br />
    <input type="submit" value="Add category" name="sub" /><br />
</form>
<?php
    if(isset($message))
    {
        echo $message;
    }
?>