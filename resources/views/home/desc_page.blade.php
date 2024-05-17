<!DOCTYPE html>
<html lang="en">
   <head>
   <base href="/public">
      @include('home.homecss')
   </head>
   <body>
      <!-- header section start -->
    
        @include('home.homeheader')
     
      </div>
      <!-- header section end -->
      <!-- services section start -->
      <div style="text-align: center;" class="col-md-12">
                     
      <div style="width: 100%; text-align: center;">
    <div style="display: inline-block;">
        <img style="padding: 20px" src="/postimage/{{$post->image}}">
    </div>
</div>




<h1 style="font-size: 24px;">{{$post->title}}</h1>

                        <p><b>Post by {{$post->name}}</b></p>
                        <p><b>{{$post->description}}</b></p>
                  </div>

     
      @include('home.footer')
   </body>
</html>




