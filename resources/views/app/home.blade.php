@extends('layouts.template')

@section('content')
    <div class="mt-5 text-center">
	    <img src="{{ asset('img/E-SAKIP_COLOR.png') }}" width="300px;" alt="">
	    <h3 style="font-family: Philosopher; font-weight: bold;">Sistem Akuntabilitas Kinerja Instansi Pemerintah</h3>
	    <h4 style="font-family: Philosopher; font-weight: bold;">Kabupaten Kepulauan Meranti</h4>
    </div> 
@stop        

@push('scripts')
<script src="{{ asset('js/highcharts.js') }}"></script>
<script src="{{ asset('js/highcharts-3d.js') }}"></script>
<script src="{{ asset('js/exporting.js') }}"></script>
<script src="{{ asset('js/export-data.js') }}"></script>

@endpush