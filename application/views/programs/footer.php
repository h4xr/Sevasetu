</div>
<script type="text/javascript" src="/public/js/jquery.js"></script>
<script type="text/javascript" src="/public/js/jquery.inview.min.js"></script>
<link rel="stylesheet" href="/public/source/jquery.fancybox.css" type="text/css" media="screen" />
<script type="text/javascript" src="/public/source/jquery.fancybox.pack.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $(".fancybox").fancybox();

    });
</script>
<style type="text/css">
#program
{
    background-image: url(<?php echo $program['pages_image']; ?>);
    background-repeat: no-repeat;
    background-size: cover;
    background-position: center;
}
</style>
</body>
</html>
