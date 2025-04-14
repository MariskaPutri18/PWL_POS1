@extends('layouts.template') 
 
@section('content') 
<div class="card card-outline card-primary"> 
  <div class="card-header"> 
    <h3 class="card-title">{{ $page->title }}</h3> 
    <div class="card-tools"> 
      <a class="btn btn-sm btn-primary mt-1" href="{{ url('user/create') }}">Tambah</a> 
    </div> 
  </div> 
  <div class="card-body"> 
    @if (session('success'))
      <div class="alert alert-success">{{session('success')}} </div>
    @endif
    @if (session('error'))
      <div class="alert alert-danger">{{session('error')}}</div>      
    @endif
    <table class="table table-bordered table-striped table-hover table-sm" id="table_user">
      <thead> 
        <tr>
          <th>ID</th>
          <th>Username</th>
          <th>Nama</th>
          <th>Level Pengguna</th>
          <th>Aksi</th>
        </tr> 
      </thead> 
    </table> 
  </div> 
</div> 
@endsection 
 
@push('css') 
<!-- Bisa tambah CSS DataTables di sini kalau mau -->
<link rel="stylesheet" href="//cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
@endpush 
 
@push('js') 
<script> 
$(document).ready(function() { 
  var dataUser = $('#table_user').DataTable({ 
    serverSide: true,
    processing: true,
    ajax: { 
      url: "{{ url('user/list') }}", 
      dataType: "json", 
      type: "POST",
      headers: {
        'X-CSRF-TOKEN': '{{ csrf_token() }}' // untuk keamanan saat POST
      }
    },
    columns: [ 
      { 
        data: "DT_RowIndex",
        className: "text-center",
        orderable: false,
        searchable: false
      },
      { 
        data: "username",
        className: "",
        orderable: true,
        searchable: true
      },
      { 
        data: "nama",
        className: "",
        orderable: true,
        searchable: true
      },
      { 
        data: "level_pengguna",
        className: "text-center",
        orderable: true,
        searchable: true
      },
      { 
        data: "aksi",
        className: "text-center",
        orderable: false,
        searchable: false
      }
    ]
  }); 
});
</script> 
@endpush
