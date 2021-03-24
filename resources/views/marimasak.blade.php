<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="msapplication-TitleColor" content="#ffffff">
    <meta name="msaaplication-config" content="/img/favicons/browserconfig.xml">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600&display=swap" rel="stylesheet">
    <link rel="apple-touch-icon" sizes="180x180" href="/img/favicons/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/img/favicons/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/img/favicons/favicon-16x16.png">
    <link rel="manifest" href="/img/favicons/site.webmanifest">
    <link rel="mask-icon" href="/img/favicons/safari-pinned-tab.svg" color="#5851d8">
    <link rel="shortcut icon" href="/img/favicons/favicon.ico">
    <script src="/js/pace/pace.js"></script>
    <link href="{{mix("/css/marimasak.css")}}" rel="stylesheet" type="text/css">
    <title>MariMasak - Get your food anywhere anytime</title>
</head>
<body class="h-full overflow-x-hidden bg-gray-100 layout-default skin-crater font-base">
    <div id="app" class="h-full">
        <router-view></router-view>
    </div>
    <script type="text/javascript" src="{{mix('/js/app.js')}}"></script>
</body>
</html>
