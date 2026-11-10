@include('navbar')
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  @include('sidemenu')

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
   <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h5 class="m-0">Category</h5>
          </div><!-- /.col -->
         
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
 
    <section class="content">
      <div class="container-fluid">
    
      
        <div class="row">
            <div class="col-lg-12 margin-tb">
                <div class="pull-left">
                    <h2></h2>
                </div>
                <div class="pull-right mb-2">
                    <a class="btn btn-success" data-toggle="modal" data-target="#myModal"> Create category</a>
                </div>
            </div>
        </div>
        <div class="row">
          <div class="col-12">
       
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>S.No</th>
                    <th>Category Name</th>
                    
                    <th width="280px">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($categories as $category)
                    <tr>
                        <td>{{ $category->id }}</td>
                        <td>{{ $category->name }}</td>
                        
                        <td>
                            <div class="d-flex">
                            <a href="" class=" btn btn-primary categoryedit" data-toggle="modal" data-target="#myModal1" data-name="{{ $category->name }}" data-id="{{ $category->id}}">Edit</a>
                            <form action="{{ route('destroy',$category->id) }}" method="post">
                               
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger del ml-2">Delete</button>
                            </form> 
                        </div>
                        </td>
                    </tr>
                    @endforeach
               
            </tbody>
        </table>
        {!! $categories->links() !!}
       
    </div>
   
        </div>
      
      </div><!-- /.container-fluid -->
    </section> 
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
            <h6 class="modal-title">Add category Name</h6>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          
        </div>
            <div class="modal-body">
            <form action="{{ url('store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <strong>category name *</strong>
                            <input type="text" name="name" class="form-control" placeholder="Ex('Web developer')">
                            @error('name')
                            <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                            @enderror
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
<div class="modal fade" id="myModal1" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <h6 class="modal-title">Edit category Name</h6>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          
        </div>
          <div class="modal-body">
          <form action="{{ route('update',$categories->id??0) }}" method="POST" enctype="multipart/form-data">
              @csrf
                @method('PUT')
                 <input type="hidden" name="category_id" id="category_id"  class="form-control">
              <div class="row">
                  <div class="col-xs-12 col-sm-12 col-md-12">
                      <div class="form-group">
                          <strong>Category name *</strong>
                          <input type="text" name="name" id="category"  class="form-control">

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
  </div>
</div>
</div>


</div>

  
@include('categories.script')
<script type="text/javascript">
  $(".categoryedit").click(function(){

       var id = $(this).data('id'); 

    var name = $(this).data('name');
  $('#category_id').val(id); 

     $('#category').val(name); 
    

    
  });
  

  
  
</script>

</body>
</html>

