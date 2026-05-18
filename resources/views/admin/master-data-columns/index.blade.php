<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-xs uppercase tracking-[0.3em] text-rose-500">Administrator</p>
                <h2 class="font-serif-display text-3xl text-rose-800 leading-tight">Master Data Columns</h2>
            </div>
            @if(Route::has('admin.master-data-columns.create'))
                <a href="{{ route('admin.master-data-columns.create') }}"
                   class="inline-flex items-center px-4 py-2 rounded-full bg-rose-500 text-white text-sm font-medium hover:bg-rose-600 transition">
                    + New Column
                </a>
            @endif
        </div>
    </x-slot>

    <div class="max-w-7xl mx-auto">
        <div class="bg-white rounded-2xl shadow-sm border border-rose-100 overflow-hidden">
            <table class="min-w-full divide-y divide-rose-100">
                <thead class="bg-rose-50/60">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-rose-700">Name</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-rose-700">Name to Show</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-rose-700">Data Type</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-rose-700">Required</th>
                        <th class="px-6 py-3 text-right text-xs font-semibold uppercase tracking-wider text-rose-700">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-rose-50">
                    @forelse($columns as $column)
                        <tr class="hover:bg-rose-50/30">
                            <td class="px-6 py-4 text-sm text-gray-800 font-medium">{{ $column->name }}</td>
                            <td class="px-6 py-4 text-sm text-gray-700 font-mono">{{ $column->name_to_show }}</td>
                            <td class="px-6 py-4 text-sm text-gray-600">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full bg-rose-100 text-rose-700 text-xs font-medium">
                                    {{ $column->data_type }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-sm">
                                @if($column->required)
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full bg-green-100 text-green-700 text-xs font-medium">Yes</span>
                                @else
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full bg-gray-100 text-gray-600 text-xs font-medium">No</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-right text-sm">
                                @if($column->exists && Route::has('admin.master-data-columns.edit'))
                                    <a href="{{ route('admin.master-data-columns.edit', $column) }}" class="text-rose-600 hover:underline me-3">Edit</a>
                                @endif
                                @if($column->exists && Route::has('admin.master-data-columns.destroy'))
                                    <form action="{{ route('admin.master-data-columns.destroy', $column) }}" method="POST" class="inline"
                                          onsubmit="return confirm('Delete this column?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:underline">Delete</button>
                                    </form>
                                @endif
                                @unless($column->exists)
                                    <span class="text-xs text-gray-400 italic">preview</span>
                                @endunless
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-10 text-center text-gray-400 italic">No master data columns yet.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($columns instanceof \Illuminate\Contracts\Pagination\Paginator)
            <div class="mt-4">
                {{ $columns->links() }}
            </div>
        @endif
    </div>
</x-app-layout>
