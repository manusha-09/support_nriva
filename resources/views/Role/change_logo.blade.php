@include('navbar')

@include('sidemenu')
<div class="content-wrapper  ptop">
   <!-- Content Header (Page header) -->
   <section class="content" >
      <div class="container-fluid">
         <!-- Small boxes (Stat box) -->
       
             
                      <div class="row pt-2">
					<form action="{{('update_logo')}}" method="post" enctype="multipart/form-data" >
						@csrf
					  <div class="form-row">
					    
					   
					
					 
					  <div class="form-row">
					    <div class="form-group col-md-6 col-lg-10">
					      <label for="">Edit Name :</label><span>&nbsp;&nbsp;{{$logodetails->name}}</span>
					      <input type="text" class="form-control"  name="name" value="{{$logodetails->name}}">
					    </div>
					   
					    <div class="form-group col-md-6 col-lg-10">
					      <label for="">Edit Logo :</label><span>&nbsp;&nbsp;<img src="{{asset('storage/'.preg_replace('#^public/#', '', $logodetails->logoimage))}}" height="60" width="60"></span>
					      <input type="file" class="form-control" name="logoimages">
					    </div>
					  </div>
					  <div class="col-md-3">
					  <button type="submit" class="btn btn-primary">Submit</button>
					</div>
					</form>
                      	</div>



        </div>
    </section>
</div>





@include('categories.script')
</body>
</html>