<!DOCTYPE html>
<html lang="en">

<head>
    <base href="/public">
    @include('home.homecss')

</head>


<body>
    <!-- header section start -->

    <!-- @include('home.homeheader') -->

    <!-- </div> -->

    <!-- <div style="text-align: center; padding: 20px;">
        <li class="nav-item">
            <a class="nav-link" href="{{ url('/') }}" style="
        display: inline-block;
        padding: 10px 20px;
        /* background-color: #007bff; */
         background-color: grey; 
        color: white;
        text-align: center;
        text-decoration: none;
        border-radius: 5px;
        font-size: 16px;
        margin-top: 20px;
        font-weight: bold;">Home</a>
        </li>

    </div> -->

    <div style="text-align: center;" class="col-md-12">

        <div style="width: 100%; text-align: center;">
            <div style="display: inline-block;">
                <img style="padding: 20px" src="/postimage/{{ $post->image }}">
            </div>
        </div>




        <h1 style="font-size: 24px;">{{ $post->title }}</h1>

        <p><b>Post by {{ $post->name }}</b></p>
        <p><b>{{ $post->description }}</b></p>

        <!--first approach-->
        <!-- @if($post->link)
        <p>Items to carry:</p>
        <p> <a href="{{ $post->link }}" target="_blank">{{ $post->link }}</a></p>
@endif-->


        <!--2nd approach-->
        <!-- 
@if($post->link)
        <p>Items to carry:</p>
@php
        // Convert '\n' to actual newlines and then split the links
        $links = explode("\n", str_replace('\n',
        "\n", $post->link));
@endphp

@foreach($links as $link)
@if(trim($link))
      
        <p><a href="{{ trim($link) }}" target="_blank"
                style="text-decoration: underline !important;color: red;">{{ trim($link) }}</a></p>
@endif
@endforeach
@endif-->

        <!--3rd approach-->
        @if($post->link)
            <p>Items to carry:</p>
            @php
                // Convert '\n' to actual newlines and then split the items
                $items = array_filter(array_map('trim', explode("\n", str_replace('\n', "\n", $post->link))));
            @endphp

            @foreach($items as $index => $item)
                @if($index % 2 == 0)
                    <!-- Even index: item name -->
                    <p>{{ $item }}</p>
                @else
                    <!-- Odd index: URL -->
                    <p><a href="{{ $item }}" target="_blank"
                            style="text-decoration: underline; color: purple;">{{ $item }}</a></p>
                @endif
            @endforeach
        @endif



    </div>


    @include('home.footer')
</body>

</html>
