@extends('Layout/lect_master')

@section('title', 'Classroom')

@section('content')
<style>
.classroom_container {
        border-radius: 15px;
        border: 1px solid #BFBFBF;
        padding: 0;
        margin: 0;
        margin-bottom: 50px;
        width: 96%; /* Set a fixed width for each container */
        height: 180px;
        color: #FFF;
        font-family: 'Roboto';
        font-size: 25px;
        font-style: normal;
        font-weight: 500;
        line-height: normal;
        display: inline-flex;
        flex-direction: column;
        justify-content: space-between;
        cursor: pointer;
        z-index: -1;
        margin-right: 10px;
    }

    .big_big_cont {
        overflow-x: hidden;
        white-space: nowrap;
        width:100%
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
    z-index: 1;
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
    z-index: 1;
  }

  .action-menu a:hover {
    background-color: #f2f2f2;
  }
  .title_container{
        display:flex;
        flex-direction:row;
        width:100%;
        align-items: center;
    }

    .title_container a{
       margin:0;
       padding:0;
       margin-bottom:5px;
    }


    .class_title{
        color: var(--Button, #2A2A2A);
        font-family: 'Roboto';
        font-size: 30px;
        font-style: normal;
        font-weight: 400;
        line-height: normal;
        margin-bottom: 0;
        margin-right:30px;
       
    }

    .class_subtitle{
        color: #5C5C5C;
        font-family: 'Roboto';
        font-size: 16px;
        font-style: normal;
        font-weight: 400;
        line-height: normal;
        text-decoration:underline;
        margin-right:75%;
        align-self: flex-end;
      
    }



    .add_icon{
        width:30px;
        height:30px;
        align-self: center;
    }

    .sub_cont{
    display: flex;
    flex-direction: row;   
    align-items: center;
    
    }

    .add_link{
        padding: 0;
        margin:0;
    }

    .search-form {
        position: relative;
        margin-top:15px;
        margin-right:10px;
    }

    /* Style for the search icon */
    .search_icon {
        position: absolute;
        left: 10px;
        top: 50%;
        transform: translateY(-50%);
        width: 20px; /* Adjust the width as needed */
        height: 20px; /* Adjust the height as needed */
    }

    /* Style for the input */
    .search-input {
        padding: 10px 40px; /* Adjust padding to accommodate the icon */
        border: 1px solid #ccc;
        border-radius: 5px;
        margin-right: 10px;
        font-size: 14px;
    }

    /* Style for the button */
    .search-button {
        padding: 10px 15px;
        background-color: #000;
        color: #fff;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        font-size: 14px;
    }
</style>
<div class="content">
    <div class="title_container">
    <h1 class="class_title">Classroom</h1>
    <a href="{{ route('classroom_lect_home')}}" class="class_subtitle">View More</a>
    </div>
        <div class="title_container">
            <h3 class="class_subtitle"></h3>
            <form action="{{ route('lect_search_class') }}" method="GET" class="search-form">
                <img class="search_icon" src="img/search_icon.png" alt="search_favicon">
                <input type="text" name="search" class="search-input" placeholder="Search">
            </form>
            <a href="{{ route('lect_add_class') }}">
                <img class="add_icon" src="img/add_icon.png" alt="add_favicon">
            </a>
        </div>
    

<div class="big_big_cont" id="bigBigCont">
<!-- Display filtered classrooms associated with the lecturer -->
@foreach ($classrooms as $classroom)
    @php
    $randomColors = ['#168AAD', '#52B69A', '#B876C8'];
    $randomColor = $randomColors[array_rand($randomColors)];
    @endphp
    <div class="classroom_container" style="background-color: {{ $randomColor }};" onclick="redirect('{{ route('class_lect_stream', ['classroom' => $classroom->id]) }}')">
        <div class="class_container_row1">
            <p>{{ $classroom->coursecode }} (G{{ $classroom->group }})</p>

            <div class="button-container">
                <div class="menu-icon" onclick="toggleMenu(this, event)">
                    <img src="img/threedot_white.png" alt="three_dot">
                </div>
                <div class="action-menu">
                    <a href="#" onclick="redirect('{{ route('lect_update_class', ['classroom' => $classroom->id]) }}')">Edit Class</a>
                    <a href="#" onclick="confirmAndSubmit({{ $classroom->id }})">Remove Class</a>
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


<div class="title_container">
    <h1 class="class_title">Quiz</h1>
    <a href="{{ route('classroom_lect_home')}}" class="class_subtitle">View More</a>
    </div>
        <div class="title_container">
            <h3 class="class_subtitle">Created</h3>
            <form action="{{ route('lect_search_class') }}" method="GET" class="search-form">
                <img class="search_icon" src="img/search_icon.png" alt="search_favicon">
                <input type="text" name="search" class="search-input" placeholder="Search">
            </form>
            <a href="{{ route('lect_add_class') }}">
                <img class="add_icon" src="img/add_icon.png" alt="add_favicon">
            </a>
        </div>

</div>  
<script>
    const bigBigCont = document.getElementById('bigBigCont');
    const container = document.querySelector('.classroom_container');
    const containerWidth = container.offsetWidth + parseInt(getComputedStyle(container).marginRight);
    let isMouseOver = false;

    bigBigCont.addEventListener('mouseover', function () {
        isMouseOver = true;
    });

    bigBigCont.addEventListener('mouseout', function () {
        isMouseOver = false;
    });

    bigBigCont.addEventListener('wheel', function (event) {
        event.preventDefault();

        const scrollAmount = containerWidth / 5; // Adjust the smoothness by changing the divisor

        if (event.deltaY < 0) {
            bigBigCont.scrollLeft -= scrollAmount;
        } else {
            bigBigCont.scrollLeft += scrollAmount;
        }
    });

    function confirmAndSubmit(classroomId) {
        if (confirm("Are you sure you want to remove this classroom?")) {
            $.ajax({
                url: "{{ route('classroom_remove') }}",
                method: 'POST',
                data: {
                    class_id: classroomId,
                    _token: '{{ csrf_token() }}',
                },
                success: function (response) {
                    if (response.success) {
                        alert('You have successfully removed the classroom!');
                        location.reload();
                    } else {
                        alert('Error removing classroom. ' + response.message);
                    }
                },
                error: function () {
                    alert('Error removing classroom');
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
</script>
@endsection