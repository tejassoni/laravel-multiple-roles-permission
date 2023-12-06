<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
           Sub Category
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <a title="new" href="{{ route('subcategory.create') }}"
                        class="inline-flex items-center px-4 py-2 mb-4 text-xs font-semibold tracking-widest text-black uppercase transition duration-150 ease-in-out bg-green-600 border border-transparent rounded-md hover:bg-green-500 active:bg-green-700 focus:outline-none focus:border-green-700 focus:shadow-outline-gray disabled:opacity-25">Create New Sub Category</a>

                    @if ($message = Session::get('success'))
                        <div class="bg-green-100 border-t-4 border-green-500 rounded-b text-green-900 px-4 py-3 shadow-md my-3"
                            role="alert">
                            <div class="flex">
                                <div>
                                    <p class="text-sm text-success">{{ $message }}</p>
                                </div>
                            </div>
                        </div>
                    @endif
                    <table id="sub-category-tbl" class="w-full table-fixed" style="width:100%">
                        <thead>
                            <tr class="bg-gray-100">
                                <th class="px-4 py-2 border">Name</th>
                                <th class="px-4 py-2 border">Description</th>
                                <th class="px-4 py-2 border">Parent-category</th>
                                <th class="px-4 py-2 border">Created-by</th>
                                <th class="px-4 py-2 border">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($subcategories as $subCat)
                                <tr>
                                    <td class="px-4 py-2 border">{{ $subCat->name }}</td>
                                    <td class="px-4 py-2 border">{{ $subCat->description }}</td>
                                    <td class="px-4 py-2 border">{{ $subCat->getParentCatHasOne->name ?? 'None' }}</td>
                                    <td class="px-4 py-2 border">{{ $subCat->getCatUserHasOne->name ?? 'None' }}</td>
                                    <td class="px-4 py-2 border">
                                        <form action="{{ route('subcategory.destroy', $subCat->id) }}" method="POST">
                                            <a class="inline-flex items-center px-4 py-2 mx-2 text-xs font-semibold tracking-widest text-white uppercase transition duration-150 ease-in-out bg-gray-500 border border-transparent rounded-md hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:shadow-outline-gray disabled:opacity-25"
                                                href="{{ route('subcategory.show', $subCat->id) }}">{{ __('Show') }}</a>
                                            <a class="inline-flex items-center px-4 py-2 mx-2 text-xs font-semibold tracking-widest text-white uppercase transition duration-150 ease-in-out bg-gray-800 border border-transparent rounded-md hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:shadow-outline-gray disabled:opacity-25"
                                                href="{{ route('subcategory.edit', $subCat->id) }}">{{ __('Edit') }}</a>
                                            @csrf
                                            @method('DELETE')
                                            <button title="delete" type="submit"
                                                class="inline-flex items-center px-4 py-2 mx-2 text-xs font-semibold tracking-widest text-white uppercase transition duration-150 ease-in-out bg-red-600 border border-transparent rounded-md hover:bg-red-500 active:bg-red-700 focus:outline-none focus:border-red-700 focus:shadow-outline-gray disabled:opacity-25" onclick="return confirm('Are you sure you want to delete this ?');">{{ __('Delete') }}</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>