<?php 
    require_once "conn.php";
    require_once __DIR__ . "/../helpers/index.php";

    /** PHP File that deals with DB interactions regarding the Pay Rate Entity/Table */
/**
 * 
 * KEEP WORKING HERE IN ORDER TO ADD THE WORKING DAY MAN
 */

function getWorkingDaysForUserByJobId($userId, $jobId)
{
    global $conn;

    // Return all working days that belong to a user and a job
    $sql = "SELECT id, day, start_time AS startingHour, end_time AS endingHour FROM workingdays WHERE user_id = ? AND job_id = ?";

    // Make a prepared statement
    $stmt = $conn->prepare($sql);

    // If statement could not be prepared, return an early error assoc
    if (!$stmt)
    {
        return [
            "error" => "Could not prepare to get working days",
            "error_code" => "preparation_error"
        ];
    }

    // Bind the ids of the user and the job
    $stmt->bind_param("ii", $userId, $jobId);

    // Execute the statement
    // If there was an error return an error assoc
    if (!$stmt->execute())
    {
        return [
            "error" => "Could to try to get working days",
            "error_code" => "excecution_error"
        ];
    }

    // Grab the result
    $result = $stmt->get_result();

    // If the result does not have any rows, the working days were not found
    if ($result->num_rows == 0)
    {
        return [
            "error" => "Could not find any working days",
            "error_code" => "working_days_not_found_error"
        ];
    }

    // If there were working days, grab them
    $workingDays = [];

    // Grab data for each working day
    while ($workingDay = $result->fetch_assoc())
    {
        $workingDays[$workingDay["id"]] = $workingDay;
    }

    // Close the statement
    $stmt->close();

    return $workingDays;
}

?>
