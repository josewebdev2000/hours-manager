"use strict";

/** Script for Jobs Page */

function mainJobs()
{
    // Make all elements with class job-actions responsive with btn-group and btn-group-vertical
    new ResponsiveElement(".job-actions", 576, "btn-group", "btn-group-vertical");   
}

$(document).ready(mainJobs);