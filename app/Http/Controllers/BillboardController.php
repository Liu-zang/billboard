<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\BillboardService;
use App\Support\Support;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\DB;

class BillboardController extends Controller
{
    protected $validation;
    protected $request;
    protected $service;
    public function __construct(
        Request $request,
        BillboardService $service,
        JWTAuth $jwt,
        Support $support
    ) {
        $this->request = $request;
        $this->validation = $support->validation('Billboard');
        $this->jwt = $jwt;
        $this->service = $service;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        DB::beginTransaction();
        try {
            $this->validateRequest();
            $this->service->setParameter()
                ->create($this->getAdminId());
            DB::commit();

            return;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        return $this->service->setParameter()->show($this->getAdminId());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function read($id)
    {
        return $this->service->read($id, $this->getAdminId());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update($id)
    {
        return $this->service->setParameter()->update($id, $this->getAdminId());
    }

    public function delete(Request $request, $id)
    {
        //
    }
}
