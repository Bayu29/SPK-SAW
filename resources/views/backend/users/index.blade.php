@extends('layouts.backend.app')

@section('title','Users')

@push('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css">
@endpush

@section('content')
    <div class="app-page-title">
        <div class="page-title-wrapper">
            <div class="page-title-heading">
                <div class="page-title-icon">
                    <i class="pe-7s-users icon-gradient bg-mean-fruit">
                    </i>
                </div>
                <div>Daftar Pegawai</div>
            </div>
            <div class="page-title-actions">
                <div class="d-inline-block dropdown">
                    <a href="{{ route('users.create') }}" class="btn-shadow btn btn-info">
                        <span class="btn-icon-wrapper pr-2 opacity-7">
                            <i class="fas fa-plus-circle fa-w-20"></i>
                        </span>
                        Tambah
                    </a>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="main-card mb-3 card">
                <div class="table-responsive">
                    <table id="datatable" class="align-middle mb-0 table table-borderless table-striped table-hover">
                        <thead>
                        <tr>
                            <th class="text-center">#</th>
                            <th>Nama</th>
                            <th class="text-center">Email</th>
                            <th class="text-center">Status</th>
                            <th class="text-center">Terdaftar</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $key => $user)
                                <tr>
                                    <td class="text-center text-muted">#{{ $key + 1 }}</td>
                                    <td>
                                        <div class="widget-content p-0">
                                            <div class="widget-content-wrapper">
                                                <div class="widget-content-left mr-3">
                                                    <div class="widget-content-left">
                                                        <img width="40" class="rounded-circle"
                                                             src="{{ $user->getFirstMediaUrl('avatar') != null ? $user->getFirstMediaUrl('avatar','thumb') : config('placeholder').'160' }}" alt="User Avatar">
                                                    </div>
                                                </div>
                                                <div class="widget-content-left flex2">
                                                    <div class="widget-heading">{{ $user->name }}</div>
                                                    <div class="widget-subheading opacity-7">
                                                        @if ($user->role)
                                                            <span class="badge badge-info">{{ $user->role->name }}</span>
                                                        @else
                                                            <span class="badge badge-danger">0</span>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="text-center">{{ $user->email }}</td>
                                    <td class="text-center">
                                        @if ($user->status)
                                            <div class="badge badge-success">Aktif</div>
                                        @else
                                            <div class="badge badge-danger">Nonaktif</div>
                                        @endif
                                    </td>
                                    <td class="text-center">{{ $user->created_at->diffForHumans() }}</td>
                                    <td class="text-center">

                                        {{ $user->performanceAssesment }}

                                        @if( empty($user->performanceAssesment) )
                                            <a href="{{ route('evaluation.evaluate', $user->id) }}" class="btn btn-success btn-sm">Penilaian</a>
                                        @else 
                                            <button class="btn btn-success btn-sm" data-toggle="tooltip" data-placement="top" title="Data sudah ada" disabled>Penilaian</button>
                                        @endif 

                                        <a class="btn btn-secondary btn-sm" href="{{ route('users.show',$user->id) }}"><i
                                                class="fas fa-eye"></i>
                                        </a>
                                        <a class="btn btn-info btn-sm" href="{{ route('users.edit',$user->id) }}"><i
                                                class="fas fa-edit"></i>
                                        </a>
                                        <button type="button" class="btn btn-danger btn-sm"
                                                onclick="deleteData({{ $user->id }})">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                        <form id="delete-form-{{ $user->id }}"
                                              action="{{ route('users.destroy',$user->id) }}" method="POST"
                                              style="display: none;">
                                            @csrf()
                                            @method('DELETE')
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js"></script>
    <script>
        $(document).ready(function() {
            // Datatable
            $("#datatable").DataTable();

            $('[data-toggle="tooltip"]').tooltip()
        });
    </script>
@endpush
