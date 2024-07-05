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
                        <label for="rolename" class="col-lg-2 col-lg-offset-1 control-label">Role</label>
                        <div class="col-lg-6">
                            <input type="text" name="rolename" id="rolename" maxlength="150" class="form-control" required>
                            <span class="help-block with-errors"></span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="roledesk" class="col-lg-2 col-lg-offset-1 control-label">Deskripsi</label>
                        <div class="col-lg-6">
                            <textarea name="roledesk" id="roledesk" class="form-control"></textarea>
                            <span class="help-block with-errors"></span>
                        </div>
                    </div>

                    <table class="table table-stiped table-bordered">
                        <thead>
                            <th class="text-center">
                                <div class="icheck-primary d-inline">
                                    <input type="checkbox" id='select-all'>
                                </div>
                            </th>
                            <th>Modul</th>
                            <th>Deskripsi</th>
                        </thead>
                        <tbody>
                            @foreach($module as $key => $row)
                            <tr>
                                <td align="center">
                                    <div class="icheck-primary d-inline">
                                        <input type="checkbox" class="module-item" name="mod[]" value="{{$row->modulekode}}" {{($row->modulekode == 'dashboard')?'checked disabled':''}}>
                                    </div>
                                </td>
                                <td>{{$row->modulename}}</td>
                                <td>{{$row->moduledesk}}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>

                </div>
                <div class="modal-footer">
                    <button class="btn btn-sm btn-flat btn-primary"><i class="fa fa-save"></i> Simpan</button>
                    <button type="button" class="btn btn-sm btn-flat btn-warning" data-dismiss="modal"><i class="fa fa-arrow-circle-left"></i> Batal</button>
                </div>
            </div>
        </form>
    </div>
</div>

@push('css')
<!-- iCheck for checkboxes and radio inputs -->
<link rel="stylesheet" href="{{ asset('/assets/plugins/iCheck/all.css') }}">
@endpush

@push('scripts')
<!-- iCheck 1.0.1 -->
<script src="{{ asset('assets/plugins/iCheck/icheck.min.js') }}"></script>
<script>
    $(function(){
        $('input[type="checkbox"].flat-red, input[type="radio"].flat-red').iCheck({
          checkboxClass: 'icheckbox_flat-green',
          radioClass   : 'iradio_flat-green'
        })

        $('#select-all').click(function(event) {   
            if(this.checked) {
              // Iterate each checkbox
              $(':checkbox').not("[disabled]").each(function() {
                this.checked = true;                        
              });
            }
            else {
              // Iterate each checkbox
              $(':checkbox').not("[disabled]").each(function() {
                this.checked = false;
              });
            }
        });
    })
</script>
@endpush