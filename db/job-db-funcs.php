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
            $endingHour = $workingDayData["endingHour"];

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

function getAllJobsOfUserForJobsPage($user_id)
{
    /** Extract All Jobs From The DB */
    global $conn;

    // Prepare a SQL statement to grab all jobs

    $sql = "SELECT 
    j.title AS job_title,
    j.role AS job_role,
    j.id AS job_id, 
    e.name AS employer_name,
    p.rate_amount AS pay_rate_amount, 
    p.rate_type AS pay_rate_type,
    GROUP_CONCAT(DISTINCT wd.day ORDER BY FIELD(wd.day, 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday')) AS working_days, 
    pr.payment_day AS payroll_day
    FROM 
    jobs j
    INNER JOIN 
    payrates p ON j.id = p.job_id AND j.user_id = p.user_id
    LEFT JOIN 
    workingdays wd ON j.id = wd.job_id AND j.user_id = wd.user_id
    INNER JOIN 
    payrolls pr ON j.id = pr.job_id AND j.user_id = pr.user_id
    INNER JOIN
    employers e ON e.id = j.employer_id AND e.user_id = j.user_id
    WHERE 
    j.user_id = ?
    GROUP BY 
    j.id
    ORDER BY 
    j.title";

    // Make a prepared SQL statement
    $stmt = $conn->prepare($sql);

    // If statement could not be prepared return an early error assoc
    if (!$stmt)
    {
        return [
            "error" => "Could not prepare to get jobs data",
            "error_code" => "preparation_error"
        ];
    }

    // Bind the user_id parameter as an integer
    $stmt->bind_param("i", $user_id);

    // Execute the statement
    // If there is an error, return early
    if (!$stmt->execute())
    {
        return [
            "error" => "Could not try to get jobs",
            "error_code" => "excecution_error"
        ];
    }

    // Grab the result
    $result = $stmt->get_result();

    // If the result has no rows, then return jobs not found error
    if ($result->num_rows == 0)
    {
        return [
            "error" => "Could not find any jobs",
            "error_code" => "jobs_not_found_error"
        ];
    }

    // If there were jobs found, grab them
    $jobs = [];

    // Loop through all jobs and add them to the jobs array
    while ($job = $result->fetch_assoc())
    {
        $jobs[$job["job_id"]] = $job;
    }

    // Close the statement
    $stmt->close();

    // Return jobs array
    return $jobs;
}

function getJobOfUserById($user_id, $job_id)
{
    /** Extract A Job For The DB */
    global $conn;

    // Prepare SQL statement to grab a job by its id
    $sql = "SELECT 
    j.title AS job_title,
    j.role AS job_role,
    j.id AS job_id, 
    j.address AS job_address,
    j.description AS job_description,
    e.name AS employer_name,
    e.email AS employer_email,
    e.phone_number AS employer_phone_number,
    p.rate_amount AS pay_rate_amount, 
    p.rate_type AS pay_rate_type,
    p.effective_date AS effective_date,
    pr.payment_day AS payroll_day,
    pr.pay_period_start AS starting_day,
    pr.pay_period_end AS ending_day,
    pr.total_hours AS total_hours,
    pr.total_payment AS total_pay,
    pr.tips AS tip
    FROM 
    jobs j
    INNER JOIN 
    payrates p ON j.id = p.job_id AND j.user_id = p.user_id
    INNER JOIN 
    payrolls pr ON j.id = pr.job_id AND j.user_id = pr.user_id
    INNER JOIN
    employers e ON e.id = j.employer_id AND e.user_id = j.user_id
    WHERE 
    j.user_id = ?
    AND
    j.id = ?
    GROUP BY 
    j.id
    ORDER BY 
    j.title";

    // Make a prepared SQL statement
    $stmt = $conn->prepare($sql);

    // If the statement could not be prepared, return an error
    if (!$stmt)
    {
        return [
            "error" => "Could not prepare to get job by its id",
            "error_code" => "preparation_error"
        ];
    }

    // Bind user_id and job_id parameters
    $stmt->bind_param("ii", $user_id, $job_id);

    // Execute the statement
    // If there was an error, return an error assoc
    if (!$stmt->execute())
    {
        return [
            "error" => "Could not try to get job by its id",
            "error_code" => "excecution_error"
        ];
    }

    // Grab the result
    $result = $stmt->get_result();

    // If the result does not have one row, return not found
    if ($result->num_rows != 1)
    {
        return [
            "error" => "Could not find job by its id",
            "error_code" => "job_not_found_error"
        ];
    }

    // If the job was found, return it as a PHP assoc
    $job = $result->fetch_assoc();

    // Close the statement
    $stmt->close();

    return $job;
}

?>
