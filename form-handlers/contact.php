<?php 
// Set error reporting level
error_reporting(E_ALL);

// Enable displaying errors
ini_set('display_errors', 1);

require_once "../helpers/index.php"; 
require_once "../envs.php";

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once '../vendor/autoload.php';

loadEnvVarsWhenRequired();

/** Handle POST Request for Contact Page */

if (is_post_request())
{
    // Grab Data that comes from JSON
    $contact_data = get_json_request();

    /** Data is Grabbed Without Hanging */

    // Validate Contact data
    $validation_assoc = validate_contact_data($contact_data);

    /** Validation Runs Without Hanging */

    // Try to send Email
    if (array_key_exists("success", $validation_assoc))
    {
        // Send no reply email and admin message email
        /** Scripts HANGS AROUND HERE
         * RESEARCH SEND_HTML_EMAIL FUNCTION and OTHERS
         */
        $no_reply_result = send_html_email($contact_data, "build_no_reply_email_for_user");

        if (array_key_exists("success", $no_reply_result))
        {
            return send_json_response($no_reply_result);
        }

        else
        {
            return send_json_error_response($no_reply_result, 500);
        }
    }

    // Send Early JSON HTTP Response
    else
    {
        return send_json_error_response($validation_assoc, 400);
    }

}

function validate_contact_data($contact_assoc)
{
    /** Validate Received Contact Data */
    
    // First, check all expected JSON fields are set
    $expected_fields = ["name", "email", "subject", "request"];

    // Check that none of the field values is empty
    foreach ($expected_fields as $field)
    {
        // Return error if one of the fields is not set
        if (!array_key_exists($field, $contact_assoc))
        {
            return ["error" => "$field is not set"];
        }

        // Return an error if one of the fields is empty
        if (empty($contact_assoc[$field]))
        {
            return ["error" => "$field has no value"];
        }
    }

    // Now grab each field value and run a check for each
    $name = $contact_assoc["name"];
    $email = $contact_assoc["email"];
    $subject = $contact_assoc["subject"];
    $request = $contact_assoc["request"];

    // Run checks for name regex
    $nameRegex = "/^[A-Za-z\s.,:;]+$/";

    if (!preg_match($nameRegex ,$name)) 
    {
        return ["error" => "Name can only contain letters and white space allowed"];
    }

    // Run checks for email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL))
    {
        return ["error" => "Invalid Email Address was provided"];
    }

    // By this point, return a success assoc
    return ["success" => ""];
}

function build_no_reply_email_for_user($email_assoc)
{
    /** Function to build automatic email user will get as soon as he sent an email to contact page
     * Return an assoc with the following elements
     * htmlMessage: HTML String representing the email content to be sent,
     * sender: Email Address of the sender of this email
     * senderPass: Password for sender
     * recipient: Email Address of the recipient of this email
     */

     // Grab the current year for the date section of the copyright
     $current_year = date("Y");

     // Grab the HTML email template for no reply
     $no_reply_template_string = file_get_contents("../email-templates/no-reply.html");

     /** Script Hangs Around Here */
     //return send_json_response($email_assoc);

     // Replace placeholders for actual data
     $no_reply_template_string = str_replace("{{NAME}}", $email_assoc["name"], $no_reply_template_string);
     $no_reply_template_string = str_replace("{{DATE}}", $current_year, $no_reply_template_string);

     $result_assoc = [
        "htmlMessage" => $no_reply_template_string,
        "host" => $_ENV["SMTP_HOST"],
        "from" => "No Reply HoursManager Email Sender",
        "subject" => $email_assoc["subject"],
        "sender" => $_ENV["SMTP_NO_REPLY_USER"],
        "senderPass" => $_ENV["SMTP_NO_REPLY_PASS"],
        "recipient" => $email_assoc["email"]
     ];

     return $result_assoc;

}

function send_html_email($email_assoc, $email_template_building_function)
{
    /** Send an Email with an HTML Template */

    // Call the email template building function
    $building_response_assoc = call_user_func($email_template_building_function ,$email_assoc);

    // Generate a new instance of PHP Mailer
    $mailer = new PHPMailer(true);

    try
    {
        // Configure creds according to the assoc gotten from the template building function
        $mailer->SMTPDebug = 0;
        $mailer->isSMTP();
        $mailer->isHTML(true);
        $mailer->SMTPAuth = true;
        $mailer->Host = $building_response_assoc["host"];
        $mailer->Username = $building_response_assoc["sender"];
        $mailer->Password = $building_response_assoc["senderPass"];
        // $mailer->SMTPSecure = 'tls'; // Use TLS encryption
        $mailer->Port = 587;

        // Set the email of the sender as the SMTP email
        $mailer->setFrom($building_response_assoc["sender"], $building_response_assoc['from']);
        $mailer->addAddress($building_response_assoc['recipient']);
        $mailer->Subject = $building_response_assoc['subject'];
        $mailer->Body = $building_response_assoc['htmlMessage'];

        // Set a timeout for the send operation
        $timeout_seconds = 30; // Adjust as needed
        $mailer->Timeout = $timeout_seconds;

        // Send the email
        if (!$mailer->send()) 
        {
            throw new Exception('Failed to send email: ' . $mailer->ErrorInfo);
        }
    }

    catch (Exception $e)
    {
        return ["error" => $e->getMessage()];
    }

    return ["success" => "Email could be successfully sent"];
}

?>