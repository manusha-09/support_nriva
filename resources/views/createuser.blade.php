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
         </div>
      </div>
   </div>
   <!-- Main content -->
   <section class="content">
      <div class="container-fluid">
         <div class="row">
            <div class="col-lg-12">
               <div class="pull-left">
                  <h2></h2>
               </div>
               <div class="pull-right mb-2">
                  <a  href="{{route('register')}}" class="btn btn-success">Add User</a>
               </div>
            </div>
            
         </div>
         <div class="row">
           <div class="col-12">
                <div class="table-responsive">
                  <table class="table table-bordered">
                   <thead>
                      <tr>
                         <th>S.No</th>
                         <th>User Name</th>
                         <th>Email</th>
                         <th width="280px">Action</th>
                      </tr>
                   </thead>
                   <tbody>
                      @foreach($userlist as $userlists)
                      <tr>
                         <td>{{$userlists->id}}</td>
                         <td>{{$userlists->name}}</td>
                         <td>{{$userlists->email}}</td>
                         <td>
                            <div class="d-flex">
                               <a href="" class=" btn btn-primary useredit" data-toggle="modal" data-target="#myModal1" data-name="{{ $userlists->name }}"  data-email="{{$userlists->email}}" data-id="{{ $userlists->id}}" >Edit</a>
                               <form action="{{ route('destroyuser',$userlists->id) }}" method="post">
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
                </div>
            </div>
         </div>
         <div class="modal fade" id="myModal1" role="dialog">
            <div class="modal-dialog">
               <!-- Modal content-->
               <div class="modal-content">
                  <div class="modal-header">
                     <h6 class="modal-title">Edit User Name</h6>
                     <button type="button" class="close" data-dismiss="modal">&times;</button>
                  </div>
                  <div class="modal-body">
                     <form action="{{ route('updateuser',$userslist->id??0) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="userslist_id" id="userslist_id"  class="form-control">
                        <div class="row">
                           <div class="col-xs-12 col-sm-12 col-md-12">
                              <div class="form-group">
                                 <strong>User name *</strong>
                                 <input type="text" name="name" id="name"  class="form-control">
                                 @error('department')
                                 <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                                 @enderror
                              </div>
                              <div class="form-group">
                                 <strong>User email*</strong>
                                 <input type="text" name="email" id="email"  class="form-control">
                                 @error('department')
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
      </div>
   </section>
   <!-- /.content -->
</div>

<script type="text/javascript">
   $(".useredit").click(function(){
   
        var id = $(this).data('id'); 
   
     var name = $(this).data('name');
     var email = $(this).data('email');
   $('#userslist_id').val(id); 
   
      $('#name').val(name); 
        $('#email').val(email); 
     
   
     
   });
   

</script>
@include('categories.script')

</body>
</html>