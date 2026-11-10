@include('navbar')
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
   @if ( Auth::user()->isSupportAdmin())
   
  @include('sidemenu')

  @else
  
  @include('users.usersidemenu')

  @endif
    <div class="content-wrapper">
    
    <section class="content">
      <div class="container-fluid">
       
        <div class="row">
            <div class="col-lg-12 margin-tb">
                <div class="pull-right mt-2">
                 
                    <a href="{{ URL::previous() }}" class="btn btn-info">Back</a>
                  
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
                  <div class="col-12 col-md-4 col-lg-4" >
                  </div>

            <div class="col-12 col-md-8 col-lg-8" >
                 <div class=" col-12 col-md-8 col-lg-8"> 
               <h5 class="font-weight-bold">Ticket Details</h5>
            </div>
        <form action="{{ url('update-ticket/'.$ticket->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="form-group mb-3">

                                        <div class="card mt-2">
                                      <h5 class="card-header" style="font-weight: bold;">Ticket Subject</h5>
                                      <div class="card-body">

                                        <input type="text" name="subject" value="{{$ticket->subject}}" class="form-control">
                                       
                                      </div>
                                    </div>
                            
                           
                        </div>

                        <div class="form-group mb-3">
                         <div class="card">
                                  <h5 class="card-header"  style="font-weight: bold;"> Ticket Desciption</h5>
                                  <div class="card-body">
                                  
                                    <textarea id="editor1" class="form-control" id="inputPassword" name="description" ><?php echo $ticket->description; ?></textarea>
                                   
                                  </div>
                                </div>
                        </div>

                        <div class="form-group mb-3">
                            <label for="">Committee Name</label>
                            
                             <select  class="form-control" name="department">
                            <option value="{{$ticket->department}}" >{{$ticket->department}}</option>
                            @foreach ($department as $departments)
                            <option value="{{$departments->department}}">{{$departments->department}}
                                
                            </option>
                            @endforeach
                        </select>
                        </div>
                         
                        <div class="form-group mb-3">
                            <label for="">Category Name</label>
                            
                            <select  class="form-control custom-select"  name="category">
                            <option value="{{$ticket->category}}">{{$ticket->category}}</option>
                            @foreach ($categories as $category)
                            <option value="{{$category->name}}">{{$category->name}}
                                
                            </option>
                            @endforeach
                        </select>

                        </div>
                       <!--  <div class="form-group mb-3">
                            <label for="">Project Name</label>
                            <input type="text" name="project" value="{{$ticket->project}}" class="form-control">
                        </div> -->
                        
                        <div class="form-group mb-3">
                            <label for="">Issue priority</label>
                           
                             <select class="form-control" name="issue_priority">
                                    <option value="{{$ticket->issue_priority}}">{{$ticket->issue_priority}}</option>
                                    <option value="High">High</option>
                                    <option value="Medium">Medium</option>
                                    <option value="Low">Low</option>
                                  </select>
                        </div>
                        <div class="form-group mb-3">
                          <label for="" class="col-sm-2 col-form-label">Issue Status</label>
                         
                            <select class="form-control" name="issue_status">
                            <option value="{{$ticket->issue_status}}">{{$ticket->issue_status}}</option>
                            <option value="pending">Pending</option>
                            <option value="assigned">Assigned</option>
                            <option value="inprogress">In Progress</option>
                            <option value="completed">Completed</option>
                            </select>
                       
                        </div>
                        
                         <div class="form-group mb-3">
                <label for="">Upload file   :</label><span>{{$ticket->file_path}}</span>
                <input type="file"  class="form-control" name="files[]" value="" id="upload_file1"/ >
              </div>

                        
                        <div class="form-group mb-3">
                            <button type="submit" class="btn btn-primary">Update Ticket</button>
                        </div>


                    </form>
                </div>
            </div>
        </div>



    </section>
</div>

@include('categories.script')
<script src="https://cdn.ckeditor.com/4.22.1/standard/ckeditor.js"></script> 
<script type="text/javascript">
 CKEDITOR.replace( 'editor1' );
 </script>
</body>
</html>

