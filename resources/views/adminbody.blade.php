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
                <h3>{{$completedcount['assigned']??0}}</h3>

                <p>Assigned Tickets</p>
              </div>
              <div class="icon">
                <i class="ion ion-bag"></i>
              </div>
              <a href="{{route('viewticket', ['status' => 'assigned', 'dashboard' => 1])}}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-success">
              <div class="inner">
                <h3>{{$completedcount['inprogress']??0}}</h3>

                <p>In Progress tickets</p>
              </div>
              <div class="icon">
                <i class="ion ion-stats-bars"></i>
              </div>
              <a href="{{route('viewticket', ['status' => 'inprogress', 'dashboard' => 1])}}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-warning">
              <div class="inner">
                <h3>{{$completedcount['pending']??0}}</h3>

                <p>Pending Tickets</p>
              </div>
              <div class="icon">
                <i class="ion ion-person-add"></i>
              </div>
              <a href="{{route('viewticket', ['status' => 'pending', 'dashboard' => 1])}}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-danger">
              <div class="inner">
                <h3>{{$completedcount['completed']??0}}</h3>

                <p>Completed Tickets</p>
              </div>
              <div class="icon">
                <i class="ion ion-pie-graph"></i>
              </div>
              <a href="{{route('viewticket', ['status' => 'completed', 'dashboard' => 1])}}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
        </div>
        <div class="row">
          <h5>By Committees</h5>
          <table class="table table-striped">
  <thead>
    <tr>
      <th style="width: 150px !important;">Committees</th>
 	<th >Assigned Tickets</th>
       <th >InProgress Tickets</th>

	<th >Pending Tickets</th>

 	<th >Completed Tickets</th>
    </tr>
  </thead>
  <tbody>
      @foreach($list as $lists)
    <tr>

      	<td>{{$lists->department}}</td>
 	<td>{{count($lists->tickets_assigned)}}</td>

      	<td>{{count($lists->tickets_in_progress)}}</td>
      	<td>{{count($lists->pending_tickets)}}</td>

 	<td>{{count($lists->tickets_completed)}}</td>

    </tr>
        @endforeach




  </tbody>
</table>
        </div>

      </div>
    </section> 
    <!-- /.content -->
  </div>


