<?php

namespace App\Http\Controllers;
 
 use App\Models\KategoriModel;
 use Illuminate\Http\Request;
 use Illuminate\Support\Facades\DB;
 use Yajra\DataTables\Facades\DataTables;
 use Illuminate\Support\Facades\Validator;
 class KategoriController extends Controller
 { public function index()
    {
        $breadcrumb = (object) [
            'title' => 'Daftar Kategori',
            'list' => ['Home', 'Kategori'],
        ];
        $page = (object) [
            'title' => 'Daftar kategori yang terdaftar dalam sistem',
        ];

        $activeMenu = 'kategori';

        $kategori = KategoriModel::all();

        return view('kategori.index', ['breadcrumb' => $breadcrumb, 'activeMenu' => $activeMenu, 'page' => $page, 'kategori' => $kategori]);
    }
// Ambil data kategori dalam bentuk json untuk datatables
public function list(Request $request)
{
    $kategori = KategoriModel::select('kategori_id', 'kategori_kode', 'kategori_nama');

    if ($request->kategori_id) {
        $kategori->where('kategori_id', $request->kategori_id);
    }

    return DataTables::of($kategori)
        // menambahkan kolom index
        ->addIndexColumn()
        ->addColumn('aksi', function ($kategori) {
            $btn  = '<button onclick="modalAction(\''.url('/kategori/' . $kategori->kategori_id . '/show_ajax').'\')" class="btn btn-info btn-sm">Detail</button> ';
            $btn .= '<button onclick="modalAction(\''.url('/kategori/' . $kategori->kategori_id . '/edit_ajax').'\')" class="btn btn-warning btn-sm">Edit</button> ';
            $btn .= '<button onclick="modalAction(\''.url('/kategori/' . $kategori->kategori_id . '/delete_ajax').'\')"  class="btn btn-danger btn-sm">Hapus</button> ';
            return $btn;
        })
        ->rawColumns(['aksi'])
        ->make(true);
}
// menampilkan halaman form tambah kategori
public function create()
{
    $breadcrumb = (object) [
        'title' => 'Tambah Kategori',
        'list' => ['Home', 'Kategori', 'Tambah'],
    ];

    $page = (object) [
        'title' => 'Tambah kategori baru',
    ];

    $activeMenu = 'kategori';

    return view('kategori.create', ['breadcrumb' => $breadcrumb, 'activeMenu' => $activeMenu, 'page' => $page]);
}
// menyimpan data kategori baru
public function store(Request $request)
{
    $request->validate([
        'kategori_kode' => 'required|string|max:5',
        'kategori_nama' => 'required|string|max:100',
    ]);

    KategoriModel::create([
        'kategori_kode' => $request->kategori_kode,
        'kategori_nama' => $request->kategori_nama
    ]);

    return redirect('/kategori')->with('success', 'Data kategori berhasil ditambahkan');
}
// menampilkan halaman detail kategori
public function show(string $id)
{
    $kategori = KategoriModel::find($id);

    $breadcrumb = (object) [
        'title' => 'Detail Kategori',
        'list' => ['Home', 'Kategori', 'Detail'],
    ];

    $page = (object) [
        'title' => 'Detail kategori',
    ];

    $activeMenu = 'kategori';

    return view('kategori.show', ['breadcrumb' => $breadcrumb, 'activeMenu' => $activeMenu, 'page' => $page, 'kategori' => $kategori]);
}
// menampilkan halaman form edit kategori
public function edit(string $id)
{
    $kategori = KategoriModel::find($id);

    $breadcrumb = (object) [
        'title' => 'Edit Kategori',
        'list' => ['Home', 'Kategori', 'Edit'],
    ];

    $page = (object) [
        'title' => 'Edit kategori',
    ];

    $activeMenu = 'kategori';

    return view('kategori.edit', ['breadcrumb' => $breadcrumb, 'activeMenu' => $activeMenu, 'page' => $page, 'kategori' => $kategori]);
}

// mengubah data kategori
public function update(Request $request, string $id)
{
    $request->validate([
        'kategori_kode' => 'required|string|max:5',
        'kategori_nama' => 'required|string|max:100'
    ]);

    KategoriModel::find($id)->update([
        'kategori_kode' => $request->kategori_kode,
        'kategori_nama' => $request->kategori_nama
    ]);

    return redirect('/kategori')->with('success', 'Data kategori berhasil diubah');
}

    // menghapus data kategori
    public function destroy(string $id)
    {
        $check = KategoriModel::find($id);
        if (!$check) {
            return redirect('/kategori')->with('error', 'Data kategori tidak ditemukan');
        }
        try {
            KategoriModel::destroy($id);
            return redirect('/kategori')->with('success', 'Data kategori berhasil dihapus');
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect('/kategori')->with('error', 'Data kategori gagal dihapus karena masih terdapat tabel lain yang terkait dengan data ini');
        }
    }
    
    public function create_ajax() {
        $kategori = KategoriModel::select('kategori_kode', 'kategori_nama')->get();
        return view('kategori.create_ajax')->with('kategori', $kategori);
    }

    public function store_ajax(Request $request){
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'kategori_kode' => 'required|string|max:5',
                'kategori_nama' => 'required|string|max:100'
            ];
    
            $validator = Validator::make($request->all(), $rules);
    
            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validasi Gagal',
                    'msgField' => $validator->errors(),
                ]);
            }
    
            KategoriModel::create($request->only(['kategori_kode', 'kategori_nama']));
    
            return response()->json([
                'status' => true,
                'message' => 'Data Kategori berhasil disimpan'
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
        $kategori = KategoriModel::find($id);
    
        if (!$kategori) {
            return response()->view('kategori.edit_ajax', ['ketegori' => null]);
        }
    
        return view('kategori.edit_ajax', ['kategori' => $kategori]);
    }

    public function update_ajax(Request $request, $id)
    {
        // Pastikan permintaan berasal dari AJAX atau menginginkan JSON
        if ($request->ajax() || $request->wantsJson()) {
            // Validasi input
            $rules = [
                'kategori_kode' => 'required|string|max:5',
                'kategori_nama' => 'required|string|max:100'
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

            // Temukan data kategori berdasarkan ID
            $kategori = KategoriModel::find($id);

            if ($kategori) {
                // Hanya update field yang divalidasi, bukan semua input
                $dataUpdate = $request->only(['kategori_kode', 'kategori_nama']);

                // Update data
                $kategori->update($dataUpdate);

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

    }

    public function confirm_ajax(string $id)
    {
        $kategori = KategoriModel::find($id);

        return view('kategori.confirm_ajax', ['kategori' => $kategori]);
    }

    public function delete_ajax(Request $request, $id)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $kategori = KategoriModel::find($id);
            if ($kategori) {
                $kategori->delete();
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