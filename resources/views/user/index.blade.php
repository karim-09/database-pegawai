@extends('layouts.master')

@section('title')
    Daftar User
@endsection

@section('breadcrumb')
    @parent
    <li class="active">Daftar User</li>
@endsection

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="box">
            <div class="box-header with-border">
                <button onclick="addForm('{{ route('user.store') }}')" class="btn btn-success btn-md"><i class="fa fa-plus-circle"></i> Tambah</button>
            </div>
            <div class="box-body table-responsive">
                <div class="alert alert-danger alert-dismissible alertError" style="display: none;">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <span id="alertError"></span>
                </div>

                <table class="table table-stiped table-bordered">
                    <thead>
                        <th width="5%">No</th>
                        <th>Username</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th width="15%"><i class="fa fa-cog"></i></th>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>

@includeIf('user.form')
@endsection

@push('scripts')
<script>
    let table;

    $(function () {
        table = $('.table').DataTable({
            responsive: true,
            processing: true,
            serverSide: true,
            autoWidth: false,
            ajax: {
                url: '{{ route('user.data') }}',
            },
            columns: [
                {data: 'DT_RowIndex', searchable: false, sortable: false},
                {data: 'username'},
                {data: 'name'},
                {data: 'email'},
                {data: 'rolename'},
                {data: 'aksi', searchable: false, sortable: false},
            ]
        });

        $('#modal-form').validator().on('submit', function (e) {
            if (! e.preventDefault()) {
                $.post($('#modal-form form').attr('action'), $('#modal-form form').serialize())
                    .done((response) => {
                        if(response.status == true){
                            $('.msgError').hide();
                            $('#modal-form').modal('hide');
                            table.ajax.reload();
                            swal('Berhasil',response.message,'success');
                        }else{
                            $('.msgError').show();
                            $('#msgError').html(response.message);
                            return;
                        }
                    })
                    .fail((errors) => {
                        alert('Tidak dapat menyimpan data');
                        return;
                    });
            }
        });
    });

    function addForm(url) {
        $('#modal-form').modal('show');
        $('#modal-form .modal-title').text('Tambah User');

        $('#modal-form form')[0].reset();
        $('#modal-form form').attr('action', url);
        $('#modal-form [name=_method]').val('post');
        $('#modal-form [name=name]').focus();

        $('#password, #password_confirmation').attr('required', true);
    }

    function editForm(url) {
        $('#modal-form').modal('show');
        $('#modal-form .modal-title').text('Edit User');

        $('#modal-form form')[0].reset();
        $('#modal-form form').attr('action', url);
        $('#modal-form [name=_method]').val('put');
        $('#modal-form [name=name]').focus();

        $('#password, #password_confirmation').attr('required', false);

        $.get(url)
            .done((response) => {
                $('#modal-form [name=name]').val(response.name);
                $('#modal-form [name=email]').val(response.email);
                $('#modal-form [name=role_id]').val(response.role_id).trigger('change');
            })
            .fail((errors) => {
                alert('Tidak dapat menampilkan data');
                return;
            });
    }

    function deleteData(url) {
      swal({
        title: 'Apakah yakin akan hapus data?',
        text: "Anda akan menghapus data dari database!",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d73925',
        cancelButtonColor: '#ccc',
        confirmButtonText: 'Hapus',
        closeOnConfirm: false
      }).then(function(isConfirm) {
        if (isConfirm) {
            $.post(url, {
                    '_token': $('[name=csrf-token]').attr('content'),
                    '_method': 'delete'
                })
                .done((response) => {
                    if(response.status == true){
                        $('.alertError').hide();
                        table.ajax.reload();
                        var sts1 = 'Berhasil';
                        var sts2 = 'success';
                        var msg = response.message;
                    }else{
                        $('.alertError').show();
                        $('#alertError').html(response.message);
                        var sts1 = 'Gagal';
                        var sts2 = 'warning';
                        var msg = 'Data gagal dihapus';
                    }

                    swal(sts1,msg,sts2);
                })
                .fail((errors) => {
                    alert('Tidak dapat menghapus data');
                    return;
                });
        }
      }) 
    }
</script>
@endpush