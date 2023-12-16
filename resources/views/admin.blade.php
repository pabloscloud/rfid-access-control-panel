<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Admin') }}
        </h2>
    </x-slot>

    <div class="py-3">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-gray-300 dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                @if($chips->isNotEmpty())
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    {{ __("These are all the chips. They can be used alongside their pin ;)") }}
                </div>

                <div class="px-6 py-4">
                @foreach($chips as $chip)
                    <div class="py-4 text-gray-900 dark:text-gray-100">
                        <div class="flex justify-between">
                            <div class="flex">
                                <x-heroicon-o-key class="h-6 w-6 mr-3 text-indigo-600" /> {{ $chip->name }} owned by {{ $chip->user->name }}
                            </div>

                            <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                                {{ $chip->logs->where('success', 0)->count() === 0 ? 'No' : $chip->logs->where('success', 0)->count() }} unsuccessful {{ Str::plural('attempt', $chip->logs->where('success', 0)->count()) }}
                            </div>

                        </div>
                        <div class="sm:hidden text-gray-900 dark:text-gray-100">
                            {{ $chip->logs->where('success', 0)->count() === 0 ? 'No' : $chip->logs->where('success', 0)->count() }} unsuccessful {{ Str::plural('attempt', $chip->logs->where('success', 0)->count()) }}
                        </div>
                    </div>
                @endforeach
                </div>

                @else
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    {{ __("There are no chips. Go on, make yourself useful and add some!") }}
                </div>
                @endif
            </div>
        </div>
    </div>

<div class="py-3">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-gray-300 dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                @if($logs->isNotEmpty())
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    {{ __("These are logs regarding your chips. Something seems sus? Report it to your admin to investigate :/") }}
                </div>

                <div class="px-6 py-4">
                @foreach($logs as $log)
                    <div class="py-4 {{ $log->success === 0 ? 'text-red-600' : 'text-gray-900 dark:text-gray-100' }}">
                        <div class="flex justify-between">
                            <div class="flex">
                                <x-heroicon-o-key class="h-6 w-6 mr-3 text-{{ $log->success === 0 ? 'red' : 'green' }}-600" /> {{ $log->chip->name }} owned by {{ $log->chip->user->name }}
                            </div>

                            <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                                {{ $log->success === 0 ? 'unsuccessful attempt' : 'successful attempt' }} {{ $log->created_at() }}
                            </div>

                        </div>
                        <div class="sm:hidden">
                            {{ $log->success === 0 ? 'unsuccessful attempt' : 'successful attempt' }} {{ $log->created_at() }}
                        </div>
                    </div>
                @endforeach
                </div>

                @else
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    {{ __("There are no logs regarding chips usage. Try and see if they work. If not, blame yourself!") }}
                </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
