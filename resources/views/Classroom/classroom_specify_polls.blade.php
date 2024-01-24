@extends('Layout/classroom_specify_master')

@section('title', 'Classroom')

@section('content')
<style>

.polls-page a {
    text-decoration: underline;
    /* Add any other styles for the current page link */
    }

    .annPolls{
        border-radius: 8px;
        margin-bottom:30px;
        background: #FFFFFF;
        border: 1px solid #353535;
    }

  
    .ann_header{
        display: flex;
        flex-direction: row;
        border-radius: 8px 8px 0 0;
        background: #252525;
        padding:20px 20px 5px 20px;
    }

    .ann_header p, .ann_header h1{
        padding: 0;

    }

    .ann_category{
        color: #000;
        font-family: 'Roboto';
        font-size: 18px;
        font-style: normal;
        font-weight: 500;
        line-height: normal;
        margin-right:30px;
    }

    .author{
        color: #FFFFFF;
        font-family: 'Roboto';
        font-size: 14px;
        font-style: normal;
        font-weight: 500;
        line-height: normal;
    }

    .datetime{
        color: #FFFFFF;
        font-family: 'Roboto';
        font-size: 14px;
        font-style: normal;
        font-weight: 500;
        line-height: normal;
        margin-left:auto;
        margin-right:30px;
    }

    .ann_content{
        display:flex;
        flex-direction: column;
        border-top: 1px solid #BFBFBF;
        cursor: pointer;
        background: #FAFAFA;
        border-bottom: 1px solid #BFBFBF;
        padding-top:15px;

       
    }

    .ann_content p{
        margin:0;
        padding:0;
    }

    .ann_content p{
        padding:5px 20px 5px 20px;
    }

    .question{
        color: #000000;
        font-family: 'Roboto';
        font-size: 20px;
        font-style: normal;
        font-weight: 500;
        line-height: normal;
    }

.option_big_container {
    display: flex;
    flex-direction: row;
    justify-content: space-between;
    margin-left:20px;
    margin-right:20px;
    margin-bottom:30px;
}

.option_one, .option_two {
    border: 1px solid #ddd;
    margin: 10px;
    padding:15px;
    padding-top:25px;
    padding-bottom:25px;
    width:500px; /* Adjust the width as needed */
    box-sizing: border-box;
    cursor: pointer;
    border-radius: 8px;
    display:flex;
    flex-direction: row;
    justify-content: center;
    align-content: center;
    align-items: center;

}

.option_one p, .option_two p,.option_one label, .option_two label{
    margin:0;
    padding:0;
}


form {
    margin-top: 20px;
}

input[type="radio"] {
    margin-right: 5px;
}

input[type="submit"] {
        border: none;
        cursor: pointer;
        border-radius: 8px;
        background: var(--Button, #2A2A2A); 
        width: 300px;
        height: 50px;
        flex-shrink: 0;
        color: #FFF;
        font-family: 'Roboto';
        font-size: 16px;
        font-style: normal;
        font-weight: 400;
        line-height: normal;
       
}

.polls_result{
    margin-top: 20px;
    padding:8px 20px 8px 20px;
    border-top: 1px solid #BFBFBF;
}

.polls-options {
    margin: 10px 0;
}

.option-label {
    flex: 1;
    margin-right: 10px;
    font-weight: bold; /* Make the option label bold for better visibility */
    color: #000000;
    font-family: 'Roboto';
    font-size: 14px;
    font-style: normal;
    font-weight: bold;
    line-height: normal;
    margin-left:3px;
}


.progress-container {
    flex: 3;
    height: 20px; /* Increase the height of the progress bar */
    border: 1px solid #ddd;
    border-radius: 8px;
    overflow: hidden;
    width:300px;
    background:#EFEFEF;
}

.progress{
    display: flex;
    flex-direction: row ;
    margin:0;
    height:20px;
    background:#FFFFFF;
}
.progress p{
    color: #000000;
    font-family: 'Roboto';
    font-size: 12px;
    font-style: normal;
    font-weight: 500;
    line-height: normal;
    
}

.progress-bar {
    width:300px;
    height: 100%;
    color: white;
    text-align: center;
    line-height: 30px; /* Adjust the line height for better centering */
}

.progress-bar1 {
    width: <?php echo $option1Count; ?>%;
    background-color: #F8A3A3;
    border-radius:8px;
}

.progress-bar2 {
    width: <?php echo $option2Count; ?>%;
    background-color: #8FB8D6; /* You can change this color */

}

.polls_button{
    display: flex;
    justify-content: center;
    margin: 10px;

}

.info_txt {
    margin-top: 5px;
    margin-left: 30px;
    color: rgb(3, 172, 3);
}

</style>


<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<div class="row">
<div class="col-md-12">
<div class="annPolls">
    <div class="ann_header">
    <p class="author">{{$announcement->user->name}}</p>
        <p class="datetime">{{ \Carbon\Carbon::createFromTimestamp(strtotime($announcement->created_at))->format('d/m/Y h:i A')}}</p>
        <div class="button-container">
            <div class="menu-icon"  id="menuIcon2" onclick="toggleMenu(this, event)">
                <img src="{{ asset('img/threedot_white.png')}}" alt="three_dot">
            </div>
            <div class="action-menu" id="actionMenu2">
                <a href="#" data-toggle="modal" data-target="#updateAnnouncementModal" class="updateAnnouncementBtn" onclick="openUpdateModal({{ $announcement->id }})">Update Announcement</a>
                <a href="#" class="deleteAnnouncementBtn" onclick="deleteAnnouncement({{ $announcement->id }})">Delete Announcement</a>
            </div>
           
        </div>
    </div>
    <div class="ann_content">
    <p class="question">{{ $announcement->annPolls->question }}</p>
    
    <div class="polls_result">
    
        <div class="polls-options">
            <div class="option-label">{{$announcement->annPolls->option1}}</div>
            <div class="progress">
                <div class="progress-container">
                    <div class="progress-bar progress-bar1"></div>
               
                </div>
                <p>{{$option1Count}}</p>
            </div>
        </div>
        
        <div class="polls-options">
            <div class="option-label">{{$announcement->annPolls->option2}}</div>
            <div class="progress">
                <div class="progress-container">
                    <div class="progress-bar progress-bar2"></div>
                </div>
                <p>{{$option2Count}}</p>
            </div>
        </div>

    </div>

    </div>


    @if (!$userHasVoted)
    <form action="{{ route('class_reply_polls') }}" method="post">
        @csrf
        <div class="option_big_container">

            <div class="option_one" onclick="selectOption('option1')">
                <label for="option1">
                    <input type="radio" name="poll_option" id="option1" value="1">
                </label>
                <p class="option-label">{{$announcement->annPolls->option1}}</p>
            </div>

            <div class="option_two" onclick="selectOption('option2')">
                <label for="option2">
                    <input type="radio" class="option-label" name="poll_option" id="option2" value="2">
                </label>
                <p class="option-label">{{$announcement->annPolls->option2}}</p>
            </div>
            
        </div>

        <input type="hidden" name="polls_id" value="{{ $polls->id }}">
        <div class="polls_button">
        <input type="submit" value="Vote">
        </div>
    </form>
@else
    <p class="info_txt">You have already voted for this poll.</p>
@endif

@error('poll_option') {{-- Note the correct usage --}}
    <script>
         showErrorPopup("{{ __('Please select an option!') }}");
        function showErrorPopup(errorMessage) {
    Swal.fire({
        title: 'Error!',
        text: errorMessage,
        icon: 'error',
        confirmButtonText: 'OK'
    });
}
    </script>


@enderror
</div>
</div>
</div>

<script>
  function selectOption(optionId) {
        const radio = document.getElementById(optionId);
        radio.checked = true;
    }
    
</script>
@endsection