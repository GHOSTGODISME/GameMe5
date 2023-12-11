@extends('Layout/classroom_lect_home_master')

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
    z-index: -1;
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

</style>



<!-- Display filtered classrooms associated with the lecturer -->
@foreach ($filteredClassrooms as $index=> $classroom)
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
                    <a href="#" onclick="confirmAndSubmit({{ $classroom->id }},event)">Remove Class</a>
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


<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
   function confirmAndSubmit(classroomId, event) {
    event.stopPropagation();
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