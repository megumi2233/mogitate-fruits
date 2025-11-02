<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>mogitate</title>

    <!-- CSS 読み込み -->
    <link rel="stylesheet" href="{{ asset('css/products.css') }}">

     <!-- ページごとの追加CSSを読み込む場所 -->
    @yield('css')
</head>
<body>
    <header>
        <h1 class="mogitate-logo">mogitate</h1>
    </header>

    <main>
        @yield('content')
    </main>
</body>
</html>
