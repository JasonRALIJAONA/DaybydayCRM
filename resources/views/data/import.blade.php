{{-- a form to import a csv file --}}
@extends('layouts.master')
@section('heading')
    {{__('Import data')}}
@stop

@section('content')
    <div class="container">
        <h2>Importer un fichier CSV</h2>

        <form action="{{ url('data/import-data') }}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="file"> Selectionner le fichier csv </label>
                <input type="file" name="file" class="form-control">
            </div>

            <button type="submit" class="btn btn-primary mt-2"> Importer </button>
        </form>
    </div>
@endsection