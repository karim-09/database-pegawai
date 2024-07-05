<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;
use Validator;
use DB;

class UserController extends Controller
{
    public function index()
    {
        $role = Role::select('id','rolename')->orderBy('rolename', 'asc')->get();
        return view('user.index', compact('role'));
    }

    public function data()
    {
        // $user = User::isNotAdmin()->orderBy('id', 'desc')->get();
        $user = DB::table('view_users')
                ->select('id','username','name','email','rolename')
                ->whereNull('deleted_at')
                ->orderBy('id', 'desc')
                ->get();

        return datatables()
            ->of($user)
            ->addIndexColumn()
            ->addColumn('aksi', function ($user) {
                return '
                    <button type="button" onclick="editForm(`'. route('user.update', $user->id) .'`)" class="btn btn-xs btn-info btn-flat"><i class="fa fa-pencil"></i></button>
                    <button type="button" onclick="deleteData(`'. route('user.destroy', $user->id) .'`)" class="btn btn-xs btn-danger btn-flat"><i class="fa fa-trash"></i></button>
                ';
            })
            ->rawColumns(['aksi'])
            ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = [
            'name' => 'required',
            'email' => 'required',
            'role_id' => 'required',
            'password' => 'required|confirmed|min:6',
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

        $cekDeleted = User::withTrashed()->find($request->deptemail);
        if($cekDeleted){
            $cekDeleted->name = $request->name;
            $cekDeleted->email = $request->email;
            $cekDeleted->role_id = $request->role_id;
            $cekDeleted->password = bcrypt($request->password);
            $cekDeleted->updated_by = null;
            $cekDeleted->updated_at = null;
            $cekDeleted->deleted_by = null;
            $cekDeleted->deleted_at = null;
            $cekDeleted->update();

            return response()->json(['status'=>true,'message'=>'Data berhasil disimpan']);
        }

        $cekEmail = User::where('email',$request->email)->first();
        if($cekEmail){
            return response()->json(['status'=>false,'message'=>'Email Sudah digunakan, silahkan gunakan email yang lain']);
        }

        $user = new User();
        $user->name = $request->name;
        $user->username = uniqid();
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->role_id = $request->role_id;
        $user->save();

        return response()->json(['status'=>true,'message'=>'Data berhasil disimpan']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = DB::table('view_users')->select('id','name','email','role_id')->where('id',$id)->first();

        return response()->json($user);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $user = User::find($id);
        $cekEmail = User::where('email',$request->email)->where('id','!=',$id)->first();
        if($cekEmail){
            return response()->json(['status'=>false,'message'=>'Email Sudah digunakan, silahkan gunakan email yang lain']);
        }
        $user->name = $request->name;
        $user->email = $request->email;
        $user->role_id = $request->role_id;
        if ($request->has('password') && $request->password != "") 
            $user->password = bcrypt($request->password);
        $user->update();

        return response()->json(['status'=>true,'message'=>'Data berhasil disimpan']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = User::find($id);
        $data->delete();

        return response()->json(['status'=>true,'message'=>'Data berhasil dihapus']);
    }

    public function profil()
    {
        $profil = auth()->user();
        return view('user.profil', compact('profil'));
    }

    public function updateProfil(Request $request)
    {
        $user = auth()->user();
        
        $user->name = $request->name;
        if ($request->has('password') && $request->password != "") {
            if (Hash::check($request->old_password, $user->password)) {
                if ($request->password == $request->password_confirmation) {
                    $user->password = bcrypt($request->password);
                } else {
                    return response()->json('Konfirmasi password tidak sesuai', 422);
                }
            } else {
                return response()->json('Password lama tidak sesuai', 422);
            }
        }

        if ($request->hasFile('foto')) {
            $file = $request->file('foto');
            $nama = 'foto-' . date('YmdHis') . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('/img/users'), $nama);

            $user->profile_photo_path = "/img/users/$nama";
        }

        $user->update();

        return response()->json($user, 200);
    }
}
