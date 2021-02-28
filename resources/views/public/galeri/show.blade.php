@extends('public.template2')

@section('content')

<div class="row">
    <div class="col-md-12">
      <img src="{{ url('/galeri/'.$model->photo) }}" width="100%">
    </div>
</div>

<br>
<br>
<div class="row">
  <div class="col-md-12">
    <h2 class="text-center">{{ $model->judul }}</h2>
  </div>
</div>

<br>
<div class="row">
  <div class="dol-md-12">
    <p>{{ $model->title }}</p>
  </div>
</div>

            
@endsection      
