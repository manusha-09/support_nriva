<?php

  

namespace App\Http\Controllers;

  

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;

use Session;

use App\Models\User;
use App\Models\department;
use Illuminate\Support\Str;
use Carbon\Carbon; 


use Mail;
use App\Mail\MailNotify;


use Hash;
use DB;

  

class AuthController extends Controller

{

    /**

     * Write code on Method

     *

     * @return response()

   use AuthenticatesUsers;
    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    // protected $redirectTo;
    public function adminindex()
    {
        if(Auth::user()->role){
           
            $this->redirectTo = '/admin';
        //     return $this->redirectTo;
        // //     return redirect()->route('admin');
        }
       // return view('admin');
    }

    public function index()

    {
        if(Auth::user()){

                   if(Auth::user()->id == 1270){

            return redirect()->intended('admin');
                    }else{
                         return redirect()->intended('member');
                     }

        }
        return view('auth.login');

    }  

      

    /**

     * Write code on Method

     *

     * @return response()

     */

    public function registration()

    {

        return view('auth.registration');

    }

    //  public function authenticate(Request $request)
    // {
    //    // dd($request->all());
    //     $credentials = $request->validate([
    //         'email' => ['required', 'email'],
    //         'password' => ['required'],
    //     ]);
 
    //     if (Auth::attempt($credentials)) {
    //         $request->session()->regenerate();
 
    //         return redirect()->intended('dashboard');
    //     }
 
    //     return back()->withErrors([
    //         'email' => 'The provided credentials do not match our records.',
    //     ]);
    // }
    // public function logout(Request $request)
    // {
    //     Auth::logout();
     
    //     $request->session()->invalidate();
     
    //     $request->session()->regenerateToken();
     
    //     return redirect('/');
    // }

      

    /**

     * Write code on Method

     *

     * @return response()

     */

    public function postLogin(Request $request)

    {
        $email=$request->email;
       
        $data=department::get();

        $dep_email = department::where('committee_email',$email)->first();
        //dd($dep_email);
     
        $request->validate([

            'email' => 'required',

            'password' => 'required',

        ]);

   

        $credentials = $request->only('email', 'password');
     $user = \App\Models\User::where('email', $credentials['email'])->first();
if ($user && (Hash::check($credentials['password'], $user->password2) || Hash::check($credentials['password'], $user->password))) {
        Auth::login($user);
    $user = Auth::user();

   
    if ($user->id == 1270) {
        return redirect()->intended('/admin')
            ->withSuccess('Welcome Technology Chair (Admin)');
    }
                    elseif(!empty($dep_email)){

                         return redirect()->intended('user_committee')

                        ->withSuccess('');


                    }
                        else{
                        return redirect()->intended('member')

                        ->withSuccess('');
                    }

        }

  

        return redirect("login")->with('success','Oppes! You have entered invalid credentials');

    }

      

    /**

     * Write code on Method

     *

     * @return response()

     */

    // public function postRegistration(Request $request)

    // {  

    //     $request->validate([

    //         'name' => 'required',

    //         'email' => 'required|email|unique:users',

    //         'password' => 'required|min:6',

    //     ]);

           

    //     $data = $request->all();

    //     $check = $this->create($data);

         

    //     return redirect("auth.dashboard")->withSuccess('Great! You have Successfully loggedin');

    // }

    

    /**

     * Write code on Method

     *

     * @return response()

     */

    public function dashboard()

    {

        if(Auth::check()){

            return view('auth.dashboard');

        }

  

        return redirect("home")->withSuccess('Opps! You do not have access');

    }
    public function logouts(Request $request) {

        Auth::logout();
  Session::flush();
        return redirect('/');
    }
    public function removesession(Request $request){
 $request->session()->forget('priority');
  $request->session()->forget('date_from');
    $request->session()->forget('department'); 
     $request->session()->forget('date_to');  
     $request->session()->forget('status');
    $request->session()->forget('category');

        
    }

    

    /**

     * Write code on Method

     *

     * @return response()

     */

    public function Add(Request $data)

    {
          $data->validate([
            'Role' => 'required',

            'name' => 'required',

            'email' => 'required|email|unique:users',

            'password' => 'required|min:6',

        ]);

       User::create([

        'Role'=> $data['Role'],
        'name' => $data['name'],

        'email' => $data['email'],

        'password' => Hash::make($data['password']),

        

      ]);

       return redirect("createusers")->withSuccess('You have Successfully registered');


    }

    

    /**

     * Write code on Method

     *

     * @return response()

     */

    public function logout() {

        Session::flush();

        Auth::logout();

  

        return Redirect('auth.login');

    }
     public function showForgetPasswordForm()
      {
         return view('auth.forgetPassword');
      }
  
      /**
       * Write code on Method
       *
       * @return response()
       */
      public function submitForgetPasswordForm(Request $request)
      {
          $request->validate([
              'email' => 'required|email|exists:users',
          ]);
  
          $token = Str::random(64);
  
          DB::table('password_resets')->insert([
              'email' => $request->email, 
              'token' => $token, 
              'created_at' => Carbon::now()
            ]);
  
          Mail::send('email.forgetPassword', ['token' => $token], function($message) use($request){
              $message->to($request->email);
              $message->subject('Reset Password');
          });
  
          return back()->with('message', 'We have e-mailed your password reset link!');
      }
      /**
       * Write code on Method
       *
       * @return response()
       */
      public function showResetPasswordForm($token) { 
         return view('auth.forgetPasswordLink', ['token' => $token]);
      }
  
      /**
       * Write code on Method
       *
       * @return response()
       */
      public function submitResetPasswordForm(Request $request)
      {
          $request->validate([
              'email' => 'required|email|exists:users',
              'password' => 'required|string|min:6|confirmed',
              'password_confirmation' => 'required'
          ]);
  
          $updatePassword = DB::table('password_resets')
                              ->where([
                                'email' => $request->email, 
                                'token' => $request->token
                              ])
                              ->first();
  
          if(!$updatePassword){
              return back()->withInput()->with('error', 'Invalid token!');
          }
  
          $user = User::where('email', $request->email)
                      ->update(['password' => Hash::make($request->password)]);
 
          DB::table('password_resets')->where(['email'=> $request->email])->delete();
  
          return redirect('/login')->with('message', 'Your password has been changed!');
      }

}