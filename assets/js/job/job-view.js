"use strict";

/** JS Script for viewing a job in job.php page */
function mainJob()
{
    // Request Work Data From the Back-End
    requestWorkingDaysDataFromBackEnd();
}

function initializeReadOnlyScheduleCalendar(workingDays)
{
    /** Start out the calendar meant to read data from the back-end */
    const readOnlyScheduleCalendarElement = $("#view-schedule-calendar");

    // Place WorkingDaysForAdapter
    const workingDaysForAdapter = [];

    for (let workingDayId in workingDays)
    {
        const workingDay = workingDays[workingDayId];

        const workingDayForAdapter = {
            id: workingDay.id,
            subject: `${$("#view-job-role").val()} - ${$("#view-employer-name").val()}`,
            from: new Date(workingDay.startingHour),
            to: new Date(workingDay.endingHour)
        };

        // KEEP WORKING HERE
        console.log(workingDay);
    }

    // Only show calendar if container is there
    if (readOnlyScheduleCalendarElement.length > 0)
    {
        readOnlyScheduleCalendarElement.jqxScheduler({
            width: "100%",
            height: 600,
            source: [],
            view: "weekView",
            views: ["dayView", "weekView"],
            resources: {
                colorScheme: "scheme05",
                dataField: "calendar"
            },
            views: [
                { type: "dayView", showWeekends: true },
                { type: "weekView", showWeekends: true }
            ],
            editDialogDateTimeFormatString: "hh:mm tt"
        }); 
        
        // Runs when an appointment dialog is opened
        readOnlyScheduleCalendarElement.on('editDialogCreate', function (event) { 
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
        
    }
}

function requestWorkingDaysDataFromBackEnd()
{
    // Prepare payload to send
    const data = JSON.stringify({
        action: "getWorkingDays",
        user_id: $("#user_id").val(),
        job_id: $("#job_id").val()
    });

    // Grab original content of view-schedule-calendar
    const viewScheduleCalendar = $("#view-schedule-calendar");
    const viewScheduleCalendarHTMLOri = $("#view-schedule-calendar").html();

    // Send AJAX request
    $.ajax({
        url: `${websiteURL}api/working-days.php`,
        method: "POST",
        contentType: "application/json",
        data,
        beforeSend: function() {
            // Display a spinner in the container that should contain the calendar
            viewScheduleCalendar.html(loadingSpinner());
        },
        success: function(response) {
            viewScheduleCalendar.html(viewScheduleCalendarHTMLOri);

            // Initialize Calendar
            initializeReadOnlyScheduleCalendar(response);

        },
        error: function() {
            viewScheduleCalendar.html(viewScheduleCalendarHTMLOri);

            $("#working-days-not-found").removeClass("d-none");
        }
    });
}

// $(document).ready(mainJob);