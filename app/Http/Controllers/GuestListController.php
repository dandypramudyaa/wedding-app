<?php

namespace App\Http\Controllers;

use App\Models\Guest;
use App\Models\MasterDataColumn;
use App\Models\MasterDataColumnAnswer;
use App\Models\MasterDataColumnSelectionOption;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class GuestListController extends Controller
{
    public function index()
    {
        $columns = MasterDataColumn::with('selectionOptions')
            ->orderBy('id')
            ->get();

        $guests = Guest::with([
            'answers.masterDataColumn',
            'answers.selectionOption',
        ])
            ->latest('id')
            ->paginate(15);

        return view('guest-list.index', compact('columns', 'guests'));
    }

    public function create()
    {
        $columns = MasterDataColumn::with('selectionOptions')
            ->orderBy('id')
            ->get();

        return view('guest-list.create', compact('columns'));
    }

    public function store(Request $request)
    {
        $columns = MasterDataColumn::with('selectionOptions')
            ->orderBy('id')
            ->get();

        $rules = $this->buildValidationRules($columns);
        $attributeNames = $columns
            ->mapWithKeys(fn ($c) => ["answers.{$c->id}" => $c->name])
            ->all();

        $validated = $request->validate($rules, [], $attributeNames);
        $answers = $validated['answers'] ?? [];

        $guest = DB::transaction(function () use ($columns, $answers) {
            $guest = Guest::create([
                'created_by' => auth()->id(),
            ]);

            foreach ($columns as $column) {
                $raw = $answers[$column->id] ?? null;

                if ($raw === null || $raw === '') {
                    continue;
                }

                if ($column->data_type === 'select') {
                    $option = $column->selectionOptions
                        ->firstWhere('option_value', $raw);

                    MasterDataColumnAnswer::create([
                        'guest_id' => $guest->id,
                        'master_data_column_id' => $column->id,
                        'master_data_column_selection_option_id' => $option?->id,
                        'value' => $option?->option_value,
                    ]);

                    continue;
                }

                MasterDataColumnAnswer::create([
                    'guest_id' => $guest->id,
                    'master_data_column_id' => $column->id,
                    'value' => $raw,
                ]);
            }

            return $guest;
        });

        return redirect()
            ->route('guest-list.show', $guest)
            ->with('status', 'Guest added successfully.');
    }

    public function show(Guest $guest)
    {
        $columns = MasterDataColumn::with('selectionOptions')
            ->orderBy('id')
            ->get();

        $guest->load(['answers.masterDataColumn', 'answers.selectionOption']);

        // Map answers by column id so the blade can render them in column order.
        $answersByColumn = $guest->answers->keyBy('master_data_column_id');

        return view('guest-list.show', compact('guest', 'columns', 'answersByColumn'));
    }

    public function destroy(Guest $guest)
    {
        $guest->delete();

        return redirect()
            ->route('guest-list.index')
            ->with('status', 'Guest deleted successfully.');
    }

    private function buildValidationRules($columns): array
    {
        $rules = ['answers' => ['array']];

        foreach ($columns as $column) {
            $key = "answers.{$column->id}";

            $fieldRules = [$column->required ? 'required' : 'nullable'];

            if ($column->data_type === 'select') {
                $allowed = $column->selectionOptions
                    ->pluck('option_value')
                    ->filter()
                    ->values()
                    ->all();

                $fieldRules[] = $allowed
                    ? Rule::in($allowed)
                    : 'prohibited';
            } else {
                $fieldRules[] = 'string';
                $fieldRules[] = 'max:1000';
            }

            $rules[$key] = $fieldRules;
        }

        return $rules;
    }
}
