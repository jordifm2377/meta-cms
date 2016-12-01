<?php

class ImageCloner extends model
{
	var $img;
	var $isImg;
	var $dst_dir;
	var $error;
	
	function __construct ($src_image)
	{
		$ymd =date('Ymd');
		$desti=DIR_UPLOADS.$ymd;
		$this->dst_dir=$desti;
		$this->createDiretoryStructure();
		$this->parse_image($src_image);
		if (!$isImg) return false;
	}
	
	function save_image_attribute ($inst_id, $atri_id, $value, $width, $height)
	{
	  $sql="select count(*) num from omp_values where inst_id=$inst_id and atri_id=$atri_id and type='I'";
	  $row=parent::get_one($sql);
		if ($row['num']==0)
		{// hem d'insertar, no hi era
		  $sql="insert into omp_values (inst_id, atri_id, text_val, img_info) values($inst_id, $atri_id, '".$value."','".$width.'.'.$height."')";
			parent::insert_one($sql);		  
		}
		else
		{// hem de fer update
		  $sql="update omp_values set text_val='".$value."', img_info='".$width.'.'.$height."'";
			parent::execute($sql);
		}
	}
	
	function clone_image ($dst_filename, $width, $height)
	{
	  //echo 'clone_image TBD '.$dst_filename.' '.$width.' '.$height;
		$this->size_width_height($width,$height);
		$this->save($this->dst_dir.'/'.$dst_filename);
		return (str_replace(DIR_APLI.'/', '', $this->dst_dir).'/'.$dst_filename);
	}

	function fixFileName($string) 
	{
		$string = strtr ( $string, "�����������������������������������������������������", "AAAAAAaaaaaaOOOOOOooooooEEEEeeeeCcIIIIiiiiUUUUuuuuyNn");
		for($i=0 ; $i < strlen($string); $i++) 
		{
			if(!ereg("([0-9A-Za-z_\.])",$string[$i])) 
			{
				$string[$i] = "_";
			}
		}

		return $string;
	}	
	
	function createDiretoryStructure() 
	{
		$arr = explode('\\', $this->dst_dir);
		$j=0;
		for($i=0; $i < count($arr); $i++)
			if($arr[$i]) $new_arr[$j++] = $arr[$i];
		//---------------------------------------------//

		$arr = $new_arr;
		$end = count($arr);

		$path="";
		for($i=0; $i < $end; $i++)
		{
			if ($path=="") 
			{
				$path=$arr[$i];
			} 
			else 
			{
				$path .= "\\".$arr[$i];
			}
		  if(!file_exists($path)) 
			{
			  if(!@mkdir($path,0755)) 
				{
				  $fail = TRUE;
				  break;
			  }
		  }
		}

		if($fail) return FALSE; else return TRUE;
	}
	
	function insert_update_image($value, $inst_id, $info) {
		$sql = "SELECT text_val FROM omp_values WHERE inst_id = '{$inst_id}' and atri_id='{$info['id']}';";
			$ret = parent::get_one($sql);
			//$this->pr_sql();
			if(empty($ret)){
				$sql = "INSERT INTO omp_values (text_val, inst_id, atri_id) 
								VALUES ('".mysql_real_escape_string($value, $this->dbh)."', {$inst_id}, {$info['id']});";
				$ret = $this->insert_one($sql);
				//$this->pr_sql();
			} else
			{
				$sql = "UPDATE omp_values SET text_val='{$value}'
						WHERE inst_id = '{$inst_id}' and atri_id='{$info['id']}'";
				$ret = $this->update($sql);
				//$this->pr_sql();
			}
		return $ret;
	}

	function busca_idiomes()
	{
		$sql ='select language as lang from omp_attributes where language!="ALL" group by language';
		$ret=parent::get_data($sql);

		$idiomes=array();
		foreach($ret as $row)
			$idiomes[]=$row['lang'];

		return $idiomes;
	}	
	
	//Al crear o editar una instancia
	function updateCache($inst_id) {

		$idiomes=$this->busca_idiomes();
		
		$ok = false;
		foreach($idiomes as $idioma) {
			$cache_xml_r = $this->getInstanceInfo($inst_id, $idioma, 'cache', 'R', $_SESSION['rol_id']);
			$cache_xml_d = $this->getInstanceInfo($inst_id, $idioma, 'cache', 'D', $_SESSION['rol_id']);
			$search_field= $this->search_texts($inst_id,$idioma);

			$sql_cache='insert omp_instances_cache (inst_id,language,xml_cache_r,xml_cache_d,search_field) values ('.$inst_id.', "'.$idioma.'", "'.mysql_real_escape_string($cache_xml_r,$this->dbh).'", "'.mysql_real_escape_string($cache_xml_d,$this->dbh).'", "'.mysql_real_escape_string($search_field,$this->dbh).'");';
			$ret_cache=parent::insert_one($sql_cache);
			if (!$ret_cache) {
				$sql_cache='update omp_instances_cache set xml_cache_r="'.mysql_real_escape_string($cache_xml_r,$this->dbh).'",xml_cache_d="'.mysql_real_escape_string($cache_xml_d,$this->dbh).'",search_field="'.mysql_real_escape_string($search_field,$this->dbh).'" where inst_id="'.$inst_id.'" and language="'.$idioma.'";';
				//$ret_cache=parent::update($sql_cache);
				//TENIA SOLAPAMENT ENTRE carrega/Model.php i models/model.php, i hem quedu amb les funcions de model.php
				$ret_cache=parent::update_one($sql_cache);
				if (!$ret_cache) 
					echo $sql_cache.chr(10).chr(13);
				else $ok = true;
			}else $ok = true;
		}
		
		return $ok;
	}	
	
	function getInstanceInfo($p_instance_id, $p_lang, $p_relacio, $p_detail, $usuari) {

		$res="";
		$sql="select i.key_fields key_fields, i.status status, i.publishing_begins publi_b, i.publishing_ends publi_e, i.class_id type, i.default_draw, i.creation_date, i.update_date, c.name c_nom, c.id c_id
		from omp_instances i, omp_classes c
		where i.id = '".$p_instance_id."' and c.id = i.class_id;";
		$sql2="select a.id a_id, a.tag tag, a.type type, v.text_val val_text, v.date_val val_data, v.num_val val_num, v.img_info, ca.id ca_id
		from omp_instances i, omp_attributes a, omp_values v, omp_class_attributes ca
		where i.id = '".$p_instance_id."'
		and (a.language = '".$p_lang."' or a.language = 'ALL')
		and v.inst_id = i.id
		and v.atri_id = a.id
		and a.id = ca.atri_id
		and i.class_id = ca.class_id";

		if ($p_detail == 'R') $sql2.=" and ca.detail = 'N';";

		$ret = mysql_query($sql,$this->dbh);
		$ret2 = mysql_query($sql2,$this->dbh);

		$lanice=$this->get_nice_from_id ($p_instance_id, $p_lang);
		$erlang='';
		if ($this->MULTI_LANG == 1) $erlang='/'.$p_lang;

		$row = @mysql_fetch_array($ret, MYSQL_ASSOC);

		if (!$row) print_r('error al obtenir la instancia: '.$p_instance_id.' '.$p_lang.' '.$p_relacio.' '.$p_detail.' '.$usuari);

		$res.='<pub_date_b>'.$row['publi_b'].'</pub_date_b>'.chr(13).chr(10);
		$res.='<pub_date_e>'.$row['publi_e'].'</pub_date_e>'.chr(13).chr(10);
		$res.='<auto_link>'.chr(13).chr(10);
			$res.='<link name="simple">/'.$p_lang.'/'.$lanice.'</link>'.chr(13).chr(10);
			//$res.='<link name="simple">/'.$lanice.'</link>'.chr(13).chr(10);
		$res.='</auto_link>'.chr(13).chr(10);


		$res.='<instance id="'.$p_instance_id.'" status="'.$row['status'].'" tipus="'.$row['type'].'" lang="'.$p_lang.'" paint="'.$row['default_draw'].'" rel="'.$p_relacio.'" class_name="'.$row['c_nom'].'" nice="'.$lanice.'" creation="'.$row['creation_date'].'" publishing="'.$row['publi_b'].'" update="'.$row['update_date'].'">'.chr(13).chr(10);
		if(isset ($this->rol_id) && $this->rol_id !='' && $row['type']!="" && $p_instance_id!="") {
			$res.="<edit>/admin/view_instance?p_class_id=".$row['type']."&amp;p_inst_id=$p_instance_id</edit>";
		}

		while ($row2 = @mysql_fetch_array($ret2, MYSQL_ASSOC)) {
			if ($row2['type'] == 'D') {
				$res.='<'.$row2['tag'].' type="'.$row2['type'].'">'.$this->mysql_to_date($row2['val_data']).'</'.$row2['tag'].'>'.chr(13).chr(10);
			}
			elseif ($row2['type'] == 'N') $res.='<'.$row2['tag'].' type="'.$row2['type'].'"><![CDATA['.$row2['val_num'].']]></'.$row2['tag'].'>'.chr(13).chr(10);
			elseif ($row2['type'] == 'L') {
				if ($usuari==-1) {
					require_once($_SERVER['DOCUMENT_ROOT'].'/utils/lookup_utils.php');
					$res.='<'.$row2['tag'].' type="'.$row2['type'].'" num_val="'.$row2['val_num'].'" value="'.$this->front_get_true_value($row2['val_num'], $p_lang).'"><![CDATA['.$this->front_get_value($row2['val_num'], $p_lang).']]></'.$row2['tag'].'>'.chr(13).chr(10);
				}
				else {
					$res.='<'.$row2['tag'].' type="'.$row2['type'].'" num_val="'.$row2['val_num'].'" value="'.$this->get_true_value($row2['val_num'], $p_lang).'"><![CDATA['.$this->get_value2($row2['val_num'], $p_lang).']]></'.$row2['tag'].'>'.chr(13).chr(10);
				}
			}
			elseif ($row2['type'] == 'T') {
				$new_val=$row2['val_text'];
				$res.='<'.$row2['tag'].' type="'.$row2['type'].'"><![CDATA['.$new_val.']]></'.$row2['tag'].'>'.chr(13).chr(10);
			}
			elseif ($row2['type'] == 'A') {
				//$new_val=nl2br($row2['val_text']);
				$new_val=$row2['val_text'];
				$res.='<'.$row2['tag'].' type="'.$row2['type'].'"><![CDATA['.$new_val.']]></'.$row2['tag'].'>'.chr(13).chr(10);
			}
			elseif ($row2['type'] == 'M') {
				$pos=explode("@",$row2['val_text']);
				$new_val=explode(":",$pos[0]);
				$res.='<'.$row2['tag'].' type="'.$row2['type'].'"><lat><![CDATA['.$new_val[0].']]></lat><long><![CDATA['.$new_val[1].']]></long></'.$row2['tag'].'>'.chr(13).chr(10);
			}
			elseif ($row2['type'] == 'I') {
				$wh=$row2['img_info'];
				$swh=(string)$wh;
				$swh=str_replace(',', '.', $swh);
				$ii=explode('.', $swh);
				$img_url=$row2['val_text'];
				if (substr($img_url, 0, 7)=='uploads') $img_url='/'.$img_url;
				$res.='<'.$row2['tag'].' width="'.$ii[0].'" height="'.$ii[1].'" type="'.$row2['type'].'"><![CDATA['.str_replace(chr(10), "<br />", $img_url).']]></'.$row2['tag'].'>'.chr(13).chr(10);
			}
			elseif ($row2['type']== 'C') {
				$res.='<'.$row2['tag'].' type="'.$row2['type'].'">';
				$res.='<![CDATA[';
				$fn = create_function('$lg, $inst_id',$row2['val_text']);
				$res.= $fn($p_lang, $_SESSION['actual_inst']);
				$res.=']]></'.$row2['tag'].'>'.chr(13).chr(10);
			}
			elseif ($row2['type'] == 'F') {
				$arxiu=DIR_APLI.'/'.$row2['val_text'];
				if (file_exists($arxiu)) $mida_arxiu=round((filesize($arxiu)/1024),1);
				else $mida_arxiu=0;
				$img_url=$row2['val_text'];
				if (substr($img_url, 0, 7)=='uploads') $img_url='/'.$img_url;
				$res.='<'.$row2['tag'].' type="'.$row2['type'].'" mida="'.$mida_arxiu.'"><![CDATA['.str_replace(chr(10), "<br />", $img_url).']]></'.$row2['tag'].'>'.chr(13).chr(10);
			}
			elseif ($row2['type'] == 'G') {
				$img_url=$row2['val_text'];
				if (substr($img_url, 0, 7)=='uploads') $img_url='/'.$img_url;
				$res.='<'.$row2['tag'].' type="'.$row2['type'].'"><![CDATA['.$img_url.']]></'.$row2['tag'].'>'.chr(13).chr(10);
			}
			else {
				$new_val=$row2['val_text'];
				if (function_exists('extract_'.$row2['ca_id'])) {
					$fe = 'extract_'.$row2['ca_id'];
					$new_val = $fe($row2['val_text']);
				}
				else {
					$new_val = $this->extract_default($row2['val_text']);
				}
				$res.='<'.$row2['tag'].' type="'.$row2['type'].'"><![CDATA['.$new_val.']]></'.$row2['tag'].'>'.chr(13).chr(10);
			}
		}
		$res.='</instance>'.chr(13).chr(10);

		return $res;
	}
	

 	function generateFileName ($file, $i=0) 
	{
		//echo '***'.$file.'***';
	  $file=$this->fixFileName($file);
		//echo "existeix l'arxiu?: (".$this->dst_dir."/".$file.")<br/>";
		if(file_exists($this->dst_dir."/".$file)) 
		{
			//echo "Si, hem trobat un arxiu amb el mateix nom<br/>";
			$trozos=explode(".",$file);
			array_pop($trozos);
			$nom=implode(".",$trozos);
			$trozos2=explode(".",$file);
			$ext=$trozos2[count($trozos2)-1];
			//echo "probarem de de guardar l'arxiu com a ".$this->dst_dir."/".$nom.".".$i.".".$ext."<br/>";
			if(file_exists($this->dst_dir."/".$nom.".".$i.".".$ext)) {
				//echo "Ja existeix, provem amb un altre<br/>";
				$dst_file_name=$this->generateFileName($file,$i+1);
			}
			else {
				$dst_file_name=$nom.".".$i.".".$ext;
			}
		}
		else {
			//echo "no, no existeix<br/>";
			$dst_file_name=$file;
		}
		// echo "el nom de l'arxiu es bo: ".$dst_file_name."<br/>";

		return $dst_file_name;
	}	
	
	function parse_image($imgfile)
	{
		//echo "UUUU".$imgfile;
		//detect image format
		$this->img["file_name"]=explode('/',$imgfile);
		$this->img["file_name"]=$this->img["file_name"][count($this->img["file_name"])-1];
		
		$this->img["format"]=explode('.',$imgfile);
		$this->img["format"]=strtoupper($this->img["format"][count($this->img["format"])-1]);
		$this->isImg = 1;
		if ($this->img["format"]=="JPG" || $this->img["format"]=="JPEG") {
				//JPEG
				$this->img["format"]="JPEG";
				$this->img['fullpath']=$imgfile;
				$this->img["src"] = ImageCreateFromJPEG ($imgfile);
		}
		elseif ($this->img["format"]=="PNG") {
				//PNG
				$this->img["format"]="PNG";
				$this->img['fullpath']=$imgfile;
				$this->img["src"] = ImageCreateFromPNG ($imgfile);
		}
		elseif ($this->img["format"]=="GIF") {
				//GIF
				$this->img["format"]="GIF";
				$this->img['fullpath']=$imgfile;
				$this->img["src"] = ImageCreateFromGIF ($imgfile);
		}
		elseif ($this->img["format"]=="WBMP") {
				//WBMP
				$this->img["format"]="WBMP";
				$this->img['fullpath']=$imgfile;
				$this->img["src"] = ImageCreateFromWBMP ($imgfile);
		}
		else {
			//DEFAULT
			$this->isImg = 0;
		}
		
		@$this->img["lebar"] = imagesx($this->img["src"]);
		@$this->img["tinggi"] = imagesy($this->img["src"]);
		//default quality jpeg
		$this->img["quality"]=100;
	}

	function isImage ()
	{
		return $this->isImg;
	}

	//Unificar la funci� de les mides en una sola
	function size_width_height($width, $height) 
	{
		if ($width!='' && $width!=0 && $height!='' && $height!=0) 
		{
			$this->img["lebar_thumb"]=$width;
			//Si la imatge es m�s baixa de la que s'espera, no fem canvis, apliquem el aspect ratio i prou
			if ($this->img["tinggi"] >= $height) {
				$this->img["tinggi_thumb"]=$height;
				$this->img["src_width_start"]=0;
				$this->img["src_height_start"]=($this->img["tinggi"] - $height)/2;
			}
			//La imatge rebuda es m�s alta de la esperada. Calculem on hem de comen�ar a tallar.
			else {
				$this->img["tinggi_thumb"]=$this->img["lebar"];
				$this->img["src_width_start"]=0;
				$this->img["src_height_start"]=0;
			}
		}
		elseif ($width!='' && $width!=0) 
		{
			$this->img["src_width_start"]=0;
			$this->img["src_height_start"]=0;
			$this->img["lebar_thumb"]=$width;
			@$this->img["tinggi_thumb"] = ($this->img["lebar_thumb"]/$this->img["lebar"])*$this->img["tinggi"];
		}
		elseif ($height!='' && $height!=0) {
			echo "aquest".$width.' '.$height;
			$this->img["src_width_start"]=0;
			$this->img["src_height_start"]=0;
			$this->img["tinggi_thumb"]=$height;
			@$this->img["lebar_thumb"] = ($this->img["tinggi_thumb"]/$this->img["tinggi"])*$this->img["lebar"];
		}
	}

	function size_auto($size=100) 
	{//size
		if ($this->img["lebar"]>=$this->img["tinggi"]) {
			$this->img["lebar_thumb"]=$size;
			@$this->img["tinggi_thumb"] = ($this->img["lebar_thumb"]/$this->img["lebar"])*$this->img["tinggi"];
		}
		else {
			$this->img["tinggi_thumb"]=$size;
			@$this->img["lebar_thumb"] = ($this->img["tinggi_thumb"]/$this->img["tinggi"])*$this->img["lebar"];
		}
	}

	function jpeg_quality($quality=100) 
	{//jpeg quality
		$this->img["quality"]=$quality;
	}

	function show() {//show thumb
		@Header("Content-Type: image/".$this->img["format"]);

		/* change ImageCreateTrueColor to ImageCreate if your GD not supported ImageCreateTrueColor function*/
		$this->img["des"] = ImageCreateTrueColor($this->img["lebar_thumb"],$this->img["tinggi_thumb"]);
		@imagecopyresampled ($this->img["des"], $this->img["src"], 0, 0, $this->img["src_width_start"], $this->img["src_height_start"], floor($this->img["lebar_thumb"]), floor($this->img["tinggi_thumb"]), $this->img["lebar"], $this->img["tinggi"]);

		if ($this->img["format"]=="JPG" || $this->img["format"]=="JPEG") {//JPEG
			imageJPEG($this->img["des"],"",$this->img["quality"]);
		}
		elseif ($this->img["format"]=="PNG") {//PNG
			imagePNG($this->img["des"]);
		} 
		elseif ($this->img["format"]=="GIF") {//GIF
			imageGIF($this->img["des"]);
		} 
		elseif ($this->img["format"]=="WBMP") {//WBMP
			imageWBMP($this->img["des"]);
		}
	}

	function save($save="") 
	{//save thumb
		if (empty($save)) $save=strtolower("./thumb.".$this->img["format"]);
		/* change ImageCreateTrueColor to ImageCreate if your GD not supported ImageCreateTrueColor function*/

		$this->img["des"] = ImageCreateTrueColor($this->img["lebar_thumb"],$this->img["tinggi_thumb"]);
		imagecopyresampled ($this->img["des"], $this->img["src"], 0, 0, $this->img["src_width_start"], $this->img["src_height_start"], floor($this->img["lebar_thumb"]), floor($this->img["tinggi_thumb"]), $this->img["lebar"], $this->img["tinggi"]);

		if ($this->img["format"]=="JPG" || $this->img["format"]=="JPEG") {//JPEG
			imageJPEG($this->img["des"],"$save",$this->img["quality"]);
		} 
		elseif ($this->img["format"]=="PNG") {//PNG
			imagePNG($this->img["des"],"$save");
		} 
		elseif ($this->img["format"]=="GIF") {//GIF
			imageGIF($this->img["des"],"$save");
		} 
		elseif ($this->img["format"]=="WBMP") {//WBMP
			imageWBMP($this->img["des"],"$save");
		}
	}
} 