<?php 
// Set error reporting level
error_reporting(E_ALL);

// Enable displaying errors
ini_set('display_errors', 1);

require_once __DIR__ . "/../helpers/index.php"; 
require_once __DIR__ . "/../private/index.php";

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
        "host" => SMTP_HOST,
        "from" => "No Reply HoursManager Email Sender",
        "subject" => $email_assoc["subject"],
        "sender" => SMTP_NO_REPLY_USER,
        "senderPass" => SMTP_NO_REPLY_PASS,
        "recipient" => $email_assoc["email"]
     ];

     return $result_assoc;

}

?>