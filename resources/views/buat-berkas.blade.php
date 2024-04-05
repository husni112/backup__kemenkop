@extends('layouts.user_type.auth')

@section('content')
<div class="row">
  <div class="col-md-12">
    <div class="card">
      <div class="card-header pb-0">
        <h6 class="mb-0">Akuns</h6>
      </div>
      <div>
        <form id="uploadForm" action="" method="post" enctype="multipart/form-data">
          @csrf
          <input type="hidden" id="user-id" value="{{ $user->id }}">
          <button type="button" onclick="addData()">Tambah Berkas</button>
        </form>
      </div>
      <div class="card-body pt-4 p-3" id="listContainer">
        @foreach ($berkas as $data)
          <div id="berkas-{{ $data->id }}" class="list-group-item border-0 d-flex p-4 mb-2 bg-gray-100 border-radius-lg" onclick="redirectToPage('{{ route('pengajuan', ['id' => $data->id]) }}')">
            <div id="test" class="d-flex flex-column">
              <h6 class="mb-3 text-sm">Kode Berkas : <span class="mb-2 text-xs">{{ $data->kode_berkas }}</span></h6>
              <button type="button" onclick="removeData(event, '{{ $data->id }}')">Delete</button> 
            </div>
          </div>
        @endforeach   
      </div>
      {{ $berkas->links('pagination::bootstrap-5') }}
    </div>
  </div>
</div>


<script src="{{ asset('js/script.js') }}">

@endsection

