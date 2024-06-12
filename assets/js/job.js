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
    $("#schedule-calendar").jqxScheduler({
        width: "100%",
        height: 600,
        source: [],
        view: "weekView",
        views: ["dayView", "weekView"],
        appointmentDataFields: {
            from: "start",
            to: "end",
            id: "id",
            description: "description",
            location: "place",
            subject: "subject",
            resourceId: "calendar"
        },
        resources: {
            colorScheme: "scheme05",
            dataField: "calendar"
        },
        views: [
            { type: 'dayView', showWeekends: true},
            { type: 'weekView', showWeekends: true },
        ],
        ready: function () {

            // Hide the arrows
            $(".jqx-icon-arrow-right").remove();
            $(".jqx-icon-arrow-left").remove();

            // Hide Toolbar Details
            $(".jqx-scheduler-toolbar-details").remove();

            // Hide Icon Calendar
            $(".jqx-widget.jqx-datetimeinput.jqx-input.jqx-overflow-hidden.jqx-rc-all.jqx-reset.jqx-clear.jqx-widget-content").hide();
        },
    });
}

$(document).ready(mainJob);