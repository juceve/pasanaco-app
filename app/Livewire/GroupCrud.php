<?php

namespace App\Livewire;

use App\Models\PasanacoGroup;
use Livewire\Component;
use Livewire\WithPagination;

class GroupCrud extends Component
{
    use WithPagination;

    public $search = '';
    public $sortField = 'id';
    public $sortDirection = 'desc';
    public $perPage = 5;

    public $groupId;
    public $name, $start_date, $frequency = 'monthly', $custom_days_interval, $day_of_week, $day_of_month, $amount_per_participant, $status = 'in_progress';
    public $isEditing = false;
    public $showModal = false;
    public $showModal2 = false;

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

    protected $listeners = ['deleteGroup'];

    public function deleteGroup($id)
    {
        $group = PasanacoGroup::findOrFail($id);
        $group->delete();
        $this->dispatch('toast-success', 'Grupo eliminado correctamente.');
    }

    public function create()
    {
        $this->resetForm();
        $this->isEditing = false;
        $this->showModal = true;
    }

    public function edit($id)
    {
        $group = PasanacoGroup::findOrFail($id);
        $this->groupId = $id;
        $this->name = $group->name;
        $this->start_date = $group->start_date;
        $this->frequency = $group->frequency;
        // $this->custom_days_interval = $group->custom_days_interval;
        // $this->day_of_week = $group->day_of_week;
        // $this->day_of_month = $group->day_of_month;
        $this->amount_per_participant = $group->amount_per_participant;
        $this->status = $group->status;
        $this->isEditing = true;
        $this->showModal = true;
    }

    public function store()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'amount_per_participant' => 'required|numeric|min:0',
        ]);

        PasanacoGroup::create([
            'name' => $this->name,
            'amount_per_participant' => $this->amount_per_participant,
            'status' => 'CREADO',
        ]);

        $this->showModal = false;
        $this->resetForm();
        return redirect()->route('groups')->with('success', 'Grupo creado correctamente.');
    }

    public function update()
    {
        $this->validate([
            'name' => 'required|string|max:255',
        ]);

        PasanacoGroup::findOrFail($this->groupId)->update([
            'name' => $this->name,
            'amount_per_participant' => $this->amount_per_participant,
            'status' => $this->status,
        ]);

        $this->showModal = false;
        $this->isEditing = false;
        $this->resetForm();
        $this->dispatch('toast-success', 'Grupo editado correctamente.');
    }

    public function resetForm()
    {
        $this->name = $this->start_date = $this->custom_days_interval = $this->day_of_week = $this->day_of_month = $this->amount_per_participant = '';
        $this->frequency = 'monthly';
        $this->status = 'in_progress';
        $this->groupId = null;
        $this->isEditing = false;
    }

    public function render()
    {
        $query = PasanacoGroup::query()
            ->when($this->search, function ($q) {
                $q->where('name', 'like', '%' . $this->search . '%')
                    ->orWhere('status', 'like', '%' . $this->search . '%');
            })
            ->orderBy($this->sortField, $this->sortDirection);

        $groups = $query->paginate($this->perPage);

        return view('livewire.group-crud', [
            'groups' => $groups,
        ])->layout('layouts.app');
    }
}
