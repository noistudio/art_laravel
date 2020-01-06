@extends('vendor.installer.layouts.master')

@section('title', trans('installer_messages.final.title'))
@section('container')
<p class="paragraph" style="text-align: center;">{{ session('message')['message'] }}</p>
<p class="paragraph">Адрес админ.панели:{{route('backend/index')}}<br>Логин:{{ env('BACKEND_ADMIN_LOGIN') }}<br><br>Пароль:{{ env('BACKEND_ADMIN_PASSWORD') }}<br></p>

<div class="buttons">
    <a href="{{route('backend/index')}}" target="_blank" class="button">{{ trans('installer_messages.final.exit') }}</a>
</div>
@stop
