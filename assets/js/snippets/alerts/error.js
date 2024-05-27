"use strict";

function errorAlert(message)
{
    return `<div class="alert alert-danger dissmissable fade" role="alert">
                <button type="button" class="close" data-bs-dismiss="alert" aria-label="Close">&#10005;</button>
                <h5><i class="icon fas fa-ban"></i> Error</h5>
                <p>${message}</p>
            </div>`;
}