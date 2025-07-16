<div class="max-w-7xl mx-auto p-6 bg-white rounded-lg shadow-md">

    {{-- Títulos y botón Nuevo alineados --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-4">
        <div>
            <h3 class="title-h3 mb-1 text-sky-800">Participantes</h3>
            <h5 class="title-h5 mb-0 text-gray-600">Listado completo de participantes registrados</h5>
        </div>
        <button wire:click="create"
            class="mt-3 sm:mt-0 inline-flex items-center justify-center w-full sm:w-auto px-4 py-2 bg-sky-600 hover:bg-sky-700 text-white rounded-md text-sm font-semibold transition text-center"
            aria-label="Registrar nuevo participante">
            <i class="fas fa-plus mr-1"></i>
            Nuevo
        </button>
    </div>

    {{-- Buscador y selector de filas sobre la tabla --}}
    <div class="mb-4 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2 w-full">
        {{-- Buscador --}}
        <div class="relative w-full sm:w-1/2">
            <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
                <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <circle cx="11" cy="11" r="8" />
                    <line x1="21" y1="21" x2="16.65" y2="16.65" />
                </svg>
            </span>
            <input type="search" wire:model.live.debounce.500ms="search"
                placeholder="Buscar por nombre, celular o email..."
                class="pl-10 pr-3 py-2 border border-gray-300 rounded-md text-sm focus:outline-none focus:ring-2 focus:ring-sky-500 w-full placeholder-gray-400">
        </div>
        {{-- Select de filas --}}
        <div class="flex items-center gap-1">
            <label for="perPage" class="text-sm text-gray-700 whitespace-nowrap">Filas:</label>
            <select id="perPage" wire:model.live="perPage"
                class="border-gray-300 rounded-md text-sm focus:ring-sky-500 focus:border-sky-500">
                <option value="5">5</option>
                <option value="10">10</option>
                <option value="25">25</option>
                <option value="50">50</option>
            </select>
        </div>
    </div>

    <div class="overflow-x-auto rounded-lg shadow ring-1 ring-black ring-opacity-5">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr role="row">
                    
                    <th scope="col"
                        class="px-6 py-4 text-left text-sm font-semibold text-gray-900 uppercase tracking-wider cursor-pointer select-none"
                        wire:click="sortBy('id')">
                        id
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
                    <th scope="col"
                        class="px-6 py-4 text-left text-sm font-semibold text-gray-900 uppercase tracking-wider hidden md:table-cell cursor-pointer select-none"
                        wire:click="sortBy('celular')">
                        Celular
                        @if ($sortField === 'celular')
                            <span>
                                @if ($sortDirection === 'asc')
                                    &#9650;
                                @else
                                    &#9660;
                                @endif
                            </span>
                        @endif
                    </th>
                    <th scope="col"
                        class="px-6 py-4 text-left text-sm font-semibold text-gray-900 uppercase tracking-wider hidden md:table-cell cursor-pointer select-none"
                        wire:click="sortBy('email')">
                        Email
                        @if ($sortField === 'email')
                            <span>
                                @if ($sortDirection === 'asc')
                                    &#9650;
                                @else
                                    &#9660;
                                @endif
                            </span>
                        @endif
                    </th>
                    <th scope="col"
                        class="px-6 py-4 text-left text-sm font-semibold text-gray-900 uppercase tracking-wider cursor-pointer select-none"
                        wire:click="sortBy('estado')">
                        Estado
                        @if ($sortField === 'estado')
                            <span>
                                @if ($sortDirection === 'asc')
                                    &#9650;
                                @else
                                    &#9660;
                                @endif
                            </span>
                        @endif
                    </th>
                    <th scope="col"
                        class="px-6 py-4 text-right text-sm font-semibold text-gray-900 uppercase tracking-wider"
                        aria-label="Acciones">
                        Acciones
                    </th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse ($participants ?? [] as $participant)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $participant->nombre }}</td>
                        <td class="px-6 py-4 whitespace-nowrap hidden md:table-cell">{{ $participant->celular }}</td>
                        <td class="px-6 py-4 whitespace-nowrap hidden md:table-cell">{{ $participant->email }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if ($participant->estado === 'activo')
                                <span
                                    class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-semibold bg-green-100 text-green-800">
                                    <svg class="w-3 h-3 mr-1 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                        <circle cx="10" cy="10" r="10" />
                                    </svg>
                                    Activo
                                </span>
                            @else
                                <span
                                    class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-semibold bg-red-100 text-red-800">
                                    <svg class="w-3 h-3 mr-1 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                                        <circle cx="10" cy="10" r="10" />
                                    </svg>
                                    Inactivo
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right">
                            <button wire:click="edit({{ $participant->id }})"
                                class="inline-flex items-center px-3 py-1.5 bg-sky-600 hover:bg-sky-700 text-white rounded-md text-sm font-semibold transition mr-2"
                                aria-label="Editar participante {{ $participant->nombre }}">
                                <i class="fas fa-edit mr-1"></i>
                                Editar
                            </button>
                            <button onclick="confirmarEliminacion({{ $participant->id }}, 'deleteParticipant')"
                                class="inline-flex items-center px-3 py-1.5 bg-red-600 hover:bg-red-700 text-white rounded-md text-sm font-semibold transition"
                                aria-label="Eliminar participante {{ $participant->nombre }}">
                                <i class="fas fa-trash mr-1"></i> Eliminar
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center py-10 text-gray-400 italic">No hay participantes
                            registrados.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Paginación alineada a la derecha --}}
    <div class="flex justify-end mt-4">
        {{ $participants->links() }}
    </div>

    {{-- Modal para registrar/editar participante --}}
    @if ($showModal)
        <div x-data="{ show: @entangle('showModal') }" x-show="show" x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
            x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            class="fixed inset-0 flex items-center justify-center z-50 bg-black bg-opacity-40" style="display: none;">
            <div x-show="show" x-transition:enter="transition ease-out duration-300 transform"
                x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
                x-transition:leave="transition ease-in duration-200 transform"
                x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95"
                class="bg-white rounded-lg shadow-lg w-full max-w-md p-6 relative">
                <button wire:click="$set('showModal', false)"
                    class="absolute top-2 right-2 text-gray-400 hover:text-gray-600 text-2xl leading-none">
                    &times;
                </button>
                <h4 class="text-lg font-semibold mb-4 text-sky-700">
                    {{ $isEditing ? 'Editar participante' : 'Registrar nuevo participante' }}
                </h4>
                <form wire:submit.prevent="{{ $isEditing ? 'update' : 'store' }}">
                    <div class="mb-3">
                        <label class="block text-sm font-medium text-gray-700">Nombre</label>
                        <input type="text" wire:model.defer="nombre" placeholder="Ej: Juan Pérez"
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm placeholder-gray-400"
                            required>
                        @error('nombre')
                            <span class="text-red-500 text-xs">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label class="block text-sm font-medium text-gray-700">Celular</label>
                        <input type="text" wire:model.defer="celular" placeholder="Ej: 71234567"
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm placeholder-gray-400"
                            required>
                        @error('celular')
                            <span class="text-red-500 text-xs">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label class="block text-sm font-medium text-gray-700">Email</label>
                        <input type="email" wire:model.defer="email" placeholder="Ej: correo@ejemplo.com"
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm placeholder-gray-400">
                        @error('email')
                            <span class="text-red-500 text-xs">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Estado</label>
                        <select wire:model.defer="estado"
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                            <option value="">Seleccione...</option>
                            <option value="activo">Activo</option>
                            <option value="inactivo">Inactivo</option>
                        </select>
                        @error('estado')
                            <span class="text-red-500 text-xs">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="flex justify-end">
                        <button type="button" wire:click="$set('showModal', false)"
                            class="mr-2 px-4 py-2 bg-gray-200 rounded-md">Cancelar</button>
                        <button type="submit" class="px-4 py-2 bg-sky-600 text-white rounded-md hover:bg-sky-700">
                            {{ $isEditing ? 'Actualizar' : 'Guardar' }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endif


</div>
