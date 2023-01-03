<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Classes;
use App\Models\Course;
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
            'total_student' => 'nullable|numeric',
            'is_open' => 'nullable|boolean',
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
        $course = Course::where('id',$input['course_id'])->first();
        $course['total_class'] += 1;
        if ($input != null || $input['is_open'] == true) $course['available_class'] += 1;
        $course->save();
        $arr = ['status' => true,
            'message'=>'Lớp học đã lưu thành công',
            'data'=> new ClassesResource($classes)
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
        $change = false;
        $input = $request->all();
        $validator = Validator::make($input, [
            'class_name' => 'required|string',
            'total_student' => 'nullable|numeric',
            'is_open' => 'nullable|boolean',
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
        if ($class['course_id'] != $input['course_id']){
            if ($class['course_id'] != 0){
                $courseOld = Course::where('id',$class['course_id'])->first();
                $coursesNew = Course::where('id',$input['course_id'])->first();
                $courseOld['total_class'] -= 1;
                $coursesNew['total_class'] += 1;
                if ($class['is_open'] != $input['is_open']){
                    if ($class['is_open'] == true){
                        $courseOld['available_class'] -= 1;
                    }
                    else $coursesNew['available_class'] += 1;
                } else {
                    if ($input['is_open'] ==  true) {
                        $courseOld['available_class'] -= 1;
                        $coursesNew['available_class'] += 1;
                    }
                }
                $courseOld->save();
                $coursesNew->save();
            } else {
                $coursesNew = Course::where('id',$input['course_id'])->first();
                $coursesNew['total_class'] += 1;
                if ($input['is_open'] == true)
                    $coursesNew['available_class'] += 1;
                $coursesNew->save();
            }
        } else {
            $course = Course::where('id', $class['course_id'])->first();
            if ($class['is_open'] != $input['is_open']){
                if ($class['is_open'] == true)
                    $course['available_class'] -= 1;
                else $course['available_class'] += 1;
            }
            $course->save();
        }
        $class->is_open = $input['is_open'];
        $class->course_id = $input['course_id'];
        $class->start_date = $input['start_date'];
        $class->end_date = $input['end_date'];
        $class->save();
        $arr = [
            'status' => true,
            'message' => 'Lớp học cập nhật thành công',
            'data' => new ClassesResource($class)
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
        $course = Course::where('id', $class['course_id'])->first();
        if ($course != null){
            $course['total_class'] -= 1;
            if ($class['is_open'] == true)
                    $course['available_class'] -= 1;
            $course->save();
        }
        $class->delete();
        $arr = [
            'status' => true,
            'message' =>'Lớp học đã được xóa',
            'data' => [],
        ];
        return response()->json($arr, 200);
    }
}
