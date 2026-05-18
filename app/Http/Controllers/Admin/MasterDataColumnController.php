<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MasterDataColumn;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class MasterDataColumnController extends Controller
{
    private const DATA_TYPES = ['text', 'select'];

    public function index()
    {
        $columns = MasterDataColumn::orderBy('name')->paginate(15);

        return view('admin.master-data-columns.index', compact('columns'));
    }

    public function create()
    {
        return view('admin.master-data-columns.create', [
            'dataTypes' => self::DATA_TYPES,
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'name_to_show' => ['nullable', 'string', 'max:255', 'unique:master_data_columns,name_to_show'],
            'data_type' => ['required', Rule::in(self::DATA_TYPES)],
            'required' => ['nullable', 'boolean'],
            'default_value' => ['nullable', 'string', 'max:255'],
            'options' => ['array'],
            'options.*.option_value' => ['nullable', 'string', 'max:255'],
            'options.*.option_label' => ['nullable', 'string', 'max:255'],
            'options.*.color' => ['nullable', 'string', 'max:32'],
        ]);

        // Auto-derive the machine key from name if the user didn't fill it in.
        $data['name_to_show'] = $data['name_to_show']
            ?: Str::snake(Str::lower($data['name']));

        $data['required'] = (bool) ($data['required'] ?? false);

        DB::transaction(function () use ($data, $request) {
            $column = MasterDataColumn::create([
                'name' => $data['name'],
                'name_to_show' => $data['name_to_show'],
                'data_type' => $data['data_type'],
                'required' => $data['required'],
                'default_value' => $data['default_value'] ?? null,
            ]);

            if ($data['data_type'] === 'select') {
                $options = collect($request->input('options', []))
                    ->filter(fn ($option) => filled($option['option_value'] ?? null) || filled($option['option_label'] ?? null))
                    ->map(fn ($option) => [
                        'option_value' => $option['option_value'] ?? null,
                        'option_label' => $option['option_label'] ?? null,
                        'color' => $option['color'] ?? null,
                    ]);

                if ($options->isNotEmpty()) {
                    $column->selectionOptions()->createMany($options->all());
                }
            }
        });

        return redirect()
            ->route('admin.master-data-columns.index')
            ->with('status', 'Master data column created successfully.');
    }
}
