"use strict";

/** JS Script for job.php page */
function mainJob()
{
    initializePhoneMask();
}

function initializePhoneMask()
{
    const phoneInputSelectorSlug = "input[type='tel'";
    (new phoneMask()).init(phoneInputSelectorSlug);
}

$(document).ready(mainJob);