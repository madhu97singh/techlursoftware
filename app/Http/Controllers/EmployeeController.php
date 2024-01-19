<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\EmployeeForm;
use App\Models\Employee;
use File;
use DateTime;
use Carbon\Carbon;

class EmployeeController extends Controller
{
    public function index()
    {
        // $employees = Employee::latest()->paginate(5);
        $employees = Employee::paginate(5);

        return view('employees.index', compact('employees'))
            ->with('i', (request()->input('page', 1) - 1) * 5);
    }

    public function store(Request $request)
    { 
        $validator = \Validator::make($request->all(), [
            'name' => 'required|min:3',
            'dob' => 'required',
            'salary' => 'required',
            'joining_date' => 'required',
            'relieving_date' => 'required|after:joining_date',
            'contact_number' => 'required|digits:10|unique:employees',
        ]);
        
        if ($validator->fails())
        {
            return response()->json(['errors'=>$validator->errors()->all()]);
        }

        $dateFrom = Carbon::parse($request->joining_date);
        $dateTo = Carbon::parse($request->relieving_date);
        $interval = $dateFrom->diff($dateTo);
        $experience = $interval->format('%y years %m months');

        $employee= new Employee();
        $employee->name=$request->name;
        $employee->dob=$request->dob;
        $employee->salary=$request->salary;
        $employee->joining_date=$request->joining_date;
        $employee->relieving_date=$request->relieving_date;
        $employee->contact_number=$request->contact_number;
        $employee->status='active';
        $employee->save();
   
        return response()->json(['success'=>'Data is successfully added']);
    }

    public function edit(request $request)
    {
        // dd($request->id);
        $employee = Employee::where(['id' => $request->id])->first();
        $employees = Employee::latest()->paginate(5);
        return view('employees.index', compact('employee','employees'));
    }

    public function update(Request $request, $id)
    { 
        // dd($request->all());
        $validator = \Validator::make($request->all(), [
            'name' => 'required|min:3',
            'dob' => 'required',
            'salary' => 'required',
            'joining_date' => 'required',
            'relieving_date' => 'required|after:joining_date',
            'contact_number' => 'required|digits:10|unique:employees,contact_number,'.$id,
        ]);
        
        if ($validator->fails())
        {
            return response()->json(['errors'=>$validator->errors()->all()]);
        }

        $dateFrom = Carbon::parse($request->joining_date);
        $dateTo = Carbon::parse($request->relieving_date);
        $interval = $dateFrom->diff($dateTo);
        $experience = $interval->format('%y years %m months');

        $employee = Employee::find($id);

        $employee->name=$request->name;
        $employee->dob=$request->dob;
        $employee->salary=$request->salary;
        $employee->joining_date=$request->joining_date;
        $employee->relieving_date=$request->relieving_date;
        $employee->contact_number=$request->contact_number;
        $employee->status='active';
        $employee->save();
   
        return response()->json(['success'=>'Data updated successfully']);
    }

    public function destroy($id)
    {
        $employee=Employee::find($id);
        if($employee)
        {
            $employee->delete();
            $employeearr['status'] = "success";
        }else{
            $employeearr['status'] = "fail";
        }
        return json_encode($employeearr);
        exit;
    }

    public function status($userId)
    {
        $employee = Employee::find($userId);
        if ($employee->status == 'active') {
            $employee->status = 'inactive';
            $employee->save();
        }else{
            $employee->status = 'active';
            $employee->save();
        }
        return response()->json(['message' => 'Employee status toggled successfully']);
    }
}
