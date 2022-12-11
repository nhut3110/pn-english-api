<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\Classes;
use App\Http\Resources\Course as CourseResource;
use Illuminate\Support\Facades\Validator;

class CourseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $courses = Course::all();
        return response()->json($courses);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

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
            'course_name' => 'required|string',
            'total_class' => 'required|numeric',
            'available_class' => 'nullable|numeric',
            'description' => 'nullable|string',
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
        $courses = Course::create($input);
        $arr = ['status' => true,
            'message'=>"Khóa học đã lưu thành công",
            'data'=> new CourseResource($courses)
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
        $courses = Course::where('id',$id)->first();
        return response()->json($courses);
    }

           /**
     * Display the specified resource by class.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function showByCourse($id)
    {
        $classes = Classes::where('course_id',$id)->get();
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
    public function update(Request $request,  Course $course)
    {
        $input = $request->all();
        $validator = Validator::make($input, [
            'course_name' => 'required|string',
            'total_class' => 'required|numeric',
            'available_class' => 'nullable|numeric',
            'description' => 'nullable|string',
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
        $course->course_name = $input['course_name'];
        $course->total_class = $input['total_class'];
        $course->available_class = $input['available_class'];
        $course->description = $input['description'];
        $course->start_date = $input['start_date'];
        $course->end_date = $input['end_date'];
        $course->save();
        $arr = [
            'status' => true,
            'message' => 'Khóa học cập nhật thành công',
            'data' => new CourseResource($course)
        ];
        return response()->json($arr, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Course $course)
    {
        $course->delete();
        $arr = [
            'status' => true,
            'message' =>'Khóa học đã được xóa',
            'data' => [],
        ];
        return response()->json($arr, 200);
    }
}
