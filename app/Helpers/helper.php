<?php

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

function causer_id()
{
    return !empty(auth()->user()) ? auth()->user()->id : NULL;
}

function apiResponse($success = false, $message = "", $data = [])
{
    $response = ['success' => $success];
    if ($message) {
        $response['message'] = $message;
    }
    if ($data) {
        $response['data'] = $data;
    }

    return response($response);
}

function uploadFile($file, $path, $image_name = NULL)
{
    $image_name = $image_name ?? time() . rand(00, 99) . '.' . $file->getClientOriginalName();
    $path2  = Storage::disk('public')->put('\\images\\' . $path . '\\' . $image_name, File::get($file));
    return $image_name;
}

function deleteFile($file_name, $folder_name)
{
    $path = public_path("storage/images/" . $folder_name . "/") . $file_name;
    if ($file_name && file_exists($path)) {
        unlink($path);
    }

    return true;
}

function getImage($file_name, $folder_name)
{
    $path = public_path("storage/images/" . $folder_name . "/") . $file_name;
    if ($file_name && file_exists($path)) {
        return asset("storage/images/" . $folder_name . "/" . $file_name);
    }

    return asset("avatar/avatar.jpg");
}
