<?php
class Steg extends CI_Model {
	
	public function __construct()
	{
		parent::__construct();
	}
	//embed message at position x = k
	function ensteg($id, $message, $key, $path_to_uploaded_img)
	{ 
		if(file_exists($path_to_uploaded_img))
		{ 
			$im = $path_to_uploaded_img;
		}
		else
		{
			return false;
		}
		$type = strtolower(substr(strrchr($path_to_uploaded_img,"."),1));
  		if($type == 'jpeg') $type = 'jpg';
  		switch($type)
  		{
    			case 'jpg': $im = imagecreatefromjpeg($path_to_uploaded_img); break;
    			case 'png': $im = imagecreatefrompng($path_to_uploaded_img); break;
    			default : return "Unsupported picture type!";
  		}		
		imagealphablending($im, false);
        imagesavealpha($im, true); 
		$width = imagesx($im);  
           	$height = imagesy($im); 
           	$i = 0;
           	$counter = count($message);
           	//let the looping begin  
           	for($x = 0; $x < $width; $x++)   
           	{  
                	for($y = 0; $y < $height; $y++)   
                	{  
                     		$rgb = imagecolorat($im, $x, $y);  
                     		$r = ($rgb >> 16) & 0xFF;  
                     		$g = ($rgb >> 8) & 0xFF;  
                     		$b = $rgb & 0xFF;  
                     		$alpha = ($rgb & 0xFF000000) >> 24;  
                      		
                     		if($x == $key)
                     		{
                     			//add individual digits from message array
                     			if($i == $counter){$i = 0;}
                     			$alpha = $message[$i];
                     			$i = $i + 1;
                     			//save pixel with updated alpha information
                     		 	imagesetpixel($im, $x, $y, imagecolorallocatealpha($im, $r, $g, $b,$alpha));
                     			 
                     		}
                     		else
                     		{
                     		   //add random digit to alpha channel of other px
                     		   $alpha = rand(0,9);
                     		 	imagesetpixel($im, $x, $y, imagecolorallocatealpha($im, $r, $g, $b,$alpha)); 
                     		}
                     		 
                     		 
                	}  
                }
			imagepng($im, 'temp_imgs/'.$id.'.png', 9);	
 
			$file = ''.$id.'.png';
			if (file_exists($file)) { unlink(''.$id.'.png'); }
			
			imagedestroy($im);
			
			$img_url = $id;				
		
			return $img_url;
		 
	}
    //retrieve message array from image using key
	function desteg($id, $key) 
	{ 
		$file1 = "temp_imgs/".$id.".png";
		if (file_exists($file1))
		{ 
			$im = "temp_imgs/".$id.".png";

		}
		else{
			return 0;
		}		
		$im = imagecreatefrompng($im);
		$msg_array = array();
		$width = imagesx($im);  
        $height = imagesy($im);
        for($x = 0; $x < $width; $x++)   
        {  
            for($y = 0; $y < $height; $y++)   
            {  
                $rgb = imagecolorat($im, $x, $y);  
                $r = ($rgb >> 16) & 0xFF;  
                $g = ($rgb >> 8) & 0xFF;  
                $b = $rgb & 0xFF;  
                $alpha = ($rgb & 0xFF000000) >> 24;  
                //grab alpha info at position x = key
                if($x == $key)
                { 
                     $msg_array[] = $alpha;
                }
            }  
        } 			
	return $msg_array; 
	}
}