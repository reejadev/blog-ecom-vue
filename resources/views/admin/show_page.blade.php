<!DOCTYPE html>
<html>
  <head> 

  <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"
   integrity="sha512-AA1Bzp5Q0K1KanKKmvN/4d3IRKVlv9PYgwFPvm32nPO6QS8yH1HO7LbgB1pgiOxPtfeg5zEn2ba64MUcqJx6CA==" 
  crossorigin="anonymous" referrerpolicy="no-referrer"></script>

  @include('admin.css')

  </head>
  <body>
 @include('admin.header')
    <div class="d-flex align-items-stretch">
      <!-- Sidebar Navigation-->
     @include('admin.sidebar')
      <!-- Sidebar Navigation end-->
      <div class="page-content" style="overflow-x:auto;">

      @if(session()->has('message'))

<div class="alert alert-success">
  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
  {{session()->get('message')}}
</div>

@endif


<div style="padding: 20px;" >

<h3>All Post</h3>
  <table bgcolor="black">
    <tr>
      <th style="padding: 30px"> Title </th>
      <th style="padding: 30px"> Description </th>
      <th style="padding: 30px">Post by  </th>
      <th style="padding: 30px">Post Status  </th>
      <th style="padding: 30px">UserType  </th>
      <th style="padding: 30px">Image  </th>
   
      <th colspan="3" style="padding: 30px"> Action  </th>
      <th  colspan="3" style="padding: 30px"> Post Accept  </th>
      <th  colspan="3" style="padding: 30px"> Post Reject </th>
  
    </tr>

    @foreach($post as $posts)
    <tr align="center">

    <td>{{$posts->title}}</td>
    <td style="width: 400px; height: 100px;">{{$posts->description}}</td>
    <td style="width: 200px; height: 100px;">{{$posts->name}}</td>

    <td style="width: 200px; height: 100px;">{{$posts->post_status}}</td>

        <td style="width: 200px; height: 100px;">{{$posts->usertype}}</td>

    <td><img height="100px" width="100px" padding="20px" src="postimage/{{$posts->image}}"></td>
    
    <td><a href="{{url('/edit_page',$posts->id)}}" class="btn btn-success">Edit</a></td>

    <td><a href="{{url('/deletemenu',$posts->id)}}" class="btn btn-danger"
     onclick="confirmation(event)">Delete</a></td>

     <td colspan="3"><a onclick="return confirm('are you sure to accept this post?')" href="{{url('/accept_post',$posts->id)}}" class="btn btn-secondary"
    >Accept</a></td>

     <td colspan="3"><a onclick="return confirm('are you sure to reject this post?')" href="{{url('/reject_post',$posts->id)}}" class="btn btn-primary"
    >Reject</a></td>
     
    </tr>
    @endforeach
  </table>
    </div>


    </div>
</div>

    @include('admin.footer')

<script type="text/javascript">

function confirmation(ev)
{
ev.preventDefault();
var urlToRedirect=ev.currentTarget.getAttribute('href');
console.log(urlToRedirect);
swal({

  title:"Are you Sure",
  text:"you wont be able to revert this delete",
  icon:"warning",
  buttons:true,
  dangerMode:true,
})

.then((willCancel)=>
{

if(willCancel)
{
window.location.href=urlToRedirect;
}

});


}

</script>
  </body>
</html>