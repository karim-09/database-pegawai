<?php

function format_uang ($angka) {
    return number_format($angka, 0, ',', '.');
}

function terbilang ($angka) {
    $angka = abs($angka);
    $baca  = array('', 'satu', 'dua', 'tiga', 'empat', 'lima', 'enam', 'tujuh', 'delapan', 'sembilan', 'sepuluh', 'sebelas');
    $terbilang = '';

    if ($angka < 12) { // 0 - 11
        $terbilang = ' ' . $baca[$angka];
    } elseif ($angka < 20) { // 12 - 19
        $terbilang = terbilang($angka -10) . ' belas';
    } elseif ($angka < 100) { // 20 - 99
        $terbilang = terbilang($angka / 10) . ' puluh' . terbilang($angka % 10);
    } elseif ($angka < 200) { // 100 - 199
        $terbilang = ' seratus' . terbilang($angka -100);
    } elseif ($angka < 1000) { // 200 - 999
        $terbilang = terbilang($angka / 100) . ' ratus' . terbilang($angka % 100);
    } elseif ($angka < 2000) { // 1.000 - 1.999
        $terbilang = ' seribu' . terbilang($angka -1000);
    } elseif ($angka < 1000000) { // 2.000 - 999.999
        $terbilang = terbilang($angka / 1000) . ' ribu' . terbilang($angka % 1000);
    } elseif ($angka < 1000000000) { // 1000000 - 999.999.990
        $terbilang = terbilang($angka / 1000000) . ' juta' . terbilang($angka % 1000000);
    }

    return $terbilang;
}

function randomNumber($length = 6) {
    $str = "";
    $characters = array_merge(range('0','9'));
    $max = count($characters) - 1;
    for ($i = 0; $i < $length; $i++) {
        $rand = mt_rand(0, $max);
        $str .= $characters[$rand];
    }
    return $str;
}


function tanggal_indonesia($tgl, $tampil_hari = true)
{
    $nama_hari  = array(
        'Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jum\'at', 'Sabtu'
    );
    $nama_bulan = array(1 =>
        'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
    );

    $tahun   = substr($tgl, 0, 4);
    $bulan   = $nama_bulan[(int) substr($tgl, 5, 2)];
    $tanggal = substr($tgl, 8, 2);
    $text    = '';

    if ($tampil_hari) {
        $urutan_hari = date('w', mktime(0,0,0, substr($tgl, 5, 2), $tanggal, $tahun));
        $hari        = $nama_hari[$urutan_hari];
        $text       .= "$hari, $tanggal $bulan $tahun";
    } else {
        $text       .= "$tanggal $bulan $tahun";
    }
    
    return $text; 
}

function format_date($date = NULL, $format = "d/m/Y") {
    if(!empty($date) && $date != "0000-00-00"){
      $timestamp = strtotime($date);
      return date($format, $timestamp);
    }else{
      return '';
    }
}

function tambah_nol_didepan($value, $threshold = null)
{
    return sprintf("%0". $threshold . "s", $value);
}

function getModule($kode='')
{
    $data = [];
    $role_id = auth()->user()->role_id;
    $modLists = \App\Models\Role::find($role_id);
    if($modLists){
        $modulelists = json_decode($modLists->modulelists,true);
        $mod = \App\Models\Module::where('modulekode',$kode)->orderBy('modulesort','ASC')->first();
        if($mod && in_array($kode, $modulelists)){
            $data = [
                'modulekode'    => $mod->modulekode,
                'modulename'    => $mod->modulename,
                'moduledesk'    => $mod->moduledesk,
                'moduleurl'     => $mod->moduleurl,
                'moduleicon'    => $mod->moduleicon,
            ];
        }
    }

    return $data;
}

function getUser()
{
    $data = [];
    $id = auth()->user()->id ?? null;
    $getDetail = \DB::table('view_users')->find($id);
    if($getDetail){
        $foto = auth()->user()->profile_photo_url ?? '';
        $file = ltrim($getDetail->profile_photo_path, '/');
        if(file_exists($file)){
            $foto = url($getDetail->profile_photo_path);
        }
        $data = [
            'id'            => $getDetail->id,
            'name'          => $getDetail->name,
            'username'      => $getDetail->username,
            'email'         => $getDetail->email,
            'foto'          => $foto,
            'role_id'       => $getDetail->role_id,
            'rolename'      => $getDetail->rolename,
        ];
    }

    return $data;
}

function cekStok($prod = null)
{
    $cek = \DB::select('SELECT "hitung_stok_produk"('.$prod.')');
    return $cek[0]->hitung_stok_produk;
}

function cekStokByDate($prod=null, $tgl=null)
{
    if(empty($tgl)){
        $tgl = date('Y-m-d');
    }
    $cek = \DB::select("SELECT hitung_stok_produk_by_date(".$prod.",'".$tgl."')");
    return $cek[0]->hitung_stok_produk_by_date;
}

function statusHtml($sts=null,$html=true){
    $data = '';
    if($html){
        $cekNama = \App\Models\Ms_options::where('kode',$sts)->first()->nama ?? '';
        if($sts == 'A'){
            $data = '<span class="label label-success">'. $cekNama .'</span>';
        }
        if($sts == 'M'){
            $data = '<span class="label label-warning">'. $cekNama .'</span>';
        }
        if($sts == 'MD'){
            $data = '<span class="label label-info">'. $cekNama .'</span>';
        }
        if($sts == 'D'){
            $data = '<span class="label label-danger">'. $cekNama .'</span>';
        }
    }else{
        $data = $sts;
    }
    return $data;
}

function getOption($untuk=null)
{
    $data = [];
    $getData = \App\Models\Ms_options::select('kode','nama')->where('untuk',$untuk)->get();
    if($getData){
        $data = $getData;
    }

    return $data;
}

function getDept($kode_dept='ho') {
    $arrDept = _getArrDept($kode_dept);
    $res = \App\Models\Dept::
            select(
                "deptcode",
                "deptname",
                "deptperent"
            )
            ->whereIn('deptcode', $arrDept)
            ->orderBy("created_at","ASC")
            ->get();
    $data = array();
    foreach ($res as $set) {
        $data[] = array(
            'deptcode'=>$set->deptcode,
            'deptname'=>$set->deptname,
            'deptperent'=>$set->deptperent,
        );
    }

    $recursiveArray = _getListDept($data);
    $units = _getFlattenDownDept($recursiveArray);
    return $units;
}

function _getArrDept($kode_dept=null)
{
    $arrDept = [];
    array_push($arrDept, $kode_dept);

    $parents = \App\Models\Dept::select('deptcode')
    ->where('deptperent', $kode_dept)
    ->get();

    if (!empty($parents)) {

        foreach ($parents as $key => $value) {
            $kd = $value->deptcode;
            if (!in_array($kd, $arrDept)){
                array_push($arrDept, $kd);
            }

            $parents2 = \App\Models\Dept::select('deptcode')
            ->where('deptperent', $kd)
            ->get();
            if (!empty($parents2)) {
                foreach ($parents2 as $key => $val1) {
                    $kd1 = $val1->deptcode;
                    if (!in_array($kd1, $arrDept)){
                        array_push($arrDept, $kd1);
                    }
                }
            }

        }
    }
    return $arrDept;
}

function _getListDept($data)
{
    
    $elements = [];
    $tree = [];
    foreach ($data as &$element) {
        $element['children'] = [];
        $deptcode = $element['deptcode'];
        $deptperent = $element['deptperent'];
        $elements[$deptcode] =& $element;
        if (isset($elements[$deptperent])) { $elements[$deptperent]['children'][] =& $element; }
        else { $tree[] =& $element; }
    }
    return $tree;
}

function _getFlattenDownDept($data, $index=0) {
    $elements = [];
    foreach($data as $element) {
        $lv = 0;
        if(!empty($element['deptperent'])){
            $lv = $index;
        }
        $elements[] = array(
            'deptcode'=>$element['deptcode'],
            'deptname'=>str_repeat(" -", $index) . $element['deptname'],
            'deptperent'=>$element['deptperent'],
            'level'=> $lv,
        );
        if(!empty($element['children'])) $elements = array_merge($elements, _getFlattenDownDept($element['children'], $index+1));
    }
    return $elements;
}

function responseFormat(array $params)
{
    //untuk menseragmkan format respose api yg akan di konsume oleh programmer mobile
    $response = ['status'=>[
                                'success'=>$params['status'],
                                'message'=>$params['message'],
                           ]
                ];
    //tambahkan atrubut 'data' jika ada data
    if(isset($params['data'])){
        $response += ['data'=>$params['data']];
    }
    //tambahkan atrubut 'data' jika ada token yang akan di
    if(isset($params['token'])){
        $response += ['token'=>$params['token']];
    }

    return $response;
}   
