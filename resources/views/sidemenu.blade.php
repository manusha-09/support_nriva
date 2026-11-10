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

      #sidebar .assigned-menu summary {padding:10px 8px;color:#fff;text-align:center;cursor:pointer;list-style:none;font-size:14px;}
      #sidebar .assigned-menu summary::-webkit-details-marker {display:none;}
      #sidebar .assigned-menu summary > span {display:block;font-size:22px;margin-bottom:5px;}
      #sidebar .assigned-submenu {margin:0;background:#12384d;}
      #sidebar .assigned-submenu li a {padding:10px 4px;font-size:11px;line-height:1.4;white-space:normal;overflow-wrap:break-word;}
      #sidebar.active ul.components li a .assigned-count,
      #sidebar .assigned-submenu a .assigned-count {display:inline-flex!important;align-items:center;justify-content:center;min-width:12px;width:auto;height:auto;padding:1px 3px;margin:0 0 0 2px;border-radius:6px;background:#e8f3ff;color:#154466;font-size:9px!important;font-weight:600;line-height:1.1!important;vertical-align:middle;}
    </style>
  <div class="wrapper d-flex align-items-stretch">
      <nav id="sidebar" class="active">

        <ul class="components mb-5 ">
          <li class="">
            <a href="{{ Auth::user()->isSupportAdmin() ? route('admin') : route('member') }}"><span class="fa fa-home"></span>DashBoard</a>
          </li>
          @if(Auth::user()->isSupportAdmin())
          <li>
               <a href="{{route('viewticket')}}"><span class="fa fa-user"></span> All Tickets</a>
          </li>
          @else
          @php
            $assignedCounts = [];
            foreach (['committee', 'chapter', 'me'] as $assignedScope) {
                $assignedCounts[$assignedScope] = \App\Services\AssignedTickets::query(Auth::user(), $assignedScope)->count();
            }
          @endphp
          <li>
            <a href="{{route('mytickets')}}"><span class="fa fa-user"></span>My Tickets</a>
          </li>
          <li>
            <details class="assigned-menu" {{ request()->is('assigned-to/*') ? 'open' : '' }}>
              <summary><span class="fa fa-inbox" aria-hidden="true"></span>Assigned To <i class="fa fa-angle-down" aria-hidden="true"></i></summary>
              <ul class="list-unstyled assigned-submenu">
                <li><a href="{{ route('assigned.tickets', 'committee') }}">My Committee Tickets <span class="assigned-count" data-assigned-count="committee" title="Total tickets">{{ $assignedCounts['committee'] }}</span></a></li>
                <li><a href="{{ route('assigned.tickets', 'chapter') }}">My Chapter Tickets <span class="assigned-count" data-assigned-count="chapter" title="Total tickets">{{ $assignedCounts['chapter'] }}</span></a></li>
                <li><a href="{{ route('assigned.tickets', 'me') }}">To Me <span class="assigned-count" data-assigned-count="me" title="Total tickets">{{ $assignedCounts['me'] }}</span></a></li>
              </ul>
            </details>
          </li>
          @endif
          <li>
            <a href="{{route('createticket')}}"><span class=" fas fa-pen"></span>CreateTicket</a>
          </li>
         <!--  <li>
            <a href="#" class="tereeview"><span class="fa fa-cogs"></span>Masters</a>
          </li> -->

          @if(Auth::user()->isSupportAdmin())
           <li>

           <a href="{{url('/tickets') }}"><span class="fa fa-plus-square-o"></span>Categories</a>

          </li>




           <li>
             <a href="{{route('projects')}}"><span class="fas fa-list"></span>Projects</a>
          </li>
                <li>
            <a href="{{route('logo_edit')}}"><span class=" fas fa-pen"></span>Manage&nbsp;Data</a>
          </li>
          <li>
            <a href="{{route('ticket.settings')}}"><span class="fa fa-cog"></span>Settings</a>
          </li>
          @endif
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
