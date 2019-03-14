@if ($errors->any())
    <div class="col">
        <div class="alert alert-danger" style="font-size:0.8em">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    </div>
@endif
