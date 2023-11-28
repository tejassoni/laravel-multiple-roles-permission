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
                    <a href="{{ route('subcategory.create') }}"
                        class="inline-flex items-center px-4 py-2 mb-4 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-green uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150">New</a>

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
                            @foreach ($categories as $category)
                                <tr>
                                    <td>{{ $category->name }}</td>
                                    <td>{{ $category->description }}</td>
                                    <td>{{ $category->getParentCatHasOne->name ?? 'None' }}</td>
                                    <td>{{ $category->getCatUserHasOne->name ?? 'None' }}</td>
                                    <td><select class="form-select" name="select_status" id="select_status" data-id="{{ $category->id }}">
                                    <option selected readonly disabled>{{ __('messages.status') }}</option>
                                    <option value="1" {{ $category->status == "1" ? "selected" : "" }}>{{ __('messages.active') }}</option>
                                    <option value="0" {{ $category->status == "0" ? "selected" : "" }}>{{ __('messages.in-active') }}</option>
                                    </select></td>
                                    <td>
                                        <form action="{{ route('subcategory.destroy', $category->id) }}" method="POST">
                                            <a class="btn btn-info btn-sm"
                                                href="{{ route('subcategory.show', $category->id) }}">{{ __('messages.show') }}</a>
                                            <a class="btn btn-primary btn-sm"
                                                href="{{ route('subcategory.edit', $category->id) }}">{{ __('messages.edit') }}</a>
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
                $('#select_status').on('change', function(){
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