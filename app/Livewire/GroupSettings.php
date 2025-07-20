<?php

namespace App\Livewire;

use App\Models\Participant;
use App\Models\PasanacoGroup;
use App\Models\PasanacoGroupDate;
use App\Models\PasanacoGroupParticipant;
use Carbon\Carbon;
use DateTime;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class GroupSettings extends Component
{

    public ?int $groupId = null;
    public $groupSel;
    public array $selectedParticipants = [];
    public string $search = '';
    public $frequency = '', $day_of_week = 'Lunes', $day_of_month = '', $custom_days_interval = '1', $start_date = '';
    public $fechas = [];
    public $participantCounts = [];
    public $cantidadFechas = 0;

    public bool $fechasGeneradas = false;
    public bool $asignacionesCompletas = false;
    public $asignacionesFinalizadas = [];

    public function mount(int $groupId)
    {
        $this->groupId = $groupId;
        $this->groupSel = PasanacoGroup::findOrFail($groupId);
        $this->start_date = $this->groupSel->start_date ?? '';
        $fecha = new DateTime($this->start_date);
        $day_of_week = $fecha->format('w');
        $this->frequency = $this->groupSel->frequency ?? '';
        $this->day_of_week = $this->groupSel->day_of_week ?? $day_of_week;
        $this->day_of_month = $this->groupSel->day_of_month ?? '';
        $this->fechas = $this->groupSel->pasanacoGroupDates()->orderBy('date')->get();
        $this->custom_days_interval = $this->groupSel->custom_days_interval ?? '1';
        $this->loadSelectedParticipants();

        // Cargar participantes seleccionados con cantidad
        $this->selectedParticipants = PasanacoGroupParticipant::where('pasanaco_group_id', $groupId)
            ->where('status', 'active')
            ->with('participant')
            ->get()
            ->map(function ($pgp) {
                return [
                    'id' => $pgp->participant_id,
                    'nombre' => $pgp->participant->nombre,
                    'cantidad' => $pgp->cantidad,
                ];
            })->toArray();

        // Inicializar participantCounts con las cantidades guardadas
        $this->participantCounts = [];
        foreach ($this->selectedParticipants as $p) {
            $this->participantCounts[$p['id']] = $p['cantidad'];
            $this->cantidadFechas += $p['cantidad'];
        }


        // Verificar asignaciones al final del mount
        $this->verificarAsignacionesCompletas();
    }

    public function getPuedeAbrirModalProperty()
    {
        return !empty($this->fechas) && !empty($this->selectedParticipants);
    }

    // public function getCantFechasGenerasDB()
    // {
    //     return PasanacoGroupDate::where('pasanaco_group_id', $this->groupId)->count();
    // }

    public function loadSelectedParticipants()
    {
        $this->selectedParticipants = PasanacoGroupParticipant::with('participant')
            ->where('pasanaco_group_id', $this->groupId)
            ->where('status', 'active')
            ->get()
            ->map(function ($record) {
                return [
                    'id'     => $record->participant_id,
                    'nombre' => $record->participant->nombre ?? 'Desconocido',
                    'email'  => $record->participant->email ?? null,
                    'cantidad'  => $record->cantidad ?? null,
                ];
            })->toArray();
    }

    public function getAllParticipantsProperty()
    {
        return Participant::query()
            ->where('estado', 'activo')
            ->where('nombre', 'like', '%' . $this->search . '%')
            ->whereNotIn('id', collect($this->selectedParticipants)->pluck('id'))
            ->orderBy('nombre')
            ->get();
    }

    public function selectParticipant($id)
    {
        // Verifica si ya existe el registro
        $participant = PasanacoGroupParticipant::firstOrCreate([
            'pasanaco_group_id' => $this->groupId,
            'participant_id' => $id,
        ], [
            'cantidad' => 1,
            'status' => 'active'
        ]);

        // Actualiza el array local
        $this->participantCounts[$id] = $participant->cantidad;

        $participantModel = Participant::find($id);
        if ($participantModel && !collect($this->selectedParticipants)->contains('id', $participantModel->id)) {
            $this->selectedParticipants[] = [
                'id'     => $participantModel->id,
                'nombre' => $participantModel->nombre,
                'email'  => $participantModel->email,
            ];
        }
    }

    public function removeParticipant($id)
    {
        // Elimina de la base de datos
        PasanacoGroupParticipant::where('pasanaco_group_id', $this->groupId)
            ->where('participant_id', $id)
            ->delete();
        PasanacoGroupDate::where('pasanaco_group_id', $this->groupId)->delete();
        // Elimina del array local
        $this->selectedParticipants = array_filter($this->selectedParticipants, function ($p) use ($id) {
            return $p['id'] != $id;
        });

        unset($this->participantCounts[$id]);
        $this->resetFechasGeneradas();
    }

    public function saveParticipants()
    {
        if (!$this->groupId) {
            return;
        }
        PasanacoGroupParticipant::where('pasanaco_group_id', $this->groupId)->delete();
        foreach ($this->selectedParticipants as $participant) {
            PasanacoGroupParticipant::create([
                'pasanaco_group_id' => $this->groupId,
                'participant_id'    => $participant['id'],
                'status'           => 'active',
                'joined_at'        => now(),
            ]);
        }
        $this->reset('search');
        $this->loadSelectedParticipants();
    }

    public function render()
    {
        return view('livewire.group-settings')->layout('layouts.app');
    }

    public function generaFechas()
    {
        $this->cantidadFechas = array_sum($this->participantCounts);

        if ($this->cantidadFechas <= 0) {
            $this->dispatch('toast-error', 'No se puede generar fechas sin participantes asignados.');
            return;
        }
        $group = PasanacoGroup::findOrFail($this->groupId);

        $group->pasanacoGroupDates()->delete();
        $fechas = [];



        switch ($this->frequency) {
            case 'DIARIO':
                $fechas = $this->generarFechasConsecutivas();
                break;
            case 'SEMANAL':
                $fechas = $this->generarFechasPorDiaSemana();
                break;
            case 'MENSUAL':
                $fechas = $this->generarFechasPorDiaMes();
                break;
            case 'PERSONALIZABLE':
                $fechas = $this->generarFechasConIntervalo();
                break;
        }

        foreach ($fechas as $fecha) {
            $group->pasanacoGroupDates()->create(['date' => $fecha]);
        }

        $this->fechas = $this->groupSel->pasanacoGroupDates()->orderBy('date')->get();
        $this->fechasGeneradas = true;

        $this->dispatch('toast-success', 'Fechas generadas correctamente.');
    }



    function generarFechasConsecutivas()
    {
        $fechas = [];
        $fecha = new DateTime($this->start_date);

        for ($i = 0; $i < $this->cantidadFechas; $i++) {
            $fechas[] = $fecha->format('Y-m-d');
            $fecha->modify('+1 day');
        }

        return $fechas;
    }

    function generarFechasPorDiaSemana()
    {
        // Mapea número de día (PHP: 0=Domingo, 1=Lunes, ..., 6=Sabado) a nombre en inglés
        $diasIngles = [
            0 => 'Sunday',
            1 => 'Monday',
            2 => 'Tuesday',
            3 => 'Wednesday',
            4 => 'Thursday',
            5 => 'Friday',
            6 => 'Saturday',
        ];

        // Asegura que el valor recibido sea entero
        $diaSemana = intval($this->day_of_week);
        $diaIngles = $diasIngles[$diaSemana] ?? null;
        if ($diaIngles === null) return [];

        $fecha = \Carbon\Carbon::createFromFormat('Y-m-d', $this->start_date);

        // Si la fecha inicial no es el día deseado, buscar el próximo en inglés
        if ($fecha->dayOfWeek !== $diaSemana) {
            $fecha->modify('next ' . $diaIngles);
        }

        $fechas = [];
        for ($i = 0; $i < $this->cantidadFechas; $i++) {
            $fechas[] = $fecha->format('Y-m-d');
            $fecha->addWeek();
        }
        return $fechas;
    }

    function generarFechasPorDiaMes()
    {
        $fechas = [];
        $fecha = \Carbon\Carbon::createFromFormat('Y-m-d', $this->start_date);

        // Si la fecha inicial es posterior al día solicitado, avanzar al siguiente mes
        if ($fecha->day > $this->day_of_month) {
            $fecha->addMonth();
        }

        for ($i = 0; $i < $this->cantidadFechas; $i++) {
            // Clonar el mes y año actual
            $anio = $fecha->year;
            $mes = $fecha->month;

            // Calcular el último día del mes
            $ultimoDiaMes = \Carbon\Carbon::create($anio, $mes, 1)->endOfMonth()->day;

            // Si el día solicitado es mayor al último día del mes, usar el último día
            $dia = ($this->day_of_month > $ultimoDiaMes) ? $ultimoDiaMes : $this->day_of_month;

            // Crear la fecha
            $fechaGenerada = \Carbon\Carbon::create($anio, $mes, $dia)->format('Y-m-d');
            $fechas[] = $fechaGenerada;

            // Avanzar al siguiente mes
            $fecha->addMonth();
        }

        return $fechas;
    }

    function generarFechasConIntervalo()
    {
        $fechas = [];
        $fecha = Carbon::createFromFormat('Y-m-d', $this->start_date);

        $intervalo = (int) $this->custom_days_interval;
        if ($intervalo < 1) {
            $intervalo = 1;
        }

        for ($i = 0; $i < $this->cantidadFechas; $i++) {
            $fechas[] = $fecha->format('Y-m-d');
            $fecha->addDays($intervalo);
        }

        return $fechas;
    }

    public function updatedStartDate()
    {
        $this->groupSel->start_date = $this->start_date;
        $this->groupSel->day_of_week = date('w', strtotime($this->start_date));

        $this->groupSel->day_of_month = date('d', strtotime($this->start_date));

        $this->groupSel->save();
        $this->day_of_week = date('w', strtotime($this->start_date));
        $this->day_of_month = date('d', strtotime($this->start_date));
        $this->resetFechasGeneradas();
    }

    public function updatedFrequency()
    {
        $this->groupSel->frequency = $this->frequency;
        $this->groupSel->save();
        $this->resetFechasGeneradas();
    }


    public function updatedCustomDaysInterval()
    {
        $this->groupSel->custom_days_interval = $this->custom_days_interval ?: 1;
        $this->groupSel->save();
        $this->resetFechasGeneradas();
    }

    public function updatedParticipantCounts($value, $key)
    {
        $cantidad = (int)$value;
        if (empty($cantidad) || $cantidad < 1) {
            $cantidad = 1;
            $this->participantCounts[$key] = 1;
        }

        PasanacoGroupParticipant::where('pasanaco_group_id', $this->groupId)
            ->where('participant_id', $key)
            ->update(['cantidad' => $cantidad]);

        $this->cantidadFechas = array_sum($this->participantCounts);

        $this->resetFechasGeneradas();  // Forzar borrar fechas si cambia cualquier cantidad

    }

    private function resetFechasGeneradas()
    {


        PasanacoGroupDate::where('pasanaco_group_id', $this->groupId)->delete();
        $this->fechas = collect(); // SIEMPRE una colección vacía
        $this->fechasGeneradas = true;
    }

    public function guardarAsignaciones($asignaciones)
    {
        try {
            DB::beginTransaction();

            $actualizacionesRealizadas = 0;
            $errores = [];

            foreach ($asignaciones as $asignacion) {
                // Buscar el registro de fecha por su ID
                $fechaRecord = PasanacoGroupDate::where('id', $asignacion['fechaId'])
                    ->where('pasanaco_group_id', $this->groupId)
                    ->first();

                if ($fechaRecord) {
                    // Actualizar el participant_id
                    $fechaRecord->update([
                        'participant_id' => $asignacion['participantId']
                    ]);

                    $actualizacionesRealizadas++;
                } else {
                    $errores[] = "No se encontró registro para fechaId: {$asignacion['fechaId']}";
                }
            }

            DB::commit();

            // Opcional: Mostrar información de debug
            // $this->dispatch('success', "Se registraron asignaciones correctamente.");
            return redirect()->route('groups.settings', ['groupId' => $this->groupId])->with('success', 'Se registraron las asignaciones correctamente.');
        } catch (\Exception $e) {
            DB::rollBack();

            $this->dispatch('error', 'Error al guardar las asignaciones: ' . $e->getMessage());
        }
    }

    public function verificarAsignacionesCompletas()
    {
        // Contar total de fechas y fechas con participantes asignados
        $totalFechas = PasanacoGroupDate::where('pasanaco_group_id', $this->groupId)->count();
        $fechasConParticipantes = PasanacoGroupDate::where('pasanaco_group_id', $this->groupId)
            ->whereNotNull('participant_id')
            ->count();

        // Si hay fechas y todas tienen participantes asignados
        if ($totalFechas > 0 && $totalFechas === $fechasConParticipantes) {
            $this->asignacionesCompletas = true;
            $this->fechasGeneradas = false;
            // Cargar asignaciones con información del participante
            $this->asignacionesFinalizadas = PasanacoGroupDate::where('pasanaco_group_id', $this->groupId)
                ->with('participant')
                ->orderBy('date')
                ->get()
                ->map(function ($fecha, $index) {
                    return [
                        'numero' => $index + 1,
                        'fecha' => Carbon::parse($fecha->date)->format('d/m/Y'),
                        'fecha_texto' => Carbon::parse($fecha->date)->locale('es')->isoFormat('dddd, D [de] MMMM [de] YYYY'),
                        'participant_nombre' => $fecha->participant->nombre ?? 'Sin asignar',
                        'participant_email' => $fecha->participant->email ?? '',
                    ];
                })
                ->toArray();
        } else {
            $this->asignacionesCompletas = false;
            $this->asignacionesFinalizadas = [];
        }
    }

    // Método para resetear y volver a la configuración

    public function volverAConfiguracion()
    {
        try {
            DB::beginTransaction();

            // Limpiar todas las asignaciones
            PasanacoGroupDate::where('pasanaco_group_id', $this->groupId)
                ->update(['participant_id' => null]);

            DB::commit();

            $this->verificarAsignacionesCompletas();

            // Dispatch de éxito
            $this->dispatch('asignaciones-reseteadas');
        } catch (\Exception $e) {
            DB::rollBack();

            // Dispatch de error
            $this->dispatch('error-reseteo', 'Error al resetear las asignaciones: ' . $e->getMessage());
        }
    }
}
