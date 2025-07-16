<?php

namespace App\Livewire;

use App\Models\Participant;
use App\Models\PasanacoGroupParticipant;
use Livewire\Component;

class ParticipantsModal extends Component
{
    public bool $showModal = false;
    public ?int $groupId = null;

    public array $selectedParticipants = [];
    public string $search = '';

    public function openModal(int $groupId)
    {
        $this->groupId = $groupId;
        $this->showModal = true;
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->groupId = null;
        $this->selectedParticipants = [];
        $this->search = '';
    }

    public function getAllParticipantsProperty()
    {
        return Participant::query()
            ->where('estado', 'activo')
            ->where('nombre', 'like', '%' . $this->search . '%')
            ->orderBy('nombre')
            ->get();  // Esto debe devolver una colección (iterable)
    }

    public function selectParticipant($participantId)
    {
        $participant = Participant::find($participantId);

        if ($participant && !collect($this->selectedParticipants)->contains('id', $participant->id)) {
            $this->selectedParticipants[] = [
                'id' => $participant->id,
                'nombre' => $participant->nombre,
                'email' => $participant->email,
            ];
        }
    }

    public function removeParticipant($participantId)
    {
        $this->selectedParticipants = array_values(array_filter($this->selectedParticipants, function ($p) use ($participantId) {
            return $p['id'] !== $participantId;
        }));
    }

    public function saveParticipants()
    {
        if (!$this->groupId) {
            return; // seguridad básica
        }

        foreach ($this->selectedParticipants as $participant) {
            PasanacoGroupParticipant::firstOrCreate([
                'pasanaco_group_id' => $this->groupId,
                'participant_id'    => $participant['id'],
            ], [
                'status'     => 'active',
                'joined_at'  => now(),
            ]);
        }

        $this->dispatch('participants-added');

        $this->closeModal();
    }
    protected $listeners = ['openParticipantsModal' => 'openModal'];


    public function render()
    {
        return view('livewire.participants-modal');
    }
}
