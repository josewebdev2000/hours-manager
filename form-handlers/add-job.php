<?php 
/** Form Handler to Deal With All Interactions Regarding Adding a New Job to the DB */
// Set error reporting level
error_reporting(E_ALL);

// Enable displaying errors
ini_set("display_errors", 1);

require_once __DIR__ . "/../helpers/index.php";
require_once __DIR__ . "/../db/employer-db-funcs.php";
require_once __DIR__ . "/../db/job-db-funcs.php";
require_once __DIR__ . "/../db/pay-rate-db-funcs.php";
require_once __DIR__ . "/../db/pay-roll-db-funcs.php";

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

    // First add employer the employer
    $employerData = insertNewEmployer(
        $job_data["user_id"],
        $employerValAssoc["employerName"],
        $employerValAssoc["employerEmail"],
        $employerValAssoc["employerPhoneNumber"]
    );

    // In case there was an error, return it
    if (array_key_exists("error", $employerData))
    {
        return send_json_error_response($employerData, 500);
    }

    // Otherwise, create a new job
    // Grab employer id first
    $employerId = $employerData["id"];

    $jobData = insertNewJob(
        $job_data["user_id"],
        $employerId,
        $jobValAssoc["title"]
    );

    if (array_key_exists("error", $jobData))
    {
        return send_json_error_response($jobData, 500);
    }

    // Grab the job id
    $jobId = $jobData["id"];

    // Now that we have the user and job, insert the pay rate
    $payRateData = insertNewPayRate(
        $job_data["user_id"],
        $jobId,
        $payRateValAssoc["rateType"],
        $payRateValAssoc["rateAmount"],
        $payRateValAssoc["effectiveDate"]
    );

    if (array_key_exists("error", $payRateData))
    {
        return send_json_error_response($payRateData, 500);
    }

    // Now insert the pay roll
    $payRollData = insertNewPayRoll(
        $job_data["user_id"],
        $jobId,
    );

    if (array_key_exists("error", $payRollData))
    {
        return send_json_error_response($payRollData, 500);
    }

    // Now insert as many working days as there are
    foreach ($workShiftValAssoc as $workShift)
    {
        //$workShiftData = 
    }

}

?>