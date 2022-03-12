@extends('layouts.app')

<style>
    .reset-password-section {
        margin-top: 86px;
        margin-bottom: 168px;
        width: 335px;
        display: flex;
    }

    .reset-password-section .card {
        box-shadow: 0px 3px 6px #00000029 !important;
        border-radius: 6px;
    }

    .reset-password-section .card-body {
        padding: 20px 14px !important;
    }

    .reset-password-section .reset-password-title {
        font-size: 24px;
        font-weight: 500;
        color: #42424d;
        margin-bottom: 20px !important;
    }

    .reset-password-section label.label-for-email {
        font-size: 12px;
        font-weight: 600;
        color: #131220;
    }

    .reset-password-section label.label-for-email span.text-danger {
        color: #e31616;
        font-size: 14px;
        font-weight: 700;
    }

    .reset-password-section input#email {
        background-color: #ffffff;
        border: 1px solid #13122066;
        border-radius: 4px;
    }

    .reset-password-section .btn-primary {
        color: #ffffff !important;
        font-size: 12px;
        font-weight: 600;
        background: transparent linear-gradient(256deg, #7272FF 0%, #9759FF 100%) 0% 0% no-repeat padding-box;
        box-shadow: 0px 2px 4px #9759FF4D;
        border-radius: 12px !important;
        height: 40px;
        width: 160px;
    }

    @media (min-width: 320px) and (max-width: 767px) {
        .reset-password-section {
            margin-bottom: 50px;
        }
        .reset-password-section .reset-password-title {
            font-size: 20px;
        }
    }
</style>
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="reset-password-section">
            <div class="row">
                <div class="col-md-12 px-0">
                    <p class="reset-password-title">{{ __('Password Reset') }}</p>
                </div>
                <div class="card col-md-12 px-0">
                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        <form method="POST" action="{{ route('password.email') }}">
                            @csrf
                            <div class="form-group">
                                <label for="email" class="label-for-email">Email Address<span class="text-danger">*</span></label>
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-group row mb-0 justify-content-center">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Send Reset Link') }}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
