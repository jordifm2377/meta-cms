/**
 * jqUploader (http://www.pixeline.be/experiments/jqUploader/)
 * A jQuery plugin to replace html-based file upload input fields with richer flash-based upload progress bar UI.
 *
 * Version 1.0.2.2
 * September 2007
 *
 * Copyright (c) 2007 Alexandre Plennevaux (http://www.pixeline.be)
 * Dual licensed under the MIT and GPL licenses.
 * http://www.opensource.org/licenses/mit-license.php
 * http://www.opensource.org/licenses/gpl-license.php
 *
 * using plugin "Flash" by Luke Lutman (http://jquery.lukelutman.com/plugins/flash)
 *
 * IMPORTANT:
 * The packed version of jQuery breaks ActiveX control
 * activation in Internet Explorer. Use JSMin to minifiy
 * jQuery (see: http://jquery.lukelutman.com/plugins/flash#activex).
 *
 **/
 
jQuery.fn.jqUploader = function(options) {
    return this.each(function(index) {
        var $this = jQuery(this);
		// fetch label value if any, otherwise set a default one
		var $thisForm =  $this.parents("form");
		var $thisInput = $("input[@type='file']",$this);
		var $thisLabel = $("label",$this);
		var containerId = $this.attr("id") || 'jqUploader-'+index;
		var startMessage = ($thisLabel.text() =='') ? 'Elige un archivo' : $thisLabel.text();
		// get form action attribute value as upload script, appending to it a variable telling the script that this is an upload only functionality
		var actionURL = $thisForm.attr("action");
		// adds a var setting jqUploader to 1, so you can use it for serverside processing
		var prepender = (actionURL.lastIndexOf("?") != -1) ? "&": "?";
		actionURL = actionURL+prepender+'jqUploader=1';
		// check if max file size is set in html form
		var maxFileSize = $("input[@name='MAX_FILE_SIZE']", $(this.form)).val();
		
		var arr= (document.cookie).split(";");
		k=0;
		while(k<arr.length){
			var arr2=arr[k].split("=");
			if(arr2[0]==' PHPSESSID' || arr2[0]=='PHPSESSID'){
				galleta=arr2[1];
			}
			k++;
		}
		actionURL=actionURL+"&cookie="+galleta;
		var opts = jQuery.extend({
				width:320,
				height:85,
				version: 8, // version 8+ of flash player required to run jqUploader
				background: 'FFFFFF', // background color of flash file
				src:    '/admin/utils/jqUploader.swf',
				uploadScript:     actionURL,
				afterScript:      null, // if this is empty, jqUploader will replace the upload swf by a hidden input element
				varName:	        $thisInput.attr("name"),  //this holds the variable name of the file input field in your html form
				allowedExt:	      '*.*', // allowed extensions
				allowedExtDescr:  'All (*.*)',
				params:           {menu:false},
				flashvars:        {},
				hideSubmit:       true,
				barColor:		      '0000CC',
				maxFileSize:      maxFileSize,
				startMessage:     startMessage,
				errorSizeMessage: 'Archivo demasiado grande',
				validFileMessage: 'haz click en Upload para subirlo',
				progressMessage: 'Espera un momento, subiendo ',
				endMessage:    'Acabado',
				destino:	'destino',
				directorio: '',
				imagen: '',
				atriId: 0,
				instId: 0,
				w: '',
				h: ''
		}, options || {}
		);
		
		// disable form submit button
		if (opts.hideSubmit==true) {
			$("*[@type='submit']",this.form).hide();
		}
		
		// THIS WILL BE EXECUTED IN THE USECASE THAT THERE IS NO REDIRECTION TO BE DONE AFTER UPLOAD
		TerminateJQUploader = function(containerId,filename,varname){
			//$this= $('#'+containerId).empty();
			//$this.text('').append('<span style="color:#00CC00">Upload of <strong>'+filename+'</strong> finished! (the filename is now stored in the form as an hidden input field)</span><input name="'+varname+'" type="hidden" id="'+varname+'" value="'+filename+'"/>');
			
			$("#"+  opts.destino+"").val("uploads/"+opts.directorio+filename); //Carlos
			$("#"+  opts.destino+"").siblings("img").remove(); //Carlos
			$("#img-"+opts.imagen).attr("src","/uploads/"+opts.directorio+filename); //Carlos
			$("#upload-popup1").hide(); //Carlos
			$("#fosc_upload").hide(); //Carlos
			actualizar("#"+  opts.destino,"#img-"+opts.imagen,opts.instId,opts.atriId);
			$("#"+opts.destino).parent().next().show();
			$("#loader"+opts.destino).remove();
			
			
			
			
			var myForm = $this.parents("form");
			myForm.submit(function(){return true});
			$("*[@type='submit']",myForm).show();
		}
		
		var myParams = '';
		for (var p in opts.params){
				myParams += p+'='+opts.params[p]+',';
		}
		
		myParams = myParams.substring(0, myParams.length-1);
		
		// this function interfaces with the jquery flash plugin
		
		jQuery(this).flash(
		{
			src: opts.src,
			width: opts.width,
			height: opts.height,
			id:'movie_player-'+index,
			bgcolor:'#'+opts.background,
			flashvars: {
				containerId: containerId,
				uploadScript: opts.uploadScript+"&xatri="+opts.atriId+"&xinst="+opts.instId+"&p_width="+opts.w+"&p_height="+opts.h ,
				afterScript: opts.afterScript,
				allowedExt: opts.allowedExt,
				allowedExtDescr: opts.allowedExtDescr,
				varName :  opts.varName,
				barColor : opts.barColor,
				maxFileSize :opts.maxFileSize,
				startMessage : opts.startMessage,
				errorSizeMessage : opts.errorSizeMessage,
				validFileMessage : opts.validFileMessage,
				progressMessage : opts.progressMessage,
				endMessage: opts.endMessage,
				jsatriId: opts.atriId,
				jsinstId: opts.instId,
				cookie: galleta
			},
			params: myParams
		},
		{
			version: opts.version,
			update: false
		},
			function(htmlOptions){
				var $el = $('<div id="'+containerId+'" class="flash-replaced"><div class="alt">'+this.innerHTML+'</div></div>');
					 $el.prepend($.fn.flash.transform(htmlOptions));
					 $('div.alt',$el).remove();
					 $(this).after($el).remove();
			}
		);
		
	});
};

function uploadFile(name,id,dir,inst,width,height){
	$("#fosc_upload").show();

	$("#upload-popup1").html("<form enctype=\"multipart/form-data\" action=\"/admin/utils/flash_upload.php\" method=\"POST\" class=\"a_form\"> \
		<div id=\"upload1\"> \
        <label for=\"example3_field\">Elige el archivo a subir:</label> \
        <input name=\"myFile3\" id=\"example3_field\"  type=\"file\"/> \
		<input type=\"submit\" name=\submit\" value=\"Upload File\" /> \
		</div> \
		<p style='margin:10px 20px;font-size:12px;'><a style='color:#333333;' href=\"javascript://\" onclick=\"cambiar('"+id+"');\"><img  border='0' src='images/editarmini.gif'/> Continuar mientras se sube el archivo</a></p> \
		<p style='margin:10px 20px;font-size:12px;'><a style='color:#333333;' href='javascript://' onclick='$(\"#upload-popup1\").hide();$(\"#fosc_upload\").hide();$(\"#"+id+"\").parent().next().show();$(\"#loader"+id+"\").remove();'><img  border='0' src='images/eliminarmini.gif'/> Cancelar y cerrar</a></p></form>");
	$("#upload-popup1").show();
	$("#upload1").jqUploader({background:"ffffff",barColor:"FF0000",destino: id, directorio: dir,imagen: name,atriId: name,instId: inst ,w: width,h:height});
	
	$("#fosc_upload").css("height",$(document).height());
	var offset=$("#"+id).offset({ scroll: false });
	$("#upload-popup1").css("top",offset.top-200);
	$("#"+id).parent().next().hide();
	

}
function actualizar(input,img,inst,atri){
	$.post("controller_ajax.php",{ action: "actualizar", instId: inst, atriId: atri},
	  function(data){
	    $(input).val(data);
		
		if(!$(img).is("img")) $(input).parent().next().after("<img src='/"+data+"' width='60' height='60'/>");
		else $(img).attr('src',"/"+data);
	  }
	);
}

function guardar(file,atri,inst){

$.post("controller_ajax.php",{ action: "upload", xfile: file, xatri: atri, xinst: inst },
  function(data){
    alert("Data Loaded: " + data);
  }
);




}

function cambiar(name){
	$("#fosc_upload").hide('slow');
	//$("#upload-popup1").css("position","absolute");
	/*$("#upload-popup1").css("top","-1000px");
	$("#upload-popup1").css("left","0");*/
	$("#upload-popup1").css("top",-1000);
	$("#upload-popup1").css("left",-1000);
	
	
	$("<a href=\"javascript://\" onclick=\"abriragain('"+name+"');\"><img src=\'images/ajax-loader.gif\' id=\'loader"+name+"\' border='0' alt='Subiendo archivo' title'Subiendo archivo' /></a>").insertAfter("#"+name);
	
	
	
	//$("#upload-popup1").animate({left: -500, top: -500}, 500);
}
function abriragain(id){
$("#fosc_upload").show();
$("#upload-popup1").show();
$("#loader"+id).remove();

var offset=$("#"+id).offset({ scroll: false });
$("#upload-popup1").css("top",offset.top-200);
$("#upload-popup1").css("left",offset.left-400);
$("#fosc_upload").css("height",$(document).height());
}

