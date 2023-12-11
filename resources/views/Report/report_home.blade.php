@extends('Layout/lect_master')

@section('title', 'Report Dashboard')

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

 
    .bordered{
        color: var(--Thirdly, #656565);
        font-family: 'Roboto';
        font-size: 16px;
        font-style: normal;
        font-weight: 400;
        line-height: normal; 
    }

.report_table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 20px;
}

.report_table th{
    border: 1px solid #ddd;
    padding: 8px;
    text-align: left;
}

.report_table td {
    border-bottom: 1px solid #ddd;
    padding: 8px;
    text-align: left;
}

.report_table th {
    background-color: #f2f2f2;
}

.report_table tbody tr:nth-child(even) {
    background-color: #f9f9f9;
}


.button-container {
    position: relative;
    display: flex;
    align-items: center;
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

  td a{
    color: var(--Thirdly, #656565);
        font-family: 'Roboto';
        font-size: 16px;
        font-style: normal;
        font-weight: 400;
        line-height: normal; 
    text-decoration: none;
  }

  td a:hover{
    color: var(--Thirdly, #656565);
        font-family: 'Roboto';
        font-size: 16px;
        font-style: normal;
        font-weight: 400;
        line-height: normal; 
    text-decoration: underline;
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

    .sub_cont a{
        color: #000;
        font-family: 'Roboto';
        font-size: 30px;
        font-style: normal;
        font-weight: 500;
        line-height: normal;
    }

</style>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<div class = title_bar>
    <div class="sub_cont">
        <a class="admin_subtitle3" href="{{ route('report_home') }}">Report</a>
    </div>
    <form action="{{ route('report_search') }}" method="GET" class="search-form">
        <img class="search_icon" src="img/search_icon.png" alt="search_favicon">
        <input type="text" name="search" class="search-input" placeholder="Search">
        <button type="submit" class="search-button">Search</button>
    </form>
</div>

<table class="report_table">
    <thead>
        <tr>
            <th class="bordered">No</th>
            <th class="bordered">Quiz Name</th>
            <th class="bordered">Creation Date</th>
            <th class="bordered">Created By</th>
            <th class="bordered">Action</th>
        </tr>
    </thead>
    <tbody>
     
        @foreach ($sessionData as $index=> $report)
            <tr>
                <td class="bordered">{{ $loop->index + 1 }}</td>
                <td class="bordered"><a href="{{ route('report_specify', ['reportId' => $report->id]) }}">{{ $report->quiz->title }}</a></td>
                <td class="bordered">{{ $report->created_at }}</td>
                <td class="bordered">{{ $report->lecturer->user->name}}</td>
                <td class="button-container">
                    <div class="menu-icon" id="menuIcon{{ $index }}" onclick="toggleMenu(this)">
                        <img src="img/threedot_icon.png" alt="three_dot">
                    </div>
                    <div class="action-menu" id="actionMenu{{ $index }}">
                        <a href="#" class="update-button" onclick="printPage('{{ $report->id }}')">Print</a>
                    </div>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
@if($sessionData->isEmpty())
<p class="noResultMsg">No results found.</p>
 @else
@endif

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

    function printChildPage(reportId) {
  // Open the child page in a new window
  const childPageUrl = "{{ route('report_specify', ['reportId' => ':reportId']) }}".replace(':reportId', reportId);
  const childWindow = window.open(childPageUrl, '_blank');

  // Check if the child window is opened successfully
  if (childWindow) {
    // Wait for the child window to load, then trigger the print function
    childWindow.onload = function () {
      childWindow.print();
    };
  } else {
    alert('Failed to open the child page. Please allow pop-ups for this site.');
  }
}

function printPage(reportId) {
  // If you want to print the current page, you can use window.print()
  // For example: window.print();

  // If you want to print a specific child page, call printChildPage with the reportId
  printChildPage(reportId);
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