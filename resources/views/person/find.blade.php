@extends('layouts.helloapp')

@section('title','Person.find')

@section('menubar')
  @parent
  検索ページ
@endsection

@section('content')
  <form action="/person/find" method="post">
    {{ csrf_field() }}
    <input type="text" name="input" value="{{$input}}">
    <input type="submit" value="find">
  </form>
  @isset($item)
    <table>
      <tr><th>Data</th></tr>
      <tr>
        <td>{{$item->getData()}}</td>
      </tr>
    </table>
  @endisset
@endsection

@section('footer')
Copyright 2019 tsukamoto.
@endsection
