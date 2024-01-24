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
    background-color: #ffffff;
    box-shadow: 0px 8px 16px 0px rgba(0, 0, 0, 0.2);
    z-index: 1;
    display: none;
    width:200px;
    border-radius: 8px;

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
    background-color: #e3e3e3;
    border-radius: 8px;
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
        color: var(--Button, #ffffff);
        font-family: 'Roboto';
        font-size: 30px;
        font-style: normal;
        font-weight: 400;
        line-height: normal;
        margin-bottom: 0;
        margin-right:30px;
       
    }

    .class_subtitle{
        color: #ffffff;
        font-family: 'Roboto';
        font-size: 14px;
        font-style: normal;
        font-weight: 400;
        line-height: normal;
        text-decoration:underline;
        margin-right:75%;
        align-self: flex-end;
      
    }

    u{
        color: #ffffff;  
    }
    .class_subtitle:hover{
        color: #ffffff;
        font-family: 'Roboto';
        font-size: 14px;
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
    .admin_subtitle1{
    text-decoration: underline;
    }

.nav_container {
        display: flex;
        flex-direction: row;

    }

    .admin_title {
        color: var(--Button, #2A2A2A);
        font-family: 'Roboto';
        font-size: 30px;
        font-style: normal;
        font-weight: 400;
        line-height: normal;
    }

    .admin_subtitle1 {
        color: #5C5C5C;
        font-family: 'Roboto';
        font-size: 16px;
        font-style: normal;
        font-weight: 400;
        line-height: normal;
    }

    .admin_subtitle2 {
        color: #5C5C5C;
        font-family: 'Roboto';
        font-size: 16px;
        font-style: normal;
        font-weight: 400;
        line-height: normal;
        margin-left: 50px;
    }

    .admin_subtitle3 {
        color: #000;
        font-family: 'Inter';
        font-size: 30px;
        font-style: normal;
        font-weight: 700;
        line-height: normal;
    }

    .bordered {
        color: var(--Thirdly, #656565);
        font-family: 'Roboto';
        font-size: 16px;
        font-style: normal;
        font-weight: 400;
        line-height: normal;
    }

    .admin_table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
    }

    .admin_table th {
        border: 1px solid #ddd;
        padding: 8px;
        text-align: left;
    }

    .admin_table td {
        border-bottom: 1px solid #ddd;
        padding: 8px;
        text-align: left;
    }

    .admin_table th {
        background-color: #f2f2f2;
    }

    .admin_table tr{
        background-color: #f2f2f2;
    }

    
    .admin_table tbody tr:nth-child(even) {
        background-color: #f9f9f9;
    }

    .admin_subtitle1 a,
    .admin_subtitle2 a {
        text-decoration: none;
    }

    .admin_subtitle1 a:hover,
    .admin_subtitle2 a:hover {
        color: #5C5C5C;
        font-family: 'Roboto';
        font-size: 16px;
        font-style: normal;
        font-weight: 400;
        line-height: normal;
    }

    
    .admin_subtitle1 a:visited,
    .admin_subtitle2 a:visited {
        color: #5C5C5C;
        font-family: 'Roboto';
        font-size: 16px;
        font-style: normal;
        font-weight: 400;
        line-height: normal;
    }

    .title_bar {
        display: flex;
        flex-direction: row;
        width: 100%;
        justify-content: space-between;
    }

    .add_icon {
        width: 30px;
        height: 30px;
        align-self: center;
    }

    .sub_cont {
        display: flex;
        flex-direction: row;
        justify-content: space-between;
        align-items: center;
        gap: 10px;
    }

    .add_link {
        padding: 0;
        margin: 0;
    }

    .sub_container{
        margin-left:auto;
        margin-right:20px;
        display: flex;
        flex-direction: row;
        align-items: center;
    }

    .btn{
        width:50px;
        height:30px;
        display: inline;
    }
 

</style>

    <div class="title_container">
    <h1 class="class_title">Classroom</h1>
    <a href="{{ route('classroom_lect_home')}}" class="class_subtitle">View More</a>
    </div>
        <div class="title_container">
            <h3 class="class_subtitle"></h3>
            <div class=sub_container>
          
            {{-- <form action="{{ route('lect_search_class') }}" method="GET" class="search-form">
                <img class="search_icon" src="img/search_icon.png" alt="search_favicon">
                <input type="text" name="search" class="search-input" placeholder="Search">
            </form> --}}
            {{-- <a href="{{ route('lect_add_class') }}">
                <img class="add_icon" src="img/add_icon.png" alt="add_favicon">
            </a> --}}
        </div>
        </div>
    

<div class="big_big_cont" id="bigBigCont">
<!-- Display filtered classrooms associated with the lecturer -->
@foreach ($classrooms as $index => $classroom)
    @php
    $randomColors = ['#168AAD', '#52B69A', '#B876C8'];
    $randomColor = $randomColors[array_rand($randomColors)];
    @endphp
    <div class="classroom_container" style="background-color: {{ $randomColor }};" onclick="redirect('{{ route('class_lect_stream', ['classroom' => $classroom->id]) }}')">
        <div class="class_container_row1">
            <p>{{ $classroom->coursecode }} (G{{ $classroom->group }})</p>

            <div class="button-container">
                <div class="menu-icon" id="menuIcon{{ $index }}" onclick="toggleMenu(this, event)">
                    <img src="img/threedot_white.png" alt="three_dot">
                </div>
                <div class="action-menu" id="actionMenu{{ $index }}">
                    <a href="#" onclick="redirect('{{ route('lect_update_class', ['classroom' => $classroom->id]) }}')">Edit Class</a>
                    <a href="#" onclick="confirmAndSubmit({{ $classroom->id }}, event)">Remove Class</a>
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
    <a href="{{ route('own-quiz')}}" class="class_subtitle">View More</a>
    </div>
        <div class="title_container" style="margin-top:30px;">
            <h3 class="class_subtitle">Created</h3>
        <div class=sub_container>
                {{-- <form action="{{ route('lect_search_class') }}" method="GET" class="search-form">
                    <img class="search_icon" src="img/search_icon.png" alt="search_favicon">
                    <input type="text" name="search" class="search-input" placeholder="Search">
                </form> --}}
                {{-- <a href="{{ route('lect_add_class') }}">
                    <img class="add_icon" src="img/add_icon.png" alt="add_favicon">
                </a> --}}
        </div>
    </div>

        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    
        <!-- In your Blade view (resources/views/admin/students/index.blade.php) -->
        @if(count($quizzes) > 0)
        <table class="admin_table">
            <thead>
                <tr>
                    <th class="bordered">No</th>
                    <th class="bordered">Title</th>
                    <th class="bordered">Visibility</th>
                    <th class="bordered">Modified Date</th>
                    <th class="bordered">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($quizzes as $quiz)
                    <tr>
                        <td class="bordered">{{ $loop->index + 1 }}</td>
                        <td class="bordered">{{ $quiz->title }}</td>
                        <td class="bordered">{{ ucfirst($quiz->visibility) }}</td>
                        <td class="bordered">{{ $quiz->updated_at->format('Y-m-d H:i:s') }}</td>
    
                        <td>
                            <a href="{{ route('view-quiz', ['id' => $quiz->id]) }}" class="btn btn-info edit-delete-btn">
                                View</a>
                            <a href="{{ route('edit-quiz', ['id' => $quiz->id]) }}" class="btn btn-info edit-delete-btn">
                                <i class="fa fa-edit"></i></a>
                            <a class="btn btn-danger edit-delete-btn" onclick="confirmDelete({{ $quiz->id }})">
                                <i class="fa fa-trash"></i></a>
                        </td>
                    </tr>
                @endforeach
                <!-- Add more rows as needed -->
            </tbody>
        </table>
        @else
        <p>No records found.</p>
        @endif


        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous">
        </script> 
        <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>

        function confirmDelete(id) {
            if (confirm('Are you sure you want to delete this quiz?')) {
                // Make an AJAX request to delete the quiz
                axios.delete('{{ url('delete-quiz') }}/' + id, {
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                })
                .then(response => {
                    // Handle success, e.g., remove the deleted row from the table
                    console.log('quiz deleted successfully:', response.data);
                    location.reload(); // Reload the page
                })
                .catch(error => {
                    // Handle error
                    console.error('Error deleting quiz:', error);
                });
            }
        }

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
        Swal.fire({
    title: 'Are you sure?',
    text: 'Once deleted, you will not be able to recover this classroom!',
    icon: 'warning',
    showCancelButton: true,  // This line ensures the "Cancel" button is displayed
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'OK',
    cancelButtonText: 'Cancel',  // This line sets the text for the "Cancel" button
    dangerMode: true,
})
.then((result) => {
    if (result.isConfirmed) {
        // User clicked "OK," proceed with the deletion
        $.ajax({
            url: "{{ route('classroom_remove') }}",
            method: 'POST',
            data: {
                class_id: classroomId,
                _token: '{{ csrf_token() }}',
            },
            success: function (response) {
                if (response.success) {
                    Swal.fire('Poof! Your classroom has been deleted!', {
                        icon: 'success',
                    })
                    .then(() => {
                        location.reload();
                    });
                } else {
                    Swal.fire('Error!', 'Error removing classroom. ' + response.message, 'error');
                }
            },
            error: function () {
                Swal.fire('Error!', 'Error removing classroom', 'error');
            }
        });
    } else {
        // User clicked "Cancel," do nothing or handle as needed
        Swal.fire('Your classroom is safe!');
    }
});
}


    function redirect(url) {
        window.location.href = url;
    }

    // Add a variable to keep track of the currently open menu
    let openMenu = null;
// Function to toggle menu visibility
// Function to toggle menu visibility
function toggleMenu(icon, event) {
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

        // Add a click event listener to the menu items to stop propagation
        const menuItems = menu.querySelectorAll('a');
        menuItems.forEach(item => {
            item.addEventListener('click', function (e) {
                e.stopPropagation();
            });
        });
    } else {
        closeMenu(menu);
    }

    // Stop event propagation to prevent the container click
    event.stopPropagation();
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
// $(document).ready(function () {
//     var menuTimers = {}; // Object to store the timer IDs for each menu
//     var inactivityTimer; // Variable to store the inactivity timer ID

//     function showMenu(menuId) {
//         clearTimeout(menuTimers[menuId]); // Clear any existing timer
//         $("#" + menuId).slideDown(200); // Show the menu
//     }

//     function hideMenu(menuId) {
//         menuTimers[menuId] = setTimeout(function () {
//             $("#" + menuId).slideUp(200); // Hide the menu after 5 seconds
//         }, 500);
//     }

//     function handleInactivity() {
//         inactivityTimer = setTimeout(function () {
//             hideAllMenus();
//         }, 1000);
//     }

//     function hideAllMenus() {
//         Object.keys(menuTimers).forEach(function (menuId) {
//             hideMenu(menuId);
//         });
//     }

//     $("[id^='menuIcon']").click(function () {
//         var menuId = $(this).attr("id").replace("menuIcon", "");
//         showMenu("actionMenu" + menuId);
//         handleInactivity();
//     });

//     // Handle hover events for the action menus
//     $("[id^='actionMenu']").hover(
//         function () {
//             // Mouse enters the action menu
//             var menuId = $(this).attr("id");
//             clearTimeout(menuTimers[menuId]); // Clear the timer
//             clearTimeout(inactivityTimer); // Clear the inactivity timer
//         },
//         function () {
//             // Mouse leaves the action menu
//             var menuId = $(this).attr("id");
//             hideMenu(menuId);
//             handleInactivity();
//         }
//     );

//     // Automatically close all menus after 3 seconds of inactivity
//     $("body").on("mousemove", function () {
//         clearTimeout(inactivityTimer);
//         handleInactivity();
//     });
// });

</script>
@endsection