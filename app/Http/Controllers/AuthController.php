<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\User;
use Auth;
    
class AuthController extends Controller {

    public function postLogin(Request $request)
    {
        try {
            //Retrieving users data
            $email = $request->get('email');
            $password = $request->get('password');

            $userAuthen = User::where('email', $email)->where('password', $password)->get();

            if (count($userAuthen)) {
                return $this->respond(Response::HTTP_OK, [
                    "loginStatus" => "SUCCESS",
                    "result" => $userAuthen
                ]);
            }else{
                return $this->respond(Response::HTTP_OK, [
                    "loginStatus" => "FAIL",
                    "result" => "The email or password you’ve entered doesn’t match any account."
                ]);
            }
        }
        catch(\Exception $e)
        {
            return $e->getMessage();
        }
    }    
}