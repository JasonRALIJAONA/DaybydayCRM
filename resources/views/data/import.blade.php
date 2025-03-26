{{-- a form to import a csv file --}}
@extends('layouts.master')
@section('heading')
    {{__('Import data')}}
@stop

@section('content')

<div class="tablet">
    <div class="tablet__head tablet__head__color-brand">
        <h3 class="tablet__head-title text-white">{{ __('Import Data') }}</h3>
    </div>
    <div class="tablet__body">
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

        <br>

        {{-- list the error in a table if there is any --}}
        @if (isset($err) && count($err) > 0)
        <div class="row mt-4">
            <div class="col-md-12">
                <h4 class="text-danger">{{ __('Errors') }}</h4>
                <table class="table table-bordered table-striped table-hover">
                    <thead>
                        <tr>
                            <th>{{ __('File') }}</th>
                            <th>{{ __('Line') }}</th>
                            <th>{{ __('Message') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($err as $error)
                            <tr>
                                <td>{{ $error['file'] }}</td>
                                <td>{{ $error['line'] }}</td>
                                <td>{{ $error['message'] }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @endif
    </div>
</div>

@endsection