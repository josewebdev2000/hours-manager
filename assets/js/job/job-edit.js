"use strict";

/** JS Script for editing a job to job.php page */
function mainEditJob()
{
    // Show Success Feedback in case there is any
    showEditSuccessFeedback();

    // Execute Operations to Cancel Job Edition
    cancelJobEdition();

    // Send AJAX Request To Backend
    sendEditJobAJAXRequestToBackend();
}

function cancelJobEdition()
{
    $("button#edit-job-cancel-btn").on("click", redirectToDashboard);
}

function showEditSuccessFeedback()
{
    const successResponse = sessionStorage.getItem("successResponse");

    if (successResponse)
    {
        const msg = JSON.parse(successResponse)["message"];

        smoothlyScrollToTop(".content-wrapper");
        displayFormSuccessAlert("job-page-content-wrapper", msg, false);
        
        sessionStorage.removeItem("successResponse");
    }
}

function sendEditJobAJAXRequestToBackend()
{
    // Add event listener to edit job btn to send AJAX request to backend
    $("#edit-job-btn").on("click", function (e) {

        // Prevent Default Behaviour
        e.preventDefault();

        // Prepare data to be sent to the user
        // Grab user id
        const user_id = $("#user_id").val();

        // Grab employer id
        const employer_id = $("#edit_employer_id").val();

        // Grab job id
        const job_id = $("#edit_job_id").val();

        // Get employer data
        const employerData = {
            employerName: $("#edit-employer-name").val(),
            employerEmail: $("#edit-employer-email").val(),
            employerPhoneNumber: $("#edit-employer-phone-number").val()
        };

        // Get Job Data
        const jobData = {
            jobTitle: $("#edit-job-title").val(),
            jobRole: $("#edit-job-role").val(),
            jobAddress: $("#edit-job-address").val(),
            jobDescription: $("#edit-job-description").val()
        };

        // Get pay rate data
        const payRateData = {
            rateType: $("#edit-rate-type").val(),
            rateAmount: $("#edit-rate-amount").val(),
            effectiveDate: $("#edit-effective-date").val()
        };

        // Get pay roll data in an obj
        const payRollData = {
            startingDay: $("#edit-starting-day").val(),
            endingDay: $("#edit-ending-day").val(),
            paymentDay: $("#edit-payment-day").val(),
            totalHours: $("#edit-total-hours").val(),
            totalPay: $("#edit-total-pay").val(),
            tip: $("#edit-tips").val()
        }

        // Prepare JSON payload to send
        const data = JSON.stringify({
            "employer_id": employer_id,
            "job_id": job_id,
            "employer": employerData,
            "job": jobData,
            "pay_rate": payRateData,
            "pay_roll": payRollData,
            "work_shifts": []
        });

        // Do an AJAX request
        $.ajax({
            url: `${websiteURL}form-handlers/edit-job.php`,
            method: "POST",
            contentType: "application/json",
            data,
            beforeSend: function() {
                // Disable Edit Job Btn temporarily
                $("#edit-job-btn").prop("disabled", true);
            },
            success: function (response)
            {
                // Set in Session Storage the JSONification of the response
                sessionStorage.setItem("successResponse", JSON.stringify(response));

                // Refresh this page in case of success
                location.reload();
            },
            error: function (xhr)
            {

                // Smoothly scroll back to top
                smoothlyScrollToTop(".content-wrapper");

                // Show error alert
                let errorMsg = "Job Coult Not Be Editted";

                if (xhr.responseJSON["error"])
                {
                    errorMsg = xhr.responseJSON["error"];
                }

                displayFormErrorAlert("job-page-content-wrapper", errorMsg, false);                 
            },
            complete: function () {
                // Enable the button back
                $("#edit-job-btn").prop("disabled", false);
            }
        });
    });
}

$(document).ready(mainEditJob);