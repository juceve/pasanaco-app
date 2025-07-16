<?php

namespace App\Http\Controllers;

use App\Models\PasanacoGroupParticipant;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Requests\PasanacoGroupParticipantRequest;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class PasanacoGroupParticipantController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $pasanacoGroupParticipants = PasanacoGroupParticipant::paginate();

        return view('pasanaco-group-participant.index', compact('pasanacoGroupParticipants'))
            ->with('i', ($request->input('page', 1) - 1) * $pasanacoGroupParticipants->perPage());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $pasanacoGroupParticipant = new PasanacoGroupParticipant();

        return view('pasanaco-group-participant.create', compact('pasanacoGroupParticipant'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PasanacoGroupParticipantRequest $request): RedirectResponse
    {
        PasanacoGroupParticipant::create($request->validated());

        return Redirect::route('pasanaco-group-participants.index')
            ->with('success', 'PasanacoGroupParticipant created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id): View
    {
        $pasanacoGroupParticipant = PasanacoGroupParticipant::find($id);

        return view('pasanaco-group-participant.show', compact('pasanacoGroupParticipant'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id): View
    {
        $pasanacoGroupParticipant = PasanacoGroupParticipant::find($id);

        return view('pasanaco-group-participant.edit', compact('pasanacoGroupParticipant'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PasanacoGroupParticipantRequest $request, PasanacoGroupParticipant $pasanacoGroupParticipant): RedirectResponse
    {
        $pasanacoGroupParticipant->update($request->validated());

        return Redirect::route('pasanaco-group-participants.index')
            ->with('success', 'PasanacoGroupParticipant updated successfully');
    }

    public function destroy($id): RedirectResponse
    {
        PasanacoGroupParticipant::find($id)->delete();

        return Redirect::route('pasanaco-group-participants.index')
            ->with('success', 'PasanacoGroupParticipant deleted successfully');
    }
}
