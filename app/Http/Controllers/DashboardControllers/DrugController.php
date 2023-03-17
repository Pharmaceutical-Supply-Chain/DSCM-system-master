<?php

namespace App\Http\Controllers\DashboardControllers;

use App\Models\Drug;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\DrugType;

class DrugController extends Controller
{
        public function index()
    {
        return Drug::select('id', 'trade_name', 'scientific_name',
        'drug_description', 'drug_dose', 'image')->with('drugType')->get();
    }

    public function store(Request $request)
    {
        // $drug_type =DrugType::all();
        $input =  $request->validate([
            'trade_name' => 'required',
            'scientific_name' => 'required',
            'drug_description' => 'required',
            'drug_dose' => 'required',
            'drug_type_id' => 'required'
            //'image'=>'required'
            // 'image'=>'required|image'
        ]);

        $drugs = Drug::create($input);
        return response()->json([
            'message' => 'Drug created successfully'
        ]);
    }

    public function show($id)
    {
        $drugs = Drug::where('id', $id)->with('drugType')->get();
        if ($drugs != null) {
            return $drugs;
        }
        else {
            return response()->json([
                'message' => 'drugs not found'
            ]);
        }
    }

    public function update(Request $request, $id)
    {
        $drugs = Drug::where('id', $id)->with('drugType')->get();
        if ($drugs != null) {
            // $input =  $request->validate([
            //     'trade_name' => 'required',
            //     'scientific_name' => 'required',
            //     'drug_description' => 'required',
            //     'drug_dose' => 'required',
            //     'image'=>'required'
            //     // 'image'=>'required|image'
            // ]);

            $drugs->update($request->all());
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
        $drugs = Drug::findOrFail($id);

        if ($drugs != null) {
            $drugs->delete();
                return response()->json([
            'message' => 'Drugs deleted'
        ]);
        }
        else{
            return response()->json([
                'message' => 'Drugs not found'
            ]);
        }
    }

    public function getDrugsByType (DrugType $drugType)
    {
        $drugs = Drug::where('drug_type_id', $drugType->id)->with('drugType')->get();
        if ($drugs != null)
        {
            return response()->json($drugs);
        }

        return response()->json("Not Found");
    }
}