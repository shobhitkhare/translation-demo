<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    const SUCCESS = 200, VALIDATION_ERROR = 422, NOT_FOUND = 404, SERVER_ERROR = 500;

    public function logExceptionAndRespond($e)
    {
        return $this->apiResponse(false, trans('translation.key_errors'), trans('translation.something_went_wrong'));
    }

    protected function apiResponse($status, $key = null, $data = null, array $otherData = [], $statusCode = 200)
    {
        return response()->json(
            array_merge([
                'success' => $status,
                $key => $data,
            ], $otherData),
            $statusCode
        );
    }
}
