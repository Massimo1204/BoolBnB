@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center pt-3">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Edit Account Info</div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('user.update', Auth::id()) }}" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="form-group row mb-3">
                                <label for="first_name"
                                    class="col-md-4 col-form-label text-md-right">{{ __('First Name') }}*</label>

                                <div class="col-md-6">
                                    <input id="first_name" type="text"
                                        class="form-control @error('name') is-invalid @enderror" name="first_name"
                                        value="{{ $user->first_name }}" required autofocus>

                                    @error('name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>


                            <div class="form-group row mb-3">
                                <label for="last_name"
                                    class="col-md-4 col-form-label text-md-right">{{ __('Last Name') }}*</label>

                                <div class="col-md-6">
                                    <input id="last_name" type="text"
                                        class="form-control @error('name') is-invalid @enderror" name="last_name"
                                        value="{{ $user->last_name }}" required autofocus>

                                    @error('name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row mb-3">
                                <label for="email"
                                    class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}*</label>

                                <div class="col-md-6">
                                    <input id="email" type="email"
                                        class="form-control @error('email') is-invalid @enderror" name="email"
                                        value="{{ $user->email }}" required>

                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row mb-3">
                                <label for="birth_date"
                                    class="col-md-4 col-form-label text-md-right">{{ __('Birth Date') }}</label>

                                <div class="col-md-6">
                                    <input id="birth_date" type="date"
                                        class="form-control @error('birth_date') is-invalid @enderror" name="birth_date">

                                    @error('birth_date')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row mb-3">
                                <label for="profile_picture"
                                    class="col-md-4 col-form-label text-md-right">{{ __('Profile Picture') }}</label>

                                <div class="col-md-6">
                                    <input id="profile_picture" type="file"
                                        class="form-control @error('profile_picture') is-invalid @enderror"
                                        name="profile_picture">

                                    @error('profile_picture')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row mb-3">
                                <label for="password"
                                    class="col-md-4 col-form-label text-md-right">{{ __('Password') }}*</label>

                                <div class="col-md-6">
                                    <input id="password" type="password"
                                        class="form-control @error('password') is-invalid @enderror" name="password"
                                       >

                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row mb-3">
                                <label for="password-confirm"
                                    class="col-md-4 col-form-label text-md-right">{{ __('Confirm Password') }}*</label>

                                <div class="col-md-6">
                                    <input id="password-confirm" type="password" class="form-control  onChange="onChange()"
                                    @if ($errors->any())
                                    @foreach ($errors->all() as $error)
                                        @if (strpos($error, 'password confirmation') !== false)
                                        is-invalid
                                        @endif
                                    @endforeach
                                @endif " name="password_confirmation" required
                                        >
                                    @if ($errors->any())
                                        @foreach ($errors->all() as $error)
                                            @if (strpos($error, 'password confirmation') !== false)
                                                <strong class="text-danger fs-small mt-1" onChange="onChange()">{{ $error }}</strong>
                                            @endif
                                        @endforeach
                                    @endif
                                </div>
                            </div>
                    </div>

                    <div class="form-group row mb-2">
                        <div class="col-1 mx-auto">
                            <button type="submit" class="btn btn-primary mx-auto">
                                {{ __('Edit') }}
                            </button>
                        </div>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    </div>
@endsection

@section('footer-scripts')
    <script defer>

        function onChange() {
            const password = document.querySelector('#password');
            const confirm = document.querySelector('#password-confirm');
            if (confirm.value == password.value) {
                confirm.setCustomValidity('');
            } else {
                confirm.setCustomValidity('Passwords do not match');
            }
        }
    </script>
@endsection
