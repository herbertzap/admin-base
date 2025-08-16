<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CustomsDeclaration;
use App\Models\Company;
use Illuminate\Support\Facades\Validator;

class CustomsDeclarationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $declarations = CustomsDeclaration::with(['company', 'user'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        return view('customs-declarations.index', compact('declarations'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $companies = Company::where('is_active', true)->orderBy('name')->get();
        return view('customs-declarations.create', compact('companies'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'company_id' => 'required|exists:companies,id',
            'declaration_number' => 'required|string|unique:customs_declarations,declaration_number',
            'document_type' => 'required|string',
            'declaration_date' => 'required|date',
            'customs_office' => 'required|string',
            'transport_mode' => 'required|string',
            'total_value' => 'required|numeric|min:0',
            'total_weight' => 'required|numeric|min:0',
            'description' => 'required|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $data = $request->all();
        $data['user_id'] = auth()->id();
        $data['status'] = 'draft';

        CustomsDeclaration::create($data);

        return redirect()->route('customs-declarations.index')->with('success', 'Declaración creada exitosamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $customsDeclaration = CustomsDeclaration::with(['company', 'user'])->findOrFail($id);
        return view('customs-declarations.show', compact('customsDeclaration'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $customsDeclaration = CustomsDeclaration::findOrFail($id);
        $companies = Company::where('is_active', true)->orderBy('name')->get();
        return view('customs-declarations.edit', compact('customsDeclaration', 'companies'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $customsDeclaration = CustomsDeclaration::findOrFail($id);
        
        $validator = Validator::make($request->all(), [
            'company_id' => 'required|exists:companies,id',
            'declaration_number' => 'required|string|unique:customs_declarations,declaration_number,' . $id,
            'document_type' => 'required|string',
            'declaration_date' => 'required|date',
            'customs_office' => 'required|string',
            'transport_mode' => 'required|string',
            'total_value' => 'required|numeric|min:0',
            'total_weight' => 'required|numeric|min:0',
            'description' => 'required|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $customsDeclaration->update($request->all());

        return redirect()->route('customs-declarations.index')->with('success', 'Declaración actualizada exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $customsDeclaration = CustomsDeclaration::findOrFail($id);
        $customsDeclaration->delete();

        return redirect()->route('customs-declarations.index')->with('success', 'Declaración eliminada exitosamente.');
    }
}
