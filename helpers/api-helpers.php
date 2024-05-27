<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
/** PHP Reused code that has to do with dealing with external API services */
require_once __DIR__ . "/../vendor/autoload.php";

// Set up Cloudinary Work Environment
use Cloudinary\Cloudinary;

function init_cloudinary($cloud_name, $api_key, $api_secret)
{
    /** Initialize Cloudinary for later usage */
    $cloudinary = new Cloudinary(
        [
            'cloud' => [
                'cloud_name' => $cloud_name,
                'api_key'    => $api_key,
                'api_secret' => $api_secret,
            ],
        ]
    );

    return $cloudinary;
}

function upload_base64_to_cloudinary($cloudinary_obj, $base64_data, $image_id)
{
    /** Upload the Base64 data of an image to cloudinary */
    return $cloudinary_obj->uploadApi()->upload(
        $base64_data,
        ["public_id" => $image_id]
    );
}

function replace_base64_with_urls($htmlSnippet)
{
    /** Replace Base 64 Image Sources with URLS from the API */

    // Parse the HTML content
    $dom = new DOMDocument();
    $dom->loadHTML($htmlSnippet, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);

    // Iterate through all <img> tags
    $images = $dom->getElementsByTagName('img');

    foreach ($images as $image) 
    {
        // Get the src attribute
        $src = $image->getAttribute('src');
        
        // Check if the src is a base-64 encoded image
        if (strpos($src, 'data:image') === 0) 
        {
            // Replace the src attribute with the URL returned by the API
            /*$api_res_assoc = request_to_upload_img_base_64_src_online($_ENV["API_KEY_PY_PIC"], $src, "pic");
            
            if (isset($api_res_assoc["img_url"]))
            {
                $image->setAttribute('src', $api_res_assoc["img_url"]);
            }
            */

            // Initialize Cloudinary for the Image API to use it
            $cloudinary = init_cloudinary(
                $_ENV["API_CLOUDINARY_CLOUD_NAME"], 
                $_ENV["API_CLOUDINARY_API_KEY"], 
                $_ENV["API_CLOUDINARY_API_SECRET"]
            );

            // Upload the Image to Cloudinary to get the URL of the image to be sent
            // Generate a Unique ID for each image
            $img_url = upload_base64_to_cloudinary($cloudinary, $src, uniqid('', true))["secure_url"];

            // Grab the image url from the response
            $image->setAttribute("src", $img_url);
        }
    }

    // Save the modified HTML
    $modifiedHtml = $dom->saveHTML();

    return $modifiedHtml;
}
?>