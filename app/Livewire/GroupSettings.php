<?php

namespace App\Livewire;

use App\Models\Participant;
use App\Models\PasanacoGroup;
use App\Models\PasanacoGroupParticipant;
use Livewire\Component;

class GroupSettings extends Component
{
    public ?int $groupId = null;
    public $groupSel;
    public array $selectedParticipants = [];
    public string $search = '';

    public function mount(int $groupId)
    {
        $this->groupId = $groupId;
        $this->groupSel = PasanacoGroup::findOrFail($groupId);
        $this->loadSelectedParticipants();
    }

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

    public function selectParticipant($participantId)
    {
        $participant = Participant::find($participantId);

        if ($participant && !collect($this->selectedParticipants)->contains('id', $participant->id)) {
            $this->selectedParticipants[] = [
                'id'     => $participant->id,
                'nombre' => $participant->nombre,
                'email'  => $participant->email,
            ];
        }
    }

    public function removeParticipant($participantId)
    {
        $this->selectedParticipants = array_values(array_filter($this->selectedParticipants, function ($p) use ($participantId) {
            return $p['id'] !== $participantId;
        }));
    }

    public function cancelParticipants()
    {
        $this->reset('selectedParticipants');
        $this->loadSelectedParticipants();
    }

    public function saveParticipants()
    {
        if (!$this->groupId) {
            return;
        }

        // Paso 1: eliminar todos los participantes actuales de este grupo
        PasanacoGroupParticipant::where('pasanaco_group_id', $this->groupId)->delete();

        // Paso 2: insertar los participantes seleccionados nuevamente (sin duplicados, porque acabamos de eliminar todo)
        foreach ($this->selectedParticipants as $participant) {
            PasanacoGroupParticipant::create([
                'pasanaco_group_id' => $this->groupId,
                'participant_id'    => $participant['id'],
                'status'           => 'active',
                'joined_at'        => now(),
            ]);
        }
        $this->reset('search');
        $this->dispatch('toast-success', 'Participantes guardados correctamente.');

        // Recargar participantes seleccionados desde BD para reflejar datos actualizados
        $this->loadSelectedParticipants();
    }

    public function render()
    {
        return view('livewire.group-settings')->layout('layouts.app');
    }
}
