<?php

namespace App\Livewire;

use App\Models\Participant;
use Livewire\Component;
use Livewire\WithPagination;
use function Livewire\Volt\{on};

class ParticipantsCrud extends Component
{
    use WithPagination;

    public $search = '';
    public $sortField = 'nombre';
    public $sortDirection = 'asc';
    public $perPage = 5;

    public $participantId;
    public $nombre, $email, $celular, $cedula, $direccion, $estado = 'activo';
    public $isEditing = false;
    public $showModal = false;

    protected $updatesQueryString = ['search', 'page', 'sortField', 'sortDirection'];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingPerPage()
    {
        $this->resetPage();
    }

    public function sortBy($field)
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortField = $field;
            $this->sortDirection = 'asc';
        }
        $this->resetPage();
    }

    protected $listeners = ['deleteParticipant'];

    public function deleteParticipant($id)
    {
        $participant = Participant::findOrFail($id);
        $participant->delete();
        $this->dispatch('toast-success','Participante eliminado correctamente.');
    }


    public function create()
    {
        $this->resetForm();
        $this->isEditing = false;
        $this->showModal = true;
    }

    public function edit($id)
    {
        $participant = Participant::findOrFail($id);
        $this->participantId = $id;
        $this->nombre = $participant->nombre;
        $this->email = $participant->email;
        $this->celular = $participant->celular;
        $this->cedula = $participant->cedula;
        $this->direccion = $participant->direccion;
        $this->estado = $participant->estado;
        $this->isEditing = true;
        $this->showModal = true;
    }

    public function store()
    {
        $this->validate([
            'nombre' => 'required|string|max:255',
            'celular' => 'required|string|max:20',
            'email' => 'nullable|email|max:255',
            'estado' => 'required|in:activo,inactivo',
        ]);

        Participant::create([
            'nombre' => $this->nombre,
            'celular' => $this->celular,
            'email' => $this->email,
            'estado' => $this->estado,
            'cedula' => $this->cedula,
            'direccion' => $this->direccion,
        ]);

        $this->showModal = false;
        $this->dispatch('toast-success', 'Participante creado correctamente.');
        $this->resetForm();
    }

    public function update()
    {
        $this->validate([
            'nombre' => 'required|string|max:255',
            'celular' => 'required|string|max:20',
            'email' => 'nullable|email|max:255',
            'estado' => 'required|in:activo,inactivo',
        ]);

        Participant::findOrFail($this->participantId)->update([
            'nombre' => $this->nombre,
            'celular' => $this->celular,
            'email' => $this->email,
            'estado' => $this->estado,
            'cedula' => $this->cedula,
            'direccion' => $this->direccion,
        ]);

        $this->showModal = false;
        $this->isEditing = false;
        $this->resetForm();
    }

    public function resetForm()
    {
        $this->nombre = $this->email = $this->celular = $this->cedula = $this->direccion = '';
        $this->estado = 'activo';
        $this->participantId = null;
        $this->isEditing = false;
    }

    public function render()
    {
        $query = Participant::query()
            ->when($this->search, function ($q) {
                $q->where('nombre', 'like', '%' . $this->search . '%')
                    ->orWhere('celular', 'like', '%' . $this->search . '%')
                    ->orWhere('email', 'like', '%' . $this->search . '%');
            })
            ->orderBy($this->sortField, $this->sortDirection);

        $participants = $query->paginate($this->perPage);

        return view('livewire.participants-crud', [
            'participants' => $participants,
        ])->layout('layouts.app');
    }
}
