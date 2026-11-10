@include('navbar')

  @include('sidemenu')

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
        <!-- Small boxes (Stat box) -->
        <div class="row">
          
         
            <div class="col-lg-12">
               
            <div class=" d-flex justify-content-between">
                        <div class="pull-left mb-2">
                            <a class="btn btn-success btn-lg" data-toggle="modal" data-target="#myModal" href="{{url('/departmentcreate')}}"> Add Committee</a>
                        </div>
                         <div class="">
      
                              <form action="{{route('department')}}" method="GET">

                                  <div class="input-group">
                                      <span class="input-group-btn">
                                          <button class="btn btn-info" type="submit">
                                              <span class="fas fa-search"></span>
                                          </button>
                                      </span>
                                      <input type="text" class="form-control" name="search_committee" placeholder="Search committees" >
                                      <a href="{{route('department')}}" class=" ml-1">
                                          <span class="input-group-btn">
                                              <button class="btn btn-danger" type="button" >
                                                  <span class="fas fa-sync-alt"></span>
                                              </button>
                                          </span>
                                      </a>
                                  </div>
                              </form>
                        </div>
               </div>
            </div>
        </div>
           
       <div class="row">
        <div class="col-lg-12 scrolls">
           <table id="dataTable" width="100%" class="table  table-bordered table-hover ">
            <thead>
                <tr>
                    <th>S.No</th>
                   
                    <th>Committee Name</th>
                       <th>Email</th>
                    <!-- <th>Status</th> -->
                    
                    <th width="280px">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($departments as $department)
                    <tr>
                        <td>{{ $department->id}}</td>
                       

                        <td>{{ $department->department }}</td>
                         <td>{{ $department->committee_email }}</td>
                         <!--  <td> 
                              <div class="custom-control custom-switch">
                                <input type="checkbox" class="custom-control-input switch-input" id="customSwitches" data-id="{{ $department->id}}" @if($department->status==1) checked @endif>
                                <label class="custom-control-label" for="customSwitches"></label>
                              </div>
                             
                            </td> -->
                        
                        <td>
                            <div class="d-flex">
                          <a href="javascript:;" class=" btn btn-primary departmentedit" data-toggle="modal" data-target="#myModal1" data-name="{{ $department->department }}"  data-committee_email="{{ $department->committee_email }}" data-id="{{ $department->id}}">Edit</a>
                            <form action="{{ route('departmentdestroy',$department->id) }}" method="post">
                               
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

       
    </div>
   
        </div>
      
    
 


  <!-- Modal -->
  <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
        	<h6 class="modal-title">Add New Committee Name</h6>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          
        </div>
	        <div class="modal-body">
	        <form action="{{ url('departmentstore') }}" method="POST" enctype="multipart/form-data">
	            @csrf
	            <div class="row">
	                <div class="col-xs-12 col-sm-12 col-md-12">
	                    <div class="form-group">
	                        <strong>Committee name *</strong>
	                        <input type="text" name="department" class="form-control" placeholder="Enter Committee Name">
	                        @error('name')
	                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
	                        @enderror
	                    </div>
                       <div class="form-group">
                          <strong>Committee Email *</strong>
                          <input type="email" name="committee_email" class="form-control" placeholder="Enter Committee Email">
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
    
    
      <div class="modal-content">
                <div class="modal-header">
                  <h6 class="modal-title">Edit Committee Name</h6>
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                  
                </div>
          <div class="modal-body">
          <form action="{{ route('departmentupdate',$department->id??0) }}" method="POST" enctype="multipart/form-data">
              @csrf
                @method('PUT')
                 <input type="hidden" name="department_id" id="department_id"  class="form-control">
                      <div class="row">
                          <div class="col-xs-12 col-sm-12 col-md-12">
                              <div class="form-group">
                                <strong>Department name *</strong>
                                <input type="text" name="department" id="department"  class="form-control">

                                @error('department')
                                <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                                @enderror
                            </div>
                             <div class="form-group">
                                <strong>Department Email *</strong>
                                <input type="email" name="committee_email" id="committee_email"  class="form-control">

                                @error('department')
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
    </section> 
   
  </div>
</div>


 
<script type="text/javascript">
 //$('body').on('click',".departmentedit",function() {

  $(".departmentedit").click(function(){
       var id = $(this).data('id');

    var name = $(this).data('name');
    var committee_email = $(this).data('committee_email');
  $('#department_id').val(id); 
     $('#department').val(name); 
       $('#committee_email').val(committee_email); 
    

    
  });
  

    $(".switch-input").click(function() {
      var id = $(this).data('id');
      //alert(id);

    $.ajax({
      type: "get",
      url: '{{url("update_status")}}',
      data: {
        'id': id
      },
      success: function(data){
           //redirect where you want..
      },
    });
});
 
</script>
@include('categories.script')
</div>


</body>
</html>


