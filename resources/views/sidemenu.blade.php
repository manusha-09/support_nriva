 <aside class="main-sidebar">
    <!-- Brand Logo -->
    <a href="#" class="brand-link p-0">
      <img src="{{asset('storage/'.preg_replace('#^public/#', '', $logodetails->logoimage))}}" alt="" class="brand-image img-circle elevation-3 " width = "50">
      <!-- <span class="brand-text font-weight-light" style="font-size: 18px;"></span> -->
    </a>

    <!-- Sidebar -->
    <style type="text/css">
      .active{
        background-color:skyblue;
      }
   
    </style>
  <div class="wrapper d-flex align-items-stretch">
      <nav id="sidebar" class="active">
        
        <ul class="components mb-5 ">
          <li class="">
            <a href="{{url('admin') }}"><span class="fa fa-home"></span>DashBoard</a>
          </li>
          <li>
               <a href="{{route('viewticket')}}"><span class="fa fa-user"></span> All Tickets</a>
          </li>
          <li>
            <a href="{{route('createticket')}}"><span class=" fas fa-pen"></span>CreateTicket</a>
          </li>
         <!--  <li>
            <a href="#" class="tereeview"><span class="fa fa-cogs"></span>Masters</a>
          </li> -->
       
           <li>
             
           <a href="{{url('/tickets') }}"><span class="fa fa-plus-square-o"></span>Categories</a>

          </li>
           <li>
            <a href="{{route('department')}}"><span class="fa fa-users"></span>Committees</a>

          </li>


           <li>
           <a href="{{route('createusers')}}"><span class="fa fa-user"></span>Users</a>

          </li>
           <li>
             <a href="{{route('projects')}}"><span class="fas fa-list"></span>Projects</a>
          </li>
                <li>
            <a href="{{route('logo_edit')}}"><span class=" fas fa-pen"></span>Manage&nbsp;Data</a>
          </li>
          <li>
             <a href="{{route('logout')}}" ><span class="fa fa-paper-plane"></span>Logout</a>
          </li>
        </ul>

         
      </nav>

  </aside>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
<script type="text/javascript">
$(document).ready(function() {

var url = window.location.href;

$('body').find('a[href*="'+url+'"]').addClass('active');
//alert($('body').find('a[href*="'+url+'"]').attr('class'));
if($('body').find('a[href*="'+url+'"]').attr('class')=='components active'){
  $('body').find('a[href*="'+url+'"]').parents('.sub').find('.icon').addClass('active');
   $('body').find('.nav-treeview').show();
}

});



</script>
