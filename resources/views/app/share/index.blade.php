<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <style>
        .myvideo {
            height: 100vh;
            width: 100vw;
        }
    </style>

    <audio controls>
        <source src="{{$audio->audio_path}}" type="audio/mp3">
    </audio>
</body>
</html>
