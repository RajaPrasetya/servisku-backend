<?php

namespace App\Http\Controllers;

use App\Models\FormService;
use App\Http\Requests\StoreFormServiceRequest;
use App\Http\Requests\UpdateFormServiceRequest;

class FormServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreFormServiceRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(FormService $formService)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateFormServiceRequest $request, FormService $formService)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(FormService $formService)
    {
        //
    }
}
