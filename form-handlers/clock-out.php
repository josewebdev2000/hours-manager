<?php 
/** Form Handler to Deal With All Interactions Regarding Clocking-Out a Job */
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
    $clock_out_data = get_json_request();

    // Validate Clock In Data
    $validate_clock_out_data = validate_clock_out_data($clock_out_data);

    if (array_key_exists("error", $validate_clock_out_data))
    {
        return send_json_error_response($validate_clock_out_data, 400);
    }

    // Insert New Work Session In The DB
    $clock_out_res_assoc = clockOutJob(
        $validate_clock_out_data["worksession_id"],
        $validate_clock_out_data["end_time"]
    );

    if (array_key_exists("error", $clock_out_res_assoc))
    {
        return send_json_error_response($clock_out_res_assoc, 400);
    }

    return send_json_response($clock_out_res_assoc);
}

function validate_clock_out_data($clock_out_data)
{
    if (!is_valid_id_param($clock_out_data["worksession_id"]))
    {
        return [
            "error" => "Invalid Work Session Id Parameter"
        ];
    }

    if (!isValidDateTime($clock_out_data["end_time"]))
    {
        return [
            "error" => "Invalid End Time Parameter"
        ];
    }

    return [
        "worksession_id" => strip_tags($clock_out_data["worksession_id"]),
        "end_time" => strip_tags($clock_out_data["end_time"])
    ];
}

?>