<!DOCTYPE html>
<html>
  <head> 
  @include('admin.css')
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
 @include('admin.header')
    <div class="d-flex align-items-stretch">
      <!-- Sidebar Navigation-->
     @include('admin.sidebar')
      <!-- Sidebar Navigation end-->
      <div class="page-content">

@if(session()->has('message'))

<div class="alert alert-success">
  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
  {{session()->get('message')}}
</div>

@endif

        <h1 class="post_title">Add Post</h1>
        <div>
<form action="{{url('add_post')}}" method="POST" enctype="multipart/form-data">
@csrf

<div class="center">
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
    <input type="submit" class="btn btn-primary">
  </div>
</div>

</form>
        </div>



        
     
</div>
      @include('admin.footer')
  </body>
</html>