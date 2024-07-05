@extends('layouts.master')

@section('title')
    Daftar Departemen
@endsection

@section('breadcrumb')
    @parent
    <li class="active">Daftar Departemen</li>
@endsection

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="box">
            <div class="box-header with-border">
                <button onclick="addForm('{{ route('dept.store') }}')" class="btn btn-success btn-md"><i class="fa fa-plus-circle"></i> Tambah</button>
            </div>
            <div class="box-body table-responsive">
                <div class="alert alert-danger alert-dismissible alertError" style="display: none;">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <span id="alertError"></span>
                </div>

                <table class="table table-stiped table-bordered">
                    <thead>
                        <th width="5%">No</th>
                        <th>Kode</th>
                        <th>Departemen</th>
                        <th>Perent</th>
                        <th>Email</th>
                        <th>Telp</th>
                        <th>Alamat</th>
                        <th width="15%"><i class="fa fa-cog"></i></th>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>

@includeIf('dept.form')
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
                url: '{{ route('dept.data') }}',
            },
            columns: [
                {data: 'DT_RowIndex', searchable: false, sortable: false},
                {data: 'deptcode'},
                {data: 'deptname'},
                {data: 'deptperentnama'},
                {data: 'deptemail'},
                {data: 'depttelp'},
                {data: 'deptaddress'},
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
        $('.msgError').hide();
        $('#modal-form').modal('show');
        $('#modal-form .modal-title').text('Tambah Data');

        $('#modal-form form')[0].reset();
        $('#modal-form form').attr('action', url);
        $('#modal-form [name=_method]').val('post');
        $('#deptcode').prop('readonly', false);
        $('#modal-form [name=deptcode]').focus();
        $('#modal-form [name=deptperent]').val('').trigger('change');
    }

    function editForm(url) {
        $('.msgError').hide();
        $('#modal-form').modal('show');
        $('#modal-form .modal-title').text('Edit Data');

        $('#modal-form form')[0].reset();
        $('#modal-form form').attr('action', url);
        $('#modal-form [name=_method]').val('put');
        $('#deptcode').prop('readonly', true);
        $('#modal-form [name=deptname]').focus();

        $.get(url)
            .done((response) => {
                $('#modal-form [name=deptcode]').val(response.deptcode);
                $('#modal-form [name=deptperent]').val(response.deptperent).trigger('change');
                $('#modal-form [name=deptname]').val(response.deptname);
                $('#modal-form [name=deptemail]').val(response.deptemail);
                $('#modal-form [name=depttelp]').val(response.depttelp);
                $('#modal-form [name=deptaddress]').val(response.deptaddress);
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