<div class="sidebar-col collapsed">
    <ul class="nav flex-column">
      <li class="nav-item">
        <a class="nav-link" href="{{ route('user.dashboard') }}">
            <span class="icon"><svg width="26" height="26" viewBox="0 0 26 26" fill="none" xmlns="http://www.w3.org/2000/svg" class=""><path d="M1.44444 14.4444H10.1111C10.4942 14.4444 10.8616 14.2923 11.1325 14.0214C11.4034 13.7505 11.5556 13.3831 11.5556 13V1.44444C11.5556 1.06135 11.4034 0.693954 11.1325 0.423068C10.8616 0.152182 10.4942 0 10.1111 0H1.44444C1.06135 0 0.693954 0.152182 0.423068 0.423068C0.152182 0.693954 0 1.06135 0 1.44444V13C0 13.3831 0.152182 13.7505 0.423068 14.0214C0.693954 14.2923 1.06135 14.4444 1.44444 14.4444ZM0 24.5556C0 24.9386 0.152182 25.306 0.423068 25.5769C0.693954 25.8478 1.06135 26 1.44444 26H10.1111C10.4942 26 10.8616 25.8478 11.1325 25.5769C11.4034 25.306 11.5556 24.9386 11.5556 24.5556V18.7778C11.5556 18.3947 11.4034 18.0273 11.1325 17.7564C10.8616 17.4855 10.4942 17.3333 10.1111 17.3333H1.44444C1.06135 17.3333 0.693954 17.4855 0.423068 17.7564C0.152182 18.0273 0 18.3947 0 18.7778V24.5556ZM14.4444 24.5556C14.4444 24.9386 14.5966 25.306 14.8675 25.5769C15.1384 25.8478 15.5058 26 15.8889 26H24.5556C24.9386 26 25.306 25.8478 25.5769 25.5769C25.8478 25.306 26 24.9386 26 24.5556V14.4444C26 14.0614 25.8478 13.694 25.5769 13.4231C25.306 13.1522 24.9386 13 24.5556 13H15.8889C15.5058 13 15.1384 13.1522 14.8675 13.4231C14.5966 13.694 14.4444 14.0614 14.4444 14.4444V24.5556ZM15.8889 10.1111H24.5556C24.9386 10.1111 25.306 9.95893 25.5769 9.68804C25.8478 9.41716 26 9.04976 26 8.66667V1.44444C26 1.06135 25.8478 0.693954 25.5769 0.423068C25.306 0.152182 24.9386 0 24.5556 0H15.8889C15.5058 0 15.1384 0.152182 14.8675 0.423068C14.5966 0.693954 14.4444 1.06135 14.4444 1.44444V8.66667C14.4444 9.04976 14.5966 9.41716 14.8675 9.68804C15.1384 9.95893 15.5058 10.1111 15.8889 10.1111Z" fill="white"></path></svg></span>
          <span class="label">Dashboard</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="{{route('user.tts.list-books')}}">
            <span class="icon"><svg width="28" height="39" viewBox="0 0 28 39" fill="none" xmlns="http://www.w3.org/2000/svg" class=""><path d="M14 23.7576C17.9836 23.7576 21.2121 20.5673 21.2121 16.6303V7.12727C21.2121 3.1903 17.9836 0 14 0C10.0164 0 6.78788 3.1903 6.78788 7.12727V16.6303C6.78788 20.5673 10.0164 23.7576 14 23.7576ZM28 16.5455C28 16.3588 27.8473 16.2061 27.6606 16.2061H25.1152C24.9285 16.2061 24.7758 16.3588 24.7758 16.5455C24.7758 22.4976 19.9521 27.3212 14 27.3212C8.04788 27.3212 3.22424 22.4976 3.22424 16.5455C3.22424 16.3588 3.07152 16.2061 2.88485 16.2061H0.339394C0.152727 16.2061 0 16.3588 0 16.5455C0 23.7024 5.37091 29.6079 12.303 30.4436V34.7879H6.13879C5.55758 34.7879 5.09091 35.3945 5.09091 36.1455V37.6727C5.09091 37.8594 5.2097 38.0121 5.35394 38.0121H22.6461C22.7903 38.0121 22.9091 37.8594 22.9091 37.6727V36.1455C22.9091 35.3945 22.4424 34.7879 21.8612 34.7879H15.5273V30.4648C22.54 29.7012 28 23.7618 28 16.5455Z" fill="white"></path></svg></span>
          <span class="label">Audio books</span>
        </a>
      </li>
      <li class="nav-item">
        @if(userHasAccessToEnterprise(Auth::id()))
        <a class="nav-link" href="{{ route('user.agency') }}">
          <span class="icon"><svg width="30" height="28" viewBox="0 0 30 28" fill="none" xmlns="http://www.w3.org/2000/svg" class=""><path d="M15.1519 0L0 12.5675H3.5825V27.5675H26.0825V12.5675H30L15.1519 0ZM18.5462 23.1925H11.4531L12.9406 16.4981C12.0413 15.8731 11.4531 14.9319 11.4531 13.7794C11.4531 11.8806 13.0413 10.38 14.9994 10.38C16.9587 10.38 18.5462 11.9381 18.5462 13.8369C18.5462 14.99 17.9581 15.865 17.0594 16.4881L18.5462 23.1925Z" fill="white"></path></svg></span>                
          <span class="label">Agency</span>
        </a>
        @else
        <a class="nav-link" href="#" data-bs-target="#access-modal" data-bs-toggle="modal">
          <span class="icon"><svg width="30" height="28" viewBox="0 0 30 28" fill="none" xmlns="http://www.w3.org/2000/svg" class=""><path d="M15.1519 0L0 12.5675H3.5825V27.5675H26.0825V12.5675H30L15.1519 0ZM18.5462 23.1925H11.4531L12.9406 16.4981C12.0413 15.8731 11.4531 14.9319 11.4531 13.7794C11.4531 11.8806 13.0413 10.38 14.9994 10.38C16.9587 10.38 18.5462 11.9381 18.5462 13.8369C18.5462 14.99 17.9581 15.865 17.0594 16.4881L18.5462 23.1925Z" fill="white"></path></svg></span>                
            <span class="label">Agency</span>
          </a>
        @endif
      </li>
      <li class="nav-item">
          @if(userHasAccessToEnterprise(Auth::id()))
          <a class="nav-link {{ ($page == 'job-finder')? 'active' : ''}}" href="{{ route('user.job-finder') }}">
            <span class="icon"><svg width="30" height="28" viewBox="0 0 30 28" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M27.8883 22.6258C30.1879 19.7351 31.2179 16.1512 30.7722 12.591C30.3265 9.03084 28.4379 5.75697 25.4844 3.4244C22.5308 1.09182 18.7301 -0.127433 14.8426 0.0105538C10.955 0.148541 7.26742 1.6336 4.51747 4.16861C1.76753 6.70363 0.158046 10.1017 0.0110351 13.6829C-0.135976 17.2641 1.19032 20.7644 3.72459 23.4835C6.25885 26.2026 9.81418 27.9399 13.6793 28.348C17.5444 28.756 21.4342 27.8047 24.5706 25.6842H24.5682C24.6395 25.7717 24.7155 25.8549 24.801 25.9358L33.9444 34.3586C34.3897 34.7691 34.9938 34.9998 35.6238 35C36.2538 35.0002 36.858 34.7699 37.3037 34.3596C37.7493 33.9494 37.9998 33.3929 38 32.8126C38.0002 32.2323 37.7502 31.6756 37.3049 31.2651L28.1614 22.8424C28.0765 22.7632 27.9852 22.6922 27.8883 22.6258ZM28.5011 14.2162C28.5011 15.7963 28.1632 17.361 27.5068 18.8208C26.8503 20.2806 25.8882 21.6071 24.6753 22.7244C23.4624 23.8417 22.0224 24.728 20.4377 25.3327C18.8529 25.9374 17.1544 26.2487 15.4391 26.2487C13.7237 26.2487 12.0252 25.9374 10.4404 25.3327C8.85568 24.728 7.41574 23.8417 6.20282 22.7244C4.9899 21.6071 4.02776 20.2806 3.37133 18.8208C2.7149 17.361 2.37704 15.7963 2.37704 14.2162C2.37704 11.025 3.75322 7.96444 6.20282 5.70791C8.65242 3.45138 11.9748 2.18367 15.4391 2.18367C18.9033 2.18367 22.2257 3.45138 24.6753 5.70791C27.1249 7.96444 28.5011 11.025 28.5011 14.2162Z" fill="#FFFFFF"/></svg></span> 
            <span class="label">Job Finder</span>
          </a>
          @else
          <a class="nav-link" href="#" data-bs-target="#access-modal" data-bs-toggle="modal">
            <span class="icon"><svg width="30" height="28" viewBox="0 0 30 28" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M27.8883 22.6258C30.1879 19.7351 31.2179 16.1512 30.7722 12.591C30.3265 9.03084 28.4379 5.75697 25.4844 3.4244C22.5308 1.09182 18.7301 -0.127433 14.8426 0.0105538C10.955 0.148541 7.26742 1.6336 4.51747 4.16861C1.76753 6.70363 0.158046 10.1017 0.0110351 13.6829C-0.135976 17.2641 1.19032 20.7644 3.72459 23.4835C6.25885 26.2026 9.81418 27.9399 13.6793 28.348C17.5444 28.756 21.4342 27.8047 24.5706 25.6842H24.5682C24.6395 25.7717 24.7155 25.8549 24.801 25.9358L33.9444 34.3586C34.3897 34.7691 34.9938 34.9998 35.6238 35C36.2538 35.0002 36.858 34.7699 37.3037 34.3596C37.7493 33.9494 37.9998 33.3929 38 32.8126C38.0002 32.2323 37.7502 31.6756 37.3049 31.2651L28.1614 22.8424C28.0765 22.7632 27.9852 22.6922 27.8883 22.6258ZM28.5011 14.2162C28.5011 15.7963 28.1632 17.361 27.5068 18.8208C26.8503 20.2806 25.8882 21.6071 24.6753 22.7244C23.4624 23.8417 22.0224 24.728 20.4377 25.3327C18.8529 25.9374 17.1544 26.2487 15.4391 26.2487C13.7237 26.2487 12.0252 25.9374 10.4404 25.3327C8.85568 24.728 7.41574 23.8417 6.20282 22.7244C4.9899 21.6071 4.02776 20.2806 3.37133 18.8208C2.7149 17.361 2.37704 15.7963 2.37704 14.2162C2.37704 11.025 3.75322 7.96444 6.20282 5.70791C8.65242 3.45138 11.9748 2.18367 15.4391 2.18367C18.9033 2.18367 22.2257 3.45138 24.6753 5.70791C27.1249 7.96444 28.5011 11.025 28.5011 14.2162Z" fill="#FFFFFF"/></svg></span> 
            <span class="label">Job Finder</span>
          </a>
          @endif
      </li>
      @if(Auth::user()->account_type != 'whitelabel' && Auth::user()->account_type != 'agency')

        <li class="nav-item">
          @if(userHasAccessToReseller(Auth::id()))
            <a class="nav-link" href="{{ route('user.whitelabel') }}">
                <span class="icon"><svg width="30" height="31" viewBox="0 0 30 31" fill="none" xmlns="http://www.w3.org/2000/svg" class=""><path d="M25.2357 0C26.1105 0 26.9494 0.347503 27.568 0.966063C28.1866 1.58462 28.5341 2.42357 28.5341 3.29835V11.3053C28.534 12.5688 28.032 13.7806 27.1385 14.674L27.1004 14.7121C25.2783 13.5363 23.1097 13.0171 20.9526 13.2404C18.7956 13.4637 16.7793 14.416 15.2367 15.9402C13.6941 17.4643 12.7176 19.469 12.4683 21.6232C12.2191 23.7774 12.7121 25.9521 13.866 27.7882C12.9512 28.369 11.8661 28.6212 10.789 28.5034C9.71186 28.3857 8.70686 27.9049 7.9392 27.1403L1.39822 20.611C0.50405 19.7183 0.00110145 18.507 1.80698e-06 17.2435C-0.00109784 15.98 0.499741 14.7678 1.39235 13.8736L13.8528 1.3985C14.2954 0.955472 14.821 0.60405 15.3995 0.364334C15.9781 0.124618 16.5982 0.00131045 17.2244 0.00146583L25.2357 0ZM21.2044 5.13369C20.9156 5.13369 20.6297 5.19057 20.3629 5.30108C20.0961 5.41158 19.8537 5.57355 19.6496 5.77774C19.4454 5.98192 19.2834 6.22433 19.1729 6.49111C19.0624 6.75789 19.0055 7.04383 19.0055 7.33259C19.0055 7.62136 19.0624 7.90729 19.1729 8.17407C19.2834 8.44086 19.4454 8.68326 19.6496 8.88745C19.8537 9.09163 20.0961 9.2536 20.3629 9.36411C20.6297 9.47461 20.9156 9.53149 21.2044 9.53149C21.7876 9.53149 22.3469 9.29982 22.7593 8.88745C23.1716 8.47507 23.4033 7.91578 23.4033 7.33259C23.4033 6.74941 23.1716 6.19011 22.7593 5.77774C22.3469 5.36536 21.7876 5.13369 21.2044 5.13369ZM30 22.7219C30 24.8603 29.1505 26.911 27.6385 28.4231C26.1265 29.9351 24.0757 30.7846 21.9374 30.7846C19.799 30.7846 17.7483 29.9351 16.2362 28.4231C14.7242 26.911 13.8748 24.8603 13.8748 22.7219C13.8748 20.5836 14.7242 18.5328 16.2362 17.0208C17.7483 15.5088 19.799 14.6593 21.9374 14.6593C24.0757 14.6593 26.1265 15.5088 27.6385 17.0208C29.1505 18.5328 30 20.5836 30 22.7219ZM19.523 19.2711C19.4548 19.2031 19.374 19.1491 19.285 19.1123C19.1959 19.0755 19.1006 19.0566 19.0043 19.0567C18.8098 19.0568 18.6233 19.1342 18.4858 19.2719C18.3484 19.4095 18.2713 19.5961 18.2714 19.7906C18.2715 19.9851 18.3489 20.1716 18.4866 20.309L20.901 22.7219L18.4866 25.1349C18.3489 25.2723 18.2715 25.4588 18.2714 25.6533C18.2713 25.8478 18.3484 26.0344 18.4858 26.172C18.6233 26.3096 18.8098 26.387 19.0043 26.3872C19.1988 26.3873 19.3854 26.3102 19.523 26.1728L21.9374 23.7584L24.3503 26.1728C24.4879 26.3102 24.6745 26.3873 24.869 26.3872C25.0635 26.387 25.25 26.3096 25.3874 26.172C25.5249 26.0344 25.602 25.8478 25.6019 25.6533C25.6017 25.4588 25.5243 25.2723 25.3867 25.1349L22.9738 22.7219L25.3867 20.309C25.4549 20.241 25.5089 20.1602 25.5459 20.0712C25.5828 19.9823 25.6018 19.8869 25.6019 19.7906C25.6019 19.6943 25.583 19.5989 25.5463 19.5099C25.5095 19.4209 25.4555 19.34 25.3874 19.2719C25.3194 19.2037 25.2386 19.1497 25.1496 19.1127C25.0607 19.0758 24.9653 19.0568 24.869 19.0567C24.7727 19.0566 24.6773 19.0755 24.5883 19.1123C24.4993 19.1491 24.4184 19.2031 24.3503 19.2711L21.9374 21.6855L19.523 19.2711Z" fill="white"></path></svg></span>
              <span class="label">Whitelabel</span>
            </a>
          @else
          <a class="nav-link" href="#" data-bs-target="#access-modal" data-bs-toggle="modal">
            <span class="icon"><svg width="30" height="31" viewBox="0 0 30 31" fill="none" xmlns="http://www.w3.org/2000/svg" class=""><path d="M25.2357 0C26.1105 0 26.9494 0.347503 27.568 0.966063C28.1866 1.58462 28.5341 2.42357 28.5341 3.29835V11.3053C28.534 12.5688 28.032 13.7806 27.1385 14.674L27.1004 14.7121C25.2783 13.5363 23.1097 13.0171 20.9526 13.2404C18.7956 13.4637 16.7793 14.416 15.2367 15.9402C13.6941 17.4643 12.7176 19.469 12.4683 21.6232C12.2191 23.7774 12.7121 25.9521 13.866 27.7882C12.9512 28.369 11.8661 28.6212 10.789 28.5034C9.71186 28.3857 8.70686 27.9049 7.9392 27.1403L1.39822 20.611C0.50405 19.7183 0.00110145 18.507 1.80698e-06 17.2435C-0.00109784 15.98 0.499741 14.7678 1.39235 13.8736L13.8528 1.3985C14.2954 0.955472 14.821 0.60405 15.3995 0.364334C15.9781 0.124618 16.5982 0.00131045 17.2244 0.00146583L25.2357 0ZM21.2044 5.13369C20.9156 5.13369 20.6297 5.19057 20.3629 5.30108C20.0961 5.41158 19.8537 5.57355 19.6496 5.77774C19.4454 5.98192 19.2834 6.22433 19.1729 6.49111C19.0624 6.75789 19.0055 7.04383 19.0055 7.33259C19.0055 7.62136 19.0624 7.90729 19.1729 8.17407C19.2834 8.44086 19.4454 8.68326 19.6496 8.88745C19.8537 9.09163 20.0961 9.2536 20.3629 9.36411C20.6297 9.47461 20.9156 9.53149 21.2044 9.53149C21.7876 9.53149 22.3469 9.29982 22.7593 8.88745C23.1716 8.47507 23.4033 7.91578 23.4033 7.33259C23.4033 6.74941 23.1716 6.19011 22.7593 5.77774C22.3469 5.36536 21.7876 5.13369 21.2044 5.13369ZM30 22.7219C30 24.8603 29.1505 26.911 27.6385 28.4231C26.1265 29.9351 24.0757 30.7846 21.9374 30.7846C19.799 30.7846 17.7483 29.9351 16.2362 28.4231C14.7242 26.911 13.8748 24.8603 13.8748 22.7219C13.8748 20.5836 14.7242 18.5328 16.2362 17.0208C17.7483 15.5088 19.799 14.6593 21.9374 14.6593C24.0757 14.6593 26.1265 15.5088 27.6385 17.0208C29.1505 18.5328 30 20.5836 30 22.7219ZM19.523 19.2711C19.4548 19.2031 19.374 19.1491 19.285 19.1123C19.1959 19.0755 19.1006 19.0566 19.0043 19.0567C18.8098 19.0568 18.6233 19.1342 18.4858 19.2719C18.3484 19.4095 18.2713 19.5961 18.2714 19.7906C18.2715 19.9851 18.3489 20.1716 18.4866 20.309L20.901 22.7219L18.4866 25.1349C18.3489 25.2723 18.2715 25.4588 18.2714 25.6533C18.2713 25.8478 18.3484 26.0344 18.4858 26.172C18.6233 26.3096 18.8098 26.387 19.0043 26.3872C19.1988 26.3873 19.3854 26.3102 19.523 26.1728L21.9374 23.7584L24.3503 26.1728C24.4879 26.3102 24.6745 26.3873 24.869 26.3872C25.0635 26.387 25.25 26.3096 25.3874 26.172C25.5249 26.0344 25.602 25.8478 25.6019 25.6533C25.6017 25.4588 25.5243 25.2723 25.3867 25.1349L22.9738 22.7219L25.3867 20.309C25.4549 20.241 25.5089 20.1602 25.5459 20.0712C25.5828 19.9823 25.6018 19.8869 25.6019 19.7906C25.6019 19.6943 25.583 19.5989 25.5463 19.5099C25.5095 19.4209 25.4555 19.34 25.3874 19.2719C25.3194 19.2037 25.2386 19.1497 25.1496 19.1127C25.0607 19.0758 24.9653 19.0568 24.869 19.0567C24.7727 19.0566 24.6773 19.0755 24.5883 19.1123C24.4993 19.1491 24.4184 19.2031 24.3503 19.2711L21.9374 21.6855L19.523 19.2711Z" fill="white"></path></svg></span>
              <span class="label">Whitelabel</span>
            </a>
          @endif
        </li>
      @endif
      
      <li class="nav-item">
        <a class="nav-link" href="{{ route('user.settings') }}">
            <span class="icon"><svg width="30" height="31" viewBox="0 0 30 31" fill="none" xmlns="http://www.w3.org/2000/svg" class=""><path d="M17.8152 30.9224H12.1873C11.8347 30.9224 11.4926 30.8019 11.2179 30.5809C10.9432 30.3599 10.7522 30.0516 10.6768 29.7071L10.0475 26.7942C9.20803 26.4264 8.41205 25.9665 7.67419 25.4228L4.83397 26.3273C4.49779 26.4345 4.13505 26.4235 3.80599 26.2961C3.47693 26.1687 3.20135 25.9326 3.02501 25.6269L0.204893 20.7551C0.0304066 20.4492 -0.0350914 20.0931 0.0191153 19.7451C0.073322 19.3971 0.244024 19.0778 0.503294 18.8395L2.70651 16.8295C2.60632 15.919 2.60632 15.0003 2.70651 14.0898L0.503294 12.0845C0.243657 11.846 0.0727227 11.5264 0.0185071 11.1781C-0.0357085 10.8298 0.0300107 10.4734 0.204893 10.1673L3.01883 5.29236C3.19517 4.98672 3.47075 4.75059 3.79981 4.62318C4.12886 4.49578 4.4916 4.48477 4.82779 4.59197L7.66801 5.49645C8.04526 5.21815 8.43797 4.9584 8.84306 4.72339C9.23423 4.50384 9.63622 4.30439 10.0475 4.12659L10.6783 1.2168C10.7534 0.872316 10.944 0.56385 11.2184 0.342541C11.4929 0.121231 11.8347 0.000371016 12.1873 0H17.8152C18.1678 0.000371016 18.5096 0.121231 18.7841 0.342541C19.0585 0.56385 19.2491 0.872316 19.3242 1.2168L19.9612 4.12814C20.8002 4.49596 21.5956 4.95592 22.3329 5.49954L25.1747 4.59506C25.5107 4.48825 25.8731 4.49947 26.2018 4.62685C26.5305 4.75424 26.8058 4.99014 26.9821 5.29546L29.7961 10.1704C30.1548 10.7996 30.0311 11.5959 29.4977 12.086L27.2944 14.096C27.3946 15.0065 27.3946 15.9252 27.2944 16.8357L29.4977 18.8456C30.0311 19.3373 30.1548 20.132 29.7961 20.7613L26.9821 25.6362C26.8058 25.9418 26.5302 26.178 26.2011 26.3054C25.8721 26.4328 25.5093 26.4438 25.1732 26.3366L22.3329 25.4321C21.5957 25.9753 20.8002 26.4348 19.9612 26.802L19.3242 29.7071C19.2488 30.0513 19.0581 30.3594 18.7837 30.5804C18.5092 30.8014 18.1675 30.9221 17.8152 30.9224ZM8.22925 21.9997L9.49707 22.9274C9.7831 23.1377 10.08 23.3309 10.3892 23.5072C10.6798 23.6757 10.9767 23.8272 11.2844 23.9648L12.7269 24.5972L13.4335 27.8301H16.5721L17.2787 24.5957L18.7212 23.9633C19.3505 23.685 19.9488 23.3402 20.5039 22.9336L21.7717 22.0059L24.9289 23.0109L26.4982 20.2928L24.0507 18.0618L24.2238 16.4971C24.3012 15.8122 24.3012 15.121 24.2238 14.4377L24.0507 12.873L26.4997 10.6373L24.9289 7.91767L21.7732 8.92265L20.5039 7.99498C19.9485 7.58633 19.3509 7.23851 18.7212 6.95753L17.2787 6.32517L16.5721 3.09224H13.4335L12.7223 6.32672L11.2844 6.95753C10.6538 7.23368 10.056 7.57904 9.5017 7.98725L8.23234 8.91492L5.07826 7.90994L3.50586 10.6373L5.95336 12.8653L5.7802 14.4315C5.70289 15.1164 5.70289 15.8075 5.7802 16.4909L5.95336 18.0556L3.50586 20.2866L5.07517 23.0047L8.22925 21.9997ZM14.9951 21.6457C13.3548 21.6457 11.7818 20.9941 10.622 19.8343C9.46217 18.6745 8.81059 17.1014 8.81059 15.4612C8.81059 13.821 9.46217 12.2479 10.622 11.0881C11.7818 9.92829 13.3548 9.27671 14.9951 9.27671C16.6353 9.27671 18.2083 9.92829 19.3681 11.0881C20.528 12.2479 21.1795 13.821 21.1795 15.4612C21.1795 17.1014 20.528 18.6745 19.3681 19.8343C18.2083 20.9941 16.6353 21.6457 14.9951 21.6457ZM14.9951 12.3689C14.3895 12.3696 13.7975 12.5479 13.2924 12.882C12.7874 13.216 12.3915 13.6909 12.1539 14.2479C11.9163 14.8049 11.8475 15.4194 11.956 16.0151C12.0644 16.6108 12.3454 17.1616 12.7641 17.5991C13.1827 18.0366 13.7206 18.3415 14.311 18.4761C14.9014 18.6107 15.5183 18.5689 16.0852 18.3561C16.6521 18.1432 17.144 17.7686 17.4999 17.2787C17.8558 16.7889 18.0601 16.2052 18.0873 15.6003V16.2188V15.4612C18.0873 14.6411 17.7615 13.8545 17.1816 13.2746C16.6017 12.6947 15.8152 12.3689 14.9951 12.3689Z" fill="white"></path></svg></span>
          <span class="label">Settings</span>
        </a>
      </li>
    </ul>
  
    <div class="pb-5">
      <ul class="nav flex-column">
        <li class="nav-item">
          @if($whitelabelIsSet == true)
          <a class="nav-link" href="{{ $config->support_url }}">
            <span class="icon"><svg width="37" height="35" viewBox="0 0 37 35" fill="none" xmlns="http://www.w3.org/2000/svg" class=""><path d="M31.75 15C31.75 15.4142 32.0858 15.75 32.5 15.75C32.9142 15.75 33.25 15.4142 33.25 15H31.75ZM18.5 1V0.25V1ZM3.75 15C3.75 15.4142 4.08579 15.75 4.5 15.75C4.91421 15.75 5.25 15.4142 5.25 15H3.75ZM1 19.4835L0.25 19.4834V19.4835H1ZM3.65125 16.0885L3.83313 16.8161L3.83355 16.816L3.65125 16.0885ZM6.69625 15.3255L6.515 14.5977L6.51396 14.598L6.69625 15.3255ZM8 16.344H8.75V16.3437L8 16.344ZM8 25.9043H7.25L7.25 25.9056L8 25.9043ZM6.6945 26.9245L6.877 26.1971L6.8764 26.1969L6.6945 26.9245ZM3.6495 26.1633L3.46725 26.8908L3.4676 26.8909L3.6495 26.1633ZM1 22.7683H0.25V22.7683L1 22.7683ZM36 19.4835H36.75V19.4834L36 19.4835ZM33.3488 16.0885L33.1665 16.816L33.1669 16.8161L33.3488 16.0885ZM30.3038 15.3255L30.486 14.598L30.485 14.5977L30.3038 15.3255ZM29 16.344L28.25 16.3437V16.344H29ZM29 25.9043L29.75 25.9052V25.9043H29ZM30.3038 26.9245L30.485 27.6523L30.4857 27.6521L30.3038 26.9245ZM33.3488 26.1633L33.1669 25.4356L33.1669 25.4357L33.3488 26.1633ZM36 22.7683L36.75 22.7684V22.7683H36ZM14.0188 33.4812L14.5492 32.9508L14.0188 33.4812ZM13.25 31.625H12.5H13.25ZM23.75 31.625H24.5H23.75ZM22.9812 33.4812L22.4508 32.9508L22.9812 33.4812ZM33.25 15C33.25 11.0881 31.696 7.33634 28.9298 4.57018L27.8692 5.63084C30.354 8.11569 31.75 11.4859 31.75 15H33.25ZM28.9298 4.57018C26.1637 1.80401 22.4119 0.25 18.5 0.25V1.75C22.0141 1.75 25.3843 3.14598 27.8692 5.63084L28.9298 4.57018ZM18.5 0.25C14.5881 0.25 10.8363 1.80401 8.07018 4.57018L9.13084 5.63084C11.6157 3.14598 14.9859 1.75 18.5 1.75V0.25ZM8.07018 4.57018C5.30401 7.33634 3.75 11.0881 3.75 15H5.25C5.25 11.4859 6.64598 8.11569 9.13084 5.63084L8.07018 4.57018ZM1.75 19.4836C1.75009 18.8704 1.95515 18.2748 2.33259 17.7914L1.15037 16.8682C0.567057 17.6152 0.250144 18.5357 0.25 19.4834L1.75 19.4836ZM2.33259 17.7914C2.71003 17.3081 3.23819 16.9648 3.83313 16.8161L3.46938 15.3609C2.54993 15.5907 1.73369 16.1213 1.15037 16.8682L2.33259 17.7914ZM3.83355 16.816L6.87855 16.053L6.51396 14.598L3.46896 15.361L3.83355 16.816ZM6.8775 16.0533C6.92171 16.0423 6.96784 16.0415 7.01241 16.0509L7.32443 14.5838C7.05706 14.5269 6.78025 14.5317 6.515 14.5977L6.8775 16.0533ZM7.01241 16.0509C7.05697 16.0604 7.09879 16.0799 7.13469 16.108L8.05812 14.9259C7.84271 14.7576 7.5918 14.6406 7.32443 14.5838L7.01241 16.0509ZM7.13469 16.108C7.17059 16.136 7.19963 16.1719 7.21961 16.2128L8.56767 15.555C8.44779 15.3093 8.27354 15.0942 8.05812 14.9259L7.13469 16.108ZM7.21961 16.2128C7.23959 16.2538 7.24998 16.2987 7.25 16.3443L8.75 16.3437C8.7499 16.0704 8.68755 15.8006 8.56767 15.555L7.21961 16.2128ZM7.25 16.344V25.9043H8.75V16.344H7.25ZM7.25 25.9056C7.25008 25.9512 7.23974 25.9963 7.21976 26.0373L8.56856 26.6936C8.68842 26.4473 8.75047 26.1769 8.75 25.903L7.25 25.9056ZM7.21976 26.0373C7.19979 26.0784 7.1707 26.1143 7.13473 26.1424L8.05838 27.3243C8.27422 27.1557 8.44871 26.9399 8.56856 26.6936L7.21976 26.0373ZM7.13473 26.1424C7.09876 26.1706 7.05684 26.1901 7.01218 26.1996L7.32308 27.667C7.59106 27.6102 7.84255 27.493 8.05838 27.3243L7.13473 26.1424ZM7.01218 26.1996C6.96752 26.209 6.92129 26.2082 6.877 26.1971L6.512 27.652C6.77769 27.7186 7.05509 27.7238 7.32308 27.667L7.01218 26.1996ZM6.8764 26.1969L3.8314 25.4357L3.4676 26.8909L6.5126 27.6521L6.8764 26.1969ZM3.83175 25.4357C3.23707 25.2868 2.70922 24.9434 2.33205 24.4601L1.14954 25.3829C1.73244 26.1298 2.5482 26.6605 3.46725 26.8908L3.83175 25.4357ZM2.33205 24.4601C1.95488 23.9768 1.75002 23.3813 1.75 22.7682L0.25 22.7683C0.250025 23.7157 0.566635 24.636 1.14954 25.3829L2.33205 24.4601ZM36.75 19.4834C36.7499 18.5357 36.4329 17.6152 35.8496 16.8682L34.6674 17.7914C35.0448 18.2748 35.2499 18.8704 35.25 19.4836L36.75 19.4834ZM35.8496 16.8682C35.2663 16.1213 34.4501 15.5907 33.5306 15.3609L33.1669 16.8161C33.7618 16.9648 34.29 17.3081 34.6674 17.7914L35.8496 16.8682ZM33.531 15.361L30.486 14.598L30.1215 16.053L33.1665 16.816L33.531 15.361ZM30.485 14.5977C30.2198 14.5317 29.9429 14.5269 29.6756 14.5838L29.9876 16.0509C30.0322 16.0415 30.0783 16.0423 30.1225 16.0533L30.485 14.5977ZM29.6756 14.5838C29.4082 14.6406 29.1573 14.7576 28.9419 14.9259L29.8653 16.108C29.9012 16.0799 29.943 16.0604 29.9876 16.0509L29.6756 14.5838ZM28.9419 14.9259C28.7265 15.0942 28.5522 15.3093 28.4323 15.555L29.7804 16.2128C29.8004 16.1719 29.8294 16.136 29.8653 16.108L28.9419 14.9259ZM28.4323 15.555C28.3125 15.8006 28.2501 16.0704 28.25 16.3437L29.75 16.3443C29.75 16.2987 29.7604 16.2538 29.7804 16.2128L28.4323 15.555ZM28.25 16.344V25.9043H29.75V16.344H28.25ZM28.25 25.9033C28.2496 26.1769 28.3117 26.447 28.4313 26.693L29.7802 26.0369C29.7603 25.9959 29.7499 25.9508 29.75 25.9052L28.25 25.9033ZM28.4313 26.693C28.551 26.9391 28.7252 27.1546 28.9407 27.3232L29.8651 26.1419C29.8292 26.1138 29.8002 26.0779 29.7802 26.0369L28.4313 26.693ZM28.9407 27.3232C29.1562 27.4918 29.4072 27.6091 29.6748 27.6661L29.9875 26.199C29.9429 26.1895 29.901 26.17 29.8651 26.1419L28.9407 27.3232ZM29.6748 27.6661C29.9424 27.7231 30.2195 27.7184 30.485 27.6523L30.1225 26.1967C30.0782 26.2078 30.0321 26.2085 29.9875 26.199L29.6748 27.6661ZM30.4857 27.6521L33.5307 26.8909L33.1669 25.4357L30.1218 26.1969L30.4857 27.6521ZM33.5306 26.8909C34.4501 26.661 35.2663 26.1305 35.8496 25.3835L34.6674 24.4603C34.29 24.9436 33.7618 25.2869 33.1669 25.4356L33.5306 26.8909ZM35.8496 25.3835C36.4329 24.6366 36.7499 23.7161 36.75 22.7684L35.25 22.7681C35.2499 23.3814 35.0448 23.977 34.6674 24.4603L35.8496 25.3835ZM31.75 27.25V28.125H33.25V27.25H31.75ZM31.75 28.125C31.75 28.8544 31.4603 29.5538 30.9445 30.0696L32.0052 31.1302C32.8022 30.3332 33.25 29.2522 33.25 28.125H31.75ZM30.9445 30.0696C30.4288 30.5853 29.7293 30.875 29 30.875V32.375C30.1272 32.375 31.2082 31.9272 32.0052 31.1302L30.9445 30.0696ZM29 30.875H22.875V32.375H29V30.875ZM21.125 33.5H15.875V35H21.125V33.5ZM15.875 33.5C15.3777 33.5 14.9008 33.3025 14.5492 32.9508L13.4885 34.0115C14.1214 34.6444 14.9799 35 15.875 35V33.5ZM14.5492 32.9508C14.1975 32.5992 14 32.1223 14 31.625H12.5C12.5 32.5201 12.8556 33.3786 13.4885 34.0115L14.5492 32.9508ZM14 31.625C14 31.1277 14.1975 30.6508 14.5492 30.2992L13.4885 29.2385C12.8556 29.8715 12.5 30.7299 12.5 31.625H14ZM14.5492 30.2992C14.9008 29.9476 15.3777 29.75 15.875 29.75V28.25C14.9799 28.25 14.1214 28.6056 13.4885 29.2385L14.5492 30.2992ZM15.875 29.75H21.125V28.25H15.875V29.75ZM21.125 29.75C21.6223 29.75 22.0992 29.9476 22.4508 30.2992L23.5115 29.2385C22.8786 28.6056 22.0201 28.25 21.125 28.25V29.75ZM22.4508 30.2992C22.8025 30.6508 23 31.1277 23 31.625H24.5C24.5 30.7299 24.1444 29.8715 23.5115 29.2385L22.4508 30.2992ZM23 31.625C23 32.1223 22.8025 32.5992 22.4508 32.9508L23.5115 34.0115C24.1444 33.3786 24.5 32.5201 24.5 31.625H23ZM22.4508 32.9508C22.0992 33.3025 21.6223 33.5 21.125 33.5V35C22.0201 35 22.8786 34.6444 23.5115 34.0115L22.4508 32.9508ZM1.75 22.7683V19.4835H0.25V22.7683H1.75ZM36.75 22.7683V19.4835H35.25V22.7683H36.75Z" fill="white"></path></svg></span>
            <span class="label">Help</span>
          </a>
          @else
          <a class="nav-link" href="https://support.audiostudio.cc/">
            <span class="icon"><svg width="37" height="35" viewBox="0 0 37 35" fill="none" xmlns="http://www.w3.org/2000/svg" class=""><path d="M31.75 15C31.75 15.4142 32.0858 15.75 32.5 15.75C32.9142 15.75 33.25 15.4142 33.25 15H31.75ZM18.5 1V0.25V1ZM3.75 15C3.75 15.4142 4.08579 15.75 4.5 15.75C4.91421 15.75 5.25 15.4142 5.25 15H3.75ZM1 19.4835L0.25 19.4834V19.4835H1ZM3.65125 16.0885L3.83313 16.8161L3.83355 16.816L3.65125 16.0885ZM6.69625 15.3255L6.515 14.5977L6.51396 14.598L6.69625 15.3255ZM8 16.344H8.75V16.3437L8 16.344ZM8 25.9043H7.25L7.25 25.9056L8 25.9043ZM6.6945 26.9245L6.877 26.1971L6.8764 26.1969L6.6945 26.9245ZM3.6495 26.1633L3.46725 26.8908L3.4676 26.8909L3.6495 26.1633ZM1 22.7683H0.25V22.7683L1 22.7683ZM36 19.4835H36.75V19.4834L36 19.4835ZM33.3488 16.0885L33.1665 16.816L33.1669 16.8161L33.3488 16.0885ZM30.3038 15.3255L30.486 14.598L30.485 14.5977L30.3038 15.3255ZM29 16.344L28.25 16.3437V16.344H29ZM29 25.9043L29.75 25.9052V25.9043H29ZM30.3038 26.9245L30.485 27.6523L30.4857 27.6521L30.3038 26.9245ZM33.3488 26.1633L33.1669 25.4356L33.1669 25.4357L33.3488 26.1633ZM36 22.7683L36.75 22.7684V22.7683H36ZM14.0188 33.4812L14.5492 32.9508L14.0188 33.4812ZM13.25 31.625H12.5H13.25ZM23.75 31.625H24.5H23.75ZM22.9812 33.4812L22.4508 32.9508L22.9812 33.4812ZM33.25 15C33.25 11.0881 31.696 7.33634 28.9298 4.57018L27.8692 5.63084C30.354 8.11569 31.75 11.4859 31.75 15H33.25ZM28.9298 4.57018C26.1637 1.80401 22.4119 0.25 18.5 0.25V1.75C22.0141 1.75 25.3843 3.14598 27.8692 5.63084L28.9298 4.57018ZM18.5 0.25C14.5881 0.25 10.8363 1.80401 8.07018 4.57018L9.13084 5.63084C11.6157 3.14598 14.9859 1.75 18.5 1.75V0.25ZM8.07018 4.57018C5.30401 7.33634 3.75 11.0881 3.75 15H5.25C5.25 11.4859 6.64598 8.11569 9.13084 5.63084L8.07018 4.57018ZM1.75 19.4836C1.75009 18.8704 1.95515 18.2748 2.33259 17.7914L1.15037 16.8682C0.567057 17.6152 0.250144 18.5357 0.25 19.4834L1.75 19.4836ZM2.33259 17.7914C2.71003 17.3081 3.23819 16.9648 3.83313 16.8161L3.46938 15.3609C2.54993 15.5907 1.73369 16.1213 1.15037 16.8682L2.33259 17.7914ZM3.83355 16.816L6.87855 16.053L6.51396 14.598L3.46896 15.361L3.83355 16.816ZM6.8775 16.0533C6.92171 16.0423 6.96784 16.0415 7.01241 16.0509L7.32443 14.5838C7.05706 14.5269 6.78025 14.5317 6.515 14.5977L6.8775 16.0533ZM7.01241 16.0509C7.05697 16.0604 7.09879 16.0799 7.13469 16.108L8.05812 14.9259C7.84271 14.7576 7.5918 14.6406 7.32443 14.5838L7.01241 16.0509ZM7.13469 16.108C7.17059 16.136 7.19963 16.1719 7.21961 16.2128L8.56767 15.555C8.44779 15.3093 8.27354 15.0942 8.05812 14.9259L7.13469 16.108ZM7.21961 16.2128C7.23959 16.2538 7.24998 16.2987 7.25 16.3443L8.75 16.3437C8.7499 16.0704 8.68755 15.8006 8.56767 15.555L7.21961 16.2128ZM7.25 16.344V25.9043H8.75V16.344H7.25ZM7.25 25.9056C7.25008 25.9512 7.23974 25.9963 7.21976 26.0373L8.56856 26.6936C8.68842 26.4473 8.75047 26.1769 8.75 25.903L7.25 25.9056ZM7.21976 26.0373C7.19979 26.0784 7.1707 26.1143 7.13473 26.1424L8.05838 27.3243C8.27422 27.1557 8.44871 26.9399 8.56856 26.6936L7.21976 26.0373ZM7.13473 26.1424C7.09876 26.1706 7.05684 26.1901 7.01218 26.1996L7.32308 27.667C7.59106 27.6102 7.84255 27.493 8.05838 27.3243L7.13473 26.1424ZM7.01218 26.1996C6.96752 26.209 6.92129 26.2082 6.877 26.1971L6.512 27.652C6.77769 27.7186 7.05509 27.7238 7.32308 27.667L7.01218 26.1996ZM6.8764 26.1969L3.8314 25.4357L3.4676 26.8909L6.5126 27.6521L6.8764 26.1969ZM3.83175 25.4357C3.23707 25.2868 2.70922 24.9434 2.33205 24.4601L1.14954 25.3829C1.73244 26.1298 2.5482 26.6605 3.46725 26.8908L3.83175 25.4357ZM2.33205 24.4601C1.95488 23.9768 1.75002 23.3813 1.75 22.7682L0.25 22.7683C0.250025 23.7157 0.566635 24.636 1.14954 25.3829L2.33205 24.4601ZM36.75 19.4834C36.7499 18.5357 36.4329 17.6152 35.8496 16.8682L34.6674 17.7914C35.0448 18.2748 35.2499 18.8704 35.25 19.4836L36.75 19.4834ZM35.8496 16.8682C35.2663 16.1213 34.4501 15.5907 33.5306 15.3609L33.1669 16.8161C33.7618 16.9648 34.29 17.3081 34.6674 17.7914L35.8496 16.8682ZM33.531 15.361L30.486 14.598L30.1215 16.053L33.1665 16.816L33.531 15.361ZM30.485 14.5977C30.2198 14.5317 29.9429 14.5269 29.6756 14.5838L29.9876 16.0509C30.0322 16.0415 30.0783 16.0423 30.1225 16.0533L30.485 14.5977ZM29.6756 14.5838C29.4082 14.6406 29.1573 14.7576 28.9419 14.9259L29.8653 16.108C29.9012 16.0799 29.943 16.0604 29.9876 16.0509L29.6756 14.5838ZM28.9419 14.9259C28.7265 15.0942 28.5522 15.3093 28.4323 15.555L29.7804 16.2128C29.8004 16.1719 29.8294 16.136 29.8653 16.108L28.9419 14.9259ZM28.4323 15.555C28.3125 15.8006 28.2501 16.0704 28.25 16.3437L29.75 16.3443C29.75 16.2987 29.7604 16.2538 29.7804 16.2128L28.4323 15.555ZM28.25 16.344V25.9043H29.75V16.344H28.25ZM28.25 25.9033C28.2496 26.1769 28.3117 26.447 28.4313 26.693L29.7802 26.0369C29.7603 25.9959 29.7499 25.9508 29.75 25.9052L28.25 25.9033ZM28.4313 26.693C28.551 26.9391 28.7252 27.1546 28.9407 27.3232L29.8651 26.1419C29.8292 26.1138 29.8002 26.0779 29.7802 26.0369L28.4313 26.693ZM28.9407 27.3232C29.1562 27.4918 29.4072 27.6091 29.6748 27.6661L29.9875 26.199C29.9429 26.1895 29.901 26.17 29.8651 26.1419L28.9407 27.3232ZM29.6748 27.6661C29.9424 27.7231 30.2195 27.7184 30.485 27.6523L30.1225 26.1967C30.0782 26.2078 30.0321 26.2085 29.9875 26.199L29.6748 27.6661ZM30.4857 27.6521L33.5307 26.8909L33.1669 25.4357L30.1218 26.1969L30.4857 27.6521ZM33.5306 26.8909C34.4501 26.661 35.2663 26.1305 35.8496 25.3835L34.6674 24.4603C34.29 24.9436 33.7618 25.2869 33.1669 25.4356L33.5306 26.8909ZM35.8496 25.3835C36.4329 24.6366 36.7499 23.7161 36.75 22.7684L35.25 22.7681C35.2499 23.3814 35.0448 23.977 34.6674 24.4603L35.8496 25.3835ZM31.75 27.25V28.125H33.25V27.25H31.75ZM31.75 28.125C31.75 28.8544 31.4603 29.5538 30.9445 30.0696L32.0052 31.1302C32.8022 30.3332 33.25 29.2522 33.25 28.125H31.75ZM30.9445 30.0696C30.4288 30.5853 29.7293 30.875 29 30.875V32.375C30.1272 32.375 31.2082 31.9272 32.0052 31.1302L30.9445 30.0696ZM29 30.875H22.875V32.375H29V30.875ZM21.125 33.5H15.875V35H21.125V33.5ZM15.875 33.5C15.3777 33.5 14.9008 33.3025 14.5492 32.9508L13.4885 34.0115C14.1214 34.6444 14.9799 35 15.875 35V33.5ZM14.5492 32.9508C14.1975 32.5992 14 32.1223 14 31.625H12.5C12.5 32.5201 12.8556 33.3786 13.4885 34.0115L14.5492 32.9508ZM14 31.625C14 31.1277 14.1975 30.6508 14.5492 30.2992L13.4885 29.2385C12.8556 29.8715 12.5 30.7299 12.5 31.625H14ZM14.5492 30.2992C14.9008 29.9476 15.3777 29.75 15.875 29.75V28.25C14.9799 28.25 14.1214 28.6056 13.4885 29.2385L14.5492 30.2992ZM15.875 29.75H21.125V28.25H15.875V29.75ZM21.125 29.75C21.6223 29.75 22.0992 29.9476 22.4508 30.2992L23.5115 29.2385C22.8786 28.6056 22.0201 28.25 21.125 28.25V29.75ZM22.4508 30.2992C22.8025 30.6508 23 31.1277 23 31.625H24.5C24.5 30.7299 24.1444 29.8715 23.5115 29.2385L22.4508 30.2992ZM23 31.625C23 32.1223 22.8025 32.5992 22.4508 32.9508L23.5115 34.0115C24.1444 33.3786 24.5 32.5201 24.5 31.625H23ZM22.4508 32.9508C22.0992 33.3025 21.6223 33.5 21.125 33.5V35C22.0201 35 22.8786 34.6444 23.5115 34.0115L22.4508 32.9508ZM1.75 22.7683V19.4835H0.25V22.7683H1.75ZM36.75 22.7683V19.4835H35.25V22.7683H36.75Z" fill="white"></path></svg></span>
            <span class="label">Help</span>
          </a>
          @endif
          
        </li>
      </ul>
  
      <a href="{{ route('user.logout') }}" class="btn btn-logout">
        <span class="icon"><svg width="23" height="23" viewBox="0 0 23 23" fill="none" xmlns="http://www.w3.org/2000/svg" class=""><path d="M20.5908 17.0275H18.7492C18.6234 17.0275 18.5055 17.0825 18.427 17.1795C18.2436 17.4021 18.0471 17.6169 17.8402 17.8213C16.9937 18.6685 15.9912 19.3437 14.8879 19.8096C13.7448 20.2923 12.5162 20.54 11.2754 20.5378C10.0206 20.5378 8.80511 20.2916 7.66296 19.8096C6.55965 19.3437 5.55707 18.6685 4.71065 17.8213C3.86272 16.9769 3.1866 15.976 2.71974 14.8742C2.23511 13.7321 1.99149 12.5192 1.99149 11.2644C1.99149 10.0096 2.23773 8.7967 2.71974 7.65455C3.18603 6.55169 3.85666 5.55886 4.71065 4.70748C5.56464 3.85611 6.55748 3.18549 7.66296 2.7192C8.80511 2.23719 10.0206 1.99095 11.2754 1.99095C12.5302 1.99095 13.7457 2.23457 14.8879 2.7192C15.9933 3.18549 16.9862 3.85611 17.8402 4.70748C18.0471 4.91443 18.241 5.12924 18.427 5.34929C18.5055 5.44622 18.626 5.50123 18.7492 5.50123H20.5908C20.7558 5.50123 20.858 5.31785 20.7663 5.17902C18.757 2.05644 15.2415 -0.0104388 11.2466 3.96575e-05C4.96999 0.0157573 -0.062288 5.11091 0.000582745 11.3796C0.0634535 17.5488 5.08788 22.5287 11.2754 22.5287C15.2598 22.5287 18.7596 20.4645 20.7663 17.3497C20.8553 17.2109 20.7558 17.0275 20.5908 17.0275ZM22.9196 11.0993L19.2024 8.16537C19.0635 8.05535 18.8618 8.1549 18.8618 8.33041V10.3213H10.6362C10.521 10.3213 10.4267 10.4156 10.4267 10.5309V11.9979C10.4267 12.1131 10.521 12.2074 10.6362 12.2074H18.8618V14.1983C18.8618 14.3739 19.0661 14.4734 19.2024 14.3634L22.9196 11.4294C22.9446 11.4098 22.9649 11.3848 22.9788 11.3562C22.9928 11.3276 23 11.2962 23 11.2644C23 11.2326 22.9928 11.2012 22.9788 11.1726C22.9649 11.144 22.9446 11.1189 22.9196 11.0993Z" fill="white"></path></svg></span>
        <span class="label">Logout</span>
      </a>
    </div>
  </div>
