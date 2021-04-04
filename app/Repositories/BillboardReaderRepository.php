<?php

namespace App\Repositories;

use App\Models\BillboardReader;

class BillboardReaderRepository extends Repository
{
  public function __construct(
    BillboardReader $model
  ) {
    $this->model = $model;
  }
}
