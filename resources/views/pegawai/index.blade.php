@extends('layouts.master')

@section('title')
    Daftar Pegawai
@endsection

@section('breadcrumb')
    @parent
    <li class="active">Daftar Pegawai</li>
@endsection

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="box">
            <div class="box-header with-border">
                <div class="panel box box-primary">
                  <div class="box-header with-border">
                    <h4 class="box-title">
                      <a data-toggle="collapse" data-parent="#accordion" href="#filter">
                        Filter
                      </a>
                    </h4>
                  </div>
                  <div id="filter" class="panel-collapse collapse in">
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-2 form-group">
                                <label for="fdept" class="control-label">Departemen</label>
                                <select onchange="setFilter()" name="fdept" id="fdept" class="form-control select2" style="width: 100%;" required>
                                    <option value="" hidden selected>--Pilih--</option>
                                    @foreach(getDept() as $key => $row)
                                    <option value="{{ $row['deptcode'] }}" class="{{($row['deptperent'] > 0)?'ml-2':''}}">{{ $row['deptname'] }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-2 form-group">
                                <label for="fagama" class="control-label">Agama</label>
                                <select onchange="setFilter()" name="fagama" id="fagama" class="form-control select2" style="width: 100%;" required>
                                    <option value="" hidden selected>--Pilih--</option>
                                    @foreach(getOption('agama') as $key => $row)
                                    <option value="{{ $row->kode }}">{{ $row->nama }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-2 form-group">
                                <label for="fstatusnikah" class="control-label">Status Nikah (SN)</label>
                                <select onchange="setFilter()" name="fstatusnikah" id="fstatusnikah" class="form-control select2" style="width: 100%;" required>
                                    <option value="" hidden selected>--Pilih--</option>
                                    @foreach(getOption('statusnikah') as $key => $row)
                                    <option value="{{ $row->kode }}">{{ $row->nama }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-2 form-group">
                                <label for="fpendidikan" class="control-label">Pendidikan</label>
                                <select onchange="setFilter()" name="fpendidikan" id="fpendidikan" class="form-control select2" style="width: 100%;" required>
                                    <option value="" hidden selected>--Pilih--</option>
                                    @foreach(getOption('pendidikan') as $key => $row)
                                    <option value="{{ $row->kode }}">{{ $row->nama }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-2 form-group">
                                <label for="fjabatan" class="control-label">Jabatan</label>
                                <select onchange="setFilter()" name="fjabatan" id="fjabatan" class="form-control select2" style="width: 100%;" required>
                                    <option value="" hidden selected>--Pilih--</option>
                                    @foreach(getOption('jabatan') as $key => $row)
                                    <option value="{{ $row->kode }}">{{ $row->nama }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-2 form-group">
                                <label for="fstatus" class="control-label">Status</label>
                                <select onchange="setFilter()" name="fstatus" id="fstatus" class="form-control select2" style="width: 100%;" required>
                                    <option value="" hidden selected>--Pilih--</option>
                                    @foreach(getOption('statuspegawai') as $key => $row)
                                    <option value="{{ $row->kode }}">{{ $row->nama }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                  </div>
                </div>
                <button onclick="addForm('{{ route('pegawai.store') }}')" class="btn btn-success btn-md"><i class="fa fa-plus-circle"></i> Tambah</button>
            </div>
            <div class="box-body table-responsive">
                <div class="alert alert-danger alert-dismissible alertError" style="display: none;">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <span id="alertError"></span>
                </div>

                <table class="table table-stiped table-bordered">
                    <thead>
                        <th width="3%">No</th>
                        <th>NIP</th>
                        <th>Nama Lengkap</th>
                        <th>TTL</th>
                        <th>L/P</th>
                        <th>Pendidikan</th>
                        <th>Departemen</th>
                        <th>Jabatan</th>
                        <th>Agama</th>
                        <th>SN</th>
                        <th>No Telp</th>
                        <th>Status</th>
                        <th width="8%"><i class="fa fa-cog"></i></th>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>

@includeIf('pegawai.form')
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
                url: '{{ route('pegawai.data') }}',
                data: function(data){
                   data.fdept = $('[name=fdept]').val();
                   data.fagama = $('[name=fagama]').val();
                   data.fstatusnikah = $('[name=fstatusnikah]').val();
                   data.fpendidikan = $('[name=fpendidikan]').val();
                   data.fjabatan = $('[name=fjabatan]').val();
                   data.fstatus = $('[name=fstatus]').val();
                },
            },
            columns: [
                {data: 'DT_RowIndex', searchable: false, sortable: false},
                {data: 'nip'},
                {data: 'nama'},
                {data: 'ttl'},
                {data: 'jenis_kelamin_nama'},
                {data: 'pendidikan_nama'},
                {data: 'deptname'},
                {data: 'jabatan_nama'},
                {data: 'agama_nama'},
                {data: 'status_nikah_nama'},
                {data: 'no_hp'},
                {data: 'status_nama'},
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
        $('#nip').prop('readonly', false);
        $('#modal-form [name=nip]').focus();
    }

    function editForm(url) {
        $('.msgError').hide();
        $('#modal-form').modal('show');
        $('#modal-form .modal-title').text('Edit Data');

        $('#modal-form form')[0].reset();
        $('#modal-form form').attr('action', url);
        $('#modal-form [name=_method]').val('put');
        $('#nip').prop('readonly', true);
        $('#modal-form [name=pegawainame]').focus();

        $.get(url)
            .done((response) => {
                $('#modal-form [name=nip]').val(response.nip);
                $('#modal-form [name=nama]').val(response.nama);
                $('#modal-form [name=nik]').val(response.nik);
                $('#modal-form [name=tmp_lahir]').val(response.tmp_lahir);
                $('#modal-form [name=tgl_lahir]').val(response.tgl_lahir);
                $('#modal-form [name=tgl_lahir]').val(response.tgl_lahir);
                $('#modal-form [name=jenis_kelamin]').val(response.jenis_kelamin).trigger('change');
                $('#modal-form [name=deptcode]').val(response.deptcode).trigger('change');
                $('#modal-form [name=agama]').val(response.agama).trigger('change');
                $('#modal-form [name=status_nikah]').val(response.status_nikah).trigger('change');
                $('#modal-form [name=pendidikan]').val(response.pendidikan).trigger('change');
                $('#modal-form [name=jurusan]').val(response.jurusan).trigger('change');
                $('#modal-form [name=alamat_ktp]').val(response.alamat_ktp);
                $('#modal-form [name=alamat_domisili]').val(response.alamat_domisili);
                $('#modal-form [name=nama_istri_suami]').val(response.nama_istri_suami);
                $('#modal-form [name=nama_ayah]').val(response.nama_ayah);
                $('#modal-form [name=nama_ibu]').val(response.nama_ibu);
                $('#modal-form [name=jabatan]').val(response.jabatan).trigger('change');
                $('#modal-form [name=no_hp]').val(response.no_hp);
                $('#modal-form [name=email]').val(response.email);
                $('#modal-form [name=status]').val(response.status).trigger('change');
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

    function setFilter() {
        table.ajax.reload();
    }

    $(window).bind('resize load', function() {
        if ($(this).width() < 767) {
            $('.collapse').removeClass('in');
            $('.collapse').addClass('out');
        } else {
            $('.collapse').removeClass('out');
            $('.collapse').addClass('in');
        }
    });
</script>
@endpush