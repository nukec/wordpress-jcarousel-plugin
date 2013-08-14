function mycarousel_initCallback(carousel)
{
	// Disable autoscrolling if the user clicks the prev or next button.
	carousel.buttonNext.bind('click', function() {
		carousel.startAuto(0);
	});

	carousel.buttonPrev.bind('click', function() {
		carousel.startAuto(0);
	});

	// Pause autoscrolling if the user moves with the cursor over the clip.
	carousel.clip.hover(function() {
		carousel.stopAuto();
	}, function() {
		carousel.startAuto();
	});
};

function chamile(divid, type, code, width, height){

	//vimeo
	if(type == "1"){
		document.getElementById(divid).innerHTML = "<iframe src=\"http://player.vimeo.com/video/" + code + "?badge=0\" width=\"" + width + "\" height=\"" + height + "\" frameborder=\"0\" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe>";
	}
	//yt
	else if(type == "2"){
		document.getElementById(divid).innerHTML = "<iframe width=\"" + width + "\" height=\"" + height + "\" src=\"http://www.youtube.com/embed/" + code + "?wmode=transparent\" frameborder=\"0\" allowfullscreen></iframe>";
	}
	//image
	else if(type == "3"){
		document.getElementById(divid).innerHTML = "<img src=\"" + code + "\" width=\"" + width + "\" height=\"" + height + "\" border=\"0\" />";
	}
	

}
jQuery(function(){



	jQuery('#zonecarousel').jcarousel({
auto:8,
wrap: 'last',
initCallback: mycarousel_initCallback
	});

});

