<?php

function interceptEcho($message, $statusCode = 200, $data = null, $error = null) {
    http_response_code($statusCode);

    $response = [
        'success' => true,
        'message' => $message
    ];

    if (!is_null($data)) {
        $response['data'] = $data;
    }

    if (!is_null($error)) {
        $response['success'] = false;
        $response['error'] = $error;
    }

    echo json_encode($response);
}