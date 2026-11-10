
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
  <script src="https://cdn.ckeditor.com/4.22.1/standard/ckeditor.js"></script> 
    <link rel="stylesheet" href="{{asset('dist/css/style.css')}}">
  <script src="https://cdn.ckeditor.com/ckeditor5/38.0.1/classic/ckeditor.js"></script>
    <link rel="stylesheet" href="{{asset('plugins/dropzone/min/dropzone.min.css')}}">
    <script src="{{asset('plugins/dropzone/min/dropzone.min.js')}}"></script>
</head>
 <div class="container-fluid bg-light">
      <div class="row">
        <div class="col-12 col-sm-6 col-md-6 col-lg-6 my-auto">
          <nav class="navbar navbar-expand-sm">
          <div class="">
   <a class="navbar-brand" href="#">
    <img src="{{asset('storage/'.str_replace('public/', '', $logodetails->logoimage))}}" alt="Logo" style="width:50px;">
  </a>

<span class="brand-text font-weight-bold" style="font-size:20px;">{{$logodetails->name}}</span>
</div>
</nav>
</div>
            <div class="col-12 col-sm-6 col-md-6 col-lg-6 my-auto">
                <div class="d-flex justify-content-end">
                 <div class="mr-2">
                          <form class="searchid" action="{{route('searchticket')}}" method="GET">
                       
              <input type="text" placeholder="Search by TicketId" name="search" required>
              <button type="submit"><i class="fa fa-search"></i></button>
            </form>
                                
                </div>
       
    
                 <div class="text-right">
                <a  class=" btn btn-info" href="{{route('login')}}">Login</a>
                                
                </div>
            </div>
            </div>
</div>
</div> 

<style>
label{
    font-weight: normal !important;
}
  .create-btn:hover
  {
text-decoration: none;
  }
</style>
<body>

    <!-- Content Header (Page header) -->
    <div>
      <div class="container-fluid">
        <div class="container">
          <div class="row mb-2">
            <div class="col-12">
                 <div class="text-center">
                    <h3 class=" m-0">Create Ticket</h3>
                 </div>
               
                 <!--  <ol class="breadcrumb float-sm-right ">
                    <li class="breadcrumb-item"><a href="{{route('login')}}">Home</a></li>
                    
                  </ol>
                   <ol class="breadcrumb float-sm-right ml-2">
                    <li class="breadcrumb-item"><a href="{{route('login')}}">login</a></li>
                    
                  </ol> -->
                 
                  <!-- <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="">Home</a></li>
                    
                  </ol> -->
                 
                </div>
              </div>
              <!-- /.col -->
            </div>
          </div><!-- /.row -->
        </div><!-- /.container -->
      </div><!-- /.container-fluid -->
  
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid px-5">
        <!-- Small boxes (Stat box) -->
        <div class="row">
            <div class="col-lg-12 margin-tb">
                <div class="pull-right">
                    <h5 class=""></h5>
                </div>
               
            </div>
        </div>
        @if ($message = Session::get('success'))
            <div class="alert alert-dismissable alert-success">
               
                <p class="mb-0">{{ $message }}
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button></p>

            </div>
        @endif

              
              
      
        <div class="row">
          <div class="col-12 col-md-12">
               <form action="{{route('ticketfile')}}" method="post" enctype="multipart/form-data" data-ticket-create>
              @csrf
              @include('tickets.create-errors')
                    <div class="row">
                        <div class="col-12 col-md-6 col-lg-6 pr-0 pr-md-4">
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group row mb-2">
                                        <label for="text" class="col-sm-3 col-form-label">Select Project<span class="text-red">*</span></label>
                                        <div class="col-sm-9">
                                            <select  class="form-control ml-1" name="project" required>
                                                <option value="">-- Select Project --</option>
                                             
                                                @foreach ($projects as $project)
                                                <option value="{{$project->name}}" {{ old('project') == $project->name ? 'selected' : '' }}>{{$project->name}}
                                                    
                                                </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group row mb-2">
                                        <label for="text" class="col-sm-3 col-form-label">Select Category <span class="text-red">*</span></label>
                                        <div class="col-sm-9">
                                            <select  class="form-control ml-1 custom-select"  name="category" required>
                                                <option value="">-- Select category --</option>
                                                @foreach ($categories as $category)
                                                <option value="{{$category->name}}" {{ old('category') == $category->name ? 'selected' : '' }}>{{$category->name}}
                                                    
                                                </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                @include('tickets.assignment-fields')
                                <div class="col-12">
                                    <div class="form-group row mb-2">
                                        <label for="text" class="col col-sm-3 col-form-label">Issue Priority</label>
                                        <div class="col-sm-9">
                                             <select class="form-control ml-1" name="issue_priority">
                                                <option value="">--Select--</option>
                                                <option value="High">High</option>
                                                <option value="Medium">Medium</option>
                                                <option value="Low">Low</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group row mb-2">
                                        <label for="text" class="col-sm-3 col-form-label">Created By <span class="text-red">*</span></label>                                
                                        <div class="col-sm-9">
                                            <input type="text" name="name" class="form-control ml-1" placeholder="Enter name of the issue reporter" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group row mb-2">
                                        <label for="text" class="col-sm-3 col-form-label">Email<span class="text-red">*</span></label>
                                        <div class="col-sm-9">
                                            <input type="email" name="email" class="form-control ml-1" placeholder="Enter Email of the issue reporter" required>
                                        </div>
                                    </div>
                                </div>

                                 <div class="col-12">
                                    <div class="form-group row mb-2">
                                        <label for="text" class="col-sm-3 col-form-label">Your Committee</label>
                                        <div class="col-sm-9">
                                            <select  class="form-control ml-1" name="committee">
                                                <option value="" >-- Select Your Committee--</option>
                                                    @foreach ($department as $departments)
                                                <option value="{{$departments->name}}">{{$departments->name}}
                                                    
                                                </option>
                                                  @endforeach
                                           
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group row mb-2">
                                       <label for="text" class=" col col-sm-3 col-form-label">Issue Status</label>
                                        <div class="col-sm-9">
                                             <select class="form-control ml-1" name="issue_status">
                                                <option value="pending" selected >Pending</option>
                                                <option value="assigned">Assigned</option>
                                                <option value="inprogress">In Progress</option>
                                                <option value="completed">Completed</option>
                                              </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group row mb-2">
                                        <label class="col-sm-3 col-form-label">Upload ScreenShots</label>
                                        <div class="col-sm-9">
                                            <input type="file"  class="form-control-file ml-1 dropzone" name="files[]" id="upload_file1 imageUpload"/>
                                           
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 visible">
                           
                                </div>
                                <div class="col-12">
                                    <div class="form-group row mb-2">
                                       <div id="moreImageUpload" class="pl-2"></div>
                                        <div class="clear"></div>
                                          <div id="moreImageUploadLink" class="col-lg-3">
                                            <a href="javascript:void(0);" id="attachMore">Attach another file</a>
                                          </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-6 col-lg-6 border-left pl-0 pl-md-4">
                            <div class="form-group row mb-2">
                                <label for="text" class="col-12 col-form-label">Subject<span class="text-red">*</span></label>
                                <div class="col-12">
                                    <input type="text" class="form-control" id="inputPassword" name="subject" placeholder="Subject" value="{{ old('subject') }}" required>
                                </div>
                            </div>
                            <div class="form-group row mb-2">
                                <label class="col-12 col-form-label">Description <span class="text-red">*</span></label>
                                <div class="col-12">
                                    <textarea id="editor1" class="form-control" name="description" required>{{ old('description') }}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--  <div class="row">
                        <div class="col-12 col-md-12 col-lg-6 visible">
                           
                        </div>
                        <div class="col-12 col-md-12 col-lg-6">
                            <div class="form-group row mb-2">
                               <div id="moreImageUpload" class="pl-2"></div>
                                <div class="clear"></div>
                                  <div id="moreImageUploadLink" class="pl-2">
                                    <a href="javascript:void(0);" id="attachMore">Attach another file</a>
                                  </div>
                            </div>
                        </div>
                    </div> -->
                    <div class="col-12 mb-4">
                      <div class="text-right">
                        <button type="submit" class="btn btn-info">Create ticket</button>
                      </div>
                    </div>
                </form>
    </div>

        </div>
        <!-- /.row -->
        <!-- Main row -->
     
        <!-- /.row (main row) -->
      </div><!-- /.container-fluid -->
    </section> 
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->



  <!-- Modal -->
 



  

  
</div>

@include('categories.script')
<script type="text/javascript">
      CKEDITOR.replace( 'editor1' );
    $(document).ready(function() {
    $("input[id^='upload_file']").each(function() {
    var id = parseInt(this.id.replace("upload_file", ""));
    $("#upload_file" + id).change(function() {
    if ($("#upload_file" + id).val() != "") {
    $("#moreImageUploadLink").show();
    }
    });
     });
    });
     $(document).ready(function() {
    var upload_number = 2;
    $('#attachMore').click(function() {
    //add more file
    var moreUploadTag = '';
    moreUploadTag += '<div class="element form-group row"><label class="col-sm-4 col-form-label" for="upload_file"' + upload_number + '>Upload File ' + upload_number + '</label>';
    moreUploadTag += '<input type="file" name="files[]"  class="col-sm-6 form-control-file"/>';
    moreUploadTag += ' <div class="col-lg-2"><a class="btn btn-danger" href="javascript:del_file(' + upload_number + ')" style="cursor:pointer;" onclick="return confirm("Are you really want to delete ?")">Delete </a></div></div>';
    $('<dl id="delete_file' + upload_number + '">' + moreUploadTag + '</dl>').fadeIn('slow').appendTo('#moreImageUpload');
    upload_number++;
      });
    });

 function del_file(eleId) {
  var ele = document.getElementById("delete_file" + eleId);
  ele.parentNode.removeChild(ele);
}
</script>
<script src="{{ asset('dist/js/ticket-create-validation.js') }}" defer></script>
