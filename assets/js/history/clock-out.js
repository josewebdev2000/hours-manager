"use strict";

/** Script to Clock Out For The Job History Page */

function mainClockOut()
{
    clockOutAJAXBackendRequest();
}

function getLatestWorkSessionId()
{
    const workSessionIds = [];

    $(".work-session-id-holder").each(function () {
        workSessionIds.push($(this).val());
    });

    // Return the last workSessionId
    return workSessionIds[workSessionIds.length - 1];
}

function clockOutAJAXBackendRequest()
{
    const clockStateBtn = $("#clock-state-btn");

    clockStateBtn.on("click", function(e) {

        // Grab the text in the button
        const clockStateBtnText = clockStateBtn.text().trim();

        // Perform AJAX request only if the job is in clock-out state
        if (clockStateBtnText == "Clock-Out")
        {
            // Get worksession id of the latest worksession
            const worksession_id = getLatestWorkSessionId();

            // Get MySQL Date Time for End Time
            const end_time = getCurrentTime();

            // Prepare data object to be sent to the back-end
            const data = JSON.stringify({
                worksession_id,
                end_time
            });

            // Now prepare AJAX Request
            $.ajax({
                url: `${websiteURL}form-handlers/clock-out.php`,
                method: "POST",
                contentType: "application/json",
                data,
                beforeSend: function() {},
                success: function(response) {
                    // Reload Page
                    location.reload();
                },
                error: function(xhr) {
                    const errMsg = xhr.responseJSON["error"];

                    displayFormErrorAlert("job-history-content-wrapper", errMsg, false);
                },
                complete: function() {}
            });
        }
    });
}

$(document).ready(mainClockOut);