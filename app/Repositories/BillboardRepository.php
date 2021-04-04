<?php

namespace App\Repositories;

use App\Models\Billboard;
use Illuminate\Support\Facades\DB;

class BillboardRepository extends Repository
{
    public function __construct(
        Billboard $model
    ) {
        $this->model = $model;
    }

    public function show($adminId, $parameter)
    {
        $list = DB::table('billboard')
            ->join('billboard_reader as reader', 'billboard.id', 'reader.billboardId')
            ->where('billboard.isDeleted', 0)
            ->where('reader.readerId', $adminId)
            ->where('reader.isDeleted', 0)
            ->select(
                'billboard.id as id',
                'billboard.typeId as typeId',
                'billboard.title as title',
                'billboard.updatedOn as updatedOn',
                'billboard.updatedBy'
            );

        $count = $list->count();
        $list = $list->take($parameter['pageSize'])
            ->skip($parameter['page'] > 1 ? ($parameter['page'] - 1) * $parameter['pageSize'] : 0)
            ->get();

        return [
            'count' => $count,
            'list' => $list
        ];
    }
}
