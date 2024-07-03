<?php 
/** Form Handler to Deal With All Interactions Regarding Clocking-In a Job */
// Set error reporting level
error_reporting(E_ALL);

// Enable displaying errors
ini_set("display_errors", 1);

require_once __DIR__ . "/../helpers/index.php";
require_once __DIR__ . "/../db/worksession-db-funcs.php";

// Import other funcs
require_once __DIR__ . "/../utils/constants.php";

// Handle Post Request for Add Job Page
if (is_post_request())
{
    $clock_in_data = get_json_request();

    // Validate Clock In Data
    $validate_clock_in_data = validate_clock_in_data($clock_in_data);

    if (array_key_exists("error", $validate_clock_in_data))
    {
        return send_json_error_response($validate_clock_in_data, 400);
    }

    // Insert New Work Session In The DB
    $clock_in_res_assoc = insertNewWorkSession(
        $validate_clock_in_data["user_id"],
        $validate_clock_in_data["job_id"],
        $validate_clock_in_data["start_time"]
    );

    if (array_key_exists("error", $clock_in_res_assoc))
    {
        return send_json_error_response($clock_in_res_assoc, 400);
    }

    return send_json_response($clock_in_res_assoc);
}

function validate_clock_in_data($clock_in_data)
{
    if (!is_valid_id_param($clock_in_data["user_id"]))
    {
        return [
            "error" => "Invalid User Id Parameter"
        ];
    }

    if (!is_valid_id_param($clock_in_data["job_id"]))
    {
        return [
            "error" => "Invalid Job Id Parameter"
        ];
    }

    if (!isValidDateTime($clock_in_data["start_time"]))
    {
        return [
            "error" => "Invalid Start Time Parameter"
        ];
    }

    return [
        "user_id" => strip_tags($clock_in_data["user_id"]),
        "job_id" => strip_tags($clock_in_data["job_id"]),
        "start_time" => strip_tags($clock_in_data["start_time"])
    ];
}

?>