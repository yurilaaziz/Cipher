<?php
include("decrypt.php");
include("encrypt.php");

$data ="Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vestibulum feugiat"
		.", odio non volutpat rhoncus, diam dui rutrum tortor, eget tristique ipsum "
		."libero quis ex. Morbi quis posuere velit, sit amet pharetra dolor. Ut sed "
		."facilisis purus. Phasellus ultrices sed risus a tincidunt. Nam sed leo vitae "
		."arcu rutrum malesuada. Morbi semper ipsum nisl, et ultricies arcu eleifend vitae."
		." Aliquam id enim dolor. ";
$config = array("publickey_file" => "public.key",
				"privatekey_file" => "private.key");

// DEFINE our cipher
define('AES_256_CBC', 'aes-256-cbc');

// encryption using AES 256 

//Generate a 256-bit encryption key
$encryption_key = openssl_random_pseudo_bytes(32);

// Generate an initialization vector
$iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length(AES_256_CBC));

// Encrypt $data using aes-256-cbc cipher with the given encryption key and 
// our initialization vector.
$encrypted_data = openssl_encrypt($data, AES_256_CBC, $encryption_key, 0, $iv);



$public_key = load_public_key($config["publickey_file"]);
$encrypted_key = encrypt_data($encryption_key, $public_key);

$data_to_send = $encrypted_data. ':'
				. base64_encode($iv). ':'
				. base64_encode($encrypted_key);

/***
* Now $data_to_send is ready to be sent (for ex POST request)
*
*/

// decryption

$data_r = $data_to_send;

// after receiving data, separate the $encrypted_data, $iv and $encrypted_key
$array = explode(':',$data_r);

$encrypted_data = $array[0];
$iv = base64_decode($array[1]);
$encrypted_key = base64_decode($array[2]);

// decrypt the AES encryption_key 
$private_key = load_private_key($config["privatekey_file"]);
$decrypted_key = decrypt_data($encrypted_key, $private_key);

// decrypt data with the AES encryption key ~ decrypted_key 
$decrypted_data = openssl_decrypt($encrypted_data, AES_256_CBC, $decrypted_key, 0, $iv);

echo "\n=begin==\n";
echo "\n\noriginal data : \n";
echo $data;
echo "\n\nencrypted data : \n";
echo $encrypted_data;
echo "\n\nencrypted key : \n";
echo $encrypted_key;
echo "\n\ndecrypted data : \n";
echo $decrypted_data;
echo "\n\ndecrypted key : \n";
echo $decrypted_key;
echo "\n==end==\n";


?>