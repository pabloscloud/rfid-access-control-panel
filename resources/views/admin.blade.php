<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Admin') }}
        </h2>
    </x-slot>

    @if($chipsUnassigned->isNotEmpty())
        <div class="py-3">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-gray-300 dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        {{ __("There are unassigned chips. Please assign them to users or delete them!") }}
                    </div>

                    <div class="px-6 py-4">
                        @foreach($chipsUnassigned as $chip)
                            <div class="py-4 text-gray-900 dark:text-gray-100">
                                <div class="items-center flex-wrap gap-4 hidden md:-my-px md:md-10 md:flex">
                                    <x-heroicon-o-key class="h-6 w-6 text-indigo-600" />
                                    <form action="{{ route('admin.chip.assign', ['chip' => $chip]) }}" method="post" class="form-group flex items-center space-x-3 flex-wrap" onsubmit="prepareData(event)">
                                        @csrf
                                        @method('put')
                                        <x-text-input name="chip_name" value="{{ $chip->name }}" />
                                        <select class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm mb-2 sm:mb-0" name="user_id">
                                            <option value="">Assign User</option>
                                            @foreach($users as $user)
                                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                                            @endforeach
                                        </select>
                                        <x-primary-button>{{ __('Assign') }}</x-primary-button>
                                    </form>

                                    <form action="{{ route('admin.chip.delete', ['chip' => $chip]) }}" method="post" class="mt-3 sm:mt-0">
                                        @csrf
                                        @method('delete')
                                        <x-danger-button>{{ __('Delete') }}</x-danger-button>
                                    </form>
                                </div>
                                <div class="flex items-center flex-wrap gap-4 md:hidden">
                                    <x-heroicon-o-key class="h-6 w-6 mr-3 text-indigo-600" /> {{ $chip->name }}

                                    <x-primary-button
                                            x-data=""
                                            x-on:click.prevent="$dispatch('open-modal', 'assign-chip-user')"
                                        >{{ __('Assign') }}</x-primary-button>

                                    <form action="{{ route('admin.chip.delete', ['chip' => $chip]) }}" method="post">
                                        @csrf
                                        @method('delete')
                                        <x-danger-button>{{ __('Delete') }}</x-danger-button>
                                    </form>

                                    <x-modal name="assign-chip-user" focusable>
                                        <form method="post" action="{{ route('admin.chip.assign', ['chip' => $chip]) }}" class="p-6">
                                            @csrf
                                            @method('put')

                                            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                                                {{ __('Which user do you want to assign this chip to?') }}
                                            </h2>

                                            <div class="mt-6">
                                                <div class="mt-2">
                                                    <x-input-label for="chip_name" value="{{ __('Chip Name') }}" />
                                                    <x-text-input
                                                        id="chip_name"
                                                        name="chip_name"
                                                        class="mt-1 block w-full"
                                                        value="{{ $chip->name }}"
                                                        placeholder="{{ $chip->name }}"
                                                    />
                                                </div>

                                                <div class="mt-2">
                                                    <x-input-label for="chip_name" value="{{ __('Chip User') }}" />
                                                    <select name="user_id" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm mb-2 sm:mb-0">
                                                        <option value="">Assign User</option>
                                                        @foreach($users as $user)
                                                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="mt-6 flex justify-end">
                                                <x-secondary-button x-on:click="$dispatch('close')">
                                                    {{ __('Cancel') }}
                                                </x-secondary-button>

                                                <x-primary-button class="ms-3">
                                                    {{ __('Assign') }}
                                                </x-primary-button>
                                            </div>
                                        </form>
                                    </x-modal>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    @endif

    <div class="py-3">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-gray-300 dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                @if($chips->isNotEmpty())
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    {{ __("These are all the chips. They can be used alongside the users pin ;)") }}
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
                    {{ __("These are logs regarding chip-usage. Something seems sus? Investigate!") }}
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

    <div class="py-3">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-gray-300 dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                @if($userInRooms->isNotEmpty())
                <style>
                    .avatar-wrapper {
                      display: inline-block; /* Ensures avatars appear in a row */
                      margin: 5px; /* Adjust as needed */
                    }

                    .avatar {
                      box-sizing: border-box;
                      border-radius: 50%;
                      overflow: hidden;
                      display: flex;
                      justify-content: center;
                      align-items: center;
                      text-align: center;
                      padding: 5px;
                      box-shadow: 0 15px 15px 0px rgba(0, 0, 0, 0.2);
                    }

                    .avatar p {
                      margin: 0;
                    }

                    .floater {
                    	transform: translate(0px);
                    	animation: float 7s ease-in-out infinite;
                    	box-shadow: 0 15px 15px 0px rgba(0,0,0,0.2);
                    }

                    .delay {
                    	animation-delay: 2s;
                    }

                    @keyframes float {
                    	0% {
                    		transform: translatey(0px);
                    	}
                      	5% {
                    		transform: translatey(0px);
                    	}
                    	50% {
                    		transform: translatey(-15px);
                    	}
                    	95% {
                    		transform: translatey(0px);
                    	}
                      	100% {
                    		transform: translatey(0px);
                    	}
                    }

                    @keyframes float-2 {
                    	0% {
                    		transform: translatey(0px);
                    	}
                      	5% {
                    		transform: translatey(0px);
                    	}
                    	50% {
                    		transform: translatey(-15px);
                    	}
                    	95% {
                    		transform: translatey(0px);
                    	}
                      	100% {
                    		transform: translatey(0px);
                    	}
                    }

                    @keyframes float-alt {
                    	0% {
                    		box-shadow: 0 5px 15px 0px rgba(0,0,0,0.6);
                    		transform: translatey(0px);
                    	}
                      	5% {
                    		transform: translatey(0px);
                    	}
                    	50% {
                    		box-shadow: 0 25px 15px 0px rgba(0,0,0,0.2);
                    		transform: translatey(-20px);
                    	}
                    	95% {
                    		box-shadow: 0 25px 15px 0px rgba(0,0,0,0.2);
                    		transform: translatey(0px);
                    	}
                      	100% {
                    		box-shadow: 0 5px 15px 0px rgba(0,0,0,0.6);
                    		transform: translatey(0px);
                    	}
                    }
                </style>
                <script>
                    window.addEventListener('DOMContentLoaded', () => {
                      const avatars = document.querySelectorAll('.avatar p');
                      avatars.forEach((avatar) => {
                        const nameLength = avatar.textContent.trim().length;
                        const diameter = 40 + nameLength * 10; // Adjust the multiplier to suit your design
                        avatar.closest('.avatar').style.width = `${diameter}px`;
                        avatar.closest('.avatar').style.height = `${diameter}px`;
                      });
                    });
                </script>
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    {{ __("These are the users, who are inside. Something seems sus? Investigate!") }}
                </div>

                <div class="px-6 py-4">
                @foreach($userInRooms as $key => $userInRoom)
                    <div class="avatar-wrapper">
                        <div class="avatar floater @if($key % 2 != 0) delay @endif bg-gray-100 dark:bg-gray-700">
                            <p class="text-gray-900 dark:text-gray-100">{{$userInRoom->user->name}}</p>
                        </div>
                    </div>
                @endforeach
                </div>

                @else
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    {{ __("There are no users inside. Can they get inside? If not, blame yourself!") }}
                </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
