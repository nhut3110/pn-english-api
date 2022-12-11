<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Classes;
use App\Http\Resources\Classes as ClassesResource;
use Illuminate\Support\Facades\Validator;

class ClassController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $classes = Classes::all();
        return response()->json($classes);
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
            'class_name' => 'required|string',
            'total_student' => 'required|numeric',
            'is_open' => 'required|boolean',
            'description' => 'nullable|string',
            'course_id' => 'nullable|numeric',
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
        $classes = Classes::create($input);
        $arr = ['status' => true,
            'message'=>"Lớp học đã lưu thành công",
            'data'=> new StudentResource($classes)
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
        $classes = Classes::where('id',$id)->first();
        return response()->json($classes);
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
    public function update(Request $request, Classes $class)
    {
        $input = $request->all();
        $validator = Validator::make($input, [
            'class_name' => 'required|string',
            'total_student' => 'required|numeric',
            'is_open' => 'required|boolean',
            'description' => 'nullable|string',
            'course_id' => 'nullable|numeric',
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
        $class->class_name = $input['class_name'];
        $class->total_student = $input['total_student'];
        $class->is_open = $input['is_open'];
        $class->class_email = $input['class_email'];
        $class->description = $input['description'];
        $class->course_id = $input['course_id'];
        $class->start_date = $input['start_date'];
        $class->end_date = $input['end_date'];
        $class->save();
        $arr = [
            'status' => true,
            'message' => 'Lớp học cập nhật thành công',
            'data' => new StudentResource($class)
        ];
        return response()->json($arr, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Classes $class)
    {
        $class->delete();
        $arr = [
            'status' => true,
            'message' =>'Lớp học đã được xóa',
            'data' => [],
        ];
        return response()->json($arr, 200);
    }
}
