/** Code used throughout all scripts */
function usernameValidate(username_id)
{
    const curUserName = $(`#${username_id}`).val();

    if (curUserName.trim().length == 0)
    {
        $(`#${username_id}`).removeClass("is-valid");
        $(`#${username_id}`).addClass("is-invalid");
        $(`.invalid-tooltip.${username_id}`).text("Username cannot be empty");
    }

    else if (!userNameRegex.test(curUserName.trim()))
    {
        $(`#${username_id}`).removeClass("is-valid");
        $(`#${username_id}`).addClass("is-invalid");
        $(`.invalid-tooltip.${username_id}`).text("Username cannot have special symbols");
    }

    else
    {
        $(`#${username_id}`).removeClass("is-invalid");
        $(`.invalid-tooltip.${username_id}`).text("");
        $(`#${username_id}`).addClass("is-valid");
    }
}

function nameValidate(name_id) 
{
    const curName = $(`#${name_id}`).val();

    if (curName.trim().length == 0)
    {
        $(`#${name_id}`).removeClass("is-valid");
        $(`#${name_id}`).addClass("is-invalid");
        $(`.invalid-tooltip.${name_id}`).text("Name cannot be empty");
    }

    else if (!nameRegex.test(curName.trim()))
    {
        $(`#${name_id}`).removeClass("is-valid");
        $(`#${name_id}`).addClass("is-invalid");
        $(`.invalid-tooltip.${name_id}`).text("Name cannot have numbers or special symbols");
    }

    else
    {
        $(`#${name_id}`).removeClass("is-invalid");
        $(`.invalid-tooltip.${name_id}`).text("");
        $(`#${name_id}`).addClass("is-valid");
    }
}

function emailValidate(email_id)
{
    const curEmail = $(`#${email_id}`).val();

    if (curEmail.trim().length == 0)
    {
        $(`#${email_id}`).removeClass("is-valid");
        $(`#${email_id}`).addClass("is-invalid");
        $(`.invalid-tooltip.${email_id}`).text("Email cannot be empty");
    }

    else if (!emailRegex.test(curEmail.trim()))
    {
        $(`#${email_id}`).removeClass("is-valid");
        $(`#${email_id}`).addClass("is-invalid");
        $(`.invalid-tooltip.${email_id}`).text("Invalid Email");
    }

    else
    {
        $(`#${email_id}`).removeClass("is-invalid");
        $(`.invalid-tooltip.${email_id}`).text("");
        $(`#${email_id}`).addClass("is-valid");
    }
}

function passwordValidate(password_input_id)
{
    const curPassword = $(`#${password_input_id}`).val();

    if (curPassword.trim().length == 0)
    {
        $(`#${password_input_id}`).removeClass("is-valid");
        $(`#${password_input_id}`).addClass("is-invalid");
        $(`.invalid-tooltip.${password_input_id}`).text("Password cannot be empty");
    }

    else if (!passwordRegex.test(curPassword.trim()))
    {
        $(`#${password_input_id}`).removeClass("is-valid");
        $(`#${password_input_id}`).addClass("is-invalid");
        $(`.invalid-tooltip.${password_input_id}`).text("Password needs at least one uppercase, one lowecase, one digit, and eight characters");
    }

    else
    {
        $(`#${password_input_id}`).removeClass("is-invalid");
        $(`.invalid-tooltip.${password_input_id}`).text("");
        $(`#${password_input_id}`).addClass("is-valid");
    }
}

function confirmPasswordValidate(confirm_id, ori_id)
{
    // Confirm Password Input
    const confirmP = $(`#${confirm_id}`).val();

    // Original Password Input
    const oriP = $(`#${ori_id}`).val();

    // If they are not the same, then raise flags in both
    if (confirmP != oriP)
    {
        $(`#${confirm_id}`).removeClass("is-valid");
        $(`#${confirm_id}`).addClass("is-invalid");

        $(`#${ori_id}`).removeClass("is-valid");
        $(`#${ori_id}`).addClass("is-invalid");


        $(`.invalid-tooltip.${confirm_id}`).text("Passwords Do Not Match"); 
        $(`.invalid-tooltip.${ori_id}`).text("Passwords Do Not Match"); 
    }

    else
    {
        $(`#${confirm_id}`).removeClass("is-invalid");
        $(`.invalid-tooltip.${confirm_id}`).text("");
        $(`#${confirm_id}`).addClass("is-valid");

        $(`#${ori_id}`).removeClass("is-invalid");
        $(`.invalid-tooltip.${ori_id}`).text("");
        $(`#${ori_id}`).addClass("is-valid");
    }
}

function formControlFocusValidate(form_control_id)
{
    /** Execute when input element is on focus */
    if ($(`#${form_control_id}`).hasClass("is-valid"))
    {
        $(`.valid-tooltip.${form_control_id}`).fadeIn();
    }

    if ($(`#${form_control_id}`).hasClass("is-invalid"))
    {
        $(`.invalid-tooltip.${form_control_id}`).fadeIn();
    }
}

function formControlBlurValidate(form_control_id)
{
    /** Execute when input element is on blur */
    $(`.valid-tooltip.${form_control_id}`).fadeOut();
    $(`.invalid-tooltip.${form_control_id}`).fadeOut();
}

function displayFormErrorAlert(alert_container_id ,error_msg, doAppend = true)
{
    // Create Error Alert
    const eAlert = $(errorAlert(error_msg));

    // Append the alert to the container
    if (doAppend)
    {
        $(`#${alert_container_id}`).append(eAlert);   
    }

    else
    {
        $(`#${alert_container_id}`).prepend(eAlert);   
    }
    // Fade in the alert in 150 mls
    setTimeout(() => eAlert.addClass("show"), 150);
}

function displayFormSuccessAlert(alert_container_id, success_msg, doAppend = true)
{
    // Create Success Alert
    const sAlert = $(successAlert(success_msg));

    // Append the alert to the container
    if (doAppend)
    {
        $(`#${alert_container_id}`).append(sAlert);   
    }

    else
    {
        $(`#${alert_container_id}`).prepend(sAlert);   
    }

    // Fade in the alert in 150 mls
    setTimeout(() => sAlert.addClass("show"), 150);
}

function removeAlertFromContainer(alert_container_id, alert_selector)
{
    $(`#${alert_container_id}`).find(alert_selector).remove();
}

function encodeTextFileToBase64(textFileObj)
{
    /** Encode the decoded text context of a text file to Base 64 */
    /** Call this function at the "change" event handler of your input[type="file"] */

    // Read the contents of the file
    const textFileReader = new FileReader();
    textFileReader.readAsText(textFileObj);

    // Make an async promise to allow the content of the file to be returned
    const readFilePromise = new Promise(function (resolve, reject) {
        textFileReader.addEventListener("loadend", function () {
            const base64content = window.btoa(textFileReader.result);
            resolve(base64content);
        });
        textFileReader.addEventListener("error", function () {
            reject(`Could not encode file of name: ${textFileObj.name}`);
        });
    });

    return readFilePromise;
}

function formatTime(dateString) 
{
    // Grab hours and minutes from dateString
    const hours = dateString.substring(dateString.indexOf('T') + 1, dateString.indexOf(':', dateString.indexOf('T')));
    const firstColonIndex = dateString.indexOf(':');
    const secondColonIndex = dateString.indexOf(':', firstColonIndex + 1);
    const minutes = dateString.substring(firstColonIndex + 1, secondColonIndex);

    const hoursInt = parseInt(hours);

    if (hoursInt < 12)
    {
        return `${(hours < 1) ? 12 : hours}:${minutes} AM`;
    }

    else
    {
        return `${(hours % 12 < 10) ? `0${(hours % 12)}`:hours % 12}:${minutes} PM`;
    }
}

function getDayOfWeek(i)
{
    // Return a name of the day of the week based on index value
    switch (i)
    {
        case 0:
            return "Sunday";
        case 1:
            return "Monday";
        case 2:
            return "Tuesday";
        case 3:
            return "Wednesday";
        case 4:
            return "Thursday";
        case 5:
            return "Friday";
        case 6:
            return "Saturday";
    }
}

function smoothlyScrollToTop(container_selector)
{
    // Using jQuery's animate() method to add smooth page scroll
    $('html, body').animate({
        scrollTop: $(container_selector).offset().top
    }, 800);
}

function decodeBase64TextFile(encodedTextFile, fileName)
{
    /** Decode the encoded text content in Base64 of a text file
     * Return the URL of the text file in the front-end
     */

    // Decode Base64 Data
    const binaryStr = window.atob(encodedTextFile);

    // Grab the bytes
    const bytes = new Uint8Array(binaryStr.length);

    // Change its byte for the String Code It Should Have to Form Text File
    for (let i = 0; i < binaryStr.length; i++)
    {
        bytes[i] = binaryStr.charCodeAt(i);
    }

    // Make a Blob File Object of a Plain Text File
    const blob = new Blob([bytes], { type: "text/plain" });

    // Create an object URL for the Blob
    const url = window.URL.createObjectURL(blob);

    // Return the url
    return {url, fileName};
}