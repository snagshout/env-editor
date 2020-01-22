@extends('layout')

@section('title', 'Bucket ' . $bucket)

@section('content')
    <div class="row">
        <div class="col mt-3">
            <form method="post">
                @csrf
                <div class="form-row">
                    <div class="col">
                        <input class="form-control form-control-sm"
                               type="text"
                               name="bucket"
                               value="{{ $bucket }}"/>
                    </div>
                    <div class="col">
                        <button class="btn btn-primary btn-sm" type="submit">
                            Load
                        </button>
                    </div>
                </div>
            </form>
        </div>

        <div class="col mt-3">
            <a href="{{ route('add_env_file', ['bucket' => $bucket]) }}"
               class="add-line btn btn-success btn-sm float-right">
                Create .env file
            </a>
        </div>

        <div class="col-12 mt-3">

            <ul class="list-group">
                @forelse ($envs as $env)
                    <?php $params = ['file' => $env->path(), 'bucket' => $bucket]?>
                    <li class="list-group-item">
                        {{ $env->path() }}
                        <div class="float-right">
                            <a href="{{ route('env_file_history', $params) }}"
                               class="btn btn-sm btn-info">
                                <i class="fas fa-history"></i>
                            </a>
                            <a href="{{ route('edit_env_file', $params) }}"
                               class="btn btn-sm btn-primary">
                                <i class="far fa-edit"></i>
                            </a>
                            <a href="{{ route('delete_env_file', $params) }}"
                               class="btn btn-sm btn-danger">
                                <i class="far fa-trash-alt"></i>
                            </a>
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
        $(document).ready(function () {
            $('.env-select').on('change', function (e) {
                window.location.href = $(this).val()
            })
        })
    </script>
@endsection
