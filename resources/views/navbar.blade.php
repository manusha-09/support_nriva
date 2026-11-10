<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Support Ticketing System</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{asset('plugins/fontawesome-free/css/all.min.css')}}">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Tempusdominus Bootstrap 4 -->
  <link rel="stylesheet" href="{{asset('plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css')}}">
  <!-- iCheck -->
  <link rel="stylesheet" href="{{asset('plugins/icheck-bootstrap/icheck-bootstrap.min.css')}}">
  <!-- JQVMap -->
  <link rel="stylesheet" href="{{asset('plugins/jqvmap/jqvmap.min.css')}}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{asset('dist/css/adminlte.min.css')}}">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="{{asset('plugins/overlayScrollbars/css/OverlayScrollbars.min.css')}}">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="{{asset('plugins/daterangepicker/daterangepicker.css')}}">
  <!-- summernote -->
  <link rel="stylesheet" href="{{asset('plugins/summernote/summernote-bs4.min.css')}}">
  <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
  <link rel="stylesheet" href="{{asset('dist/css/style.css')}}">
   {{--  dropbox CDN  --}}
    <link rel="stylesheet" href="{{asset('plugins/dropzone/min/dropzone.min.css')}}">
    <script src="{{asset('plugins/dropzone/min/dropzone.min.js')}}"></script>
<script defer src="{{ asset('dist/js/delete-confirmation.js') . '?v=' . filemtime(public_path('dist/js/delete-confirmation.js')) }}"></script>
</head>
<style>
  body{
    overflow-x: hidden;
	font-size:15px;
  }
 /* .table-responsive{
    height:75vh;


  }*/
  .table-responsive {
 width: 100%;

 overflow: auto;
}
table tr td:first-child {
 position: sticky;
 width: 10px;
 left: 0;

 color: #3f6791;
 z-index: 9;
 cursor: pointer;
 font-size: 17px;
/* background-color: white;*/
/*   box-shadow: 0px 3px 11px -3px #7c7c7c;*/
/*       border-radius: 4px;*/
  border-spacing:5px;

}
table tr th:first-child {
 position: sticky !important;
 width: 50px !important;
 left: 0;

 color:#3f6791;
 z-index: 10;
}
tr.table-success {
 position: sticky;
 left: 0;
 z-index: 10;
  background: #fff !important;
}
tr.table-success {
 top: 0px !important;
 position: sticky !important;
}
.table-success,
.table-success > td,
.table-success > th {
 background-color: #c3e6cb;
}
#sidebar{
  z-index: 99999;
}

</style>

<body class="hold-transition sidebar-mini layout-fixed sidebar-collapse">
<div class="wrapper">

  <!-- Preloader -->
  <div class="preloader flex-column justify-content-center align-items-center">
    <img class="animation__shake" src="{{asset('load_image.png')}}" alt="" height="60" width="60">
 
  </div>

  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light ">
    <!-- Left navbar links -->
    <ul class="navbar-nav">

      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
     
     
      
    </ul>
   <!-- -->

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <!-- Navbar Search -->
      <li class="nav-item">
        
      
      </li>
        <li class="nav-item pr-3">
              @if ($message = Session::get('success'))
            <div class="alert alert-dismissable alert-info mb-0 py-2">
               
                <p class="mb-0" style="line-height: 22px;">{{ $message }}
                <button type="button" class="close pl-1" data-dismiss="alert" aria-hidden="true">&times;</button></p>

            </div>
                @endif
         </li>
     

  
      <!-- Notifications Dropdown Menu -->
      <li class="nav-item">
                
                  <a href="{{route('createticket')}}" class="font-weight-bold nav-link btn btn-success text-white py-1" style="line-height: 27px;">Create&nbsp;Ticket</a>
      
                  </li> 
      <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="">
          <i class="far fa-bell"></i>
          <span class="badge badge-warning navbar-badge">{{count($counttickets)}}</span>
        </a>
        
        <div class="dropdown-menu dropdown-menu-sm dropdown-menu-right">
          <span class="dropdown-item dropdown-header"></span>
      
   <div class="dropdown-divider"></div>
  <a href="{{route('notifies')}}" class="dropdown-item ">
       <i class="fas mr-2 "> Mark All Read</i><a>
         
          <div class="dropdown-divider"></div> 
           @foreach ($counttickets as $counter)
        <a href="{{route('notify',$counter->id)}}" class="dropdown-item">
         
         
            <i class="fas mr-2"> {{$counter->data}}</i>
            <span class="float-right text-muted text-sm"></span>
            
          </a>
          @endforeach
          <div class="dropdown-divider"></div>
         <!--  <a href="{{route('logout')}}" class="dropdown-item">
            <i class="fas fa-file mr-2"></i>logout
            <span class="text-muted text-sm"></span>
          </a> -->
          <!-- <div class="dropdown-divider"></div>
          <a href="" class="dropdown-item dropdown-footer"></a>
        </div> -->
      </li>
     <!--  <li class="nav-item">
        <a class="nav-link" data-widget="fullscreen" href="#" role="button">
          <i class="fas fa-expand-arrows-alt"></i>
        </a>
      </li>
       -->
    </ul>
  </nav>
