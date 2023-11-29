<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create - User') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg px-4 py-4">
                <a href="{{ route('users.index') }}"
                    class="inline-flex items-center px-4 py-2 mb-4 text-xs font-semibold tracking-widest text-black uppercase transition duration-150 ease-in-out bg-green-600 border border-transparent rounded-md hover:bg-green-500 active:bg-green-700 focus:outline-none focus:border-green-700 focus:shadow-outline-gray disabled:opacity-25">
                    Go back
                </a>
                <form action="{{ route('users.store') }}" method="POST">
                    @csrf
                    <div class="mb-4">
                        <label for="textname" class="block mb-2 text-sm font-bold text-gray-700">Name</label>
                        <input type="text"
                            class="w-full px-3 py-2 leading-tight text-gray-700 border rounded shadow appearance-none focus:outline-none focus:shadow-outline"
                            name="name" placeholder="Enter name" value="{{ $user->name }}">
                        @error('name')
                            <span class="text-red-500">{{ $message }}
                            </span>
                        @enderror
                    </div>
                    <div class="mb-4">
                        <label for="textemail" class="block mb-2 text-sm font-bold text-gray-700">Email</label>
                        <input type="text"
                            class="w-full px-3 py-2 leading-tight text-gray-700 border rounded shadow appearance-none focus:outline-none focus:shadow-outline"
                            name="email" placeholder="Enter email" value="{{ $user->email }}">
                        @error('email')
                            <span class="text-red-500">{{ $message }}
                            </span>
                        @enderror
                    </div>
                    @php
                        // Inherit by-reference
$example = function ($data) use (&$message) {
    var_dump($message);
    echo '<pre> Test 1 :: Starts';
    print_r($data);
    echo '</pre>';
    // die('LOOP ENDS HERE');
    // if (in_array('string_val', $array_name)) {
    // // found
    // }
};
$example($user->getRoleNames()->toArray(),123);
                    @endphp 
                    <div class="mb-4">
                        <label for="textrole" class="block mb-2 text-sm font-bold text-gray-700">Select Role</label>
                        <select name="roles" id="roles" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" multiple>
                            <option selected>Choose a role</option>
                            @foreach ($roles as $role)
                            <option value="{{ $role->name }}" >{{ $role->name }}</option>
                            @endforeach
                          </select>  
                        @error('email')
                            <span class="text-red-500">{{ $message }}
                            </span>
                        @enderror
                    </div>

                    <div>
                        <button type="submit"
                            class="inline-flex items-center px-4 py-2 my-3 text-xs font-semibold tracking-widest text-white uppercase transition duration-150 ease-in-out bg-gray-800 border border-transparent rounded-md hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:shadow-outline-gray disabled:opacity-25">
                            Save
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
