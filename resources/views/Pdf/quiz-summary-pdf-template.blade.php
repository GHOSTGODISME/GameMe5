<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>

    <style>
        body {
            width: 90%;
            margin: auto;
            margin-top: 50px;
            margin-bottom: 50px;
        }

        .header {
            text-align: center;
            word-break: break-all;
        }

        .summary-details {
            border: 1px solid #ccc;
            padding: 10px;
            margin-bottom: 20px;
        }

        .summary-details p {
            margin: 5px 0;
        }


        .quiz-info {
            width: 100%;
            margin-bottom: 20px;
            border-collapse: collapse;
        }

        .quiz-info td {
            text-align: right;
            padding: 5px;
        }

        .quiz-info td:nth-child(1) {
            text-align: left;
        }

        .quiz-info td:nth-child(2) {
            text-align: right;
        }

        .answered-by {
            width: 50%;
        }

        .generated-date {
            width: 50%;
        }

        .summary-details {
            border: 1px solid #ccc;
            padding: 10px;
            margin-bottom: 20px;
        }

        .summary-details table {
            width: 100%;
        }

        .summary-details td {
            padding: 5px;
            border-bottom: 1px solid #ccc;
            width: 10%;
            /* Divide table into two columns */
        }

        .summary-details td:nth-child(1) {
            font-weight: bold;
            width: 45%;
        }

        .summary-details td:nth-child(3) {
            width: 45%;
        }


        .question-review {
            border: 1px solid #ccc;
            margin-top: 10px;
            padding: 10px;
        }

        .question {
            margin-bottom: 20px;
            border: 1px solid #ccc;
            padding: 10px;
        }

        .question h4 {
            margin-top: 0;
            margin-bottom: 0;
        }

        ul {
            list-style: none;
            padding-left: 0;
        }

        li {
            margin-bottom: 5px;
        }

        .selected {
            font-weight: bold;
            color: blue;
        }

        .correct {
            font-weight: bold;
            color: green;
        }
    </style>
</head>

<body>

    <body>
        <div class="header">
            <!-- Sample user and quiz details -->
            <h1>{{ $data->quiz->title }}</h1>
            <h3>Quiz Summary Report</h3>
            <table class="quiz-info">
                <tr>
                    <td class="answered-by">
                        <p>Answered by: {{ $data->quizResponse->username ?? 'Chloe' }}</p>
                    </td>
                    <td class="generated-date">
                        <p>Generated Date: {{ $generatedDate }}</p>
                    </td>
                </tr>
            </table>

        </div>
        <div class="summary-details">
            <table>
                <tr>
                    <td>Rank</td>
                    <td>:</td>
                    <td>{{ $data->rank }}/{{ $data->totalParticipants }}</td>
                </tr>
                <tr>
                    <td>Score</td>
                    <td>:</td>
                    <td>{{ $data->quizResponse->total_points }}</td>
                </tr>
                <tr>
                    <td>Accuracy</td>
                    <td>:</td>
                    <td>{{ $data->quizResponse->accuracy }}%</td>
                </tr>
                <tr>
                    <td>Correct Answers</td>
                    <td>:</td>
                    <td>{{ $data->quizResponse->correct_answer_count }}</td>
                </tr>
                <tr>
                    <td>Incorrect Answers</td>
                    <td>:</td>
                    <td>{{ $data->quizResponse->incorrect_answer_count }}</td>
                </tr>
                <tr>
                    <td>Average Time</td>
                    <td>:</td>
                    <td>{{ $data->quizResponse->average_time }}s</td>
                </tr>
            </table>
        </div>
        <div class="question-review">
            <h3>Question Review</h3>
            <div class="questions">
                @foreach ($data->quiz->quiz_questions as $question)
                    <div class="question">
                        <h4>{{ $loop->iteration }}. {{ $question->title }}</h4>
                        <hr>
                        <ul>
                            @if ($question->type === 0 || $question->type === 1)
                                @foreach ($question->options as $option)
                                    <!-- <li>
                                        {{-- @if ($question->type === '0' && $question->single_ans_flag === 1) --}}
                                            <!== Single-select MCQ Question ==>
                                            <input type="radio" name="mcq-single"
                                            {{-- @if (in_array($option, $data->quizResponse->responses[$loop->index]->user_response)) checked @endif> --}}
                                            {{-- @if (in_array($option, $data->quizResponse->quiz_response_details[$loop->index]->user_response)) checked @endif> --}}
                                            {{-- @if (!empty($data->quizResponse->quiz_response_details[$loop->index]->user_response) && in_array($option, $data->quizResponse->quiz_response_details[$loop->index]->user_response)) checked @endif> --}}

                                            {{-- @else --}}
                                            <!== Multi-select MCQ Question ==>
                                            <input type="checkbox"
                                            {{-- @if (in_array($option, $data->quizResponse->quiz_response_details[$loop->index]->user_response)) checked @endif> --}}
                                            {{-- @if (!empty($data->quizResponse->quiz_response_details[$loop->index]->user_response) && in_array($option, $data->quizResponse->quiz_response_details[$loop->index]->user_response)) checked @endif> --}}

                                        {{-- @endif --}}
                                        {{-- {{ $option }} --}}
                                        {{-- @if (in_array($option, $question->correct_ans)) --}}
                                            {{-- <span class="correct">(Correct)</span> --}}
                                        {{-- @endif --}}
                                        {{-- @if (!empty($data->quizResponse->quiz_response_details[$loop->index]->user_response) && in_array($option, $data->quizResponse->quiz_response_details[$loop->index]->user_response)) --}}
                                            {{-- <span class="selected">(Selected)</span> --}}
                                        {{-- @endif --}}
                                    </li> -->

                                    <li>
                                        @php
                                            $userResponse = !empty($data->quizResponse->quiz_response_details[$loop->index]->user_response) ? json_decode($data->quizResponse->quiz_response_details[$loop->index]->user_response) : []; // Convert the string to array
                                        @endphp

                                        @if ($question->type === 0 && $question->single_ans_flag === 1)
                                            <!-- Single-select MCQ Question -->
                                            <input type="radio" name="mcq-single"
                                                @if (in_array($option, $userResponse)) checked @endif>
                                        @else
                                            <!-- Multi-select MCQ Question -->
                                            <input type="checkbox" @if (in_array($option, $userResponse)) checked @endif>
                                        @endif

                                        {{ $option }}

                                        @if (in_array($option, $question->correct_ans))
                                            <span class="correct">(Correct)</span>
                                        @endif

                                        @if (!empty($userResponse) && in_array($option, $userResponse))
                                            <span class="selected">(Selected)</span>
                                        @endif
                                    </li>
                                @endforeach
                                @if (!empty($question->answer_explaination))
                                    <div>
                                        <hr>
                                        <p><b>Explanation:</b></p>
                                        <p>{{ $question->answer_explaination }}</p>
                                    </div>
                                @endif
                            @elseif ($question->type === 2)
                                @if (!empty($data->quizResponse->quiz_response_details[$loop->index]->user_response))
                                    @php
                                        $userResponse = $data->quizResponse->quiz_response_details[$loop->index]->user_response;
                                        $userResponse = str_replace(['[', ']', '"'], '', $userResponse);
                                        $correctness = $data->quizResponse->quiz_response_details[$loop->index]->correctness;
                                    @endphp
                                    @if ($correctness)
                                        <p>Answered: {{ $userResponse }} <span class="correct">(Correct)</span></p>
                                    @else
                                        <p>Answered: {{ $userResponse }}</p>
                                        <hr>
                                        <p>Correct Answer: {{ $question->correct_ans[0] }}</p>
                                    @endif
                                @else
                                    <p>No response provided</p>
                                @endif
                                @if (!empty($question->answer_explaination))
                                    <div>
                                        <hr>
                                        <p><b>Explanation:</b></p>
                                        <p>{{ $question->answer_explaination }}</p>
                                    </div>
                                @endif
                            @endif
                        </ul>
                    </div>
                @endforeach
            </div>
        </div>
    </body>
</body>

</html>
