<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Users') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">

                    <table class="w-full">
                        <thead class="border-b">
                        <tr>
                            <th scope="col" class="text-start py-2">Name</th>
                            <th scope="col" class="text-start py-2">Image</th>
                            <th scope="col" class="text-start py-2">Image Verified At</th>
                            <th scope="col" class="text-start py-2">Email</th>
                            <th scope="col" class="ab asa atm aue cgk"><span class="t">Edit</span></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($users as $user)
                            <tr>
                                <td class="py-4">{{$user->name}}</td>
                                <td class="py-4">
                                    @if($user->image)
                                        <img src="{{ asset('/storage/images/' . $user->image) }}" alt="User Profile"
                                             class="w-[40px] aspect-square">
                                    @else
                                        <span class="opacity-50">No Image</span>
                                    @endif
                                </td>
                                <td class="py-4 opacity-50">{{$user->image_verified_at ?? 'Not Verified'}}</td>
                                <td class="py-4 opacity-50">{{$user->email}}</td>
                                <td class="py-4 text-center">
                                    <a href="{{ route('users.edit', $user) }}" class="bg-blue-700 px-4 py-1 rounded">Edit</a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>

                    {{ $users->links() }}

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
