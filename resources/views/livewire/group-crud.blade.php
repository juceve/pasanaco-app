<div class="max-w-9xl mx-auto p-6 ">
    <div class="flex items-center justify-between p-1 mb-2">
        <h1 class="text-2xl font-bold text-gray-900 dark:text-gray-100">
            Grupos
        </h1>
    </div>
    <div class="p-6 bg-white rounded-lg shadow-md dark:bg-gray-800 dark:text-gray-200">

        {{-- Títulos y botón Nuevo --}}
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-4">
            <div>
                <h5 class="title-h5 mb-0 text-sky-700 dark:text-gray-400">Gestión de grupos, cronogramas y participantes
                </h5>
            </div>
            <button wire:click="create"
                class="mt-3 sm:mt-0 inline-flex items-center justify-center w-full sm:w-auto px-4 py-2 bg-sky-600 hover:bg-sky-700 text-white rounded-md text-sm font-semibold transition text-center dark:bg-sky-700 dark:hover:bg-sky-800"
                aria-label="Registrar nuevo participante">
                <i class="fas fa-plus mr-1"></i>
                Nuevo
            </button>
        </div>

        {{-- Buscador y selector de filas --}}
        <div class="mb-4 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2 w-full">
            <div class="relative w-full sm:w-1/2">
                <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400 dark:text-gray-500">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <circle cx="11" cy="11" r="8" />
                        <line x1="21" y1="21" x2="16.65" y2="16.65" />
                    </svg>
                </span>
                <input type="search" wire:model.live.debounce.500ms="search"
                    placeholder="Buscar grupo por nombre o estado..."
                    class="pl-10 pr-3 py-2 border border-gray-300 rounded-md text-sm focus:outline-none focus:ring-2 focus:ring-sky-500 w-full placeholder-gray-400 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-sky-500">
            </div>
            <div class="flex items-center gap-1">
                <label for="perPage" class="text-sm text-gray-700 dark:text-gray-300 whitespace-nowrap">Filas:</label>
                <select id="perPage" wire:model="perPage"
                    class="border-gray-300 rounded-md text-sm focus:ring-sky-500 focus:border-sky-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:focus:ring-sky-500">

                    <option value="5">5</option>
                    <option value="10">10</option>
                    <option value="25">25</option>
                    <option value="50">50</option>
                </select>
            </div>
        </div>

        {{-- Tabla de grupos --}}
        <div class="overflow-x-auto rounded-lg shadow ring-1 ring-black ring-opacity-5 dark:ring-gray-700">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                <thead class="bg-gray-50 dark:bg-gray-700">
                    <tr>
                        <th scope="col"
                            class="px-6 py-4 text-left text-sm font-semibold text-gray-900 dark:text-gray-300 uppercase tracking-wider cursor-pointer select-none"
                            wire:click="sortBy('id')">
                            ID
                            @if ($sortField === 'id')
                                <span>
                                    @if ($sortDirection === 'asc')
                                        &#9650;
                                    @else
                                        &#9660;
                                    @endif
                                </span>
                            @endif
                        </th>
                        <th wire:click="sortBy('name')"
                            class="px-6 py-4 text-left text-sm font-semibold text-gray-900 dark:text-gray-300 uppercase tracking-wider cursor-pointer select-none">
                            Nombre
                            @if ($sortField === 'name')
                                <span>
                                    @if ($sortDirection === 'asc')
                                        &#9650;
                                    @else
                                        &#9660;
                                    @endif
                                </span>
                            @endif
                        </th>
                        <th wire:click="sortBy('start_date')"
                            class="px-6 py-4 text-left text-sm font-semibold text-gray-900 dark:text-gray-300 uppercase tracking-wider cursor-pointer select-none">
                            Inicio
                            @if ($sortField === 'start_date')
                                <span>
                                    @if ($sortDirection === 'asc')
                                        &#9650;
                                    @else
                                        &#9660;
                                    @endif
                                </span>
                            @endif
                        </th>
                        <th wire:click="sortBy('frequency')"
                            class="px-6 py-4 text-left text-sm font-semibold text-gray-900 dark:text-gray-300 uppercase tracking-wider cursor-pointer select-none">
                            Frecuencia
                            @if ($sortField === 'frequency')
                                <span>
                                    @if ($sortDirection === 'asc')
                                        &#9650;
                                    @else
                                        &#9660;
                                    @endif
                                </span>
                            @endif
                        </th>
                        <th
                            class="px-6 py-4 text-left text-sm font-semibold text-gray-900 dark:text-gray-300 uppercase tracking-wider">
                            Estado
                        </th>
                        <th
                            class="px-6 py-4 text-right text-sm font-semibold text-gray-900 dark:text-gray-300 uppercase tracking-wider">
                        </th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 dark:divide-gray-700 bg-white dark:bg-gray-800">
                    @forelse ($groups as $group)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                            <td class="px-6 py-4 whitespace-nowrap dark:text-gray-300">{{ $group->id }}</td>
                            <td class="px-6 py-4 whitespace-nowrap dark:text-gray-300">{{ $group->name }}</td>
                            <td class="px-6 py-4 whitespace-nowrap dark:text-gray-300">
                                {{ \Carbon\Carbon::parse($group->start_date)->format('d/m/Y') }}</td>
                            <td class="px-6 py-4 whitespace-nowrap capitalize dark:text-gray-300">
                                @if ($group->frequency)                                   
                                        {{ $group->frequency }}
                                @else
                                     <span
                                        class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-semibold bg-gray-200 text-gray-700 dark:bg-gray-600 dark:text-gray-200">
                                        <svg class="w-3 h-3 mr-1 text-gray-400 dark:text-gray-300" fill="currentColor"
                                            viewBox="0 0 20 20">
                                            <circle cx="10" cy="10" r="10" />
                                        </svg>
                                        No definido
                                    </span>
                                @endif</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if ($group->status === 'CREADO')
                                    <span
                                        class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-semibold bg-sky-100 text-sky-800 dark:bg-sky-900 dark:text-sky-200">
                                        <svg class="w-3 h-3 mr-1 text-sky-500 dark:text-sky-400" fill="currentColor"
                                            viewBox="0 0 20 20">
                                            <circle cx="10" cy="10" r="10" />
                                        </svg>
                                        Creado
                                    </span>
                                @endif
                                @if ($group->status === 'EN PROGRESO')
                                    <span
                                        class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-semibold bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">
                                        <svg class="w-3 h-3 mr-1 text-green-500 dark:text-green-400" fill="currentColor"
                                            viewBox="0 0 20 20">
                                            <circle cx="10" cy="10" r="10" />
                                        </svg>
                                        En proceso
                                    </span>
                                @endif
                                @if ($group->status === 'COMPLETADO')
                                    <span
                                        class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-semibold bg-gray-200 text-gray-700 dark:bg-gray-600 dark:text-gray-200">
                                        <svg class="w-3 h-3 mr-1 text-gray-400 dark:text-gray-300" fill="currentColor"
                                            viewBox="0 0 20 20">
                                            <circle cx="10" cy="10" r="10" />
                                        </svg>
                                        Completado
                                    </span>
                                @endif
                                @if ($group->status === 'ANULADO')
                                    <span
                                        class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-semibold bg-gray-200 text-gray-700 dark:bg-gray-600 dark:text-gray-200">
                                        <svg class="w-3 h-3 mr-1 text-red-400 dark:text-red-300" fill="currentColor"
                                            viewBox="0 0 20 20">
                                            <circle cx="10" cy="10" r="10" />
                                        </svg>
                                        Anulado
                                    </span>
                                @endif
                            </td>
                            <td align="right" class="px-6 py-4 whitespace-nowrap">
                                <div x-data="{
                                    open: false,
                                    menuStyle: '',
                                    toggleDropdown($el) {
                                        this.open = !this.open;
                                        if (this.open) {
                                            this.$nextTick(() => {
                                                const rect = $el.getBoundingClientRect();
                                                const menuHeight = 180; // px
                                                let top = rect.bottom;
                                                let left = rect.right - 176; // ancho del menú (w-44 = 176px)
                                                // Si no hay espacio abajo, mostrar arriba
                                                if (window.innerHeight - rect.bottom < menuHeight) {
                                                    top = rect.top - menuHeight;
                                                }
                                                this.menuStyle = `top:${top}px;left:${left}px;min-width:176px;`;
                                            });
                                        }
                                    }
                                }" class="relative inline-block text-left">
                                    <button @click="toggleDropdown($el)"
                                        class="cursor-pointer text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-1.5 text-center inline-flex items-center dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800"
                                        aria-haspopup="true" :aria-expanded="open">
                                        Opciones
                                        <i class="fas fa-chevron-down ml-2"></i>
                                    </button>
                                    <div x-show="open" @click.away="open = false" x-transition :style="menuStyle"
                                        class="fixed z-50 origin-top-right rounded-md shadow-lg bg-white dark:bg-gray-700 ring-1 ring-black ring-opacity-5">
                                        <div class="py-1">
                                            <a href="javascript:void(0)" wire:click="edit({{ $group->id }})"
                                                @click="open = false"
                                                class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-600">
                                                <i class="fas fa-edit mr-1"></i> Editar
                                            </a>
                                            <a href="{{ route('groups.settings', $group->id) }}" @click="open = false"
                                                class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-600">
                                                <i class="fas fa-sliders-h mr-1"></i> Configuraciones
                                            </a>
                                            <a href="javascript:void(0)"
                                                onclick="confirmarEliminacion({{ $group->id }}, 'deleteGroup')"
                                                @click="open = false"
                                                class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-600">
                                                <i class="fas fa-trash mr-1"></i> Eliminar
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                {{-- FIN OPCIONES --}}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-10 text-gray-400 dark:text-gray-500 italic">No
                                hay
                                grupos registrados.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Paginación alineada a la derecha --}}
        <div class="flex justify-end mt-4">
            {{ $groups->links() }}
        </div>

        @if ($showModal)
            <div x-data="{ show: @entangle('showModal') }" x-show="show" x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100"
                x-transition:leave-end="opacity-0"
                class="fixed inset-0 flex items-center justify-center z-50 bg-black bg-opacity-40 dark:bg-opacity-60"
                style="display: none;">
                <div x-show="show" x-transition:enter="transition ease-out duration-300 transform"
                    x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
                    x-transition:leave="transition ease-in duration-200 transform"
                    x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95"
                    class="bg-white rounded-lg shadow-lg w-full max-w-md p-6 relative dark:bg-gray-800">
                    <button wire:click="$set('showModal', false)"
                        class="absolute top-2 right-2 text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 text-2xl leading-none">
                        &times;
                    </button>
                    <h4 class="text-lg font-semibold mb-4 text-sky-700 dark:text-sky-400">
                        {{ $isEditing ? 'Editar Grupo' : 'Registrar nuevo grupo' }}
                    </h4>
                    <form wire:submit.prevent="{{ $isEditing ? 'update' : 'store' }}">
                        <div class="mb-3">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nombre</label>
                            <input type="text" wire:model.defer="name" placeholder="Nombre Grupo"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm placeholder-gray-400 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:placeholder-gray-400"
                                required>
                            @error('nombre')
                                <span class="text-red-500 text-xs">{{ $message }}</span>
                            @enderror
                        </div>
                         <div class="mb-3">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Monto
                                cuota</label>
                            <input type="number" step="any" wire:model.defer="amount_per_participant"
                                placeholder="0.00"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm placeholder-gray-400 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:placeholder-gray-400">
                            @error('amount_per_participant')
                                <span class="text-red-500 text-xs">{{ $message }}</span>
                            @enderror
                        </div>
                        {{-- <div class="mb-3">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Fecha
                                Inicio</label>
                            <input type="date" wire:model.defer="start_date"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm placeholder-gray-400 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:placeholder-gray-400"
                                required>
                            @error('start_date')
                                <span class="text-red-500 text-xs">{{ $message }}</span>
                            @enderror
                        </div>
                       
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Frecuencia de
                                cobro</label>
                            <select wire:model.defer="frequency"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                                required>
                                <option value="DIARIO">Diario</option>
                                <option value="SEMANAL">Semanal</option>
                                <option value="MENSUAL">Mensual</option>
                                <option value="PERSONALIZABLE">Personalizado</option>
                            </select>
                            @error('frequency')
                                <span class="text-red-500 text-xs">{{ $message }}</span>
                            @enderror 
                        </div>--}}
                        @if ($isEditing)
                            <div class="mb-4">
                                <label
                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300">Estado</label>
                                <select wire:model.defer="status"
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                                    required>
                                    <option value="CREADO">Creado</option>
                                    <option value="EN PROGRESO">En progreso</option>
                                    <option value="COMPLETADO">Completado</option>
                                    <option value="ANULADO">Anulado</option>
                                </select>
                                @error('status')
                                    <span class="text-red-500 text-xs">{{ $message }}</span>
                                @enderror
                            </div>
                        @endif
                        <div class="flex justify-end">
                            <button type="button" wire:click="$set('showModal', false)"
                                class="mr-2 px-4 py-2 bg-gray-200 rounded-md dark:bg-gray-600 dark:text-gray-200">Cancelar</button>
                            <button type="submit"
                                class="px-4 py-2 bg-sky-600 text-white rounded-md hover:bg-sky-700 dark:bg-sky-700 dark:hover:bg-sky-800">
                                {{ $isEditing ? 'Actualizar' : 'Guardar' }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        @endif
    </div>
</div>
