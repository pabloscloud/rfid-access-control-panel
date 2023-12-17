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
                    {{ __("These are logs regarding chips usage. Something seems sus? Investigate!") }}
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
