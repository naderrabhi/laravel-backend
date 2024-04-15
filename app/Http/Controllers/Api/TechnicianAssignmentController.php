<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\TechnicianAssignment;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class TechnicianAssignmentController extends Controller
{

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id_technician' => 'required|string',
            'id_peripheral' => 'required|string',
            'confirmed' => 'required|boolean',
            'fixed' => 'required|boolean',
            // 'confirmed_at' => 'string',
            // 'fixed_at' => 'string',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $assignment = TechnicianAssignment::create([
            'id_technician' =>$request->id_technician,
            'id_peripheral' =>$request->id_peripheral,
            'confirmed' =>$request->confirmed,
            'fixed' =>$request->fixed,
            'confirmed_at' =>$request->confirmed_at,
            'fixed_at' =>$request->fixed_at,
        ]);
        
        if($assignment){
            return response()->json([
                'status'=>200,
                'message'=> "assignment créer avec succés"
            ],200);
        }else{
            return response()->json([
                'status'=>500,
                'message'=> "something went wrong"
            ],500);

        }
    }

    public function index()
{
    $assignments = TechnicianAssignment::with('peripheral', 'technician')->get();

    $responseData = [];

    foreach ($assignments as $assignment) {
        $data = [
            'id' => $assignment->id,
            'created_at' => $assignment->created_at,
            'updated_at' => $assignment->updated_at,
            'id_technician' => $assignment->id_technician,
            'id_peripheral' => $assignment->id_peripheral,
            'confirmed' => $assignment->confirmed,
            'fixed' => $assignment->fixed,
            'confirmed_at' => $assignment->confirmed_at,
            'fixed_at' => $assignment->fixed_at,
        ];

        if ($assignment->technician) {
            $data['technician'] = $assignment->technician->toArray();
        } else {
            $data['technician'] = null;
        }

        if ($assignment->peripheral) {
            $data['peripheral'] = $assignment->peripheral->toArray();
        } else {
            $data['peripheral'] = null;
        }

        $responseData[] = $data;
    }

    return response()->json([
        'status' => 200,
        'message' => 'Assignments retrieved successfully',
        'data' => $responseData,
    ], 200);
}

    public function show($id)
    {
        $assignment = TechnicianAssignment::with('peripheral', 'technician')->find($id);

        if (!$assignment) {
            return response()->json(['message' => 'Assignment not found'], 404);
        }

        return response()->json([
            'id' => $assignment->id,
            'created_at' => $assignment->created_at,
            'updated_at' => $assignment->updated_at,
            'id_technician' => $assignment->id_technician,
            'id_peripheral' => $assignment->id_peripheral,
            'confirmed' => $assignment->confirmed,
            'fixed' => $assignment->fixed,
            'confirmed_at' => $assignment->confirmed_at,
            'fixed_at' => $assignment->fixed_at,
            'technician' => $assignment->technician ? $assignment->technician->toArray() : null,
            'peripheral' => $assignment->peripheral ? $assignment->peripheral->toArray() : null,
        ]);
    }

    public function getByTechnician($id)
    {
        $assignments = TechnicianAssignment::with('technician', 'peripheral')->where('id_technician', $id)->get();

        if ($assignments->isEmpty()) {
            return response()->json(['message' => 'No assignments found for this technician'], 404);
        }

        $responseData = [];
        foreach ($assignments as $assignment) {
            $data = [
                'id' => $assignment->id,
                'created_at' => $assignment->created_at,
                'updated_at' => $assignment->updated_at,
                'id_technician' => $assignment->id_technician,
                'id_peripheral' => $assignment->id_peripheral,
                'confirmed' => $assignment->confirmed,
                'fixed' => $assignment->fixed,
                'confirmed_at' => $assignment->confirmed_at,
                'fixed_at' => $assignment->fixed_at,
                'technician' => $assignment->technician ? $assignment->technician->toArray() : null,
                'peripheral' => $assignment->peripheral ? $assignment->peripheral->toArray() : null,
            ];
            $responseData[] = $data;
        }

        return response()->json($responseData);
    }

    public function getByPeripheral($id)
    {
        $assignments = TechnicianAssignment::with('technician', 'peripheral')->where('id_peripheral', $id)->get();

        if ($assignments->isEmpty()) {
            return response()->json(['message' => 'No assignments found for this peripheral'], 404);
        }

        $responseData = [];
        foreach ($assignments as $assignment) {
            $data = [
                'id' => $assignment->id,
                'created_at' => $assignment->created_at,
                'updated_at' => $assignment->updated_at,
                'id_technician' => $assignment->id_technician, // Optional
                'id_peripheral' => $assignment->id_peripheral, // Optional
                'confirmed' => $assignment->confirmed,
                'fixed' => $assignment->fixed,
                'confirmed_at' => $assignment->confirmed_at,
                'fixed_at' => $assignment->fixed_at,
                'technician' => $assignment->technician ? $assignment->technician->toArray() : null,
                'peripheral' => $assignment->peripheral ? $assignment->peripheral->toArray() : null,
            ];
            $responseData[] = $data;
        }

        return response()->json($responseData);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'created_at' => 'nullable|date',
            'updated_at' => 'nullable|date',
            'id_technician' => 'nullable|integer|exists:users,id',
            'id_peripheral' => 'nullable|integer|exists:peripherals,id',
            'confirmed' => 'nullable|boolean',
            'fixed' => 'nullable|boolean',
            // 'confirmed_at' => 'nullable|string',
            // 'fixed_at' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $assignment = TechnicianAssignment::find($id);

        if (!$assignment) {
            return response()->json(['message' => 'Assignment not found'], 404);
        }

        $assignment->update($request->all());
        return response()->json($assignment);
    }

    public function destroy($id)
    {
        $assignment = TechnicianAssignment::find($id);

        if (!$assignment) {
            return response()->json(['message' => 'Assignment not found'], 404);
        }

        $assignment->delete();

        return response()->json(['message' => 'Assignment deleted successfully']);
    }
}
