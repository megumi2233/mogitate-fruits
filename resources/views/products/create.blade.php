@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/product-create.css') }}">
@endsection

@section('content')
    <div class="container">
        <h1 class="page-title">商品登録</h1>

        <!-- 商品追加フォーム -->
        <form action="{{ route('products.store') }}" method="POST" class="product-form" enctype="multipart/form-data">
            @csrf

            <!-- 商品名 -->
            <div class="form-group">
                <label for="name">商品名 <span class="badge-required">必須</span></label>
                <input type="text" id="name" name="name" value="{{ old('name') }}" placeholder="商品名を入力">
                @error('name')
            <div class="error">{{ $message }}</div>
        @enderror
            </div>

            <!-- 価格 -->
            <div class="form-group">
                <label for="price">値段 <span class="badge-required">必須</span></label>
                <input type="number" id="price" name="price" value="{{ old('price') }}" placeholder="値段を入力">
                @error('price')
                   <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <!-- 画像ファイル名 -->
            <div class="form-group">
                <label for="image">商品画像 <span class="badge-required">必須</span></label>
                <input type="file" id="image" name="image">
                @error('image')
            <div class="error">{{ $message }}</div>
        @enderror
            </div>

            <!-- 季節 -->
            <div class="form-group">
                <label for="seasons">
                    季節 <span class="badge-required">必須</span>
                    <span class="badge-optional-text">複数選択可</span>
                </label>
                <div class="season-options">
                    @foreach ($seasons as $season)
                        <label class="season-label">
                            <input type="checkbox" name="seasons[]" value="{{ $season->id }}"
                                {{ is_array(old('seasons')) && in_array($season->id, old('seasons')) ? 'checked' : '' }}>
                            {{ $season->name }}
                        </label>
                    @endforeach
                </div>
                @error('seasons')
            <div class="error">{{ $message }}</div>
        @enderror
            </div>

            <!-- 説明 -->
            <div class="form-group">
                <label for="description">商品説明 <span class="badge-required">必須</span></label>
                <textarea id="description" name="description" placeholder="商品の説明を入力">{{ old('description') }}</textarea>
                @error('description')
            <div class="error">{{ $message }}</div>
        @enderror
            </div>

            <!-- ボタン -->
            <div class="form-actions">
                <a href="{{ route('products.index') }}" class="btn-back">戻る</a>
                <button type="submit" class="btn-submit">登録</button>
            </div>
        </form>
    </div>
@endsection
