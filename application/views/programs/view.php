<div id="inform" class="transition">
    <div class="info">
        <h4>About</h4 >
        <p><?php echo $program['pages_description']; ?></p>
    </div>
    <div class="info info-Gallery transition">
        <h4>Gallery</h4>
        <ul id="mb_imagelist" class="mb_imagelist transition">
            <?php
                $image=$program['pages_image'];
                $mulimage=explode(",",$program['pages_multiple_image']);
                echo<<<_END
<li><a class='fancybox' rel='group' href='$image' title='$title'><img class='transition' src='$image' width='60' height='60' alt='Program Image'></a></li>
_END;
                foreach($mulimage as $img)
                {
                    echo<<<_END
<li><a class='fancybox' rel='group' href='$img' title='$title'><img class='transition' src='$img' width='60' height='60' alt='Program Image'></a></li>
_END;

                }
            ?>
        </ul>

    </div>

</div>
