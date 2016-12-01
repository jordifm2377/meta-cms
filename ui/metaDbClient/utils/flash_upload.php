<?php
//list($cookieName, $cookieValue) = str_split('=', $_REQUEST['cookie']);
session_id($_REQUEST['cookie']);
session_name('PHPSESSID');

session_start();
require_once($_SERVER['DOCUMENT_ROOT'].'/admin/conf/ompinfo.php');
require_once("security.php");
//require_once($_SERVER['DOCUMENT_ROOT'].'/admin/upload_class.php');
/*
+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
jqUploader serverside example: (author : pixeline, http://www.pixeline.be)

when javascript is available, a variable is automatically created that you can use to dispatch all the possible actions

This file examplifies this usage: javascript available, or non available.

1/ a form is submitted
1.a javascript is off, so jquploader could not be used, therefore the file needs to be uploaded the old way
1.b javascript is on, so the file, by now is already uploaded and its filename is available in the $_POST array sent by the form

2/ a form is not submitted, and jqUploader is on
jqUploader flash file is calling home! process the upload.



+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

*/

if(testSession()) {
	$ymd =date('Ymd');
	$uploadDir=DIR_UPLOADS.$ymd."/";

	createDiretoryStructure(DIR_UPLOADS.$ymd);
	$uploadFile = $uploadDir.generateFileName2($uploadDir ,fixFileName( basename($_FILES['Filedata']['name'])));


	if ($_POST['submit'] != '') {
		// 1. submitting the html form
		if (!isset($_GET['jqUploader'])) {
			// 1.a javascript off, we need to upload the file
			//if (move_uploaded_file ($_FILES[0]['tmp_name'], $uploadFile)) {
			if (moveFileToDestination ($_FILES[0]['tmp_name'], $uploadFile)) {
				// delete the file
				// @unlink ($uploadFile);
				$html_body = '<h1>File successfully uploaded!</h1><pre>';
				$html_body .= print_r($_FILES, true);
				$html_body .= '</pre>';
			}
			else {
				$html_body = '<h1>File upload error!</h1>';

				switch ($_FILES[0]['error']) {
					case 1:
						$html_body .= 'The file is bigger than this PHP installation allows';
						break;
					case 2:
						$html_body .= 'The file is bigger than this form allows';
						break;
					case 3:
						$html_body .= 'Only part of the file was uploaded';
						break;
					case 4:
						$html_body .= 'No file was uploaded';
						break;
					default:
						$html_body .= 'unknown errror';
				}
				$html_body .= 'File data received: <pre>';
				$html_body .= print_r($_FILES, true);
				$html_body .= '</pre>';
			}
			$html_body = '<h1>Full form</h1><pre>';
			$html_body .= print_r($_POST, true);
			$html_body .= '</pre>';
		}
		else {
			// 1.b javascript on, so the file has been uploaded and its filename is in the POST array
			$html_body = '<h1>Form posted!</h1><p>Error:<pre>';
			$html_body .= print_r($_POST, false);

			$html_body .= '</pre>';
		}

	}
	else {
		if ($_GET['jqUploader'] == 1) {
			// ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
			// 2. performing jqUploader flash upload
			if ($_FILES['Filedata']['name']) {
				if (moveFileToDestination ($_FILES['Filedata']['tmp_name'], $uploadFile)) {
					// delete the file
					//  @unlink ($uploadFile);

					$_SESSION['uploadfile']=$uploadFile;

					$instance_id=$_REQUEST['xinst'];
					$atr_id=$_REQUEST['xatri'];

					/*global $dbh;
					$sql="delete from omp_values where atri_id=$atr_id and inst_id=$instance_id";
					$ret = mysql_query($sql, $dbh);
					$file= str_replace(DIR_APP."/","",$uploadFile);
					$sql='insert into omp_values (inst_id, atri_id, text_val) values("'.$instance_id.'", "'.$atr_id.'", "'.$file.'");';
					$ret = mysql_query($sql, $dbh);
					*/


					return $uploadFile;
				}
			}
			else {
				if ($_FILES['Filedata']['error']) {
					return $_FILES['Filedata']['error'];
				}
			}
		}
	}
}

// /////////////////// HELPER FUNCTIONS
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
function fixFileName($string) {
	$string = strtr ( $string, "ÀÁÂÃÄÅàáâãäåÒÓÔÕÖØòóôõöøÈÉÊËèéêëÇçÌÍÎÏìíîïÙÚÛÜùúûüÿÑñ", "AAAAAAaaaaaaOOOOOOooooooEEEEeeeeCcIIIIiiiiUUUUuuuuyNn");
	for($i=0 ; $i < strlen($string); $i++) {
		if(!ereg("([0-9A-Za-z_\.])",$string[$i])) {
			$string[$i] = "_";
		}
	}

	return $string;
}
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
function createDiretoryStructure($dir){
   $arr = explode('\\',$dir);
   $j=0;
   for($i=0; $i < count($arr); $i++)
     if($arr[$i]) $new_arr[$j++] = $arr[$i];
   //---------------------------------------------//

   $arr = $new_arr;
   $end = count($arr);

   $path="";
   for($i=0; $i < $end; $i++){
       if ($path=="") {
           $path=$arr[$i];
       } else {
           $path .= "\\".$arr[$i];
       }
     if(!file_exists($path)) {
       if(!@mkdir($path,0755)) {
         $fail = TRUE;
         break;
       }
     }
   }

   if($fail) return FALSE; else return TRUE;
 }

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
function moveFileToDestination($temporal,$futuro){


	$arch=explode("uploads/",$futuro);
	$_SESSION['last_upload_file']="uploads/".$arch[1];
    if (GD_LIB){
		
        if ((isset($_REQUEST['p_width']) && $_REQUEST['p_width']<>'') || (isset($_REQUEST['p_height']) && $_REQUEST['p_height']<>''))
          $new_img = new image($temporal, $futuro);
        if (((isset($_REQUEST['p_width']) && $_REQUEST['p_width']<>'') || (isset($_REQUEST['p_height']) && $_REQUEST['p_height']<>'')) && $new_img->isImage()){
//echo "<br/><br/>AKI MERDA:".$_REQUEST['p_width'].$_REQUEST['p_height'];
			
	        $new_img->size_width($_REQUEST['p_width'],$_REQUEST['p_height']);
			$new_img->size_height($_REQUEST['p_width'],$_REQUEST['p_height']);
			$new_img->save( $futuro);
			
			return true;
        }
        else{
			if(@move_uploaded_file($temporal, $futuro)){
				@chmod ($futuro,"0444");
				
				return true;
			} 
			else 
				
				return false;
		}
    }
	else{
		
		error_reporting(E_ALL);
		/*
		$ret=move_uploaded_file($temporal,$futuro);
		set_error_handler("miGestorErrores");
		return true;*/
        if(move_uploaded_file($temporal,$futuro)){
            
			
			
			chmod ($futuro,"0444");
			return true; 
        } 
        else {
			
			
            return false;
		}
			
    }
        
  }
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
function miGestorErrores($num_err, $cadena_err, $archivo_err, $linea_err){
	
}
function generateFileName2($dir,$file,$i=0){
	    if(file_exists($dir.$file))
		{
			$trozos=explode(".",$file);
			array_pop($trozos);
			$nom=implode(".",$trozos);
			$trozos2=explode(".",$file);
			$ext=$trozos2[count($trozos2)-1];
			if(file_exists($dir."/".$nom.".".$i.".".$ext))
			{
			  $dst_file_name=generateFileName2($dir,$file,$i+1);
			}
			else
			{
			  $dst_file_name=$nom.".".$i.".".$ext;
			}
		}
		else{
			$dst_file_name=$file;
		}
    return $dst_file_name;
  }
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
function logejar($string) {
  $wh = fopen("/tmp/log_editora.txt", 'a');
    $string=time().": $string".chr(13).chr(10);
    fwrite($wh, $string);
    fclose($wh);
}

class image
{
    var $img;
    var $isImg;

    function image($imgfile, $originalName)
    {
//echo "UUUU".$imgfile;
        //detect image format
        $this->img["format"]=str_replace(".*\.(.*)$","\\1",$originalName);
        $this->img["format"]=strtoupper($this->img["format"]);
	$this->isImg = 1;
        if ($this->img["format"]=="JPG" || $this->img["format"]=="JPEG") {
            //JPEG
            $this->img["format"]="JPEG";
            $this->img["src"] = ImageCreateFromJPEG ($imgfile);
        } elseif ($this->img["format"]=="PNG") {
            //PNG
            $this->img["format"]="PNG";
            $this->img["src"] = ImageCreateFromPNG ($imgfile);
        } elseif ($this->img["format"]=="GIF") {
            //GIF
            $this->img["format"]="GIF";
            $this->img["src"] = ImageCreateFromGIF ($imgfile);
        } elseif ($this->img["format"]=="WBMP") {
            //WBMP
            $this->img["format"]="WBMP";
            $this->img["src"] = ImageCreateFromWBMP ($imgfile);
        } else {
            //DEFAULT
	    $this->isImg = 0;
        }
        @$this->img["lebar"] = imagesx($this->img["src"]);
        @$this->img["tinggi"] = imagesy($this->img["src"]);
        //default quality jpeg
        $this->img["quality"]=75;
    }

    function isImage ()
    {
       return $this->isImg;
    }

    function size_height($width, $height)
    {
        //height
	if (!isset($height) || $height=='')
	{
            $ratio = 1;
            if (isset($width) || $width<>'')
                $ratio = $width/$this->img["lebar"];
            $height = round($this->img["tinggi"] * $ratio,0);
	}

        $this->img["tinggi_thumb"]=$height;
        @$this->img["lebar_thumb"] = ($this->img["tinggi_thumb"]/$this->img["tinggi"])*$this->img["lebar"];
    }

    function size_width($width, $height)
    {
        //width
	if (!isset($width) || $width=='')
	{
            $ratio = 1;
            if (isset($height) || $height<>'')
                $ratio = $height/$this->img["tinggi"];
            $width = round($this->img["lebar"] * $ratio,0);
	}

        $this->img["lebar_thumb"]=$width;
        @$this->img["tinggi_thumb"] = ($this->img["lebar_thumb"]/$this->img["lebar"])*$this->img["tinggi"];
    }

    function size_auto($size=100)
    {
        //size
        if ($this->img["lebar"]>=$this->img["tinggi"]) {
            $this->img["lebar_thumb"]=$size;
            @$this->img["tinggi_thumb"] = ($this->img["lebar_thumb"]/$this->img["lebar"])*$this->img["tinggi"];
        } else {
            $this->img["tinggi_thumb"]=$size;
            @$this->img["lebar_thumb"] = ($this->img["tinggi_thumb"]/$this->img["tinggi"])*$this->img["lebar"];
        }
    }

    function jpeg_quality($quality=75)
    {
        //jpeg quality
        $this->img["quality"]=$quality;
    }

    function show()
    {
        //show thumb
        @Header("Content-Type: image/".$this->img["format"]);

        /* change ImageCreateTrueColor to ImageCreate if your GD not supported ImageCreateTrueColor function*/
        $this->img["des"] = ImageCreateTrueColor($this->img["lebar_thumb"],$this->img["tinggi_thumb"]);
            @imagecopyresampled ($this->img["des"], $this->img["src"], 0, 0, 0, 0, $this->img["lebar_thumb"], $this->img["tinggi_thumb"], $this->img["lebar"], $this->img["tinggi"]);

        if ($this->img["format"]=="JPG" || $this->img["format"]=="JPEG") {
            //JPEG
            imageJPEG($this->img["des"],"",$this->img["quality"]);
        } elseif ($this->img["format"]=="PNG") {
            //PNG
            imagePNG($this->img["des"]);
        } elseif ($this->img["format"]=="GIF") {
            //GIF
            imageGIF($this->img["des"]);
        } elseif ($this->img["format"]=="WBMP") {
            //WBMP
            imageWBMP($this->img["des"]);
        }
    }

    function save($save="")
    {
        //save thumb
        if (empty($save)) $save=strtolower("./thumb.".$this->img["format"]);
        /* change ImageCreateTrueColor to ImageCreate if your GD not supported ImageCreateTrueColor function*/
        $this->img["des"] = ImageCreateTrueColor($this->img["lebar_thumb"],$this->img["tinggi_thumb"]);
            @imagecopyresampled ($this->img["des"], $this->img["src"], 0, 0, 0, 0, $this->img["lebar_thumb"], $this->img["tinggi_thumb"], $this->img["lebar"], $this->img["tinggi"]);

        if ($this->img["format"]=="JPG" || $this->img["format"]=="JPEG") {
            //JPEG
            imageJPEG($this->img["des"],"$save",$this->img["quality"]);
        } elseif ($this->img["format"]=="PNG") {
            //PNG
            imagePNG($this->img["des"],"$save");
        } elseif ($this->img["format"]=="GIF") {
            //GIF
            imageGIF($this->img["des"],"$save");
        } elseif ($this->img["format"]=="WBMP") {
            //WBMP
            imageWBMP($this->img["des"],"$save");
        }
    }
} 
?>