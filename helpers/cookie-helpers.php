<?php 
error_reporting(E_ALL);

// Enable displaying errors
ini_set('display_errors', 1);

/** PHP Code used to deal with user cookies */
// All DB Queries will be done from here

function create_user_cookie($id, $enc_method, $enc_key)
{
    // Set expiration time for two weeks
    $expiration = time() + (14 * 24 * 3600);
    setcookie(
        "lmFw3e", // Place a confusing name to the cookie in order to boo away hackers 
        get_encrypted_cookie_value($enc_method, $enc_key, $id), 
        [
            "expires"   =>      $expiration, 
            "path"      =>      "/"
        ]);
}

function get_encrypted_cookie_value($method, $key, $cookie_value)
{
    // Encrypt a cookie value

    // Generate a random initialization vector
    $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length($method));

    // Encrypt the cookie value
    $encrypted = openssl_encrypt($cookie_value, $method, $key, OPENSSL_RAW_DATA, $iv);

    // Combine the IV and the encrypted data in base-64 encoding
    $final_cookie_value = base64_encode($iv . $encrypted);

    return $final_cookie_value;
}

function get_decrypted_cookie_value($method, $key, $cookie_value)
{
    // Decrypt a cookie value

    // Decode the base-64 first
    $data = base64_decode($cookie_value);

    // Extract the Initialization Vector
    $iVector = substr($data, 0, openssl_cipher_iv_length($method));

    // Decrypt the cookie value with the key
    $decrypted_cookie_value = openssl_decrypt(substr($data, openssl_cipher_iv_length($method)), $method, $key, OPENSSL_RAW_DATA, $iVector);

    return $decrypted_cookie_value;
}

function delete_user_cookie()
{
    // Set expiration to one hour ago
    if (isset($_COOKIE["lmFw3e"]))
    {
        $expiration = time() - 3600;

        setcookie("lmFw3e", "", 
        [
            "expires"   => $expiration,
            "path"      => "/"
        ]);
    }
}

?>