<!DOCTYPE html>
<html lang="en">

<head>
    <base href="/public">
    @include('home.homecss')
</head>

<body>

    <div style="text-align: center;" class="col-md-12">

        @if($posts->isNotEmpty())
            @foreach($posts as $post)
                <div style="width: 100%; text-align: center;">
                    <div style="display: inline-block;">
                        <img style="padding: 20px" src="/postimage/{{ $post->image }}" alt="Post Image">
                    </div>
                </div>

                <h1 style="font-size: 24px;">{{ $post->title }}</h1>

                <p><b>Post by {{ $post->name }}</b></p>
                <p><b>{{ $post->description }}</b></p>

                <!--3rd approach for link items-->
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
            @endforeach
        @else
            <h2>No results found for your search.</h2>
        @endif

    </div>

    @include('home.footer')
</body>

</html>
