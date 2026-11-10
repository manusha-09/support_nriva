@include('navbar')
<!-- /.navbar -->
<!-- Main Sidebar Container -->
@include('sidemenu')
 <script src="https://cdn.ckeditor.com/4.22.1/standard/ckeditor.js"></script> 
 <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<style type="text/css">
.scroll::-webkit-scrollbar, .card_scroll::-webkit-scrollbar {
  width: 8px;
}

/* Track */
.scroll::-webkit-scrollbar-track, .card_scroll::-webkit-scrollbar-track {
  background: #f1f1f1; 
box-shadow: inset 0 0 3px grey;
}
 
/* Handle */
.scroll::-webkit-scrollbar-thumb, .card_scroll::-webkit-scrollbar-thumb {
  background: #888; 
  border-radius: 10px;
}

/* Handle on hover */
.scroll::-webkit-scrollbar-thumb:hover, .card_scroll::-webkit-scrollbar-thumb:hover {
  background: #555; 
}
.open_pop{
    width: 100%;
    height: auto;
}
#myTabledata tbody tr:first-child{
    background-color: #cddadf!important;
}
.firstletter{
    font-weight: 500;
    font-size: 18px!important;
    line-height: 18px;
    color: #fff;

}
.main_comment--container{
    background-color: white;
}
.subjectdata{
    text-overflow: ellipsis;
    white-space: nowrap;
    overflow: hidden;
    max-width: 45ch;
}
.spandata{
    background-color: white;
}

 

  
</style>
<div class="content-wrapper ptop ticket-workspace">
@include('tickets.toolbar', ['deskTickets' => $ticketlist, 'deskTitle' => 'All Tickets'])
   <!-- Content Header (Page header) -->
   <section class="content" >
      <div class="container-fluid">
         <!-- Small boxes (Stat box) -->
       
             
                      <div class="row pt-2 d-flex ">
                          <!--  <div id="filters" class="col-12 col-sm-6 col-md-3 col-lg-1 my-auto">
                              <h5 class="font-weight-bold mb-0 headings-styles">All&nbsp;Tickets</h5>
                              </div> -->

                             
                               <div id="filters4" class=" pl-0 pr-1">
                                 <select  style="width: 120px!important;" class="fetchval form-control form-cntrl font-weight-bold" id="status">
                                    <option value="All">All Tickets</option>
                                    <option value="pending" @if(Session::get('status')=='pending' || empty(Session::get('status'))) Selected @endif >Pending</option>
                                    <option value="assigned" @if(Session::get('status')=='assigned') Selected @endif>Assigned</option>
                                    <option value="inprogress" @if(Session::get('status')=='inprogress') Selected @endif>Inprogress</option>
                                    <option value="completed" @if(Session::get('status')=='completed') Selected @endif>Completed</option>
                                 </select>
                              </div>
                               <div id="filters3" class=" px-1">
                                 <select class="fetchval form-control form-cntrl font-weight-bold" id="priority">
                                    <option value="">By Issue Priority</option>
                                    <option value="High" @if(Session::get('priority')=='High') Selected @endif>High</option>
                                    <option value="Medium" @if(Session::get('priority')=='Medium') Selected @endif>Medium</option>
                                    <option value="Low" @if(Session::get('priority')=='Low') Selected @endif>Low</option>
                                 </select>
                              </div>
                            
                        
                              <div id="filters" class=" px-1">
                                 <select class="fetchval form-control form-cntrl font-weight-bold" id="department">
                                    <option value="">By Committee</option>
                                    @foreach($department as $departments)
                                    <option value="{{$departments->department}}" @if(Session::get('department')==$departments->department) Selected @endif>{{$departments->department}}</option>
                                    @endforeach
                                 </select>
                              </div>
                              <div id="filters1" class="px-1">
                                 <select class="fetchval form-control form-cntrl font-weight-bold" id="category">
                                    <option value="">By Category</option>
                                    @foreach($categories as $category)
                                    <option value="{{$category->name}}" @if(Session::get('category')==$category->name) Selected @endif> {{$category->name}}</option>
                                    @endforeach
                                 </select>
                              </div>
                              <!-- <div id="filters2" class=" px-1">
                                 <select class="fetchval form-control form-cntrl font-weight-bold" id="project">
                                    <option value="">By Project</option>
                                    @foreach($projects as $project)
                                    <option value="{{$project->name}}" @if(Session::get('project')==$project->name) Selected @endif>{{$project->name}}</option>
                                    @endforeach
                                 </select>
                              </div > -->
                               <div class="px-1">
                            
                                    <input type="date" name="date_from" class="fetchval form-control form-cntrl font-weight-bold" @if(!empty(Session::get('date_from'))) value="{{(Session::get('date_from'))}}"" @else value="{{date('Y-m-d',strtotime('-1 month'))}}" @endif id="date_from">
                                </div>
                                 <div class="px-1">
                               
                                    <input type="date" name="date_to" class="fetchval form-control form-cntrl font-weight-bold" @if(!empty(Session::get('date_to'))) value="{{(Session::get('date_to'))}}"" @else value="{{date('Y-m-d')}}" @endif id="date_to">
                                 </div>
                             
                               <div id="Resetfilters" class="col-12 col-sm-6 col-md-3 col-lg-1 my-auto">
                              <h6 class="text-blue font-weight-bold"> <u>Reset</u></h6>
                              </div>
                             
                              

                              <!--  <div class="form-inline">
                                 <div class="input-group" data-widget="sidebar-search">
                                   <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
                                   <div class="input-group-append">
                                     <button class="btn btn-sidebar">
                                       <i class="fas fa-search fa-fw"></i>
                                     </button>
                                   </div>
                                 </div>
                                 </div> -->
                    </div>
        </div>
               <div class="row">
                  <div class="col-12 col-md-6 col-lg-5 pl-1 scroll mt-1 desk-ticket-list" >
                        <div class="table-responsive ">


                               <table  width="100%" class="table bordred table-hover space tickets" id="myTable">
                                  <thead>
                                    <!--  <tr class="table-success">
                                        <th style="width:300px"> All Tickets</th>
                                        
                                     </tr> -->
                                
                                  </thead>
                                  <tbody class="row_position">
                                     @foreach ($ticketlist as $ticket)
                                     <tr id='but_search' data-id="{{$ticket->id}}" @if(Request::get('id')==$ticket->id)
                                       class="highlight" @else class="tr-card shadow-sm" @endif >

                                        <td data-order= "" class="border-0" >
                                           <h6 class="font-weight-bold mb-3 text-break subjectdata" style="font-size:17px">{{$ticket->subject}}</h6>
                                           <div>
                                              <span class="btn btn-skyblue btn-styles btn-sm"> {{$ticket->ticket_unique_id}}</span> 
                                                       <span class="btn btn-yellow btn-styles btn-sm ">{{$ticket->issue_priority}}</span>
                                        
                                                         
                                                           <span class="btn btn-orange btn-styles btn-sm ">{{$ticket->department}}</span>
                                                            <span class="btn btn-violet btn-styles btn-sm">{{$ticket->issue_status}}</span>
                                                            
                                            </div>


                                     

                                                           <!--  <div class="mx-1">
                                              <select id="ticket_status" class="ticket_status" data-id="{{$ticket->id}}" data-status="{{$ticket->issue_status}}">
                                                 <option value="pending" @if ($ticket->issue_status == 'pending') selected @endif>Pending</option>
                                                 <option value="assigned" @if ($ticket->issue_status == 'assigned') selected @endif>Assigned</option>
                                                 <option value="inprogress "
                                                 @if ($ticket->issue_status == 'inprogress') selected @endif>Inprogress</option>
                                                 <option value="completed" @if ($ticket->issue_status == 'completed') selected @endif>Completed</option>
                                              </select>
                                           </div> -->
                    
                                          
                                 
                                       
                                                 

                                                
                                             
                                           </td>
                                     </tr>
                                     @endforeach

                                  </tbody>

                               </table>



                        </div>
                    </div>

           @include('tickets.properties', ['deskTickets' => $ticketlist])
@if(isset($ticketlist[0]))
    <div class="col-12 col-md-6 col-lg-7 mt-2 pl-1 desk-ticket-detail" >
        <div id="LoadingImage" class="loading"style="display:none"><h6>Please Wait.....</h6></div>
                  
        <div id="showdetails" class="ml-2" style="display:none;" selected>
            <div class="row mb-2">
                     
                    <div class=" col-12 col-md-9 col-lg-9 my-auto pl-1 d-flex">
                       <div class=' btn btn-info btn-styles btn-sm category_ajax ml-1' style="cursor: initial;">{{$ticketlist[0]->category??''}}</div>
                       <div class=' btn btn-info btn-styles btn-sm issue_priorityedit ml-1' style="cursor: initial;">{{$ticketlist[0]->issue_priority??''}}</div>
                      
                        <!-- <div class=' btn btn-info btn-styles btn-sm chaptername1 ml-1' style="cursor: initial;">{{$ticketlist[0]->chapter_name??''}}</div> -->
                       <div class=' btn btn-info btn-styles btn-sm issue_statusedit ml-1' style="cursor: initial;">{{$ticketlist[0]->issue_status??''}}</div>
                    <div class=' btn btn-info btn-styles btn-sm fa fa-arrow-up department_ajax ml-1' style="cursor: initial;"></div>
                                
                                         <select  style="width: 120px!important;" class="btn btn-info btn-styles ml-1 status_change" data-id="">
                                            <option value="">Change Status</option>
                                            <option value="pending" >Pending</option>
                                            <option value="assigned">Assigned</option>
                                            <option value="inprogress">Inprogress</option>
                                            <option value="completed" >Completed</option>
                                        
                                         </select>
                                          <div class=' btn btn-info btn-styles btn-sm statustime ml-1' style="cursor: initial;"></div>
                     
              
                    </div>


                    <div class=" col-12 col-md-3 col-lg-3 my-auto"> 

                            <a class=" btn btn-violet  btn-sm pull-right mr-2 shareTicket py-1"  data-id="{{$ticketlist[0]->ticket_unique_id??''}}"><i class="fa fa-link" aria-hidden="true"></i></a>

                        <a class='btn btn-violet  btn-sm pull-right  mr-2 edit_tickets py-1' ><i class="fa fa-edit" aria-hidden="true"></i></a>
                         <a class='btn btn-violet  btn-sm pull-right  mr-2 delete_tickets py-1' href="javascript:;" onclick="return confirm('Are you sure?')"><i class="fa fa-trash" aria-hidden="true"></i></a>
                    
                      
                       
                   
                    </div>
            </div>
                <div class="card  mb-1">
                 

                  <div class="card-body py-2">

                    <h5 style="font-weight: bold; color: #3f6791; font-size:17px;" class="mb-0 subject ">{{$ticketlist[0]->subject??''}}</h5>

                  </div>
                </div>
                
   <!-- Table -->
  
 
    <div class="py-2 spandata mb-2">
        <span><i class="fa fa-envelope px-2"></i></span>
        <span id="email">{{$ticketlist[0]->email??''}}</span>
        <span class="px-3">|</span><span><i class="fa fa-user pr-2"></i>
        </span><span id="name">{{$ticketlist[0]->name??''}}</span>
        <span class="font-weight-bold">(</span><span  class="selected_committee"></span><span class="px-2">|</span><span  class="chaptername1"></span><span class="font-weight-bold">)</span>
        <span class="px-3">|</span><span><i class="fa fa-calendar pr-2"></i></span><span class="created">{{$ticketlist[0]->created_at??''}}</span>


        <span class="px-3">|</span>
<span>
    <i class="fa fa-edit pr-2"></i>
</span>
<span class="updated">
    {{$ticketlist[0]->updated_at ?? ''}}
</span>
        <!-- <span class="px-3">|</span><span><i class="fa fa-arrow-up pr-2"></i></span><span class=" department_ajax">{{$ticketlist[0]->department??''}}</span> -->
     </div>


    <div class="card_scroll">

<div class="card mb-1">
  <h5 class="card-header"  style="font-weight: bold; color: #3f6791; font-size:17px;"> Ticket Description</h5>
  <div class="card-body py-2">

  
    <div class="card-text descriptiondata" ><?php echo $ticketlist[0]->description; ?></div>
   
  </div>
</div>
  
<table class="table border bg-white pt-0" style="box-shadow: none;" width="100%" id='empTable' >

     <thead>
                    
    </thead> 
     <tbody>

   <!--  <tr>
               
          <th> Ticket ID</th>
        <td id="id">{{$ticketlist[0]->ticket_unique_id}} </td>
        </tr>
   
     
    <tr> -->
      <th >Upload&nbsp;Screens   
                    </th>
      <td class="file_path" id="img1">

         @if($ticketlist[0]->file_path=='')

        <h6>No Images Available</h6>
        @else


       <?php  $images= explode(',' , $ticketlist[0]->file_path);?>
     
            @foreach($images as $key=>$image)
             <span class="removeimage"><button class=' mr-2 delete_images py-1' data-id="{{$ticketlist[0]->id??''}}" data-key="{{$key}}" data-src="{{$image}}" href="javascript:;" onclick="return confirm('Are you sure?')">X</button>
            <img src="{{asset('storage/'.preg_replace('#^public/#', '', $image))}}"  class="images images_list " width="100px" height=
            "100px"></span>
            @endforeach
        

        @endif</td>

      
    </tr>
  

     </tbody>
</table>

         @endif

         <div class="row add_comment" style="display:none;">
             <div class="col-12">
            
                    <form method="" action="" >
                     @csrf
                     <div class="row">
                   <div class="form-group col-9">
                     
                       <textarea  name="body" class="form-control body" placeholder="Write Comment Here" /></textarea>
                            <input type="hidden" name="post_id"  class="ticketid" value="{{$ticketlist[0]->id??''}}" >
                            <input type="hidden" name="parent_id"  class="commentspost_id" value="0" />
                      
                    </div>

                       
       
                     <div class="form-group mt-2 col-3">
                       
                            <input type="button" class="btn btn-success submit_comment" value="Add Comment">
                    </div>
                </div>
                      </form>
                </div>
          
        </div>
   


<div class="main_comment--container comments_list  ">

    @foreach($comments as $comment)
    <div class="row py-2 removecomment" >
        <div class="col-2 col-md-1">
            <div class="letter_circle mx-2">
                <span class="firstletter "><?php

                 $fstchar = substr($comment->user->name,0,1);
                 echo ucfirst($fstchar);
                ?> </span>
            </div>
        </div>
        <div class="col-10 col-md-11 pl-3 pl-md-0 ">
             <div class="font-weight-bold">{{$comment->user->name??''}}</div>
             <div><?php
             $gettime=abs(time() - strtotime($comment->created_at)) < 300;
             echo $gettime;
         ?></div><a class='pull-right delete-comments mr-2 py-1' data-id="{{$comment->id}}" href="javascript:;" ><i class="fa fa-trash text-red" aria-hidden="true"></i></a>
            <div class="text-break"> {{$comment->body}}</div>
        </div>
    </div>

   
    @endforeach
</div>

</div>
</div>


<div class="editshowdetails" style="display: none;">
       <div class="row">
             
             <div class="col-12"> 
                     <div class="text-right"> 
                        <button class='pull-right btn btn-info mr-1 py-1' id="edit_cancel">Back</button>
                       
                   
                   </div>
                </div>
                </div>
                     
 
    <form action="" method="POST" enctype="multipart/form-data" id="form_action" class="update_ticket_form">
                      
                        <div class="form-group mb-3">
                            <input type="hidden" class="ticketid">
                        </div>
                           <div class="form-group mb-3">

                                        <div class="card mt-2">
                                      <h5 class="card-header" style="font-weight: bold;">Ticket Subject</h5>
                                      <div class="card-body">

                                        <textarea  class="form-control subjectedit" name="subject" value="{{$ticketlist[0]->subject??''}}">
                                        </textarea>
                                       
                                      </div>
                                    </div>
                            
                           
                        </div>

                        <div class="form-group mb-3">
                         <div class="card">
                                  <h5 class="card-header"  style="font-weight: bold;"> Ticket Description</h5>
                                  <div class="card-body">
                                  
                                    <textarea  id="editor1" class="form-control descriptionpath" name="description"></textarea>
                                   
                                  </div>
                                </div>
                        </div>

                        <div class="form-group mb-3">
                            <label for="">Committee Name</label>
                            
                             <select  class="form-control" name="department">
                            <option class="department_ajax_val">{{$ticketlist[0]->department??''}}</option>
                            @foreach ($department as $departments)
                            <option value="{{$departments->department}}">{{$departments->department}}
                                
                            </option>
                            @endforeach
                        </select>
                        </div>
                          <div class="form-group mb-3">
                            <label for="">Chapter Name</label>
                            
                             <select  class="form-control chaptername" name="chapter">
                            <option value="">-- No Chapter --</option>
                            @foreach ($chapters as $chapter)
                            <option value="{{$chapter->chapter_id??''}}">{{$chapter->chapter_name??''}}
                                
                            </option>
                            @endforeach
                        </select>
                        </div>
                         
                        <div class="form-group mb-3">
                            <label for="">Category Name</label>
                            
                            <select  class="form-control custom-select"  name="category">
                            <option class="category_ajax_val">{{$ticketlist[0]->category??''}}</option>
                            @foreach ($categories as $category)
                            <option value="{{$category->name??''}}">{{$category->name??''}}
                                
                            </option>
                            @endforeach
                        </select>

                        </div>
    <div class="form-group mb-3">
                            <label for="">Issue priority</label>
                           
                             <select class="form-control issue_priority" name="issue_priority">
                                   
                                    <option value="High">High</option>
                                    <option value="Medium">Medium</option>
                                    <option value="Low">Low</option>
                                  </select>
                        </div>
                        <div class="form-group mb-3">
                          <label for="">Issue Status</label>
                         
                            <select class="form-control issue_status" name="issue_status">
                            
                            <option value="pending">Pending</option>
                            <option value="assigned">Assigned</option>
                            <option value="inprogress">In Progress</option>
                            <option value="completed">Completed</option>
                            </select>
                       
                        </div>
                        
                         <div class="form-group mb-3">
                            <label for="">Upload file   :</label><span class="file_path_update"></span>
                            <input type="file"  class="form-control " name="files[]" value="" id="files" multiple>
                            
                          </div>
                          <div class="form-group mb-2">
                                       <div id="moreImageUpload"></div>
                                        <div class="clear"></div>
                                          <div id="moreImageUploadLink" >
                                            <a href="javascript:void(0);" id="attachMore">Attach another file</a>
                                          </div>
                        </div>
                       
                               
                        
                        <div class="form-group mb-3">
                            <input type="submit" class="btn btn-primary update_ticket" value="Update Ticket">
                        </div>


                    </form>
</div>


<div class="share" style="display: none;">
    <input type="text" class="form-control">
    </div>
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
                       <div><img src=""class="mr-2 open_pop"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade bd-example-modal-lg" tabindex="-1"  id="share" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      ...
    </div>
  </div>
</div>

<!-- Small modal -->



        
      </div>


   </section>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
 <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<script type="text/javascript">
        $(document).ready(function () {
         // let table = new DataTable('#myTable');
           $( ".row_position" ).sortable({
        delay: 150,
        stop: function() {
            var selectedData = new Array();
            $('.row_position>tr').each(function() {
                selectedData.push($(this).attr("id"));
            });
            updateOrder();
        }
    });
            
         function updateOrder() {
             var order = [];
               
                $('tr#but_search').each(function(index,element) {
                    order.push({
                        id: $(this).attr('data-id'),
                        position: index+1
                    });
                });
        $.ajax({
            type: "POST",
                    dataType: "json",
                    url: "{{ url('post-reorder') }}",
            data:{order:order},
            success:function(response){
                 if (response.status == "success") {
                            console.log(response);
                        } else {
                            console.log(response);
                        }
            }
        });
    }
});
    </script>
<script type="text/javascript">
   // let table = new DataTable('#myTable');
   //$('#myTable tbody tr:first-child').addClass('highlight');




  
     $( ".fetchval" ).on( "change", function() {
        window.location.href= "{{url('viewticket')}}?department="+$('#department').val()+'&&category='+$('#category').val()+'&&priority='+$('#priority').val()+'&&status='+$('#status').val()+'&&date_from='+$('#date_from').val()+'&&date_to='+$('#date_to').val();
       });


     $('body').on('change',".status_change",function() {
        var statuschanged=$(".status_change").val();
        var id=$(this).data('id');
        //alert(id);
         $.ajax({
      type: "get",
      url: '{{url("tickets_status_change")}}',
      data: {
        id: id , statuschanged:statuschanged
      },
      success: function(data){
        //alert(data.days);
        

        alert("Status Updated");
         window.location.reload();

      },
  });
 });
     
      $('body').on('click',".delete-comments",function() {
         var result = confirm("Are you sure ?");
      if (!result) {
      return false;
       }
     var id=$(this).data('id');
      //  alert(id);
        var this_class =$(this);
         $.ajax({
      type: "get",
      url: '{{url("delete_comments")}}',
      data: {
        'id': id
      },
      success: function(data){
          Swal.fire({
          position: 'between',
            icon: 'success',
          title: 'Comment Deleted Successfully',
          showConfirmButton: false,
          timer: 1500
        })
          this_class.parents('.removecomment').remove();
      },
        });
      });


 $('body').on('click',"#Resetfilters",function() {
   //localStorage.clear()
//window.location.href= "{{url('viewticket')}}";
$.ajax({
    type: 'GET',
    url: '{{url('removefilter')}}',
    success: function(msg) {
        
           window.location.href= "{{url('viewticket')}}";

        
    }
});
 });
  $('body').on('click',".reply",function() {
 var id = $(this).data("id");
 $('.commentspost_id').val(id);
 $('#comment_data').text("to "+ $(this).data("name"));
  });
 
   $('body').on('click'," .delete_images",function() {
    var result = confirm("Are you sure ?");
      if (!result) {
      return false;
       }
   
        var id = $(this).data('id');
     var key= $(this).data('key');
     //alert(key);
     var src= $(this).data('src');
       //alert(src);
       var this_class =$(this);

    $.ajax({
      type: "get",
      url: '{{url("deleteimages")}}',
      data: {
        'id': id,'key':key,'src':src},
      
      success: function(data){
         Swal.fire({
          position: 'center',
            icon: 'success',
          title: 'Image Deleted Successfully',
          showConfirmButton: false,
          timer: 1500
        })
         this_class.parent('.removeimage').remove();  
        
      },
    });
    });

//     $('body').on('change',".ticket_status",function() {
//       var id = $(this).data('id');
//       var status = $(this).val();

//       alert(id);

//     $.ajax({
//       type: "get",
//       url: '{{url("tickets_status")}}',
//       data: {
//         'id': id,'status':status
//       },
//       success: function(data){

//         console.log(data);
           
//       },
//     });
// });
      
   $(document).ready(function(){
      $('body').on('click',"#but_search",function() {

          $('.highlight').removeClass('highlight');
         $(this).toggleClass('highlight');



         var userid =$(this).data('id');
          $("#showdetails").show();

         $("#LoadingImage").show();
             $(".add_comment").show();
                $('.editshowdetails').hide(); 

        
          
         if(userid > 0){

          loading_data(userid);
            }
         

      });

   });

      function loading_data(userid) {
           // AJAX POST request
           $.ajax({
              url: '{{ url('getUserbyid') }}',
              cache: false,
              type: 'get',
              data: {userid:userid},
              dataType: 'json',
              success: function(response){
               $("#LoadingImage").hide();
       CKEDITOR.instances['editor1'].setData(response.employees.description);
             var images= (response.employees.file_path || '').split(',');
               var image_html ='';
               var updateimage_html = '';

               for (var i = 0; i < images.length; i++) {
                  
                  if(images[i]!=''){

                     image_html+='<span class="removeimage"><button class="delete_images" href=""data-id='+response.employees.id+' data-key='+i+' data-src='+images[i]+'>&times;</button><img src="{{ asset('storage') }}/'+images[i].replace(/^public\//, '')+'" height="100px" width="100px" class="mr-2 images_list" data-src="{{ asset('storage') }}/'+images[i].replace(/^public\//, '')+'"> </span>';
                     updateimage_html+='<img src="{{ asset('storage') }}/'+images[i].replace(/^public\//, '')+'" height="100px" width="100px" class="mr-2 images_list">';

                  }

               }
                $('.statustime').text(response.days);
               $('.ticketid').val(response.employees.id);

                 $('#id').text(response.employees.ticket_unique_id);
                   $('.subjectedit').val(response.employees.subject);
                  $('.subject').html(response.employees.subject);
                     $('#name').text(response.employees.name);

                     //alert(response.employees.name);
                       $('#email').text(response.employees.email);
                        $('.department_ajax').text(response.employees.department);
                          $('.department_ajax_val').val(response.employees.department || '').text(response.employees.department || '-- No Committee --');
                          $('select[name=department]').val(response.employees.department || '');
                         $('.category_ajax').text(response.employees.category);
                            $('.category_ajax_val').val(response.employees.category);
                         $('.descriptiondata').html("");
                            $('.descriptiondata').html(response.employees.description);
                            // $('.descriptionpath').val(response.employees.description.replace(/(<([^>]+)>)/ig,""));

                              $('.issue_priority').val(response.employees.issue_priority);
                                 $('.issue_priorityedit').html(response.employees.issue_priority);
                              $('.issue_status').val(response.employees.issue_status);
                                 $('.issue_statusedit').html(response.employees.issue_status);
                                  $('.selected_committee').html(response.employees.committee);

                                  
                            if (response.employees.chapters === null) {
                                $('.chaptername1').text("No Chapter Available");
                                $('.chaptername').val('');
                            }else{ 
                               // console.log(response.employees.chapters);
                                $('.chaptername1').text(response.employees.chapters.chapter_name);
                                $('.chaptername').val(response.employees.chapters.chapter_id);
                            }
                                    
                               
                             
                              $('.created').text(response.employees.created_at.split('T')[0]);
                             $('.updated').text(response.employees.updated_at.split('T')[0]);
                          if(image_html != '')
                          {
                             $('.file_path').html(image_html);
                             $('.file_path_update').html(updateimage_html);

                  }
                        else
                        {
                         
                         $(".file_path").html("<div class='error_log'><p class='error'>No Image Available.</p></div>");
                         $(".file_path_update").html("<div class='error_log'><p class='error'>No Image Available.</p></div>");
                           
                              }
                            
                               // $('.edit_tickets').attr('href','{{url("edit_ticket")}}/'+response.id);
                                $('.delete_tickets').attr('href','{{url("deleteadmintickets")}}/'+response.employees.id);
                                //$('#form_action').attr('action','{{ url("update-ticket") }}/'+response.employees.id);
                                 $('.shareTicket').data('id',response.employees.ticket_unique_id);
                                 $('.status_change').data('id',response.employees.id);
                          
                                 
                                 $('.comments_list').html(response.comments);
                                 document.dispatchEvent(new CustomEvent('ticket:loaded', {detail: response.employees}));

                            }


                        

           });
      }
      
$('body').on('click',".edit_tickets",function() { 
    $('#showdetails').hide(); 
   $('.editshowdetails').show();
   
});
$('body').on('click',"#edit_cancel",function() {
      $('.editshowdetails').hide(); 
    $('#showdetails').show(); 

   
});

      CKEDITOR.replace( 'editor1' );
    

     $('body').on('click','.images_list',function(){

        $('.open_pop').attr('src',$(this).data('src'));
        $('#imageModal').modal('show');
     })

 $('body').on('click','.shareTicket',function(){
   // alert($(this).data('id'));

       var copyURL = "{{url('searchticket')}}?search="+$(this).data('id');
        // copyURL.copy();  
   
    navigator.clipboard.writeText(copyURL);  
  alert("Copied: " + copyURL);
     });

$('body').on('click','.submit_comment',function(){
 
    var parent_id =0;
    //alert(parent_id);
       var body = $('.body').val();
       var post_id = $('.ticketid').val();
       $.ajax({
           type: "get",
           url:"{{route('reply.add')}}",
           data: { body : body, parent_id : parent_id, post_id : post_id },

           success: function(data) {
              $('.body').val(''); 
             Swal.fire({
          position: 'center',
            icon: 'success',
          title: 'Comment Added Successfully',
          showConfirmButton: false,
          timer: 1500
        }) 
        $('.comments_list').html(data.comments); 

           }

       });


    });

$('body').on('submit','.update_ticket_form',function(e){
    var id = $('.ticketid').val();
    if (window.CKEDITOR && CKEDITOR.instances.editor1) CKEDITOR.instances.editor1.updateElement();
    var formData = new FormData(this);

     formData.append('id',id); 
        e.preventDefault();    
     $.ajax({
           type: "post",
           url:"{{ url('update-ticket') }}",
           data:formData,
            processData: false,
            contentType: false,
           success: function(data) {
              loading_data(id);
              $('.editshowdetails').hide();
              $('#showdetails').show();
             Swal.fire({
            position: 'center',
            icon: 'success',
          title: 'Ticket Updated Successfully',
          showConfirmButton: false,
          timer: 1500
        })
             $('.editshowdetails').hide(); 
              $('#showdetails').show(); 

           }
       });
    });

 </script> 

@include('categories.script')
<script src="{{ asset('dist/js/ticket-workspace.js') . '?v=' . filemtime(public_path('dist/js/ticket-workspace.js')) }}"></script>
</body>
</html>

