
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
                    <a class="btn btn-success btn-lg" data-toggle="modal" data-target="#myModal" href="{{url('/projectcreate')}}"> Add Project</a>
                </div>
            </div>
        </div>
    <div class="row">
      <div class="col-lg-12">
        <table id="dataTable" width="100%" class="table  table-bordered table-hover">
            <thead>
                <tr>
                    <th>S.No</th>
                   
                    <th>Project Name</th>
                    <th>Status</th>
                    
                    <th width="280px">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($projects as $project)
                    <tr>
                        <td>{{ $project->id}}</td>
                       

                        <td>{{ $project->name }}</td>
                          <td> 
                            
                          <div class="custom-control custom-switch">
                                <input type="checkbox" class="custom-control-input checked" id="customSwitches" data-id="{{ $project->id}}" @if($project->status==1) checked @endif>
                                <label class="custom-control-label" for="customSwitches"></label>
                              </div>
                             
                            </td>
                        
                        <td>
                            <div class="d-flex">
                          <a href="javascript:;" class=" btn btn-primary projectedit" data-toggle="modal" data-target="#myModal1" data-name="{{ $project->name}}" data-id="{{ $project->id}}">Edit</a>
                            <form action="{{ route('projectdestroy',$project->id) }}" method="post">
                               
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
            <h6 class="modal-title">Add New Project Name</h6>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          
        </div>
            <div class="modal-body">
            <form action="{{ url('projectstore') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <strong>project name *</strong>
                            <input type="text" name="name" class="form-control" placeholder="Ex('Web developer')">
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
          <h6 class="modal-title">Edit Project Name</h6>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          
        </div>
          <div class="modal-body">
          <form action="{{ route('projectupdate',$project->id??0) }}" method="POST" enctype="multipart/form-data">
              @csrf
                @method('PUT')
                 <input type="hidden" name="project_id" id="project_id"  class="form-control">
              <div class="row">
                  <div class="col-xs-12 col-sm-12 col-md-12">
                      <div class="form-group">
                          <strong>project name *</strong>
                          <input type="text" name="name"  id="project"  class="form-control">

                          @error('project')
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
  $(".projectedit").click(function(){
    alert("hi");
       var id = $(this).data('id');

    var name = $(this).data('name');
  $('#project_id').val(id); 
     $('#project').val(name); 
    

    
  });
  $(document).ready(function(){
  $(".del").click(function(){
    if (!confirm("Do you want to delete")){
      return false;
    }
  });
});
// $('.switch-input').on('change', function() {
//     result = document.getElementsByClassName("switch-input")[0].checked ? 'yes' : 'no';
//     alert(result);
// });
  // function status(id) {
  //   $.ajaxSetup({
  //     headers: {
  //       'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
  //     }
  //   });

    $(".checked").click(function() {
      var id = $(this).data('id');
       // alert(id);

    $.ajax({
      type: "get",
      url: '{{url("update_project")}}',
      data: {
        'id': id
      },

      success: function(data){
            alert("updated");
      },
    });
});
  
</script>
</body>
</html>


