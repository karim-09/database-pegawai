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
                        <label for="deptcode" class="col-lg-2 col-lg-offset-1 control-label">Kode</label>
                        <div class="col-lg-6">
                            <input type="text" name="deptcode" id="deptcode" maxlength="50" class="form-control" required>
                            <span class="help-block with-errors"></span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="deptname" class="col-lg-2 col-lg-offset-1 control-label">Departemen</label>
                        <div class="col-lg-6">
                            <input type="text" name="deptname" id="deptname" maxlength="150" class="form-control" required>
                            <span class="help-block with-errors"></span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="deptperent" class="col-lg-2 col-lg-offset-1 control-label">Perent</label>
                        <div class="col-lg-6">
                            <select name="deptperent" id="deptperent" class="form-control select2" style="width: 100%;">
                                <option value="" hidden selected>Pilih Perent</option>
                                @foreach($deptList as $key => $row)
                                <option value="{{ $row->deptcode }}">{{ $row->deptcode.' - '.$row->deptname }}</option>
                                @endforeach
                            </select>
                            <span class="help-block with-errors"></span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="deptemail" class="col-lg-2 col-lg-offset-1 control-label">Email</label>
                        <div class="col-lg-6">
                            <input type="email" name="deptemail" id="deptemail" maxlength="150" class="form-control" required>
                            <span class="help-block with-errors"></span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="depttelp" class="col-lg-2 col-lg-offset-1 control-label">Telp</label>
                        <div class="col-lg-6">
                            <input type="text" name="depttelp" id="depttelp" maxlength="20" pattern=".{9,}" title="9 chars minimum" minlength="9" oninput="this.value = this.value.replace(/[^0-9]/g, '').replace(/(\..*?)\..*/g, '$1');" class="form-control" required>
                            <span class="help-block with-errors"></span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="deptaddress" class="col-lg-2 col-lg-offset-1 control-label">Alamat</label>
                        <div class="col-lg-6">
                            <textarea name="deptaddress" id="deptaddress" class="form-control"></textarea>
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