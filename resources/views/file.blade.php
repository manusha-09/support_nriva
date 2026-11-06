@include('navbar')
<!-- /.navbar -->
<!-- Main Sidebar Container -->
@include('sidemenu')
<div class="content-wrapper">
   <!-- Content Header (Page header) -->
   <section class="content">
      <div class="container-fluid">
         <!-- Small boxes (Stat box) -->
       
            <div class="container-fluid">
               <div class="row">
              @if ($message = Session::get('success'))
            <div class="alert alert-dismissable alert-success">
               
                <p class="mb-0">{{ $message }}
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button></p>

            </div>
        @endif 
    <div>
    	<h6>All Files</h6>
    	<?php //dd(explode(',', $ticket->file_path)); ?>
    	   @foreach(explode(',', $ticket->file_path) as $files) 
    	   <div class="btn btn-success btn-styles btn-sm">
                           <a style="color: white;" href="{{URL::asset('storage/app/'.$files)}}" target="blank">Files
                       
                           </a>
                        </div>
                        @endforeach
    
 

    </div>
</div>
</div>
</div>
</section></div>





@include('categories.script')