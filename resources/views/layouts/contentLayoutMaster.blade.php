@isset($pageConfigs)
    {!! Helper::updatePageConfig($pageConfigs) !!}
@endisset

<!DOCTYPE html>
@php
    $configData = Helper::applClasses();
@endphp

<html class="loading {{ $configData['theme'] === 'light' ? '' : $configData['layoutTheme'] }}"
    lang="@if (session()->has('locale')) 
    {{ session()->get('locale') }}
    @else
    {{ $configData['defaultLanguage'] }} 
    @endif"
    data-textdirection="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}"
    @if ($configData['theme'] === 'dark') data-layout="dark-layout" @endif>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1.0,minimal-ui">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="{{ env('APP_NAME', 'APP') }} | Dashboard">
    <meta name="keywords" content="{{ env('APP_NAME', 'APP') }} | Dashboard">
    <meta name="author" content="Darbi">
    <title>{{ env('APP_NAME', 'APP') }} | @yield('title')</title>
    <link rel="apple-touch-icon" href="{{ asset('images/ico/apple-icon-120.png') }}">
    {{-- <link rel="shortcut icon" type="image/x-icon" href="{{ asset('images/logo/favicon.ico') }}"> --}}
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('images/logo/white-sm.png') }}">

    {{-- Include core + vendor Styles --}}
    @include('panels/styles')
</head>

@isset($configData['mainLayoutType'])
    @extends($configData['mainLayoutType'] === 'horizontal' ? 'layouts.horizontalLayoutMaster' : 'layouts.verticalLayoutMaster')
@endisset
