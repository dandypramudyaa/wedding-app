<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterDataColumn extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'name_to_show',
        'data_type',
        'required',
    ];

    protected $casts = [
        'required' => 'boolean',
    ];

    public const DATA_TYPES = [
        'text',
        'number',
        'date',
        'select',
        'boolean',
    ];
}
