"use strict";

/** Script for Jobs Page */

function mainJobs()
{
    // Make all elements with class job-actions responsive with btn-group and btn-group-vertical
    new ResponsiveElement(".job-actions", 576, "btn-group", "btn-group-vertical");
    
    // Prepare AJAX request to delete a job
    sendDeleteJobAJAXRequestToBackend();
}

function getJobIdOutOfDeleteBtnId(btn_id)
{
    // Split id by the "-" character
    const sections = btn_id.split("-");

    // Return the last one
    return sections[sections.length - 1];
}

function getEmployerIdOutOfDeleteBtnId(btn_id)
{
    // Split id by the "-" character
    const sections = btn_id.split("-");

    // Return the second to last one
    return sections[sections.length - 1];
}

function sendDeleteJobAJAXRequestToBackend()
{
    // Grab all elements of class "delete-job-btn"
    $(".delete-job-btn").on("click", function (e) {

        // Grab the id of the clicked element
        const deleteBtnId = e.target.id;

        // Extract the job id out of it
        const job_id = getJobIdOutOfDeleteBtnId(deleteBtnId);
        const employer_id = getEmployerIdOutOfDeleteBtnId(deleteBtnId);

        // Prepare data to be send to AJAX
        const data = JSON.stringify({
            job_id,
            employer_id
        });

        const modalBodyOriginalHTMLContent = $(`#${deleteBtnId} .modal-body`).html();

        // Make AJAX request to delete the job and all related data
        $.ajax({
            url: `${websiteURL}form-handlers/delete-job.php`,
            method: "POST",
            contentType: "application/json",
            data,
            beforeSend: function() {
                // Place a spinner at the center of the modal
                $(`#${deleteBtnId} .modal-body`).html(`<div class='text-center'>${loadingSpinner()}</div>`);
            },
            success: function(response) {

            },
            error: function(xhr) {

            },
            complete: function() {
                $(`#${deleteBtnId} .modal-body`).html(modalBodyOriginalHTMLContent);
            }
        });
    });
}

$(document).ready(mainJobs);