<!DOCTYPE html>
<html lang="en">
   <head>
      @include('home.homecss')
   </head>

   <style type="text/css">
.div_deg
{
    text-align:center;
}

.post_title
{
    font-size:30px;
font-weight:bold;
color:white;
}
    </style>
   <body>
      <!-- header section start -->
    
        @include('home.homeheader')

        @if(session()->has('message'))

<div class="alert alert-success">
  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
  {{session()->get('message')}}
</div>

@endif


        <div class="div_deg">  
        <h1 class="post_title">Add Post</h1>
        <div>
<form action="{{url('user_post')}}" method="POST" enctype="multipart/form-data">
@csrf


  <div class="form-group">
    <label for="title">Post Title</label>
    <input type="text" id="title" name="title">
  </div>

  <div class="form-group">
    <label for="description">Post Description</label>
    <textarea id="description" name="description"></textarea>
  </div>

  <div class="form-group">
    <label for="image">Post Image</label>
    <input type="file" id="image" name="image">
  </div>

  <div>
    <input type="submit" value="Add Post" class="btn btn-primary">
  </div>
</div>

</form>
        </div>



       
      @include('home.footer')
   </body>
</html>