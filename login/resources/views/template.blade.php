<!doctype html>
<html>
  <head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="/css/app.css">
    @yield('head')
  </head>
  <body>
    <div class='banner'>
      <a href='/login' class='banner-link login-link'>Login</a>
      <a href='/' class='banner-link home-link'>Home</a>
      <a href='/blog' class='banner-link blog-link'>Blog</a>
    </div>
    <div id="app" class = 'content'>
      <div class='loading' v-if='loading'>
        <h1 class='loading-head'>Loading...</h1>
        <p>This may take a second, depending on how slow your connection is.</br>If it's been more than a few seconds, then there might be something wrong on my end. Please let me know at latticusroberts@gmail.com</p>
      </div>
      @yield('content')
    </div>
  </body>
  <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
  <scirpt src="/js/axios.min.js"></scirpt>
  <script src="/js/vue.js"></script>
  <script src="/js/app.js"></script>
</html>
