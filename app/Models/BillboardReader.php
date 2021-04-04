<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BillboardReader extends Model
{
  protected $table = 'billboard_reader';

  const CREATED_AT  = 'createdOn';
  const UPDATED_AT  = 'updatedOn';

  protected $fillable = [
    'billboardId',
    'readerId',
    'isRead',
    'createdBy',
    'updatedBy',
    'createdOn',
    'updatedOn',
    'isDeleted'
  ];
}
