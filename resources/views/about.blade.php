@extends('layouts.app')
@section('title', 'About')
@section('content')
  <h1 class="text-2xl font-bold mb-4">About</h1>

  <x-alert type="success" class="mb-3">
    保存に成功しました。
  </x-alert>

  <x-alert type="danger" class="mb-3">
    エラーが発生しました。
  </x-alert>

  <p>OrderPad は Laravel 学習のためのミニアプリです。</p>
@endsection
