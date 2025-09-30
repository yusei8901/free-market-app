@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/profile/edit.css') }}">
@endsection

@section('content')
    <div class="profile__box">
        <h2 class="profile__title">プロフィール設定</h2>
        <form class="profile__form" action="/profile/edit" method="post" enctype="multipart/form-data">
            @csrf
            <div class="input-box">
                <div class="image-box">
                    <div id="previewContainer">
                        <img id="imagePreview" class="profile-image"
                            src="{{ $user->profile_image ? asset('storage/' . $user->profile_image) : '' }}" alt="プロフィール画像"
                            style="{{ $user->profile_image ? '' : 'display:none;' }}">
                    </div>
                    <label class="select-btn" for="imageInput">画像を選択する</label>
                    <input type="file" class="hidden" id="imageInput" name="profile_image" accept="image/*">
                </div>
            </div>
            <div class="message-box">
                @error('profile_image')
                    <p class="message-error">{{ $errors->first('profile_image') }}</p>
                @enderror
            </div>
            <div class="input-box">
                <label for="name">ユーザー名</label>
                <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}">
            </div>
            <div class="message-box">
                @error('name')
                    <p class="message-error">{{ $errors->first('name') }}</p>
                @enderror
            </div>
            <div class="input-box">
                <label for="postal_code">郵便番号</label>
                <input type="text" name="postal_code" id="postal_code"
                    value="{{ old('postal_code', $user->postal_code) }}">
            </div>
            <div class="message-box">
                @error('postal_code')
                    <p class="message-error">{{ $errors->first('postal_code') }}</p>
                @enderror
            </div>
            <div class="input-box">
                <label for="address">住所</label>
                <input type="text" name="address" id="address" value="{{ old('address', $user->address) }}">
            </div>
            <div class="message-box">
                @error('address')
                    <p class="message-error">{{ $errors->first('address') }}</p>
                @enderror
            </div>
            <div class="input-box">
                <label for="building">建物名</label>
                <input type="text" name="building" id="building" value="{{ old('building', $user->building) }}">
            </div>
            <div class="message-box">
                @error('building')
                    <p class="message-error">{{ $errors->first('building') }}</p>
                @enderror
            </div>
            <button class="submit-btn" type="submit">更新する</button>
        </form>
    </div>
    <script>
        document.getElementById('imageInput').addEventListener('change', function(e) {
            const file = e.target.files[0];
            const preview = document.getElementById('imagePreview');
            if (!file) {
                return; // 選択解除された場合は何もしない
            }
            const objectUrl = URL.createObjectURL(file);
            preview.src = objectUrl;
            preview.style.display = 'block'; // 非表示だった場合も表示
        });
    </script>
@endsection
