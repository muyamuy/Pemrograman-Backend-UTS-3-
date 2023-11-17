<?php

namespace App\Http\Controllers;

use App\Models\employees;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class EmployeesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $employees = employees::orderBy('time', 'DESC')->get();
        $response = [
            'message' => 'Get All Resource',
            'data' => $employees
        ];

        return response()->json($response, 200);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $validator = Validator::make($request->all(),[
            'name' => ['required'],
            'gender' => ['required'],
            'phone' => ['required', 'numeric'],
            'addres' => ['required'],
            'email' => ['required', 'email'],
            
            'hired_on' => ['required']
        ]);

        if($validator->fails()){
            return response()->json($validator->errors(), 422);
        }

        try {
            $employees = employees::create($request->all());
            $response = [
                'message' => 'Data created',
                'data' => $employees
            ];

            return response()->json($response, 200);
        } catch (QueryException $e) {
            return response()->json([
                'message' => "Failed" . $e->errorInfo
            ]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
        $employees = employees::findOrFail($id);
        $response = [
            'message' => 'Detail of data',
            'data' => $employees
        ];

        return response()->json($response, 200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        $employees = employees::findOrFail($id);

        $validator = Validator::make($request->all(),[
            'name' => ['required'],
            'gender' => ['required'],
            'phone' => ['required'],
            'addres' => ['required'],
            'email' => ['required', 'email'],
            'status'=>['required'],
            'hired_on' => ['required']
        ]);

        if($validator->fails()){
            return response()->json($validator->errors(), 422);
        }

        try {
            $employees->update($request->all());
            $response = [
                'message' => 'Data updated',
                'data' => $employees
            ];

            return response()->json($response, 201);
        } catch (QueryException $e) {
            return response()->json([
                'message' => "Failed" . $e->errorInfo
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //menghapus dengan id
        $employees = Employees::find($id);

        if (!$employees) {
            return response()->json(['message' => 'Employees not found'], 404);
        }

        $employees->delete();

        $data = [
            'message' => 'Employees has been deleted successfully',
        ];

        return response()->json($data, 200);
    }
     // Menambahkan method untuk mencari karyawan berdasarkan nama
     
}
