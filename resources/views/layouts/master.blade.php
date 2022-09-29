<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Dashboard</title>
  <link rel="shortcut icon" href="/img/new-logo-2.png" type="image/x-icon">

<link href="/assets/css/styles.css" rel="stylesheet"></head>
<link rel="stylesheet" href="https://unpkg.com/element-ui/lib/theme-chalk/index.css">
<link rel="stylesheet" href="https://unpkg.com/vue-multiselect@2.1.0/dist/vue-multiselect.min.css">
<style>
  .swal-modal{
    background: rgb(29,31,66);
  }
  .swal-title, .swal-text{
    color : #FFF;
  }
</style>
<link href="/css/text-tip.css" rel="stylesheet">
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">

@yield('style')
<body>
  
<div class="{{ $pageClass ?? 'dashboard-page' }}">
  <nav class="navbar navbar-expand-lg navbar-light bg-transparent">
  <div class="container">
    <a class="logo-type" href="{{route('user.dashboard')}}">        <img src="/img/new-logo-2.png" style="height: 40px" class="marketing-card-user" alt="">
    </a>

    <ul class="navbar-nav ml-auto">
      <li class="nav-item">
        <a class="nav-link active" aria-current="page" href="#">
            <span class="icon"><svg width="25" height="30" viewBox="0 0 25 30" fill="none" xmlns="http://www.w3.org/2000/svg" class=""><path d="M22.2222 0H2.77778C2.04107 0 1.33453 0.292658 0.813592 0.813592C0.292658 1.33453 0 2.04107 0 2.77778V22.2222C0 22.9589 0.292658 23.6655 0.813592 24.1864C1.33453 24.7073 2.04107 25 2.77778 25H8.33333L12.5 29.1667L16.6667 25H22.2222C23.75 25 25 23.75 25 22.2222V2.77778C25 1.25 23.75 0 22.2222 0ZM13.8889 22.2222H11.1111V19.4444H13.8889V22.2222ZM16.7639 11.4583L15.5139 12.7361C14.5139 13.75 13.8889 14.5833 13.8889 16.6667H11.1111V15.9722C11.1111 14.4444 11.7361 13.0556 12.7361 12.0417L14.4583 10.2917C14.9722 9.79167 15.2778 9.09722 15.2778 8.33333C15.2778 6.80556 14.0278 5.55556 12.5 5.55556C10.9722 5.55556 9.72222 6.80556 9.72222 8.33333H6.94444C6.94444 5.26389 9.43056 2.77778 12.5 2.77778C15.5694 2.77778 18.0556 5.26389 18.0556 8.33333C18.0556 9.55556 17.5556 10.6667 16.7639 11.4583Z" fill="white"></path></svg></span>
        </a>
      </li>
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="notification-dropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            <span class="icon"><svg width="25" height="29" viewBox="0 0 25 29" fill="none" xmlns="http://www.w3.org/2000/svg" class=""><path d="M12.5 28.573C13.4472 28.573 14.3556 28.1967 15.0254 27.5269C15.6952 26.8572 16.0714 25.9488 16.0714 25.0016H8.92857C8.92857 25.9488 9.30485 26.8572 9.97462 27.5269C10.6444 28.1967 11.5528 28.573 12.5 28.573ZM14.2768 1.96406C14.3017 1.71577 14.2743 1.465 14.1964 1.22794C14.1184 0.990884 13.9917 0.772794 13.8242 0.587738C13.6568 0.402681 13.4525 0.254767 13.2244 0.153535C12.9963 0.0523026 12.7495 0 12.5 0C12.2505 0 12.0037 0.0523026 11.7756 0.153535C11.5475 0.254767 11.3432 0.402681 11.1758 0.587738C11.0083 0.772794 10.8816 0.990884 10.8036 1.22794C10.7257 1.465 10.6983 1.71577 10.7232 1.96406C8.70485 2.3746 6.8904 3.47006 5.58708 5.06496C4.28376 6.65985 3.57169 8.65616 3.57143 10.7158C3.57143 12.6766 2.67857 21.4301 0 23.2158H25C22.3214 21.4301 21.4286 12.6766 21.4286 10.7158C21.4286 6.39442 18.3571 2.78728 14.2768 1.96406Z" fill="white"></path></svg></span>
        </a>
        <ul class="dropdown-menu dropdown-menu-end" style="background:rgb(53, 59, 90);" aria-labelledby="notification-dropdown">
          <li style="color: #FFF; padding:5px;">
            No new message
          </li>
        </ul>
      </li>
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            <span class="icon"><svg width="25" height="29" viewBox="0 0 25 29" fill="none" xmlns="http://www.w3.org/2000/svg" class=""><path d="M24.625 20.6923C23.0799 19.0183 21.205 17.6823 19.1182 16.7686C17.0314 15.8548 14.7781 15.3831 12.5 15.3831C10.2219 15.3831 7.96856 15.8548 5.88179 16.7686C3.79501 17.6823 1.92005 19.0183 0.375 20.6923C0.136458 20.9561 0.00302143 21.2982 0 21.6538V27.4231C0.0050562 27.8023 0.159242 28.1642 0.429181 28.4305C0.69912 28.6969 1.06309 28.8462 1.44231 28.8462H23.5577C23.9402 28.8462 24.3071 28.6942 24.5776 28.4237C24.848 28.1532 25 27.7864 25 27.4038V21.6346C24.9923 21.2856 24.8592 20.9511 24.625 20.6923Z" fill="white"></path><path d="M12.5 13.4615C16.2173 13.4615 19.2308 10.4481 19.2308 6.73077C19.2308 3.01347 16.2173 0 12.5 0C8.7827 0 5.76923 3.01347 5.76923 6.73077C5.76923 10.4481 8.7827 13.4615 12.5 13.4615Z" fill="white"></path></svg></span>
        </a>
        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
          {{-- <li><a class="dropdown-item" href="{{ route('admin.writer') }}">Manage writer</a></li> --}}
          <li><a class="dropdown-item" href="{{ route('user.settings') }}">Account</a></li>
          {{-- <li><a class="dropdown-item" href="#">Billing</a></li> --}}
          <li><hr class="dropdown-divider"></li>
          <li><a class="dropdown-item" href="{{ route('user.logout') }}">Logout</a></li>
        </ul>
      </li>
    </ul>
  </div>
</nav>


  <div class="main">
    @yield('side-bar')


    <div class="main-col">
      @yield('content')
    </div>
  </div>

  

</div>
<script src="/js/text-tip.js"></script>
<script src="{{URL::asset('js/jquery-3.6.0.min.js')}}"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>

{{-- <script src="{{URL::asset('plugins/bootstrap/popper.min.js')}}"></script> --}}
{{-- <script src="{{URL::asset('plugins/bootstrap/js/bootstrap.min.js') }}"></script> --}}
{{-- <script src="{{URL::asset('plugins/bootstrap/js/bootstrap5.min.js')}}?v=1"></script> --}}
{{-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js"></script> --}}
{{-- <script type="text/javascript" src="/assets/js/bundle.js"></script></body> --}}
@yield('js')

</html>
