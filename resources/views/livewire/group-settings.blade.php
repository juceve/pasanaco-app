<div class="p-2 max-w-9xl mx-auto">
    <div class="flex items-center justify-between  mb-2">
        <h1 class="text-2xl font-bold text-gray-900 dark:text-gray-100">
            Configuraciones de Grupo
        </h1>
        <button onclick="history.back()"
            class="bg-sky-600 hover:bg-sky-700 text-white font-semibold px-4 py-2 rounded focus:outline-none focus:ring-2 focus:ring-sky-500 text-sm"
            aria-label="Volver">
            <i class="fas fa-arrow-left mr-1 text-sm"></i> Volver
        </button>
    </div>
    @if (!$asignacionesCompletas)
        {{-- Participantes --}}
        <div class="bg-white dark:bg-gray-900 shadow-lg rounded-xl p-6 text-gray-700 dark:text-gray-300 mb-3">

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
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2"
                                viewBox="0 0 24 24">
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
                                <button wire:click="selectParticipant({{ $participant->id }},1)"
                                    class="w-full bg-gray-100 dark:bg-gray-800 hover:bg-gray-200 dark:hover:bg-gray-700 p-2 rounded text-left text-gray-700 dark:text-gray-200">
                                    {{ $participant->nombre }}
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
                                    <strong>{{ $participant['nombre'] }}</strong>
                                </div>
                                <div class="flex items-center gap-2">
                                    <span class="text-xs text-gray-500 dark:text-gray-400">Cantidad</span>
                                    <input type="number" min="1"
                                        wire:model.lazy="participantCounts.{{ $participant['id'] }}"
                                        class="w-14 px-2 py-1 border rounded text-sm bg-white dark:bg-gray-800 dark:text-gray-200"
                                        title="Cantidad de fechas a asignar" />

                                    <button wire:click="removeParticipant({{ $participant['id'] }})"
                                        class="text-red-600 hover:text-red-800 dark:text-red-400 dark:hover:text-red-300">
                                        Quitar
                                    </button>
                                </div>
                            </li>
                        @empty
                            <li class="text-gray-400 dark:text-gray-500">Ninguno seleccionado.</li>
                        @endforelse
                    </ul>
                </div>

            </div>


        </div>

        {{-- Frecuencia --}}
        <div class="bg-white dark:bg-gray-900 shadow-lg rounded-xl p-6 text-gray-700 dark:text-gray-300 mb-3">

            <h2 class="text-lg font-bold mb-6 text-sky-800 dark:text-white">
                Cuando Cobrar
            </h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 text-md">
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Fecha de Inicio</label>
                    <input type="date" wire:model.live="start_date"
                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                        required>
                    @error('start_date')
                        <span class="text-red-500 text-xs">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 text-md">

                @if ($start_date != '')

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Frecuencia de
                            cobro</label>

                        <select wire:model.live="frequency"
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                            required>
                            <option value="">Seleccione como hacer los cobros</option>
                            <option value="DIARIO">Diario</option>
                            <option value="SEMANAL">Semanal</option>
                            <option value="MENSUAL">Mensual</option>
                            <option value="PERSONALIZABLE">Personalizado</option>
                        </select>
                        @error('frequency')
                            <span class="text-red-500 text-xs">{{ $message }}</span>
                        @enderror
                    </div>
                    @if ($frequency === 'DIARIO')
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                <strong>Nota:</strong>
                            </label>
                            <span class="text-sky-800 dark:text-sky-600">Los dias de cobro serán consecutivos a partir
                                del
                                {{ fechaLiteralEsp($start_date) }}</span>
                        </div>
                    @endif
                    @if ($frequency === 'SEMANAL')
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Dia de Cobro
                                <small class="text-xs"><i>(El día es tomado de la fecha inicial)</i></small></label>

                            <select wire:model.live="day_of_week" disabled
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                                <option value="1">Lunes</option>
                                <option value="2">Martes</option>
                                <option value="3">Miercoles</option>
                                <option value="4">Jueves</option>
                                <option value="5">Viernes</option>
                                <option value="6">Sabado</option>
                                <option value="0">Domingo</option>
                            </select>
                        </div>
                    @endif
                    @if ($frequency === 'MENSUAL')
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Elija la fecha
                                Cobro</label>
                            <select wire:model.live="day_of_month" disabled
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                                <option value="">Seleccione un día del mes</option>
                                <!-- Días del 1 al 30 -->
                                <option value="01">01</option>
                                <option value="02">02</option>
                                <option value="03">03</option>
                                <option value="04">04</option>
                                <option value="05">05</option>
                                <option value="06">06</option>
                                <option value="07">07</option>
                                <option value="08">08</option>
                                <option value="09">09</option>
                                <option value="10">10</option>
                                <option value="11">11</option>
                                <option value="12">12</option>
                                <option value="13">13</option>
                                <option value="14">14</option>
                                <option value="15">15</option>
                                <option value="16">16</option>
                                <option value="17">17</option>
                                <option value="18">18</option>
                                <option value="19">19</option>
                                <option value="20">20</option>
                                <option value="21">21</option>
                                <option value="22">22</option>
                                <option value="23">23</option>
                                <option value="24">24</option>
                                <option value="25">25</option>
                                <option value="26">26</option>
                                <option value="27">27</option>
                                <option value="28">28</option>
                                <option value="29">29</option>
                                <option value="30">30</option>
                                <option value="31">31</option>
                            </select>
                            <small class="text-xs text-sky-700 dark:text-sky-600"><i>Si elije un dia mayor a 28,
                                    Febrero
                                    tomará el ultimo día del mes</i></small>

                        </div>
                    @endif
                    @if ($frequency === 'PERSONALIZABLE')
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Intervalo de
                                Días</label>
                            <input type="number" wire:model.live.debounce.800ms="custom_days_interval"
                                min="1"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm dark:bg-gray-700 dark:border-gray-600 dark:text-white">

                            <small class="text-xs text-sky-700 dark:text-sky-600"><i>Elija cada cuantos dias se
                                    realizará
                                    el
                                    cobro a partir de la fecha inicial</i></small>
                            @error('custom_days_interval')
                                <small class="text-xs text-danger-600">{{ $message }}</small>
                            @enderror
                        </div>
                    @endif
                @endif
            </div>


        </div>

        {{-- Asignaciones de Participantes en Fechas --}}

        @if (count($participantCounts))
            <div class="bg-white dark:bg-gray-900 shadow-lg rounded-xl p-6 text-gray-700 dark:text-gray-300 mb-3">

                <h2 class="text-lg font-bold mb-2 text-sky-800 dark:text-white">
                    Asignaciones
                </h2>
                <div class="grid grid-cols-1 md:grid-cols-4 gap-6 text-md">
                    @if ($fechas->count() === 0)
                        <button wire:click="generaFechas"
                            class="bg-green-600 hover:bg-green-700 text-white font-semibold px-4 py-2 rounded focus:outline-none focus:ring-2 focus:ring-green-500 text-sm mb-2">
                            <i class="fas fa-calendar-plus mr-1"></i> Generar Fechas
                        </button>
                    @else
                        <button onclick="asignarAutomaticamente()"
                            class="bg-yellow-500 hover:bg-yellow-600 text-white font-semibold px-4 py-2 rounded focus:outline-none focus:ring-2 focus:ring-yellow-500 text-sm mb-2">
                            <i class="fas fa-random mr-1"></i> Asignar Automáticamente
                        </button>
                    @endif
                </div>

                @if ($fechas->count() > 0)
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 text-md max-h-[50vh] overflow-y-auto">
                        <div class="mb-4">
                            <label class="block font-medium text-sky-700 dark:text-gray-300">
                                Participantes
                            </label>
                            <div id="paticipantes">
                                @php $bid = 1; @endphp
                                @foreach ($selectedParticipants as $participant)
                                    @for ($i = 0; $i < ($participantCounts[$participant['id']] ?? 1); $i++)
                                        <button data-participant-id="{{ $participant['id'] }}"
                                            data-button-id="{{ $bid }}"
                                            id="participant-btn-{{ $bid++ }}"
                                            class="participant-btn w-full text-left bg-sky-400 hover:bg-sky-700 text-white font-semibold py-2 px-4 rounded-md shadow transition mb-3">
                                            {{ $participant['nombre'] }}
                                        </button>
                                    @endfor
                                @endforeach
                            </div>
                        </div>
                        <div class="mb-4">
                            <label class="block font-medium text-sky-700 dark:text-gray-300">
                                Fechas Disponibles
                            </label>
                            <div class="" id="fechas">
                                @php $i = 1; @endphp
                                @foreach ($fechas as $fecha)
                                    <div class="flex justify-between shrink-0 font-semibold py-2 px-4 rounded-md bg-green-400 dark:text-gray-700 mb-3 cursor-pointer hover:bg-green-500 transition-all"
                                        data-fecha-id="{{ $fecha->id }}" data-fecha-date="{{ $fecha->date }}"
                                        onclick="asignarParticipanteAFecha(this)">

                                        <span class="fecha-numero">{{ $i++ }}.- {{ $fecha->date }}</span>

                                        <span
                                            class="fecha-asignacion rounded-md bg-gray-300 text-sm px-6 dark:text-gray-700 text-center hover:bg-gray-400 transition pointer-events-none">
                                            Sin Asignar
                                        </span>
                                    </div>
                                @endforeach
                            </div>

                        </div>
                    </div>
                @endif
            </div>
        @endif
    @else
        {{-- Tabla de asignaciones finalizadas --}}
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-3">
            <div class="flex items-center">
                <svg class="w-6 h-6 mr-2" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd"
                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                        clip-rule="evenodd"></path>
                </svg>
                <div>
                    <strong class="font-bold">✅ Proceso de asignaciones completado</strong>
                    <p class="text-sm">Todas las fechas han sido asignadas a participantes correctamente.</p>
                </div>
            </div>
        </div>

        {{-- RESUMEN COMPLETO --}}
        <div class="bg-white dark:bg-gray-900 shadow-lg rounded-xl p-6 text-gray-700 dark:text-gray-300 mb-3"
            id="resumen-completo">


            {{-- Resumen del Grupo --}}
            <div class="mb-6">
                <div class="bg-blue-50 dark:bg-blue-900 border border-blue-200 dark:border-blue-700 rounded-lg p-6">
                    <h3 class="text-lg font-semibold mb-4 text-blue-800 dark:text-blue-200 flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z">
                            </path>
                        </svg>
                        Información del Grupo
                    </h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        {{-- Información básica del grupo --}}
                        <div class="space-y-3">
                            <div class="flex items-start">
                                <span
                                    class="inline-flex items-center justify-center w-8 h-8 bg-blue-100 dark:bg-blue-800 text-blue-600 dark:text-blue-300 rounded-full text-sm font-semibold mr-3">
                                    📋
                                </span>
                                <div>
                                    <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Nombre del Grupo
                                    </p>
                                    <p class="text-lg font-semibold text-gray-900 dark:text-gray-100">
                                        {{ $groupSel->name }}</p>
                                </div>
                            </div>

                            <div class="flex items-start">
                                <span
                                    class="inline-flex items-center justify-center w-8 h-8 bg-green-100 dark:bg-green-800 text-green-600 dark:text-green-300 rounded-full text-sm font-semibold mr-3">
                                    💰
                                </span>
                                <div>
                                    <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Monto de Aporte</p>
                                    <p class="text-lg font-semibold text-gray-900 dark:text-gray-100">
                                        Bs.{{ number_format($groupSel->amount_per_participant, 2) }}
                                    </p>
                                </div>
                            </div>
                        </div>

                        {{-- Información de fechas --}}
                        <div class="space-y-3">
                            <div class="flex items-start">
                                <span
                                    class="inline-flex items-center justify-center w-8 h-8 bg-purple-100 dark:bg-purple-800 text-purple-600 dark:text-purple-300 rounded-full text-sm font-semibold mr-3">
                                    📅
                                </span>
                                <div>
                                    <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Fecha de Inicio</p>
                                    <p class="text-lg font-semibold text-gray-900 dark:text-gray-100">
                                        {{ \Carbon\Carbon::parse($groupSel->start_date)->format('d/m/Y') }}
                                    </p>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">
                                        {{ \Carbon\Carbon::parse($groupSel->start_date)->locale('es')->isoFormat('dddd, D [de] MMMM [de] YYYY') }}
                                    </p>
                                </div>
                            </div>

                            <div class="flex items-start">
                                <span
                                    class="inline-flex items-center justify-center w-8 h-8 bg-orange-100 dark:bg-orange-800 text-orange-600 dark:text-orange-300 rounded-full text-sm font-semibold mr-3">
                                    🔄
                                </span>
                                <div>
                                    <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Frecuencia de Cobro
                                    </p>
                                    <p class="text-lg font-semibold text-gray-900 dark:text-gray-100">
                                        {{ ucfirst(strtolower($groupSel->frequency)) }}
                                    </p>
                                    @if ($groupSel->frequency === 'PERSONALIZABLE' && $groupSel->custom_days_interval)
                                        <p class="text-xs text-gray-500 dark:text-gray-400">
                                            Cada {{ $groupSel->custom_days_interval }} días
                                        </p>
                                    @elseif($groupSel->frequency === 'SEMANAL' && $groupSel->day_of_week)
                                        <p class="text-xs text-gray-500 dark:text-gray-400">
                                            @php
                                                $dias = [
                                                    'Domingo',
                                                    'Lunes',
                                                    'Martes',
                                                    'Miércoles',
                                                    'Jueves',
                                                    'Viernes',
                                                    'Sábado',
                                                ];
                                            @endphp
                                            Los {{ $dias[$groupSel->day_of_week] }}
                                        </p>
                                    @elseif($groupSel->frequency === 'MENSUAL' && $groupSel->day_of_month)
                                        <p class="text-xs text-gray-500 dark:text-gray-400">
                                            Día {{ $groupSel->day_of_month }} de cada mes
                                        </p>
                                    @endif
                                </div>
                            </div>
                        </div>

                        {{-- Estadísticas del cronograma --}}
                        <div class="space-y-3">
                            <div class="flex items-start">
                                <span
                                    class="inline-flex items-center justify-center w-8 h-8 bg-red-100 dark:bg-red-800 text-red-600 dark:text-red-300 rounded-full text-sm font-semibold mr-3">
                                    📊
                                </span>
                                <div>
                                    <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Duración Total</p>
                                    <p class="text-lg font-semibold text-gray-900 dark:text-gray-100">
                                        {{ count($asignacionesFinalizadas) }} fechas
                                    </p>
                                    @if (count($asignacionesFinalizadas) > 0)
                                        @php
                                            try {
                                                // Usar la función fechaCarbon mejorada que maneja diferentes formatos
                                                $fechaInicio = fechaCarbon($asignacionesFinalizadas[0]['fecha']);
                                                $fechaFin = fechaCarbon(
                                                    $asignacionesFinalizadas[count($asignacionesFinalizadas) - 1][
                                                        'fecha'
                                                    ],
                                                );

                                                // Calcular diferencias
                                                $duracionMeses = $fechaInicio->diffInMonths($fechaFin);
                                                $duracionDias = $fechaInicio->diffInDays($fechaFin);
                                                $duracionSemanas = $fechaInicio->diffInWeeks($fechaFin);

                                                // Determinar la mejor unidad para mostrar
                                                $mostrarDuracion = true;
                                                $textoDuracion = '';

                                                if ($duracionMeses >= 12) {
                                                    $anos = floor($duracionMeses / 12);
                                                    $mesesRestantes = $duracionMeses % 12;
                                                    $textoDuracion = $anos . ($anos == 1 ? ' año' : ' años');
                                                    if ($mesesRestantes > 0) {
                                                        $textoDuracion .=
                                                            ' y ' .
                                                            $mesesRestantes .
                                                            ($mesesRestantes == 1 ? ' mes' : ' meses');
                                                    }
                                                } elseif ($duracionMeses > 0) {
                                                    $textoDuracion =
                                                        $duracionMeses . ($duracionMeses == 1 ? ' mes' : ' meses');
                                                } elseif ($duracionSemanas > 4) {
                                                    $textoDuracion =
                                                        $duracionSemanas .
                                                        ($duracionSemanas == 1 ? ' semana' : ' semanas');
                                                } elseif ($duracionDias > 0) {
                                                    $textoDuracion =
                                                        $duracionDias . ($duracionDias == 1 ? ' día' : ' días');
                                                } else {
                                                    $textoDuracion = 'Mismo día';
                                                }
                                            } catch (\Exception $e) {
                                                // En caso de error, registrar y mostrar información básica
                                                \Log::error(
                                                    'Error calculando duración en group-settings.blade.php: ' .
                                                        $e->getMessage(),
                                                    [
                                                        'fecha_inicio' => $asignacionesFinalizadas[0]['fecha'] ?? 'N/A',
                                                        'fecha_fin' =>
                                                            $asignacionesFinalizadas[
                                                                count($asignacionesFinalizadas) - 1
                                                            ]['fecha'] ?? 'N/A',
                                                    ],
                                                );

                                                $mostrarDuracion = false;
                                                $textoDuracion = 'Error al calcular duración';
                                            }
                                        @endphp

                                        @if ($mostrarDuracion)
                                           

                                            {{-- Información adicional de fechas --}}
                                            
                                                <div class="text-xs text-gray-400 dark:text-gray-500 space-y-1">
                                                   
                                                    <div class="flex justify-between">
                                                        <span>Fin:</span>
                                                        <span
                                                            class="font-medium">{{ $asignacionesFinalizadas[count($asignacionesFinalizadas) - 1]['fecha'] }}</span>
                                                    </div>
                                                    @if (isset($duracionDias) && $duracionDias > 0)
                                                        <div class="flex justify-between">
                                                            <span>Total días:</span>
                                                            <span class="font-medium">{{ $duracionDias + 1 }}</span>
                                                        </div>
                                                    @endif
                                                </div>
                                            
                                        @else
                                            <p class="text-xs text-red-500 dark:text-red-400">
                                                {{ $textoDuracion }}
                                            </p>
                                        @endif
                                    @else
                                        <p class="text-xs text-gray-500 dark:text-gray-400">
                                            Sin fechas asignadas
                                        </p>
                                    @endif
                                </div>
                            </div>
                              <div class="flex items-start">
                            <span
                                class="inline-flex items-center justify-center w-8 h-8 bg-teal-100 dark:bg-teal-800 text-teal-600 dark:text-teal-300 rounded-full text-sm font-semibold mr-3">
                                💸
                            </span>
                            <div>
                                <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Recaudar por fecha
                                </p>
                                <p class="text-lg font-semibold text-gray-900 dark:text-gray-100">
                                    Bs.{{ number_format($groupSel->amount_per_participant * count($asignacionesFinalizadas), 2) }}
                                </p>
                                <p class="text-xs text-gray-500 dark:text-gray-400">
                                    Bs.{{ number_format($groupSel->amount_per_participant, 2) }} ×
                                    {{ count($asignacionesFinalizadas) }} fechas
                                </p>
                            </div>
                        </div>
                        </div>

                      
                    </div>
                </div>



            </div>
        </div>

        {{-- Tabla de cronograma --}}


        {{-- Tabla de cronograma --}}
        <div class="mb-3">
            <h3 class="text-lg font-semibold mb-4 text-gray-800 dark:text-gray-200">
                📋 Cronograma de Asignaciones - {{ $groupSel->name }}
            </h3>

            <div class="overflow-x-auto">
                <table class="min-w-full bg-white dark:bg-gray-800 rounded-lg shadow">
                    <thead class="bg-gray-50 dark:bg-gray-700">
                        <tr>
                            <th
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                #
                            </th>
                            <th
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                Fecha
                            </th>

                            <th
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                Participante
                            </th>
                            <th
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                Estado
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-600">
                        @php $contador = 1; @endphp
                        @foreach ($asignacionesFinalizadas as $asignacion)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                                <td
                                    class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-gray-100">
                                    {{ $contador++ }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                                    <div class="flex flex-col">
                                        <span class="font-semibold text-lg">{{ $asignacion['fecha'] }}</span>
                                        <span class="text-xs text-gray-500 dark:text-gray-400">
                                            {{ $asignacion['fecha_texto'] }}
                                        </span>
                                    </div>
                                </td>

                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-10 w-10">
                                            <div
                                                class="h-10 w-10 rounded-full bg-gradient-to-r from-blue-500 to-purple-600 flex items-center justify-center text-white text-sm font-bold shadow-lg">
                                                {{ substr($asignacion['participant_nombre'], 0, 1) }}
                                            </div>
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900 dark:text-gray-100">
                                                {{ $asignacion['participant_nombre'] }}
                                            </div>
                                            @if ($asignacion['participant_email'])
                                                <div class="text-sm text-gray-500 dark:text-gray-400">
                                                    {{ $asignacion['participant_email'] }}
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">
                                        <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                                clip-rule="evenodd"></path>
                                        </svg>
                                        Asignado
                                    </span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Estadísticas --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
            <div class="bg-blue-50 dark:bg-blue-900 p-4 rounded-lg">
                <div class="flex items-center">
                    <div class="p-2 rounded-md bg-blue-500 text-white">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                            </path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600 dark:text-gray-300">Total Fechas</p>
                        <p class="text-2xl font-semibold text-gray-900 dark:text-gray-100">
                            {{ count($asignacionesFinalizadas) }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-green-50 dark:bg-green-900 p-4 rounded-lg">
                <div class="flex items-center">
                    <div class="p-2 rounded-md bg-green-500 text-white">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z">
                            </path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600 dark:text-gray-300">Participantes</p>
                        <p class="text-2xl font-semibold text-gray-900 dark:text-gray-100">
                            {{ collect($asignacionesFinalizadas)->unique('participant_nombre')->count() }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-purple-50 dark:bg-purple-900 p-4 rounded-lg">
                <div class="flex items-center">
                    <div class="p-2 rounded-md bg-purple-500 text-white">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600 dark:text-gray-300">Estado</p>
                        <p class="text-2xl font-semibold text-gray-900 dark:text-gray-100">100%</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Botones de acción --}}
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            <button onclick="confirmarResetear()"
                class="bg-orange-500 hover:bg-orange-600 text-white font-bold py-3 px-6 rounded-lg transition-colors flex items-center justify-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15">
                    </path>
                </svg>
                Resetear y Volver a Configurar
            </button>

            <button onclick="confirmarImprimir()"
                class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-3 px-6 rounded-lg transition-colors flex items-center justify-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z">
                    </path>
                </svg>
                Imprimir Cronograma
            </button>
        </div>
</div>

@endif



</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        let botonSeleccionado = null;
        let participantIdSeleccionado = null;
        let buttonIdSeleccionado = null;
        let asignacionesTemporales = []; // Array para guardar asignaciones temporales

        // Función para manejar la selección de participantes
        function manejarSeleccionParticipante(boton) {
            // Si ya hay un botón seleccionado, quita la selección
            if (botonSeleccionado) {
                botonSeleccionado.classList.remove('bg-sky-700', 'ring-2', 'ring-sky-300');
                botonSeleccionado.classList.add('bg-sky-400');
            }

            // Si se presiona el mismo botón, deselecciona
            if (botonSeleccionado === boton) {
                liberarDatosTemporales();
                return;
            }

            // Selecciona el nuevo botón y guarda los datos temporalmente
            botonSeleccionado = boton;
            participantIdSeleccionado = boton.getAttribute('data-participant-id');
            buttonIdSeleccionado = boton.getAttribute('data-button-id');

            boton.classList.remove('bg-sky-400');
            boton.classList.add('bg-sky-700', 'ring-2', 'ring-sky-300');

            // Toast de selección
            // Swal.fire({
            //     toast: true,
            //     position: 'top-end',
            //     icon: 'info',
            //     title: `Participante seleccionado: ${boton.innerText}`,
            //     showConfirmButton: false,
            //     timer: 2000,
            //     timerProgressBar: true
            // });
        }

        // Función para liberar datos temporales
        function liberarDatosTemporales(mostrarToast = true) {
            if (botonSeleccionado) {
                botonSeleccionado.classList.remove('bg-sky-700', 'ring-2', 'ring-sky-300');
                botonSeleccionado.classList.add('bg-sky-400');
            }

            botonSeleccionado = null;
            participantIdSeleccionado = null;
            buttonIdSeleccionado = null;

            // Solo mostrar toast si se especifica
            // if (mostrarToast) {
            //     Swal.fire({
            //         toast: true,
            //         position: 'top-end',
            //         icon: 'success',
            //         title: 'Selección liberada',
            //         showConfirmButton: false,
            //         timer: 1500,
            //         timerProgressBar: true
            //     });
            // }
        }

        // Función para asignar participante a fecha
        window.asignarParticipanteAFecha = function(element) {
            if (!botonSeleccionado) {
                Swal.fire({
                    toast: true,
                    position: 'top-end',
                    icon: 'warning',
                    title: 'Primero selecciona un participante de la lista izquierda',
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true
                });
                return;
            }

            // Si se hizo clic en el span interno, obtener el contenedor padre
            let fechaContainer = element;
            if (!fechaContainer.hasAttribute('data-fecha-id')) {
                fechaContainer = element.closest('[data-fecha-id]');
            }

            const fechaId = fechaContainer.getAttribute('data-fecha-id');
            const fechaDate = fechaContainer.getAttribute('data-fecha-date');

            // Verificar si ya hay una asignación para esta fecha
            const asignacionExistente = asignacionesTemporales.find(a => a.fechaId === fechaId);
            if (asignacionExistente) {
                Swal.fire({
                    toast: true,
                    position: 'top-end',
                    icon: 'error',
                    title: 'Esta fecha ya está asignada',
                    text: 'Haz doble clic para liberar primero',
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true
                });
                return;
            }

            // Crear la asignación temporal
            const asignacion = {
                fechaId: fechaId,
                fechaDate: fechaDate,
                participantId: participantIdSeleccionado,
                buttonId: buttonIdSeleccionado,
                participantName: botonSeleccionado.innerText
            };

            // Agregar a asignaciones temporales
            asignacionesTemporales.push(asignacion);

            // Obtener el span de asignación dentro del contenedor
            const spanElement = fechaContainer.querySelector('.fecha-asignacion');

            // Actualizar visualmente la fecha
            spanElement.innerHTML = asignacion.participantName;
            spanElement.classList.remove('bg-gray-300', 'hover:bg-gray-400');
            spanElement.classList.add('bg-blue-300', 'text-blue-800');

            // Cambiar el color de toda la fila para indicar que está asignada
            fechaContainer.classList.remove('bg-green-400', 'hover:bg-green-500');
            fechaContainer.classList.add('bg-green-600');

            // SOLO agregar doble clic, MANTENER el clic simple
            fechaContainer.setAttribute('ondblclick', 'liberarFecha(this)');
            // fechaContainer.removeAttribute('onclick'); ← ELIMINAR ESTA LÍNEA

            // Ocultar el botón del participante
            botonSeleccionado.style.display = 'none';

            // Toast de éxito
            Swal.fire({
                toast: true,
                position: 'top-end',
                icon: 'success',
                title: 'Asignación realizada',
                text: `${asignacion.participantName} asignado a ${asignacion.fechaDate}`,
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true
            });

            // Liberar selección SIN mostrar toast adicional
            liberarDatosTemporales(false);

            // Verificar si todas las fechas están asignadas
            verificarAsignacionCompleta();
        };

        // Función para liberar una fecha asignada
        window.liberarFecha = function(element) {
            // Si se hizo clic en el span interno, obtener el contenedor padre
            let fechaContainer = element;
            if (!fechaContainer.hasAttribute('data-fecha-id')) {
                fechaContainer = element.closest('[data-fecha-id]');
            }

            const fechaId = fechaContainer.getAttribute('data-fecha-id');

            // Encontrar la asignación
            const asignacionIndex = asignacionesTemporales.findIndex(a => a.fechaId === fechaId);
            if (asignacionIndex === -1) return;

            const asignacion = asignacionesTemporales[asignacionIndex];

            // Mostrar confirmación antes de liberar
            Swal.fire({
                title: '¿Liberar asignación?',
                text: `¿Deseas liberar la fecha ${asignacion.fechaDate} de ${asignacion.participantName}?`,
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sí, liberar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Restaurar el botón del participante
                    const botonParticipante = document.getElementById(
                        `participant-btn-${asignacion.buttonId}`);
                    if (botonParticipante) {
                        botonParticipante.style.display = 'block';
                    }

                    // Obtener el span de asignación
                    const spanElement = fechaContainer.querySelector('.fecha-asignacion');

                    // Restaurar visualmente la fecha
                    spanElement.innerHTML = 'Sin Asignar';
                    spanElement.classList.remove('bg-blue-300', 'text-blue-800');
                    spanElement.classList.add('bg-gray-300', 'hover:bg-gray-400');

                    // Restaurar el color de toda la fila
                    fechaContainer.classList.remove('bg-green-600');
                    fechaContainer.classList.add('bg-green-400', 'hover:bg-green-500');

                    // Restaurar el clic simple y quitar el doble clic
                    fechaContainer.setAttribute('onclick', 'asignarParticipanteAFecha(this)');
                    fechaContainer.removeAttribute('ondblclick');

                    // Eliminar la asignación temporal
                    asignacionesTemporales.splice(asignacionIndex, 1);

                    // Toast de liberación exitosa
                    Swal.fire({
                        toast: true,
                        position: 'top-end',
                        icon: 'success',
                        title: 'Fecha liberada',
                        text: `${asignacion.participantName} liberado de ${asignacion.fechaDate}`,
                        showConfirmButton: false,
                        timer: 3000,
                        timerProgressBar: true
                    });

                    // Verificar si todas las fechas están asignadas
                    verificarAsignacionCompleta();
                }
            });
        };

        // Función para obtener todas las asignaciones temporales
        window.obtenerAsignacionesTemporales = function() {
            if (asignacionesTemporales.length === 0) {
                Swal.fire({
                    toast: true,
                    position: 'top-end',
                    icon: 'info',
                    title: 'No hay asignaciones temporales',
                    showConfirmButton: false,
                    timer: 2000,
                    timerProgressBar: true
                });
            }
            return asignacionesTemporales;
        };

        // Función para limpiar todas las asignaciones
        window.limpiarAsignaciones = function() {
            if (asignacionesTemporales.length === 0) {
                Swal.fire({
                    toast: true,
                    position: 'top-end',
                    icon: 'info',
                    title: 'No hay asignaciones para limpiar',
                    showConfirmButton: false,
                    timer: 2000,
                    timerProgressBar: true
                });
                return;
            }

            // Mostrar confirmación antes de limpiar todo
            Swal.fire({
                title: '¿Limpiar todas las asignaciones?',
                text: 'Esta acción liberará todas las asignaciones temporales realizadas',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Sí, limpiar todo',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    const cantidadAsignaciones = asignacionesTemporales.length;

                    asignacionesTemporales.forEach(asignacion => {
                        // Restaurar botones
                        const botonParticipante = document.getElementById(
                            `participant-btn-${asignacion.buttonId}`);
                        if (botonParticipante) {
                            botonParticipante.style.display = 'block';
                        }

                        // Restaurar fechas
                        const fechaContainer = document.querySelector(
                            `[data-fecha-id="${asignacion.fechaId}"]`);
                        const fechaElement = fechaContainer?.querySelector(
                            '.fecha-asignacion');
                        if (fechaElement && fechaContainer) {
                            fechaElement.innerHTML = 'Sin Asignar';
                            fechaElement.classList.remove('bg-blue-300', 'text-blue-800');
                            fechaElement.classList.add('bg-gray-300', 'hover:bg-gray-400');

                            fechaContainer.classList.remove('bg-green-600');
                            fechaContainer.classList.add('bg-green-400',
                                'hover:bg-green-500');
                            fechaContainer.setAttribute('onclick',
                                'asignarParticipanteAFecha(this)');
                            fechaContainer.removeAttribute('ondblclick');
                        }
                    });

                    asignacionesTemporales = [];
                    liberarDatosTemporales();

                    // Toast de limpieza exitosa
                    Swal.fire({
                        toast: true,
                        position: 'top-end',
                        icon: 'success',
                        title: 'Asignaciones limpiadas',
                        text: `Se liberaron ${cantidadAsignaciones} asignaciones`,
                        showConfirmButton: false,
                        timer: 3000,
                        timerProgressBar: true
                    });

                    // Verificar si todas las fechas están asignadas (ocultará el botón)
                    verificarAsignacionCompleta();
                }
            });
        };

        // Función para asignación automática
        window.asignarAutomaticamente = function() {
            // Obtener participantes disponibles (botones visibles)
            const participantesDisponibles = [];
            document.querySelectorAll('.participant-btn').forEach(boton => {
                if (boton.style.display !== 'none') {
                    participantesDisponibles.push({
                        element: boton,
                        participantId: boton.getAttribute('data-participant-id'),
                        buttonId: boton.getAttribute('data-button-id'),
                        participantName: boton.innerText
                    });
                }
            });

            // Obtener fechas sin asignar
            const fechasSinAsignar = [];
            document.querySelectorAll('[data-fecha-id]').forEach(fechaContainer => {
                const fechaId = fechaContainer.getAttribute('data-fecha-id');
                const asignacionExistente = asignacionesTemporales.find(a => a.fechaId === fechaId);
                if (!asignacionExistente) {
                    fechasSinAsignar.push({
                        element: fechaContainer,
                        fechaId: fechaId,
                        fechaDate: fechaContainer.getAttribute('data-fecha-date')
                    });
                }
            });

            if (participantesDisponibles.length === 0) {
                Swal.fire({
                    toast: true,
                    position: 'top-end',
                    icon: 'warning',
                    title: 'No hay participantes disponibles para asignar',
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true
                });
                return;
            }

            if (fechasSinAsignar.length === 0) {
                Swal.fire({
                    toast: true,
                    position: 'top-end',
                    icon: 'info',
                    title: 'Todas las fechas ya están asignadas',
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true
                });
                return;
            }

            // Mezclar participantes aleatoriamente (algoritmo Fisher-Yates)
            const participantesMezclados = [...participantesDisponibles];
            for (let i = participantesMezclados.length - 1; i > 0; i--) {
                const j = Math.floor(Math.random() * (i + 1));
                [participantesMezclados[i], participantesMezclados[j]] = [participantesMezclados[j],
                    participantesMezclados[i]
                ];
            }

            // Asignar participantes a fechas
            let participanteIndex = 0;
            const asignacionesRealizadas = [];

            fechasSinAsignar.forEach(fecha => {
                if (participanteIndex < participantesMezclados.length) {
                    const participante = participantesMezclados[participanteIndex];

                    // Crear la asignación temporal
                    const asignacion = {
                        fechaId: fecha.fechaId,
                        fechaDate: fecha.fechaDate,
                        participantId: participante.participantId,
                        buttonId: participante.buttonId,
                        participantName: participante.participantName
                    };

                    // Agregar a asignaciones temporales
                    asignacionesTemporales.push(asignacion);
                    asignacionesRealizadas.push(asignacion);

                    // Obtener el span de asignación dentro del contenedor
                    const spanElement = fecha.element.querySelector('.fecha-asignacion');

                    // Actualizar visualmente la fecha
                    spanElement.innerHTML = asignacion.participantName;
                    spanElement.classList.remove('bg-gray-300', 'hover:bg-gray-400');
                    spanElement.classList.add('bg-blue-300', 'text-blue-800');

                    // Cambiar el color de toda la fila para indicar que está asignada
                    fecha.element.classList.remove('bg-green-400', 'hover:bg-green-500');
                    fecha.element.classList.add('bg-green-600');

                    // Agregar doble clic para liberar y mantener el clic simple
                    fecha.element.setAttribute('ondblclick', 'liberarFecha(this)');

                    // Ocultar el botón del participante
                    participante.element.style.display = 'none';

                    participanteIndex++;
                }
            });

            // Mostrar resultado
            Swal.fire({
                toast: true,
                position: 'top-end',
                icon: 'success',
                title: 'Asignación automática completada',
                text: `Se asignaron ${asignacionesRealizadas.length} fechas automáticamente`,
                showConfirmButton: false,
                timer: 4000,
                timerProgressBar: true
            });

            // Verificar si todas las fechas están asignadas para mostrar botón guardar
            verificarAsignacionCompleta();

            console.log('Asignaciones automáticas realizadas:', asignacionesRealizadas);
            console.log('Total asignaciones temporales:', asignacionesTemporales);
        };

        // Función para verificar si todas las fechas están asignadas
        function verificarAsignacionCompleta() {
            const totalFechas = document.querySelectorAll('[data-fecha-id]').length;
            const fechasAsignadas = asignacionesTemporales.length;

            const botonGuardar = document.getElementById('btn-guardar-asignaciones');

            if (fechasAsignadas === totalFechas && totalFechas > 0) {
                // Mostrar botón guardar si no existe
                if (!botonGuardar) {
                    mostrarBotonGuardar();
                }
            } else {
                // Ocultar botón guardar si existe
                if (botonGuardar) {
                    botonGuardar.remove();
                }
            }
        }

        // Función para mostrar el botón guardar asignaciones
        function mostrarBotonGuardar() {
            const container = document.querySelector('#fechas').closest('.bg-white');

            if (container && !document.getElementById('btn-guardar-asignaciones')) {
                const botonGuardar = document.createElement('div');
                botonGuardar.id = 'btn-guardar-asignaciones';
                botonGuardar.className = 'mt-2 text-center';
                botonGuardar.innerHTML = `
                <button onclick="guardarAsignaciones()" 
                    class="bg-green-600 hover:bg-green-700 text-white font-bold px-8 py-3 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 text-lg shadow-lg transition-all duration-200 transform hover:scale-105">
                    <i class="fas fa-save mr-2"></i> Guardar Asignaciones
                </button>
            `;
                container.appendChild(botonGuardar);
            }
        }

        // Eventos de selección de participantes
        document.addEventListener('click', function(e) {
            if (e.target.classList.contains('participant-btn')) {
                e.preventDefault();
                e.stopPropagation();
                manejarSeleccionParticipante(e.target);
            }
            // Solo liberar si NO es un clic en una fecha (ni asignada ni sin asignar)
            else if (botonSeleccionado &&
                !e.target.closest('.participant-btn') &&
                !e.target.closest('[data-fecha-id]')) { // Excluir toda la fila de fecha
                liberarDatosTemporales();
            }
        });

        // Manejar la tecla ESC para deseleccionar
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' && botonSeleccionado) {
                liberarDatosTemporales();
            }
        });

        // Reset cuando Livewire actualiza
        document.addEventListener('livewire:updated', function() {
            botonSeleccionado = null;
            participantIdSeleccionado = null;
            buttonIdSeleccionado = null;
        });

        // Funciones globales para acceso externo
        window.getDatosParticipanteSeleccionado = function() {
            return {
                participantId: participantIdSeleccionado,
                buttonId: buttonIdSeleccionado,
                button: botonSeleccionado
            };
        };

        window.hayParticipanteSeleccionado = function() {
            return botonSeleccionado !== null;
        };

        // Función para guardar asignaciones
        window.guardarAsignaciones = function() {
            Swal.fire({
                title: '¿Guardar asignaciones?',
                text: `Se guardarán ${asignacionesTemporales.length} asignaciones de fechas`,
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#16a34a',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sí, guardar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Enviar datos a Livewire
                    window.Livewire.find('{{ $_instance->getId() }}').call('guardarAsignaciones',
                        asignacionesTemporales);
                }
            });
        };
    });
</script>

<script>
    // Función para confirmar reseteo con SweetAlert2
    function confirmarResetear() {
        Swal.fire({
            title: '¿Resetear todas las asignaciones?',
            html: `
            <div class="text-left">
                <p class="mb-3">Esta acción:</p>
                <ul class="list-disc list-inside text-sm text-gray-600">
                    <li>Eliminará todas las asignaciones guardadas</li>
                    <li>Borrará todos los participantes de las fechas</li>
                    <li>Te permitirá volver a configurar desde cero</li>
                    <li><strong>No se puede deshacer</strong></li>
                </ul>
            </div>
        `,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#f97316',
            cancelButtonColor: '#6b7280',
            confirmButtonText: '<i class="fas fa-exclamation-triangle mr-2"></i>Sí, resetear todo',
            cancelButtonText: '<i class="fas fa-times mr-2"></i>Cancelar',
            reverseButtons: true,
            focusCancel: true,
            customClass: {
                confirmButton: 'font-bold',
                cancelButton: 'font-bold'
            }
        }).then((result) => {
            if (result.isConfirmed) {
                // Mostrar loading
                Swal.fire({
                    title: 'Reseteando asignaciones...',
                    text: 'Por favor espera mientras se procesan los cambios',
                    icon: 'info',
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                    showConfirmButton: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });

                // Ejecutar la función de Livewire
                @this.call('volverAConfiguracion');
            }
        });
    }

    function confirmarImprimir() {
        Swal.fire({
            title: '¿Imprimir cronograma?',
            html: `
            <div class="text-left">
                <p class="mb-3">Se imprimirá:</p>
                <ul class="list-disc list-inside text-sm text-gray-600">
                    <li>Tabla completa de asignaciones</li>
                    <li>{{ count($asignacionesFinalizadas) }} fechas programadas</li>
                    <li>Información de todos los participantes</li>
                    <li>Cronograma del grupo: <strong>{{ $groupSel->name }}</strong></li>
                </ul>
            </div>
        `,
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#6b7280',
            cancelButtonColor: '#6b7280',
            confirmButtonText: '<i class="fas fa-print mr-2"></i>Sí, imprimir',
            cancelButtonText: '<i class="fas fa-times mr-2"></i>Cancelar',
            reverseButtons: true,
            customClass: {
                confirmButton: 'font-bold',
                cancelButton: 'font-bold'
            }
        }).then((result) => {
            if (result.isConfirmed) {
                // Toast de éxito antes de imprimir
                Swal.fire({
                    toast: true,
                    position: 'top-end',
                    icon: 'success',
                    title: 'Preparando impresión...',
                    showConfirmButton: false,
                    timer: 1500,
                    timerProgressBar: true
                }).then(() => {
                    // Ejecutar impresión solo del resumen completo
                    imprimirResumenCompleto();
                });
            }
        });
    }

    // Nueva función para imprimir solo el resumen completo
    function imprimirResumenCompleto() {
        // Crear estilos CSS para impresión
        const estilosImpresion = document.createElement('style');
        estilosImpresion.innerHTML = `
        @media print {
            * {
                visibility: hidden;
            }
            
            #resumen-completo,
            #resumen-completo * {
                visibility: visible;
            }
            
            #resumen-completo {
                position: absolute;
                left: 0;
                top: 0;
                width: 100%;
                margin: 0;
                padding: 20px;
                background: white !important;
                box-shadow: none !important;
            }
            
            /* Ocultar botones en la impresión */
            #resumen-completo button {
                display: none !important;
            }
            
            /* Estilos para la tabla */
            #resumen-completo table {
                width: 100% !important;
                border-collapse: collapse !important;
            }
            
            #resumen-completo th,
            #resumen-completo td {
                border: 1px solid #333 !important;
                padding: 8px !important;
                font-size: 12px !important;
            }
            
            #resumen-completo th {
                background-color: #f5f5f5 !important;
                font-weight: bold !important;
            }
            
            /* Título del cronograma */
            #resumen-completo h3 {
                font-size: 18px !important;
                margin-bottom: 15px !important;
                text-align: center !important;
            }
            
            /* Estadísticas */
            #resumen-completo .grid {
                display: flex !important;
                justify-content: space-around !important;
                margin: 20px 0 !important;
            }
            
            #resumen-completo .grid > div {
                border: 1px solid #333 !important;
                padding: 10px !important;
                text-align: center !important;
            }
            
            /* Mensaje de completado */
            #resumen-completo .bg-green-100 {
                background-color: #f0f9f0 !important;
                border: 2px solid #4ade80 !important;
                padding: 15px !important;
                margin-bottom: 20px !important;
            }
            
            /* Remover colores de fondo oscuros */
            .dark\\:bg-gray-900,
            .dark\\:bg-gray-800,
            .dark\\:bg-gray-700 {
                background-color: white !important;
            }
            
            .dark\\:text-gray-100,
            .dark\\:text-gray-200,
            .dark\\:text-gray-300 {
                color: #000 !important;
            }
        }
    `;

        // Agregar estilos al head
        document.head.appendChild(estilosImpresion);

        // Ejecutar impresión
        window.print();

        // Remover estilos después de un breve delay
        setTimeout(() => {
            document.head.removeChild(estilosImpresion);
        }, 1000);
    }
    // Listener para cuando se complete el reseteo
    document.addEventListener('livewire:init', function() {
        Livewire.on('asignaciones-reseteadas', () => {
            Swal.fire({
                title: '¡Reseteo completado!',
                text: 'Las asignaciones han sido eliminadas correctamente. Ahora puedes volver a configurar.',
                icon: 'success',
                confirmButtonColor: '#16a34a',
                confirmButtonText: '<i class="fas fa-check mr-2"></i>Entendido',
                customClass: {
                    confirmButton: 'font-bold'
                }
            });
        });

        // Listener para errores en el reseteo
        Livewire.on('error-reseteo', (mensaje) => {
            Swal.fire({
                title: 'Error al resetear',
                text: mensaje,
                icon: 'error',
                confirmButtonColor: '#dc2626',
                confirmButtonText: '<i class="fas fa-exclamation-circle mr-2"></i>Entendido',
                customClass: {
                    confirmButton: 'font-bold'
                }
            });
        });
    });
</script>
