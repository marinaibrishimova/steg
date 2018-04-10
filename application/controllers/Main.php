<?php

class Main extends CI_controller
{
	function __construct()
	{
		parent::__construct('main');
		$this->load->model('Steg');
	}
	function index()
	{
		$this->load->view('main');
	}
	function upload_img()
	{
		//grab image data from post data
		$data_url = filter_var($this->input->post('data_url'), FILTER_UNSAFE_RAW);
		$data_url = str_replace(' ','+',$data_url);
		$message = filter_var($this->input->post('msg'), FILTER_SANITIZE_FULL_SPECIAL_CHARS);
		$key = filter_var($this->input->post('time'), FILTER_SANITIZE_FULL_SPECIAL_CHARS);
		if(is_numeric($message) && is_numeric($key))
		{
		    $message = str_split($message);
		    $key = $key%500;
		    //check image data for acceptable format:accepts png and jpg
		    if(strpos($data_url, 'jpeg'))
		    {
 			    $image = base64_decode(str_replace('data:image/jpeg;base64,', '', $data_url));
 			    $ext = "jpg";
 		    }
 		    else if(strpos($data_url, 'png'))
		    {
 			    $image = base64_decode(str_replace('data:image/png;base64,', '', $data_url));
 			    $ext = "png";
 		    } 
		    else
		    {
			    json_encode(array('error'=>'Image not valid','success'=>'no'));
		    }	
			if(filter_var($image, FILTER_SANITIZE_STRING))
			{
				$file = rand();
				$filename = getcwd()."/uplds/".$file.".".$ext;
				$fp = fopen($filename, 'w');
				if(fwrite($fp, $image))
				{
					fclose($fp);
					//create stego image
					if ($final_img = $this->Steg->ensteg($file, $message, $key, $filename)) 
					{
						$final_data = array('image'=>$final_img, 'key'=>$key, 'success'=>'yes');
						$this->load->view('result', $final_data);
					}
					else
					{
						echo json_encode(array('error'=>'Could not ensteg','success'=>'no'));
					}
				}
				else{
					echo json_encode(array('error'=>'Could not write image','success'=>'no'));
				}
			}
			else{
				echo json_encode(array('error'=>'Image format not accepted','success'=>'no'));
			}
		}
		else {echo "Message must be numeric";}
	}

//desteg a stego image (retrieve the message drray)
//accepts image ID and timestamp key as parameters
	function destegged($img_id, $key)
	{
	    $key = filter_var($key, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
	    $img_id = filter_var($img_id, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
		if(is_numeric($img_id) && is_numeric($key))
		{
		    $destegged_message = $this->Steg->desteg($img_id, $key);
		    print_r($destegged_message);
		}
		else 
		{
		    echo "Image ID and key must be numeric";
		   
		}
	}
}