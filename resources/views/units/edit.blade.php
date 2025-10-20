@extends('layouts.app')

@section('title', 'Edit Unit')

@section('content')
    <div class="container-fluid">
        @include('layouts.alert')

        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Edit Unit</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('units.update', $unit->id) }}" method="POST">
                    @csrf
                    @method('patch')

                    <div class="mb-3">
                        <label for="code" class="form-label">Kode Unit</label>
                        <input type="text" class="form-control" id="code" name="code" value="{{ $unit->code }}"
                            required>
                    </div>

                    <div class="mb-3">
                        <label for="name" class="form-label">Nama Unit</label>
                        <input type="text" class="form-control" id="name" name="name" value="{{ $unit->name }}"
                            required>
                    </div>

                    <button type="submit" class="btn btn-success">Update</button>
                </form>
            </div>
        </div>
    </div>
@endsection
