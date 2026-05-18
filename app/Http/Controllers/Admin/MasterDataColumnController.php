<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MasterDataColumn;
use Illuminate\Support\Collection;

class MasterDataColumnController extends Controller
{
    public function index()
    {
        // TODO: swap to `MasterDataColumn::orderBy('name')->paginate(15)` once the
        // master_data_columns table migration exists. For now we render a
        // hard-coded preview so the UI is reviewable without a database table.
        $columns = new Collection([
            new MasterDataColumn([
                'name' => 'Full name',
                'name_to_show' => 'full_name',
                'data_type' => 'text',
                'required' => true,
            ]),
            new MasterDataColumn([
                'name' => 'Side',
                'name_to_show' => 'side',
                'data_type' => 'select',
                'required' => true,
            ]),
        ]);

        return view('admin.master-data-columns.index', compact('columns'));
    }
}
