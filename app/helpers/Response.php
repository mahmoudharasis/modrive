<?php

class Response {
    public static function success($data = null, $message = 'Success') {
        return response()->json([
            'status' => 'success',
            'message' => $message,
            'data' => $data,
        ], 200);
    }

    public static function error($message = 'Error', $code = 400) {
        return response()->json([
            'status' => 'error',
            'message' => $message,
        ], $code);
    }
}