<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Test Layout</title>
    @stack('head')
</head>
<body>
    <div class="app">
        @yield('content')
    </div>
    @stack('custome-js')
</body>
</html>
