"use strict";

/** JS Script for adding a job to job.php page */
function mainJob()
{
    // Initialize Phone Mask for Phone Number Input
    initializePhoneMask();

    // Execute Operations To Cancel A New Job
    cancelNewJob();

    // Validate Add Job Data
    validateAddJobData();

    // Send AJAX Request To Backend
    sendAddNewJobAJAXRequestToBackend();
}

function cancelNewJob()
{
    $("button#add-job-cancel-btn").on("click", redirectToDashboard);
}

function validateAddJobData()
{
    // Validate Employer Section
    $("#employer-name").on({
        input: () => requiredFieldValidate("employer-name"),
        focus: () => formControlFocusValidate("employer-name"),
        blur: () => formControlBlurValidate("employer-name")
    });

    // Validate Job Section
    $("#job-title").on({
        input: () => requiredFieldValidate("job-title"),
        focus: () => formControlFocusValidate("job-title"),
        blur: () => formControlBlurValidate("job-title")
    });

    $("#job-role").on({
        input: () => requiredFieldValidate("job-role"),
        focus: () => formControlFocusValidate("job-role"),
        blur: () => formControlBlurValidate("job-role")
    });

    // Validate Rate Type Section
    $("#rate-amount").on({
        input: () => requiredFieldValidate("rate-amount"),
        focus: () => formControlFocusValidate("rate-amount"),
        blur: () => formControlBlurValidate("rate-amount")
    });

    $("#effective-date").on({
        input: () => requiredFieldValidate("effective-date"),
        focus: () => formControlFocusValidate("effective-date"),
        blur: () => formControlBlurValidate("effective-date")
    });

    // Validate Pay Roll Data
    $("#total-hours").on({
        input: () => requiredFieldValidate("total-hours"),
        focus: () => formControlBlurValidate("total-hours"),
        blur: () => formControlBlurValidate("total-hours")
    });

    $("#total-pay").on({
        input: () => requiredFieldValidate("total-pay"),
        focus: () => formControlFocusValidate("total-pay"),
        blur: () => formControlBlurValidate("total-pay")
    });
}

function emptyAddJobFormFields()
{
    /** Empty form fields before unloading */

    // Empty all employer fields
    $("#employer-name").val("");
    $("#employer-email").val("");
    $("#employer-phone-number").val("+1 (___) ___ - ____");

    // Empty all job fields
    $("#job-title").val("");
    $("#job-role").val("");
    $("#job-address").val("");
    $("#job-description").val("");

    // Empty all pay rate fields
    $("#rate-type").val("Hourly");
    $("#rate-amount").val("");
    $("#effective-date").val("");

    // Empty all apy roll fields
    $("#pay-period-start").val("Monday");
    $("#pay-period-end").val("Monday");
    $("#payment-day").val("Monday");
    $("#total-hours").val("");
    $("#total-pay").val("");
    $("#tip-amount").val("");

    /*
    // Find a way to delete appointments from jqxScheduler
    const appointments = $("#schedule-calendar").jqxScheduler("getAppointments");

    appointments.forEach(appointment => {
        $("#schedule-calendar").jqxScheduler("deleteAppointment", appointment.jqxAppointment.id);
    });
    */
}

function sendAddNewJobAJAXRequestToBackend()
{
    // Add an event listener for the add new job button
    $("#add-job-new-btn").on("click", function (e) {

        // Prevent Default Behaviour
        e.preventDefault();

        // Prepare data to be sent to the user
        // Grab User Id
        const user_id = $("#user_id").val();

        // Get employer data in an obj
        const employerData = {
            employerName: $("#employer-name").val(),
            employerEmail: $("#employer-email").val(),
            employerPhoneNumber: $("#employer-phone-number").val()
        };

        // Get job data in an obj
        const jobData = {
            jobTitle: $("#job-title").val(),
            jobRole: $("#job-role").val(),
            jobAddress: $("#job-address").val(),
            jobDescription: $("#job-description").val(),
        };

        // Get pay rate data in an obj
        const payRateData = {
            rateType: $("#rate-type").val(),
            rateAmount: $("#rate-amount").val(),
            effectiveDate: $("#effective-date").val(),
        };

        // Get pay roll data in an obj
        const payRollData = {
            startingDay: $("#pay-period-start").val(),
            endingDay: $("#pay-period-end").val(),
            paymentDay: $("#payment-day").val(),
            totalHours: $("#total-hours").val(),
            totalPay: $("#total-pay").val(),
            tip: $("#tip-amount").val()
        };

        // Required Form Control Checks
        const requiredFormControls = [
            $("#employer-name"),
            $("#job-title"),
            $("#job-role"),
            $("#rate-amount"),
            $("#effective-date"),
            $("#total-hours"),
            $("#total-pay")
        ]; 

        // Control whehter AJAX request should be made
        var doAjax = false;

        for (let requiredFormControl of requiredFormControls)
        {
            if (requiredFormControl.hasClass("is-valid"))
            {
                doAjax = true;
            }

            else
            {
                doAjax = false;
                requiredFormControl.removeClass("is-valid");
                requiredFormControl.addClass("is-invalid");
            }
        }

        if (!doAjax)
        {
            displayFormErrorAlert("job-page-content-wrapper", "Add All Required Job Data", false);
        }


        // Prepare JSON payload to send
        const data = JSON.stringify({
            "user_id": user_id,
            "employer": employerData,
            "job": jobData,
            "pay_rate": payRateData,
            "pay_roll": payRollData,
            "work_shifts": []
        });

        if (doAjax)
        {
            // Run validation code once it is developed
            $.ajax({
                url: `${websiteURL}form-handlers/add-job.php`,
                method: "POST",
                contentType: "application/json",
                data,
                beforeSend: function() {
                    smoothlyScrollToTop(".content-wrapper");
                },
                success: function(response) {
                    // Show Success Alert When New Job Could Be Added
                    const message = response["message"];

                    displayFormSuccessAlert("job-page-content-wrapper", message, false);

                    emptyAddJobFormFields();
                },
                error: function(xhr) {
                    // Show Error Alert When New Job Could Not Be Added

                    // Grab error message
                    let errorMsg = "New Job Could Not Be Added";

                    if (xhr.responseJSON["error"])
                    {
                        errorMsg = xhr.responseJSON["error"];   
                    }

                    displayFormErrorAlert("job-page-content-wrapper", errorMsg, false);
                }
            });   
        }
    });
}

$(document).ready(mainJob);