<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            {{ __('Update API Key') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            {{ __('Create a new api key, in case you don\'t have one already or forgot your old one.') }}
        </p>
    </header>

    <form method="post" action="{{ route('apikey.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('put')

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Create New Key') }}</x-primary-button>

            @if (session('token'))
            <p
                x-data="{ show: true }"
                x-show="show"
                x-transition
                x-init="setTimeout(() => show = false, 5000)"
                class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                {{ __('Updated. Copy your new key with the button below. ') }}
            </p>
            @endif
        </div>
    </form>

    @if (session('token'))
    <div class="mt-6 space-y-6">
        <input id="key" type="hidden" value="{{ session('token') }}"></input>
        <div class="flex items-center gap-4">
            <x-secondary-button onclick="copyKey()">{{ __('Copy Key') }}</x-secondary-button>
            <p
                id="copiedMessageKey"
                x-data="{ show: false }"
                x-show="false"
                x-transition
                class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                {{ __('Copied. Only paste the key to a save place.') }}
            </p>
        </div>
        <script>
            function copyKey() {
                const input = document.getElementById("key");
                input.removeAttribute("type");
                input.select();
                document.execCommand('copy');
                input.setAttribute("type", "hidden");

                const copiedMessage = document.getElementById("copiedMessageKey");
                copiedMessage.setAttribute("x-show", "show");
                copiedMessage.setAttribute("x-data", "{ show: true }");
                setTimeout(() => {
                    copiedMessage.setAttribute("x-show", "false");
                    copiedMessage.setAttribute("x-data", "{ show: false }");
                }, 5000);
            }
        </script>
    </div>
    @endif
</section>
