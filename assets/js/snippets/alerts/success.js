"use strict";

function successAlert(message)
{
    return `<div class="alert alert-success dismissable fade" role="alert">
                <button type="button" class="close" data-bs-dismiss="alert" aria-label="Close">&#10005;</button>
                <h5><i class="icon fas fa-check"></i> Success</h5>
                <p>${message}</p>
            </div>`;
}