<!-- Fixed Sidebar -->
<aside
    class="bg-gray-800 text-white w-64 fixed h-full md:transform-none transform -translate-x-full transition-transform duration-300 ease-in-out z-20"
    :class="{'translate-x-0': isOpenSidebar}">
    <div class="p-4 h-full flex flex-col">
        <div class="flex justify-between items-center mb-6 md:hidden">
            <h1 class="text-xl font-semibold">NGO portal</h1>
            <button @click="isOpenSidebar = false" class="text-white">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <nav class="flex-1 overflow-y-auto">
            <ul class="space-y-2">
                <!-- Dashboard - For all roles -->
                <li>
                    <a href="{{ route('dashboard') }}" class="flex items-center p-2 hover:bg-gray-700 rounded">
                        <i class="fas fa-home mr-3"></i>
                        <span>Dashboard</span>
                    </a>
                </li>

                <!-- NGO Management - For authority and admin roles only -->
                @hasrole(['admin', 'authority'])
                <li x-data="{ open: false }" class="opcion-con-desplegable">
                    <div @click="open = !open"
                        class="flex items-center justify-between p-2 hover:bg-gray-700 rounded cursor-pointer">
                        <div class="flex items-center">
                            <i class="fas fa-hands-helping mr-3"></i>
                            <span>NGO Management</span>
                        </div>
                        <i class="fas fa-chevron-down text-xs transition-transform duration-300"
                            :class="{ 'rotate-180': open }"></i>
                    </div>
                    <ul x-show="open" x-transition class="desplegable ml-8">
                        <li>
                            <a href="#" class="p-2 hover:bg-gray-700 rounded flex items-center gap-3">
                                <i class="fa fa-angle-right" aria-hidden="true"></i>
                                <span>Pending Approvals</span>
                                <span class="ml-auto bg-red-500 text-white text-xs px-2 py-1 rounded-full">5</span>
                            </a>
                        </li>
                        <li>
                            <a href="#" class="p-2 hover:bg-gray-700 rounded flex items-center gap-3">
                                <i class="fa fa-angle-right" aria-hidden="true"></i>
                                <span>Approved NGOs List</span>
                            </a>
                        </li>
                    </ul>
                </li>
                @endhasrole

                <!-- Projects Overview - For authority and admin roles only -->
                @hasrole(['admin', 'authority'])
                <li>
                    <a href="#" class="flex items-center p-2 hover:bg-gray-700 rounded">
                        <i class="fas fa-project-diagram mr-3"></i>
                        <span>Projects Overview</span>
                    </a>
                </li>
                @endhasrole

                <!-- Projects Section -->
                @hasrole(['admin', 'ngo'])
                <li>
                    <a href="{{ route('direct.projects') }}" class="flex items-center p-2 hover:bg-gray-700 rounded">
                        <i class="fas fa-chalkboard-teacher mr-3"></i>
                        <span>Projects</span>
                    </a>
                </li>
                <script>
                function goToProjects() {
                    // console.log('Navigating to projects page directly');
                    window.location.href = '/direct-projects';
                    return false;
                }
                </script>
                @endhasrole
            </ul>
        </nav>
    </div>
</aside>