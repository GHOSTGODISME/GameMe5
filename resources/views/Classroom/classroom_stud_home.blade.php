@extends('Layout/classroom_home_master')

@section('title', 'Classroom')

@section('content')
<style>
    .classroom_container{
    border-radius: 15px;
    border: 1px solid #BFBFBF;
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


</style>

<!-- Display classrooms associated with the  student -->
@foreach ($student->classrooms as $classroom)

@php
$randomColors = ['#168AAD', '#52B69A', '#B876C8'];
$randomColor = $randomColors[array_rand($randomColors)];
@endphp

<div class="classroom_container" style="background-color: {{ $randomColor }};"onclick="redirect('{{ route('class_stud_stream', ['classroom' => $classroom->id]) }}')">
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