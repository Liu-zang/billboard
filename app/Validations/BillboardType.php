<?php

namespace App\Validations;

class BillboardType
{
  /**
   * create
   *
   * @param  Array $request
   * @return Array
   */
  public static function create($request = null)
  {
    return [
      'rule' => [
        'name' => 'required|string|max:10',
        'sequence' => 'nullable|integer|min:1|max:999',
        'isEnabled' => 'required|boolean'
      ]
    ];
  }
}
