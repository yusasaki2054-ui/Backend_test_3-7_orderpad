@extends('layouts.app')
@section('title', '404 Not Found')
@section('content')
  <h1 class="text-2xl font-bold mb-4">404 - ページが見つかりません</h1>
  <p>お探しのページは存在しません。</p>
  <a href="{{ route('home') }}" class="text-blue-500">トップへ戻る</a>
@endsection
