<?php

namespace App\Http\Controllers\Api;

use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Interfaces\Notification;
use App\Models\Salary;
use Illuminate\Http\Request;

class SalaryController extends Controller
{
    public function Paid(Request $request, $id)
    {
        $request->validate([
            'salary_month' => 'required',
        ]);
        $month = $request->salary_month;
        $check = DB::table('salaries')->where('employee_id', $id)->where('salary_month', $month)->first();
        if ($check) {
            return response()->json('Salary Already Paid');
        } else {
            $data = array();
            $data['employee_id'] = $id;
            $data['amount'] = $request->salary;
            $data['salary_month'] = $month;
            $data['salary_year'] = date('Y');
            $data['salary_date'] = date('d/m/Y');
            DB::table('salaries')->insert($data);
        }
    }
    public function allSalary()
    {
        $salaries = DB::table('salaries')->select('salary_month')->groupBy('salary_month')->get();
        return response()->json($salaries);
    }
    public function viewSalary($id)
    {
        $month = $id;
        $view = DB::table('salaries')->join('employees', 'salaries.employee_id', 'employees.id')->select('employees.name', 'salaries.*')
            ->where('salaries.salary_month', $month)->get();
        return response()->json($view);
    }
    public function editSalary($id)
    {
        $view = DB::table('salaries')->join('employees', 'salaries.employee_id', 'employees.id')->select('employees.name', 'employees.email', 'salaries.*')
            ->where('salaries.id', $id)->first();
        return response()->json($view);
    }
    public function updateSalary(Request $request, $id)
    {
        $request->validate([
            'salary_month' => 'required',
        ]);
        $month = $request->salary_month;
        $check = DB::table('salaries')->where('employee_id', $id)->where('salary_month', $month)->first();
        if ($check) {
            return response()->json('Salary Already Paid');
        } else {
            $data = array();
            $data['employee_id'] = $request->employee_id;
            $data['amount'] = $request->amount;
            $data['salary_month'] = $month;
            DB::table('salaries')->where('id', $id)->update($data);
        }
    }
}
