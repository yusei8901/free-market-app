@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/profile/edit.css') }}">
@endsection

@section('content')
    @if(session('success'))
        <div class="verify__success">
            {{ session('success') }}
        </div>
    @endif
    <div class="edit">
        <h2 class="edit-title">プロフィール設定</h2>
        <form class="edit-form" action="/mypage/profile" method="post" enctype="multipart/form-data">
            @csrf
            <div class="edit-form__input-box">
                <div class="edit-form__image-box">
                    <div id="previewContainer">
                        <img id="imagePreview" class="edit-form__profile-image"
                            src="{{ $user->profile_image ? asset('storage/' . $user->profile_image) : '' }}" alt="プロフィール画像"
                            style="{{ $user->profile_image ? '' : 'display:none;' }}">
                    </div>
                    <label class="edit-form__select-btn" for="imageInput">画像を選択する</label>
                    <input type="file" class="hidden" id="imageInput" name="profile_image" accept="image/*">
                </div>
            </div>
            <div class="edit-form__register-error">
                @error('profile_image')
                    {{ $errors->first('profile_image') }}
                @enderror
            </div>
            <div class="edit-form__input-box">
                <label for="name">ユーザー名</label>
                <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}">
            </div>
            <div class="edit-form__register-error">
                @error('name')
                    {{ $errors->first('name') }}
                @enderror
            </div>
            <div class="edit-form__input-box">
                <label for="postal_code">郵便番号</label>
                <input type="text" name="postal_code" id="postal_code"
                    value="{{ old('postal_code', $user->postal_code) }}">
            </div>
            <div class="edit-form__register-error">
                @error('postal_code')
                    {{ $errors->first('postal_code') }}
                @enderror
            </div>
            <div class="edit-form__input-box">
                <label for="address">住所</label>
                <input type="text" name="address" id="address" value="{{ old('address', $user->address) }}">
            </div>
            <div class="edit-form__register-error">
                @error('address')
                    {{ $errors->first('address') }}
                @enderror
            </div>
            <div class="edit-form__input-box">
                <label for="building">建物名</label>
                <input type="text" name="building" id="building" value="{{ old('building', $user->building) }}">
            </div>
            <div class="edit-form__register-error">
                @error('building')
                    {{ $errors->first('building') }}
                @enderror
            </div>
            <button class="edit-form__submit-btn" type="submit">更新する</button>
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
