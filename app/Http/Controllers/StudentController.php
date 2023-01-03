<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\Classes;
use App\Http\Resources\StudentResource as StudentResource;
use Illuminate\Support\Facades\Validator;


class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $students = Student::all();
        return response()->json($students);
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
        $input = $request->all();
        $validator = Validator::make($input, [
            'full_name' => 'required|string',
            'student_phone' => 'required|string',
            'parent_phone' => 'required|string',
            'student_email' => 'required|string',
            'age' => 'required|numeric',
            'address' => 'required|string',
            'description' => 'nullable|string',
            'current_class_id' => 'nullable|numeric',
            'is_paid' => 'nullable|boolean',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after:start_date',
        ]);
        if($validator->fails()){
            $arr = [
            'success' => false,
            'message' => 'Lỗi kiểm tra dữ liệu',
            'data' => $validator->errors()
            ];
            return response()->json($arr, 200);
        }
        $students = Student::create($input);
        if ($input['current_class_id'] != null){
            $class = Classess::where('id',$input['current_class_id'])->first();
            $class['total_student'] += 1;
            $class->save();
        }
        $arr = ['status' => true,
            'message'=>"Học viên đã lưu thành công",
            'data'=> new StudentResource($students)
        ];
        return response()->json($arr, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $students = Student::where('id',$id)->first();
        return response()->json($students);
    }

       /**
     * Display the specified resource by class.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function showByClass($id)
    {
        $students = Student::where('current_class_id',$id)->get();
        return response()->json($students);
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
    public function update(Request $request, Student $student)
    {
        $input = $request->all();
        $validator = Validator::make($input, [
            'full_name' => 'required|string',
            'student_phone' => 'required|string',
            'parent_phone' => 'required|string',
            'student_email' => 'required|string',
            'age' => 'required|numeric',
            'address' => 'required|string',
            'description' => 'nullable|string',
            'current_class_id' => 'nullable|numeric',
            'is_paid' => 'nullable|boolean',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after:start_date',
        ]);
        if($validator->fails()){
            $arr = [
            'success' => false,
            'message' => 'Lỗi kiểm tra dữ liệu',
            'data' => $validator->errors()
            ];
            return response()->json($arr, 200);
        }
        $student->full_name = $input['full_name'];
        $student->student_phone = $input['student_phone'];
        $student->parent_phone = $input['parent_phone'];
        $student->student_email = $input['student_email'];
        $student->age = $input['age'];
        $student->address = $input['address'];
        $student->description = $input['description'];
        if ($student['current_class_id'] != $input['current_class_id']){
            if ($student['current_class_id'] != 0){
                $classOld = Classess::where('id',$student['current_class_id'])->first();
                $classNew = Classess::where('id',$input['current_class_id'])->first();
                $classOld["total_student"] -= 1;
                $classNew["total_student"] += 1;
                $classOld->save();
                $classNew->save();
            } else {
                $classNew = Classess::where('id',$input['current_class_id'])->first();
                $classNew["total_student"] += 1;
                $classNew->save();
            }
        }
        $student->current_class_id = $input['current_class_id'];
        $student->is_paid = $input['is_paid'];
        $student->start_date = $input['start_date'];
        $student->end_date = $input['end_date'];
        $student->save();
        $arr = [
            'status' => true,
            'message' => 'Học viên cập nhật thành công',
            'data' => new StudentResource($student)
        ];
        return response()->json($arr, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Student $student)
    {
        $student->delete();
        $arr = [
            'status' => true,
            'message' =>'Học viên đã được xóa',
            'data' => [],
        ];
        return response()->json($arr, 200);
    }
}
