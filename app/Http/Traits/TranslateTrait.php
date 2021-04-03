<?php

namespace App\Http\Traits;

use Google\Cloud\Translate\V2\TranslateClient;


Trait TranslateTrait
{
    public function getTranslate()
    {
        try {
            $translate = new TranslateClient([
                'key' => env('GOOGLE_TRANSLATE_KEY')
            ]);
            return $translate;

        } catch (\Exception $error) {
            return $this->logExceptionAndRespond($error->getMessage());
        }

    }
}
