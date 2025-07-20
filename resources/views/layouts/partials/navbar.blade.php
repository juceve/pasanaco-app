    <nav
        class="fixed top-0 z-50 w-full border-b border-blue-500 bg-gradient-to-r from-blue-900 via-sky-700 to-sky-600            
            
            text-white
            transition-colors duration-300">


        <div class="px-3 py-3 lg:px-5 lg:pl-3">
            <div class="flex items-center justify-between">
                <div class="flex items-center justify-start rtl:justify-end">


                    <!-- Logo + título -->
                    <a href="{{route('dashboard')}}" class="flex ms-4">
                        <img src="{{ asset(config('admin.app.logo')) }}" class="h-8 me-3" alt="Logo" />
                        <span class="self-center text-xl font-semibold sm:text-2xl whitespace-nowrap dark:text-white">
                            {{ config('admin.app.name') }}
                        </span>
                    </a>

                    <!-- Botón hamburguesa que aparece siempre -->
                    <button @click="$dispatch('toggle-sidebar')" type="button"
                        class="inline-flex items-center p-2 text-sm text-gray-500 rounded-lg hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-blue-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600">
                        <span class="sr-only">Toggle</span>
                        <i class="fas fa-bars text-lg"></i>
                    </button>
                </div>

                <!-- Usuario -->
                <div class="flex items-center">

                    <div class="flex items-center ms-3">
                        <div>
                            <button type="button"
                                class="flex text-sm bg-gray-800 rounded-full focus:ring-4 focus:ring-gray-300 dark:focus:ring-gray-600"
                                aria-expanded="false" data-dropdown-toggle="dropdown-user">
                                <span class="sr-only">Open user menu</span>
                                <img class="w-8 h-8 rounded-full"
                                    src="@if (Auth::user()->profile_photo_path) {{ Storage::url(Auth::user()->profile_photo_path) }}@else https://ui-avatars.com/api/?name={{ Auth::user()->name }}&color=7F9CF5&background=EBF4FF @endif"
                                    alt="UserPhoto">
                            </button>
                        </div>
                        <div class="z-50 hidden my-4 text-base list-none bg-white divide-y divide-gray-100 rounded-sm shadow-sm dark:bg-gray-700 dark:divide-gray-600"
                            id="dropdown-user">
                            <div class="px-4 py-3">
                                <p class="text-sm text-gray-900 dark:text-white">{{ Auth::user()->name }}</p>
                                <p class="text-sm font-medium text-gray-900 truncate dark:text-gray-300">
                                    {{ Auth::user()->email }}</p>
                            </div>
                            <ul class="py-1">
                                <li>
                                    <a href="{{ route('profile.show') }}"
                                        class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-600 dark:hover:text-white"><i
                                            class="fas fa-sliders-h mr-1.5"></i> Ajustes</a>
                                </li>
                                <li>
                                    <button @click="dark = !dark"
                                        class="w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-600 dark:hover:text-white flex items-center gap-2"
                                        title="Cambiar tema">
                                        <template x-if="!dark">
                                            <i class="fas fa-moon"></i>
                                        </template>
                                        <template x-if="dark">
                                            <i class="fas fa-sun"></i>
                                        </template>
                                        <span>Cambiar tema</span>
                                    </button>
                                </li>
                                <li>
                                    <form action="{{ route('logout') }}" method="POST">
                                        @csrf
                                        <button
                                            class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-600 dark:hover:text-white">
                                            <i class="fas fa-sign-out-alt mr-1"></i> Cerrar sesión
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </nav>
