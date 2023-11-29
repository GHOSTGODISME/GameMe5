@extends('Layout/classroom_specify_master')

@section('title', 'Classroom')

@section('content')
<style>

.polls-page a {
    text-decoration: underline;
    /* Add any other styles for the current page link */
    }

    
    .annPolls{
        border:1px black solid;
        margin-bottom:10px;
    }
    .ann_header{
        display: flex;
        flex-direction: row;
        justify-content: space-between;
    }

    .ann_category{

    }

    .author{

    }

    .datetime{

    }

    .ann_content{
    display:flex;
    flex-direction: row;
    justify-content: space-between;
    }

    .option_big_container {
        display: flex;
        flex-direction: row;
        justify-content: space-between;
    }

    .option_one,
    .option_two {
        border: 1px solid #ddd;
        padding: 10px;
        margin: 5px;
    }

    .polls_result {
        margin-top: 20px;
    }

</style>

<div class="annPolls">
    <div class="ann_header">
    <p class="author">{{$announcement->user->name}}<p>
        <p class="datetime">{{ \Carbon\Carbon::createFromTimestamp(strtotime($announcement->created_at))->format('d/m/Y h:i A')}}</p>
    </div>
    <div class="ann_content">
    <p>{{ $announcement->annPolls->question }}</p>
    </div>

    <div class="polls_result">
        <p>Results:</p>
        <p>Option 1: {{ $option1Count }} votes</p>
        <p>Option 2: {{ $option2Count }} votes</p>
    </div>
    @if (!$userHasVoted)
    <form action="{{ route('class_reply_polls') }}" method="post">
        @csrf
        <div class="option_big_container">
            <div class="option_one">
                <label for="option1">
                    <input type="radio" name="poll_option" id="option1" value="1">
                    Option 1
                </label>
            </div>
            <div class="option_two">
                <label for="option2">
                    <input type="radio" name="poll_option" id="option2" value="2">
                    Option 2
                </label>
            </div>
        </div>

        <input type="hidden" name="polls_id" value="{{ $polls->id }}">
        <input type="submit" value="Submit">
    </form>
@else
    <p>You have already voted for this poll.</p>
@endif
</div>

<script>
</script>
@endsection