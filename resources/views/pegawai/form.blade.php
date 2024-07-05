<div class="modal fade" id="modal-form" tabindex="-1" role="dialog" aria-labelledby="modal-form" data-backdrop="static">
    <div class="modal-dialog modal-lg" role="document">
        <form action="" method="post" class="form-horizontal" autocomplete="off">
            @csrf
            @method('post')

            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title"></h4>
                </div>
                <div class="modal-body">
                    <div class="alert alert-danger alert-dismissible msgError" style="display: none;">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        <span id="msgError"></span>
                    </div>

                    <div class="form-group row">
                        <label for="nip" class="col-lg-2 col-lg-offset-1 control-label">NIP</label>
                        <div class="col-lg-6">
                            <input type="text" name="nip" id="nip" maxlength="20" class="form-control" required>
                            <span class="help-block with-errors"></span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="nama" class="col-lg-2 col-lg-offset-1 control-label">Nama Lengkap</label>
                        <div class="col-lg-6">
                            <input type="text" name="nama" id="nama" maxlength="100" class="form-control" required>
                            <span class="help-block with-errors"></span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="nik" class="col-lg-2 col-lg-offset-1 control-label">NIK</label>
                        <div class="col-lg-6">
                            <input type="text" name="nik" id="nik" maxlength="16" pattern=".{16,}" title="16 chars minimum" minlength="16" oninput="this.value = this.value.replace(/[^0-9]/g, '').replace(/(\..*?)\..*/g, '$1');" class="form-control" required>
                            <span class="help-block with-errors"></span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="tmp_lahir" class="col-lg-2 col-lg-offset-1 control-label">Tempat Lahir</label>
                        <div class="col-lg-6">
                            <input type="text" name="tmp_lahir" id="tmp_lahir" maxlength="60" class="form-control" required>
                            <span class="help-block with-errors"></span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="tgl_lahir" class="col-lg-2 col-lg-offset-1 control-label">Tanggal Lahir</label>
                        <div class="col-lg-6">
                            <input type="text" name="tgl_lahir" id="tgl_lahir" value="01/01/2000" maxlength="60" class="form-control datepicker" required>
                            <span class="help-block with-errors"></span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="jenis_kelamin" class="col-lg-2 col-lg-offset-1 control-label">Jenis Kelamin</label>
                        <div class="col-lg-6">
                            <select name="jenis_kelamin" id="jenis_kelamin" class="form-control select2" style="width: 100%;" required>
                                <!-- <option value="" hidden selected>--Pilih--</option> -->
                                @foreach(getOption('jeniskelamin') as $key => $row)
                                <option value="{{ $row->kode }}">{{ $row->nama }}</option>
                                @endforeach
                            </select>
                            <span class="help-block with-errors"></span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="deptcode" class="col-lg-2 col-lg-offset-1 control-label">Departemen</label>
                        <div class="col-lg-6">
                            <select name="deptcode" id="deptcode" class="form-control select2" style="width: 100%;" required>
                                <option value="" hidden selected>--Pilih--</option>
                                @foreach(getDept() as $key => $row)
                                <option value="{{ $row['deptcode'] }}" class="{{($row['deptperent'] > 0)?'ml-2':''}}">{{ $row['deptname'] }}</option>
                                @endforeach
                            </select>
                            <span class="help-block with-errors"></span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="agama" class="col-lg-2 col-lg-offset-1 control-label">Agama</label>
                        <div class="col-lg-6">
                            <select name="agama" id="agama" class="form-control select2" style="width: 100%;" required>
                                <option value="" hidden selected>--Pilih--</option>
                                @foreach(getOption('agama') as $key => $row)
                                <option value="{{ $row->kode }}">{{ $row->nama }}</option>
                                @endforeach
                            </select>
                            <span class="help-block with-errors"></span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="status_nikah" class="col-lg-2 col-lg-offset-1 control-label">Status Nikah</label>
                        <div class="col-lg-6">
                            <select name="status_nikah" id="status_nikah" class="form-control select2" style="width: 100%;" required>
                                <option value="" hidden selected>--Pilih--</option>
                                @foreach(getOption('statusnikah') as $key => $row)
                                <option value="{{ $row->kode }}">{{ $row->nama }}</option>
                                @endforeach
                            </select>
                            <span class="help-block with-errors"></span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="pendidikan" class="col-lg-2 col-lg-offset-1 control-label">Pendidikan</label>
                        <div class="col-lg-6">
                            <select name="pendidikan" id="pendidikan" class="form-control select2" style="width: 100%;" required>
                                <option value="" hidden selected>--Pilih--</option>
                                @foreach(getOption('pendidikan') as $key => $row)
                                <option value="{{ $row->kode }}">{{ $row->nama }}</option>
                                @endforeach
                            </select>
                            <span class="help-block with-errors"></span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="jurusan" class="col-lg-2 col-lg-offset-1 control-label">Jurusan</label>
                        <div class="col-lg-6">
                            <input type="text" name="jurusan" id="jurusan" maxlength="100" class="form-control">
                            <span class="help-block with-errors"></span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="alamat_ktp" class="col-lg-2 col-lg-offset-1 control-label">Alamat KTP</label>
                        <div class="col-lg-6">
                            <textarea name="alamat_ktp" id="alamat_ktp" maxlength="255" class="form-control"></textarea>
                            <span class="help-block with-errors"></span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="alamat_domisili" class="col-lg-2 col-lg-offset-1 control-label">Alamat Domisili</label>
                        <div class="col-lg-6">
                            <textarea name="alamat_domisili" id="alamat_domisili" maxlength="255" class="form-control"></textarea>
                            <span class="help-block with-errors"></span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="nama_istri_suami" class="col-lg-2 col-lg-offset-1 control-label">Nama Istri/Suami</label>
                        <div class="col-lg-6">
                            <input type="text" name="nama_istri_suami" id="nama_istri_suami" maxlength="100" class="form-control">
                            <span class="help-block with-errors"></span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="nama_ayah" class="col-lg-2 col-lg-offset-1 control-label">Nama Ayah</label>
                        <div class="col-lg-6">
                            <input type="text" name="nama_ayah" id="nama_ayah" maxlength="100" class="form-control">
                            <span class="help-block with-errors"></span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="nama_ibu" class="col-lg-2 col-lg-offset-1 control-label">Nama Ibu</label>
                        <div class="col-lg-6">
                            <input type="text" name="nama_ibu" id="nama_ibu" maxlength="100" class="form-control">
                            <span class="help-block with-errors"></span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="jabatan" class="col-lg-2 col-lg-offset-1 control-label">Jabatan</label>
                        <div class="col-lg-6">
                            <select name="jabatan" id="jabatan" class="form-control select2" style="width: 100%;" required>
                                <option value="" hidden selected>--Pilih--</option>
                                @foreach(getOption('jabatan') as $key => $row)
                                <option value="{{ $row->kode }}">{{ $row->nama }}</option>
                                @endforeach
                            </select>
                            <span class="help-block with-errors"></span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="no_hp" class="col-lg-2 col-lg-offset-1 control-label">Telp</label>
                        <div class="col-lg-6">
                            <input type="text" name="no_hp" id="no_hp" maxlength="16" pattern=".{9,}" title="9 chars minimum" minlength="9" oninput="this.value = this.value.replace(/[^0-9]/g, '').replace(/(\..*?)\..*/g, '$1');" class="form-control" required>
                            <span class="help-block with-errors"></span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="email" class="col-lg-2 col-lg-offset-1 control-label">Email</label>
                        <div class="col-lg-6">
                            <input type="email" name="email" id="email" maxlength="150" class="form-control">
                            <span class="help-block with-errors"></span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="status" class="col-lg-2 col-lg-offset-1 control-label">Status</label>
                        <div class="col-lg-6">
                            <select name="status" id="status" class="form-control select2" style="width: 100%;" required>
                                <!-- <option value="" hidden selected>--Pilih--</option> -->
                                @foreach(getOption('statuspegawai') as $key => $row)
                                <option value="{{ $row->kode }}">{{ $row->nama }}</option>
                                @endforeach
                            </select>
                            <span class="help-block with-errors"></span>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-sm btn-flat btn-primary"><i class="fa fa-save"></i> Simpan</button>
                    <button type="button" class="btn btn-sm btn-flat btn-warning" data-dismiss="modal"><i class="fa fa-arrow-circle-left"></i> Batal</button>
                </div>
            </div>
        </form>
    </div>
</div>