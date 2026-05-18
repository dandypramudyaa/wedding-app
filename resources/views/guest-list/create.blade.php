<x-app-layout>
    <x-slot name="header">
        <div>
            <p class="text-xs uppercase tracking-[0.3em] text-gray-500">Wedding</p>
            <h2 class="font-serif-display text-3xl text-gray-900 leading-tight">Add Guest</h2>
        </div>
    </x-slot>

    @php
        $inputClasses = 'block mt-1 w-full border-gray-200 focus:border-gray-400 focus:ring-gray-400 rounded-md';
    @endphp

    <div>
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-8">
            <div class="mb-6 flex items-start justify-between gap-4">
                <div>
                    <h3 class="font-serif-display text-2xl text-gray-900">New Guest</h3>
                    <p class="text-sm text-gray-500 mt-1">
                        Fields are generated from
                        @if(Route::has('admin.master-data-columns.index'))
                            <a href="{{ route('admin.master-data-columns.index') }}"
                               class="text-gray-700 underline hover:text-gray-900">Master Data Columns</a>.
                        @else
                            Master Data Columns.
                        @endif
                    </p>
                </div>
                <a href="{{ route('guest-list.index') }}"
                   class="text-sm text-gray-500 hover:text-gray-900">&larr; Back to list</a>
            </div>

            @if($columns->isEmpty())
                <div class="border border-dashed border-gray-200 rounded-md p-8 text-center">
                    <p class="text-gray-500 italic">No master data columns have been configured yet.</p>
                    @auth
                        @if(auth()->user()->hasRole('admin'))
                            <a href="{{ route('admin.master-data-columns.create') }}"
                               class="inline-flex items-center mt-4 px-4 py-2 rounded-md bg-gray-900 text-white text-sm font-medium hover:bg-gray-800 transition">
                                + Create First Column
                            </a>
                        @endif
                    @endauth
                </div>
            @else
                <form method="POST" action="{{ route('guest-list.store') }}" class="space-y-5">
                    @csrf

                    @foreach($columns as $column)
                        @php
                            $key = "answers.{$column->id}";
                            $name = "answers[{$column->id}]";
                            $id = "answer_{$column->id}";
                            $label = $column->name_to_show;
                            $isRequired = (bool) $column->required;
                            $oldValue = old($key, $column->default_value);
                        @endphp

                        <div>
                            <x-input-label :for="$id" class="text-gray-700">
                                {{ $label }}
                                @if($isRequired)
                                    <span class="text-red-500">*</span>
                                @endif
                            </x-input-label>

                            @if($column->data_type === 'select')
                                <select id="{{ $id }}" name="{{ $name }}"
                                    @if($isRequired) required @endif
                                    class="{{ $inputClasses }}">
                                    <option value="">— Select —</option>
                                    @foreach($column->selectionOptions as $option)
                                        @php
                                            $value = $option->option_value ?? '';
                                            $optionLabel = $option->option_label ?: $option->option_value;
                                        @endphp
                                        <option value="{{ $value }}"
                                            @selected((string) $oldValue === (string) $value)>
                                            {{ $optionLabel }}
                                        </option>
                                    @endforeach
                                </select>
                            @else
                                <input id="{{ $id }}" name="{{ $name }}" type="text"
                                    @if($isRequired) required @endif
                                    class="{{ $inputClasses }}"
                                    value="{{ $oldValue }}">
                            @endif

                            <x-input-error :messages="$errors->get($key)" class="mt-2" />
                        </div>
                    @endforeach

                    <div class="flex justify-end gap-3 pt-4 border-t border-gray-100">
                        <a href="{{ route('guest-list.index') }}"
                           class="px-4 py-2 rounded-md border border-gray-200 text-gray-700 hover:bg-gray-50">
                            Cancel
                        </a>
                        <button type="submit"
                                class="px-5 py-2 rounded-md bg-gray-900 text-white hover:bg-gray-800">
                            Add Guest
                        </button>
                    </div>
                </form>
            @endif
        </div>
    </div>
</x-app-layout>
