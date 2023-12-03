@extends('Layout/student_master')

@section('title', 'Homepage')

@section('content')
<style>

body{
    background: linear-gradient(to right, #00C6FF, #0082FF, #0072FF);  
}

.stud_big_cont{
    display:flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
}

#txt_game_code{
    padding: 25px 15px 20px 15px;
    border: 1px solid #BFBFBF;
    border-radius: 10px;
    box-sizing: border-box;
    background: #FAFAFA;
    width: 500px;
    height: 40px;
    flex-shrink: 0;
    margin-top:30px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-family: 'Roboto', sans-serif; /* Replace 'Your Font' with the desired font name */
    font-size: 25px; /* Adjust the font size as needed */
    font-weight: bold; /* Adjust the font weight as needed */
    text-align: center; /* Center the text horizontally */
}

#txt_game_code:focus{
    outline: none;
    border-color: #007bff; /* Change the border color on focus */
} 
    
#txt_game_code::placeholder{
    color: #A3A3A3;
    font-family:'Roboto';
    font-size: 25px;
    font-style:normal;
    font-weight: 400;
    line-height: normal;
    text-align: center;
}

.stud_sub_header{
color: var(--Logo-Secondary, #FAFAFA);
font-family: 'Bubblegum Sans';
font-size: 40px;
font-style: normal;
font-weight: 400;
line-height: normal;
text-decoration: none;
}


.classroom_container{
    border-radius: 15px;
    padding:0;
    margin:0;
    margin-bottom:50px;
    width:100%;
    height: 180px;

    color: #FFF;
    font-family: 'Roboto';
    font-size: 25px;
    font-style: normal;
    font-weight: 500;
    line-height: normal;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    cursor: pointer;
    background-color: rgba(255, 255, 255, 0.3); /* 0.8 is the alpha value (transparency), where 0 is fully transparent and 1 is fully opaque */

    }

    .class_container_row1{
        display:flex;
        flex-direction: row;
        justify-content: space-between;
        margin:10px 50px 0 30px;
        padding:0;
    
    }

    .class_container_row1 p{
        text-align: center; 
        justify-content: center;
        align-self:center;
    }

    .class_container_row2{
        display:flex;
        flex-direction: row;
        justify-content: space-between;
        margin:15px 50px 0 30px;
        padding:0;
        
    }

    .class_container_row3{
        display:flex;
        flex-direction: row;
        justify-content:flex-end;
        margin:10px 50px 20px 20px;
        padding:0;
        padding-right: 20px;
        font-size: 20px;

        
    }

    .classroom_container p{
        margin:0;
        padding:0;
    }

    
.button-container {
    position: relative;
    display: flex;
    align-items: center; 
    width:50px;
    height:50px;
   
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
    background-color: #D9D9D9;
    box-shadow: 0px 8px 16px 0px rgba(0, 0, 0, 0.2);
    z-index: 1;
    display: none;
    width:200px;

  }

  .action-menu a {
    display: block;
    padding: 8px;
    text-decoration: none;
    color: #000;
    font-family: 'Roboto';
    font-size: 16px;
    font-style: normal;
    font-weight: 200;
    line-height: normal;
  }

  .action-menu a:hover {
    background-color: #f2f2f2;
  }


.stud_small_cont {
    overflow: auto;
    max-height: 300px; /* Set your preferred height */
}

.stud_small_cont::-webkit-scrollbar {
    width: 0; /* Set the width of the scrollbar to 0 */
}

.stud_sub_cont a{
text-decoration: none;
}


</style>

<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

<form action="{{ route('join-quiz') }}" method="GET">
    @csrf
<div class="stud_big_cont">
    <img src="img/logo_stud.png" alt="logo">
    <input type="text" id="txt_game_code" name="code" placeholder="Game Code">
    <button type="submit" class="button_general">Enter</button>
</div>
</form>

<div class="stud_sub_cont">
<a href="{{ route('classroom_stud_home') }}" class="stud_sub_header">Classroom</a>
<div class="stud_small_cont">
    @foreach ($student->classrooms as $classroom)

    <div class="classroom_container" onclick="redirect('{{ route('class_stud_stream', ['classroom' => $classroom->id]) }}')">
        <div class="class_container_row1">
        <p>{{ $classroom->coursecode }} (G{{ $classroom->group }})</p>

        <div class="button-container">
            <div class="menu-icon" onclick="toggleMenu(this, event)">
                <img src="img/threedot_white.png" alt="three_dot">
            </div>
            <div class="action-menu">
                <a href="#" onclick="confirmAndSubmit({{ $classroom->id }})">Leave Class</a>
            </div>
        </div>

        </div>
        <div class="class_container_row2">
        <p>{{ $classroom->name }}</p>
        </div>

        <div class="class_container_row3">
            <p> {{ $classroom->creator->user->name }}</p>
        </div>

    </div>
@endforeach
</div>
</div>

<script>
    function confirmAndSubmit(classroomId) {
    if (confirm("Are you sure you want to leave this classroom?")) {
        $.ajax({
            url: "{{ route('classroom_quit') }}",
            method: 'POST',
            data: {
                class_id: classroomId, // Update this line
                _token: '{{ csrf_token() }}',
            },
            success: function (response) {
                if (response.success) {
                    alert('You have successfully left the classroom!');
                    location.reload();
                } else {
                    alert('Error leaving classroom: ' + response.message);
                }
            },
            error: function () {
                alert('Error leaving classroom');
            }
        });
    }
}

function redirect(url) {
        window.location.href = url;
    }

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



</script>
@endsection
