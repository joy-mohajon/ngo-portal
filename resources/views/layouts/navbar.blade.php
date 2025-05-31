<nav class="bg-blue-500 p-4 flex items-center justify-between fixed top-0 right-0 md:left-64 left-0 z-10 md:hidden">
    <div class="flex items-center gap-4">
        <button @click="isOpenSidebar = true" class="md:hidden  text-white">
            <i class="fas fa-bars"></i>
        </button>
        <h1 class="text-white text-xl font-semibold">
            NGO Portal
        </h1>
    </div>

    <!-- Settings Dropdown -->
    <div class="flex sm:items-center sm:ms-6">
        <x-dropdown align="top" width="48">
            <x-slot name="trigger">
                <button
                    class="inline-flex items-center gap-4 text-base leading-4 font-medium rounded-md text-white transition ease-in-out duration-150">
                    <div class="flex flex-col items-end gap-1">
                        <span>{{ Auth::user()->name }}</span>
                        @php 
                            $roleName = DB::table('model_has_roles')
                                ->join('roles', 'roles.id', '=', 'model_has_roles.role_id')
                                ->where('model_has_roles.model_id', Auth::id())
                                ->value('roles.name');
                        @endphp
                        @if($roleName)
                            <span class="text-xs text-gray-300">{{ ucfirst($roleName) }}</span>
                        @endif
                    </div>

                    <!-- Profile Image or Default Icon -->
                    @if(Auth::user()->profile_photo_path)
                        <img class="w-8 h-8 rounded-full object-cover"
                            src="{{ asset('storage/' . Auth::user()->profile_photo_path) }}"
                            alt="{{ Auth::user()->name }}" />
                    @else
                        <div class="w-8 h-8 rounded-full bg-gray-500 flex items-center justify-center">
                            <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 12c2.7 0 4.8-2.1 4.8-4.8S14.7 2.4 12 2.4 7.2 4.5 7.2 7.2 9.3 12 12 12zm0 2.4c-3.2 0-9.6 1.6-9.6 4.8V21h19.2v-1.8c0-3.2-6.4-4.8-9.6-4.8z"/>
                            </svg>
                        </div>
                    @endif
                </button>
            </x-slot>

            <x-slot name="content">
                <x-dropdown-link :href="route('profile.edit')">
                    {{ __('Profile') }}
                </x-dropdown-link>

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    
                    <x-dropdown-link :href="route('logout')" onclick="event.preventDefault();
                                                this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-dropdown-link>
                </form>
            </x-slot>
        </x-dropdown>
    </div>

</nav>