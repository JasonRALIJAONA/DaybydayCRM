{{-- a form to import a csv file --}}
@extends('layouts.master')
@section('heading')
    {{__('Import data')}}
@stop

@section('content')
    {!! Form::open([
            'route' => 'data.import-data',
            'files' => true
            ]) !!}
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <div class="form-group">
        {!! Form::label('file', __('File to import') . ':', ['class' => 'control-label thin-weight']) !!}
        {!! Form::file('file', null,['class' => 'form-control']) !!}
    </div>
    {!! Form::submit(__("Import data"), ['class' => 'btn btn-md btn-brand']) !!}

    {!! Form::close() !!}
@endsection