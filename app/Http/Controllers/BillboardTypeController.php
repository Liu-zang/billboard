<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\BillboardTypeService;
use App\Support\Support;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\DB;

class BillboardTypeController extends Controller
{
  protected $validation;
  protected $request;
  protected $service;
  public function __construct(
    Request $request,
    BillboardTypeService $service,
    JWTAuth $jwt,
    Support $support
  ) {
    $this->request = $request;
    $this->validation = $support->validation('BillboardType');
    $this->jwt = $jwt;
    $this->service = $service;
  }

  /**
   * create
   *
   * @return
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
   * show
   *
   * @param  int  $id
   * @return
   */
  public function show()
  {
    return $this->service->setParameter()->show();
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function read($id)
  {
    return $this->service->read($id);
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
    $this->service->setParameter()
      ->update($id, $this->getAdminId());
  }

  public function delete($id)
  {
    $this->service->delete($id);
  }
}
