/** Code used throughout all scripts */
function usernameValidate()
{
    const curUserName = $("#username").val();

    if (curUserName.trim().length == 0)
    {
        $("#username").removeClass("is-valid");
        $("#username").addClass("is-invalid");
        $(".invalid-tooltip.username").text("Username cannot be empty");
    }

    else if (!userNameRegex.test(curUserName.trim()))
    {
        $("#username").removeClass("is-valid");
        $("#username").addClass("is-invalid");
        $(".invalid-tooltip.username").text("Username cannot have special symbols");
    }

    else
    {
        $("#username").removeClass("is-invalid");
        $(".invalid-tooltip.username").text("");
        $("#username").addClass("is-valid");
    }
}

function nameValidate() 
{
    const curName = $("#name").val();

    if (curName.trim().length == 0)
    {
        $("#name").removeClass("is-valid");
        $("#name").addClass("is-invalid");
        $(".invalid-tooltip.name").text("Name cannot be empty");
    }

    else if (!nameRegex.test(curName.trim()))
    {
        $("#name").removeClass("is-valid");
        $("#name").addClass("is-invalid");
        $(".invalid-tooltip.name").text("Name cannot have numbers or special symbols");
    }

    else
    {
        $("#name").removeClass("is-invalid");
        $(".invalid-tooltip.name").text("");
        $("#name").addClass("is-valid");
    }
}

function emailValidate()
{
    const curEmail = $("#email").val();

    if (curEmail.trim().length == 0)
    {
        $("#email").removeClass("is-valid");
        $("#email").addClass("is-invalid");
        $(".invalid-tooltip.email").text("Email cannot be empty");
    }

    else if (!emailRegex.test(curEmail.trim()))
    {
        $("#email").removeClass("is-valid");
        $("#email").addClass("is-invalid");
        $(".invalid-tooltip.email").text("Invalid Email");
    }

    else
    {
        $("#email").removeClass("is-invalid");
        $(".invalid-tooltip.email").text("");
        $("#email").addClass("is-valid");
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

function displayFormErrorAlert(alert_container_id ,error_msg)
{
    // Create Error Alert
    const eAlert = $(errorAlert(error_msg));

    // Append the alert to the container
    $(`#${alert_container_id}`).append(eAlert);

    // Fade in the alert in 150 mls
    setTimeout(() => eAlert.addClass("show"), 150);
}

function displayFormSuccessAlert(alert_container_id, success_msg)
{
    // Create Success Alert
    const sAlert = $(successAlert(success_msg));

    // Append the alert to the container
    $(`#${alert_container_id}`).append(sAlert);

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