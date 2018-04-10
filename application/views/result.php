<!DOCTYPE html>
<html>
  <head>
    <meta http-equiv='Content-type' content='text/html; charset=utf-8'>
    <meta name="viewport" content="width=device-width, initial-scale=1, minimal-ui">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Message in an image</title>
<script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
	<script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>
  </head>
  <body>
	<div id="about" class="page">
		<div class="content-wrapper">
			<div class="content">
				<div class="inner">
					<h1>Success! Download StegoPNG below. </h1>
<section id="cd-timeline" class="cd-container">
    <div class="cd-timeline-content"> 
		<div id="inputTainer">
	 <a href="steg/temp_imgs/<?php echo $image; ?>.png" class="cd-read-more">Download Image</a></div>
</div>
</section>
<section id="cd-timeline" class="cd-container">
    <div class="cd-timeline-content"> 
		<div id="inputTainer">
		  
	 <a href="steg/index.php/main/destegged/<?php echo $image; ?>/<?php echo $key; ?>" class="cd-read-more">Get Secret Message</a></div>
</div>
</section>
</div>
<div style="clear:both"></div>
</div>
</div>
</div>
</div>

<canvas id="canvas" style="z-index:100000;">No Canvas</canvas>
		<img src="" id="imgr" style="position:absolute; top:0px; left:0px; visibility:hidden;">
<script>
var showUploadSuccess = function() {
	$('#choose_album').trigger('tap');
	$("#upload").show(200);
    	var uploadTimeout = setTimeout( function() {
    	   $("#upload").hide(200);
    	}, 5000);
};
</script>
	 
    </div>
	  
<script>
function resize(input) {
	$('#loading').show();
	// Check for the various File API support.
	if (window.File && window.FileReader && window.FileList && window.Blob) {
		// Great success! All the File APIs are supported.
	} else {
		alert('File APIs not supported');
	}
	var file = input.files[0];
	
	var imgr = document.getElementById('imgr');
	var reader = new FileReader();
	reader.onload = function(event) {
	   imgr.src = event.currentTarget.result;
	};
	reader.onloadend = function(event) {
	   if (imgr.complete) {
	      dataurl = paintImage();
	      submitForm(dataurl);
           } else {
              imgr.onload = function () {
                 dataurl = paintImage();
                 submitForm(dataurl);
              };
           }
	};
	reader.onerror = function(event) {
	   alert('error');
	}
	reader.readAsDataURL(file);
}
function paintImage() {
	var canvas = document.getElementById('canvas');
	var imgr = document.getElementById('imgr');
	var MAX_WIDTH = 1000;
	var MAX_HEIGHT = 1000;
	var width = imgr.width;
	var height = imgr.height;

	if (width > height) {
	  if (width > MAX_WIDTH) {
	    height *= MAX_WIDTH / width;
	    width = MAX_WIDTH;
	  }
	} else {
	  if (height > MAX_HEIGHT) {
	    width *= MAX_HEIGHT / height;
	    height = MAX_HEIGHT;
	  }
	}

	var ctx=canvas.getContext('2d');
	canvas.width = width;
	canvas.height = height;
	ctx.drawImage(imgr, 0, 0, width, height);
	var dataurl = canvas.toDataURL('image/jpeg');
	
	return dataurl;
}
function submitForm(dataurl) {
	var formy = document.getElementById('upload_img');
	$('#data_url').val(dataurl);
	formy.submit();
}

$('#choose_album').on('tap', function() {
   $('.crop_border').css({'display':'inline-block'});
});

$('#choose_file').on('tap', function() {
   $('#choose_file_input').click();
});

</script>
  </body>
</html>