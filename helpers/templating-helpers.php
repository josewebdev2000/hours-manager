<?php
/** PHP Reusable Functions Meant to Help with Templating in PHP */
function get_profile_pic_html_code($user, $class_str, $img_size, $default_pic_url)
{
    /** Show the user's profile picture according to if it is set or not */
    if (isset($user) && isset($user["pic_url"]))
    {
        // Grab relevant data
        $username = $user["name"];
        $pic_url = $user["pic_url"];

        // Use it for the img
        return "<img class='$class_str' width='$img_size' src='$pic_url' alt='$username Profile Picture'>";
    }

    else
    {
        return "<img class='$class_str' width='$img_size' src='$default_pic_url' alt='User Profile Picture'>";
    }
}
?>