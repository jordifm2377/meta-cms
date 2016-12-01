/*CALENDARI*/
$(document).ready(function(){
       // $( "#datepicker" ).datepicker();
        $( ".datepicker" ).datepicker({
            showOn: "button",
            buttonImage: "../images/calendari.png",
            buttonImageOnly: true,
            dateFormat: 'dd/mm/yy',
            dayNamesMin: ['D', 'L', 'M', 'M', 'J', 'V', 'S'],
            firstDay: 1,
            closeText: 'Cerrar',
                prevText: '&#x3c;',
                nextText: '&#x3e;',
                currentText: 'Hoy',
                monthNames: ['Enero','Febrero','Marzo','Abril','Mayo','Junio',
                'Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'],
                monthNamesShort: ['Ene','Feb','Mar','Abr','May','Jun',
                'Jul','Ago','Sep','Oct','Nov','Dic'],
                dayNames: ['Domingo','Lunes','Martes','Mi&eacute;rcoles','Jueves','Viernes','S&aacute;bado'],
                dayNamesShort: ['Dom','Lun','Mar','Mi&eacute;','Juv','Vie','S&aacute;b'],
                weekHeader: 'Sm',
                isRTL: false,
                showMonthAfterYear: false,
                yearSuffix: ''
        });

       
	/*$.datepicker.setLanguageStrings(
		['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'],
		['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
		{p:'Anterior', n:'Siguiente', c:'Cierre', b:'Elija la fecha'}
	);
        */
           ///traduccion al castellano
	$('selector').datepicker({firstDayOfWeek:1}); //empezamos la semana por lunes

	// all inputs with a class of "date-picker" have a date picker which lets you pick any date in the future
	//$('input.date-picker').datePicker();
	// OR
	// all inputs with a class of "date-picker" have a date picker which lets you pick any date after 05/03/2006
	//$('input.date-picker').datePicker({startDate:'05/03/2006'});
	// OR
	// all inputs with a class of "date-picker" have a date picker which lets you pick any date from today till 05/011/2006
	//$('input.date-picker').datePicker({endDate:'05/11/2006'});
	// OR
	// all inputs with a class of "date-picker" have a date picker which lets you pick any date from 05/03/2006 till 05/11/2006
	//$('input.date-picker').datePicker({startDate:'05/03/2006', endDate:'05/11/2006'});
	// OR
	// the input with an id of "date" will have a date picker that lets you pick any day in the future...
	$('input#date1').datepicker({startDate:'01/01/2007'});
	//$('input#date_s1').datepicker({startDate:'01/01/2007'});
	// ...and the input with an id of "date2" will have a date picker that lets you pick any day between the 02/11/2006 and 13/11/2006
	$('input#date2').datepicker({startDate:'01/01/2007'});
	//$('input#date_s2').datepicker({startDate:'01/01/2007'});
	$('input.date3').datepicker({startDate:'01/01/2007'});


        /*
        $('form#cloneimage').submit(function() {
                alert('hola');
        });
        */
});


/*
var tancat=false;

function amagar() {
	$('#sidebar').toggle();
	if(tancat==false) {
		$('#editora_body').css("width","97%");
		$("#sidebar_toggle").css("background","url('/admin/images/slidebar.gif') no-repeat 0px 300px #E6F5FC");
		$.post("controller.php", { p_action: "slide", status: "close" } );
		tancat=true;
	}
	else {
		//alert(wid);
		$('#editora_body').css("width","72%");
		$("#sidebar_toggle").css("background","url('/admin/images/slidebar.gif') no-repeat -6px 300px #E6F5FC");
		$.post("controller.php", { p_action: "slide", status: "open" } );
		tancat=false;
	}
}

function plegar(rel,div) {
	if($(rel).html()=='+') {
		$('#'+div+' ul').slideDown();
		$(rel).html('-');
	}
	else {
		$(rel).html('+');
		$('#'+div+' ul').slideUp();
	}
}

function plegar2(rel,div) {
	if($(rel).html()=='+') {
		$('#'+div+' form').slideDown();
		$(rel).html('-');
	}
	else {
		$(rel).html('+');
		$('#'+div+' form').slideUp();
	}
}
*/

$(document).ready(function() {
    $(".arrow a").bind('click', function () {
        $(this).parents('.box').toggleClass('box_hide');
    });
});

function getSelection(ta) {
	var bits = [ta.value,'','',''];
    if(document.selection) { //explorer
		var vs = '#$%^%$#';
        var tr=document.selection.createRange()

        if(tr.parentElement()!=ta) return null;
        bits[2] = tr.text;
        tr.text = vs;
        fb = ta.value.split(vs);
        tr.moveStart('character',-vs.length);
        tr.text = bits[2];
        bits[1] = fb[0];
        bits[3] = fb[1];
    }
	else { //FF
		if(ta.selectionStart == ta.selectionEnd) return null;

		bits[1]=(ta.value).substring(0,ta.selectionStart);
		bits[2]=(ta.value).substring(ta.selectionStart,ta.selectionEnd);
		bits[3]=(ta.value).substring(ta.selectionEnd,(ta.value).length);
		//bits=(new RegExp('([\x00-\xff]{'+ta.selectionStart+'})([\x00-\xff]{'+(ta.selectionEnd - ta.selectionStart)+'})([\x00-\xff]*)')).exec(ta.value);
	}

	return bits;
}

function matchPTags(str) {
	str = ' ' + str + ' ';
    ot = str.split(/\<[B|U|I].*?\>/i);
    ct = str.split(/\<\/[B|U|I].*?\>/i);
    return ot.length==ct.length;
}

function addPTag(ta,pTag) {
	bits = getSelection(ta);
    if(bits) {
		if(!matchPTags(bits[2])) {
			alert('\t\tInvalid Selection\nSelection contains unmatched opening or closing tags.');
            return;
        }
        ta.value = bits[1] + '<' + pTag + '>' + bits[2] + '</' + pTag + '>' + bits[3];
    }
}

function view_object(action, obj_id,w,h) {
    w2 = screen.availWidth-20;
    h2 = screen.availHeight;
    var leftPos = (w2-w)/8, topPos = (h2-h)/8;

    eval('window.open("/'+action+'/?inst_id='+obj_id+'","window_loc","top='+topPos+', left='+leftPos+', width='+w+', height='+h+',resizable=NO,scrollbars=YES")')
}

function select_image(id,value) {
	$("#"+id).val(value);
	$("#fosc_upload").hide();
	$("#browse-popup1").hide();
}