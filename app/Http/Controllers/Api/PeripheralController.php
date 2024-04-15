<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\Peripheral;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class PeripheralController extends Controller
{

    public function index()
    {
        $peripheralsWithUser = Peripheral::with('user')->get();

        $responseData = [];
        foreach ($peripheralsWithUser as $peripheral) {
            $data = [
                'id' => $peripheral->id,
                'name' => $peripheral->name,
                'type' => $peripheral->type,
                'description' => $peripheral->description,
                'status' => $peripheral->status,
            ];

            if ($peripheral->user) {
                $data['user'] = [
                    'id' => $peripheral->user->id,
                    'firstName' => $peripheral->user->firstName,
                    'lastName' => $peripheral->user->lastName,
                    'email' => $peripheral->user->email,
                    'role' => $peripheral->user->role,
                    'disponible' => $peripheral->user->disponible,
                    'acceptedByAdmin' => $peripheral->user->acceptedByAdmin,
                ];
            }

            $responseData[] = $data;
        }

        return response()->json([
            'status' => 200,
            'message' => 'Peripherals found',
            'data' => $responseData,
        ], 200);
    }
    
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'type' => 'required|string',
            'description' => 'string',
            'status' => 'required|string', // (exp: BROKEN, PENDING, CONFIRMED, FIXED)
            'id_reporteduser' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $peripheral = Peripheral::create([
            'name' =>$request->name,
            'type' =>$request->type,
            'description' =>$request->description,
            'status' =>$request->status,
            'id_reporteduser' =>$request->id_reporteduser,
        ]);
        
        if($peripheral){
            return response()->json([
                'status'=>200,
                'message'=> "périphérique créer avec succés"
            ],200);
        }else{
            return response()->json([
                'status'=>500,
                'message'=> "something went wrong"
            ],500);

        }
    }

    public function show($id)
    {
        $peripheralWithUser = Peripheral::with('user')->find($id);

        if (!$peripheralWithUser) {
            return response()->json([
                'status' => 404,
                'message' => "Peripheral not found",
            ], 404);
        }

        $responseData = [
            'id' => $peripheralWithUser->id,
            'name' => $peripheralWithUser->name,
            'type' => $peripheralWithUser->type,
            'description' => $peripheralWithUser->description,
            'status' => $peripheralWithUser->status,
        ];

        if ($peripheralWithUser->user) {
            $responseData['users'] = [
                'id' => $peripheralWithUser->user->id,
                'firstName' => $peripheralWithUser->user->firstName,
                'lastName' => $peripheralWithUser->user->lastName,
                'email' => $peripheralWithUser->user->email,
                'role' => $peripheralWithUser->user->role,
                'disponible' => $peripheralWithUser->user->disponible,
                'acceptedByAdmin' => $peripheralWithUser->user->acceptedByAdmin,
            ];
        }

        return response()->json([
            'status' => 200,
            'message' => 'Peripheral found',
            'data' => $responseData,
        ], 200);
    }


    public function getByReportedUser($id)
    {
        $peripheralsWithUser = Peripheral::with('user')
            ->where('id_reporteduser', $id)
            ->get();

        if ($peripheralsWithUser->isEmpty()) {
            return response()->json([
                'status' => 404,
                'message' => 'No peripherals reported by this user',
            ], 404);
        }

        $responseData = [];
        foreach ($peripheralsWithUser as $peripheral) {
            $data = [
                'id' => $peripheral->id,
                'name' => $peripheral->name,
                'type' => $peripheral->type,
                'description' => $peripheral->description,
                'status' => $peripheral->status,
            ];

            if ($peripheral->user) {
                $data['user'] = [
                    'id' => $peripheral->user->id,
                    'firstName' => $peripheral->user->firstName,
                    'lastName' => $peripheral->user->lastName,
                    'email' => $peripheral->user->email,
                    'role' => $peripheral->user->role,
                    'disponible' => $peripheral->user->disponible,
                    'acceptedByAdmin' => $peripheral->user->acceptedByAdmin,
                ];
            }

            $responseData[] = $data;
        }

        return response()->json([
            'status' => 200,
            'message' => 'Peripherals found',
            'data' => $responseData,
        ], 200);
    }

    public function edit($id)
    {
        $peripheral=Peripheral::find($id);
        if($peripheral){
            return response()->json([
                'status'=>200,
                'message'=>$peripheral
            ],200);
        }else{
            return response()->json([
                'status'=>404,
                'message'=>"n'est pas trouver"
            ],404);
        }
    }
    

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'type' => 'required|string',
            'description' => 'string',
            'status' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $peripheral = Peripheral::find($id);

        if (!$peripheral) {
            return response()->json(['message' => 'Peripheral not found'], 404);
        }

        $peripheral->update($request->all());
        return response()->json($peripheral);
    }

    public function destroy($id)
    {
        $peripheral = Peripheral::find($id);

        if (!$peripheral) {
            return response()->json(['message' => 'Peripheral not found'], 404);
        }

        $peripheral->delete();

        return response()->json(['message' => 'Peripheral deleted successfully']);
    }
}
