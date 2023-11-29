<!-- Display all survey responses in a scrollable table -->
<div style="overflow-x: auto; overflow-y: auto; max-height: 400px;">
    <p>number of response: {{$surveyResponses->count()}}</p>

    <table border="1">
        <thead>
            <tr>
                <th>Response ID</th>
                <th>Survey ID</th>
                <th>User ID</th>
                <!-- Add columns for each question title -->
                @foreach ($surveyResponses->first()->question_responses as $questionResponse)
                    <th>{{ $questionResponse->survey_question->title }}</th>
                @endforeach
                <!-- Add other headings as needed -->
            </tr>
        </thead>
        <tbody>
            @foreach ($surveyResponses as $response)
                <tr>
                    <td>{{ $response->id }}</td>
                    <td>{{ $response->survey_id }}</td>
                    <td>{{ $response->user_id }}</td>
                    <!-- Loop through each question response for this response -->
                    @foreach ($response->question_responses as $questionResponse)
                        <td>{{ $questionResponse->answers }}</td>
                    @endforeach
                    <!-- Add other response details as needed -->
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
