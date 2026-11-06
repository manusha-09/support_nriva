@include('users.usernavbar')
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  @include('users.usersidemenu')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h5 class="m-0">Dashboard</h5>
          </div>
         
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="">Home</a></li>
             
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
        
      </div><!-- /.container-fluid -->
    </div>
    
    <section class="content">
      <div class="container-fluid">
        
        <div class="row">
        
          <div class="col-lg-3 col-6">
           
            <div class="small-box bg-info">
              <div class="inner">
                <h3>{{$data_assign}}</h3>

                <p>Assigned Tickets</p>
              </div>
              <div class="icon">
                <i class="ion ion-bag"></i>
              </div>
              <a href="{{route('viewticket')}}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <div class="col-lg-3 col-6">
           
           <div class="small-box bg-success">
              <div class="inner">
                <h3>{{$data_list}}</h3>

                <p>Pending Tickets</p>
              </div>
              <div class="icon">
                 <i class="ion ion-stats-bars"></i>
              </div>
              <a href="{{route('viewticket')}}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <div class="col-lg-3 col-6">
           
            <div class="small-box bg-warning">
              <div class="inner">
                <h3>{{$data_complete}}</h3>

                <p>Completed Tickets</p>
              </div>
              <div class="icon">
                <i class="ion ion-person-add"></i>
              </div>
              <a href="{{route('viewticket')}}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <div class="col-lg-3 col-6">
           
            <div class="small-box bg-danger">
              <div class="inner">
                <h3>{{$data_incomplete}}</h3>

                <p>Incomplete Tickets</p>
              </div>
              <div class="icon">
                <i class="ion ion-pie-graph"></i>
              </div>
              <a href="{{route('viewticket')}}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
</div>

</div>
</section>
@include('categories.script')
</body>
</html>

