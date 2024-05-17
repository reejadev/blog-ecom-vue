<!DOCTYPE html>
<html>
  <head> 
    <base href="/public">
    @include('home.homecss')

  <style type="text/css">

.post_title
{
  font-size: 30px;
  font-weight: bold;
  text-align: center;
  padding: 30px;
  color: white;
}



.center {
display: flex;
flex-direction: column;
align-items: center;
}

.form-group {
margin-bottom: 15px;
text-align: left;
}

label {
display: block;
margin-bottom: 5px;
}

input[type="text"],
textarea,
input[type="file"],
.btn {
width: 100%;
padding: 8px;
border: 1px solid #ccc;
border-radius: 4px;
box-sizing: border-box;
}

textarea {
height: 100px;
}

.btn {
width: auto;
}

</style>


  </head>
  <body>
  @include('home.homeheader')
    <div class="align-center">
      <!-- Sidebar Navigation-->
   
      <!-- Sidebar Navigation end-->
   
      <div class="page-content">
    
      @if(session()->has('message'))

<div class="alert alert-success">
  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
  {{session()->get('message')}}
</div>

@endif



<div class="center">
<form action="{{url('update_post',$posts->id)}}" method="POST" enctype="multipart/form-data">
@csrf


<div class="center mb-4 form-group">
    <label style="font-weight: bold; margin-top: 4px; font-size: larger;" for="title">Edit Post </label>
      </div>

  <div class="form-group">
    <label for="title">Post Title</label>
    <input type="text" id="title" name="title" value="{{$posts->title}}">
  </div>

  <div class="form-group">
    <label for="description">Post Description</label>
    <textarea id="description" name="description"> {{$posts->description}}</textarea>
  </div>

<div>
<label>Old Image</label>
<img src='/postimage/{{$posts->image}}'  width="100px" height="100px">
</div>


  <div class="form-group">
    <label for="image">Post Image</label>
    <input type="file" id="image" name="image" value="{{$posts->image}}">
  </div>

  <div>
    <input type="submit" value="Update" class="btn btn-primary">
  </div>


</form>
        </div>


</div>



      <!-- services section end -->
      <!-- about section start -->


     
      <!-- about section end -->
      <!-- blog section start -->
      
      <!-- blog section end -->
      <!-- client section start -->
      
      <!-- client section start -->
      <!-- choose section start -->
    
      <!-- choose section end -->
      <!-- footer section start -->
   
  </body>
</html>