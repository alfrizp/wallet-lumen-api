<?php

namespace App\Traits;

trait ApiResponser
{
    protected function successResponse($data, $code)
    {
        $response = [
            'status' => true,
            'code' => $code,
            'message' => array_key_exists('message', $data) ? $data['message'] : '',
            'data' => array_key_exists('data', $data) ? $data['data'] : null,
            'meta' => array_key_exists('meta', $data) ? $data['meta'] : null,
        ];

        return response()->json($response, $code);
    }

    protected function errorResponse($errResponse, $code)
    {
        $response = [
            'status' => false,
            'code' => $code,
            'message' => array_key_exists('message', $errResponse) ? $errResponse['message'] : '',
            'data' => array_key_exists('data', $errResponse) ? $errResponse['data'] : null,
        ];

        return response()->json($response, $code);
    }

    protected function showMessage($message, $code = 200)
    {
        $response = [];
        $response['message'] = $message;

        return $this->successResponse($response, $code);
    }

    protected function successDataResponse($data = [], $message = '', $code = 200)
    {
        $response = [];
        $response['data'] = $data;
        $response['message'] = $message;

        return $this->successResponse($response, $code);
    }
}
