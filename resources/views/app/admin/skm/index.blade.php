@extends('layouts.template')

@section('content')

<div class="text-center" id="loading-on">
    @include('layouts._loading')
</div>

<div class="layar" id="loading-off">
    <div class="card card shadow mb-4">
        
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h4>Survey Kepuasan Masayarakat</h4>
        </div>

        <div class="card-body">
              <!-- include table -->
              @include('app.admin.skm._table')
            </div>

        </div> 
        <!-- end card body -->
    </div>
    <!-- end card -->
</div>
<!-- end loading -->

@endsection        

@section('scripts')
<script>
    $(document).ready(function(){


        fetch_data()

    })

    function fetch_data(){

        $('#loading-on').addClass('layar')
        $('#loading-off').removeClass('layar')

        $.ajax({
            type: 'GET',
            url: `{{ url('admin/skm/fetch') }}`,
            dataType: 'json',
            success: function(res){

                let output = ``

                let qty_res = JSON.parse(res.skms.length)


                let u1 = 0
                let u2 = 0
                let u3 = 0
                let u4 = 0
                let u5 = 0
                let u6 = 0
                let u7 = 0
                let u8 = 0
                let u9 = 0
                let u10 = 0
                let u11 = 0
                let u12 = 0
                


                $.each(res.skms, function(i, item){
                    let jawaban = JSON.parse(res.skms[i].jawaban)

                    u1 = parseInt(u1) + parseInt(jawaban.u1)
                    u2 = parseInt(u2) + parseInt(jawaban.u2)
                    u3 = parseInt(u3) + parseInt(jawaban.u3)
                    u4 = parseInt(u4) + parseInt(jawaban.u4)
                    u5 = parseInt(u5) + parseInt(jawaban.u5)
                    u6 = parseInt(u6) + parseInt(jawaban.u6)
                    u7 = parseInt(u7) + parseInt(jawaban.u7)
                    u8 = parseInt(u8) + parseInt(jawaban.u8)
                    u9 = parseInt(u9) + parseInt(jawaban.u9)
                    u10 = parseInt(u10) + parseInt(jawaban.u10)
                    u11 = parseInt(u11) + parseInt(jawaban.u11)
                    u12 = parseInt(u12) + parseInt(jawaban.u12)

                    let totalRataRata = parseInt(jawaban.u1) + parseInt(jawaban.u2) + parseInt(jawaban.u3) + parseInt(jawaban.u4) + parseInt(jawaban.u5) + parseInt(jawaban.u6) + parseInt(jawaban.u6) + parseInt(jawaban.u7) + parseInt(jawaban.u8) + parseInt(jawaban.u9) + parseInt(jawaban.u10) + parseInt(jawaban.u11) + parseInt(jawaban.u12)

                    output += `
                        <tr>
                            <td>${i+1}</td>
                            <td>
                                tt
                            </td>
                            <td>${jawaban.u1}</td>
                            <td>${jawaban.u2}</td>
                            <td>${jawaban.u3}</td>
                            <td>${jawaban.u4}</td>
                            <td>${jawaban.u5}</td>
                            <td>${jawaban.u6}</td>
                            <td>${jawaban.u7}</td>
                            <td>${jawaban.u8}</td>
                            <td>${jawaban.u9}</td>
                            <td>${jawaban.u10}</td>
                            <td>${jawaban.u11}</td>
                            <td>${jawaban.u12}</td>
                            <td>${totalRataRata.toFixed(2)}</td>
                        </tr>

                    `
                })

                let totalNilai = u1 + u2 + u3 + u4 + u5 + u6 + u7 + u8 + u9 + u10 + u11 + u12

                let nrr1 = u1/qty_res
                let nrr2 = u2/qty_res
                let nrr3 = u3/qty_res
                let nrr4 = u4/qty_res
                let nrr5 = u5/qty_res
                let nrr6 = u6/qty_res
                let nrr7 = u7/qty_res
                let nrr8 = u8/qty_res
                let nrr9 = u9/qty_res
                let nrr10 = u10/qty_res
                let nrr11 = u11/qty_res
                let nrr12 = u12/qty_res

                let totalNrr = nrr1 + nrr2 + nrr3 + nrr4 + nrr5 + nrr6 + nrr7 + nrr8 + nrr9 + nrr10 + nrr11 + nrr12


                let tertimbang1 = nrr1.toFixed(3)*0.083
                let tertimbang2 = nrr2.toFixed(3)*0.083
                let tertimbang3 = nrr3.toFixed(3)*0.083
                let tertimbang4 = nrr4.toFixed(3)*0.083
                let tertimbang5 = nrr5.toFixed(3)*0.083
                let tertimbang6 = nrr6.toFixed(3)*0.083
                let tertimbang7 = nrr7.toFixed(3)*0.083
                let tertimbang8 = nrr8.toFixed(3)*0.083
                let tertimbang9 = nrr9.toFixed(3)*0.083
                let tertimbang10 = nrr10.toFixed(3)*0.083
                let tertimbang11 = nrr11.toFixed(3)*0.083
                let tertimbang12 = nrr12.toFixed(3)*0.083

                let totalTertimbang = tertimbang1 + tertimbang2 + tertimbang3 + tertimbang4 + tertimbang5 + tertimbang6 + tertimbang7 + tertimbang8 + tertimbang9 + tertimbang10 + tertimbang11 + tertimbang12 
                let totalUnitPelayanan = totalTertimbang * 30

                    output += `
                        <tr>
                            <td colspan="2"><strong>Nilai/Unsur</strong></td>
                            <td><strong>${u1}</strong></td>
                            <td><strong>${u2}</strong></td>
                            <td><strong>${u3}</strong></td>
                            <td><strong>${u4}</strong></td>
                            <td><strong>${u5}</strong></td>
                            <td><strong>${u6}</strong></td>
                            <td><strong>${u7}</strong></td>
                            <td><strong>${u8}</strong></td>
                            <td><strong>${u9}</strong></td>
                            <td><strong>${u10}</strong></td>
                            <td><strong>${u11}</strong></td>
                            <td><strong>${u12}</strong></td>
                            <td><strong>${totalNilai.toFixed(2)}</strong></td>
                        </tr>
                        <tr>
                            <td colspan="2"><strong>NRR/Unsur</strong></td>
                            <td><strong>${nrr1.toFixed(3)}</strong></td>
                            <td><strong>${nrr2.toFixed(3)}</strong></td>
                            <td><strong>${nrr3.toFixed(3)}</strong></td>
                            <td><strong>${nrr4.toFixed(3)}</strong></td>
                            <td><strong>${nrr5.toFixed(3)}</strong></td>
                            <td><strong>${nrr6.toFixed(3)}</strong></td>
                            <td><strong>${nrr7.toFixed(3)}</strong></td>
                            <td><strong>${nrr8.toFixed(3)}</strong></td>
                            <td><strong>${nrr9.toFixed(3)}</strong></td>
                            <td><strong>${nrr10.toFixed(3)}</strong></td>
                            <td><strong>${nrr11.toFixed(3)}</strong></td>
                            <td><strong>${nrr12.toFixed(3)}</strong></td>
                            <td><strong>${totalNrr.toFixed(2)}</strong></td>
                        </tr>


                        <tr>
                            <td colspan="2"><strong>NRR Tertimbang/Unsur</strong></td>
                            <td><strong>${tertimbang1.toFixed(3)}</strong></td>
                            <td><strong>${tertimbang2.toFixed(3)}</strong></td>
                            <td><strong>${tertimbang3.toFixed(3)}</strong></td>
                            <td><strong>${tertimbang4.toFixed(3)}</strong></td>
                            <td><strong>${tertimbang5.toFixed(3)}</strong></td>
                            <td><strong>${tertimbang6.toFixed(3)}</strong></td>
                            <td><strong>${tertimbang7.toFixed(3)}</strong></td>
                            <td><strong>${tertimbang8.toFixed(3)}</strong></td>
                            <td><strong>${tertimbang9.toFixed(3)}</strong></td>
                            <td><strong>${tertimbang10.toFixed(3)}</strong></td>
                            <td><strong>${tertimbang11.toFixed(3)}</strong></td>
                            <td><strong>${tertimbang12.toFixed(3)}</strong></td>
                            <td><strong>${totalTertimbang.toFixed(3)}</strong></td>
                        </tr>
                        <tr>
                            <td colspan="14"><strong>IKM Unit Pelayanan</strong></td>
                            <td><strong>${totalUnitPelayanan.toFixed(3)}</strong></td>
                        </tr>
                    `

                $('#load').html(output)
            }
        })

    }

</script>
@endsection
