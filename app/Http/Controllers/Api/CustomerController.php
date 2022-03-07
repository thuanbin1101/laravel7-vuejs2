<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Intervention\Image\ImageManagerStatic as Image;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $customers = Customer::all();
        return response()->json($customers);
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
            'name' => 'required|unique:customers|max:255',
            'email' => 'required',
            'phone' => 'required|unique:customers',
        ]);
        $position = strpos($request->photo, ';'); // 15
        $sub = substr($request->photo, 0, $position); // data:image/jpeg
        $ext = explode('/', $sub)[1]; // jpeg
        $name = time() . "." . $ext; // 122121.jpeg
        $img = Image::make($request->photo)->resize(240, 200);
        $upload_path =  'backend/customer/';
        $image_url = $upload_path . $name; // backend/customer/122121.jpeg
        $img->save($image_url);


        $customer = new Customer();
        $customer->name = $request->name;
        $customer->email = $request->email;
        $customer->phone = $request->phone;
        $customer->address = $request->address;
        if ($request->photo) {
            $customer->photo = $image_url;
        }
        $customer->save();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $customer = Customer::find($id);
        return response()->json($customer);
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
        $image = $request->newphoto;
        if ($image) {
            $position = strpos($image, ';'); // 15
            $sub = substr($image, 0, $position); // data:image/jpeg
            $ext = explode('/', $sub)[1]; // jpeg
            $name = time() . "." . $ext; // 122121.jpeg
            $img = Image::make($image)->resize(240, 200);
            $upload_path =  'backend/customer/';
            $image_url = $upload_path . $name; // backend/customer/122121.jpeg
            $success = $img->save($image_url);
            if ($success) {
                $data['photo'] = $image_url;
                $img = Customer::find($id);
                $image_path = $img->photo;
                unlink($image_path);
            }
        } else {
            $oldphoto = $request->photo;
            $data['photo'] = $oldphoto;
        }
        DB::table('customers')->where('id', $id)->update($data);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $idba
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $customer = Customer::find($id);
        $photo = $customer->photo;
        if ($photo) {
            unlink($photo);
        }
        $customer->delete();
    }
}
