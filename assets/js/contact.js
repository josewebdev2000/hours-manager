"use strict";

function mainContact()
{
    // Initialize Summernote to it looks pretty
    initializeSummerNote();

    // reset contact form on reload
    resetContactForm();

    // Validate the contact form
    validateAndSubmitContactForm();
}

function initializeSummerNote()
{
    $('.summernote').summernote({
        height: 300,
        width: "100%",
        placeholder: "Write your message here"
    });
}

function resetContactForm()
{
    $(window).on("beforeunload", function () {
        $("#name").val("");
        $("#email").val("");
        $("#subject").val("");
        $("#message").summernote("code", "");
    });
}

/** Write Code for Front-End Contact Form Validation and AJAX Sending */
function validateAndSubmitContactForm()
{
    // Validate the name input
    $("#name").on({
        input: () => nameValidate("name"),
        focus: () => formControlFocusValidate("name"),
        blur: () => formControlBlurValidate("name")
    });

    // Validate the email input
    $("#email").on({
        input: () => emailValidate("email"),
        focus: () => formControlFocusValidate("email"),
        blur: () => formControlBlurValidate("email")
    });

    // Validate the subject input
    $("#subject").on({
        input: () => subjectValidate("subject"),
        focus: () => formControlFocusValidate("subject"),
        blur: () => formControlBlurValidate("subject")
    });

    // Validate the request element
    $("#message").on({
        "summernote.change": requestValidate,
        "summernote.focus": () => formControlFocusValidate("message"),
        "summernote.blur": () => formControlBlurValidate("message")
    });

    // Submit the form
    $("#contact-form").on("submit", function (e) {

        var doAjax = false;

        // Make sure form submission is handled by JS, not by HTML or PHP
        e.preventDefault();

        // Check all required form controls have the is-valid class

        const formControls = $(".form-control:not(.note-input)").toArray();

        for (let formControl of formControls)
        {
            if ($(formControl).hasClass("is-valid"))
            {
                doAjax = true;
            }

            else
            {
                doAjax = false;

                if ($("#form-alerts-container").children().length < 1)
                {
                    displayFormErrorAlert("form-alerts-container", "Contact Form Needs To Be Properly Filled");
                }

                break;
            }
        }

        // Perform AJAX Request if form has been properly filled
        if (doAjax)
        {
            // Grab actual values of all form controls
            const name = $("#name").val();
            const email = $("#email").val();
            const subject = $("#subject").val();
            const request = $("#message").summernote("code");

            // Form JSON string to send to the back-end
            const data = JSON.stringify({
                name,
                email,
                subject,
                request
            });

            // Grab original HTML content from submit button
            const submitBtnHTMLOri = $("#send").html();

            // Send AJAX Request
            $.ajax({
                url: `${websiteURL}form-handlers/contact.php`,
                method: "POST",
                contentType: "application/json",
                data,
                beforeSend: function () {
                    // Disable Send Button To Avoid Request Before Response
                    const sendBtn = $("#send");
                    sendBtn.html(loadingSpinner());
                    sendBtn.prop("disabled", true);
                },
                success: function (response) {
                    displayFormSuccessAlert("form-alerts-container", response["success"]);  
                },
                error: function (xhr) {
                    displayFormErrorAlert("form-alerts-container", xhr.responseJSON["error"]);
                },
                complete: function () {
                    // Enable Send Button To Avoid Request Before Response
                    const sendBtn = $("#send");
                    sendBtn.html(submitBtnHTMLOri);
                    sendBtn.prop("disabled", false);
                }
            });
        }
    });
}

function subjectValidate()
{
    const curSubject = $("#subject").val();

    if (curSubject.trim().length == 0)
    {
        $("#subject").removeClass("is-valid");
        $("#subject").addClass("is-invalid");
        $(".invalid-tooltip.subject").text("Subject cannot be empty");
    }

    else
    {
        $("#subject").removeClass("is-invalid");
        $(".invalid-tooltip.subject").text("");
        $("#subject").addClass("is-valid");
    }
}

function requestValidate()
{
    const curRequest = $("#message").summernote('code');

    if (curRequest.trim().length <= "<br>".length)
    {
        $("#message").removeClass("is-valid");
        $("#message").addClass("is-invalid");

        // You can customize the error message as needed
        $(".invalid-tooltip.message").text("Message cannot be empty");
    }
    else
    {
        $("#message").removeClass("is-invalid");
        $(".invalid-tooltip.message").text("");
        $("#message").addClass("is-valid");
    }
}

$(document).ready(mainContact);