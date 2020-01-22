@extends('layout')

@section('title', 'Edit')

@section('content')
    <div class="row">
        <div class="col-12 mt-3 mb-5">
            <form method="post" action="{{ route('update_env_file') }}">
                @csrf
                <input type="hidden" name="path" value="{{ $env->path() }}" />
                <input type="hidden" name="bucket" value="{{ $bucket }}" />
                <span class="remove-key-container"><input type="hidden" id="remove-key-tpl" /></span>

                <div class="row mb-3 sticky-top">
                    <div class="col">
                        <div class="row ">
                            <div class="col bg-dark text-white p-3">
                                <div class="lead">{{ $envName }}</div>
                            </div>
                            <div class="col-2 bg-dark text-white p-3 text-right">
                                <a class="btn btn-success btn-sm " href="{{ route('list_env_files', compact('bucket'))
                                }}"><i
                                            class="fas fa-step-backward"></i></a>
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
                    @php $index = 0 @endphp
                    @forelse ($env->toArray() as $key => $value)
                    <div class="form-row mb-1 env-line">
                        <div class="col-6">
                            <input type="text" name="lines[{{ $index }}][key]" class="line-key form-control" value="{{ $key }}" /></div>
                        <div class="col-5">
                            <input type="text" name="lines[{{ $index++ }}][value]" class="line-value form-control" value="{{ $value }}" /></div>
                        <div class="col-1">
                            <button class="delete-line btn btn-danger w-100"><i class="fas fa-times"></i></button></div>
                    </div>
                    @empty
                    <div class="display-4">Empty</div>
                    @endforelse

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
