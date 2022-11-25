<?php

namespace App\Traits;

/**
 *
 */
trait HttpResponses
{
    protected function success($data, $message = null, $code = 200)
    {
        return response()->json([
            'message' => $message,
            'data' => $data
        ], $code);
    }

    protected function errors($message, $data, $code = 422)
    {
        return response()->json([
            'message' => $message,
            'data' => $data
        ], $code);
    }

    protected function simple($message)
    {
        return response()->json([
            'message' => $message
        ]);
    }
}
