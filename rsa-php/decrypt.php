<?php

function load_private_key($privatekey_filename){

$privatekey_file = fopen($privatekey_filename, "r");
if (!$privatekey_file)
	die('Cannot open private key file');

$private_key_raw = fread($privatekey_file,8192);
fclose($privatekey_file);

return openssl_get_privatekey($private_key_raw);
}

function decrypt_data($encrypted, $private_key){

	openssl_private_decrypt($encrypted, $decrypted, $private_key);

	if (!empty($decrypted)) {
	    openssl_free_key($private_key);
		return $decrypted;
	}else
	    return false;

}

?>