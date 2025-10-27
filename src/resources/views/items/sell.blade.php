@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/items/sell.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
@endsection

@section('content')
    <div class="sell">
        <h2 class="sell-title">商品の出品</h2>
        <form class="sell-form" action="{{ route('items.store') }}" method="post" enctype="multipart/form-data">
            @csrf
            <!-- 商品画像設定 -->
            <p class="sell-form__section-title">商品画像</p>
            <div class="sell-form__input-box">
                <div class="sell-form__image-box">
                    <div id="previewContainer">
                        <img id="imagePreview" src="" alt="商品画像プレビュー">
                    </div>
                    <label class="sell-form__select-btn" for="imageInput">画像を選択する</label>
                    <input type="file" class="hidden" id="imageInput" name="item_image" accept="image/*" value="{{ old('item_image') }}">
                </div>
                <div class="sell-form__register-error">
                    @error('item_image')
                        {{ $message }}
                    @enderror
                </div>
            </div>

            <h3 class="sell-form__title--gray">商品の詳細</h3>
            <!-- カテゴリー設定 -->
            <p class="sell-form__section-title">カテゴリー</p>
            <div class="sell-form__input-box">
                <div class="sell-form__category-box">
                    @foreach ($categories as $category)
                        <input type="checkbox" class="sell-form__checkbox hidden" value="{{ $category->id }}" name="categories[]"
                            id="{{ $category->name }}"
                            {{ is_array(old('categories')) && in_array($category->id, old('categories')) ? 'checked' : '' }}>
                        <label class="sell-form__category-btn" for="{{ $category->name }}">{{ $category->name }}</label>
                    @endforeach
                </div>
                <div class="sell-form__register-error">
                    @error('categories')
                        {{ $message }}
                    @enderror
                </div>
            </div>

            <div class="sell-form__input-box">
                <label class="sell-form__section-title" for="name">商品の状態</label>
                <select name="condition">
                    <option value="" selected disabled>選択してください</option>
                    <option value="良好">良好</option>
                    <option value="目立った傷や汚れなし">目立った傷や汚れなし</option>
                    <option value="やや傷や汚れあり">やや傷や汚れあり</option>
                    <option value="状態が悪い">状態が悪い</option>
                </select>
                <div class="sell-form__register-error">
                    @error('condition')
                        {{ $message }}
                    @enderror
                </div>
            </div>

            <h3 class="sell-form__title--gray">商品名と説明</h3>

            <div class="sell-form__input-box">
                <label class="sell-form__section-title" for="name">商品名</label>
                <input type="text" name="name" value="{{ old('name') }}">
                <div class="sell-form__register-error">
                    @error('name')
                        {{ $message }}
                    @enderror
                </div>
            </div>

            <div class="sell-form__input-box">
                <label class="sell-form__section-title" for="brand">ブランド名</label>
                <input type="text" name="brand" value="{{ old('brand') }}">
            </div>

            <div class="sell-form__input-box">
                <label class="sell-form__section-title" for="description">商品の説明</label>
                <textarea class="sell-form__description" name="description" id="description">{{ old('description') }}</textarea>
                <div class="sell-form__register-error">
                    @error('description')
                        {{ $message }}
                    @enderror
                </div>
            </div>

            <div class="sell-form__input-box">
                <label class="sell-form__section-title" for="price">販売価格</label>
                <div class="sell-form__price-box">
                    <i class="sell-form__price-icon fa-sharp fa-solid fa-yen-sign" style="color: #000000;"></i>
                    <input class="sell-form__price-input" type="number" name="price" value="{{ old('price') }}">
                </div>

                <div class="sell-form__register-error">
                    @error('price')
                        {{ $message }}
                    @enderror
                </div>
            </div>
            <button class="sell-form__submit-btn" type="submit">出品する</button>
        </form>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const input = document.getElementById('imageInput');
            const preview = document.getElementById('imagePreview');
            const form = document.querySelector('.sell-form');

            input.addEventListener('change', function(e) {
                const file = e.target.files[0];

                // ファイルが選択されていない場合はプレビューを消す
                if (!file) {
                    preview.src = '';
                    preview.style.display = 'none';
                    return;
                }

                // 選択されたファイルが画像かどうかチェック
                if (file.type.match('image.*')) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        preview.src = e.target.result;
                        preview.style.display = 'block';
                    }
                    reader.readAsDataURL(file);
                } else {
                    // 画像以外が選ばれた場合の処理
                    preview.src = '';
                    preview.style.display = 'none';
                    // alert('画像ファイル（jpeg, png）を選択してください');
                    input.value = ''; // 選択をクリアして再度選択できるように
                }
            });
        });
    </script>
@endsection
