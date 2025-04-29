<?php
 
 namespace App\Http\Controllers;
 
 use App\Models\LevelModel;
 use Illuminate\Http\Request;
 use Illuminate\Support\Facades\DB;
 use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;

 class LevelController extends Controller
 {public function index()
    {
        $breadcrumb = (object) [
            'title' => 'Daftar Level',
            'list' => ['Home', 'Level'],
        ];
        $page = (object) [
            'title' => 'Daftar level yang terdaftar dalam sistem',
        ];
        $activeMenu = 'level';
        $level = LevelModel::all(); // ambil semua data level
 
         return view('level.index', ['breadcrumb' => $breadcrumb, 'activeMenu' => $activeMenu, 'page' => $page, 'level' => $level]);
     }
 
     // Ambil data level dalam bentuk json untuk datatables
     public function list(Request $request)
     {
         $levels = LevelModel::select('level_id', 'level_kode', 'level_name');
 
         if ($request->level_id) {
             $levels->where('level_id', $request->level_id);
         }
 
         return DataTables::of($levels)
             ->addIndexColumn() // menambahkan kolom index / no urut (default nama kolom: DT_RowIndex)
             ->addColumn('aksi', function ($level) { // menambahkan kolom aksi
                $btn  = '<button onclick="modalAction(\''.url('/level/' . $level->level_id . '/show_ajax').'\')" class="btn btn-info btn-sm">Detail</button> ';
                $btn .= '<button onclick="modalAction(\''.url('/level/' . $level->level_id . '/edit_ajax').'\')" class="btn btn-warning btn-sm">Edit</button> ';
                $btn .= '<button onclick="modalAction(\''.url('/level/' . $level->level_id . '/delete_ajax').'\')"  class="btn btn-danger btn-sm">Hapus</button> ';
                return $btn;
                 return $btn;
             })
             ->rawColumns(['aksi']) // memberitahu bahwa kolom aksi adalah html
             ->make(true);
     }
 
     // Menampilkan form tambah level
     public function create()
     {
         $breadcrumb = (object) [
             'title' => 'Tambah Level',
             'list' => ['Home', 'Level', 'Tambah'],
         ];
 
         $page = (object) [
             'title' => 'Tambah level baru',
         ];
 
         $activeMenu = 'level';
 
         return view('level.create', ['breadcrumb' => $breadcrumb, 'activeMenu' => $activeMenu, 'page' => $page]);
     }
 
     // Menyimpan data level baru
     public function store(Request $request)
     {
         $request->validate([
             'level_kode' => 'required|string|max:5',
             'level_name' => 'required|string|max:100'
         ]);
 
         LevelModel::create([
             'level_kode' => $request->level_kode,
             'level_name' => $request->level_name
         ]);
 
         return redirect('/level')->with('success', 'Data level berhasil ditambahkan');
     }
 
     // Menampilkan detail level
     public function show(string $id)
     {
         $level = LevelModel::find($id);
 
         $breadcrumb = (object) [
             'title' => 'Detail Level',
             'list' => ['Home', 'Level', 'Detail'],
         ];
 
         $page = (object) [
             'title' => 'Detail level',
         ];
 
         $activeMenu = 'level';
 
         return view('level.show', ['breadcrumb' => $breadcrumb, 'activeMenu' => $activeMenu, 'page' => $page, 'level' => $level]);
     }
 
     // Menampilkan form edit level
     public function edit(string $id)
     {
         $level = LevelModel::find($id);
 
         $breadcrumb = (object) [
             'title' => 'Edit Level',
             'list' => ['Home', 'Level', 'Edit'],
         ];
 
         $page = (object) [
             'title' => 'Edit level',
         ];
 
         $activeMenu = 'level';
 
         return view('level.edit', ['breadcrumb' => $breadcrumb, 'activeMenu' => $activeMenu, 'page' => $page, 'level' => $level]);
     }
 
     // Memperbarui data level
     public function update(Request $request, string $id)
     {
         $request->validate([
             'level_kode' => 'required|string|max:5',
             'level_name' => 'required|string|max:100'
         ]);
 
         LevelModel::find($id)->update([
             'level_kode' => $request->level_kode,
             'level_name' => $request->level_name
         ]);
 
         return redirect('/level')->with('success', 'Data level berhasil diubah');
     }
 
     // Menghapus data level
     public function destroy(string $id)
     {
         $check = LevelModel::find($id);
         if (!$check) {
             return redirect('/level')->with('error', 'Data level tidak ditemukan');
         }
 
         try {
             LevelModel::destroy($id);
             return redirect('/level')->with('success', 'Data level berhasil dihapus');
         } catch (\Illuminate\Database\QueryException $e) {
             return redirect('/level')->with('error', 'Data level gagal dihapus karena masih terdapat tabel lain yang terkait dengan data ini');
         }
     }

     public function create_ajax() {
        $level = LevelModel::select('level_kode', 'level_name')->get();
        return view('level.create_ajax')->with('level', $level);
    }
    
    public function store_ajax(Request $request){
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'level_kode' => 'required|string|max:5',
                'level_name' => 'required|string|max:100'
            ];
    
            $validator = Validator::make($request->all(), $rules);
    
            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validasi Gagal',
                    'msgField' => $validator->errors(),
                ]);
            }
    
            LevelModel::create($request->only(['level_kode', 'level_name']));
    
            return response()->json([
                'status' => true,
                'message' => 'Data Level berhasil disimpan'
            ]);
        }
    
        // Optional: bisa dihilangkan kalau hanya untuk ajax
        return response()->json([
            'status' => false,
            'message' => 'Request bukan AJAX',
        ]);
    }
    
    
    //Menampilkan halaman form edit user ajax
    public function edit_ajax(string $id){
        $level = LevelModel::find($id);
    
        if (!$level) {
            return response()->view('level.edit_ajax', ['level' => null]);
        }
    
        return view('level.edit_ajax', ['level' => $level]);
    }
    

    public function update_ajax(Request $request, $id)
    {
        // Pastikan permintaan berasal dari AJAX atau menginginkan JSON
        if ($request->ajax() || $request->wantsJson()) {
            // Validasi input
            $rules = [
                'level_kode' => 'required|string|max:5',
                'level_name' => 'required|string|max:100'
            ];

            $validator = Validator::make($request->all(), $rules);

            // Jika validasi gagal
            if ($validator->fails()) {
                return response()->json([
                    'status'   => false,
                    'message'  => 'Validasi gagal.',
                    'msgField' => $validator->errors()
                ]);
            }

            // Temukan data level berdasarkan ID
            $level = LevelModel::find($id);

            if ($level) {
                // Hanya update field yang divalidasi, bukan semua input
                $dataUpdate = $request->only(['level_kode', 'level_name']);

                // Update data
                $level->update($dataUpdate);

                return response()->json([
                    'status'  => true,
                    'message' => 'Data berhasil diupdate.'
                ]);
            } else {
                return response()->json([
                    'status'  => false,
                    'message' => 'Data tidak ditemukan.'
                ]);
            }
        }

    // Jika bukan permintaan AJAX, redirect ke home
    return redirect('/');
    }

    public function confirm_ajax(string $id)
    {
        $level = LevelModel::find($id);

        return view('level.confirm_ajax', ['level' => $level]);
    }

    public function delete_ajax(Request $request, $id)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $level = LevelModel::find($id);
            if ($level) {
                $level->delete();
                return response()->json([
                    'status' => true,
                    'message' => 'Data berhasil dihapus'
                ]);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'Data tidak ditemukan'
                ]);
            }
        }

        return redirect('/');
    }

}