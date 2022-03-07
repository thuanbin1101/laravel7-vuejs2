<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function todayOrder()
    {
        $data = date("d/m/Y");
        $orders = DB::table('orders')->join('customers', 'orders.customer_id', 'customers.id')->where('orders.order_date', $data)->select("customers.name", "orders.*")->orderBy('orders.id', 'DESC')->get();
        return response()->json($orders);
    }
    public function allOrder()
    {
        $orders = DB::table('orders')->join('customers', 'orders.customer_id', 'customers.id')->select("customers.name", "orders.*")->orderBy('orders.id', 'DESC')->get();
        return response()->json($orders);
    }
    public function orderDetails($id)
    {
        $order = DB::table('orders')
            ->join('customers', 'orders.customer_id', 'customers.id')->where('orders.id', $id)->select("customers.name", "customers.phone", "customers.address", "orders.*")->first();
        return response()->json($order);
    }
    public function orderDetailsAll($id)
    {
        $details = DB::table('order_details')
            ->join('products', 'order_details.product_id', 'products.id')->where('order_details.order_id', $id)->select("products.product_name", "products.product_code", "products.image", "order_details.*")->get();
        return response()->json($details);
    }
    public function searchOrder(Request $request)
    {
        $dateSearch = $request->date;
        $newdate = new DateTime($dateSearch);
        $done = $newdate->format("d/m/Y");
        $order = DB::table('orders')
            ->join('customers', 'orders.customer_id', 'customers.id')->where('orders.order_date', $done)->select("customers.name","orders.*")->get();
        return response()->json($order);
    }
}
