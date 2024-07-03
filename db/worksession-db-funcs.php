<?php 
    require_once "conn.php";
    require_once __DIR__ . "/../helpers/index.php";

/** PHP File that deals with DB interactions regarding the WorkSession Entity/Table */

function insertNewWorkSession($user_id, $job_id, $start_time)
{
    /** Insert a New WorkSession To The DB */
    global $conn;

    // Make SQL String to insert a new work session
    $sql = "INSERT INTO worksessions (user_id, job_id, start_time) VALUES (?, ?, ?)";

    // Make a prepared statement out of it
    $stmt = $conn->prepare($sql);

    // If statement could not be made, return early error
    if (!$stmt)
    {
        return [
            "error" => "Could not prepare to clock-in",
            "error_code" => "preparation_error"
        ];
    }

    // Bind the parameters
    $stmt->bind_param("iis", $user_id, $job_id, $start_time);

    // If couldn't execute the statement, return error
    if (!$stmt->execute())
    {
        return [
            "error" => "Could not try to clock-in",
            "error_code" => "excecution_error"
        ];
    }

    // Grab the id
    $worksession_id = $conn->insert_id;

    // Grab relevant clock in data to return
    $newWorkSession = [
        "id" => $worksession_id,
        "start_time" => $start_time,
        "user_id" => $user_id,
        "job_id" => $job_id
    ];

    // Close the statement
    $stmt->close();

    return $newWorkSession;
}

function clockOutJob($worksession_id, $end_time)
{
    /** Update an existing worksession record in order to clock out */

    // Establish a DB transaction for two SQL queries
    // First query: Update End-Time to Work Session
    // Second Query: Insert Difference Between End-Time and Start-Time
    global $conn;

    // Create final message assoc
    $finalMsgAssoc = [];

    $end_time_sql = "UPDATE worksessions SET end_time = ? WHERE id = ?";
    $timediff_sql = "UPDATE worksessions SET duration = TIMEDIFF(end_time, start_time) WHERE id = ?";

    // Begin a DB Transaction
    $conn->begin_transaction();

    // Try/catch block for transaction
    try
    {
        // Set up end time first
        $endTimeStmt = $conn->prepare($end_time_sql);

        if (!$endTimeStmt)
        {
            // JSON encode exception error message
            $endTimePreparationErrorAssoc = [
                'error' => 'Could not prepare to clock-out',
                'error_code' => 'preparation_error'
            ];

            throw new Exception(json_encode($endTimePreparationErrorAssoc));
        }

        // Bind parameters for end time
        $endTimeStmt->bind_param("si", $end_time, $worksession_id);

        // If there is an error updating the worksession return an error
        if (!$endTimeStmt->execute())
        {
            // JSON encode exception error message
            $endTimeExcecutionError = [
                'error' => 'Could not try to clock-out',
                'error_code' => 'excecution_error'
            ];

            throw new Exception(json_encode($endTimeExcecutionError));
        }

        // Now make a statement for the second query
        $durationStmt = $conn->prepare($timediff_sql);

        if (!$durationStmt)
        {
            // JSON encode exception error message
            $durationPreparationErrorAssoc = [
                'error' => 'Could not prepare to calculation work shift duration',
                'error_code' => 'preparation_error'
            ];

            throw new Exception(json_encode($durationPreparationErrorAssoc));
        }

        // Bind worksession id
        $durationStmt->bind_param("i", $worksession_id);

        // Throw error if couldn't update
        if (!$durationStmt->execute())
        {
            // JSON encode exception error message
            $durationExcecutionErrorAssoc = [
                'error' => 'Could not try to calculate work shift duration',
                'error_code' => 'excecution_error'
            ];

            throw new Exception(json_encode($durationExcecutionErrorAssoc));
        }

        // Close statements
        $endTimeStmt->close();
        $durationStmt->close();

        // Confirm all transactions
        $conn->commit();

        // Prepare success message
        $finalMsgAssoc["message"] = "Clocked Out Successfully";
    }

    catch (Exception $e)
    {
        // If one interaction fails, remove all changes made to the DB
        $conn->rollback();

        // Grab error message
        $error_msg = $e->getMessage();

        // Json Decode
        $decoded_message = json_decode($e->getMessage());

        // If it is null, then make the assoc yourself
        if ($decoded_message == NULL)
        {
            $finalMsgAssoc["error"] = $error_msg;
        }

        else
        {
            $finalMsgAssoc["error"] = $decoded_message;
        }
    }

    return $finalMsgAssoc;
}

?>