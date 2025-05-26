<!-- Fixed Sidebar -->
<aside
    class="bg-gray-800 text-white w-64 fixed h-full md:transform-none transform -translate-x-full transition-transform duration-300 ease-in-out z-20"
    :class="{'translate-x-0': isOpenSidebar}">
    <div class="px-4 pt-8 pb-6 h-full flex flex-col">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-semibold">NGO Portal</h1>
            <button @click="isOpenSidebar = false" class="text-white md:hidden">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <nav class="flex-1 overflow-y-auto" x-data="{ activeItem: '{{ Route::currentRouteName() }}' }">
            <ul class="space-y-2">
                <!-- Dashboard -->
                <li>
                    <a href="{{ route('dashboard') }}" @click="activeItem = 'dashboard'"
                        :class="activeItem === 'dashboard' ? 'bg-gray-700 text-white' : ''"
                        class="flex items-center p-2 text-[15px] hover:bg-gray-700 rounded">
                        <i class="fas fa-home mr-3"></i>
                        <span>Dashboard</span>
                    </a>
                </li>

                <!-- NGO Management - For authority and admin roles only -->
                <!-- @hasrole(['admin', 'authority'])
                <li>
                    <a href="{{ route('ngos.index') }}" @click="activeItem = 'ngos.index'"
                        :class="activeItem === 'ngos.index' ? 'bg-gray-700 text-white' : ''"
                        class="p-2 text-[15px] hover:bg-gray-700 rounded flex items-center gap-3">
                        <i class="fas fa-hands-helping"></i>
                        <span>NGOs</span>
                    </a>
                </li>
                @endhasrole -->


                @hasrole(['admin', 'authority'])
                <li x-data="{ open: false }" class="opcion-con-desplegable">
                    <div @click="open = !open" @click="activeItem = 'ngos.index'"
                        :class="activeItem === 'ngos.index' ? 'bg-gray-700 text-white' : ''"
                        class="flex items-center justify-between p-2 hover:bg-gray-700 rounded cursor-pointer">
                        <div class="flex items-center">
                            <i class="fas fa-hands-helping mr-3"></i>
                            <span>NGOs</span>
                        </div>
                        <i class="fas fa-chevron-down text-xs transition-transform duration-300"
                            :class="{ 'rotate-180': open }"></i>
                    </div>
                    <ul x-show="open" x-transition class="desplegable ml-8 mt-2 space-y-1">
                        <li>
                            <a href="{{ route('ngos.index') }}" @click="activeItem = 'ngos.index'"
                                :class="activeItem === 'ngos.index' ? 'bg-gray-700 text-white' : ''"
                                class="p-2 hover:bg-gray-700 rounded flex items-center gap-3">
                                <i class="fa fa-angle-right" aria-hidden="true"></i>
                                <span>All NGOs</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('ngos.pending') }}"
                                class="p-2 hover:bg-gray-700 rounded flex items-center gap-3">
                                <i class="fa fa-angle-right" aria-hidden="true"></i>
                                <span>Pending NGOs</span>
                                <span class="ml-auto bg-red-500 text-white text-xs px-2 py-1 rounded-full">5</span>
                            </a>
                        </li>

                    </ul>
                </li>
                @endhasrole

                <!-- Projects -->
                <li>
                    <a href="{{ route('projects.index') }}" @click="activeItem = 'projects.index'"
                        :class="activeItem === 'projects.index' ? 'bg-gray-700 text-white' : ''"
                        class="flex text-[15px] items-center p-2  hover:bg-gray-700 rounded">
                        <i class="fas fa-chalkboard-teacher mr-3"></i>
                        <span>Projects</span>
                    </a>
                </li>

                <!-- Projects Overview - For authority and admin roles only -->
                <!-- @hasrole(['admin', 'authority']) -->
                <li>
                    <a href="{{ route('students.index') }}" class="flex items-center p-2 hover:bg-gray-700 rounded">
                        <i class="fas fa-user-graduate mr-3"></i>
                        <span>Students</span>
                    </a>
                </li>
                <!-- @endhasrole -->
                @hasrole(['admin', 'ngo'])
                <li>
                    <a href="{{ route('students.index') }}" class="flex items-center p-2 hover:bg-gray-700 rounded">
                        <i class="fas fa-user-graduate mr-3"></i>
                        <span>Students</span>
                    </a>
                </li>
                @endhasrole

                @hasrole(['admin', 'ngo'])
                @if(auth()->user()->hasRole('ngo') && auth()->user()->ngo->status !== 'approved')
                <li>
                    <a href="{{ route('ngos.create') }}" class="flex items-center p-2 hover:bg-gray-700 rounded">
                        <i class="fas fa-user-check mr-3"></i>
                        <span>Get Approval</span>
                    </a>
                </li>
                @endif
                @endhasrole

                <!-- <script>
                function goToProjects() {
                    // console.log('Navigating to projects page directly');
                    window.location.href = '/direct-projects';
                    return false;
                }
                </script> -->

            </ul>
        </nav>
        <!-- Settings Dropdown -->
        <div class="flex sm:items-center sm:ms-2">
            <x-dropdown align="top" width="48">
                <x-slot name="trigger">
                    <button
                        class="inline-flex items-center gap-4 text-base leading-4 font-medium rounded-md text-white transition ease-in-out duration-150">
                        <!-- Profile Image or Default Icon -->
                        @if(Auth::user()->profile_photo_path)
                        <img class="w-8 h-8 rounded-full object-cover"
                            src="{{ asset('storage/' . Auth::user()->profile_photo_path) }}"
                            alt="{{ Auth::user()->name }}" />
                        @else
                        <div class="w-8 h-8 rounded-full bg-gray-500 flex items-center justify-center">
                            <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M12 12c2.7 0 4.8-2.1 4.8-4.8S14.7 2.4 12 2.4 7.2 4.5 7.2 7.2 9.3 12 12 12zm0 2.4c-3.2 0-9.6 1.6-9.6 4.8V21h19.2v-1.8c0-3.2-6.4-4.8-9.6-4.8z" />
                            </svg>
                        </div>
                        @endif

                        <div class="flex flex-col items-start gap-1 ttext-[15px]">
                            <span>{{ Auth::user()->name }}</span>
                            @php $role = Auth::user()->getRoleNames()->first(); @endphp
                            @if($role)
                            <span class="text-xs text-gray-300">{{ ucfirst($role) }}</span>
                            @endif
                        </div>
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
    </div>
</aside>