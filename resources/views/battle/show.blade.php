@extends("base")

@section("head")
    <title>{{ $battle->location->name }}</title>
    @parent
@stop

@section("body")

    <div class="col-md-6">
        <h2>Participants</h2>
        <hr>

        <ul class="list-group">
            @foreach($battle->participants as $character)
                <li class="list-group-item">
                    {{$character->name}}
                </li>
            @endforeach
        </ul>

        <a href="{{ route('index') }}">
            Back
            <span class="fa fa-history"></span>
        </a>
    </div>

    <div class="col-md-6">
        <h2>Battle logs:</h2>
        <hr>
        <ul class="list-group">
            @foreach($battle->logs as $log)
                <li class="list-group-item">
                    {{$log->body}}
                </li>
            @endforeach
        </ul>
    </div>

@stop