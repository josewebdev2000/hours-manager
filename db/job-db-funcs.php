<?php 
    require_once "conn.php";
    require_once __DIR__ . "/../helpers/index.php";

    /** PHP File that deals with DB interactions regarding the Job Entity/Table */

function insertNewJob($userId, $employerData, $jobData, $payRateData, $payRollData, $workShiftsData)
{
    global $conn;

    // Create final message assoc
    $finalMsgAssoc = [];

    // Need to insert employer, job, pay rate, pay roll, and schedule entries alltogether

    // Prepare SQL Code used to insert all entries into the DB
    $employer_sql = "INSERT INTO employers (user_id, name, email, phone_number) VALUES (?, ?, ?, ?)";
    $job_sql = "INSERT INTO jobs (user_id, employer_id, title, role, address, description) VALUES (?, ?, ?, ?, ?, ?)";
    $payrate_sql = "INSERT INTO payrates (user_id, job_id, rate_type, rate_amount, effective_date) VALUES (?, ?, ?, ?, ?)";
    $payroll_sql = "INSERT INTO payrolls (user_id, job_id, pay_period_start, pay_period_end, payment_day, total_hours, total_payment, tips) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
    $workingday_sql = "INSERT INTO workingdays (user_id, job_id, day, start_time, end_time) VALUES (?, ?, ?, ?, ?)";

    // Begin a DB Transaction
    $conn->begin_transaction();

    // Try catch block for transaction
    try
    {
        // Try to insert employer data first
        $employerName = $employerData["employerName"];
        $employerEmail = (strlen($employerData["employerEmail"]) > 0) ? $employerData["employerEmail"] : NULL;
        $employerPhoneNumber = (strlen($employerData["employerPhoneNumber"]) > 0) ? $employerData["employerPhoneNumber"] : NULL;

        // Create employer statement
        $employerStmt = $conn->prepare($employer_sql);

        if (!$employerStmt)
        {
            // JSON encode exception error messages
            $employerPreparationErrorAssoc = [
                'error' => 'Could not prepare to insert a new employer', 
                'error_code' => 'preparation_error'
            ];

            throw new Exception(json_encode($employerPreparationErrorAssoc));
        }

        // Bind parameters for employer
        $employerStmt->bind_param("isss", $userId, $employerName, $employerEmail, $employerPhoneNumber);

        // If there is an error inserting the new employer, throw an error
        if (!$employerStmt->execute())
        {
            // JSON encode exception error messages
            $employerExcecutionErrorAssoc = [
                'error' => 'Could not try to insert a new employer',
                'error_code' => 'excecution_error'
            ];

            throw new Exception(json_encode($employerExcecutionErrorAssoc));
        }

        // Grab the id of the last employer inserted
        $employerId = $conn->insert_id;

        // Get data to insert new job
        $jobTitle = $jobData["jobTitle"];
        $jobRole = $jobData["jobRole"];
        $jobAddress = (strlen($jobData["jobAddress"]) > 0) ? $jobData["jobAddress"] : NULL;
        $jobDescription = (strlen($jobData["jobDescription"]) > 0) ? $jobData["jobDescription"] : NULL;

        // Create job statement
        $jobStmt = $conn->prepare($job_sql);

        if (!$jobStmt)
        {
            // JSON encode error messages
            $jobPreparationErrorAssoc = [
                'error' => 'Could not prepare to insert a new job',
                'error_code' => 'preparation_error'
            ];

            throw new Exception(json_encode($jobPreparationErrorAssoc));
        }

        // Bind parameters for job
        $jobStmt->bind_param("iissss", $userId, $employerId, $jobTitle, $jobRole, $jobAddress, $jobDescription);

        // If there is an error inserting the new job, throw it
        if (!$jobStmt->execute())
        {
            // JSON encode error messages
            $jobExcecutionErrorAssoc = [
                'error' => 'Could not try to insert a new job',
                'error_code' => 'excecution_error'
            ];

            throw new Exception(json_encode($jobExcecutionErrorAssoc));
        }

        // Grab the id of the last inserted job
        $jobId = $conn->insert_id;

        // Now insert a new pay rate
        $rateType = $payRateData["rateType"];
        $rateAmount = $payRateData["rateAmount"];
        $effectiveDate = $payRateData["effectiveDate"];

        // Create pay rate statement
        $payRateStmt = $conn->prepare($payrate_sql);

        if (!$payRateStmt)
        {
            $payRatePreparationErrorAssoc = [
                'error' => 'Could not prepare to insert a new pay rate',
                'error_code' => 'preparation_error'
            ];

            throw new Exception(json_encode($payRatePreparationErrorAssoc));
        }

        // Bind parameters for pay rate
        $payRateStmt->bind_param("iisss", $userId, $jobId, $rateType, $rateAmount, $effectiveDate);

        // If pay rate couldn't be inserted, throw an error
        if (!$payRateStmt->execute())
        {
            $payRateExcecutionErrorAssoc = [
                'error' => 'Could not try to insert a new pay rate',
                'error_code' => 'excecution_error'
            ];

            throw new Exception(json_encode($payRateExcecutionErrorAssoc));
        }

        // Grab data to insert new pay roll
        $startingDay = $payRollData["startingDay"];
        $endingDay = $payRollData["endingDay"];
        $paymentDay = $payRollData["paymentDay"];
        $totalHours = $payRollData["totalHours"];
        $totalPay = $payRollData["totalPay"];
        $tip = (is_numeric($payRollData["tip"])) ? $payRollData["tip"] : NULL;

        // Create pay roll statement
        $payRollStmt = $conn->prepare($payroll_sql);

        if (!$payRollStmt)
        {
            $payRollPreparationErrorAssoc = [
                'error' => 'Could not prepare to insert a new pay roll',
                'error_code' => 'preparation_error'
            ];

            throw new Exception(json_encode($payRollPreparationErrorAssoc));
        }

        // Bind parameters for pay roll
        $payRollStmt->bind_param("iisssiii", $userId, $jobId, $startingDay, $endingDay, $paymentDay, $totalHours, $totalPay, $tip);

        // If insert new pay roll failed, then throw a new exception
        if (!$payRollStmt->execute())
        {
            $payRollExcecutionErrorAssoc = [
                'error' => 'Could not try to insert a new pay roll',
                'error_code' => 'excecution_error'
            ];

            throw new Exception(json_encode($payRollExcecutionErrorAssoc));
        }

        // Create statement to insert work days
        $workShiftStmt = $conn->prepare($workingday_sql);

        if (!$workShiftStmt)
        {
            $workingDayPreparationErrorAssoc = [
                'error' => 'Could not prepare to insert a new working day',
                'error_code' => 'preparation_error'
            ];

            throw new Exception(json_encode($workingDayPreparationErrorAssoc));
        }

        // Have placeholders for working days data
        $day = "";
        $startingHour = "";
        $endingHour = "";

        // Bind parameters for working day stmt
        $workShiftStmt->bind_param("iisss", $userId, $jobId, $day, $startingHour, $endingHour);

        // Insert each record in the workShiftsData
        foreach ($workShiftsData as $workingDayData)
        {
            // Dynamically change values of placeholders according to what is the workingDay
            $day = $workingDayData["day"];
            $startingHour = $workingDayData["startingHour"];
            $endingHour = $workingData["endingHour"];

            // If inserting the record failed, throw an exception
            if (!$workShiftStmt->execute())
            {
                $workingDayExcecutionErrorAssoc = [
                    'error' => 'Could not try to insert new working day',
                    'error_code' => 'excecution_error'
                ];

                throw new Exception(json_encode($workingDayExcecutionErrorAssoc));
            }
        }
        
        // Close all statements by this point
        $employerStmt->close();
        $jobStmt->close();
        $payRateStmt->close();
        $payRollStmt->close();
        $workShiftStmt->close();

        // Confirm all insertions into the DB
        $conn->commit();

        // Prepare success message
        $finalMsgAssoc["message"] = "New $jobRole Job could be addedd successfully";
    }

    catch (Exception $e)
    {
        // If one insertion fail, remove all others so the DB returns to its previous state
        $conn->rollback();

        // Grab error message
        $error_msg = $e->getMessage();

        var_dump($error_msg);

        // Json Decode
        $decoded_message = json_decode($e->getMessage());

        // If it is null, then make the assoc yourself
        if ($decoded_message == NULL)
        {
            $finalMsgAssoc["error"]  = $error_msg;
        }

        else
        {
            $finalMsgAssoc["error"]  = $decoded_message;
        }
    }
    
    return $finalMsgAssoc;
}

?>
