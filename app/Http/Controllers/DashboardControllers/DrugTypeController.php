<?php

namespace App\Http\Controllers\DashboardControllers;

use App\Http\Controllers\Controller;
use App\Models\DrugType;
use Illuminate\Http\Request;

class DrugTypeController extends Controller
{
    public function index()
    {
        return DrugType::select('id', 'drug_type_title', 'drug_type_description')->with('drug')->get();
    }

    public function store(Request $request)
    {
        $input =  $request->validate([
            'drug_type_title' => 'required',
            'drug_type_description' => 'required'
        ]);

        $drugTypes = DrugType::create($input);
        return response()->json([
            'message' => 'DrugType created successfully'
        ]);
    }

    public function show($id)
    {
        $drugTypes = DrugType::findOrFail($id);
        if ($drugTypes != null) {
            return $drugTypes;
        } else {
            return response()->json([
                'message' => 'drugType not found'
            ]);
        }
    }

    public function update(Request $request, $id)
    {

        $drugTypes = DrugType::findOrFail($id);
        if ($drugTypes != null) {
            // $input =  $request->validate([
            //     'drug_type_title' => 'required',
            //     'drug_type_description' => 'required'
            // ]);

            $drugTypes->update($request->all());
            return response()->json([
                'message' => 'Drugs updated successfully'
            ]);
        } else {
            return response()->json([
                'message' => 'Drugs not found'
            ]);
        }
    }

    public function destroy($id)
    {
        $drugTypes = DrugType::findOrFail($id);

        if ($drugTypes != null) {
            $drugTypes->delete();
            // $drugTypes->drugType()->delete();
            return response()->json([
                'message' => 'DrugType deleted'
            ]);
        } else {
            return response()->json([
                'message' => 'DrugType not found'
            ]);
        }
    }
}