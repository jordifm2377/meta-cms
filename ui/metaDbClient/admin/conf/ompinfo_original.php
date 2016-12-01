<?php
/**
 * Omp info, variable globals
 *
 * @version 3.1
 * @copyright 2004, omatech
 * Atributs CSS a definir
 * omp_field, per pintar els camps dels formularis
 * omp_caption, per pintar les labels dels camps dels formularis
 * omp_mandatory, per pintar l'estil del texte d'indicacio de obligatorietat del camp, habitualment un "*"
 * 
 * Explicacio dels tipus (abaix de tot):
 **/
	if ((strpos($_SERVER['HTTP_HOST'],'oma.lan')!==false || strpos($_SERVER['HOSTNAME'],'devel')!==false)) {// entorn de devel
		define("dbhost","dbhost");
		define("dbuser","root");
		define("dbpass",'$$omaROOT');
		define("dbname","auditori");

		define("ERROR_LEVEL",7);
		define("DIR_APLI", "/var/www/auditori");
		define("DIR_APLI_ADMIN", "/var/www/auditori/admin");
		define("DOMAIN_SERVER","oma.lan");
		define("IP_SERVER","test.".DOMAIN_SERVER);
		//define("GOOGLE_MAPS_API_KEY", "ABQIAAAARrURHD1FsXsbzDN_kZ7GKxSo7TTzlc7XQ6-3Ul_1KUlQzsps-BT4eofMfE4fMSioWIHM4QS4L9BDVg");
		define("URL_APLI","http://auditori.oma.lan");
	}

	$array_langs = array('ca','en','es');

	define("INST_PERM", 1);
	define("USERINSTANCES", 1000);
	define("SUPERROLID", 1);
	define("GD_LIB", TRUE);
	define("APP_BASE", "/admin");
	define("CSSPREFIX","csss/");
	define("IMGPREFIX","/images/");
	define("DIR_UTILS", "utils/");
	define("DIR_UPLOADS", DIR_APLI."/uploads/");
	define("DIR_LANGS", "langs/");
	define("DIR_VIEWS", "views/");
	define("DIR_ACCIONS", "accions/");
	define("URL_APPLICATION","http://".IP_SERVER."/");
	define("URL_UPLOADS","uploads/");
	define("URL_PREVIEW_PREFIX", "http://".IP_SERVER."/");
	define("URL_STYLES","http://".IP_SERVER."/styles/");
	define("MAIN_OBJECT", 1);
	define("MULTI_LANG", 1);

	define("COPYR_NOTICE",'(c) 2010 por <a href="http://'.IP_SERVER.'/controller.php" target="_blank">OMA Technologies</a>');
	define("STANDARD_DATE_FORMAT", "%d/%m/%Y %T");
	define("ROWS_PER_PAGE", 40);
	define("TABLE_MAX_LENGTH", "640");
	define("TD_MAX_LENGTH","210");
	define("FIELD_DEFAULT_LENGTH", 33);
	define("TEXTAREA_DEFAULT_LENGTH", 42);
	define("TEXTAREA_DEFAULT_HEIGHT", 15);
	define("FORM_OPEN_TABLE",'<table width="100%" border="0" cellspacing="0" cellpadding="0">');
	define("FORM_OPEN_TD","<td width=\"".TD_MAX_LENGTH."\">");
	define("URL_CSS",APP_BASE.CSSPREFIX."editora.css");
	define("CONTAINER_EDITORA", DIR_VIEWS."container.php");
	define("ICONO_UPLOAD",APP_BASE.IMGPREFIX."adjuntar.gif");
	define("ICONO_CALENDARIO",APP_BASE.IMGPREFIX."calendari.gif");
	define("ICONO_CALENDARIO2",APP_BASE.IMGPREFIX."calendari2.gif");
	define("ICONO_LINK",APP_BASE.IMGPREFIX."calendar.gif");
	define("ICONO_BROWSE_IMAGE",APP_BASE.IMGPREFIX."lupa.gif");
	define("ICONO_STAR",APP_BASE.IMGPREFIX."favorito.gif");
	define("ICONO_DELETE",APP_BASE.IMGPREFIX."eliminar.gif");
	define("ICONO_PREVIEW",APP_BASE.IMGPREFIX."preview_mini.gif");
	define("ICONO_EDIT",APP_BASE.IMGPREFIX."editar.gif");
	define("ICONO_GREEN",APP_BASE.IMGPREFIX."bolapublicat.gif");
	define("ICONO_RED",APP_BASE.IMGPREFIX."boladespublicat_2.gif");
	define("ICONO_YELLOW",APP_BASE.IMGPREFIX."boladespublicat.gif");
	define("ICONO_PERM",APP_BASE.IMGPREFIX."user.gif");
	define("ICONO_CLONE",APP_BASE.IMGPREFIX."clonesheep.jpg");


	define("SHOWTWIT", FALSE);
	define("TWITUSER", "omatechproves");
	define("TWITPASS", "blau4tutu");
	//Upload_type values:
	//- popup
	//- flash
	define("UPLOAD_TYPE","popup");
	define("UPLOAD_HTML_CHUNK_PRE",'<a href="javascript:show_upload(\'');
	define("UPLOAD_HTML_CHUNK_PRE2",'<a href="javascript:show_upload(\'');
	define("UPLOAD_HTML_CHUNK_POST",'\');"><img class="icon" src="'.ICONO_UPLOAD.'" border="0" title="Seleccionar archivo"></a>');
	define("UPLOAD_HTML_CHUNK_POST2",'<img class="icon" src="'.ICONO_UPLOAD.'" border="0" title="Seleccionar archivo"></a>');

	define("CALENDAR_HTML_CHUNK_PRE",'<a href="javascript:show_Calendario(\'');
	define("CALENDAR_HTML_CHUNK_POST",'\');"><img src="'.ICONO_CALENDARIO.'" border="0" title="Seleccionar fecha"></a>');
	define("LINK_HTML_CHUNK_PRE",'<a href="controller.php?rp_action=new_link&rel_id=');
	define("LINK_HTML_CHUNK_POST",'"><img src="'.ICONO_LINK.'" border="0" title="Nueva relación"></a>');
	define("LOOKUP_OPTIONAL_CAPTION","-- Ninguno --");
	$dbh=get_db_handler();
  
	function get_db_handler() {
		$dbh = mysql_connect(dbhost, dbuser, dbpass, true);

		if (!$dbh) {
			$err=mysql_error(  );
			die( "Error a la base de dades: $err" );
		}
		else {
			$sqlini="USE ".dbname;
			$result = mysql_query($sqlini, $dbh);

			$sqlencoding = "SET NAMES 'utf8'";
			$ret = mysql_query($sqlencoding, $dbh);
			return $dbh;
		}
	}
  
/*
	*
	*
	S -> T (String curt)
	A -> T (Text Area)
	I -> T (Imatge URL)
	F -> T (Fitxer URL)
	G -> T (Fitxer Flash)
	U -> T (URL)
	X -> T (XML)
	D -> D (Data)
	N -> N (Number)
	L -> N (Lookup)
	*
	*
*/  
?>
