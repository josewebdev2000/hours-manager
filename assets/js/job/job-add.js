"use strict";

/** JS Script for adding a job to job.php page */
function mainJob()
{
    // Clear Session Storage 
    sessionStorage.clear();

    // Initialize Phone Mask for Phone Number Input
    initializePhoneMask();

    // Initialize Schedule Calendar
    initializeScheduleCalendar();

    // Execute Operations To Cancel A New Job
    cancelNewJob();

    // Send AJAX Request To Backend
    sendAddNewJobAJAXRequestToBackend();
}

function initializePhoneMask()
{
    const phoneInputSelectorSlug = "input[type='tel'";
    (new phoneMask()).init(phoneInputSelectorSlug);
}

function cancelNewJob()
{
    $("button#add-job-cancel-btn").on("click",  function () {
        sessionStorage.clear();
        
        const referrer = document.referrer;

        if (referrer) {
            window.location.href = referrer;
        } else {
            // If there is no referrer, you can redirect to a default page
            window.location.href = `${websiteURL}dashboard/index.php`;
        }
    });
}

function initializeScheduleCalendar()
{
    const scheduleCalendarElement = $("#schedule-calendar");

    scheduleCalendarElement.jqxScheduler({
        width: "100%",
        height: 600,
        source: [],
        view: "weekView",
        views: ["dayView", "weekView"],
        appointmentDataFields: {
            from: "start",
            to: "end"
        },
        resources: {
            colorScheme: "scheme05",
            dataField: "calendar"
        },
        views: [
            { type: 'dayView', showWeekends: true},
            { type: 'weekView', showWeekends: true },
        ],
        editDialogDateTimeFormatString: "hh:mm tt",
        ready: function () {

            // Hide Toolbar Details
            $(".jqx-scheduler-toolbar-details").remove();

            // Hide Icon Calendar
            $(".jqx-widget.jqx-datetimeinput.jqx-input.jqx-overflow-hidden.jqx-rc-all.jqx-reset.jqx-clear.jqx-widget-content").hide();
        },

    });

    // Runs when an appointment dialog is opened
    scheduleCalendarElement.on('editDialogCreate', function (event) { 
        const args = event.args; 
        const fields = args.fields; 

        // Hide Subject Container
        $(fields.subjectContainer[0]).remove();

        // Remove Location Container
        $(fields.locationContainer[0]).remove();

        // Remove Time Zone Container
        $(fields.timeZoneContainer[0]).remove();

        // Remove Description Container
        $(fields.descriptionContainer[0]).remove();

        // Remove Status Container
        $(fields.statusContainer[0]).remove();

        // Remove Repeat Container
        $(fields.repeatContainer[0]).remove();
    });

    // Runs when an appointment is created
    scheduleCalendarElement.on("appointmentAdd", parseAppointmentData);

    // Runs when an appointment is created
    scheduleCalendarElement.on("appointmentChange", parseAppointmentData);

    // Run when an appointment is deleted
    scheduleCalendarElement.on("appointmentDelete", deleteAppointmentFromSessionStorage);
}

function deleteAppointmentFromSessionStorage(event)
{
    // Get Appointment Data
    const args = event.args;
    const appointment = args.appointment;
    const appointmentData = appointment.jqxAppointment

    // Grab session storage key data of appointmen

    // Remove It From Session Storage
    sessionStorage.removeItem(`Work Shift: ${appointmentData.subject}: ${appointmentData.id}`);
}

function parseAppointmentData(event)
{
    // Parse Appointment Data
    const args = event.args;

    // Grab appointment data
    const appointment = args.appointment;

    const appointmentData = appointment.jqxAppointment;

    // Place Subject as 'Job Title - Employer Name'
    appointmentData.subject = `${$("#job-role").val()} - ${$("#employer-name").val()}`;

    // Grab JSON String of the data
    const appointmentInitialJSONString = appointmentData.toJSON();

    // Parse it into an JS Obj
    const appointmentParsedData = JSON.parse(appointmentInitialJSONString);

    // Format Time Appropiately
    appointmentParsedData.from = formatTime(appointmentParsedData.from);
    appointmentParsedData.to = formatTime(appointmentParsedData.to);

    // Grab the day of the week
    appointmentParsedData.day = getDayOfWeek(appointmentData.from.dayOfWeek());

    // add the subject field into the appointmentParseData
    appointmentParsedData.subject = appointmentData.subject;

    // JSONify the parsed appointment data obj
    const jsonifiedAppointmentData = JSON.stringify(appointmentParsedData);

    // Add the data to sessionStorage as with the key appointment.subject + appointment-id
    sessionStorage.setItem(`Work Shift: ${appointmentParsedData.subject}: ${appointmentParsedData.id}`, jsonifiedAppointmentData);
}

function validateAddJobData()
{
    /** RONNY WILL DEVELOP VALIDATION CODE */
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

    // Find a way to delete appointments from jqxScheduler
    const appointments = $("#schedule-calendar").jqxScheduler("getAppointments");

    appointments.forEach(appointment => {
        $("#schedule-calendar").jqxScheduler("deleteAppointment", appointment.jqxAppointment.id);
    });
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

        // Get work shifts data
        const workShifts = [];

        for (let i = 0; i < sessionStorage.length; i++)
        {
            const key = sessionStorage.key(i);

            // Only Grab Keys that Start With Work Shift
            if (key.startsWith("Work Shift:"))
            {
                // Get Work Shift Data
                const workShift = sessionStorage.getItem(key);

                // Parse It Into a JS Obj
                const workShiftData = JSON.parse(workShift);

                // Add the Work Shift into the work shifts array
                workShifts.push(workShiftData);

            }
        }

        // Prepare JSON payload to send
        const data = JSON.stringify({
            "user_id": user_id,
            "employer": employerData,
            "job": jobData,
            "pay_rate": payRateData,
            "pay_roll": payRollData,
            "work_shifts": workShifts
        });

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
            },
            complete: function() {
                sessionStorage.clear();
                emptyAddJobFormFields();
            }
        });
    });
}

$(document).ready(mainJob);