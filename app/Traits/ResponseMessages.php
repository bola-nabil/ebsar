<?php

namespace App\Traits;

trait ResponseMessages {
    public function successMessage($status, $key, $value) {
        return response()->json([
            'status' => $status,
            $key => $value,
        ]);
    }
    public function errorMessage($status, $key, $value)
    {
        return response()->json([
            'status' => $status,
            $key => $value,
        ]);
    }
}