<div class="p-2 max-w-6xl mx-auto">
    <div class="flex items-center justify-between p-1 mb-2">
        <h1 class="text-2xl font-bold text-gray-900 dark:text-gray-100">
            Configuraciones de Grupo
        </h1>
        <button onclick="history.back()"
            class="bg-sky-600 hover:bg-sky-700 text-white font-semibold px-4 py-1 rounded focus:outline-none focus:ring-2 focus:ring-sky-500 text-sm"
            aria-label="Volver">
            <i class="fas fa-arrow-left mr-1 text-sm"></i> Volver
        </button>
    </div>

    <div class="bg-white dark:bg-gray-900 shadow-lg rounded-xl p-6 text-gray-700 dark:text-gray-300">

        <h2 class="text-lg font-bold mb-6 text-sky-800 dark:text-white">
            Gestionar Participantes - {{ $groupSel->name }}
        </h2>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 text-sm">

            <!-- Lista de Participantes -->
            <div>
                <h3 class="font-semibold mb-3 text-gray-700 dark:text-gray-200">Participantes Activos</h3>

                <!-- Buscador -->
                <div class="relative w-full mb-4">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-2 text-gray-400 dark:text-gray-500">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <circle cx="11" cy="11" r="8" />
                            <line x1="21" y1="21" x2="16.65" y2="16.65" />
                        </svg>
                    </span>
                    <input type="search" wire:model.live.debounce.500ms="search" placeholder="Buscar por nombre..."
                        class="pl-10 pr-3 py-2 border border-gray-300 dark:border-gray-600 dark:bg-gray-800 rounded-md text-sm focus:outline-none focus:ring-2 focus:ring-sky-500 w-full placeholder-gray-400 dark:placeholder-gray-500 text-gray-800 dark:text-gray-200">
                </div>

                <ul class="space-y-2 max-h-[40vh] overflow-y-auto pr-2">
                    @forelse ($this->getAllParticipantsProperty() as $participant)
                        <li>
                            <button wire:click="selectParticipant({{ $participant->id }})"
                                class="w-full bg-gray-100 dark:bg-gray-800 hover:bg-gray-200 dark:hover:bg-gray-700 p-2 rounded text-left text-gray-700 dark:text-gray-200">
                                {{ $participant->nombre }} <br>
                                <small class="text-sm text-gray-500 dark:text-gray-400 text-xs">
                                    ({{ $participant->email ?? 'sin email' }})
                                </small>
                            </button>
                        </li>
                    @empty
                        <li class="text-gray-400 dark:text-gray-500">Sin resultados.</li>
                    @endforelse
                </ul>
            </div>

            <!-- Lista de Seleccionados -->
            <div>
                <h3 class="font-semibold mb-3 text-gray-700 dark:text-gray-200">Lista de Seleccionados</h3>

                <ul class="space-y-2 max-h-[40vh] overflow-y-auto pr-2">
                    @php
                        $selected = $selectedParticipants ?? [];
                    @endphp

                    @forelse ($selected as $participant)
                        <li
                            class="flex justify-between items-center bg-green-100 dark:bg-green-900 p-2 rounded text-gray-700 dark:text-gray-200">
                            <div>
                                <strong>{{ $participant['nombre'] }}</strong><br>
                            </div>
                            <button wire:click="removeParticipant({{ $participant['id'] }})"
                                class="text-red-600 hover:text-red-800 dark:text-red-400 dark:hover:text-red-300">
                                Quitar
                            </button>
                        </li>
                    @empty
                        <li class="text-gray-400 dark:text-gray-500">Ninguno seleccionado.</li>
                    @endforelse
                </ul>
            </div>

        </div>
        <hr>
        <!-- Footer -->
        <div class="mt-6 flex justify-end space-x-2 text-sm">
            <button wire:click='cancelParticipants' class="bg-gray-500 text-white px-4 py-1 rounded hover:bg-gray-600">
                <i class="fas fa-ban mr-1"></i>Cancelar
            </button>

            <button wire:click="saveParticipants" class="bg-green-600 text-white px-4 py-1 rounded hover:bg-green-700">
                Guardar <i class="fas fa-save"></i>
            </button>
        </div>
    </div>




    @if (session()->has('message'))
        <div class="mt-4 text-green-600 font-semibold">
            {{ session('message') }}
        </div>
    @endif

</div>
