<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Dept;
use App\Models\Pegawai;
use Validator;
use DB;

class PegawaiController extends Controller
{
    public function index()
    {
        $deptList = Dept::orderBy('created_at','ASC')->get();
        return view('pegawai.index',compact('deptList'));
    }

    public function data(Request $request)
    {
    	//param filter
    	$fdept = $request->fdept;
    	$fagama = $request->fagama;
    	$fstatusnikah = $request->fstatusnikah;
    	$fpendidikan = $request->fpendidikan;
    	$fjabatan = $request->fjabatan;
    	$fstatus = $request->fstatus;

        $query = DB::table('view_pegawai')->select('nip', 'nama', 'tmp_lahir', 'tgl_lahir', 'jenis_kelamin_nama', 'deptname', 'no_hp', 'status', 'status_nama','pendidikan_nama','jabatan_nama','agama_nama','status_nikah_nama');

        if($fdept){
        	$query->where('deptcode',$fdept);
        }

        if($fagama){
        	$query->where('agama',$fagama);
        }

        if($fstatusnikah){
        	$query->where('status_nikah',$fstatusnikah);
        }

        if($fpendidikan){
        	$query->where('pendidikan',$fpendidikan);
        }

        if($fjabatan){
        	$query->where('jabatan',$fjabatan);
        }

        if($fstatus){
        	$query->where('status',$fstatus);
        }

        $getLists = $query->orderBy('nip', 'asc')->orderBy('created_at', 'desc')->get();

        return datatables()
            ->of($getLists)
            ->addIndexColumn()
            ->addColumn('status_nama', function ($getLists) {
                return statusHtml($getLists->status);
            })
            ->addColumn('ttl', function ($getLists) {
                return $getLists->tmp_lahir.', '.format_date($getLists->tgl_lahir);
            })
            ->addColumn('aksi', function ($getLists) {
                return '
                    <button onclick="editForm(`'. route('pegawai.update', $getLists->nip) .'`)" class="btn btn-xs btn-info btn-flat"><i class="fa fa-pencil"></i></button>
                    <button onclick="deleteData(`'. route('pegawai.destroy', $getLists->nip) .'`)" class="btn btn-xs btn-danger btn-flat"><i class="fa fa-trash"></i></button>
                ';
            })
            ->rawColumns(['status_nama','ttl','aksi'])
            ->make(true);
    }

    public function store(Request $request)
    {
        $rules = [
            'nip' => 'required',
            'nama' => 'required',
            'nik' => 'required',
            'tmp_lahir' => 'required',
            'tgl_lahir' => 'required',
            'jenis_kelamin' => 'required',
            'deptcode' => 'required',
            'agama' => 'required',
            'status_nikah' => 'required',
            'pendidikan' => 'required',
            'jabatan' => 'required',
            'no_hp' => 'required',
            'status' => 'required',
        ];
        $validator = Validator::make($request->all(), $rules);

        //check if validation fails
        if ($validator->fails()) {
            $msgNotif = implode(",",$validator->errors()->all());
	        return response()->json([
	            'status'  => false,
	            'message' => $msgNotif,
	        ]);
        }

        $cekDeleted = Pegawai::withTrashed()->find($request->nip);
        if($cekDeleted){
	        $cekDeleted->nip = $request->nip;
            $cekDeleted->nama = $request->nama;
	        $cekDeleted->nik = $request->nik;
	        $cekDeleted->tmp_lahir = $request->tmp_lahir;
	        $cekDeleted->tgl_lahir = $request->tgl_lahir;
	        $cekDeleted->jenis_kelamin = $request->jenis_kelamin;
	        $cekDeleted->deptcode = $request->deptcode;
	        $cekDeleted->agama = $request->agama;
	        $cekDeleted->status_nikah = $request->status_nikah;
	        $cekDeleted->pendidikan = $request->pendidikan;
	        $cekDeleted->jurusan = $request->jurusan;
	        $cekDeleted->alamat_ktp = $request->alamat_ktp;
	        $cekDeleted->alamat_domisili = $request->alamat_domisili;
	        $cekDeleted->nama_istri_suami = $request->nama_istri_suami;
	        $cekDeleted->nama_ayah = $request->nama_ayah;
	        $cekDeleted->nama_ibu = $request->nama_ibu;
	        $cekDeleted->tgl_masuk = $request->tgl_masuk;
	        $cekDeleted->jabatan = $request->jabatan;
	        $cekDeleted->no_hp = $request->no_hp;
	        $cekDeleted->email = $request->email;
	        $cekDeleted->status = $request->status;
	        $cekDeleted->tgl_masuk = date('Y-m-d');
	        $cekDeleted->updated_by = null;
	        $cekDeleted->updated_at = null;
	        $cekDeleted->deleted_by = null;
	        $cekDeleted->deleted_at = null;
	        $cekDeleted->update();

	        return response()->json(['status'=>true,'message'=>'Data berhasil disimpan']);
        }

        $cekCode = Pegawai::where('nip',$request->nip)->first();
        if($cekCode){
        	return response()->json(['status'=>false,'message'=>'NIP Sudah digunakan, silahkan gunakan NIP yang lain']);
        }

        $data = new Pegawai();
        $data->nip = $request->nip;
        $data->nama = $request->nama;
        $data->nik = $request->nik;
        $data->tmp_lahir = $request->tmp_lahir;
        $data->tgl_lahir = $request->tgl_lahir;
        $data->jenis_kelamin = $request->jenis_kelamin;
        $data->deptcode = $request->deptcode;
        $data->agama = $request->agama;
        $data->status_nikah = $request->status_nikah;
        $data->pendidikan = $request->pendidikan;
        $data->jurusan = $request->jurusan;
        $data->alamat_ktp = $request->alamat_ktp;
        $data->alamat_domisili = $request->alamat_domisili;
        $data->nama_istri_suami = $request->nama_istri_suami;
        $data->nama_ayah = $request->nama_ayah;
        $data->nama_ibu = $request->nama_ibu;
        $data->tgl_masuk = $request->tgl_masuk;
        $data->jabatan = $request->jabatan;
        $data->no_hp = $request->no_hp;
        $data->email = $request->email;
        $data->status = $request->status;
        $data->tgl_masuk = date('Y-m-d');
        $data->save();

        return response()->json(['status'=>true,'message'=>'Data berhasil disimpan']);
    }

    public function show($id)
    {
        $data = DB::table('view_pegawai')->where('nip',$id)->first();

        return response()->json($data);
    }

    public function update(Request $request, $id)
    {
        $data = Pegawai::find($id);
        $data->nama = $request->nama;
        $data->nik = $request->nik;
        $data->tmp_lahir = $request->tmp_lahir;
        $data->tgl_lahir = $request->tgl_lahir;
        $data->jenis_kelamin = $request->jenis_kelamin;
        $data->deptcode = $request->deptcode;
        $data->agama = $request->agama;
        $data->status_nikah = $request->status_nikah;
        $data->pendidikan = $request->pendidikan;
        $data->jurusan = $request->jurusan;
        $data->alamat_ktp = $request->alamat_ktp;
        $data->alamat_domisili = $request->alamat_domisili;
        $data->nama_istri_suami = $request->nama_istri_suami;
        $data->nama_ayah = $request->nama_ayah;
        $data->nama_ibu = $request->nama_ibu;
        $data->tgl_masuk = $request->tgl_masuk;
        $data->jabatan = $request->jabatan;
        $data->no_hp = $request->no_hp;
        $data->email = $request->email;
        $data->status = $request->status;
        $data->update();

        return response()->json(['status'=>true,'message'=>'Data berhasil disimpan']);
    }

    public function destroy($id)
    {
        $cekDt = false;
    	if( $cekDt ){
    		return response()->json(['status'=>false,'message'=>'Data digunakan tidak dapat dihapus']);
    	}

        $data = Pegawai::find($id);
        $data->delete();

        return response()->json(['status'=>true,'message'=>'Data berhasil dihapus']);
    }

    public function apiLists(Request $request)
    {
        $page = !empty($request->page)?$request->page:1;
        $search = !empty($request->search)?$request->search:null;
        $limit = !empty($request->limit)?$request->limit:10;
        $offside = ((int)$page>1) ? ((int)$page * $limit) - $limit : 0;

        $lists = [];
        $rows = [];
        $qLists = DB::table('view_pegawai');

        //search
        if(!empty($search)){
            $getLists = $qLists->where('nip','LIKE',"%{$search}%")
                    ->orWhere(function ($subquery) use ($search) {
                        $subquery->Orwhere('nama','LIKE',"%{$search}%");
                        $subquery->Orwhere('deptname','LIKE',"%{$search}%");
                        $subquery->Orwhere('agama_nama','LIKE',"%{$search}%");
                        $subquery->Orwhere('status_nikah_nama','LIKE',"%{$search}%");
                        $subquery->Orwhere('pendidikan_nama','LIKE',"%{$search}%");
                        $subquery->Orwhere('jabatan_nama','LIKE',"%{$search}%");
                    });
        }
        $getLists = $qLists->skip($offside)->take($limit)->orderBy('nip', 'asc')->orderBy('created_at', 'desc')->get();

        foreach ($getLists as $key => $value) {
            $rows[$key] = [
                'nip'                   => $value->nip,
                'nama'                  => $value->nama,
                'nik'                   => $value->nik,
                'tmp_lahir'             => $value->tmp_lahir,
                'tgl_lahir'             => $value->tgl_lahir,
                'jenis_kelamin_nama'    => $value->jenis_kelamin_nama,
                'deptname'              => $value->deptname,
                'agama_nama'            => $value->agama_nama,
                'status_nikah_nama'     => $value->status_nikah_nama,
                'pendidikan_nama'       => $value->pendidikan_nama,
                'jurusan'               => $value->jurusan,
                'alamat_ktp'            => $value->alamat_ktp,
                'alamat_domisili'       => $value->alamat_domisili,
                'nama_istri_suami'      => $value->nama_istri_suami,
                'nama_ayah'             => $value->nama_ayah,
                'nama_ibu'              => $value->nama_ibu,
                'tgl_masuk'             => $value->tgl_masuk,
                'jabatan_nama'          => $value->jabatan_nama,
                'no_hp'                 => $value->no_hp,
                'email'                 => $value->email,
                'status_nama'           => $value->status_nama,
                'created_at'            => $value->created_at,
            ];
        }

        //count
        $TotalAll = $qLists->count();

        $lists['rows'] = $rows;
        $lists['info']['page'] = (int)$page;
        $lists['info']['limit'] = (int)$limit;
        $lists['info']['total_data'] = (int)$TotalAll;
        
        $response = responseFormat(['status'=>200,'message'=>'Retrieve data success.','data'=>$lists]);
        return response()->json($response,200);
    }

    public function apiShow($id=null)
    {
        $lists = [];
        $getLists = DB::table('view_pegawai')->where('nip',$id)->first();
        if($getLists){
            $lists = [
                'nip'                   => $getLists->nip,
                'nama'                  => $getLists->nama,
                'nik'                   => $getLists->nik,
                'tmp_lahir'             => $getLists->tmp_lahir,
                'tgl_lahir'             => $getLists->tgl_lahir,
                'jenis_kelamin_nama'    => $getLists->jenis_kelamin_nama,
                'deptname'              => $getLists->deptname,
                'agama_nama'            => $getLists->agama_nama,
                'status_nikah_nama'     => $getLists->status_nikah_nama,
                'pendidikan_nama'       => $getLists->pendidikan_nama,
                'jurusan'               => $getLists->jurusan,
                'alamat_ktp'            => $getLists->alamat_ktp,
                'alamat_domisili'       => $getLists->alamat_domisili,
                'nama_istri_suami'      => $getLists->nama_istri_suami,
                'nama_ayah'             => $getLists->nama_ayah,
                'nama_ibu'              => $getLists->nama_ibu,
                'tgl_masuk'             => $getLists->tgl_masuk,
                'jabatan_nama'          => $getLists->jabatan_nama,
                'no_hp'                 => $getLists->no_hp,
                'email'                 => $getLists->email,
                'status_nama'           => $getLists->status_nama,
                'created_at'            => $getLists->created_at,
            ];
        }
        
        $response = responseFormat(['status'=>200,'message'=>'Retrieve data success.','data'=>$lists]);
        return response()->json($response,200);
    }
}
