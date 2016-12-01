<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="keywords" content="" />
    <meta name="description" content="" />
    <meta http-equiv="Pragma" content="no-cache" />
    <meta http-equiv="Cache-Control" content="no-cache" />

  <link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" />
  <script type="text/javascript" src="http://code.jquery.com/jquery-1.9.1.js"></script>
  <script type="text/javascript" src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
  <!--<script src="/jss/jquery.ui.datepicker-es.js"></script>-->
  <script type="text/javascript" src="<?php echo APP_BASE?>/jss/ajax.js"> </script>
  <script type="text/javascript" src="<?php echo APP_BASE?>/jss/upload.js"> </script>
  <script type="text/javascript" src="<?php echo APP_BASE?>/jss/utils.js"> </script>
  <script type="text/javascript" src="<?php echo APP_BASE?>/jss/general_functions.js"> </script>

<link rel="stylesheet" href="<?php echo APP_BASE?>/csss/editora.css" type="text/css" />
<link rel="stylesheet" href="<?php echo APP_BASE?>/csss/jqflashupload.css" type="text/css" />

<?php if(GOOGLE_MAPS_API_KEY!="" && $googlemaps){?>
	<script src="http://maps.google.com/maps?file=api&amp;v=2&amp;key=<?php echo GOOGLE_MAPS_API_KEY?>" type="text/javascript"> </script>
<?php } ?>

<!--Smarkup-->
<script type="text/javascript" src="<?php echo APP_BASE?>/jss/markitup/jquery.markitup.js"></script>
<script type="text/javascript" src="<?php echo APP_BASE?>/jss/markitup/sets/default/set.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo APP_BASE?>/jss/markitup/skins/markitup/style.css" />
<link rel="stylesheet" type="text/css" href="<?php echo APP_BASE?>/jss/markitup/sets/default/style.css" >
<!--Smarkup end-->

<link href="<?php echo APP_BASE?>/images/favicon.ico" rel="shortcut icon"/>


<script type="text/javascript">
	function show_upload(p_item, p_width, p_height) {
		var mides=getPageSize();
		var mida_scroll=getPageScroll();
		$("#fosc_upload").css("height",mides[1]);
		$("#fosc_upload").show();
		$("#fosc_upload").after("<div id=\"jsupload\"></div>");

		$("#jsupload").css("top",mida_scroll[1]+200).css("left",($(document).width()/2)-200);
		$("#jsupload").html("<p class=\"btn_close\"><a href=\"javascript://\" onclick=\"$('#jsupload').hide();$('#fosc_upload').hide();\">Cerrar<\/a> \
			<div class=\"upload_content\"> \
				<form action=\"/admin/upload2.php\" method=\"post\" enctype=\"multipart/form-data\" target=\"iframedestino\"> \
					<input type=\"hidden\" name=\"p_field\" value=\""+p_item+"\"> \
					<input type=\"hidden\" name=\"p_width\" value=\""+p_width+"\"> \
					<input type=\"hidden\" name=\"p_height\" value=\""+p_height+"\"> \
					<input type=\"hidden\" name=\"MAX_FILE_SIZE\" value=\"20000000\"> \
					<label for=\"\">Enviar un nou fitxer:</label> \
					<input name=\"userfile\" type=\"file\" /> \
					<p class=\"btn\"><input type=\"submit\" class=\"boto20\" value=\"Enviar\" /></p> \
				</form> \
				<iframe name='iframedestino' id='iframedestino' style='display:none;'></iframe> \
			</div>");
	}
	function browseImage(id){
		var mides=getPageSize();
		var mida_scroll=getPageScroll();
		$("#fosc_upload").css("height",mides[1]);
		$("#fosc_upload").show();

		$("#browse-popup1").css("top",mida_scroll[1]+200).css("left",($(document).width()/2)-190);
		$("#browse-popup1").html("<p class='btn_close'><a href='javascript://' onclick='$(\"#browse-popup1\").hide();$(\"#fosc_upload\").hide();'>Cerrar<\/a><\/p><div id='image_content'><\/div>");
		$("#image_content").load("<?php echo "/".URL_UPLOADS; ?>file_browser.php?reload_arr_images=true&arr_images_id="+id);
		$("#browse-popup1").show();
	}

        function cloneImage(class_id, inst_id, atri_id, p_tab_id){
		var mides=getPageSize();
		var mida_scroll=getPageScroll();
		$("#fosc_upload").css("height",mides[1]);
		$("#fosc_upload").show();

		$("#browse-popup1").css("top",mida_scroll[1]+200).css("left",($(document).width()/2)-190);
		$("#browse-popup1").html("<p class='btn_close'><a href='javascript://' onclick='$(\"#browse-popup1\").hide();$(\"#fosc_upload\").hide();'>Cerrar<\/a><\/p><div id='image_content'><\/div>");
		$("#image_content").load("<?php echo APP_BASE; ?>/clone_image?p_pagina=1&p_class_id="+class_id+"&p_inst_id="+inst_id+"&p_atri_id="+atri_id+"&p_tab_id="+p_tab_id);
		$("#browse-popup1").show();
	}

        function Appbrowser(id){

                var mides=getPageSize();
		var mida_scroll=getPageScroll();
		$("#fosc_upload").css("height",mides[1]);
		$("#fosc_upload").show();

                var storeUrl =$("input#store_url").val();
               
                
                 $.ajax({
                    url: "<?php echo DIR_JSS; ?>apps/appbrowser.php",
                    data: {'url':storeUrl},
                    type: 'POST',
                    dataType:"html",                 
                    success: function(datos){
                              if(datos.length > 0){                               
                                   $("#image_content").html(datos);                                 
                              }else{
                                   $('#image_content').html('<div class="alertmessage alert-error">\n\
                                                                           <strong>Uuups!</strong> <?=getMessage('error_getting_apps')?></div>')
                              }
                    }
            });
               

    		$("#browse-popup1").css("top",mida_scroll[1]+200).css("left",($(document).width()/2)-190);
                $("#browse-popup1").html("<p class='btn_close'><a href='javascript://' onclick='$(\"#browse-popup1\").hide();$(\"#fosc_upload\").hide();'>Cerrar<\/a><\/p><div id='image_content'><\/div>");
                $("#image_content").html('<img style="margin: 0 0 20px 60px;" src="<?=URL_APLI?>/admin/images/horizontal-loader.gif" />');
		//$("#image_content").load("<?php echo DIR_JSS; ?>appbrowser.php?url="+id);
		$("#browse-popup1").show();

        }
	
	$(document).ready(function () {		
		
		var fixHelper = function(e, ui) {
		    ui.children().each(function() {
		        $(this).width($(this).width());
		    });
		    return ui;
		};
		 
		$("[id^=divrel] tbody").sortable({
			axis: 'y',
			create: function(event, ui ) {
				/*$( this ).find('.move_item').hide();
				$( this ).parents('[id^=divrel]').find('colgroup col.w_70').remove();*/
				
			},
			helper: fixHelper,
			update: function (e) {
				parent = $( this ).parents('[id^=divrel]').attr('inst_id');
				var list = $( this ).parent().parent().parent().find('.alert');
				save_list(parent, $( this ).sortable('toArray'), list);
			}
		}).disableSelection();
		
		$('.alert').bind('click', function () {
			$(this).addClass('hidden');
		});


<?=$autocomplete_header_str?>

	$(".ui-sortable").on("click", ".reldelete", function(event) {
  var link = $(this).attr("href");
	var link=link.replace("delete_relation_instance","delete_relation_instance_ajax");
	var relid = link.substring(link.indexOf('p_rel_id=')+9);
  $.ajax({
    url: link,
    type: "GET",
    dataType: "html",
    success: function(html){
      $("#tabrel"+relid).html(html);
    }
	});
  event.preventDefault();
  });

	});
</script>

<!-- compliance patch for microsoft browsers -->
<!--[if lt IE 7]><script src="/jss/ie7/ie7-standard-p.js" type="text/javascript"></script><![endif]-->
<!--[if lt IE 7]><link rel="stylesheet" type="text/css" href="/csss/ie6.css" media="screen"/><![endif]-->
<!--[if lte IE 7]><link rel="stylesheet" type="text/css" href="/csss/ie.css" media="screen"/><![endif]-->

<script type="text/javascript" src="<?php echo APP_BASE?>/jss/maps.js"> </script>

<title>Editora 4.5 - <?php echo $title ?></title>
</head>