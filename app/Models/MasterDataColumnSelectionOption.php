<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MasterDataColumnSelectionOption extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'master_data_column_selection_options';

    protected $fillable = [
        'master_data_column_id',
        'option_value',
        'option_label',
        'color',
    ];

    public function masterDataColumn()
    {
        return $this->belongsTo(MasterDataColumn::class, 'master_data_column_id');
    }
}