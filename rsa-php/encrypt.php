<?php

function load_public_key($publickey_filename){

	$publickey_file = fopen($publickey_filename, "r");
	if (!$publickey_file)
		die('Cannot open private key file');

	$public_key_raw = fread($publickey_file,8192);
	fclose($publickey_file);

	return openssl_get_publickey($public_key_raw);
}

function encrypt_data($data, $public_key){

	openssl_public_encrypt($data, $encrypted, $public_key);

	if (!empty($encrypted)) {
	    openssl_free_key($public_key);
		return $encrypted;
	}else
	    return false;

}

?>