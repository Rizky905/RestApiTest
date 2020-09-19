<?php


namespace App\Http\Controllers\API;


use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\User;
use Illuminate\Support\Facades\Auth;
use Validator;

class RegisterController extends BaseController{
    /**
     * Register apiz
     *
     * @return \Illuminate\Http\Response
     */

    public function login(Request $request){
        $request->validate([
            'email' => 'required|string',
            'password' => 'required|string'
        ]);
        $credentials = request(['email','password']);

        if(!Auth::attempt($credentials)){
            return response()->json([
                'message' => 'invalid email or password'
            ], 401);
        }

        $user = $request->user();
        $token = $user ->createToken('access token');
        $user->access_token = $token->accessToken;
        
        return response()->json([
            "user"=>$user
        ], 200);
    }


     public function register(Request $request){
         $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required',
            'c_password' => 'required|same:password',
         ]);

         if($validator->fails()){
             return $this->sendError('validation error', $validator->errors());
         }

        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        $user = User::create($input);
        $success['token'] =  $user->createToken('MyApp')->accessToken;
        $success['name'] =  $user->name;
         
         return $this->sendResponse($success, 'User register successfully.');

     }

   
}