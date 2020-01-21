@extends('layout')

@section('title', 'Index')

@section('content')
    <div class="row">
        <div class="col">
            <div class="row ">
                <div class="col bg-dark text-white p-3">
                    <div class="lead">{{ $envName }}</div>
                </div>
                <div class="col-2 bg-dark text-white p-3 text-right">
                    <a class="btn btn-success btn-sm " href="{{ route('list_env_files') }}"><i class="fas fa-step-backward"></i></a>
                </div>
            </div>
        </div>

        <div class="col-12 mt-3">

            <ul class="list-group">
                @forelse ($versions as $version)
                <li class="list-group-item">
                    {{ $version['date']->format("m-d-Y H:i:s") }}
                    <div class="float-right">
                        <a href="{{ route('edit_env_file', ['file' => $env->path(), 'bucket' => $bucket, 'version' => $version['version']]) }}" class="btn btn-sm btn-primary">
                            <i class="far fa-edit"></i></a>
                    </div>
                </li>
                @empty
                <li class="list-group-item">No .env files found</li>
                @endforelse
            </ul>
        </div>
    </div>
@endsection

@section('scripts')
<script type="text/javascript">
$(document).ready(function(){
    $('.env-select').on('change', function(e) {
        window.location.href = $(this).val()
    })
})
</script>
@endsection
