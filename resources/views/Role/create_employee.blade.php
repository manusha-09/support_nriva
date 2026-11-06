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
        	<div class="col-lg-12">
        		<h4> Create Employee</h4>
          
			                 
			         <form>
			  <div class="form-row">
			    <div class="form-group col-md-6">
			      <label for="inputEmail4">First name *</label>
			      <input type="email" class="form-control" id="inputEmail4" placeholder="first name">
			    </div>
			    <div class="form-group col-md-6">
			      <label for="inputPassword4">Last name *</label>
			      <input type="password" class="form-control" id="inputPassword4" placeholder="lastname">
			    </div>
			  </div>
			  <div class="form-row">
			    <div class="form-group col-md-6">
			      <label for="inputEmail4">Select Role *</label>
			     
										      <select class="custom-select">
							  <option selected>Selected Role</option>
							  <option value="1">Super Admin</option>
							  <option value="2">Admin</option>
							  <option value="3">Manager</option>
							</select>
			    </div>
			    <div class="form-group col-md-6">
			      <label for="inputPassword4">Department *</label>
			      <select class="custom-select">
							  <option selected>Selected department</option>
							  <option value="1">Super Admin</option>
							  <option value="2">Admin</option>
							  <option value="3">Manager</option>
							</select>
			    </div>
			  </div>
			  
			 <div class="form-row">
			    <div class="form-group col-md-6">
			      <label for="inputEmail4">Employee ID *</label>
			      <input type="email" class="form-control" id="inputEmail4" placeholder="Email">
			    </div>
			    <div class="form-group col-md-6">
			      <label for="inputPassword4">Mobile Number *</label>
			      <input type="password" class="form-control" id="inputPassword4" placeholder="Password">
			    </div>
			  </div>
			  <div class="form-row">
			    <div class="form-group col-md-6">
			      <label for="inputEmail4">Email *</label>
			      <input type="email" class="form-control" id="inputEmail4" placeholder="Email">
			    </div>
			    <div class="form-group col-md-6">
			      <label for="inputPassword4">Password *</label>
			      <input type="password" class="form-control" id="inputPassword4" placeholder="Password">
			    </div>
			  </div>
			  <div class="form-row">
			    <div class="form-group col-md-6">
			      <label for="inputEmail4">Languages *</label>
			      <input type="email" class="form-control" id="inputEmail4" placeholder="Email">
			    </div>
			    <div class="form-group col-md-6">
			      <label for="inputPassword4">Skills *</label>
			      <input type="password" class="form-control" id="inputPassword4" placeholder="Password">
			    </div>
			  </div>
						  <div class="form-group col-md-12">
			    <label for="exampleFormControlFile1">Upload Image</label>
			    <input type="file" class="form-control-file" id="exampleFormControlFile1">
			  </div>
			   
			  <div class="form-group">
			    <div class="form-check">
			      <input class="form-check-input" type="checkbox" id="gridCheck">
			      <label class="form-check-label" for="gridCheck">
			        Check me out
			      </label>
			    </div>
			  </div >
			  <div class="float-right mb-3">
			  <button type="submit" class="btn btn-info">Create Employee</button>
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
  <footer class="main-footer">
    <strong>Copyright &copy; 2022-2023<a href="https://adminlte.io">NRIVA</a>.</strong>
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


