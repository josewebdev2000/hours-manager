<?php require_once __DIR__ . "/../utils/constants.php";

/** Validation Functions Meant to be used throughout many PHP scripts */
function validateEmployerData($employerData)
{
    // Check employer name
    if (!isset($employerData["employerName"]))
    {
        return ["error" => "Employer Name is not set"];
    }

    if (strlen($employerData["employerName"]) < 1)
    {
        return ["error" => "Employer Name cannot be empty"];
    }

    if (!preg_match(NAME_REGEX, $employerData["employerName"]))
    {
        return ["error" => "Invalid Employer Name"];
    }

    // Check employer email in case it is set
    if (isset($employerData["employerEmail"]) && strlen($employerData["employerEmail"]) >= 1)
    {
        if (!preg_match(EMAIL_REGEX, $employerData["employerEmail"]))
        {
            return ["error" => "Invalid Employer Email"];
        }
    }

    // Check employer phone number in case it is set
    if (isset($employerData["employerPhoneNumber"]) && $employerData["employerPhoneNumber"] != "+1 (___) ___ - ____")
    {
        if (!preg_match(PHONE_NUMBER_REGEX, $employerData["employerPhoneNumber"]))
        {
            return ["error" => "Invalid Employer Phone Number"];
        }
    }

    // Prepare data to be returned
    $employerName = strip_tags($employerData["employerName"]);
    $employerEmail = strip_tags($employerData["employerEmail"]);
    $employerPhoneNumber = strip_tags($employerData["employerPhoneNumber"]);

    // Return data in a safe format
    return [
        "employerName" => $employerName,
        "employerEmail" => $employerEmail,
        "employerPhoneNumber" => $employerPhoneNumber
    ];
}

function validateJobData($jobData)
{
    // Check Job Title
    if (!isset($jobData["jobTitle"]))
    {
        return ["error" => "Job Title is not set"];
    }

    if (strlen($jobData["jobTitle"]) < 1)
    {
        return ["error" => "Employer Name cannot be empty"];
    }

    // Check Job Role
    if (!isset($jobData["jobRole"]))
    {
        return ["error" => "Job Role is not set"];
    }

    if (strlen($jobData["jobRole"]) < 1)
    {
        return ["error" => "Job Role cannot be empty"];
    }

    // Prepare data to be returned
    $jobTitle = strip_tags($jobData["jobTitle"]);
    $jobRole = strip_tags($jobData["jobRole"]);
    $jobAddress = strip_tags($jobData["jobAddress"]);
    $jobDescription = strip_tags($jobData["jobDescription"]);

    return [
        "jobTitle" => $jobTitle,
        "jobRole" => $jobRole,
        "jobAddress" => $jobAddress,
        "jobDescription" => $jobDescription
    ];
}

function validatePayRateData($payRateData)
{
    // Check Rate Type
    if (strlen($payRateData["rateType"]) < 1)
    {
        return ["error" => "Rate Type cannot be empty"];
    } 

    if (!in_array($payRateData["rateType"], RATES))
    {
        return ["error" => "Unrecognized Rate Type"];
    }

    // Check Rate Amount
    if (!is_numeric($payRateData["rateAmount"]))
    {
        return ["error" => "Rate Amount must be a number"];
    }

    if ($payRateData["rateAmount"] <= 0)
    {
        return ["error" => "Rate Amount must be a positive number"];
    }

    // Check Effective Date
    if (strlen($payRateData["effectiveDate"]) < 1)
    {
        return ["error" => "Effective Date cannot be empty"];
    }

    if (!isValidDate($payRateData["effectiveDate"]))
    {
        return ["error" => "Invalid Date Format"];
    }

    // Prepare data to be returned
    $rateType = strip_tags($payRateData["rateType"]);
    $rateAmount = strip_tags($payRateData["rateAmount"]);
    $effectiveDate = strip_tags($payRateData["effectiveDate"]);

    return [
        "rateType" => $rateType,
        "rateAmount" => $rateAmount,
        "effectiveDate" => convertDateToMySQLDate($effectiveDate)
    ];
}

function validatePayRollData($payRollData)
{
    // Check Starting Day
    if (!in_array($payRollData["startingDay"], DAYS))
    {
        return ["error" => "Invalid Starting Day"];
    }

    // Check Ending Day
    if (!in_array($payRollData["endingDay"], DAYS))
    {
        return ["error" => "Invalid Ending Day"];
    }

    // Check Payment Day
    if (!in_array($payRollData["paymentDay"], DAYS))
    {
        return ["error" => "Invalid Payment Day"];
    }

    // Check Total Hours
    if (!is_numeric($payRollData["totalHours"]))
    {
        return ["error" => "Total Hours must be a number"];
    }

    if ($payRollData["totalHours"] < 1)
    {
        return ["error" => "Total Hours must be a positive number"];
    }

    // Check Total Payment
    if (!is_numeric($payRollData["totalPay"]))
    {
        return ["error" => "Total Payment must be a number"];
    }

    if ($payRollData["totalPay"] < 1)
    {
        return ["error" => "Total Payment must be a positive number"];
    }

    // In case Tip is set, use it
    if (is_numeric($payRollData["tip"]))
    {
        if ($payRollData["tip"] < 0)
        {
            return ["error" => "Tip cannot be negative"];
        }
    }

    if (!is_numeric($payRollData["tip"]) && strlen($payRollData["tip"]) > 0)
    {
        return ["error" => "Tip must be a number"];
    }

    // Prepare Data To Be Returned
    $startingDay = strip_tags($payRollData["startingDay"]);
    $endingDay = strip_tags($payRollData["endingDay"]);
    $paymentDay = strip_tags($payRollData["paymentDay"]);
    $totalHours = strip_tags($payRollData["totalHours"]);
    $totalPay = strip_tags($payRollData["totalPay"]);
    $tip = strip_tags($payRollData["tip"]);

    return [
        "startingDay" => ucfirst($startingDay),
        "endingDay" => ucfirst($endingDay),
        "paymentDay" => ucfirst($paymentDay),
        "totalHours" => $totalHours,
        "totalPay" => $totalPay,
        "tip" => $tip
    ];
}

function validateWorkShiftData($workShiftsData)
{
    // Prepare Work Shifts Array
    $workShifts = [];

    foreach ($workShiftsData as $workShiftData)
    {
        // If any day is invalid, return error
        if (!in_array(strtolower($workShiftData["day"]), DAYS))
        {
            return ["error" => "Invalid Work Shift Day"];
        }

        // If the starting hour is invalid, return error "from"
        if (!isValidTime($workShiftData["from"]))
        {
            return ["error" => "Invalid Time Format"];
        }

        // If the ending hour is invalid, return error
        if (!isValidTime($workShiftData["to"]))
        {
            return ["error" => "Invalid Time Format"];
        }

        // Prepare values to be returned
        $workShift = [
            "day" => strip_tags($workShiftData["day"]),
            "startingHour" => convertTimeToMySQLTime(strip_tags($workShiftData["from"])),
            "endingHour" => convertTimeToMySQLTime($workShiftData["to"])
        ];

        $workShifts[] = $workShift;
    }

    return $workShifts;
}

function isValidDateTime($dateTimeString)
{
    $format = 'Y-m-d H:i:s'; // MySQL DATETIME format
    $dateTime = DateTime::createFromFormat($format, $dateTimeString);

    // Check if the parsing succeeded and the resulting date matches the input
    return $dateTime && $dateTime->format($format) === $dateTimeString;
}

function isValidDate($dateStr)
{
    // Check a Date String that comes from the front-end
    // Return True if date in format yyyy-mm-dd
    $php_date_rep = DateTime::createFromFormat("Y-m-d", $dateStr);

    return $php_date_rep && $php_date_rep->format("Y-m-d") == $dateStr;
}

function convertDateToMySQLDate($dateStr)
{
    $php_date_obj = DateTime::createFromFormat("Y-m-d", $dateStr);

    return $php_date_obj->format("Y-m-d");
}

function convertTimeToMySQLTime($timeString)
{
        // Create a DateTime object from the time string
        $dateTime = DateTime::createFromFormat('h:i A', $timeString);

        // Check if the DateTime object was created successfully and matches the input format
        if ($dateTime && $dateTime->format('h:i A') === $timeString) 
        {
            // Convert the time to MySQL TIME format
            return $dateTime->format('H:i:s');
        } 
        else
        {
            // Return false if the time format is invalid
            return false;
        }
}

function isValidTime($timeStr)
{
    // Check a Time String that comes from the front-end
    // Return True if time in format hh:mm A
    $php_time_rep = DateTime::createFromFormat("h:i A", $timeStr);

    return $php_time_rep && $php_time_rep->format("h:i A") == $timeStr;
}
?>