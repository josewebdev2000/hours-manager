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

    // Validate Job Id
    if (!isset($job_data["job_id"]) || !is_valid_id_param($job_data["job_id"]))
    {
        return send_json_error_response(["error" => "Invalid Job Id"], 400);
    }

    // Validate Employer Id
    if (!isset($job_data["employer_id"]) || !is_valid_id_param($job_data["employer_id"]))
    {
        return send_json_error_response(["error" => "Invalid Employer Id", 400]);
    }

    // Grab the Job Id
    $jobId = $job_data["job_id"];

    // Grab the Employer Id
    $employerId = $job_data["employer_id"];

    // Run DB operation to delete job data
    $deleteJobRes = deleteJob($jobId, $employerId);

    if (array_key_exists("error", $deleteJobRes))
    {
        return send_json_error_response($deleteJobRes, 400);
    }

    return send_json_response($deleteJobRes);
}

?>