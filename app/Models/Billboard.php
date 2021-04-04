<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Billboard extends Model
{
    protected $table = 'billboard';

    const CREATED_AT = 'createdOn';
    const UPDATED_AT = 'updatedOn';

    protected $fillable = [
        'typeId',
        'title',
        'content',
        'createdBy',
        'updatedBy',
        'createdOn',
        'updatedOn',
        'isDeleted',
    ];

    public function updateByName()
    {
        return $this->belongsTo('App\Models\Admin', 'updatedBy', 'id');
    }

    public function readers()
    {
        return $this->belongsTo('App\Models\BillboardReader', 'id', 'billboardId');
    }
}
