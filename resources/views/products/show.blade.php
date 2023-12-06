<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Show - Product Details') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg px-4 py-4">
                <a title="back" href="{{ route('products.index') }}"
                    class="inline-flex items-center px-4 py-2 mb-4 text-xs font-semibold tracking-widest text-black uppercase transition duration-150 ease-in-out bg-green-600 border border-transparent rounded-md hover:bg-green-500 active:bg-green-700 focus:outline-none focus:border-green-700 focus:shadow-outline-gray disabled:opacity-25">
                    Go back
                </a>
                    <div class="mb-4">
                        <label for="name" class="block mb-2 text-sm font-bold text-gray-700">Product Name </label>
                        <input type="text"
                            class="w-full px-3 py-2 leading-tight text-gray-700 border rounded shadow appearance-none focus:outline-none focus:shadow-outline"
                            name="name" placeholder="Enter Product name" value="{{ old('name', $product->name) }}"
                            readonly disabled/>
                    </div>

                    <div class="mb-4">
                        <label for="description"
                            class="block mb-2 text-sm font-bold text-gray-700">{{ __('Description') }} </label>
                        <textarea class="form-control" cols="40" rows="7" name="description"
                            placeholder="{{ __('Enter Product description') }}" readonly disabled>{{ old('description', $product->description) }}</textarea>
                    </div>

                    <div class="mb-4">
                        <label for="image" class="block mb-2 text-sm font-bold text-gray-700">Image </label>
                        <img src="{{ asset('storage/products/'.$product->image) }}" heigth="150" width="150" />
                    </div>

                    <div class="mb-4">
                        <label for="parentcategory_name"
                            class="block mb-2 text-sm font-bold text-gray-700">{{ __('Parent category') }} </label>
                        <select class="form-select" name="select_parent_cat" id="select_parent_cat" readonly disabled/>
                            <option selected readonly disabled>{{ __('Select Parent category') . '--' }}</option>
                            @foreach ($parent_category as $parent_cat)
                                <option value="{{ $parent_cat->id }}"
                                    @if (old('select_parent_cat') && $parent_cat->id == old('select_parent_cat')) selected
                        @elseif(!old('select_parent_cat') && $parent_cat->id == $product->parent_category_id)
                        selected @endif>
                                    {{ $parent_cat->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-4">
                        <label for="price" class="block mb-2 text-sm font-bold text-gray-700">Price </label>
                        <input type="text"
                            class="w-full px-3 py-2 leading-tight text-gray-700 border rounded shadow appearance-none focus:outline-none focus:shadow-outline"
                            name="price" min="1" maxlength="10" placeholder="Enter Product price"
                            value="{{ old('price', $product->price) }}" readonly disabled/>
                    </div>

                    <div class="mb-4">
                        <label for="qty" class="block mb-2 text-sm font-bold text-gray-700">Quantity </label>
                        <input type="number"
                            class="w-full px-3 py-2 leading-tight text-gray-700 border rounded shadow appearance-none focus:outline-none focus:shadow-outline numberonly"
                            name="qty" min="0" placeholder="Enter Product Quantity"
                            value="{{ old('qty', $product->qty) }}" readonly disabled/>
                    </div>
            </div>
        </div>
    </div>
</x-app-layout>
