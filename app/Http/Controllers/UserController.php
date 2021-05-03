<?php

namespace App\Http\Controllers;
use App\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendEmail;
use Illuminate\Http\Request;
use Auth;
use Hash;

class UserController extends Controller
{
    public function signUp(Request $request){
        
        $this->validate($request,[

            "name"=>"required|min:4,max:20",
            "email"=>"required|email|unique:users",
            "avatar" => "mimes:jpg,jpeg,png"
        ]);


        $user = new User;

        $user->name= $request->name;
        $user->email= $request->email;
        $user->user_role = 'user';        

        if($user->save()){
            return response()->json(['success' => 'Registration Successful Please wait for the Confirmation Email']);
        }
    
        else{
            return response()->json(['error' => 'Cannot Sign Up at this time']);
        }
        
    }

    public function sendEmail($id){

       $user = User::find($id);
       
       if($user){
            Mail::to($user->email)->send(new SendEmail($user));
                  
            return response()->json(['success' => "email sent successfully"]);
       }
      
       else{
           return response()->json(['error' =>"User not found"]);
       }
    }

    public function loginUser(Request $request,$id){
        
        
        if($request->pin == "123456"){
            
          $user = User::find($id);

            Auth::login($user);

            $user->update([
                'registered_at' => Carbon::now(),                
            ]);

            return response()->json(['success' => "login successfull"]);

            //return Auth::user();

        }

        else{
            return response()->json(['error' =>"incorrect pin"]);
        }
    }

    public function profileUpdate(Request $request,$id){

        $this->validate($request,[

            "username"=>"min:4,max:20",
            "email"=>"email",
            'password' => 'confirmed',
        ]);
    
            $user = User::find($id);
    
            if($user){

                $user->update([
                    'user_name' => $request->username,
                    'password' => Hash::make($request->password)
                ]);
        
                return response()->json(['success' => "profile updated"]);
            }
            else{
                return response()->json(['error' =>"User not found"]);
            }
      
    }
}
