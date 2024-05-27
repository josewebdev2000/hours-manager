"use strict";

/**  Script for the Contact Page to handle AJAX to send email */
function mainContact()
{
    // Initialize summernote
    initializeSummerNote();
}

function initializeSummerNote()
{
    $('#message').summernote({
        height: 300,
        width: "100%",
        placeholder: "Write your message here"
    });
}

$(document).ready(mainContact);