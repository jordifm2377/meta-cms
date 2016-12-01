<?php
/* Paquet adreces maques cal modificar la taula omp_instances */

function clean_url( $url, $id = '') {
	
	if ('' == $url) return $url;
	$url=strip_tags($url);
	$url=filter_text($url);
	$temp=explode("/",$url);
	$url=$temp[count($temp)-1];


	$url = preg_replace('|[^a-z0-9-~+_. #=&;,/:]|i', '', $url);
	$url = str_replace('/', '', $url);
	$url = str_replace(' ', '-', $url);
	$url = str_replace('&', '', $url);
	$url = str_replace("'", "", $url);
	$url = str_replace(';//', '://', $url);
	$url = preg_replace('/&([^#])(?![a-z]{2,8};)/', '&#038;$1', $url);

	$url=strtolower($url);
	
	//Últims canvis
   $url = trim($url);
   $url = trim(ereg_replace("[^ A-Za-z0-9_-]", "", $url)); 
   $url = ereg_replace("[ \t\n\r]+", "-", $url);
   $url = ereg_replace("[ -]+", "-", $url);

	if ($id == '')
	  return $url;

	return $url."-".$id;
}

   
  function filter_text ($original) {
		$search = array(
		"à", "á", "â", "ã", "ä", "À", "Á", "Â", "Ã", "Ä",
		"è", "é", "ê", "ë", "È", "É", "Ê", "Ë",
		"ì", "í", "î", "ï", "Ì", "Í", "Î", "Ï",
		"ó", "ò", "ô", "õ", "ö", "Ó", "Ò", "Ô", "Õ", "Ö",
		"ú", "ù", "û", "ü", "Ú", "Ù", "Û", "Ü",
		",", ".", ";", ":", "`", "´", "<", ">", "?", "}",
		"{", "ç", "Ç", "~", "^", "Ñ", "ñ"
		);
		$change = array(
		"a", "a", "a", "a", "a", "A", "A", "A", "A", "A",
		"e", "e", "e", "e", "E", "E", "E", "E",
		"i", "i", "i", "i", "I", "I", "I", "I",
		"o", "o", "o", "o", "o", "O", "O", "O", "O", "O",
		"u", "u", "u", "u", "U", "U", "U", "U",
		" ", " ", " ", " ", " ", " ", " ", " ", " ", " ",
		" ", "c", "C", " ", " ", "NY", "ny"
		);

		$filtered = strtoupper(str_ireplace($search,$change,$original));
		return $filtered;
}
?>
