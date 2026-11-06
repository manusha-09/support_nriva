 @if(Auth::user()->Role==1)

  @include('navbar')

@else
  @include('users.usernavbar')

@endif 
 <script src="https://cdn.ckeditor.com/4.22.1/standard/ckeditor.js"></script> 
  @if(Auth::user()->Role==1)
  
  @include('sidemenu')

@else
  @include('users.usersidemenu')

@endif 
<style>
label{
    font-weight: normal !important;
}
  .create-btn:hover
  {
text-decoration: none;
  }
</style>
@if(session('error'))
<div class="alert alert-danger">
    {{ session('error') }}
</div>
@endif
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
           <h5 style="font-weight: bold; color: #3f6791; font-size:17px;" class="mb-0">Create Ticket</h5>
          </div><!-- /.col -->
          
          <!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <!-- Small boxes (Stat box) -->
        <div class="row">
          
          <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12 margin-tb">
                <div class="pull-right">
                    <h5 class=""></h5>
                </div>
               
            </div>
        </div>
       

  <div class="row">
          <div class="col-12 col-md-12">
               <form action="{{route('ticketfile')}}" method="post" enctype="multipart/form-data"  >
              @csrf
                    <div class="row">
                        <div class="col-12 col-md-6 col-lg-6 pr-0 pr-md-4">
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group row mb-2">
                                        <label for="text" class="col-sm-3 col-form-label">Select Project<span class="text-red">*</span></label>
                                        <div class="col-sm-9">
                                            <select  class="form-control ml-1" name="project" required>
                                              
                                                @foreach ($projects as $project)
                                                <option value="{{$project->name}}">{{$project->name}}
                                                    
                                                </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group row mb-2">
                                        <label for="text" class="col-sm-3 col-form-label">Select Category<span class="text-red">*</span></label>
                                        <div class="col-sm-9">
                                            <select  class="form-control ml-1 custom-select"  name="category" required>
                                                <option selected>-- Select category --</option>
                                                @foreach ($categories as $category)
                                                <option value="{{$category->name}}">{{$category->name}}
                                                    
                                                </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group row mb-2">
                                        <label for="text" class="col-sm-3 col-form-label">Assign To</label>
                                        <div class="col-sm-9">
                                           <select class="form-control ml-1" name="department" id="department">
                                                <option value="" >-- Committee--</option>
                                                @foreach ($department as $departments)
                                           <option value="{{ $departments->name }}">
    {{ $departments->name }}
</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                 <div class="col-12">
                                    <div class="form-group row mb-2">
                                        <label for="text" class="col-sm-3 col-form-label">Assign To</label>
                                        <div class="col-sm-9">
                                            <select class="form-control ml-1" name="c_id" id="chapter">
                                                <option value="" >-- Select Chapter--</option>
                                             
                                                @foreach ($chapter as $chapters)
                                                <option value="{{$chapters->chapter_id}}">{{$chapters->chapter_name}}
                                                    
                                                </option>
                                                  @endforeach
                                           
                                           
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
    <small class="text-danger ml-2">
        Select either Committee OR Chapter.
        Do not select both.
    </small>
</div>
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
                                <!-- <div class="col-12">
                                    <div class="form-group row mb-2">
                                        <label for="text" class="col-sm-3 col-form-label">Created By<span class="text-red">*</span></label>                                
                                        <div class="col-sm-9">
                                            <input type="text" name="name" class="form-control ml-1" placeholder="Enter name of the issue reporter" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group row mb-2">
                                        <label for="text" class="col-sm-3 col-form-label">Email <span class="text-red">*
                                        </span></label>
                                        <div class="col-sm-9">
                                            <input type="email" name="email" class="form-control ml-1" placeholder="Enter Email of the issue reporter" required>
                                        </div>
                                    </div>
                                </div> -->
                                <div class="col-12">
                                    <div class="form-group row mb-2">
                                       <label for="text" class=" col col-sm-3 col-form-label">Issue Status</label>
                                        <div class="col-sm-9">
                                             <select class="form-control ml-1" name="issue_status">
                                                <option value="pending" selected >Pending</option>
                                                <option value="assigned">Assigned</option>
                                                <option value="inprogress">In Progress</option>
                                                <option value="completed">Completed</option>
                                                <option value="rejected">Rejected</option>
                                <option value="needs_more_info">Needs More Info</option>
                                              </select>
                                        </div>
                                    </div>
                                </div>
                                 <div class="col-12">
                                    <div class="form-group row mb-2">
                                        <label for="text" class="col-sm-3 col-form-label">Your Committee</label>
                                        <div class="col-sm-9">
     <select name="committee" class="form-control">
        <option value="">Select Committee</option>

        @foreach($userCommittees as $committee)
            <option value="{{ $committee->name }}">
                {{ $committee->name }}
            </option>
        @endforeach

    </select>                               </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group row mb-2">
                                        <label class="col-sm-3 col-form-label">Upload ScreenShots</label>
                                        <div class="col-sm-9">
                                            <input type="file"  name="files[]" id="imageUpload" multiple>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 visible">
                           
                                </div>
                                <div class="col-12">
                                    <div class="form-group row mb-2">
                                       <div id="moreImageUpload" class="pl-2"></div>
                                        <div class="clear"></div>
                                          <div id="moreImageUploadLink" class="pl-2">
                                            <a href="javascript:void(0);" id="attachMore">Attach another file</a>
                                          </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-6 col-lg-6 border-left pl-0 pl-md-4">
                            <div class="form-group row mb-2">
                                <label for="text" class="col-12 col-form-label">Subject <span class="text-red">*</span></label>
                                <div class="col-12">
                                    <input type="text" class="form-control" id="inputPassword" name="subject" placeholder="Subject" required>
                                </div>
                            </div>
                            <div class="form-group row mb-2">
                                <label class="col-12 col-form-label">Description</label>
                                <div class="col-12">
                                    <textarea id="editor1" class="form-control" id="inputPassword" name="description" 
                                    required></textarea>
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
               




                
        </body>

        
       
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
 



  

  

 

 


 
<script type="text/javascript">
  $(".departmentedit").click(function(){

       var id = $(this).data('id');
    var name = $(this).data('name');
  $('#department_id').val(id); 
     $('#department').val(name); 
    

    
  });
   // $(document).ready(function () {
  
   //          /*------------------------------------------
   //          --------------------------------------------
   //          Country Dropdown Change Event
   //          --------------------------------------------
   //          --------------------------------------------*/
   //          $('#categorydropdown').on('change', function () {
   //              var idcategory = this.value;
   //              $("#categorydropdown").html('');
   //              $.ajax({
   //                  url: "{{url('category')}}",
   //                  type: "POST",
   //                  data: {
   //                      category_id: idcategory,
   //                      _token: '{{csrf_token()}}'
   //                  },
   //                  dataType: 'json',
   //                  success: function (result) {
   //                      $('#categorydropdown').html('<option value="">-- Select category --</option>');
   //                      $.each(result.categories, function (key, value) {
   //                          $("#categorydropdown").append('<option value="' + value
   //                              .id + '">' + value.name + '</option>');
   //                      });
                        
   //                  }
   //              });
   //          });
  
</script>
  
<script type="text/javascript">
        Dropzone.options.imageUpload = {
             maxFilesize: 12,
              renamefile: function(file) 
            {
            var dt = new Date();
            var time = dt.gettime();
         
           return time+"-"+file.name;  
        };
     
         acceptedFiles: ".jpeg,.jpg,.png,.gif",
            addRemoveLinks: true,
            timeout: 60000,
             success: function (file, response) {
                console.log(response);
            },
            error: function (file, response) {
                return false;
            }
        };
</script>
<script>

           
    CKEDITOR.replace( 'editor1' );
             
  
                </script>
                <script>

$(document).ready(function () {

    $('#department').change(function () {

        if ($(this).val() != '') {

            $('#chapter').val('');
            $('#chapter').prop('disabled', true);

        } else {

            $('#chapter').prop('disabled', false);
        }

    });

    $('#chapter').change(function () {

        if ($(this).val() != '') {

            $('#department').val('');
            $('#department').prop('disabled', true);

        } else {

            $('#department').prop('disabled', false);
        }

    });

});

</script>
                @include('categories.script')
                </div>
                

</body>
</html>


	
