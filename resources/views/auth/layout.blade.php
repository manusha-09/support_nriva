<!DOCTYPE html>

<html>

<head>

    <title>Support Ticketing System</title>
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
    <style type="text/css">

      

    </style>

</head>

<body>

    

 <div class=" container-fluid bg-light px-0">

      <div class="row">
        <div class="col-12 col-md-8 col-lg-6 my-auto">
          <nav class="navbar navbar-expand-sm ">
       
   <a class="navbar-brand" href="#">
     <img src="{{asset('storage/'.preg_replace('#^public/#', '', $logodetails->logoimage))}}" alt="Logo" style="width:50px;">

  </a>

<span class="brand-text font-weight-bold" style="font-size:20px;">{{$logodetails->name}}</span>

</nav>
</div>
<div class="col-12 col-md-4 col-lg-6 my-auto pr-4">
    <div class="d-flex justify-content-end">
     <div class="mr-2">
                          <form class="searchid" action="{{route('searchticket')}}" method="GET">
                          
              <input type="text" placeholder="Search by TicketId" name="search">
              <button type="submit"><i class="fa fa-search"></i></button>
            </form>
                                
                </div>
   <div >
     <a  class=" btn btn-info" href="{{url('/')}}">Create Ticket</a>
   </div>
</div>

  </div>
</div>
</div>


@yield('content')

     

</body>

</html>