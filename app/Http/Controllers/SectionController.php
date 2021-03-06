<?php

namespace App\Http\Controllers;

use App\Http\Requests\SectionRequest;
use App\Models\Section;

class SectionController extends Controller
{

    public function __construct()
    {
        $this->middleware('permission:sections_index', ['only' => ['index']]);
        $this->middleware('permission:create_section', ['only' => ['create', 'store']]);
        $this->middleware('permission:edit_section', ['only' => ['edit', 'update']]);
        $this->middleware('permission:delete_section', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sections = Section::all();
        return view('sections.index', compact('sections'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SectionRequest $request)
    {
        Section::create($request->validated());
        session()->flash('success', __('notifications.success_create_section'));
        return redirect()->route('sections.index');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Section  $section
     * @return \Illuminate\Http\Response
     */
    public function update(SectionRequest $request, Section $section)
    {
        $section->update($request->validated());
        session()->flash('success', __('notifications.success_update_section'));
        return redirect()->route('sections.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Section  $section
     * @return \Illuminate\Http\Response
     */
    public function destroy(Section $section)
    {
        $section->delete();
        session()->flash('success', __('notifications.success_delete_section'));
        return redirect()->route('sections.index');
    }
}
