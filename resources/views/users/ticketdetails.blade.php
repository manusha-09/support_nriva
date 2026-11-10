@include('users.usernavbar')
@if(Auth::user()->isSupportAdmin())
@include('sidemenu')
@else
@include('users.usersidemenu')
@endif

<div class="content-wrapper">
   <!-- Content Header (Page header) -->
   <section class="content">
      <div class="container-fluid">
         <!-- Small boxes (Stat box) -->
       
            <div class="container ">
               <div class="row">

                  <div class="col-lg-12 margin-tb">
                  <div class="pull-right mt-2">
                    <a href="{{ URL::previous() }}" class="btn btn-info">Back</a>
                     </div>
                      <div class="pull-right mt-2 mr-2">
                    <a href="{{ route('edit_ticket',$details->id) }}" class="btn btn-info">Edit</a>
                     </div>
                  </div>
               </div>
               <div class="card mt-2">
  <h5 class="card-header" style="font-weight: bold;">Ticket Subject</h5>
  <div class="card-body">

    <p class="card-text">{{$details->subject}}</p>
   
  </div>
</div>
<div class="card">
  <h5 class="card-header"  style="font-weight: bold;"> Ticket Desciption</h5>
  <div class="card-body">
  
    <p class="card-text" style="line-break: anywhere;"><?php echo $details->description ;?></p>
   
  </div>
</div>
  
<table class="table table-bordered mt-2">
  <thead></thead>
  <tbody>
<tr>
      <th scope="row">Ticket ID</th>
      <td> NRIVA-{{date('Y-M-d',strtotime($details->created_at))}}-{{$details->id}}</td>
     
    </tr>
  
    <!-- <tr>
      <th scope="row">Ticket Subject</th>
      <td>{{$details->subject}}</td>
      
    </tr> -->
     <tr>
      <th scope="row">Category</th>
      <td>{{$details->category}}</td>
      
    </tr>
     <tr>
      <th scope="row">Committee</th>
      <td>{{$details->department}}</td>
      
    </tr>
    <!--  <tr>
      <th scope="row">Project</th>
      <td>{{$details->project}}</td>
      
    </tr> -->
     <tr>
      <th scope="row">Issue Priority</th>
      <td>{{$details->issue_priority}}</td>
      
    </tr>
     <tr>
      <th scope="row">Issue Status</th>
      <td>{{$details->issue_status}}</td>
      
    </tr>
<!--  <tr>
      <th scope="row">Desciption</th>
      <td style="line-break: anywhere;"><?php echo $details->description ;?></td>
      
    </tr> -->

     <tr>
      <th scope="row">Upadted Files</th>
      <td><a href="{{asset('storage/'.preg_replace('#^public/#', '', $details->file_path))}}">{{$details->file_path}}</a></td>
      
    </tr>
   
  </tbody>
</table>











           </div></div></section>






@include('categories.script')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<script type="text/javascript">
   let table = new DataTable('#myTable');

   </script>

</body>
</html>


