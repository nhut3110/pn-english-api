<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Account;
use App\Http\Resources\Account as AccountResource;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class AccountController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $account = Account::all();
        return response()->json($account);
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
            'name' => 'required|string',
            'username' => 'required|string|unique:account',
            'password' => 'required|string',
            'account_type' => 'required|string',
        ]);
        if($validator->fails()){
            $arr = [
            'success' => false,
            'message' => 'Lỗi kiểm tra dữ liệu',
            'data' => $validator->errors()
            ];
            return response()->json($arr, 200);
        }
        $input['password'] = Hash::make($input['password']);
        $account = Account::create($input);
        $arr = [
            'status' => true,
            'message'=>"Tài khoản đã lưu thành công",
            'token' => $account->createToken("API TOKEN")->plainTextToken,
            'data'=> new AccountResource($account)
        ];
        return response()->json($arr, 201);
    }

    /**
     *
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request)
    {
        $input = $request->all();
        $validator = Validator::make($input, [
            'username' => 'required|string',
            'password' => 'required|string',
        ]);
        if($validator->fails()){
            $arr = [
            'success' => false,
            'message' => 'Lỗi kiểm tra dữ liệu',
            'data' => $validator->errors()
            ];
            return response()->json($arr, 200);
        }
        $login = [
            'username' => $request->username,
            'password' => $request->password
        ];
        if (!Auth::attempt($login)){
            $arr = [
            'success' => false,
            'message' => 'Tên đăng nhập hoặc mật khẩu không đúng',
            'data' => ""
            ];
            return response()->json($arr, 200);
        }
        $account = Account::where('username', $request->username)->first();
        $arr = [
            'status' => true,
            'message'=>"Tài khoản đăng nhập thành công",
            'token' => $account->createToken("API TOKEN")->plainTextToken,
            'data'=> ""
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
        $account = Account::where('id',$id)->first();
        return response()->json($account);
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
    public function update(Request $request, Account $account)
    {
        $input = $request->all();
        $validator = Validator::make($input, [
            'name' => 'required|string',
            'username' => 'required|string|unique',
            'password' => 'required|string',
            'account_type' => 'required|string',
        ]);
        if($validator->fails()){
            $arr = [
            'success' => false,
            'message' => 'Lỗi kiểm tra dữ liệu',
            'data' => $validator->errors()
            ];
            return response()->json($arr, 200);
        }
        $account->name = $input['name'];
        $account->username = $input['username'];
        $account->password = Hash::make($input['password']);
        $account->account_type = $input['account_type'];
        $account->save();
        $arr = [
            'status' => true,
            'message' => 'Tài khoản cập nhật thành công',
            'data' => new AccountResource($account)
        ];
        return response()->json($arr, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Account $account)
    {
        $account->delete();
        $arr = [
            'status' => true,
            'message' =>'Tài khoản đã được xóa',
            'data' => [],
        ];
        return response()->json($arr, 200);
    }
}
