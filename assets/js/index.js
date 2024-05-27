"use strict";
// Script for the main page and the whole app

function mainIndex()
{
    // Improve the responsiveness of the hero container of the main page
    makeHeroContainerResponsive();
}

function makeHeroContainerResponsive()
{
    // Grab the hero container of the index page
<<<<<<< HEAD
    const main = $("main");
=======
    const main = $("#index-main");
>>>>>>> jose_about_contact_page
    const indexHeroContainer = $("#index-hero-container");

    // Run only in indexMain is present
    if (main.length)
    {
        // Generate a new responsive for the index Main Element
        new ResponsiveElement(
<<<<<<< HEAD
            "main",
=======
            `${main.attr("id")}`,
>>>>>>> jose_about_contact_page
            644,
            "flex-065",
            "full-page-height"
        );
    }

    // Run only if indexHeroContainer is present
    if (indexHeroContainer.length)
    {
        // Generate new a responsive element for the index Hero Container
        new ResponsiveElement(
            "#index-hero-container",
            644,
            "",
            "m-4 p-4"
        );
    }
}

$(document).ready(mainIndex);
