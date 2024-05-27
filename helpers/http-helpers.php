<?php 
/** PHP Reused code that has to do with the HTTP Protocol */
function is_post_request()
{
    return $_SERVER["REQUEST_METHOD"] == "POST";
}

function send_json_response($json_response)
{
    // Set the header to send a JSON response
    header("Content-Type: application/json");

    // Send it with echo
    echo json_encode($json_response);
}

function send_json_error_response($json_error_response, $error_http_code)
{
    // Send a JSON error to tell the client what went wrong
    http_response_code($error_http_code);

    // Set the header to send a JSON response
    header("Content-Type: application/json");

    echo json_encode($json_error_response);
}

?>