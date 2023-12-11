@extends('Layout/admin_master')

@section('title', 'Admin Dashboard')

@section('content')
<style>
    .title_bar{
    display: flex;
    flex-direction: row;
    width:100%;
    justify-content: space-between;
    }
    .add_icon{
        width:30px;
        height:30px;
        align-self: center;
    }

    .sub_cont{
    display: flex;
    flex-direction: row;   
    justify-content: space-between;
    align-items: center;
    width:200px; 
    }

    .add_link{
        padding: 0;
        margin:0;
    }

    .search-form {
        display: flex;
        align-items: center;
        position: relative;
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
    .staff-page a {
    text-decoration: underline;
    /* Add any other styles for the current page link */
    }

    .noResultMsg{
        color: #5C5C5C;
        font-family: 'Roboto';
        font-size: 16px;
        font-style: normal;
        font-weight: 400;
        line-height: normal;
        margin-top:20px;

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
    top: 80%;
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




</style>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<div class = "title_bar">
    <div class="sub_cont">
        <h1 class="admin_subtitle3">Staff</h1>
        <a class="add_link" href="{{ route('admin_add_staffs') }}">
            <img class="add_icon" src="img/add_icon.png" alt="add_favicon">
        </a>
    </div>
    <form action="{{ route('admin_staff_search') }}" method="GET" class="search-form">
        <img class="search_icon" src="img/search_icon.png" alt="search_favicon">
        <input type="text" name="search" class="search-input" placeholder="Search">
        <button type="submit" class="search-button">Search</button>
    </form>
</div>

<!-- In your Blade view (resources/views/admin/students/index.blade.php) -->
<table class="admin_table">
    <thead>
        <tr>
            <th class="bordered">No</th>
            <th class="bordered">Staff ID</th>
            <th class="bordered">Staff Name</th>
            <th class="bordered">Gender</th>
            <th class="bordered">Email</th>
            <th class="bordered">Action</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($staffs as $index=>$staff)
            <tr>
                <td class="bordered">{{ $loop->index + 1 }}</td>
                <td class="bordered">{{ $staff->id }}</td>
                <td class="bordered">{{ $staff->name }}</td>
                <td class="bordered">{{ $staff->gender}}</td>
                <td class="bordered">{{ $staff->email }}</td>
                <td class="button-container">
                    <div class="menu-icon" id="menuIcon{{ $index }}" onclick="toggleMenu(this)">
                      <img src="img/threedot_icon.png" alt="three_dot"> <!-- Unicode character for three dots -->
                    </div>
                    <div class="action-menu" id="actionMenu{{ $index }}">
                      <a href="{{ route('admin_edit_staff', ['staff' => $staff->id]) }}">Update</a>
                      <a href="#" onclick="confirmAndSubmit({{ $staff->id }})">Remove</a>
                    </div>
                  </td>
            </tr>
        @endforeach
        <!-- Add more rows as needed -->
    </tbody>
</table>

@if($staffs ->isEmpty())
<p class="noResultMsg">No results found.</p>
 @else
@endif
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
function confirmAndSubmit(staffId) {
    Swal.fire({
        title: 'Are you sure?',
        text: 'You want to remove this staff?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, remove it!'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: "{{ route('admin_destroy_staff') }}",
                method: 'POST',
                data: {
                    staffId: staffId,
                    _token: '{{ csrf_token() }}',
                },
                success: function (response) {
                    if (response.success) {
                        Swal.fire({
                            title: 'Success!',
                            text: 'Profile removed successfully!',
                            icon: 'success',
                        }).then(() => {
                            location.reload(); // This will reload the current page
                        });
                    } else {
                        Swal.fire({
                            title: 'Error!',
                            text: 'Error removing profile: ' + response.message,
                            icon: 'error',
                        });
                    }
                },
                error: function () {
                    Swal.fire({
                        title: 'Error!',
                        text: 'Error removing profile',
                        icon: 'error',
                    });
                }
            });
        }
    });
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
</script>

@endsection