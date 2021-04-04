<?php

namespace App\Support;

use App\Services\ValidationService;

class Support
{
    /**
     * validation
     *
     * @param  String $feature
     * @return Object
     */
    public function validation($feature)
    {
        return new ValidationService($feature);
    }
}
