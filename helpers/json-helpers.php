<?php
/** PHP code that has to do with handling JSON */
function get_json_request()
{
    // Grab a JSON request from the front-end
    // Grab JSON data from the front-end as a file
    $jsonData = file_get_contents("php://input");

    // Decode the JSON data
    $decodedData = json_decode($jsonData, true);

    return $decodedData;
}

?>