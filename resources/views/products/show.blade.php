@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/product-detail.css') }}">
@endsection

@section('content')
    <div class="product-detail">
        <h1 class="product-title">商品詳細・編集</h1>

        <form action="{{ route('products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <!-- 画像＋基本情報を横並びにするブロック -->
            <div class="product-main">
                <!-- 左側：画像 -->
                <div class="product-image-block">
                    @if ($product->image)
                        <img src="{{ asset('storage/images/' . $product->image) }}" alt="{{ $product->name ?? '商品画像' }}"
                            class="current-image">
                    @endif

                    <div class="form-group custom-file">
                        <label for="image" class="file-label">ファイルを選択</label>
                        <input type="file" id="image" name="image" accept=".png,.jpeg" class="file-input">
                        @if ($product->image)
                            <span class="current-filename">{{ $product->image }}</span>
                        @endif
                        @error('image')
                            <div style="color:red;">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- 右側：商品名・値段・季節 -->
                <div class="product-info-block">
                    <div class="form-group">
                        <label for="name">商品名</label>
                        <input type="text" id="name" name="name" value="{{ old('name', $product->name) }}">
                        @error('name')
                            <div style="color:red;">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="price">値段</label>
                        <input type="number" id="price" name="price" value="{{ old('price', $product->price) }}"
                            step="1">
                        @error('price')
                            <div style="color:red;">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group seasons">
                        <label>季節</label>
                        <div class="season-options">
                            @foreach ($seasons as $season)
                                <label class="season-option">
                                    <input type="checkbox" name="seasons[]" value="{{ $season->id }}"
                                        {{ in_array($season->id, old('seasons', $product->seasons->pluck('id')->toArray())) ? 'checked' : '' }}>
                                    <span>{{ $season->name }}</span>
                                </label>
                            @endforeach
                            @error('seasons')
                                <div style="color:red;">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            <!-- 下に商品説明 -->
            <div class="form-group">
                <label for="description">商品説明</label>
                <textarea id="description" name="description" rows="5">{{ old('description', $product->description) }}</textarea>
                @error('description')
                    <div style="color:red;">{{ $message }}</div>
                @enderror
            </div>

            <div class="product-actions">
                <a href="{{ route('products.index') }}" class="btn back">戻る</a>
                <button type="submit" class="btn save">変更を保存</button>
            </div>
        </form>

        <div class="delete-wrapper">
            <form action="{{ route('products.delete', $product->id) }}" method="POST"
                onsubmit="return confirm('本当に削除しますか？');">
                @csrf
                @method('POST')
                <button type="submit" class="btn delete">🗑</button>
            </form>
        </div>
    </div>
@endsection
