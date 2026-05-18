<x-app-layout>
    <x-slot name="header">
        <div>
            <p class="text-xs uppercase tracking-[0.3em] text-gray-500">Administrator</p>
            <h2 class="font-serif-display text-3xl text-gray-900 leading-tight">Create Master Data Column</h2>
        </div>
    </x-slot>

    @php
        $existingOptions = collect(old('options', []))
            ->map(fn ($option) => [
                'option_value' => $option['option_value'] ?? '',
                'option_label' => $option['option_label'] ?? '',
                'color' => $option['color'] ?? '',
            ])
            ->values()
            ->all();
        $initialOptions = !empty($existingOptions)
            ? $existingOptions
            : [['option_value' => '', 'option_label' => '', 'color' => '']];

        $inputClasses = 'block mt-1 w-full border-gray-200 focus:border-gray-400 focus:ring-gray-400 rounded-md';
    @endphp

    <div>
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-8">
            <form method="POST" action="{{ route('admin.master-data-columns.store') }}">
                @csrf

                <div
                    x-data="{
                        dataType: @js(old('data_type', 'text')),
                        options: @js($initialOptions),
                        addOption() {
                            this.options.push({ option_value: '', option_label: '', color: '' });
                        },
                        removeOption(index) {
                            this.options.splice(index, 1);
                            if (this.options.length === 0) {
                                this.addOption();
                            }
                        },
                    }"
                    class="space-y-5"
                >
                    <div>
                        <x-input-label for="name" value="Name" class="text-gray-700" />
                        <x-text-input id="name" name="name" type="text" required
                            class="{{ $inputClasses }}"
                            value="{{ old('name') }}"
                            placeholder="e.g. Full name" />
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="name_to_show" value="Name to Show (key)" class="text-gray-700" />
                        <x-text-input id="name_to_show" name="name_to_show" type="text"
                            class="{{ $inputClasses }} font-mono"
                            value="{{ old('name_to_show') }}"
                            placeholder="auto-generated from Name if left blank" />
                        <p class="mt-1 text-xs text-gray-500">Machine-readable key. Leave blank to auto-generate (e.g. "Full name" → "full_name").</p>
                        <x-input-error :messages="$errors->get('name_to_show')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="data_type" value="Data Type" class="text-gray-700" />
                        <select id="data_type" name="data_type" required
                            x-model="dataType"
                            class="{{ $inputClasses }}">
                            @foreach($dataTypes as $type)
                                <option value="{{ $type }}" @selected(old('data_type') === $type)>
                                    {{ ucfirst($type) }}
                                </option>
                            @endforeach
                        </select>
                        <x-input-error :messages="$errors->get('data_type')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="default_value" value="Default Value (optional)" class="text-gray-700" />
                        <x-text-input id="default_value" name="default_value" type="text"
                            class="{{ $inputClasses }}"
                            value="{{ old('default_value') }}" />
                        <x-input-error :messages="$errors->get('default_value')" class="mt-2" />
                    </div>

                    <div>
                        <label class="inline-flex items-center gap-2 cursor-pointer">
                            <input type="hidden" name="required" value="0">
                            <input type="checkbox" name="required" value="1"
                                class="rounded border-gray-300 text-gray-900 focus:ring-gray-400"
                                {{ old('required') ? 'checked' : '' }}>
                            <span class="text-sm text-gray-700">Required</span>
                        </label>
                        <x-input-error :messages="$errors->get('required')" class="mt-2" />
                    </div>

                    {{-- Selection Options (only for data_type=select) --}}
                    <div x-show="dataType === 'select'" x-cloak class="border-t border-gray-200 pt-5">
                        <div class="flex items-center justify-between mb-3">
                            <div>
                                <h3 class="text-sm font-semibold text-gray-900">Selection Options</h3>
                                <p class="text-xs text-gray-500">Define the choices available for this column.</p>
                            </div>
                            <button type="button" @click="addOption()"
                                class="text-sm text-gray-700 hover:text-gray-900 font-medium">
                                + Add Option
                            </button>
                        </div>

                        <div class="space-y-2">
                            <template x-for="(option, index) in options" :key="index">
                                <div class="grid grid-cols-12 gap-2 items-start">
                                    <div class="col-span-4">
                                        <input type="text"
                                            :name="`options[${index}][option_value]`"
                                            x-model="option.option_value"
                                            placeholder="value (e.g. bride)"
                                            class="block w-full text-sm font-mono border-gray-200 focus:border-gray-400 focus:ring-gray-400 rounded-md">
                                    </div>
                                    <div class="col-span-4">
                                        <input type="text"
                                            :name="`options[${index}][option_label]`"
                                            x-model="option.option_label"
                                            placeholder="label (e.g. Bride's side)"
                                            class="block w-full text-sm border-gray-200 focus:border-gray-400 focus:ring-gray-400 rounded-md">
                                    </div>
                                    <div class="col-span-3">
                                        <div class="flex items-center gap-2">
                                            <input type="color"
                                                x-model="option.color"
                                                class="h-9 w-10 shrink-0 p-1 border border-gray-200 rounded-md cursor-pointer bg-white"
                                                aria-label="Pick color">
                                            <input type="text"
                                                :name="`options[${index}][color]`"
                                                x-model="option.color"
                                                placeholder="#111827"
                                                class="block w-full text-sm font-mono border-gray-200 focus:border-gray-400 focus:ring-gray-400 rounded-md">
                                        </div>
                                    </div>
                                    <div class="col-span-1 flex justify-end">
                                        <button type="button" @click="removeOption(index)"
                                            class="px-2 py-2 text-gray-400 hover:text-red-600"
                                            aria-label="Remove option">
                                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.8">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                            </template>
                        </div>

                        <p class="mt-2 text-xs text-gray-400">Empty rows will be ignored when saving.</p>
                    </div>
                </div>

                <div class="flex justify-end gap-3 pt-6">
                    <a href="{{ route('admin.master-data-columns.index') }}"
                       class="px-4 py-2 rounded-md border border-gray-200 text-gray-700 hover:bg-gray-50">Cancel</a>
                    <button class="px-5 py-2 rounded-md bg-gray-900 text-white hover:bg-gray-800">Create Column</button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
