<?php

$new_key= openssl_pkey_new(array(
    'private_key_bits' => 1024,
    'private_key_type' => OPENSSL_KEYTYPE_RSA,
        ));

openssl_pkey_export_to_file($new_key, 'private.key');

$details = openssl_pkey_get_details($new_key);
file_put_contents('public.key', $details['key']);

openssl_free_key($new_key);
?>