<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MasterDataColumn extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'master_data_columns';

    protected $fillable = [
        'name',
        'name_to_show',
        'data_type',
        'required',
        'default_value',
    ];

    protected $casts = [
        'required' => 'boolean',
    ];

    public function selectionOptions()
    {
        return $this->hasMany(MasterDataColumnSelectionOption::class, 'master_data_column_id');
    }

    public function answers()
    {
        return $this->hasMany(MasterDataColumnAnswer::class, 'master_data_column_id');
    }
}
