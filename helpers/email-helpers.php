<?php 
/** PHP Reused to deal with email operations */
require_once __DIR__ . "/../vendor/autoload.php";

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

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