<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Role;
use App\Models\Module;
use App\Models\User;
use Validator;

class RoleController extends Controller
{
    public function index()
    {
    	$module = Module::orderBy('modulesort','ASC')->get();
        return view('role.index', compact('module'));
    }

    public function data()
    {
        $getLists = Role::select('id','rolename','roledesk')->orderBy('id', 'desc')->get();

        return datatables()
            ->of($getLists)
            ->addIndexColumn()
            ->addColumn('aksi', function ($getLists) {
                return '
                    <button onclick="editForm(`'. route('role.update', $getLists->id) .'`)" class="btn btn-xs btn-info btn-flat"><i class="fa fa-pencil"></i></button>
                    <button onclick="deleteData(`'. route('role.destroy', $getLists->id) .'`)" class="btn btn-xs btn-danger btn-flat"><i class="fa fa-trash"></i></button>
                ';
            })
            ->rawColumns(['aksi'])
            ->make(true);
    }

    public function store(Request $request)
    {
        $rules = [
            'rolename' => 'required',
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

    	$mod = $request->mod ?? [];
    	array_push($mod, 'dashboard');

        $cekDeleted = Role::withTrashed()->find($request->deptcode);
        if($cekDeleted){
	        $cekDeleted->rolename = $request->rolename;
	        $cekDeleted->roledesk = $request->roledesk;
	        $cekDeleted->modulelists = json_encode($mod);
	        $cekDeleted->updated_by = null;
	        $cekDeleted->updated_at = null;
	        $cekDeleted->deleted_by = null;
	        $cekDeleted->deleted_at = null;
	        $cekDeleted->update();

	        return response()->json(['status'=>true,'message'=>'Data berhasil disimpan']);
        }

        $data = new Role();
        $data->rolename = $request->rolename;
        $data->roledesk = $request->roledesk;
        $data->modulelists = json_encode($mod);
        $data->save();

        return response()->json(['status'=>true,'message'=>'Data berhasil disimpan']);
    }

    public function show($id)
    {
    	$data = [];
        $getData = Role::select('id','rolename','roledesk','modulelists')->find($id);
        if($getData){
        	$data = [
        		'id' => $getData->id,
        		'rolename' => $getData->rolename,
        		'roledesk' => $getData->roledesk,
        		'modulelists' => json_decode($getData->modulelists,true),
        	];
        }

        return response()->json($data);
    }

    public function update(Request $request, $id)
    {
    	$mod = $request->mod ?? [];
    	array_push($mod, 'dashboard');

        $data = Role::find($id);
        $data->rolename = $request->rolename;
        $data->roledesk = $request->roledesk;
        $data->modulelists = json_encode($mod);
        $data->update();

        return response()->json(['status'=>true,'message'=>'Data berhasil disimpan']);
    }

    public function destroy($id)
    {
    	$cekUser = User::where('role_id',$id)->first();
    	if($cekUser){
    		return response()->json(['status'=>false,'message'=>'Data digunakan tidak dapat dihapus']);
    	}

        $data = Role::find($id);
        $data->delete();

        return response()->json(['status'=>true,'message'=>'Data berhasil dihapus']);
    }
}
