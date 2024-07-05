<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Dept;
use App\Models\Pegawai;
use Validator;

class DeptController extends Controller
{
    public function index()
    {
        $deptList = Dept::orderBy('created_at','ASC')->get();
        return view('dept.index',compact('deptList'));
    }

    public function data()
    {
        $getLists = Dept::select('depts.deptcode','depts.deptperent','d.deptname as deptperentnama','depts.deptname','depts.deptemail','depts.depttelp','depts.deptaddress')
                    ->leftJoin('depts as d','depts.deptperent','=','d.deptcode')
                    ->orderBy('depts.created_at', 'desc')->get();

        return datatables()
            ->of($getLists)
            ->addIndexColumn()
            ->addColumn('aksi', function ($getLists) {
                return '
                    <button onclick="editForm(`'. route('dept.update', $getLists->deptcode) .'`)" class="btn btn-xs btn-info btn-flat"><i class="fa fa-pencil"></i></button>
                    <button onclick="deleteData(`'. route('dept.destroy', $getLists->deptcode) .'`)" class="btn btn-xs btn-danger btn-flat"><i class="fa fa-trash"></i></button>
                ';
            })
            ->rawColumns(['aksi'])
            ->make(true);
    }

    public function store(Request $request)
    {
        $rules = [
            'deptcode' => 'required',
            'deptname' => 'required',
            'deptemail' => 'required',
            'depttelp' => 'required',
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

        $cekDeleted = Dept::withTrashed()->find($request->deptcode);
        if($cekDeleted){
	        $cekDeleted->deptname = $request->deptname;
            $cekDeleted->deptperent = $request->deptperent ?? null;
	        $cekDeleted->deptemail = $request->deptemail;
	        $cekDeleted->depttelp = $request->depttelp;
	        $cekDeleted->deptaddress = $request->deptaddress;
	        $cekDeleted->updated_by = null;
	        $cekDeleted->updated_at = null;
	        $cekDeleted->deleted_by = null;
	        $cekDeleted->deleted_at = null;
	        $cekDeleted->update();

	        return response()->json(['status'=>true,'message'=>'Data berhasil disimpan']);
        }

        $cekCode = Dept::where('deptcode',$request->deptcode)->first();
        if($cekCode){
        	return response()->json(['status'=>false,'message'=>'Kode Sudah digunakan, silahkan gunakan kode yang lain']);
        }

        $cekEmail = Dept::where('deptemail',$request->deptemail)->first();
        if($cekEmail){
        	return response()->json(['status'=>false,'message'=>'Email Sudah digunakan, silahkan gunakan email yang lain']);
        }

        $data = new Dept();
        $data->deptcode = $request->deptcode;
        $data->deptperent = $request->deptperent ?? null;
        $data->deptname = $request->deptname;
        $data->deptemail = $request->deptemail;
        $data->depttelp = $request->depttelp;
        $data->deptaddress = $request->deptaddress;
        $data->save();

        return response()->json(['status'=>true,'message'=>'Data berhasil disimpan']);
    }

    public function show($id)
    {
        $data = Dept::select('deptcode','deptperent','deptname','deptemail','depttelp','deptaddress')->find($id);

        return response()->json($data);
    }

    public function update(Request $request, $id)
    {
        $data = Dept::find($id);
        $cekEmail = Dept::where('deptemail',$request->deptemail)->where('deptcode','!=',$id)->first();
        if($cekEmail){
        	return response()->json(['status'=>false,'message'=>'Email Sudah digunakan, silahkan gunakan email yang lain']);
        }

        $data->deptperent = $request->deptperent ?? null;
        $data->deptname = $request->deptname;
        $data->deptemail = $request->deptemail;
        $data->depttelp = $request->depttelp;
        $data->deptaddress = $request->deptaddress;
        $data->update();

        return response()->json(['status'=>true,'message'=>'Data berhasil disimpan']);
    }

    public function destroy($id)
    {
        $cekDt = Pegawai::where('deptcode',$id)->first();
    	if( $cekDt ){
    		return response()->json(['status'=>false,'message'=>'Data digunakan tidak dapat dihapus']);
    	}

        $data = Dept::find($id);
        $data->delete();

        return response()->json(['status'=>true,'message'=>'Data berhasil dihapus']);
    }
}
