<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Login - Audiostudio</title>
  <meta name="csrf-token" content="{{ csrf_token() }}">
<link href="/assets/css/styles.css" rel="stylesheet"></head>
<body>
<div class="auth-page">
  <div class="auth-box">
    <div class="marketing-col">
      <div class="music-bubble">
        <div class="bubble-wrap">
          <img src="/assets/img/music-bubble.svg" class="bubble" alt="">
          <img src="/assets/img/music-icon.svg" class="icon" alt="">
        </div>
      </div>
      <img src="/assets/img/mic.svg" class="marketing-mic" alt="">

      <img src="/assets/img/user1.png" class="marketing-user1" alt="">

      <div class="eclipse"></div>
      <img src="/assets/img/beautiful-afro-american.png" class="marketing-photo" alt="">

      <img src="/assets/img/oval.svg" class="marketing-oval" alt="">

      <img src="/assets/img/curly-pointer.svg" class="curly-pointer" alt="">

      <div class="marketing-card">
        <div class="image-wrap">
          <img src="/assets/img/user2.png" class="marketing-card-user" alt="">
        </div>
        <div class="card-details">
          <div class="card-skeleton card-skeleton1"></div>
          <div class="card-skeleton card-skeleton2"></div>
          <div class="card-skeleton card-skeleton3"></div>
        </div>
      </div>
    </div>
    <div class="form-col">
      <div class="form-col-content">
        <h1 class="logo-type">audiostudio.ai</h1>
		@yield('content')
      </div>
    </div>
  </div>
</div>
<script type="text/javascript" src="./assets/js/bundle.js"></script></body>
@yield('js')
</html>
