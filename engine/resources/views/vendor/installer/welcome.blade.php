@extends('vendor.installer.layouts.master')

@section('title', trans('installer_messages.welcome.title'))
@section('container')
<p class="paragraph" style="text-align: center;">{{ trans('installer_messages.welcome.message') }}</p>
<p class="paragraph">С помощью мастера установки вы установите не только Laravel ,но и библиотеку Art. </p>
<div class="buttons">
    <a href="{{ route('LaravelInstaller::environment') }}" class="button">{{ trans('installer_messages.next') }}</a>
</div>
@stop
