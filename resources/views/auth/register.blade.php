@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8" style="max-width: 800px;">
            <div class="card">
                <div class="card-header">{{ __('Форма регистрации') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('ФИО') }}</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" autocomplete="name" autofocus>

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('Эл. почта') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" autocomplete="email">

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Пароль') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" autocomplete="new-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('Подтвердите пароль') }}</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" autocomplete="new-password">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="post" class="col-md-4 col-form-label text-md-right">{{ __('Должность') }}</label>

                            <div class="col-md-6">
                                <input id="post" type="text" class="form-control @error('post') is-invalid @enderror" name="post" value="{{ old('post') }}" autocomplete="post">

                                @error('post')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="employer_id" class="col-md-4 col-form-label text-md-right">{{ __('Работодатель') }}</label>

                            <div class="col-md-6">
                                <select id="employer_id" class="form-control @error('employer_id') is-invalid @enderror" name="employer_id" autocomplete="employer_id">
                                    <option value="1"<?php if (old('employer_id') == 1) echo ' selected'; ?>>ИП Корсун А.В.</option>
                                    <option value="2"<?php if (old('employer_id') == 2) echo ' selected'; ?>>ИП Корсун В.П.</option>
                                </select>
                                
                                @error('employer_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="form-group row">
                            <label for="department_id" class="col-md-4 col-form-label text-md-right">{{ __('Отдел') }}</label>

                            <div class="col-md-6">
                                <select id="department_id" class="form-control @error('department_id') is-invalid @enderror" name="department_id" autocomplete="department_id">
                                    @foreach ($departments as $department)
                                        <option value="{{ $department->id }}" <?php if (old('department_id') == $department->id) echo 'selected'; ?>>{{ $department->name }}</option>
                                    @endforeach
                                </select>
                                
                                @error('department_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="placement_date" class="col-md-4 col-form-label text-md-right">{{ __('Дата трудоустройства') }}</label>

                            <div class="col-md-6">
                                <input id="placement_date" type="date" class="form-control @error('placement_date') is-invalid @enderror" name="placement_date" value="{{ old('placement_date') }}" autocomplete="placement_date">
                                
                                @error('placement_date')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Зарегистрироваться') }}
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
