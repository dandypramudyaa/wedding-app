<x-app-layout>
    <x-slot name="header">
        <div>
            <p class="text-xs uppercase tracking-[0.3em] text-gray-500">Wedding · Guest List</p>
            <h2 class="font-serif-display text-3xl text-gray-900 leading-tight">Guest #{{ $guest->id }}</h2>
        </div>
    </x-slot>

    <div>
        <div class="flex items-center justify-between mb-4">
            <a href="{{ route('guest-list.index') }}"
               class="text-sm text-gray-500 hover:text-gray-900">&larr; Back to list</a>

            <div class="flex items-center gap-3 text-xs text-gray-500">
                <span>Added {{ $guest->created_at?->diffForHumans() }}</span>
                @if($guest->createdBy)
                    <span>·</span>
                    <span>by {{ $guest->createdBy->name }}</span>
                @endif
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
            <div class="px-8 py-6 border-b border-gray-100">
                <h3 class="font-serif-display text-2xl text-gray-900">Details</h3>
            </div>

            @if($columns->isEmpty())
                <div class="px-8 py-10 text-center text-gray-400 italic">
                    No master data columns are configured — nothing to display.
                </div>
            @else
                <dl class="divide-y divide-gray-100">
                    @foreach($columns as $column)
                        @php
                            $answer = $answersByColumn->get($column->id);
                            $option = $answer?->selectionOption;
                            $hasValue = $answer && ($option || filled($answer->value));
                        @endphp

                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-2 px-8 py-4">
                            <dt class="text-sm font-medium text-gray-500">
                                {{ $column->name_to_show }}
                                @if($column->required)
                                    <span class="text-red-500">*</span>
                                @endif
                                <span class="block text-[11px] font-mono text-gray-400 mt-0.5">
                                    {{ $column->name_to_show }} · {{ $column->data_type }}
                                </span>
                            </dt>

                            <dd class="sm:col-span-2 text-sm text-gray-900">
                                @if(!$hasValue)
                                    <span class="text-gray-300 italic">— not provided —</span>
                                @elseif($column->data_type === 'select' && $option)
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium"
                                        @if($option->color)
                                            style="background-color: {{ $option->color }}1A; color: {{ $option->color }};"
                                        @else
                                            style="background-color: #f3f4f6; color: #374151;"
                                        @endif>
                                        {{ $option->option_label ?: $option->option_value }}
                                    </span>
                                    <!-- <span class="ml-2 text-xs text-gray-400 font-mono">{{ $option->option_value }}</span> -->
                                @else
                                    <span class="whitespace-pre-wrap break-words">{{ $answer->value }}</span>
                                @endif
                            </dd>
                        </div>
                    @endforeach
                </dl>
            @endif
        </div>

        <div class="mt-6 flex flex-wrap justify-between gap-3">
            <form action="{{ route('guest-list.destroy', $guest) }}"
                  method="POST"
                  onsubmit="return confirm('Delete this guest? This will also remove all their answers.');">
                @csrf
                @method('DELETE')
                <button type="submit"
                        class="px-4 py-2 rounded-md border border-red-200 text-red-600 hover:bg-red-50 text-sm">
                    Delete Guest
                </button>
            </form>

            <div class="flex gap-3 ms-auto">
                <a href="{{ route('guest-list.index') }}"
                   class="px-4 py-2 rounded-md border border-gray-200 text-gray-700 hover:bg-gray-50 text-sm">
                    Back to list
                </a>
                <a href="{{ route('guest-list.create') }}"
                   class="px-5 py-2 rounded-md bg-gray-900 text-white hover:bg-gray-800 text-sm">
                    + Add Another Guest
                </a>
            </div>
        </div>
    </div>
</x-app-layout>
