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
                        :class="activeItem === 'dashboard' || (activeItem === 'ngos.show' && Auth::user()->ngo && Auth::user()->ngo->id == Route::current()->parameter('ngo')) ? 'bg-gray-700 text-white' : ''"
                        class="flex items-center p-2 text-[15px] hover:bg-gray-700 rounded">
                        <i class="fas fa-home mr-3"></i>
                        <span>Dashboard</span>
                    </a>
                </li>

                @php
                $user = Auth::user();
                if (!$user) {
                // If user is not authenticated, redirect to login
                header('Location: ' . route('login'));
                exit;
                }
                $userId = $user->id;

                // Force reload the NGO relationship to ensure fresh data
                if ($user) {
                $user->load('ngo');
                }

                // Check for admin or authority role
                $hasAdminOrAuthorityRole = DB::table('model_has_roles')
                ->join('roles', 'roles.id', '=', 'model_has_roles.role_id')
                ->where('model_has_roles.model_id', $userId)
                ->whereIn('roles.name', ['admin', 'authority'])
                ->exists();

                // Check for NGO role
                $hasNgoRole = DB::table('model_has_roles')
                ->join('roles', 'roles.id', '=', 'model_has_roles.role_id')
                ->where('model_has_roles.model_id', $userId)
                ->where('roles.name', 'ngo')
                ->exists();

                // Get first role name
                $roleName = DB::table('model_has_roles')
                ->join('roles', 'roles.id', '=', 'model_has_roles.role_id')
                ->where('model_has_roles.model_id', $userId)
                ->value('roles.name');

                // Get count of pending NGOs for authority role
                $pendingNgosCount = 0;
                if ($hasAdminOrAuthorityRole) {
                $pendingNgosCount = \App\Models\Ngo::where('status', 'pending')->count();
                }
                @endphp

                @if($hasAdminOrAuthorityRole)
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
                            <a href="{{ route('ngos.pending') }}" @click="activeItem = 'ngos.pending'"
                                :class="activeItem === 'ngos.pending' ? 'bg-gray-700 text-white' : ''"
                                class="p-2 hover:bg-gray-700 rounded flex items-center gap-3">
                                <i class="fa fa-angle-right" aria-hidden="true"></i>
                                <span>Pending NGOs</span>
                                <span
                                    class="ml-auto bg-red-500 text-white text-xs px-2 py-1 rounded-full">{{ $pendingNgosCount }}</span>
                            </a>
                        </li>

                    </ul>
                </li>
                @endif

                <!-- Projects -->
                @if($hasAdminOrAuthorityRole)
                <li>
                    <a href="{{ route('projects.index') }}" @click="activeItem = 'projects.index'"
                        :class="activeItem === 'projects.index' ? 'bg-gray-700 text-white' : ''"
                        class="flex text-[15px] items-center p-2  hover:bg-gray-700 rounded">
                        <i class="fas fa-chalkboard-teacher mr-3"></i>
                        <span>Projects</span>
                    </a>
                </li>
                @endif

                @if($hasNgoRole && $user->ngo && $user->ngo->status === 'approved')
                <li x-data="{ open: false }" class="opcion-con-desplegable">
                    <div @click="open = !open" @click="activeItem = 'projects.donner'"
                        :class="activeItem === 'projects.donner' ? 'bg-gray-700 text-white' : ''"
                        class="flex items-center justify-between p-2 hover:bg-gray-700 rounded cursor-pointer">
                        <div class="flex items-center">
                            <i class="fas fa-chalkboard-teacher mr-3"></i>
                            <span>Projects</span>
                        </div>
                        <i class="fas fa-chevron-down text-xs transition-transform duration-300"
                            :class="{ 'rotate-180': open }"></i>
                    </div>
                    <ul x-show="open" x-transition class="desplegable ml-8 mt-2 space-y-1">
                        <li>
                            <a href="{{ route('projects.donner') }}" @click="activeItem = 'projects.donner'"
                                :class="activeItem === 'projects.donner' ? 'bg-gray-700 text-white' : ''"
                                class="p-2 hover:bg-gray-700 rounded flex items-center gap-3">
                                <i class="fa fa-angle-right" aria-hidden="true"></i>
                                <span>As a Donner</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('projects.runner') }}" @click="activeItem = 'projects.runner'"
                                :class="activeItem === 'projects.runner' ? 'bg-gray-700 text-white' : ''"
                                class="p-2 hover:bg-gray-700 rounded flex items-center gap-3">
                                <i class="fa fa-angle-right" aria-hidden="true"></i>
                                <span>As a Runner</span>
                            </a>
                        </li>
                    </ul>
                </li>
                @elseif($hasNgoRole)
                <!-- For NGO users without approval, show Projects link that redirects to dashboard with message -->
                <li>
                    <a href="{{ route('dashboard') }}"
                        onclick="event.preventDefault(); alert('Your NGO needs approval before you can access projects.');"
                        class="flex items-center p-2 hover:bg-gray-700 rounded">
                        <i class="fas fa-chalkboard-teacher mr-3"></i>
                        <span>Projects</span>
                        <span class="ml-2 bg-yellow-500 text-xs text-white px-2 py-0.5 rounded-full">Pending</span>
                    </a>
                </li>
                @endif

                <!-- Students -->
                @if($hasNgoRole && $user->ngo && $user->ngo->status === 'approved')
                <li>
                    <a href="{{ route('students.index') }}" class="flex items-center p-2 hover:bg-gray-700 rounded">
                        <i class="fas fa-user-graduate mr-3"></i>
                        <span>Students</span>
                    </a>
                </li>
                @endif

                <!-- Get Approval - Show only for users without NGO or with unapproved NGO, not for authority users -->
                @if(!$hasAdminOrAuthorityRole && (($hasNgoRole && $user->ngo && $user->ngo->status !== 'approved') ||
                !$hasNgoRole))
                <li>
                    <a href="{{ route('ngos.create') }}" @click="activeItem = 'ngos.create'"
                        :class="activeItem === 'ngos.create' ? 'bg-gray-700 text-white' : ''"
                        class="flex items-center p-2 hover:bg-gray-700 rounded">
                        <i class="fas fa-user-check mr-3"></i>
                        <span>Get Approval</span>
                    </a>
                </li>
                @endif

            </ul>
        </nav>
        <!-- Settings Dropdown -->
        <div class="flex sm:items-center sm:ms-2">
            <x-dropdown align="top" width="48">
                <x-slot name="trigger">
                    <button
                        class="inline-flex items-center gap-4 text-base leading-4 font-medium rounded-md text-white transition ease-in-out duration-150">
                        <!-- Profile Image or Default Icon -->
                        @if($hasNgoRole && Auth::user()->ngo && Auth::user()->ngo->logo)
                        @php
                        $logoPath = Auth::user()->ngo->logo;
                        $fullLogoUrl = asset('storage/' . $logoPath) . '?v=' . time();
                        // Check if file exists
                        $physicalPath = public_path('storage/' . $logoPath);
                        $fileExists = file_exists($physicalPath);
                        @endphp
                        <img class="w-8 h-8 rounded-full object-cover" src="{{ $fullLogoUrl }}"
                            alt="{{ Auth::user()->name }}" />
                        @elseif(Auth::user()->profile_photo_path)
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
                            @if($roleName)
                            <span class="text-xs text-gray-300">{{ ucfirst($roleName) }}</span>
                            @endif
                        </div>
                    </button>
                </x-slot>

                <x-slot name="content">
                    @if($hasNgoRole && $user && $user->ngo)
                    <x-dropdown-link :href="route('ngos.edit', $user->ngo->id)">
                        {{ __('Profile') }}
                    </x-dropdown-link>
                    <x-dropdown-link :href="route('profile.edit')">
                        {{ __('Update Password') }}
                    </x-dropdown-link>
                    @else
                    <x-dropdown-link :href="route('profile.edit')">
                        {{ __('Profile') }}
                    </x-dropdown-link>
                    @endif

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