@extends('layouts.template')

@section('content')

<div class="box box-default" style="padding: 10px;">

    <div class="box-header">
    	<h4>Tambah Indikator Kinerja Individu</h4>
    </div>

<div class="box-body">
	{{-- <div class="table-responsive"> --}}

		<form action="{{route('iki.store')}}" method="POST">
			{{ csrf_field() }}
			<div class="row">
				<div class="col-md-12">
                    <div class="col-sm-4">
                        <select id="pegawai_id" class="form-control{{ $errors->has('pegawai_id') ? ' is-invalid' : '' }} select2" name="pegawai_id">
                        <option value="">--Pilih Pegawai--</option>
                        @foreach($pegawais as $pegawai)
                        <option {{ old('pegawai_id') ? 'selected' : '' }} value="{{ $pegawai->id }}">{{ $pegawai->nama }}</option>
                        @endforeach
                        </select>

                        @if ($errors->has('pegawai_id'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('pegawai_id') }}</strong>
                            </span>
                        @endif
                    </div>
                        

                    <div class="col-sm-4">
                        <select id="pimpinan_id" class="form-control{{ $errors->has('pimpinan_id') ? ' is-invalid' : '' }} select2" name="pimpinan_id">
                        <option value="">--Pilih Pimpinan--</option>
                        @foreach($pimpinans as $pimpinan)
                        <option {{ old('pimpinan_id') ? 'selected' : '' }} value="{{ $pimpinan->id }}">{{ $pimpinan->nama }}</option>
                        @endforeach
                        </select>

                        @if ($errors->has('pimpinan_id'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('pimpinan_id') }}</strong>
                            </span>
                        @endif
                    </div>

                     <div class="col-sm-4">
                        <select id="tahun" class="form-control{{ $errors->has('tahun') ? ' is-invalid' : '' }} select2" name="tahun">
                            <option value="">--pilih Tahun--</option>
                            <option value="2017">2017</option>
                            <option value="2018">2018</option>
                            <option value="2019">2019</option>
                            <option value="2020">2020</option>
                            <option value="2021">2021</option>
                        </select>

                        @if ($errors->has('tahun'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('tahun') }}</strong>
                            </span>
                        @endif
                    </div>
                        


				</div>
			</div>

			<hr>

			<div class="row">

				<div class="col-md-12">

                    <div class="col-sm-4">
                        <input id="sasaran_strategis" type="text" class="form-control{{ $errors->has('sasaran_strategis') ? ' is-invalid' : '' }}" name="sasaran_strategis" value="{{ old('sasaran_strategis') }}" placeholder="Sasaran Strategis..">

                        @if ($errors->has('sasaran_strategis'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('sasaran_strategis') }}</strong>
                            </span>
                        @endif
                    </div>

                    <div class="col-sm-3">
                        <select id="satuan_id" class="form-control{{ $errors->has('satuan_id') ? ' is-invalid' : '' }} select2" name="satuan_id">
                        <option value="">--Pilih Satuan--</option>
                        @foreach($satuans as $satuan)
                        <option {{ old('satuan_id') ? 'selected' : '' }} nama_satuan="{{ $satuan->satuan_nama }}" value="{{ $satuan->id }}">{{ $satuan->satuan_nama }}</option>
                        @endforeach
                        </select>

                        @if ($errors->has('satuan_id'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('satuan_id') }}</strong>
                            </span>
                        @endif
                    </div>
                    

                    <div class="col-sm-4">
                        <input id="target" type="text" class="form-control{{ $errors->has('target') ? ' is-invalid' : '' }}" name="target" placeholder="Target..">

                        @if ($errors->has('target'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('target') }}</strong>
                            </span>
                        @endif
                    </div>

                    <div class="col-md-1">
						<button class="btn btn-primary" id="addIki"><i class='fa fa-plus'></i></button>
					</div>
                        

				</div>

			</div>

			<br>

			<div class="table-responsive" style="width:100%;overflow: scroll;height:200px">
				<table class="table table-striped">
					<thead>
						<tr>
							<th>Sasaran Strategis</th>
							<th>Satuan</th>
							<th>Target</th>
							<th>#</th>
						</tr>
					</thead>
					<tbody id="load_body">

					</tbody>
				</table>
			</div>

		<hr>

		<div class="pull-right">
                <button class="btn btn-primary" id="simpan"> Simpan</button> &nbsp;
                <a href="{{ route('iki.index') }}" class="btn btn-default"> Batal</a>
		</div>

		</form>
	</div>
</div>


@endsection

@push('scripts')
	<script type="text/javascript">
		$(document).ready(function(){

			 $(document).on('click', '.remove' ,function(){
		      var delete_row = $(this).data("row");
		      $('#' + delete_row).remove();
		    });

			 $('#simpan').prop('disabled', true);


			var count=1;
		    $(document).on('click', '#addIki',function(e){
		      e.preventDefault();
		      let sasaran_strategis = $('#sasaran_strategis').val();
		      let satuan = $('#satuan_id option:selected').attr('nama_satuan');
		      let satuan_id = $('#satuan_id').val();
		      let target = $('#target').val();

		      count = count + 1;

		      let table = "<tr id='row"+count+"'>";
		          table += "<td><input type='text' class='form-control' name='sasaran_strategis_array[]' id='sasaran_strategis_array[]' value='"+sasaran_strategis+"' readonly></td>";
		          table += "<td><input type='text' class='form-control' name='satuan_array[]' id='satuan_array[]' value='"+satuan+"' readonly><input type='hidden' class='form-control' name='satuan_id_array[]' id='satuan_id_array[]' value='"+satuan_id+"' readonly></td>";
		          table += "<td><input type='text' class='form-control' name='target_array[]' id='target_array[]' value='"+target+"' readonly></td>";
		          table += "<td><button type='button' name='remove' class='btn btn-danger remove' data-row='row"+count+"'><i class='fa fa-minus'></i></button></td>";
		          table += "</tr>";

		              $('#load_body').prepend(table);
		              $('#simpan').prop('disabled', false);
		              clear();
		    });
		});

		function clear()
		{
			  $('#sasaran_strategis').val('');
		      $('#satuan').val('');
		      $('#target').val('');
		}
	</script>
@endpush




