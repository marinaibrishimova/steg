<!DOCTYPE html>
<html>
<head>
<meta http-equiv='Content-type' content='text/html; charset=utf-8'>
<meta name="viewport" content="width=device-width, initial-scale=1, minimal-ui">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Hiding a 128 bit key in an image </title>
<script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
	<script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>
  </head>
  <body>
<?php 
	$timekey = time();?>
	<div id="about" class="page">
		<div class="content-wrapper">
			<div class="content">
				<div class="inner">
					<h1>Hide a 128 bit integer in an image using the unix timestamp of the image upload modulo (size of image/2) as key</h1>
<section id="cd-timeline" class="cd-container">
    <div class="cd-timeline-content"> 
		<div id="inputTainer">
		    	    <p>
					<h3>II. Function Ensteg </h3>
					1. Split integer into individual digits and put them into array A<br />
					2. For each pixel at location x == key in the image add a digit from the array A to the alpha channel, move onto next digit and repeat until the end of the image<br />
                    3. Add random 0-9 digit to the alpha channel of other pixels<br />
                    4. Save image as png
                    </p>
		<form action="/steg/index.php/main/upload_img" method="post" accept-charset="utf-8" id="upload_img" enctype="multipart/form-data">
		    <h2>1. Enter a numeric message</h2>
            <p>
		    <input type="text" name="msg" id="msg" value="170141183460469231731687303715884105727"/><br />
		    <input type="hidden" name="time" id="time" value="<?php echo $timekey;?>"/><br />
		    </p>
		    <p> 
	        <h2>2. Select a photo </h2><input type="file" name="userfile" id="choose_file_input" onchange="resize(this); return false;" size="20" value="Select an Image" class="hidden"/>
            <input type="hidden" name="data_url" id="data_url" />
            </p>
        </form>
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
//load image onto canvas and resize if needed	  
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