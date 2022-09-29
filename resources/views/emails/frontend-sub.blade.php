<html>
<head></head>
    <body>
        <p><b>Hi {{ $user->first_name }},</b></p>
        <br><br><br>
        <p>Steve Tari here. Congratulations on your purchase of Vidilicious!</p>
        <br><br><br>
        <p>You made the right decision and we're super excited to have you onboard and to also help you make the most out of your Interactive Video Creation, Automation, and Marketing platform.</p>
        <br>
        <p>Please keep this information safe as it contains your username and password.</p>

        <p><b>Your Vidilicious Membership Info:</b></p>
        
        <p>Email: {{ $user->email }}</p>
        <p>Password: {{ $user->plain_password }}</p>
        <p>Login URL: <a href="{{ route('auth.login') }}" target='_BLANK'>{{ route('auth.login') }}</a></p>
        
        <br><br>
        <p><b>Some Important Details:</b> Here are some details to help get you started:</p>
        <br><br>
        <ol>
            <li style="margin-bottom: 10px;">Before you get started or submit any support request, kindly watch the Vidilicious Welcome & Walk-through Videos located inside the Members Area, and ALL videos in the Knowledge Base section found here: <a href="http://support.getvidilicious.com/">http://support.getvidilicious.com/</a>. These Videos will give you answers to most of the questions you may have and give you understanding of how to get started with Vidilicious.</li>
            <li style="margin-bottom: 10px;">Please do not raise multiple support tickets for the same issue, this will only delay our response time.</li>
            <li style="margin-bottom: 10px;">We have a dedicated Team of Support Ninjas waiting to help you out. Due to launch week and the volume of requests we may be handling, responses may take a little bit longer. But be assured that you’d be attended to immediately when the next agent becomes available.</li>
            <li style="margin-bottom: 10px;">In addition to the Live Chat Widget on the Vidilicious members area, you can also contact us via support@vidilicious.io</li>
        </ol>
        <p style="font-size:15px"><b>And if you missed any of the special upgrade you can get them here at a special discount:</b></p>
        <p style="margin-bottom: 10px;">=> <a href="https://getvidilicious.com/special-unlimited/">Get Discounted Vidilicious Unlimited</a></p>
        <p style="margin-bottom: 10px;">=> <a href="https://getvidilicious.com/special-professional/">Get Discounted Vidilicious Professional</a></p>
        <p style="margin-bottom: 10px;">=> <a href="https://getvidilicious.com/special-consultant/">Get Discounted Vidilicious Business Consultant</a></p>
        <p style="margin-bottom: 10px;">=> <a href="https://videoreel.getvidilicious.com/">Get Discounted Vidilicious VideoReel</a></p>
        <p style="margin-bottom: 10px;">=> <a href="https://getvidilicious.com/special-whitelabel/">Get Discounted Vidilicious Whitelabel</a></p>

        <p>Best Regards,</p>
        <p>Steve Tari [Vidilicious Founder/CEO]</p>
    </body>
</html>
