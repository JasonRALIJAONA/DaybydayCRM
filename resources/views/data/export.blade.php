{{-- contains a button to clear data --}}
@extends('layouts.master')
@section('heading')
    {{__('Export data')}}
@stop

@section('content')
    {!! Form::open([
            'route' => 'data.export-data',
            ]) !!}
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <div class="form-group">
        {!! Form::submit(__("Export CSV"), ['class' => 'btn btn-md btn-brand']) !!}
    </div>

    {!! Form::close() !!}
@endsection