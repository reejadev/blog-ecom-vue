<!DOCTYPE html>
<html lang="en">

<head>
    @include('home.homecss')
</head>

<!-- Google tag (gtag.js) -->
<!-- <script async src="https://www.googletagmanager.com/gtag/js?id=G-EJVW9FDCQ8"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'G-EJVW9FDCQ8');
</script>
  
  < Event snippet for Purchase conversion page >
<script>
  gtag('event', 'conversion', {
      'send_to': 'AW-11368418006/jJt5CNPg8vMYENaV8awq',
      'transaction_id': ''
  });
</script> -->




<body>
    <!-- header section start -->

    @include('home.homeheader')
    <!-- banner section start -->
    @include('home.homebanner')
    <!-- banner section end -->
    </div>
    <!-- header section end -->
    <!-- services section start -->
    @include('home.homeservices')
    <!-- services section end -->
    <!-- about section start -->

    @include('home.homeabout')

    <!-- about section end -->
    <!-- blog section start -->

    <!-- blog section end -->
    <!-- client section start -->

    <!-- client section start -->
    <!-- choose section start -->

    <!-- choose section end -->
    <!-- footer section start -->
    @include('home.footer')
</body>

</html>