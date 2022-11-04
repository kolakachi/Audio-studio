<html>
<head></head>
    <body>
        <p><b>Hi {{ $user->first_name }},</b></p>
        
        <p>Please keep this information safe as it contains your username and password.</p>

        <p><b>Your AudioStudio Membership Info:</b></p>
        
        <p>Email: {{ $user->email }}</p>
        <p>Password: {{ $user->plain_password }}</p>
        <p>Login URL: <a href="{{ route('login') }}" target='_BLANK'>{{ route('login') }}</a></p>
        
    
    </body>
</html>
