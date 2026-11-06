@extends('auth.layout')



@section('content')

@if($searchid=='')

<h5>No Ticket Found
</h5>

@else

<div class="content-wrapper ml-0">

   <!-- Content Header (Page header) -->

   <section class="content">

      <div class="container-fluid">

         <!-- Small boxes (Stat box) -->

       

            <div class="container-fluid ">

            	<div class="row">

                  <div class="col-12 col-md-6 col-lg-6" >

              

               <div class="card mt-2">

  <h5 class="card-header" style="font-weight: bold;">Ticket Subject</h5>

  <div class="card-body">



    <p class="card-text">{{ $searchid->subject}}</p>

   

  </div>

</div>

<div class="card">

  <h5 class="card-header"  style="font-weight: bold;"> Ticket Desciption</h5>

  <div class="card-body">

  

    <p class="card-text" style="line-break: anywhere;"><?php echo  $searchid->description ;?></p>

   

  </div>

</div>

  

<table class="table table-bordered mt-2">

  <thead></thead>

  <tbody>

<tr>

      <th scope="row">Ticket ID</th>

      <td> {{$searchid->ticket_unique_id}}</td>

     

    </tr>

     <tr>

      <th scope="row">Created By</th>

      <td>{{ $searchid->name}}</td>

      

    </tr>

     <tr>

      <th scope="row">Created&nbsp;Email</th>

      <td>{{ $searchid->email}}</td>

      

    </tr>

  

 

     <tr>

      <th scope="row">Category</th>

      <td>{{ $searchid->category}}</td>

      

    </tr>

     <tr>

      <th scope="row">Committee</th>

      <td>{{ $searchid->department}}</td>

      

    </tr>

    <!--  <tr>

      <th scope="row">Project</th>

      <td>{{ $searchid->project}}</td>

      

    </tr> -->

     <tr>

      <th scope="row">Issue&nbsp;Priority</th>

      <td>{{ $searchid->issue_priority}}</td>

      

    </tr>

     <tr>

      <th scope="row">Issue&nbsp;Status</th>

      <td>{{ $searchid->issue_status}}</td>

      

    </tr>

    

    <tr>

      <th scope="row">Created&nbsp;Date</th>

      <td>{{ $searchid->created_at->format('d-m-Y')}}</td>

      

    </tr>





     <tr>

      <th scope="row">Upadted&nbsp;Files</th>

      <td>
@if($searchid->file_path=='')
<h6>No Images Available</h6>
@else

 <?php  $images= explode(',' , $searchid->file_path);?>
     
            @foreach($images as $image)
             
            <img src="{{URL::asset('storage/app/'. $image)}}"  class="images " width="100px" height=
            "100px">
            @endforeach
        

        @endif</td>

      

    </tr>

   

  </tbody>

</table>

<div class="modal fade bd-example-modal-xl" id="imageModal" tabindex="-1" role="dialog" aria-labelledby="imageModalLabel" aria-hidden="true">

    <div class="modal-dialog modal-xl" role="document">

        <div class="modal-content">

            <div class="modal-header">

                <h5 class="modal-title" id="imageModalLabel">Image Preview</h5>

                <button type="button" class="close" data-dismiss="modal" aria-label="Close">

                    <span aria-hidden="true">&times;</span>

                </button>

            </div>

            <div class="modal-body">

              <div class="row">

                <div class="col-12">

                <img src="{{URL::asset('storage/app/'. $searchid->file_path)}}" height="100px" width="100px" class="mr-2 open_pop">

              </div>

              </div>



                <div class="row">

                    <div class="col-12">

                       <div></div>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>

























           </div></div></div></div></section>







@endif

<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>



<script>

 $('.images').click(function(){

        $('.open_pop').attr('src',$(this).data('src'));

        $('#imageModal').modal('show');

     });

 </script>





@include('categories.script')





@endsection