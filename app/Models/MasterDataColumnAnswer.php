<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MasterDataColumnAnswer extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'master_data_column_answers';

    protected $fillable = [
        'guest_id',
        'master_data_column_id',
        'master_data_column_selection_option_id',
        'value',
    ];

    public function guest()
    {
        return $this->belongsTo(Guest::class, 'guest_id');
    }

    public function masterDataColumn()
    {
        return $this->belongsTo(MasterDataColumn::class, 'master_data_column_id');
    }

    public function selectionOption()
    {
        return $this->belongsTo(
            MasterDataColumnSelectionOption::class,
            'master_data_column_selection_option_id'
        );
    }
}
