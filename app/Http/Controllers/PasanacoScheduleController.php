<?php

namespace App\Http\Controllers;

use App\Models\PasanacoSchedule;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Requests\PasanacoScheduleRequest;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class PasanacoScheduleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $pasanacoSchedules = PasanacoSchedule::paginate();

        return view('pasanaco-schedule.index', compact('pasanacoSchedules'))
            ->with('i', ($request->input('page', 1) - 1) * $pasanacoSchedules->perPage());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $pasanacoSchedule = new PasanacoSchedule();

        return view('pasanaco-schedule.create', compact('pasanacoSchedule'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PasanacoScheduleRequest $request): RedirectResponse
    {
        PasanacoSchedule::create($request->validated());

        return Redirect::route('pasanaco-schedules.index')
            ->with('success', 'PasanacoSchedule created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id): View
    {
        $pasanacoSchedule = PasanacoSchedule::find($id);

        return view('pasanaco-schedule.show', compact('pasanacoSchedule'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id): View
    {
        $pasanacoSchedule = PasanacoSchedule::find($id);

        return view('pasanaco-schedule.edit', compact('pasanacoSchedule'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PasanacoScheduleRequest $request, PasanacoSchedule $pasanacoSchedule): RedirectResponse
    {
        $pasanacoSchedule->update($request->validated());

        return Redirect::route('pasanaco-schedules.index')
            ->with('success', 'PasanacoSchedule updated successfully');
    }

    public function destroy($id): RedirectResponse
    {
        PasanacoSchedule::find($id)->delete();

        return Redirect::route('pasanaco-schedules.index')
            ->with('success', 'PasanacoSchedule deleted successfully');
    }
}
