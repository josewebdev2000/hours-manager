<?php 
/** Form Handler to Deal With All Interactions Regarding Adding a New Job to the DB */
// Set error reporting level
error_reporting(E_ALL);

// Enable displaying errors
ini_set("display_errors", 1);

require_once __DIR__ . "/../helpers/index.php";
require_once __DIR__ . "/../db/job-db-funcs.php";

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
    /*
    $workShiftValAssoc = validateWorkShiftData($job_data["work_shifts"]);

    if (array_key_exists("error", $workShiftValAssoc))
    {
        return send_json_error_response($workShiftValAssoc, 400);
    }
    */

    // Now that everything is valid, edit job data in the DB
    $updateJobResponse = editJob(
        $job_data["employer_id"],
        $job_data["job_id"],
        $employerValAssoc,
        $jobValAssoc,
        $payRateValAssoc,
        $payRollValAssoc,
    );

    // If error in adding new job, classify type of error
    if (array_key_exists("error", $updateJobResponse))
    {
        // Depending on error code, return 400 Client Error or 500 Internal Server Error
        $error_code = NULL;

        if ($updateJobResponse["error_code"] == "preparation_error" || $updateJobResponse["error_code"] == "excecution_error")
        {
            $error_code = 500;
        }

        else
        {
            $error_code = 400;
        }

        return send_json_error_response(["error" => $updateJobResponse["error"]], $error_code);
    }

    // By this point the transaction was successful, so return success message
    return send_json_response($updateJobResponse);
}

?>