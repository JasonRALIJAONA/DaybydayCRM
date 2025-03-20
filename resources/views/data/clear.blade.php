{{-- contains a button to clear data --}}
@extends('layouts.master')
@section('heading')
    {{__('Clear data')}}
@stop

@section('content')
    <h2>Excluded Tables</h2>
    <ul>
        @foreach ($excludedTables as $table)
            <li>{{ $table }}</li>
        @endforeach
    </ul>
    <h3>Count : {{$count}}</h3>
    <h3>Test : {{$list}}</h3>


    {!! Form::open([
            'route' => 'data.clear-data',
            ]) !!}
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <div class="form-group">
        {!! Form::submit(__("Clear data"), ['class' => 'btn btn-md btn-brand']) !!}
    </div>

    {!! Form::close() !!}
@endsection