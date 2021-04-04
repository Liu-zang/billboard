<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * validateRequest
     *
     * 驗證request參數
     *
     * @return void
     */
    public function validateRequest()
    {
        return $this->validation::execute(
            //取得前一個function名稱
            debug_backtrace()[1]['function'],
            $this->request->all()
        );
    }

    public function getAdminId()
    {
        return $this->jwt::parseToken()->getPayload()->get('sub');
    }
}
