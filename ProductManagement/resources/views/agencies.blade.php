<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">

</head>

<body>

    <div id="app">
        <div id="navbar">
            <navbar />
        </div>
        <div id="agencies">
            <agencies />
        </div>

    </div>

    <script type="module" src="{{ mix('/js/app.js') }}"></script>
</body>

</html>