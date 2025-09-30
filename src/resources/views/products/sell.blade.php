@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/products/sell.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
@endsection

@section('content')
    <div class="profile__box">
        <h2 class="profile__title">商品の出品</h2>
        <form class="profile__form" action="{{ route('products.store') }}" method="post" enctype="multipart/form-data">
            @csrf
            <!-- 商品画像設定 -->
            <p>商品画像</p>
            <div class="image__box">
                <div id="previewContainer">
                    <img id="imagePreview" class="product-image" src="" alt="商品画像プレビュー" style="display:none;">
                </div>
                <label class="select-btn" for="imageInput">画像を選択する</label>
                <input type="file" class="hidden" id="imageInput" name="product_image" accept="image/*" required>
            </div>

            <h3 class="sell__title">商品の詳細</h3>
            <!-- カテゴリー設定 -->
            <p>カテゴリー</p>
            <div class="category__box">
                @foreach ($categories as $category)
                    <input type="checkbox" class="checkbox hidden" value="{{ $category->id }}" name="categories[]"
                        id="{{ $category->name }}"
                        {{ is_array(old('categories')) && in_array($category->id, old('categories')) ? 'checked' : '' }}>
                    <label class="category-btn" for="{{ $category->name }}">{{ $category->name }}</label>
                @endforeach
            </div>

            <label for="name">商品の状態</label>
            <select name="condition" required>
                <option value="" selected disabled>選択してください</option>
                <option value="良好">良好</option>
                <option value="目立った傷や汚れなし">目立った傷や汚れなし</option>
                <option value="やや傷や汚れあり">やや傷や汚れあり</option>
                <option value="状態が悪い">状態が悪い</option>
            </select>

            <h3 class="sell__title">商品名と説明</h3>
            <label for="name">商品名</label>
            <input type="text" name="name" value="{{ old('name') }}">
            <label for="brand">ブランド名</label>
            <input type="text" name="brand" value="{{ old('brand') }}">
            <label for="description">商品の説明</label>
            <textarea name="description" id="description">{{ old('description') }}</textarea>

            <label for="price">販売価格</label>
            <div class="price__box">
                <i class="fa-sharp fa-solid fa-yen-sign price-icon" style="color: #000000;"></i>
                <input class="input-price" type="number" name="price" value="{{ old('price') }}">
            </div>

            <button class="profile__btn" type="submit">出品する</button>
        </form>
        <div class="error-box">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const input = document.getElementById('imageInput')
            const preview = document.getElementById('imagePreview');
            input.addEventListener('change', function(e) {
                const file = e.target.files[0];
                if (file && file.type.match('image.*')) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        preview.src = e.target.result;
                        preview.style.display = 'block';
                    }
                    reader.readAsDataURL(file);
                } else {
                    preview.src = '';
                    preview.style.display = 'none';
                }
            });
        });
    </script>
@endsection
