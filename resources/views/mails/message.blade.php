<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <h1>{{ $senderName }} ti ha mandato una richiesta di informazioni sul tuo appartamento</h1>
    <h3>L'email del mittente è:  {{ $senderEmail }} </h3>
    <p>
        Testo: {{ $senderMessage }}
    </p>
</body>
</html>
