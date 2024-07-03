"use strict";

/** Script to Clock In For The Job History Page */

function mainClockIn()
{
    clockInAJAXBackendRequest();
}

function clockInAJAXBackendRequest()
{
    const clockStateBtn = $("#clock-state-btn");

    clockStateBtn.on("click", function (e) {

        // Grab the text in the button
        const clockStateBtnText = clockStateBtn.text().trim();

        // Perform AJAX request only if the job is in clock-in state
        if (clockStateBtnText == "Clock-In")
        {
            // Get user id
            const user_id = $("#user_id").val();

            // Get job id
            const job_id = $("#job_id").val();

            // Get MySQL Date Time for Start Time
            const start_time = getCurrentTime();
            
            // Prepare data object to be sent to the back-end
            const data = JSON.stringify({
                user_id,
                job_id,
                start_time
            });

            // Now prepare AJAX Request
            $.ajax({
                url: `${websiteURL}form-handlers/clock-in.php`,
                method: "POST",
                contentType: "application/json",
                data,
                beforeSend: function() {},
                success: function(response) {
                    // Reload Page
                    location.reload();
                },
                error: function(xhr) {
                    // Show Error If Clock-In Failed
                    const errMsg = xhr.responseJSON["error"];

                    displayFormErrorAlert("job-history-content-wrapper", errMsg ,false);
                },
                complete: function() {}
            });
        }
    });
}

$(document).ready(mainClockIn);