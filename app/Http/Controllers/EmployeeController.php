<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employee;
use Illuminate\Support\Facades\Redis;
use RealRashid\SweetAlert\Facades\Alert;

class EmployeeController extends Controller
{
    private function pushToRedis(Employee $emp) {
        $key = 'emp_' . $emp->nomor;
        Redis::set($key, $emp->toJson());
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $emps = Employee::get();

        $title = 'Delete?!';
        $text = "Are you sure you want to delete?";
        confirmDelete($title, $text);

        return view('employees.index', compact('emps'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('employees.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nomor' => 'required|unique:employees,nomor',
            'nama' => 'required|string|max:150',
            'jabatan' => 'nullable|string|max:200',
            'talahir' => 'nullable|date',
            'photo' => 'nullable|image|max:2048',
        ]);

        $data = $request->only(['nomor','nama','jabatan','talahir']);
        $data['created_by'] = auth()->user()->name ?? 'system';
        $data['created_on'] = now();
        $data['updated_on'] = now();

        if ($request->hasFile('photo')) {
            $path = $request->file('photo')->store('photos', 's3');
            $data['photo_upload_path'] = Storage::disk('s3')->url($path);
        }

        $emp = Employee::create($data);

        // Redis::set('emp_' . $emp->nomor, $emp->toJson());

        Alert::success('Success Title', 'Employee created successfully.');
        return redirect()->route('employees.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Employee $employee)
    {
        return view('employees.show', compact('employee'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Employee $employee)
    {
        return view('employees.edit', compact('employee'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $r, Employee $employee) {
        $r->validate([
            'nama'=>'required',
            'photo'=>'nullable|image|max:2048',
        ]);
        $data = $r->only(['nama','jabatan','talahir']);
        $data['updated_by'] = auth()->user()->name ?? 'system';
        if($r->hasFile('photo')) {
            if($employee->photo_upload_path) {
                // optional: delete previous file if known
            }
            $path = $r->file('photo')->store('photos','s3');
            $url = Storage::disk('s3')->url($path);
            $data['photo_upload_path'] = $url;
        }
        $employee->update($data);
        // $this->pushToRedis($employee);

        Alert::success('Success Title', 'Success Message');
        return redirect()->route('employees.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Employee $employee)
    {
        $employee->delete();
        // Redis::del('emp_' . $employee->nomor);

        Alert::success('Success Title', 'Success Message');
        return back();
    }
}
