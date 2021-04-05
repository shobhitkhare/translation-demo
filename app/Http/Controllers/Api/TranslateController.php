<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Traits\TranslateTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TranslateController extends Controller
{
    use TranslateTrait;

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $translate = $this->getTranslate();

        $languages = $translate->languages();

        return $this->apiResponse(true, trans('translation.translation'), null, [
            'translation' => collect($languages)->map(function ($language, $index) {
                return [
                    'key' => $index,
                    'language' => $language
                ];
            })
        ]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function translate(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'text' => "required",
            'translate' => "required",
        ]);

        if ($validator->fails()) {
            return $this->apiResponse(false, trans('translation.key_errors'), $validator->messages(), [], $this::VALIDATION_ERROR);
        }

        try {

            $translate = $this->getTranslate();

            $languages = $translate->languages();

            if (!in_array($request->translate, $languages)) {
                return $this->apiResponse(false, trans('translation.key_errors'), trans('translation.not_supported'), [], $this::NOT_FOUND);
            }

            $result = $translate->translate($request->text, [
                'target' => $request->translate
            ]);

            return $this->apiResponse(true, trans('translation.translation'), $result['text']);

        } catch (\Exception $error) {
            return $this->logExceptionAndRespond($error->getMessage());
        }

    }
}
