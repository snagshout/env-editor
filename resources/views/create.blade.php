@extends('layout')

@section('title', 'Create')

@section('content')
    <div class="row">
        <div class="col-12 mt-3 mb-5">
            <form method="post" action="{{ route('store_env_file') }}">
                @csrf

                <div class="row mb-3 sticky-top">
                    <div class="col">
                        <div class="row ">
                            <div class="col bg-dark text-white p-3">
                                <div class="lead"><input type="text" name="path" class="form-control form-control-sm col-3" placeholder=".env-filename" /></div>
                            </div>
                            <div class="col-2 bg-dark text-white p-3 text-right">
                                <a class="btn btn-success btn-sm " href="{{ route('list_env_files') }}"><i class="fas fa-step-backward"></i></a>
                                <button type="submit" class="btn btn-success btn-sm"><i class="far fa-save"></i> Save</button>
                            </div>
                        </div>
                    </div>
                </div>

                @include('errors')

                <div class="form-row mb-1 env-line-form">
                    <div class="col-6">
                        <input type="text" class="line-key form-control" placeholder="key" /></div>
                    <div class="col-5">
                        <input type="text" class="line-value form-control" placeholder="value" /></div>
                    <div class="col-1">
                        <button class="add-line btn btn-primary w-100">add</button></div>
                </div>

                <div class="env-line-container">
                    <div id="env-line-template" class="form-row mb-1" style="display:none">
                        <div class="col-6">
                            <input type="text" class="line-key form-control" /></div>
                        <div class="col-5">
                            <input type="text" class="line-value form-control" /></div>
                        <div class="col-1">
                            <button class="delete-line btn btn-danger w-100"><i class="fas fa-times"></i></button></div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('scripts')
<script type="text/javascript" src="{{ asset("js/main.js") }}"></script>
@endsection
