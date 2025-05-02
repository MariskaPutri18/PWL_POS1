<?php
  
  namespace App\Http\Controllers;
  
  use App\Models\SupplierModel;
  use Illuminate\Http\Request;
  use Yajra\DataTables\Facades\DataTables;
  use Illuminate\Support\Facades\Validator;
  
  class SupplierController extends Controller
  {
      public function index()
      {
          $breadcrumb = (object) [
              'title' => 'Daftar Supplier',
              'list' => ['Home', 'Supplier'],
          ];
  
          $page = (object) [
              'title' => 'Daftar supplier yang terdaftar dalam sistem',
          ];
  
          $activeMenu = 'supplier';
  
          $supplier = SupplierModel::all();
  
          return view('supplier.index', ['breadcrumb' => $breadcrumb, 'activeMenu' => $activeMenu, 'page' => $page, 'supplier' => $supplier]);
      }
  
      public function list(Request $request)
      {
          $supplier = SupplierModel::select('supplier_id', 'supplier_kode', 'supplier_nama', 'supplier_alamat');
  
          if ($request->supplier_id) {
              $supplier->where('supplier_id', $request->supplier_id);
          }
  
          return DataTables::of($supplier)
              ->addIndexColumn()
              ->addColumn('aksi', function ($supplier) {
                $btn  = '<button onclick="modalAction(\''.url('/supplier/' . $supplier->supplier_id . '/show_ajax').'\')" class="btn btn-info btn-sm">Detail</button> ';
                $btn .= '<button onclick="modalAction(\''.url('/supplier/' . $supplier->supplier_id . '/edit_ajax').'\')" class="btn btn-warning btn-sm">Edit</button> ';
                $btn .= '<button onclick="modalAction(\''.url('/supplier/' . $supplier->supplier_id . '/delete_ajax').'\')"  class="btn btn-danger btn-sm">Hapus</button> ';
                 return $btn;
              })
              ->rawColumns(['aksi'])
              ->make(true);
      }
  
      public function create()
      {
          $breadcrumb = (object) [
              'title' => 'Tambah Supplier',
              'list' => ['Home', 'Supplier', 'Tambah'],
          ];
  
          $page = (object) [
              'title' => 'Tambah supplier baru',
          ];
  
          $activeMenu = 'supplier';
  
          return view('supplier.create', ['breadcrumb' => $breadcrumb, 'activeMenu' => $activeMenu, 'page' => $page]);
      }
  
      public function store(Request $request)
      {
          $request->validate([
              'supplier_kode' => 'required|string|max:10',
              'supplier_nama' => 'required|string|max:100',
              'supplier_alamat' => 'required|string|max:100',
          ]);
  
          SupplierModel::create([
              'supplier_kode' => $request->supplier_kode,
              'supplier_nama' => $request->supplier_nama,
              'supplier_alamat' => $request->supplier_alamat
          ]);
  
          return redirect('/supplier')->with('success', 'Data supplier berhasil ditambahkan');
      }
  
      public function show(string $id)
      {
          $supplier = SupplierModel::find($id);
  
          $breadcrumb = (object) [
              'title' => 'Detail Supplier',
              'list' => ['Home', 'Supplier', 'Detail'],
          ];
          $page = (object) [
              'title' => 'Detail Supplier',
          ];
  
          $activeMenu = 'supplier';
  
          return view('supplier.show', ['breadcrumb' => $breadcrumb, 'page' => $page, 'activeMenu' => $activeMenu, 'supplier' => $supplier]);
      }
  
      public function edit(string $id)
      {
          $supplier = SupplierModel::find($id);
          $breadcrumb = (object) [
              'title' => 'Edit Supplier',
              'list' => ['Home', 'Supplier', 'Edit']
          ];
  
          $page = (object) [
              'title' => 'Edit Supplier',
          ];
  
          $activeMenu = 'supplier';
  
          return view('supplier.edit', ['breadcrumb' => $breadcrumb, 'activeMenu' => $activeMenu, 'page' => $page, 'supplier' => $supplier]);
      }
  
      public function update(Request $request, string $id)
      {
          $request->validate([
              'supplier_kode' => 'required|string|max:10',
              'supplier_nama' => 'required|string|max:100',
              'supplier_alamat' => 'required'
          ]);
  
          SupplierModel::find($id)->update([
              'supplier_kode' => $request->supplier_kode,
              'supplier_nama' => $request->supplier_nama,
              'supplier_alamat' => $request->supplier_alamat
          ]);
  
          return redirect('/supplier')->with('success', 'Data supplier berhasil diubah');
      }
  
      public function destroy(string $id)
      {
          $check = SupplierModel::find($id);
  
          if (!$check) {
              return redirect('/supplier')->with('error', 'Data supplier tidak ditemukan');
          }
  
          try {
              SupplierModel::destroy($id);
              return redirect('/supplier')->with('success', 'Data supplier berhasil dihapus');
          } catch (\Illuminate\Database\QueryException $e) {
              return redirect('/supplier')->with('error', 'Data supplier gagal dihapus karena masih terdapat tabel lain yang terkait dengan data ini');
          }
      }

      public function create_ajax() {
        $supplier = SupplierModel::select('supplier_id', 'supplier_kode', 'supplier_nama', 'supplier_alamat')->get();
        return view('supplier.create_ajax')->with('supplier', $supplier);
    }

    public function store_ajax(Request $request){
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'supplier_kode' => 'required|string|max:10',
                'supplier_nama' => 'required|string|max:100',
                'supplier_alamat' => 'required'
            ];
    
            $validator = Validator::make($request->all(), $rules);
    
            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validasi Gagal',
                    'msgField' => $validator->errors(),
                ]);
            }
    
            SupplierModel::create($request->only(['supplier_kode', 'supplier_nama', 'supplier_alamat']));
    
            return response()->json([
                'status' => true,
                'message' => 'Data SUpplier berhasil disimpan'
            ]);
        }
    
        // Optional: bisa dihilangkan kalau hanya untuk ajax
        return response()->json([
            'status' => false,
            'message' => 'Request bukan AJAX',
        ]);
    }

    public function edit_ajax(string $id){
        $supplier = SupplierModel::find($id);
    
        if (!$supplier) {
            return response()->view('supplier.edit_ajax', ['supplier' => null]);
        }
    
        return view('supplier.edit_ajax', ['supplier' => $supplier]);
    }

    public function update_ajax(Request $request, $id)
    {
        // Pastikan permintaan berasal dari AJAX atau menginginkan JSON
        if ($request->ajax() || $request->wantsJson()) {
            // Validasi input
            $rules = [
                'supplier_kode' => 'required|string|max:5',
                'supplier_nama' => 'required|string|max:100',
                'supplier_alamat' => 'required'
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

            // Temukan data supplier berdasarkan ID
            $supplier = SupplierModel::find($id);

            if ($supplier) {
                // Hanya update field yang divalidasi, bukan semua input
                $dataUpdate = $request->only(['supplier_kode', 'supplier_nama']);

                // Update data
                $supplier->update($dataUpdate);

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
        $supplier = SupplierModel::find($id);

        return view('supplier.confirm_ajax', ['supplier' => $supplier]);
    }

    public function delete_ajax(Request $request, $id)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $supplier = SupplierModel::find($id);
            if ($supplier) {
                $supplier->delete();
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