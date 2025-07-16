<div>
    <!-- Botón para abrir modal -->
    <button wire:click="openModal" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
        Seleccionar Participantes
    </button>

    <!-- Modal -->
    @if ($showModal)
        <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
            <div class="bg-white rounded-lg w-11/12 md:w-3/4 p-6 max-h-[90vh] overflow-y-auto">
                <h2 class="text-xl font-bold mb-4">Gestionar Participantes</h2>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <!-- Lista de Participantes -->
                    <div>
                        <h3 class="font-semibold mb-2">Participantes Activos</h3>

                        <!-- Buscador -->
                        <div class="relative w-full mb-2">
                            <span class="absolute inset-y-0 left-0 flex items-center pl-2 text-gray-400">
                                <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2"
                                    viewBox="0 0 24 24">
                                    <circle cx="11" cy="11" r="8" />
                                    <line x1="21" y1="21" x2="16.65" y2="16.65" />
                                </svg>
                            </span>
                            <input type="search" wire:model.live.debounce.500ms="search"
                                placeholder="Buscar por nombre..."
                                class="pl-10 pr-3 py-2 border border-gray-300 rounded-md text-sm focus:outline-none focus:ring-2 focus:ring-sky-500 w-full placeholder-gray-400">
                        </div>

                        <ul class="space-y-2 max-h-[50vh] overflow-y-auto pr-2">
                            @php
                                $participants = $this->allParticipants ?? collect();
                            @endphp
                            @forelse ($participants as $participant)
                                @if (!collect($selectedParticipants)->contains('id', $participant->id))
                                    <li>
                                        <button wire:click="selectParticipant({{ $participant->id }})"
                                            class="w-full bg-gray-100 p-2 rounded hover:bg-gray-200 text-left">
                                            {{ $participant->nombre }}
                                            <span class="text-sm text-gray-500">
                                                ({{ $participant->email ?? 'sin email' }})
                                            </span>
                                        </button>
                                    </li>
                                @endif
                            @empty
                                <li class="text-gray-400">Sin resultados.</li>
                            @endforelse
                        </ul>

                    </div>

                    <!-- Lista de Seleccionados -->
                    <div>
                        <h3 class="font-semibold mb-2">Lista de Seleccionados</h3>
                        <ul class="space-y-2">
                            @php
                                $selected = $selectedParticipants ?? [];
                            @endphp

                            @forelse ($selected as $participant)
                                <li class="flex justify-between items-center bg-green-100 p-2 rounded">
                                    <div>
                                        <strong>{{ $participant['nombre'] }}</strong><br>
                                        <span
                                            class="text-sm text-gray-500">{{ $participant['email'] ?? 'sin email' }}</span>
                                    </div>
                                    <button wire:click="removeParticipant({{ $participant['id'] }})"
                                        class="text-red-600 hover:text-red-800">
                                        Quitar
                                    </button>
                                </li>
                            @empty
                                <li class="text-gray-400">Ninguno seleccionado.</li>
                            @endforelse
                        </ul>
                    </div>
                </div>

                <!-- Footer Modal -->
                <div class="mt-6 flex justify-end space-x-2">
                    <button wire:click="closeModal" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">
                        Cerrar
                    </button>
                    <button wire:click="saveParticipants"
                        class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
                        Guardar Selección
                    </button>
                </div>
            </div>
        </div>
    @endif
</div>
