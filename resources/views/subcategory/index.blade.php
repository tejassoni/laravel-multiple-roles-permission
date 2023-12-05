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
                    <table id="sub-category-tbl" class="display" style="width:100%">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Description</th>
                                <th>Parent-category</th>
                                <th>Created-by</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($subcategories as $subCat)
                                <tr>
                                    <td>{{ $subCat->name }}</td>
                                    <td>{{ $subCat->description }}</td>
                                    <td>{{ $subCat->getParentCatHasOne->name ?? 'None' }}</td>
                                    <td>{{ $subCat->getCatUserHasOne->name ?? 'None' }}</td>
                                    <td> <label class="switch" title="change status">
                                        <input id="<?= $subCat->id ?>" class="changeStatus" type="checkbox"
                                            <?= ($subCat->status == 1) ? 'checked' : ''; ?> value="{{ $subCat->status }}">
                                        <span class="slider round"></span>
                                    </label></td>
                                    <td>
                                        <form action="{{ route('subcategory.destroy', $subCat->id) }}" method="POST">
                                            <a class="btn btn-info btn-sm"
                                                href="{{ route('subcategory.show', $subCat->id) }}">{{ __('messages.show') }}</a>
                                            <a class="btn btn-primary btn-sm"
                                                href="{{ route('subcategory.edit', $subCat->id) }}">{{ __('messages.edit') }}</a>
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this ?');">{{ __('messages.delete') }}</button>
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
    @push('footer-scripts')
        <script type="text/javascript">
            $(document).ready(function() {
                $('#sub-category-tbl').DataTable();
                // Status update
                $('.changeStatus').on('change', function(){
                     $.ajax({
                        type: 'POST',
                        url: "{{ url('subcategory/statusupdate') }}",
                        data: {"_token": "{{ csrf_token() }}",status:$(this).val(),id:$(this).attr('data-id')},
                        dataType: 'json', 
                        success: function(data_resp, textStatus, jqXHR) { // On ajax success operation
                            if(data_resp.status){
                                alert(data_resp.message);
                            }
                        },error: function (jqXHR, textStatus, errorThrown) { // On ajax error operation 
                           alert(textStatus, errorThrown);        
                        }
                        });
                });
            });
        </script>
    @endpush
</x-app-layout>