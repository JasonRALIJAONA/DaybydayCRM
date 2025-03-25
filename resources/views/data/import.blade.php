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
        {!! Form::label('first file', __('First file') . ':', ['class' => 'control-label thin-weight']) !!}
        {!! Form::file('file1', null,['class' => 'form-control']) !!}
    </div>
    <div class="form-group">
        {!! Form::label('Second file', __('Second file') . ':', ['class' => 'control-label thin-weight']) !!}
        {!! Form::file('file2', null,['class' => 'form-control']) !!}
    </div>
    <div class="form-group">
        {!! Form::label('Third file', __('Third file') . ':', ['class' => 'control-label thin-weight']) !!}
        {!! Form::file('file3', null,['class' => 'form-control']) !!}
    </div>
    {!! Form::submit(__("Import data"), ['class' => 'btn btn-md btn-brand']) !!}

    {!! Form::close() !!}
@endsection