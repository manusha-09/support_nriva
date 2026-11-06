
<style>
  body{
    overflow-x: hidden;

  }
</style>
@extends('auth.layout')

 
 <!-- <div class="content-header bg-light">
      <div class="container-fluid">
        <div class="container">
          <div class="row mb-2">
            <div class="col-12 col-md-10 offset-md-1 col-lg-10 offset-lg-1">
              <div class="row">
            
     
                  <ol class="breadcrumb float-sm-right ">
                    <li class="breadcrumb-item"><a href="{{route('login')}}">Home</a></li>
                    
                  </ol>
                   <ol class="breadcrumb float-sm-right ml-2">
                    <li class="breadcrumb-item"><a href="{{route('login')}}">login</a></li>
                    
                  </ol>
                 
                  <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="">Home</a></li>
                    
                  </ol>
                  
                </div>
              </div>
           
            </div>
          </div>
        </div>
    </div> -->



<style>

  .create-btn:hover
  {
text-decoration: none;
  }
</style>

@section('content')
@if ($message = Session::get('success'))
            <div class="alert alert-dismissable alert-success">
               
                <p class="mb-0">{{ $message }}
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button></p>

            </div>
        @endif

<main class="login-form">

  <div class="container">

      <div class="row justify-content-center px-0 px-lg-5">

          <div class="col-md-6  px-0 px-lg-5">

              <div class="card">

                  <div class="card-header text-primary font-weight-bold">Login</div>

                  <div class="card-body">

  

                      <form action="{{ route('login') }}" method="POST">

                          @csrf

                          <div class="form-group row">

                              <label for="email_address" class="col-md-12 col-form-label ">E-Mail Address</label>

                              <div class="col-md-12">

                                  <input type="text" id="email_address" class="form-control" name="email" required autofocus>

                                  @if ($errors->has('email'))

                                      <span class="text-danger">{{ $errors->first('email') }}</span>

                                  @endif

                              </div>

                          </div>

  

                          <div class="form-group row">

                              <label for="password" class="col-md-12 col-form-label ">Password</label>

                              <div class="col-md-12">

                                  <input type="password" id="password" class="form-control" name="password" required>

                                  @if ($errors->has('password'))

                                      <span class="text-danger">{{ $errors->first('password') }}</span>

                                  @endif

                              </div>

                          </div>

  

                          <div class="form-group row">

                              <div class="col-md-12 ">

                                  <div class="checkbox">

                                      <label>

                                          <input type="checkbox" name="remember"> Remember Me

                                      </label>

                                  </div>

                              </div>

                          </div>
                          <div class="form-group row">
                              <div class="col-md-12 offset-md-4">
                                  <div class="checkbox">
                                      <label>
                                          <a href="{{ route('forget.password.get') }}">Reset Password</a>
                                      </label>
                                  </div>
                              </div>
                          </div>

  

                          <div class="col-12">

                              <button type="submit" class="btn btn-primary w-100">

                                  Login

                              </button>

                          </div>

                      </form>

                        

                  </div>

              </div>

          </div>

      </div>

  </div>

</main>
@include('categories.script')

@endsection