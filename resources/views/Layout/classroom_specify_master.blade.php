<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap">
    <title>@yield('title', 'GameMe5')</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Bubblegum+Sans&display=swap">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
      <!-- jQuery first, then Popper.js, then Bootstrap JS -->
      <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
      <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
      <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
      <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

      <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css"
      integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
</head>
<style>
       html,body{
        margin: 0;
        padding: 0;
        height: 100%;
    }

    body{
        background: #404040;
    }


    .content{
    margin-left:90px;
    margin-top:45px; 
    margin-right:90px; 
    padding-bottom:50px;
    }
    
    .title_container{
        display:flex;
        flex-direction:row;
        width:100%;
    }

    .class_name{
        margin-left:100px;
    }

    .class_name, .class_coursecode{
        font-family: 'Roboto';
        font-size: 25px;
        font-style: normal;
        font-weight: 500;
        line-height: normal;    
        color: #ffffff;
    
    }

    .nav_container{
        display: flex;
        flex-direction: row;
    }

    .class_subtitle1{
        color: #ffffff;
        font-family: 'Roboto';
        font-size: 16px;
        font-style: normal;
        font-weight: 400;
        line-height: normal;    
        
    }
    .class_subtitle2,.class_subtitle3,.class_subtitle4,.class_subtitle5,.class_subtitle6{
        color: #ffffff;
        font-family: 'Roboto';
        font-size: 16px;
        font-style: normal;
        font-weight: 400;
        line-height: normal;
        margin-left:50px;
    }
   
    .class_subtitle1 a,.class_subtitle2 a,.class_subtitle3 a,.class_subtitle4 a,.class_subtitle5 a,.class_subtitle6 a{
        text-decoration: none;
        color: #ffffff;
        font-family: 'Roboto';
        font-size: 16px;
        font-style: normal;
        font-weight: 400;
        line-height: normal;
    }

    
    

    .big_con{
        display:flex;
        flex-direction:row;
        justify-content: space-between;
        margin-bottom:10px;
        margin-top:25px;
    }

    .add_icon{
        width:30px;
        height:30px;
        align-self: center;
    }


    
    .info_icon{
        width:30px;
        height:30px;
        align-self: center;
    }

    
    .button-container {
    position: relative;
    display: flex;
    align-items: center; 
    width:20px;
    height:20px;
   
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
    z-index: 1;
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
  }

</style>

<body>
@include('Layout/student_header')

<div class="content">
<div class="title_container">
<h1 class="class_coursecode">{{ $classroom->coursecode }} (G{{ $classroom->group }})</h1>
<h1 class="class_name">{{ $classroom->name }} </h1>

</div>

<div class="big_con">
<div class = "nav_container">
    <h3 class="class_subtitle1 {{ in_array(request()->route()->getName(), ['class_stud_stream']) ? 'stream-page' : '' }}">
        <a href="{{ route('class_stud_stream', ['classroom' => $classroom->id]) }}">Stream</a>
    </h3>

    <h3 class="class_subtitle2 {{ in_array(request()->route()->getName(), ['class_stud_quiz']) ? 'quiz-page' : '' }}">
        <a href="{{ route('class_stud_quiz', ['classroom' => $classroom->id]) }}">Quiz</a>
    </h3>

    <h3 class="class_subtitle3 {{ in_array(request()->route()->getName(), ['class_stud_qna','class_specify_qna']) ? 'qna-page' : '' }}">
        <a href="{{ route('class_stud_qna', ['classroom' => $classroom->id]) }}">Q&A</a>
    </h3>

    <h3 class="class_subtitle4 {{ in_array(request()->route()->getName(), ['class_stud_polls','class_specify_polls']) ? 'polls-page' : '' }}">
        <a href="{{ route('class_stud_polls', ['classroom' => $classroom->id]) }}">Polls</a>
    </h3>

    <h3 class="class_subtitle5 {{ in_array(request()->route()->getName(), ['class_stud_feedback']) ? 'feedback-page' : '' }}">
        <a href="{{ route('class_stud_feedback', ['classroom' => $classroom->id]) }}">Survey</a>
    </h3>

    <h3 class="class_subtitle6 {{ in_array(request()->route()->getName(), ['class_stud_people']) ? 'people-page' : '' }}">
        <a href="{{ route('class_stud_people', ['classroom' => $classroom->id]) }}">People</a>
    </h3>

</div>


<div class="button-container">
    <div class="menu-icon" id="menuIcon" onclick="toggleMenu(this, event)">
        <img src="{{ asset('img/threedot_icon.png')}}" alt="three_dot">
    </div>
    <div class="action-menu" id="actionMenu">
        <a href="#" data-toggle="modal" data-target="#addAnnouncementModal">Add Announcement</a>
    </div>
   
</div>
</div>

    <!-- Page Content -->
    @yield('content')
</div>       
</body>


<div class="modal fade" id="addAnnouncementModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add New Announcement</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Add your form for adding a new announcement here -->
                <form id="addAnnouncementForm" action="{{ route('class_stud_add_announcement') }}" method="post">
                    @csrf 
                    <input type="hidden" name="classId" value="{{ $classroom->id }}">
                    <!-- Announcement Type -->
                    <div class="form-group">
                        <label for="announcementType">Announcement Type</label>
                        <div class="input-group">
                            <select class="form-control custom-select" id="announcementType" name="announcementType">
                                <option value="qna">Q&A Announcement</option>
                                <option value="polls">Polls Announcement</option>
                                <!-- Add other announcement types as needed -->
                            </select>
                         
                        </div>
                    </div>
                    
                    <!-- Content Field (Common to all types) -->
                 <div class="form-group" id="contentField" style="display: none;">
                        <label for="content">Content</label>
                        <textarea class="form-control" id="content" name="content"></textarea>
                    </div>

                  <!-- Q&A Specific Fields -->
                <div class="form-group" id="qnaFields">
                    <label for="qna_question">Question</label>
                    <input type="text" class="form-control" id="qna_question" name="qna_question">
                    <!-- Add other Q&A fields as needed -->
                </div>


                    <!-- Q&A Specific Fields -->
                 <!-- Polls Specific Fields -->
                <div class="form-group" id="pollsFields" style="display: none;">
                    <label for="polls_question">Question</label>
                    <input type="text" class="form-control" id="polls_question" name="polls_question">

                    <label for="option1">Option 1</label>
                    <input type="text" class="form-control" id="option1" name="option1">

                    <label for="option2">Option 2</label>
                    <input type="text" class="form-control" id="option2" name="option2">
                    <!-- Add other Polls fields as needed -->
                </div>


                    <!-- Add other specific fields for different announcement types -->

                    <button type="submit" class="btn btn-primary">Create Announcement</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Update Modal -->
<div class="modal fade" id="updateAnnouncementModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Update Announcement</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Form for updating an announcement -->
                <form id="updateAnnouncementForm" action="{{ route('class_update_announcement') }}" method="post">
                    @csrf
                    @method('POST') <!-- Use PUT method for updating -->

                    <!-- Hidden field for announcement ID -->
                    <input type="hidden" name="announcementId" id="updateAnnouncementId">

                    <!-- Announcement Type -->
                    <div class="form-group">
                        <label for="announcementType">Announcement Type</label>
                        <div class="input-group">
                            <input type="text" class="form-control" id="updateAnnouncementType" name="updateAnnouncementType" readonly>
                        </div>
                    </div>

                    <!-- Content Field (Common to all types) -->
                    <div class="form-group" id="updateContentField">
                        <label for="updateContent">Content</label>
                        <textarea class="form-control" id="updateContent" name="content"></textarea>
                    </div>

                    <!-- Q&A Specific Fields -->
                    <div class="form-group" id="updateQnaFields" style="display: none;">
                        <label for="updateQnaQuestion">Question</label>
                        <input type="text" class="form-control" id="updateQnaQuestion" name="qna_question">
                        <!-- Add other Q&A fields as needed -->
                    </div>

                    <!-- Polls Specific Fields -->
                    <div class="form-group" id="updatePollsFields" style="display: none;">
                        <label for="updatePollsQuestion">Question</label>
                        <input type="text" class="form-control" id="updatePollsQuestion" name="polls_question">

                        <label for="updateOption1">Option 1</label>
                        <input type="text" class="form-control" id="updateOption1" name="option1">

                        <label for="updateOption2">Option 2</label>
                        <input type="text" class="form-control" id="updateOption2" name="option2">
                        <!-- Add other Polls fields as needed -->
                    </div>

                    <!-- Add other specific fields for different announcement types -->

                    <button type="submit" class="btn btn-primary">Update Announcement</button>
                </form>
            </div>
        </div>
    </div>
</div>


{{-- <!-- Modal for Delete Announcement -->
<div class="modal fade" id="deleteAnnouncementModal" tabindex="-1" role="dialog" aria-labelledby="deleteAnnouncementModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteAnnouncementModalLabel">Delete Announcement</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete this announcement?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-danger" onclick="deleteAnnouncement()">Delete</button>
            </div>
        </div>
    </div>
</div> --}}

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

@if(session('success'))
    <script>
        // Call Swal for success message
        Swal.fire({
            title: 'Success!',
            text: '{{ session("success") }}',
            icon: 'success',
            confirmButtonColor: '#28a745', // You can customize the color
        });
    </script>
@endif

<script>
    
    // Add event listener for type change
    // Add event listener for type change
    document.getElementById('announcementType').addEventListener('change', function () {
        // Hide all fields
        document.getElementById('contentField').style.display = 'none';
        document.getElementById('qnaFields').style.display = 'none';
        document.getElementById('pollsFields').style.display = 'none'; // Hide pollsFields as well

        // Show fields based on the selected type
        if (this.value === 'text') {
            document.getElementById('contentField').style.display = 'block';
        } else if (this.value === 'qna') {
            document.getElementById('qnaFields').style.display = 'block';
        } else if (this.value === 'polls') {
            document.getElementById('pollsFields').style.display = 'block';
        }
        // Add other conditions for different types
    });



    
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


    // Close the dropdown if the user clicks outside of it
    window.addEventListener('click', function (event) {
        if (!event.target.matches('#dropdownToggle')) {
            var dropdown = document.getElementById('announcementType');
            if (dropdown.classList.contains('show')) {
                dropdown.classList.remove('show');
            }
        }
    });



    
var currentAnnouncementId;

function setAnnouncementId(announcementId) {
    currentAnnouncementId = announcementId;
}

function deleteAnnouncement(announcementId) {
    // Use SweetAlert to confirm the deletion
    setAnnouncementId(announcementId);
    Swal.fire({
        title: 'Are you sure?',
        text: 'You won\'t be able to revert this!',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if (result.isConfirmed) {
            // User confirmed, proceed with the deletion
            performDeleteAnnouncement();
        }
    });
}

function performDeleteAnnouncement() {
    // Find the clicked delete button and get the announcement ID
    announcementId = currentAnnouncementId;

    // Perform AJAX call to delete announcement
    $.ajax({
        url: "{{ route('class_delete_announcement') }}",
        method: 'POST',
        data: {
            _token: '{{ csrf_token() }}',
            announcementId: announcementId,
            // Add other data if needed
        },
        success: function (response) {
            if (response.success) {
                // Show success SweetAlert
                Swal.fire({
                    title: 'Success!',
                    text: 'Announcement deleted successfully!',
                    icon: 'success',
                    confirmButtonColor: '#28a745' // You can customize the color
                }).then(function () {
                    // Optionally, you can perform additional actions after the SweetAlert is closed
                    location.reload(); // This will reload the current page
                });
            } else {
                alert('Error deleting announcement: ' + response.message);
            }
        },
        error: function () {
            alert('Error deleting announcement');
        }
    });
}

// function deleteAnnouncement() {
//     // Find the clicked delete button and get the announcement ID
//     announcementId = currentAnnouncementId;
//     console.log(announcementId);
//     // Perform AJAX call to delete announcement
//     $.ajax({
//         url: "{{ route('class_delete_announcement') }}",
//         method: 'POST',
//         data: {
//             _token: '{{ csrf_token() }}',
//             announcementId: announcementId,
//             // Add other data if needed
//         },
//         success: function (response) {
//             if (response.success) {
//                 Swal.fire({
//                     title: 'Success!',
//                     text: 'Announcement deleted successfully!',
//                     icon: 'success',
//                     confirmButtonColor: '#28a745', // You can customize the color
//                 }).then(function () {
//                     // Close the deleteAnnouncementModal
//                     $('#deleteAnnouncementModal').modal('hide');
//                     location.reload(); // This will reload the current page
//                 });
//             } else {
//                 alert('Error deleting announcement: ' + response.message);
//             }
//         },
//         error: function () {
//             alert('Error deleting announcement');
//         }
//     });
// }

// Example function to open the update modal and populate form fields
function openUpdateModal(announcementId, announcementType, content, qnaQuestion, pollsQuestion, option1, option2) {
    // Set values for update form fields
    $('#updateAnnouncementId').val(announcementId);
    $('#updateAnnouncementType').val(announcementType);
    $('#updateContent').val(content);
    $('#updateQnaQuestion').val(qnaQuestion);
    $('#updatePollsQuestion').val(pollsQuestion);
    $('#updateOption1').val(option1);
    $('#updateOption2').val(option2);

    // Display the appropriate fields based on the announcement type
    toggleUpdateFields(announcementType);

    // Open the update modal
    $('#updateAnnouncementModal').modal('show');
}

function toggleUpdateFields(type) {
    // Hide all fields initially
    $('#updateAnnouncementType').hide();
    $('#updateContentField').hide();
    $('#updateQnaFields').hide();
    $('#updatePollsFields').hide();
    // Add other field IDs as needed

    // Show fields based on the announcement type
    switch (type) {
        case 'AnnText':
            $('#updateAnnouncementType').show();
            $('#updateContentField').show();
            break;
        case 'AnnQna':
            $('#updateAnnouncementType').show();
            $('#updateQnaFields').show();
            break;
        case 'AnnPolls':
            $('#updateAnnouncementType').show();    
            $('#updatePollsFields').show();
            break;
        // Add other cases for different announcement types
        default:
            // Handle other cases or throw an error
            break;
    }
}

// Function to open the update modal with existing announcement data
function openUpdateModal(announcementId) {
    // Make an AJAX request to get the announcement details

console.log(announcementId)
    $.ajax({
        url: "{{ route('get_announcement_details') }}",// Update the URL to match your Laravel route
        type: 'GET',
        data:{
            _token: '{{ csrf_token() }}',
            announcementId:announcementId,
        },
        success: function (response) {
            // Call a function to populate the modal with the retrieved data
            populateUpdateModal(response);
        },
        error: function (error) {
            console.error('Error fetching announcement details:', error);
        }
    });
}

// Function to populate the update modal with announcement data
function populateUpdateModal(response) {
    // Set values for update form fields
    var announcement = response.announcement;
    var details = response.details;
  

    console.log('Announcement:', announcement);
    // console.log('AnnText Content:', annTextContent);
    // console.log('AnnQna Question:', annQnaQuestion);
    // console.log('AnnPolls Question:', annPollsQuestion);

    
    $('#updateAnnouncementId').val(announcement.id);

  

    var type = announcement.type;

    // Populate specific fields based on announcement type
    switch (announcement.type) {
        case 'AnnText':
            $('#updateAnnouncementType').val('Text Announcement');
            $('#updateContent').val(details.annText.content);
            break;
        case 'AnnQna':
            $('#updateAnnouncementType').val('Q&A Announcement');
            $('#updateQnaQuestion').val(details.annQna.question);
            break;
        case 'AnnPolls':
            $('#updateAnnouncementType').val('Polls Announcement');
            $('#updatePollsQuestion').val(details.annPolls.question);
            $('#updateOption1').val(details.annPolls.option1);
            $('#updateOption2').val(details.annPolls.option2);
            break;
        // Add cases for other announcement types if needed
    }

    //Display the appropriate fields based on the announcement type
    toggleUpdateFields(announcement.type);

    // Open the update modal
   // $('#updateAnnouncementModal').modal('show');
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

</html>