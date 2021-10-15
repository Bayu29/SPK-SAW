@extends('layouts.backend.app')

@section('title', 'Kriteria')

@section('content')
    <div class="app-page-title">
        <div class="page-title-wrapper">
            <div class="page-title-heading">
                <div class="page-title-icon">
                    <i class="pe-7s-users icon-gradient bg-mean-fruit">
                    </i>
                </div>
                <div>{{ __((isset($criteria) ? 'Edit' : 'Tambah') . ' Kriteria') }}</div>
            </div>
            <div class="page-title-actions">
                <div class="d-inline-block dropdown">
                    <a href="{{ route('app.kriteria.index') }}" class="btn-shadow btn btn-danger">
                        <span class="btn-icon-wrapper pr-2 opacity-7">
                            <i class="fas fa-arrow-circle-left fa-w-20"></i>
                        </span>
                        {{ __('Back to list') }}
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <!-- Form Start -->
            <form id="criteriaForm" action="{{ isset($criteria) ? route('app.kriteria.update', $criteria->id) : route('app.kriteria.store') }}">
                @csrf
                @if (isset($criteria))
                    @method('PUT')
                @endif
                <div class="main-card mb-3 card">
                    <div class="card-body">
                        <h5 class="card-title">Form Data Kriteria</h5>
                        <x-forms.textbox label="Kode Kriteria" name="kode_kriteria" value="{{ $criteria->kode_kriteria ?? '' }}" field-attributes="required"></x-forms.textbox>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection