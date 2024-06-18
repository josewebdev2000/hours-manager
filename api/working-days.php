<?php require_once __DIR__ . "/../helpers/index.php";
require_once __DIR__ . "/../db/working-day-db-funcs.php";
/** Working Days PHP API to interact asynchronously with it */

// Receive a POST request from the front-end
if (is_post_request())
{
    // Get JSON request
    $workingDaysReq = get_json_request();

    // if no action field is set, return early error
    if (!isset($workingDaysReq["action"]))
    {
        return send_json_error_response(["error" => "No Action Specified"]);
    }

    // If the action isn't accepted, return error
    $allowed_actions = ["getWorkingDays", "changeWorkingDays"];

    if (!in_array($workingDaysReq["action"], $allowed_actions))
    {
        return send_json_error_response(["error" => "Invalid Action"]);
    }

    // Make a switch statement
    switch ($workingDaysReq["action"])
    {
        case "getWorkingDays":
        {
            // Grab the user id
            if (!isset($workingDaysReq["user_id"]))
            {
                return send_json_error_response(["error" => "User Id Was Not Specified"]);
            }

            if (!is_valid_id_param($workingDaysReq["user_id"]))
            {
                return send_json_error_response(["error" => "Invalid User Id"]);
            }

            $user_id = $workingDaysReq["user_id"];

            // Grab the job id
            if (!isset($workingDaysReq["job_id"]))
            {
                return send_json_error_response(["error" => "Job Id Was Not Specified"]);
            }

            if (!is_valid_id_param($workingDaysReq["job_id"]))
            {
                return send_json_error_response(["error" => "Invalid Job Id"]);
            }

            $job_id = $workingDaysReq["job_id"];

            // Make the request to grab working days
            $workingDays = getWorkingDaysForUserByJobId($user_id, $job_id);

            if (array_key_exists("error", $workingDays))
            {
                return send_json_error_response(["error" => "Working Days Were Not Found"]);
            }

            return send_json_response($workingDays);
        }
    }
}

?>