<?php

namespace App\Http\Controllers;

use App\Models\PasanacoScheduleChange;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Requests\PasanacoScheduleChangeRequest;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class PasanacoScheduleChangeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $pasanacoScheduleChanges = PasanacoScheduleChange::paginate();

        return view('pasanaco-schedule-change.index', compact('pasanacoScheduleChanges'))
            ->with('i', ($request->input('page', 1) - 1) * $pasanacoScheduleChanges->perPage());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $pasanacoScheduleChange = new PasanacoScheduleChange();

        return view('pasanaco-schedule-change.create', compact('pasanacoScheduleChange'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PasanacoScheduleChangeRequest $request): RedirectResponse
    {
        PasanacoScheduleChange::create($request->validated());

        return Redirect::route('pasanaco-schedule-changes.index')
            ->with('success', 'PasanacoScheduleChange created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id): View
    {
        $pasanacoScheduleChange = PasanacoScheduleChange::find($id);

        return view('pasanaco-schedule-change.show', compact('pasanacoScheduleChange'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id): View
    {
        $pasanacoScheduleChange = PasanacoScheduleChange::find($id);

        return view('pasanaco-schedule-change.edit', compact('pasanacoScheduleChange'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PasanacoScheduleChangeRequest $request, PasanacoScheduleChange $pasanacoScheduleChange): RedirectResponse
    {
        $pasanacoScheduleChange->update($request->validated());

        return Redirect::route('pasanaco-schedule-changes.index')
            ->with('success', 'PasanacoScheduleChange updated successfully');
    }

    public function destroy($id): RedirectResponse
    {
        PasanacoScheduleChange::find($id)->delete();

        return Redirect::route('pasanaco-schedule-changes.index')
            ->with('success', 'PasanacoScheduleChange deleted successfully');
    }
}
