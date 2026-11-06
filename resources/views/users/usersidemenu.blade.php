 <aside class="main-sidebar">
    <!-- Brand Logo -->
    <a href="" class="brand-link p-0">
      <img src="{{asset('storage/'.preg_replace('#^public/#', '', $logodetails->logoimage))}}" alt="" class="brand-image img-circle elevation-3 ">
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
            <a href="{{route('member')}}"><span class="fa fa-home"></span>DashBoard</a>
          </li>
          <li>
               <a href="{{route('mytickets')}}"><span class="fa fa-user"></span>My Tickets</a>
          </li>
          <li>
            <a href="{{route('createticket')}}"><span class="fa fa-sticky-note"></span>CreateTicket</a>
          
           <li>
            <a href="{{route('user_committee')}}"><span class="fa fa-sticky-note"></span>AllTickets</a>
          </li>
       
          <li>
             <a href="{{route('logout')}}"><span class="fa fa-paper-plane"></span>Logout</a>
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