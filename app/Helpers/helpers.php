<?php

$allowedMimeTypes = ['image/jpeg','image/gif','image/png','image/bmp','image/svg+xml'];

function is_image($path)
{
    $contentType = mime_content_type($path);
    return in_array($contentType, $allowedMimeTypes);
}

function get_admin_auth_user()
{
    return get_admin_auth()->user();
}

function get_admin_auth()
{
    return \Auth::guard("admin");
}
