"use strict";

/** JS Script for job.php page */
function mainJob()
{
    // Initialize Phone Mask for Phone Number Input
    initializePhoneMask();
}

function initializePhoneMask()
{
    const phoneInputSelectorSlug = "input[type='tel'";
    (new phoneMask()).init(phoneInputSelectorSlug);
}

$(document).ready(mainJob);