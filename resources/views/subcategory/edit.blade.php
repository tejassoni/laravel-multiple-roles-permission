<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit - Sub Category') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg px-4 py-4">
                <a title="back" href="{{ route('subcategory.index') }}"
                    class="inline-flex items-center px-4 py-2 mb-4 text-xs font-semibold tracking-widest uppercase transition duration-150 ease-in-out bg-green-600 border border-transparent rounded-md hover:bg-green-500 active:bg-green-700 focus:outline-none focus:border-green-700 focus:shadow-outline-gray disabled:opacity-25">
                    {{ __('Back') }}
                </a>

                @if ($message = Session::get('error'))
                    <div class="bg-green-100 border-t-4 border-green-500 rounded-b text-green-900 px-4 py-3 shadow-md my-3"
                        role="alert">
                        <div class="flex">
                            <div>
                                <p class="text-sm text-danger">{{ $message }}</p>
                            </div>
                        </div>
                    </div>
                @endif
                <form action="{{ route('subcategory.update', $subcategory->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="mb-4">
                        <label for="subcategory_name"
                        class="block mb-2 text-sm font-bold text-gray-700">{{ __('Sub Category Name') }} <span
                        class="text-red-600">*</span></label>
                        <input type="text" name="name" class="form-control"
                            placeholder="{{ __('Enter Sub Category name') }}" maxlength="100"
                            value="{{ old('name',$subcategory->name) }}">
                        @error('name')
                            <span class="text-red-500 text-danger">{{ $message }}
                            </span>
                        @enderror
                    </div>
                    <div class="mb-4">
                        <label for="subcategory_description"
                        class="block mb-2 text-sm font-bold text-gray-700">{{ __('Sub Category Description') }} <span
                        class="text-red-600">*</span></label>
                        <textarea class="form-control" cols="40" rows="7" name="description"
                            placeholder="{{ __('messages.enter_category_description') }}">{{ old('description',$subcategory->description) }}</textarea>
                        @error('description')
                            <span class="text-red-500 text-danger">{{ $message }}
                            </span>
                        @enderror
                    </div>
                    <div class="mb-4">
                        <label for="parentcategory_name"
                            class="block mb-2 text-sm font-bold text-gray-700">{{ __('Parent category') }} <span
                            class="text-red-600">*</span></label>
                        <select class="form-select" name="select_parent_cat" id="select_parent_cat">
                            <option selected readonly disabled>{{ __('Select Parent category--') }}</option>
                            @foreach ($parent_category ?? [] as $parent_cat)
                            <option value="{{ $parent_cat->id }}" {{ $subcategory->parent_category_id == $parent_cat->id ? "selected" : "" }} >{{ $parent_cat->name }}</option>
                            @endforeach
                        </select>
                        @error('select_parent_cat')
                            <span class="text-red-500 text-danger">{{ $message }}
                            </span>
                        @enderror
                    </div>
                    <div>
                        <button title="update" type="submit"
                            class="inline-flex items-center px-4 py-2 my-3 text-xs font-semibold tracking-widest text-white uppercase transition duration-150 ease-in-out bg-gray-800 border border-transparent rounded-md hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:shadow-outline-gray disabled:opacity-25">
                            {{ __('Update') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>