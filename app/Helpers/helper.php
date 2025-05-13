<?php

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

function uploadFile($file)
{
    $newName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
    $file->storeAs('images', $newName, 'public');
    return $newName;
}
