<div class="services_section layout_padding">
    <div class="container">
        <h1 class="services_taital">Blog Posts </h1>
        <!--p class="services_text">There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration</p-->
        <div class="services_section_2">
            <div class="row">
                @if(isset($post) && !empty($post))
                @foreach($post as $posts)
                <div class="col-md-4">
                    <div style="width: 300px; height: 200px; border: 1px solid #ccc; overflow: hidden;">
                        <img src="/postimage/{{$posts->image}}" class="services_img"
                            style="width: 100%; height: 100%; object-fit: cover;">
                    </div>
                    <h1 style="font-size: 24px;">{{$posts->title}}</h1>
                    <p><b>Post by {{$posts->name}}</b></p>
                    <div class="btn_main" style="padding-bottom: 100px;"><a href="{{url('/desc_page',$posts->id)}}">Read
                            More...</a></div>

                    @if (Route::has('login'))
                    @auth
                    @if($posts->user && $posts->user->usertype == 'user')
                    <a href="{{ url('/edit_page', $posts->id) }}" class="btn btn-success">Edit</a>
                    <a href="{{ url('/deletemenu', $posts->id) }}" class="btn btn-danger">Delete</a>
                    @endif
                    @endauth
                    @endif

                </div>
                @endforeach
                @endif
            </div>
        </div>
    </div>
</div>