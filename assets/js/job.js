"use strict";

/** JS Script for job.php page */
function mainJob()
{
    // Initialize Phone Mask for Phone Number Input
    initializePhoneMask();

    // Initialize Schedule Calendar
    initializeScheduleCalendar();

    // Execute Operations To Cancel A New Job
    cancelNewJob();

}

function initializePhoneMask()
{
    const phoneInputSelectorSlug = "input[type='tel'";
    (new phoneMask()).init(phoneInputSelectorSlug);
}

function cancelNewJob()
{
    $("button#add-job-cancel-btn").on("click",  function () {
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

$(document).ready(mainJob);