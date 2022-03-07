<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Intervention\Image\ImageManagerStatic as Image;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $employees = Employee::all();
        return response()->json($employees);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:employees|max:255',
            'email' => 'required',
            'phone' => 'required|unique:employees',
        ]);
        $position = strpos($request->photo, ';'); // 15
        $sub = substr($request->photo, 0, $position); // data:image/jpeg
        $ext = explode('/', $sub)[1]; // jpeg
        $name = time() . "." . $ext; // 122121.jpeg
        $img = Image::make($request->photo)->resize(240, 200);
        $upload_path =  'backend/employee/';
        $image_url = $upload_path . $name; // backend/employee/122121.jpeg
        $img->save($image_url);


        $employee = new Employee();
        $employee->name = $request->name;
        $employee->email = $request->email;
        $employee->phone = $request->phone;
        $employee->salary = $request->salary;
        $employee->address = $request->address;
        $employee->nid = $request->nid;
        $employee->joiningdate = $request->joiningdate;
        if ($request->photo) {
            $employee->photo = $image_url;
        }
        $employee->save();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $employee = Employee::find($id);
        return response()->json($employee);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data = array();
        $data['name'] = $request->name;
        $data['email'] = $request->email;
        $data['phone'] = $request->phone;
        $data['salary'] = $request->salary;
        $data['address'] = $request->address;
        $data['nid'] = $request->nid;
        $data['joiningdate'] = $request->joiningdate;
        $image = $request->newphoto;
        if ($image) {
            $position = strpos($image, ';'); // 15
            $sub = substr($image, 0, $position); // data:image/jpeg
            $ext = explode('/', $sub)[1]; // jpeg
            $name = time() . "." . $ext; // 122121.jpeg
            $img = Image::make($image)->resize(240, 200);
            $upload_path =  'backend/employee/';
            $image_url = $upload_path . $name; // backend/employee/122121.jpeg
            $success = $img->save($image_url);
            if ($success) {
                $data['photo'] = $image_url;
                $img = Employee::find($id);
                $image_path = $img->photo;
                unlink($image_path);
            }
        } else {
            $oldphoto = $request->photo;
            $data['photo'] = $oldphoto;
        }
        DB::table('employees')->where('id', $id)->update($data);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $idba
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $employee = Employee::find($id);
        $photo = $employee->photo;
        if ($photo) {
            unlink($photo);
        }
        $employee->delete();
    }
}
