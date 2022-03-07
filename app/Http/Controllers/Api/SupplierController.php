<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Intervention\Image\ImageManagerStatic as Image;

class SupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $suppliers = Supplier::all();
        return response()->json($suppliers);
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
            'name' => 'required|unique:suppliers|max:255',
            'email' => 'required',
            'phone' => 'required|unique:suppliers',
        ]);
        $position = strpos($request->photo, ';'); // 15
        $sub = substr($request->photo, 0, $position); // data:image/jpeg
        $ext = explode('/', $sub)[1]; // jpeg
        $name = time() . "." . $ext; // 122121.jpeg
        $img = Image::make($request->photo)->resize(240, 200);
        $upload_path =  'backend/supplier/';
        $image_url = $upload_path . $name; // backend/supplier/122121.jpeg
        $img->save($image_url);


        $supplier = new Supplier();
        $supplier->name = $request->name;
        $supplier->email = $request->email;
        $supplier->phone = $request->phone;
        $supplier->shopname = $request->shopname;
        $supplier->address = $request->address;
        if ($request->photo) {
            $supplier->photo = $image_url;
        }
        $supplier->save();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $supplier = Supplier::find($id);
        return response()->json($supplier);
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
        $data['address'] = $request->address;
        $data['shopname'] = $request->shopname;
        $image = $request->newphoto;
        if ($image) {
            $position = strpos($image, ';'); // 15
            $sub = substr($image, 0, $position); // data:image/jpeg
            $ext = explode('/', $sub)[1]; // jpeg
            $name = time() . "." . $ext; // 122121.jpeg
            $img = Image::make($image)->resize(240, 200);
            $upload_path =  'backend/supplier/';
            $image_url = $upload_path . $name; // backend/supplier/122121.jpeg
            $success = $img->save($image_url);
            if ($success) {
                $data['photo'] = $image_url;
                $img = Supplier::find($id);
                $image_path = $img->photo;
                unlink($image_path);
            }
        } else {
            $oldphoto = $request->photo;
            $data['photo'] = $oldphoto;
        }
        DB::table('suppliers')->where('id', $id)->update($data);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $idba
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $supplier = Supplier::find($id);
        $photo = $supplier->photo;
        if ($photo) {
            unlink($photo);
        }
        $supplier->delete();
    }
}
