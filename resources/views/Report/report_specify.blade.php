@extends('Layout/lect_master')

@section('title', 'Report')

@section('content')
<style>
   
.button-container {
    position: relative;
    display: flex;
    align-items:flex-start;
    margin-left:50px;
  }

  .menu-icon {
    cursor: pointer;
    font-size: 18px;
    display: flex;
    align-items:center;
    justify-content: center;
    padding: 0;
    z-index: 1;
    width:50px;
    height:50px;

  }

  .action-menu {
    position: absolute;
    top: 100%;
    right: 0;
    background: var(--Button, #2A2A2A); 
    box-shadow: 0px 8px 16px 0px rgba(0, 0, 0, 0.2);
    z-index: 1000;
    display: none;
    width:200px;
    border-radius: 8px;

  }

  .action-menu a {
    display: flex;
    padding: 8px;
    text-decoration: none;
    color: #f3f3f3;
    font-family: 'Roboto';
    font-size: 16px;
    font-style: normal;
    font-weight: 200;
    line-height: normal;
    justify-content: center;
  }

  .action-menu a:hover {
    background: var(--Button, #2A2A2A); 
    color: #d2d2d2;
    border-radius: 8px;
    text-decoration: :none;
  }

    .report_title{
        color: var(--Button, #2A2A2A);
        font-family: 'Roboto';
        font-size: 30px;
        font-style: normal;
        font-weight: 400;
        line-height: normal;
    }

    .head_container{
        display:flex;
        flex-direction:row;
        margin-top:50px;
    }

    .info_container{
        margin-left:auto;
    }
    

  .sub_header_cont{
    display:flex;
    flex-direction: row;
    margin-bottom:10px;
  }

  .report_subtitle{
         color: #5C5C5C;
        font-family: 'Roboto';
        font-size: 20px;
        font-style: normal;
        font-weight: 400;
        line-height: normal;    
  }
  
  .graph_container{
    display:flex;
    flex-direction: row;
  }

  .bottom_container{
    display:flex;
    flex-direction: row;
    justify-content: space-between;
    margin-top:20px;
    border-top:1px rgb(178, 178, 178) solid;
    padding-top:20px;
  }
  

  .ques_container{
    border-radius:8px;
    border:1px solid black;
    margin-bottom:20px;
  }

  .ques_head{
    border-bottom: 1px solid black;
    padding:10px;
    background: #3CCBC3;
    border-radius:8px 8px 0 0;
    color: #ffffff;
    font-family: 'Roboto';
    font-size: 16px;
    font-style: normal;
    font-weight: 400;
    line-height: normal;   
    display: flex; 
    align-items: center;

  }

  .ques_head p{
    margin:0;
    padding:0;
  }

  .ques_info{
    display:flex;
    flex-direction: row;
    padding:10px;
    justify-content: space-between;
  }



    .right_container{
    width:30%;
    }
  

  .dq_header{
    color: var(--Button, #5C5C5C);
    font-family: 'Roboto';
    font-size: 30px;
    font-style: normal;
    font-weight: 400;
    line-height: normal;
    margin-bottom:20px;
  }


  * {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
}

:root {
  --progress-bar-width: 200px;
  --progress-bar-height: 200px;
  --progress-bar-small-width: 50px;
  --progress-bar-small-height: 50px;
  --font-size: 2rem;
  --font-size-small: 1rem;
}

.circular-progress {
  width: var(--progress-bar-width);
  height: var(--progress-bar-height);
  border-radius: 50%;
  display: flex;
  justify-content: center;
  align-items: center;
}

.circular-progress_small{
  width: var( --progress-bar-small-width);
  height: var( --progress-bar-small-height);
  border-radius: 50%;
  display: flex;
  justify-content: center;
  align-items: center;
  margin-left:50px;
}

.inner-circle {
  position: absolute;
  width: calc(var(--progress-bar-width) - 30px);
  height: calc(var(--progress-bar-height) - 30px);
  border-radius: 50%;
  background-color: lightgrey;
}

.inner-circle_small {
  position: absolute;
  width: calc(var(--progress-bar-small-width) - 10px);
  height: calc(var(--progress-bar-small-height) - 10px);
  border-radius: 50%;
  background-color: lightgrey;
}

.percentage {
  position: relative;
  font-size: var(--font-size);
  color: rgb(0, 0, 0, 0.8);
}
.percentage_small {
  position: relative;
  font-size: var(--font-size-small);
  color: rgb(0, 0, 0, 0.8);

}

.percentage_small p{
    margin:0;
  padding:0;

}


.graph{
    margin-left:50px;
}

.progress-container{
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
}

.graph_label{
    margin-top:5px;
    color: #626262;
    font-family: 'Roboto';
    font-size: 16px;
    font-style: normal;
    font-weight: 400;
    line-height: normal;
}
.question-title {
    word-wrap: break-word;
}

.correct_info{
    display: flex;
    flex-direction: row;
    justify-content: center;
    align-items: center;
}

.time_info{
    display: flex;
    flex-direction: row;
    justify-content: center;
    align-items: center;
}
.correct_info p , .time_info p {
    margin:0;
    padding:0;
}


.correct_img{
    width:20px;
    height:20px;
    margin-right:10px;
}

.time_img{
    width:20px;
    height:20px;
    margin-right:10px;
}

.nhp_pp{
    width: 40px;
    height: 40px;
    border-radius: 50%;
    border: 2px white solid;
    margin-right:20px;
}

.need_help_cont{
    border-radius:8px;
    border:1px solid black;
    margin-top:20px;
  }

  .need_help_header{
    border-bottom: 1px solid black;
    padding:10px;
    background: #3CCBC3;
    border-radius:8px 8px 0 0;
    color: #ffffff;
    font-family: 'Roboto';
    font-size: 16px;
    font-style: normal;
    font-weight: 400;
    line-height: normal;   
    display: flex; 
    align-items: center;
    justify-content: center;
  }


  .need_help_player_cont{
    color: #000;
    font-family: 'Roboto';
    font-size: 16px;
    font-style: normal;
    font-weight: 400;
    line-height: normal;   
    display: flex; 
    align-items: center;
    padding:10px;
    justify-content: center;
  }

  .need_help_player{
    border:1px solid black;
    border-radius:8px;
    color: #000;
    font-family: 'Roboto';
    font-size: 16px;
    font-style: normal;
    font-weight: 400;
    line-height: normal;   
    display: flex; 
    align-items: center;
    padding:10px;
    width:80%;
  }

  .need_help_player p{
    margin:0;
    padding:0;
  }


  .small-progress-container {
        width: 50px; /* Adjust the width as needed */
        height: 50px; /* Adjust the height as needed */
    }

    @media print{
        .need_help_player{
            border:none;
        }
        .circular-progress_small{
        width: var( --progress-bar-small-width);
        height: var( --progress-bar-small-height);
        border-radius: 50%;
        display: flex;
        justify-content: center;
        align-items: center;
        margin-left:10px;
        }
        .nhp_pp{
            display:none;
        }


        .button-container,.menu-icon,.action-menu,.action-menu a,.action-menu a:hover{
            display:none;
        }

        .graph{
            margin-left:0px;
        }

     
    }

</style>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<link rel="stylesheet" type="text/css" href="path/to/print-styles.css" media="print" id="print-styles">
<script src="https://cdn.rawgit.com/eKoopmans/html2pdf/master/dist/html2pdf.bundle.js"></script>
<script src="https://cdn.rawgit.com/eligrey/FileSaver.js/master/dist/FileSaver.js"></script>

<div class = title_bar>
    <div class="sub_cont">
        <h1 class="report_title">Report</h1>
    </div>
</div>
<div class="head_container">
<div class="title2_container">
<h1>{{ $report->quiz->title}}</h1>
</div>
<div class="info_container">
    <div class="info"><p class="info_label"><b>Started:</b> {{$report->start_time}}</p></div>
        <div class="info"><p class="info_label"><b>Ended:</b> {{$report->end_time}}</p></div>
            <div class="info"><p class="info_label"><b>Created By:</b> {{$report->lecturer->user->name}}</p></div>

</div>

<div class="button-container">
    <div class="menu-icon" id="menuIcon" onclick="toggleMenu(this)">
        <img src="{{ asset('img/threedot_icon.png') }}" alt="three_dot">
    </div>
    <div class="action-menu" id="actionMenu">
        <a href="#" class="update-button" onclick="printPage()">Print</a>
    </div>
            
</div>
</div>
<div class="mid_container">
    <div class="sub_header_cont">
        <h3 class="report_subtitle"><u><b>Summary</b></u></h3>
    </div>
    <div class="graph_container">

        <div class="graph">
            <div class="progress-container">
                <div class="circular-progress" data-inner-circle-color="lightgrey" data-percentage="{{$quesCount}}" data-progress-color="crimson" data-bg-color="black">
                    <div class="inner-circle"></div>
                    <p class="percentage">{{$quesCount}}</p> <!-- Display integer instead of percentage -->
                </div>
                <p class="graph_label">Total Questions</p>
            </div>
        </div>

        <div class="graph">
            <div class="progress-container">
                <div class="circular-progress" data-inner-circle-color="white" data-percentage="{{$totalPlayer}}" data-progress-color="rebeccapurple" data-bg-color="violet">
                    <div class="inner-circle"></div>
                    <p class="percentage">{{$totalPlayer}}</p> <!-- Display integer instead of percentage -->
                </div>
                <p class="graph_label">Total Players</p>
            </div>
        </div>

        <div class="graph">
            <div class="progress-container">
               
                <div class="circular-progress" data-inner-circle-color="lime" data-percentage="{{$averageSessionScore}}" data-progress-color="green" data-bg-color="lightgrey">
                    <div class="inner-circle"></div>
                    <p class="percentage">{{$averageSessionScore}}%</p> <!-- Display percentage -->
                </div>
                <p class="graph_label">Average Score</p>
            </div>
        </div>

        <div class="graph">
            <div class="progress-container">
                <div class="circular-progress" data-inner-circle-color="cyan" data-percentage="{{$average_time}}" data-progress-color="blue" data-bg-color="skyblue">
                    <div class="inner-circle"></div>
                    <p class="percentage">{{$average_time}}</p> <!-- Display integer instead of percentage -->
                </div>
                <p class="graph_label">Average Time</p>
            </div>
        </div>
    </div>
</div>

<div class="bottom_container">
    <div class="left_container">
        <h3 class="dq_header">Difficult Questions</h3>
        @foreach ($difficultQuestions as $index => $dq)
        <div class="ques_container">
            <div class="ques_head">
                <p>{{ $loop->iteration }}. {{ $dq['question']->title }}</p>
            </div>
            <div class="ques_info">
                <div class="correct_info">
                    <img class="correct_img" src="{{ asset('img/correct_rep.png') }}" alt="Icon">
                    <p>Correct {{ $dq['average_correctness'] }}%</p>
                </div>

                <div class="time_info">
                    <img class="time_img" src="{{ asset('img/time_rep.png') }}" alt="Icon">
                    <p> Avg. {{ $dq['average_time_usage'] }}s</p>
                </div>
                
            </div>
        </div>
        @endforeach
    
    
        {{-- Display all difficult questions --}}
    </div>
    <div class="right_container">
        <div class="need_help_cont"> 
            <div class="need_help_header"><h3 >Need Help</h3></div>
            @foreach ($nhPlayers as $nhp)
            <div class="need_help_player_cont">
                <div class="need_help_player">
                    <img class=nhp_pp src="{{$nhp->user->profile_picture}}">
                    <p>{{$nhp->user->name}}</p>
                    <div class="small-progress-container">
                        <div class="circular-progress_small" data-inner-circle-color="white" data-percentage="{{$nhp->accuracy}}" data-progress-color="red" data-bg-color="grey">
                            <div class="inner-circle_small"></div>
                            <p class="percentage_small">0%</p> <!-- Display integer instead of percentage -->
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
           
        </div>
    </div>
</div>


<script>
   // Add a variable to keep track of the currently open menu
   let openMenu = null;
// Function to toggle menu visibility
function toggleMenu(icon, event) {
    event.stopPropagation(); // Stop event propagation to prevent the container click
    const menu = icon.nextElementSibling;

    // Close other open menu if exists
    if (openMenu && openMenu !== menu) {
        closeMenu(openMenu);
    }

    // Toggle the display of the current menu
    if (menu.style.display === 'none') {
        openMenu = menu;
        openMenu.style.display = 'block';
        // Add a click event listener to the document body to close the menu when clicking outside
        document.body.addEventListener('click', handleBodyClick);

        // Add a click event listener to the menu to stop propagation
        menu.addEventListener('click', function (e) {
            e.stopPropagation();
        });
    } else {
        closeMenu(menu);
    }
}

// Function to close the menu
function closeMenu(menu) {
    menu.style.display = 'none';
    openMenu = null;
    // Remove the click event listener from the document body
    document.body.removeEventListener('click', handleBodyClick);
}

// Function to handle clicks on the document body
function handleBodyClick() {
    // Close the currently open menu (if any)
    if (openMenu) {
        closeMenu(openMenu);
    }
}

// Add a click event listener to the document body
document.body.addEventListener('click', handleBodyClick);
$(document).ready(function () {
    var menuTimers = {}; // Object to store the timer IDs for each menu
    var inactivityTimer; // Variable to store the inactivity timer ID

    function showMenu(menuId) {
        clearTimeout(menuTimers[menuId]); // Clear any existing timer
        $("#" + menuId).slideDown(200); // Show the menu
    }

    function hideMenu(menuId) {
        menuTimers[menuId] = setTimeout(function () {
            $("#" + menuId).slideUp(200); // Hide the menu after 5 seconds
        }, 500);
    }

    function handleInactivity() {
        inactivityTimer = setTimeout(function () {
            hideAllMenus();
        }, 1000);
    }

    function hideAllMenus() {
        Object.keys(menuTimers).forEach(function (menuId) {
            hideMenu(menuId);
        });
    }

    $("[id^='menuIcon']").click(function () {
        var menuId = $(this).attr("id").replace("menuIcon", "");
        showMenu("actionMenu" + menuId);
        handleInactivity();
    });

    // Handle hover events for the action menus
    $("[id^='actionMenu']").hover(
        function () {
            // Mouse enters the action menu
            var menuId = $(this).attr("id");
            clearTimeout(menuTimers[menuId]); // Clear the timer
            clearTimeout(inactivityTimer); // Clear the inactivity timer
        },
        function () {
            // Mouse leaves the action menu
            var menuId = $(this).attr("id");
            hideMenu(menuId);
            handleInactivity();
        }
    );

    // Automatically close all menus after 3 seconds of inactivity
        $("body").on("mousemove", function () {
        clearTimeout(inactivityTimer);
        handleInactivity();
    });
});
    function handleCircularProgress(circularProgressSelector, isSmall) {
  const circularProgress = document.querySelectorAll(circularProgressSelector);

  Array.from(circularProgress).forEach((progressBar, index) => {
    const progressValue = progressBar.querySelector(isSmall ? ".percentage_small" : ".percentage");
    const innerCircle = progressBar.querySelector(isSmall ? ".inner-circle_small" : ".inner-circle");
    let startValue = 0,
        endValue = index === circularProgress.length - 1 ? parseFloat(progressBar.getAttribute("data-percentage")) : Number(progressBar.getAttribute("data-percentage")),
        speed = 0.5, // Reduced speed to 10 milliseconds
        progressColor = progressBar.getAttribute("data-progress-color");

    const step = (endValue / 100) * speed; // Calculate the step based on the decimal percentage

    const progress = setInterval(() => {
      startValue = parseFloat(startValue) + step; // Use the calculated step

      // Check if the content is a percentage or an integer
      if (progressValue.textContent.includes('%')) {
        progressValue.textContent = `${startValue.toFixed(0)}%`; // Use toFixed to include two decimal points
      } else {
        // Add 's' to the end of the content for the last element
        if (index === circularProgress.length - 1) {
          progressValue.textContent = `${startValue.toFixed(2)}s`; // Use toFixed to include two decimal points
        } else {
          progressValue.textContent = `${startValue.toFixed(0)}`;
        }
      }

      progressValue.style.color = `${progressColor}`;

      innerCircle.style.backgroundColor = `${progressBar.getAttribute(
        "data-inner-circle-color"
      )}`;

      progressBar.style.background = `conic-gradient(${progressColor} ${
        startValue * 3.6
      }deg,${progressBar.getAttribute("data-bg-color")} 0deg)`;

      if (startValue >= endValue) {
        clearInterval(progress);
      }
    }, speed);
  });
}

// Call the function for regular circular progress bars
handleCircularProgress(".circular-progress", false);

// Call the function for small circular progress bars
handleCircularProgress(".circular-progress_small", true);


function printPage() {
  // Hide non-essential elements for printing
  document.getElementById('print-styles').removeAttribute('media');
  window.print();
  // Restore styles for screen view
  document.getElementById('print-styles').setAttribute('media', 'print');
}
</script>


@endsection