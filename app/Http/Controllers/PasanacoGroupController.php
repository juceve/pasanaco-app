<?php

namespace App\Http\Controllers;

use App\Models\PasanacoGroup;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Requests\PasanacoGroupRequest;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class PasanacoGroupController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $pasanacoGroups = PasanacoGroup::paginate();

        return view('pasanaco-group.index', compact('pasanacoGroups'))
            ->with('i', ($request->input('page', 1) - 1) * $pasanacoGroups->perPage());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $pasanacoGroup = new PasanacoGroup();

        return view('pasanaco-group.create', compact('pasanacoGroup'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PasanacoGroupRequest $request): RedirectResponse
    {
        PasanacoGroup::create($request->validated());

        return Redirect::route('pasanaco-groups.index')
            ->with('success', 'PasanacoGroup created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id): View
    {
        $pasanacoGroup = PasanacoGroup::find($id);

        return view('pasanaco-group.show', compact('pasanacoGroup'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id): View
    {
        $pasanacoGroup = PasanacoGroup::find($id);

        return view('pasanaco-group.edit', compact('pasanacoGroup'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PasanacoGroupRequest $request, PasanacoGroup $pasanacoGroup): RedirectResponse
    {
        $pasanacoGroup->update($request->validated());

        return Redirect::route('pasanaco-groups.index')
            ->with('success', 'PasanacoGroup updated successfully');
    }

    public function destroy($id): RedirectResponse
    {
        PasanacoGroup::find($id)->delete();

        return Redirect::route('pasanaco-groups.index')
            ->with('success', 'PasanacoGroup deleted successfully');
    }
}
