<x-app-layout>
    <x-slot name="header">
        <div>
            <p class="text-xs uppercase tracking-[0.3em] text-gray-500">Wedding</p>
            <h2 class="font-serif-display text-3xl text-gray-900 leading-tight">Guest List</h2>
        </div>
    </x-slot>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between mb-4">
            <p class="text-sm text-gray-500">
                {{ $guests->total() }} {{ Str::plural('guest', $guests->total()) }} total
            </p>
            <a href="{{ route('guest-list.create') }}"
               class="inline-flex items-center px-4 py-2 rounded-md bg-gray-900 text-white text-sm font-medium hover:bg-gray-800 transition">
                + Add Guest
            </a>
        </div>

        @if($columns->isEmpty())
            <div class="bg-white border border-dashed border-gray-200 rounded-lg p-10 text-center">
                <p class="text-gray-500 italic">No master data columns have been configured yet — the list has no fields to display.</p>
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
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">#</th>
                                @foreach($columns as $column)
                                    <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">
                                        {{ $column->name_to_show }}
                                    </th>
                                @endforeach
                                <th class="px-6 py-3 text-right text-xs font-semibold uppercase tracking-wider text-gray-500">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse($guests as $guest)
                                @php $byColumn = $guest->answers->keyBy('master_data_column_id'); @endphp
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 text-sm text-gray-500 font-mono">{{ $guest->id }}</td>
                                    @foreach($columns as $column)
                                        @php $answer = $byColumn->get($column->id); @endphp
                                        <td class="px-6 py-4 text-sm text-gray-800">
                                            @if(!$answer)
                                                <span class="text-gray-300">—</span>
                                            @elseif($column->data_type === 'select' && $answer->selectionOption)
                                                @php $opt = $answer->selectionOption; @endphp
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium"
                                                    @if($opt->color)
                                                        style="background-color: {{ $opt->color }}1A; color: {{ $opt->color }};"
                                                    @else
                                                        style="background-color: #f3f4f6; color: #374151;"
                                                    @endif>
                                                    {{ $opt->option_label ?: $opt->option_value }}
                                                </span>
                                            @else
                                                {{ $answer->value }}
                                            @endif
                                        </td>
                                    @endforeach
                                    <td class="px-6 py-4 text-right text-sm whitespace-nowrap">
                                        <a href="{{ route('guest-list.show', $guest) }}"
                                           class="text-gray-700 hover:text-gray-900 hover:underline me-3">View</a>
                                        <form action="{{ route('guest-list.destroy', $guest) }}"
                                              method="POST"
                                              class="inline"
                                              onsubmit="return confirm('Delete this guest?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                    class="text-red-600 hover:text-red-700 hover:underline">
                                                Delete
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="{{ $columns->count() + 2 }}" class="px-6 py-10 text-center text-gray-400 italic">
                                        No guests added yet.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            @if($guests instanceof \Illuminate\Contracts\Pagination\Paginator)
                <div class="mt-4">
                    {{ $guests->links() }}
                </div>
            @endif
        @endif
    </div>
</x-app-layout>
