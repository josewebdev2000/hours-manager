<?php 
/** Form Handler to Deal With All Interactions Regarding Adding a New Job to the DB */
// Set error reporting level
error_reporting(E_ALL);

// Enable displaying errors
ini_set("display_errors", 1);

require_once __DIR__ . "/../helpers/index.php";
require_once __DIR__ . "/../db/user-db-funcs.php";

// Import other funcs
require_once __DIR__ . "/../utils/constants.php";

// Handle Post Request for Add Job Page
if (is_post_request())
{
    // Grab the data to add a new job
    $job_data = get_json_request();

    // Validate Each Section of Job Data

    // Validate Employee Data
    $employerValAssoc = validateEmployerData($job_data["employer"]);

    if (array_key_exists("error", $employerValAssoc))
    {
        return send_json_error_response($employerValAssoc, 400);
    }

    // Validate Job Data
    $jobValAssoc = validateJobData($job_data["job"]);

    if (array_key_exists("error", $jobValAssoc))
    {
        return send_json_error_response($jobValAssoc, 400);
    }

    // Validate Pay Rate Data
    $payRateValAssoc = validatePayRateData($job_data["pay_rate"]);

    if (array_key_exists("error", $payRateValAssoc))
    {
        return send_json_error_response($payRateValAssoc, 400);
    }

    // Validate Pay Roll Data
    $payRollValAssoc = validatePayRollData($job_data["pay_roll"]);

    if (array_key_exists("error", $payRollValAssoc))
    {
        return send_json_error_response($payRollValAssoc, 400);
    }

    // Validate Work Shift Data
    $workShiftValAssoc = validateWorkShiftData($job_data["work_shifts"]);

    if (array_key_exists("error", $workShiftValAssoc))
    {
        return send_json_error_response($workShiftValAssoc, 400);
    }

    // Now that everything is valid, add data to the DB

    // First add employer

}

?>