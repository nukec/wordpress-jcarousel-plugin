function changeText(elemid) {

	var ind = document.getElementById(elemid).selectedIndex;
	//alert(ind);
	if(ind == '0'){
		document.getElementById('source_title').innerHTML = '<b>ID of video</b><font style="font-size:11px;">(Insert ID only)</font>';
		document.getElementById('source_example').innerHTML = '<font style="font-size:11px;">Example: http://vimeo.com/<b>56130535</b></font>';
		document.getElementById('w').style.display = 'table-row';
		document.getElementById('h').style.display = 'table-row';
	}
	else if(ind == '1'){
		document.getElementById('source_title').innerHTML = '<b>ID of video</b><font style="font-size:11px;">(Insert ID only)</font>';
		document.getElementById('source_example').innerHTML = '<font style="font-size:11px;">Example: http://www.youtube.com/watch?v=<b>S6mc3Fv7vDM</b></font>';
		document.getElementById('w').style.display = 'table-row';
		document.getElementById('h').style.display = 'table-row';
	}
	else if(ind == '2'){
		document.getElementById('source_title').innerHTML = '<b>Image URL</b><br /></font>';
		document.getElementById('source_example').innerHTML = '<font style="font-size:11px;">Example: http://i.imgur.com/EAGf6.jpg</font>';
		document.getElementById('w').style.display = 'none';
		document.getElementById('h').style.display = 'none';
	}
	//document.getElementById("title").innerHTML=textBlocks[ind];
}

// function for preview in admin
function preview(divid){

	//reset
	document.getElementById(divid).innerHTML = "";
	
	var type = document.getElementById('select_type').value;
	var code = document.getElementById('zoneslider_source').value;
	var width = document.getElementById('zoneslider_width').value;
	var height = document.getElementById('zoneslider_height').value;
	

	if(type == "1"){
		document.getElementById(divid).innerHTML = "<iframe src=\"http://player.vimeo.com/video/" + code + "?badge=0\" width=\"" + width + "\" height=\"" + height + "\" frameborder=\"0\" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe>";
	}
	
	else if(type == "2"){
		document.getElementById(divid).innerHTML = "<iframe width=\"" + width + "\" height=\"" + height + "\" src=\"http://www.youtube.com/embed/" + code + "\" frameborder=\"0\" allowfullscreen></iframe>";
	}
	
	else if(type == "3"){
		document.getElementById(divid).innerHTML = "<img src=\"" + code + "\" width=\"" + width + "\" height=\"" + height + "\" border=\"0\" />";
	}
	

}


jQuery(function(){

	changeText('select_type');
	preview('srcpreview');

});

