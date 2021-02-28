 $(document).ready(function(){

    $(document).on('click', '#btn-tambah', function(){
        $('#title-tambah').removeClass('layar')
        $('#title-edit').addClass('layar')
        $('#btn-simpan').removeClass('layar')
        $('#btn-simpan-pk').removeClass('layar')
        $('#btn-simpan-iku').removeClass('layar')
        $('#btn-update').addClass('layar')
        $('#btn-update-pk').addClass('layar')
        $('#btn-update-iku').addClass('layar')
        $('#id').addClass('layar')

        reset()

        // if(window.user.level > 2){
        //     $('#kabupaten').val(window.user.kabupaten)
        //     filter_kecamatan(window.user.kabupaten)
        // }

        $('#myModal').modal('show')
    })

    $(document).on('click', '#btn-simpan',function(e){
        e.preventDefault()

        let token = {
                "_token": $('#token').val()
            };

        let url = $('#form').attr('url')


        $.ajax({
            type: 'POST',
            url: url,
            data: $('#form').serialize(),
            headers: token,
            success: function(res){

                Toast.fire({
                    type: "success",
                    title: `Tambah data success`
                  });

                fetch_data()
                reset()
                reset_error()

            },
            error: function(data)
            {
                reset_error()
                let errors = data.responseJSON

                Toast.fire({
                    type: "error",
                    title: `${errors.message}`
                  });

                $.each(errors.errors, function(k, v){
                    $('#'+k+'_error').html(v)
                })
            }
        })
    })

    $(document).on('click', '#handleEdit', function(){
        longValueEdit($(this))

        $('#title-tambah').addClass('layar')
        $('#title-edit').removeClass('layar')
        $('#btn-simpan').addClass('layar')
        $('#btn-simpan-pk').addClass('layar')
        $('#btn-simpan-iku').addClass('layar')
        $('#btn-update').removeClass('layar')
        $('#btn-update-pk').removeClass('layar')
        $('#btn-update-iku').removeClass('layar')
        $('#id').removeClass('layar')

        reset_error()

        $('#myModal').modal('show')

    })

    $(document).on('click', '#btn-update', function(e){
        e.preventDefault()
        let id = $('#id').val()
        let url = $('#form').attr('urlUpdate')

        let token = {
                "_token": $('#token').val()
            };

        $.ajax({
            type: 'PUT',
            url: `${url}/${id}`,
            data: $('#form').serialize(),
            headers: token,
            success: function(res){

                reset()
                reset_error()
                fetch_data()

                $('#myModal').modal('hide')
                
                 Toast.fire({
                    type: "success",
                    title: `Update Success`,
                  });

            },
            error: function(data)
            {

                reset_error()
                let errors = data.responseJSON

                Toast.fire({
                    type: "error",
                    title: `${errors.message}`
                  });

                $.each(errors.errors, function(k, v){
                    $('#'+k+'_error').html(v)
                })
            }
        })

    })


    $(document).on('click', '#handleDelete', function(){
        let id = $(this).data('id')
        let url = $(this).attr('url')

        Swal.fire({
            title: "Are you sure?",
            text: "You won't be able to revert this!",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes, delete it!"
          }).then(result => {
            if (result.value) {
              $.ajax({
                    type: 'GET',
                    url: `${url}/${id}`,
                    success: function(res){
                        fetch_data()
                         Toast.fire({
                            type: "success",
                            title: `Delete Success`
                          });

                    },
                    error: function(data)
                    {

                        reset_error()
                        let errors = data.responseJSON

                        Toast.fire({
                            type: "error",
                            title: `${errors.message}`
                          });

                        $.each(errors.errors, function(k, v){
                            $('#'+k+'_error').html(v)
                        })
                    }
                })
            }
          });
    })

})


 
// $('.select2').select2({
//     theme: "bootstrap4"
// })

function ConfirmDelete() {
    var x = confirm("Yakin akan menghapus data?");
    if (x) return true; else return false;
}

function showPassword()
{
  let x = document.getElementById("password");
  let element = document.getElementById("iconPassword");

  if (x.type === "password") {
    x.type = "text";
    element.classList.remove("fa-eye-slash");
    element.classList.add("fa-eye");
  } else {
    x.type = "password";
    element.classList.remove("fa-eye");
    element.classList.add("fa-eye-slash");
  }
}



