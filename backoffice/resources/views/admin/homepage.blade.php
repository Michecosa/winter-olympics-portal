@extends('layouts.app')

@section('content')
<div class="container my-5">
  <h2>Welcome back, {{ Auth::user()?->name }}</h2>
</div>
@endsection
