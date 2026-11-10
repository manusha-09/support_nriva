
@include('navbar')
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  @include('sidemenu')

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
   <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h5 class="m-0"></h5>
          </div>
         
         
        </div><!-- /.row -->
        
      </div><!-- /.container-fluid -->
  </div>

   
    <section class="content">
      <div class="container-fluid">
    
        <div class="row">
          
         
            <div class="col-lg-12 ">
                
                <div class="pull-right mb-2">
                    <a class="btn btn-success btn-lg" data-toggle="modal" data-target="#myModal" href=""> Add Chapter</a>
                </div>
            </div>
        </div>
    <div class="row">
      <div class="col-lg-12">
        <table id="dataTable" width="100%" class="table  table-bordered table-hover">
            <thead>
                <tr>
                    <th>S.No</th>
                   
                    <th>Chapetr Name</th>
                    <th>Chapter Email</th>
                    
                    <th width="280px">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($chapters as $chapter)
                    <tr>
                        <td>{{ $chapter->chapter_id}}</td>
                       

                        <td>{{ $chapter->chapter_name }}</td>
                          <td> 
                            
                          {{ $chapter->chapter_email }}
                             
                            </td>
                        
                        <td>
                            <div class="d-flex">
                          <a href="javascript:;" class=" btn btn-primary chapteredit" data-toggle="modal" data-target="#myModal1" data-name="{{ $chapter->chapter_name}}" data-id="{{ $chapter->chapter_id}}" data-email=" {{ $chapter->chapter_email }}">Edit</a>
                            <form action="{{route('chapterdestroy',$chapter->chapter_id) }}" method="post">
                               
                                @csrf
                                  @method('DELETE')
                              
                                <button type="submit" class="btn btn-danger ml-2 del">Delete</button>
                            </form> 
                        </div>
                        </td>
                    </tr>
                    @endforeach
               
            </tbody>
        </table>

       

   
 
       
     
   




  <!-- Modal -->
  <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
            <h6 class="modal-title">Add New Chapter Name</h6>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          
        </div>
            <div class="modal-body">
            <form action="{{route('chaptercreate')}}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <strong>Chaptername *</strong>
                            <input type="text" name="chapter_name" class="form-control" placeholder="Enter chaptername">
                            @error('name')
                            <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <strong>Chapter Email *</strong>
                            <input type="text" name="chapter_email" class="form-control" placeholder="Enter chapter Email">
                            @error('name')
                            <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    
                </div>
               
            </div>
        <div class="modal-footer">
            <button type="submit" class="btn btn-primary ml-3">Submit</button>
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
        </form>
      </div>
      
    </div>
  </div>


   <div class="modal fade" id="myModal1" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <h6 class="modal-title">Edit Chapter Name</h6>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          
        </div>
          <div class="modal-body">
          <form action="{{route('chapterupdate',$chapter->chapter_id??0) }}" method="POST" enctype="multipart/form-data">
              @csrf
                @method('PUT')
                 <input type="hidden" name="chapter_id" id="chapter_id"  class="form-control">
              <div class="row">
                  <div class="col-xs-12 col-sm-12 col-md-12">
                      <div class="form-group">
                          <strong>chapter name *</strong>
                          <input type="text" name="chapter_name"  id="chapter_name"  class="form-control">

                          @error('name')
                          <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                          @enderror
                      </div>
                       <div class="form-group">
                          <strong>chapter Email*</strong>
                          <input type="text" name="chapter_email"  id="chapter_email"  class="form-control">

                          @error('name')
                          <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                          @enderror
                      </div>
                  </div>
                  
                  
              </div>
             
          </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary ml-3">Submit</button>
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
        </form>
      </div>
      
    </div>
  </div>
   </div>
   </section> 
   
  </div>
  

  </div>



@include('categories.script')

 
<script type="text/javascript">
  $(".chapteredit").click(function(){

       var id = $(this).data('id');
    var name = $(this).data('name');
    var email = $(this).data('email');
    //alert(email);

  $('#chapter_id').val(id); 
     $('#chapter_name').val(name); 
        $('#chapter_email').val(email); 
    

    
  });
  

  
</script>
</body>
</html>


