$('body').on('click', '.modal-show', function (event) {
    event.preventDefault();

    let me = $(this),
        url = me.attr('href'),
        title = me.attr('title');

    $('#modal-title').text(title);
    $('#modal-btn-save').text(me.hasClass('edit') ? 'Update' : 'Create');

    $.ajax({
        url: url,
        dataType: 'HTML',
        success: function (response) {
            $('#modal-body').html(response);
        }
    });

    $('#modal').modal('show');
});


$('#modal-btn-save').click(function (event) {
    event.preventDefault();

    let form = $('#modal-body form'),
        url = form.attr('action'),
        method = $('input[name=_method]').val() == undefined ? 'POST' : 'PUT';

    let nameTable = $('#nameTable').val();

    form.find('.help-block').remove();
    form.find('.form-group').removeClass('has-error');

    $.ajax({
        url: url,
        method: method,
        // data: new FormData($('#form')[0]),
        data: form.serialize(),
        success: function (response) {
            form.trigger('reset'); // bersihkan inputan
            $('#modal').modal('hide'); // sembunyikan modal
            $('#' + nameTable).DataTable().ajax.reload(); // reload datatable

            // swal({
            //     type: 'success',
            //     title: 'success',
            //     text: 'data has been saved!'
            // });

            // console.log(response);
        },
        error: function (xhr) {
            let res = xhr.responseJSON;

            // if not null
            // res.errors pada each adalah key object array yang menampung pesan error dari validate 
            if ($.isEmptyObject(res) == false) {
                $.each(res.errors, function (key, value) {
                    $('#' + key)
                        .closest('.form-group') //mengambil parent yang terdekat
                        .addClass('has-error') //menambahkan class 
                        .append('<span class="help-block"><strong>' + value + '</strong></span>');

                })
            }

        }
    });
});


$('body').on('click', '.modal-delete', function (event) {
    event.preventDefault();

    let me = $(this),
        title = me.attr('title');
    url = me.attr('href'),
        csrf_token = $('meta[name="csrf-token"]').attr('content');

    Swal.fire({
  title: 'Anda yakin?',
  text: "Anda tidak akan dapat memulihkan data ini!",
  type: 'warning',
  showCancelButton: true,
  confirmButtonColor: '#3085d6',
  cancelButtonColor: '#d33',
  confirmButtonText: 'Ya, hapus!',
  cancelButtonText : 'Tidak'
}).then((result) => {
  if (result.value) {
    Swal.fire(
      'Dihapus!',
      'Data Telah Dihapus.',
      'success'
    )
  }
})

})