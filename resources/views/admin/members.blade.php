<!-- menggunakan kerangka dari master.blade.php -->


@extends('header')

@section('title', 'Dashboard')

@section('main')
<div class="col-md-12 px-4 bg-white py-5" style="min-height: calc(100vh - 75px);">
  <div class="card shadow-sm">
    <div class="card-header">
      Panel Members
    </div>
    <div class="card-body">
  @if($message = Session::get('success'))
  <div class="alert alert-success">
    <button class="close" data-dismiss="alert">×</button>
    <strong>{{ $message }}</strong>
  </div>
  @endif

  <table class="table">
    <thead>
      <tr>
        <th class="text-center">No.</th>
        <th width="30%">Nama</th>
        <th width="30%">Email</th>
        <th width="20%" class="text-center">Jumlah Postingan</th>
        <th width="30%" class="text-center">Opsi</th>
      </tr>
    </thead>
    <tbody>
      @foreach ($members as $i => $member)
      <tr>
        <td class="text-center">{{ ++$i }}</td>
        <td>{{ $member->name }}</td>
        <td>{{ $member->email }}</td>
        <td class="text-center">
          <button class="btn btn-outline-dark btn-sm" onclick="location.href='/author/{{ $member->id }}'"><span data-feather="file-text"></span> {{ $member->postis }}</button>
        </td>
        <td class="text-center">
          <button class="btn btn-outline-danger btn-sm" onclick="location.href='/delete_members/{{ $member->id }}'"><span data-feather="trash-2"></span> Hapus</button>
        </td>
      </tr>
      @endforeach
    </tbody>
  </table>
</div>
</div>
</div>
@endsection
