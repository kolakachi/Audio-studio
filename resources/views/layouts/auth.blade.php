<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  @if($whitelabelIsSet == true)
  <title>Login - {{$config->app_name}}</title>
  @else
  <title>Login - Audiostudio</title>
  @endif
 
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <link href="/assets/css/styles.css" rel="stylesheet">
  @if($whitelabelIsSet == true)
    <link rel="shortcut icon" href="{{ $config->media_path }}" type="image/x-icon">
    @else
    <link rel="shortcut icon" href="/img/favicon.png" type="image/x-icon">
    @endif
  <!-- Pixel Code for https://socialproofo.com/demo/ -->
  
<script async src="https://socialproofo.com/demo/pixel/pep6tirgsba5vmp3qvfmjdrxfvvyz5re"></script>
<!-- END Pixel Code -->
</head>
<body>
  <style>
  .btn-primary{
      background: #FFC247 !important;
      border: 1px solid #FFC247 !important;
      color: #131532 !important;
  }



  </style>
  @if($whitelabelIsSet == true)
  <style>
    .auth-page{
      background: {{ $config->color }}
    }
    .auth-page .auth-box{
      background: {{ $config->secondary_color }}
    }
  </style>
  @endif
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
        <div class="text-center">
          @if($whitelabelIsSet == true)
              <img src="{{ $config->media_path }}" style="height: 70px; margin-bottom: 10px" class="marketing-card-user" alt="">
          @else
            <img src="/img/new-logo-2.png" style="height: 70px; margin-bottom: 10px" class="marketing-card-user" alt="">
          @endif
        </div>
		@yield('content')
      </div>
    </div>
  </div>
</div>
<script type="text/javascript" src="./assets/js/bundle.js"></script></body>
<script>
  window.intercomSettings = {
    api_base: "https://api-iam.intercom.io",
    app_id: "sksvfqxn"
  };
</script>

<script>
// We pre-filled your app ID in the widget URL: 'https://widget.intercom.io/widget/sksvfqxn'
(function(){var w=window;var ic=w.Intercom;if(typeof ic==="function"){ic('reattach_activator');ic('update',w.intercomSettings);}else{var d=document;var i=function(){i.c(arguments);};i.q=[];i.c=function(args){i.q.push(args);};w.Intercom=i;var l=function(){var s=d.createElement('script');s.type='text/javascript';s.async=true;s.src='https://widget.intercom.io/widget/sksvfqxn';var x=d.getElementsByTagName('script')[0];x.parentNode.insertBefore(s,x);};if(document.readyState==='complete'){l();}else if(w.attachEvent){w.attachEvent('onload',l);}else{w.addEventListener('load',l,false);}}})();
</script>
@yield('js')
</html>
