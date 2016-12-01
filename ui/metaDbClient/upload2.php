<?php

session_start();

header("Cache-Control: no-cache, must-revalidate");
header("Cache-control: private");

require_once($_SERVER['DOCUMENT_ROOT'].'/admin/conf/ompinfo.php');
require_once(DIR_APLI_ADMIN.'/upload_class.php');
require_once(DIR_APLI_ADMIN.'/models/security.php');

$sc=new security();	
if ($sc->testSession()==0) 
{
echo('<script type="text/javascript">
	parent.document.location="/admin";
</script>');
$_SESSION['last_page']='/admin';
die;
}

$upload = new UPLOAD_FILES();
$p_field=$_REQUEST['p_field'];


if($_FILES){
	foreach($_FILES as $key => $file) 
	{
		//$nom_fitxer=$upload->fixFileName($file["name"]);
		////echo $nom_fitxer;
		$upload->set("name", $file["name"]); // Uploaded file name.
		$upload->set("type",$file["type"]); // Uploaded file type.
		$upload->set("tmp_name",$file["tmp_name"]); // Uploaded tmp file name.
		$upload->set("error",$file["error"]); // Uploaded file error.
		$upload->set("size",$file["size"]); // Uploaded file size.
		$upload->set("fld_name",$key); // Uploaded file field name.
		$upload->set("max_file_size",4096000000000); // Max size allowed for uploaded file in bytes = 40 KB.
		//$upload->set("supported_extensions",array("gif" => "image/gif" ,"jpg" => "image/pjpeg","jpeg" => "image/pjpeg" ,"png" => "image/x-png")); // Allowed extensions and types for uploaded file.
		$upload->set("randon_name",TRUE); // Generate a unique name for uploaded file? bool(true/false).
		$upload->set("replace",TRUE); // Replace existent files or not? bool(true/false).
		$upload->set("file_perm",0444); // Permission for uploaded file. 0444 (Read only).

		$upload->set("p_width",$_REQUEST['p_width']);
		$upload->set("p_height",$_REQUEST['p_height']);

		$ymd =date('Ymd');
		$desti=DIR_UPLOADS.$ymd;
		$desti2=URL_UPLOADS.$ymd."/".$upload->checkZipType();
		//echo $desti;
		$upload->set("dst_dir",$desti); // Destination directory for uploaded files.
		$upload->createDiretoryStructure();
		$result = $upload->moveFileToDestination();	// $result = bool (true/false). Succeed or not.
		//echo "file destination: ".$upload->get('name')."<br/>";
		$nom_fitxer=$upload->get('name');
		//echo "->".$upload->generateFileName2($nom_fitxer);
	}
}
//echo "<br/>F: ".$nom_fitxer;g
echo('<script type="text/javascript" src="jss/jquery.js"> </script>');
echo('<script type="text/javascript">
	parent.document.'.$p_field.'.value="'.$desti2.$nom_fitxer.'";
	$(parent.document.getElementById("fosc_upload")).hide();
	$(parent.document.getElementById("jsupload")).remove();</script>');
?>