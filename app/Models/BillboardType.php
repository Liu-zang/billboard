<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BillboardType extends Model
{
    protected $table = 'billboard_type';

    const CREATED_AT  = 'createdOn';
    const UPDATED_AT  = 'updatedOn';

    protected $fillable = [
        'name',
        'sequence',
        'riskLevel',
        'createdBy',
        'updatedBy',
        'createdOn',
        'updatedOn',
        'isDeleted',
        'isEnabled'
    ];

    public function updateByName()
    {
        return $this->belongsTo('App\Models\Admin', 'updatedBy', 'id');
    }
}
