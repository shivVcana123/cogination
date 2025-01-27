<?php

namespace App\Traits;

trait jsonResponse 
{
    public function jsonResponse($data = null){
      return response()->json([
            'status' => 'success',
            'message' => 'Data fetched successfully',
            'data' => $data,
        ], 200);
    }
}