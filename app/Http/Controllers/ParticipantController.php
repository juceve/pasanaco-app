<?php

namespace App\Http\Controllers;

use App\Models\Participant;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Requests\ParticipantRequest;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ParticipantController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $participants = Participant::paginate();

        return view('participant.index', compact('participants'))
            ->with('i', ($request->input('page', 1) - 1) * $participants->perPage());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $participant = new Participant();

        return view('participant.create', compact('participant'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ParticipantRequest $request): RedirectResponse
    {
        Participant::create($request->validated());

        return Redirect::route('participants.index')
            ->with('success', 'Participant created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id): View
    {
        $participant = Participant::find($id);

        return view('participant.show', compact('participant'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id): View
    {
        $participant = Participant::find($id);

        return view('participant.edit', compact('participant'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ParticipantRequest $request, Participant $participant): RedirectResponse
    {
        $participant->update($request->validated());

        return Redirect::route('participants.index')
            ->with('success', 'Participant updated successfully');
    }

    public function destroy($id): RedirectResponse
    {
        Participant::find($id)->delete();

        return Redirect::route('participants.index')
            ->with('success', 'Participant deleted successfully');
    }
}
