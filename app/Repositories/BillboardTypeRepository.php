<?php

namespace App\Repositories;

use App\Models\BillboardType;
use Illuminate\Support\Facades\DB;

class BillboardTypeRepository extends Repository
{
    public function __construct(
        BillboardType $model
    ) {
        $this->model = $model;
    }

    public function show($parameter)
    {
        $list = DB::table('billboard_type')
            ->where('isEnabled', 1)
            ->where('isDeleted', 0)
            ->select(
                'id',
                'name',
                'sequence',
                'createdBy',
                'updatedBy',
                'createdOn',
                'updatedOn'
            )
            ->orderBy($parameter['sortName'], $parameter['sort'])
            ->get();

        // 取得總筆數
        $count = $list->count();

        // 分頁處理
        $list = $list->skip(($parameter['page'] - 1) * $parameter['pageSize'])
            ->take($parameter['pageSize']);

        return [
            'count' => $count,
            'list' => $list
        ];
    }
}
