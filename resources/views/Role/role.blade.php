@include('navbar')
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  @include('sidemenu')

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    @include('header')
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <!-- Small boxes (Stat box) -->
        <div class="row">
          
          <div class="container mt-2">
        <div class="row">
            <div class="col-lg-12 margin-tb">
                <div class="pull-left">
                    <h2>Roles & Permissions</h2>
                </div>
                <div class="pull-right mb-2">
                    <a class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModal" href=""> Add Roles</a>
                </div>
            </div>
        </div>
        @if ($message = Session::get('success'))
            <div class="alert alert-success">
                <p class="mb-0">{{ $message }}</p>
            </div>
        @endif
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>S.No</th>
                   
                    <th>Role Name</th>
                    <th>Employee Count</th>
                      <th>Permission Count</th>
                    
                    <th width="280px">Action</th>
                </tr>
            </thead>
            <tbody>
            
                    <tr>
                        <td></td>
                       

                        <td></td>
                          <td></td>
                           <td></td>
                        
                        <td>
                            <div class="d-flex">
                            <button class="btn btn-primary" id="departmentedit" data-toggle="modal" data-target="#myModal1">Edit</button>
                            <form action="" method="post">
                               
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger ml-2">Delete</button>
                            </form> 
                        </div>
                        </td>
                    </tr>
                   
               
            </tbody>
        </table>
      
       
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
  <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
        	<h6 class="modal-title">Add New Department Name</h6>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          
        </div>
	        <div class="modal-body">
	        <form action="" method="POST" enctype="multipart/form-data">
	            @csrf
	            <div class="row">
	                <div class="col-xs-12 col-sm-12 col-md-12">
	                    <div class="form-group">
	                        <strong>Department name *</strong>
	                        <input type="text" name="department" class="form-control" placeholder="Ex('Web developer')">
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
          <h6 class="modal-title">Edit Department Name</h6>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          
        </div>
          <div class="modal-body">
          <form action="" method="POST" enctype="multipart/form-data">
              @csrf
                @method('PUT')
              <div class="row">
                  <div class="col-xs-12 col-sm-12 col-md-12">
                      <div class="form-group">
                          <strong>Department name *</strong>
                          <input type="text" name="department" value="" class="form-control">
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
  <footer class="main-footer">
    <strong>Copyright &copy; 2014-2021 <a href="https://adminlte.io">AdminLTE.io</a>.</strong>
    All rights reserved.
    <div class="float-right d-none d-sm-inline-block">
      <b>Version</b> 3.2.0
    </div>
  </footer>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<!-- jQuery -->
@include('categories.script')


</body>
</html>


