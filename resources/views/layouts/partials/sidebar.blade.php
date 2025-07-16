 <aside id="logo-sidebar" :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
     class="fixed top-0 left-0 z-40 w-64 h-screen pt-20 transition-transform duration-300 bg-white border-r border-gray-200 dark:bg-gray-800 dark:border-gray-700"
     aria-label="Sidebar">


     <div class="h-full px-3 pb-4 overflow-y-auto bg-white dark:bg-gray-800">
         <ul class="space-y-2 font-medium">
             @php
                 $links = config('admin.links');
             @endphp
             @foreach ($links as $link)
                 @php
                     // Validar permiso si está declarado
                     $canView = true;
                     if (isset($link['can'])) {
                         $canView = auth()->user()->can($link['can']);
                     }
                     // En caso de submenu, validar permisos de hijos
                     if (isset($link['submenu'])) {
                         // Verificar si al menos un hijo tiene permiso
                         $submenuHasAccess = false;
                         foreach ($link['submenu'] as $sub) {
                             if (!isset($sub['can']) || auth()->user()->can($sub['can'])) {
                                 $submenuHasAccess = true;
                                 break;
                             }
                         }
                         $canView = $canView && $submenuHasAccess;
                     }
                 @endphp

                 @if ($canView)
                     <li>
                         @isset($link['header'])
                             <div class="px-3 py-2 text-xs font-semibold text-gray-500 uppercase dark:text-gray-400">
                                 {{ $link['header'] }}
                             </div>
                         @else
                             @isset($link['submenu'])
                                 @php
                                     // Detectar si algún sublink está activo
                                     $isActiveSubmenu = collect($link['submenu'])->contains(function ($sub) {
                                         if (!isset($sub['can']) || auth()->user()->can($sub['can'])) {
                                             if (isset($sub['route'])) {
                                                 return request()->routeIs($sub['route']);
                                             }
                                             if (isset($sub['url'])) {
                                                 return url()->current() === url($sub['url']);
                                             }
                                         }
                                         return false;
                                     });
                                 @endphp

                             <li x-data="{ open: {{ $isActiveSubmenu ? 'true' : 'false' }} }">
                                 <button @click="open = !open"
                                     class="flex justify-between items-center w-full p-2 text-base text-gray-900 transition duration-75 rounded-lg group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700"
                                     aria-controls="dropdown-example" :aria-expanded="open.toString()">

                                     <!-- Ícono izquierdo + texto agrupados -->
                                     <div class="flex items-center gap-2">
                                         <span class="w-5 h-5 inline-flex justify-center items-center">
                                             <i class="{{ $link['icon'] }}"></i>
                                         </span>
                                         <span>{{ $link['name'] }}</span>
                                     </div>

                                     <!-- Ícono derecho que cambia con estado -->
                                     <i class="fas transition-transform duration-300"
                                         :class="open ? 'fa-chevron-up' : 'fa-chevron-down'" aria-hidden="true"></i>

                                 </button>

                                 <ul x-show="open" x-transition id="dropdown-example" class="py-2 space-y-1 ps-6"
                                     style="display: none;">
                                     @foreach ($link['submenu'] as $sublink)
                                         @php
                                             $canViewSub =
                                                 !isset($sublink['can']) || auth()->user()->can($sublink['can']);
                                             if (!$canViewSub) {
                                                 continue;
                                             }

                                             $isActiveLink = false;
                                             if (isset($sublink['route'])) {
                                                 $isActiveLink = request()->routeIs($sublink['route']);
                                             } elseif (isset($sublink['url'])) {
                                                 $isActiveLink = url()->current() === url($sublink['url']);
                                             }
                                         @endphp
                                         <li>
                                             <a href="{{ isset($sublink['route']) ? route($sublink['route']) : $sublink['url'] }}"
                                                 class="flex items-center p-2 text-sm transition duration-75 rounded-lg hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700
                                                {{ $isActiveLink ? 'bg-gray-100 dark:bg-gray-700 font-semibold' : 'text-gray-900' }}">
                                                 <span class="w-4 h-4 me-2 inline-flex justify-center items-center">
                                                     <i class="{{ $sublink['icon'] }}"></i>
                                                 </span>
                                                 <span>{{ $sublink['name'] }}</span>
                                             </a>
                                         </li>
                                     @endforeach
                                 </ul>
                             </li>
                         @else
                             @php
                                 $isActiveLink = false;
                                 if (isset($link['route'])) {
                                     $isActiveLink = request()->routeIs($link['route']);
                                 } elseif (isset($link['url'])) {
                                     $isActiveLink = url()->current() === url($link['url']);
                                 }
                             @endphp
                             <a href="{{ isset($link['route']) ? route($link['route']) : $link['url'] }}"
                                 class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group
                                {{ $isActiveLink ? 'bg-gray-100 dark:bg-gray-700 font-semibold' : '' }}">
                                 <span class="w-h h-5 inline-flex justify-center item-center">
                                     <i class="{{ $link['icon'] }}"></i>
                                 </span>
                                 <span class="ms-3">{{ $link['name'] }}</span>
                             </a>
                         @endisset
                     @endisset
                     </li>
                 @endif
             @endforeach
         </ul>
     </div>
 </aside>
