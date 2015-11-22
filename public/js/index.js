/**
 * Created by Kanika on 8/9/2015.
 */

$(document).ready(function(){
	$(".ch-item").click(function()
	{
		window.location=$(this).find(".ch-info > p > a").attr("href");
	});
});