<x-app-layout>
  <x-slot name="header">
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Edit - Parent Category') }}
      </h2>
  </x-slot>
  <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
          <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg px-4 py-4">
              <a title="back" href="{{ route('category.index') }}"
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
              <form action="{{ route('category.update', $category->id) }}" method="POST">
                  @csrf
                  @method('PUT')
                  <div class="mb-4">
                      <label for="category_name"
                          class="block mb-2 text-sm font-bold text-gray-700">{{ __('Category name') }}<span
                          class="text-red-600">*</span></label>
                      <input type="text" name="name" class="form-control"
                          placeholder="{{ __('Enter category name') }}" maxlength="50"
                          value="{{ old('name',$category->name) }}">
                      @error('name')
                          <span class="text-red-500 text-danger">{{ $message }}
                          </span>
                      @enderror
                  </div>
                  <div class="mb-4">
                      <label for="category_description"
                          class="block mb-2 text-sm font-bold text-gray-700">{{ __('Category Description') }}</label>
                      <textarea class="form-control" style="height:150px" name="description"
                          placeholder="{{ __('Enter Category description') }}">{{ old('description',$category->description) }}</textarea>
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