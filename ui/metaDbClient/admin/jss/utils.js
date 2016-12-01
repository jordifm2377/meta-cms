function changeLang (lang)
{
  window.location = "controller.php?p_action=changelanglogin&u_lang="+lang;
}

function view_relations(p_relation_id, p_parent_inst_id){

	$("#rel"+p_relation_id).load("controller.php?p_action=ajax_view_relations&p_relation_id="+p_relation_id+"&p_parent_inst_id="+p_parent_inst_id);
	/*,
	function () {
		$('ul.relacions').Sortable(
			{
				accept : 		'sortableitem',
				helperclass : 	'sortableitem',
				activeclass : 	'sortableitem',
				hoverclass : 	'sortableitem',
				opacity: 		0.3,
				fx:				200,
				axis:			'vertically',
				onStop:			function(){
									//alert("rel"+p_relation_id);
									serial = $.SortSerialize("rel"+p_relation_id);
									lista=serial.hash.split("&");
									i=0;
									suma=p_relation_id+","+p_parent_inst_id+",";
									while(i<lista.length){
										lista2=lista[i].split("=");
										suma+=lista2[1].substring(5)+"#";
										i++;
									}
									$.post("controller.php", { p_action: "reorder_relations", par: suma } );

								},
			}
		)
	}*/
}

function deleterelation(id){
	//alert("ID"+id);
	$.post("controller.php", { p_action: "delete_relations_parent", id_rel: id } );
	$("li#parent_rel"+id).hide();
}

function select_unselect_all() {
	if (document.getElementById("select_all").checked==false) var accio=0;
	else var accio=1;
	for (var i=0;i<document.getElementById("num_rel").value;i++) {
		if (accio==1) document.getElementById("rel_chb_"+i).checked=true;
			else document.getElementById("rel_chb_"+i).checked=false;
	}
}

function select_unselect_del_all() {
	if (document.getElementById("select_all").checked==false) var accio=0;
	else var accio=1;
	for (var i=0;i<document.getElementById("num_del").value;i++) {
		if (accio==1) document.getElementById("del_chb_"+i).checked=true;
			else document.getElementById("del_chb_"+i).checked=false;
	}
}


function changestatusimg(rel){
	var st=$(rel).val();
	if(st=="O") {
		$("#statusimg").attr("class",'status publish');
	}
	else if(st=="P") {
		$("#statusimg").attr("class",'status pending');
	}
	else {
		$("#statusimg").attr("class",'status revised');
	}
}

// funcio que prove del projecte XalokPDF
function make_magic(code , info, return_to, list){
	info = 'ajax=' + code + '&' + info;
	//var list = $('.list.alert'); la heredem del sortable del header
	$.ajax({
		url: '/ajax-params',
		type: "POST",
		data: info,
		beforeSend: function (jqXHR, settings) {
			list.removeClass('alert_error alert_right hidden').addClass('saving');
			$('.alert.list div p').html('Saving ...');
		},
		complete: function(jqXHR, textStatus) {
			if(textStatus != 'success') {
				list.removeClass('saving').addClass('alert_error');
				$('.alert.list div p').html('Something went wrong!');
			}
		},
		success: function(data) {
			switch(return_to){
				default:
					if(data == 'ok') {
						$(return_to).html('Saved!');
						list.removeClass('saving').addClass('alert_right');
					} else {
						$(return_to).html('Something went wrong!');
						list.removeClass('saving').addClass('alert_error');
					}
			}
		}
	});
}
// funcio que prove del projecte XalokPDF
function save_list(noticia_id, sortable, list) {
	var info = 'noticia_id=' + noticia_id + '&ordered=' + sortable;
	console.log(list);
	make_magic(3004, info, '.alert.list div p', list);
}