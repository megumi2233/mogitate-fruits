@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="product-list-header">
            <h1 class="page-title">商品一覧</h1>

            <div class="header-actions">
                <!-- 左側：検索フォーム -->
                <form action="{{ route('products.search') }}" method="GET" class="search-form">
                    <input type="text" name="keyword" placeholder="商品名で検索" value="{{ request('keyword') }}">
                    <button type="submit">検索</button>
                </form>

                <!-- 右側：商品追加ボタン -->
                <a href="{{ route('products.create') }}" class="btn-add">＋ 商品を追加</a>
            </div>
        </div>

        <!-- 検索結果メッセージ -->
        @if (isset($keyword))
            <p class="search-result-message">「{{ $keyword }}」の検索結果</p>
        @endif

        <div class="product-grid">
            @forelse ($products as $product)
                <div class="product-card">
                    <a href="{{ route('products.show', $product->id) }}">
                        <img src="{{ asset('storage/fruits-img/' . $product->image) }}" alt="{{ $product->name }}"
                            class="product-image">
                        <h2 class="product-name">{{ $product->name }}</h2>
                        <p class="product-price">{{ number_format($product->price) }} 円</p>
                    </a>
                </div>
            @empty
                <p class="no-result-message">該当する商品が見つかりませんでした。</p>
            @endforelse
        </div>

        <!-- ページネーション -->
        <div class="pagination">
            {{ $products->links() }}
        </div>
    </div>
@endsection
