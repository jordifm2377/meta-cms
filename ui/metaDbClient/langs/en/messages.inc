﻿<?php
function getMessage ($id) {
	$mess_arr = array();

	//Mensajes del Twitter
	$mess_arr['no_twitted'] = 'Message hasn\' been Twitted';
	$mess_arr['twitted'] = 'Message has been Twitted';
	$mess_arr['too_long'] = 'Message too long';
	$mess_arr['caracters'] = 'chars';

	$mess_arr['site_login_title'] = '\'s Content management system';

	$mess_arr['login_label_username'] = 'Username';
	$mess_arr['login_label_password'] = 'Password';
	$mess_arr['login_label_language'] = 'Language';
	$mess_arr['login_label_submit'] = 'Enter';

	$mess_arr['language_choose_ca'] = 'Català';
	$mess_arr['language_choose_en'] = 'English';
	$mess_arr['language_choose_es'] = 'Español';

	$mess_arr['info_create_object'] = 'New object of type';
	$mess_arr['info_view_object'] = 'View object';
	$mess_arr['info_edit_object'] = 'Edit object';
	$mess_arr['info_delete_object'] = 'Remove object of type';
	$mess_arr['info_delete_image'] = 'Remove image';
	$mess_arr['info_delete_multiple_object'] = 'Remove multiple objects of types';
	$mess_arr['info_search_object'] = 'Look for object';
	$mess_arr['info_addjoin_object'] = 'New related object';
	$mess_arr['info_addmassive_object'] = 'Massive creator of new related objects';
	$mess_arr['info_joinsearch_object_lite'] = 'Look for object';
	$mess_arr['info_joinsearch_object'] = 'Look for object of type';
    $mess_arr['creando_objeto'] = 'Adding object ';
	$mess_arr['viendo_objeto'] = 'View object ';
	$mess_arr['viendo_objeto2'] = ' with type ';
	$mess_arr['related_objects'] = 'Related objects found';

	$mess_arr['info_objects_found'] = 'Objects found';
	$mess_arr['info_object_created'] = 'created succesfully';
	$mess_arr['info_object_updated'] = 'updated succesfully';
	$mess_arr['info_object_deleted'] = 'Object removed succesfully';
	$mess_arr['info_image_deleted'] = 'Image removed succesfully';
	$mess_arr['info_object_deleted_plural'] = 'Objects removed succesfully';
	$mess_arr['info_object_favorited'] = 'Object succesfully added to your favorites';
	$mess_arr['info_object_unfavorited'] = 'Object succesfully removed from your favorites';
	$mess_arr['info_object_joined'] = 'succesfully related';
	$mess_arr['info_object_unjoined'] = 'unsuccesfully related';
	$mess_arr['info_objects_joined'] = 'Objects succesfully related';
	$mess_arr['relacionar_varis'] = 'Relate';
	$mess_arr['eliminar_varis'] = 'Delete';
	$mess_arr['info_create_role'] = 'New role';
	$mess_arr['info_view_role'] = 'View roles';
	$mess_arr['info_edit_role'] = 'Edit object';
	$mess_arr['info_delete_role'] = 'Remove object of type';
	$mess_arr['info_view_role_user'] = 'View users in role';
	$mess_arr['info_delete_role_users'] = 'Remove users in role';
	$mess_arr['info_view_privileges'] = 'View privileges';
	$mess_arr['info_edit_privileges'] = 'Edit privileges';
	$mess_arr['info_privileges_updated'] = 'Privileges succesfully altered';
	$mess_arr['info_privileges_unexpected'] = 'Unknown error trying to alter privileges';
	$mess_arr['info_create_user'] = 'Create user';
	$mess_arr['info_edit_user'] = 'Edit user';

	$mess_arr['site_login_session']='Session start';
	$mess_arr['info_error'] = 'Your session has expired. Please, start session again in the system.';
	$mess_arr['info_word_keyword_explanation'] = 'Order by keyword';
	$mess_arr['info_word_status_explanation'] = 'Order by status';
	$mess_arr['info_word_publishing_creation_date_explanation'] = 'Order by creation date';
	$mess_arr['info_word_publishing_begins_explanation'] = 'Order by publication date';


	$mess_arr['info_word_privileges'] = 'Privileges';
	$mess_arr['info_word_object'] = 'Object';
	$mess_arr['info_word_joinwith'] = 'to relate with';
	$mess_arr['info_word_typeof'] = 'of type';
	$mess_arr['info_word_searcher'] = 'Search';
    $mess_arr['advanced_search'] = 'Advanced Search';
	$mess_arr['info_word_type'] = 'Type';
	$mess_arr['info_word_type_explanation'] = 'Order by explanation';
	$mess_arr['info_word_text'] = 'Text';
	$mess_arr['info_word_select_date'] = 'Select date';
	$mess_arr['info_word_initial_date'] = 'Start date';
	$mess_arr['info_word_final_date'] = 'End date';
	$mess_arr['info_word_search_button'] = 'Search';
	$mess_arr['info_word_no_orderup'] = 'Up (not allowed)';
	$mess_arr['info_word_no_orderdown'] = 'Down (not allowed)';
	$mess_arr['info_word_ordertop'] = 'Up to top';
	$mess_arr['info_word_orderbottom'] = 'Down to bottom';
	$mess_arr['info_word_orderup'] = 'Up';
	$mess_arr['info_word_orderdown'] = 'Down';
	$mess_arr['info_word_unjoin'] = 'Unrelate';
	$mess_arr['info_word_unjoin_all'] = 'Unrelate all';
	$mess_arr['info_word_edit'] = 'Edit';
	$mess_arr['info_word_status'] = 'Status';
	$mess_arr['info_word_status_explanation'] = 'Order by status';
	$mess_arr['not_published'] = 'Not published';
	$mess_arr['pending'] = 'Pending';
	$mess_arr['published'] = 'Published';
	$mess_arr['info_word_status_pending'] = 'Pending';
	$mess_arr['info_word_status_reviewed'] = 'Reviewed';
	$mess_arr['info_word_status_published'] = 'Published';
	$mess_arr['info_word_publishing_begins'] = 'Publishing start date';
	$mess_arr['info_word_publishing_ends'] = 'Publishing end date';
	$mess_arr['info_word_add_button'] = 'Add';
	$mess_arr['info_word_update_button'] = 'Update';
	$mess_arr['info_word_edit_button'] = 'Edit';
	$mess_arr['info_word_testurl'] = 'Test URL';
	$mess_arr['info_word_addjoin'] = 'Add and relate';
        $mess_arr['info_word_clone'] = 'Clone image';
	$mess_arr['info_word_addmassive'] = 'Massive add';
	$mess_arr['info_word_exportmassive'] = 'Massive export';
	$mess_arr['info_word_join'] = 'Relate';
	$mess_arr['info_word_ID'] = 'ID';
	$mess_arr['info_word_ID_explanation'] = 'Order by ID';
	$mess_arr['info_word_keyword'] = 'Key';
	$mess_arr['info_word_view'] = 'View';
	$mess_arr['info_word_yes'] = 'Yes';
	$mess_arr['info_word_no'] = 'No';
	$mess_arr['info_word_areyousure'] = 'Are you sure?';
	$mess_arr['info_word_areyousure_arr'] = 'The following elements would be eliminated, are you sure?';
	$mess_arr['info_word_not_eliminate'] = 'The following elements would not be eliminated';
	$mess_arr['info_word_utilities'] = 'Tools';
	$mess_arr['info_word_creation_date'] = 'Creation date';
	$mess_arr['info_word_addfavorites'] = 'Add to favorites';
	$mess_arr['info_word_delete'] = 'Remove';
	$mess_arr['info_word_modifyperm'] = 'No';
	$mess_arr['info_word_deletejoin'] = 'Relation removed succesfully';
	$mess_arr['info_word_deletejoin_error'] = 'Relation can\'t be removed';
	$mess_arr['info_word_orderjoin'] = 'Order updated succesfully';
	$mess_arr['info_word_logged'] = 'You are connected as';
	$mess_arr['info_word_logout'] = 'Logout';
	$mess_arr['info_word_search'] = 'Search';
	$mess_arr['info_word_childs'] = 'Childs';

	$mess_arr['info_word_more_relations'] = 'More relations';
	$mess_arr['error_role_privileges'] = 'Your role doesn\'t have enough privileges to use this feature';
	$mess_arr['error_role_privileges2'] = 'Your role doesn\'t have enough privileges to view this object instance';
	$mess_arr['error_role_privileges3'] = 'Your role doesn\'t have enough privileges to edit this object instance in his current state';
	$mess_arr['error_session_timeout'] = 'Your session has expired or your credentials are incorrect, please, login again';
	$mess_arr['error_param_mandatory'] = 'Mandatory paramater needed!';
	$mess_arr['error_param_data'] = 'Error in data!';
	$mess_arr['error_param_urlnice'] = 'Duplicated URL Nice!';
	$mess_arr['error_search_data'] = 'Incorrect search data';
	$mess_arr['error_user_passwdnotmatch'] = 'Passwords didn\'t match';
	$mess_arr['error_object_delete'] = 'You cannot erase this object, there are relations to or from this object!';
	$mess_arr['error_format_massive'] = 'The representations format is invalid';
	$mess_arr['error_page'] = 'This action doesn\'t exist. Please, review if the URL is correct';

	$mess_arr['navigation_back'] = 'Back';
	$mess_arr['navigation_home'] = 'Start';
	$mess_arr['navigation_new'] = 'New';
	$mess_arr['navigation_list'] = 'List';

	$mess_arr['container_mini_cercador'] = 'Mini searcher';
	$mess_arr['container_twitter'] = 'Add to Twitter';
	$mess_arr['container_objetos_favoritos'] = 'Favorite objects';
	$mess_arr['container_objetos_padre'] = 'Parent objects';
	$mess_arr['container_ultimos_objetos'] = 'Last objects accessed';
	$mess_arr['container_derechos_reservados'] = 'All rigths reserved';
	$mess_arr['container_mes_funcions'] = 'More functions';
	$mess_arr['regenerar_cache'] = 'Regenerate cache';
	$mess_arr['info_regenerate_cache'] = 'Cache regenerated correctly';
	$mess_arr['enllacos_trencats'] = 'Found broken links';
	$mess_arr['unlinked_images'] = 'Found unlinked images';
    $mess_arr['no_found'] = 'Any object found.';


	$mess_arr['paginacion_registros_del']='Records from';
	$mess_arr['paginacion_al']='to';
	$mess_arr['paginacion_anteriores']='Previous';
	$mess_arr['paginacion_siguientes']='Next';

	$mess_arr['all']='All';

	$mess_arr['delete_massive_confirmation']='Are you sure you want to unlink and DELETE all the related objects?';

	$mess_arr['relacionando']='Relating the object ';
	$mess_arr['relacionando2']=' with class ';

	$mess_arr['preview_format']='Format';
	$mess_arr['preview_debug']='Debug';
	$mess_arr['preview_enviar']='Send';

	$mess_arr['theoric_size']='Theoric size';
	$mess_arr['real_size']='Real size';
	$mess_arr['msie6']='Alert! You are trying to log in with Internet Explorer 6.0. This is and old version of this browser, knowed for having many security holes and bugs. Omatech is no longer support this version of the browser, so is posible that many features are deactivated.

	We apologize for any inconveniences this may have caused
	<br /><br /><a title="Download Firefox" href="http://www.getfirefox.com">Download Firefox</a>
	<br /><a title="Download Google Chrome" href="http://www.google.com/chrome">Download Google Chrome</a>';

	$mess_arr['info_word_reserved_instance'] = 'Reserved instance: ';

	$mess_arr['file_name']="Image name";
	$mess_arr['file_image']="Image";
	$mess_arr['file_upload_date']="Upload date";
	$mess_arr['acciones']="Actions";


        $mess_arr['error_getting_apps']="Error getting App data, please try again";

	return $mess_arr[$id];
}
?>
