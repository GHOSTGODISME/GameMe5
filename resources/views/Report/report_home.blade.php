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
    font-size: 18px; /* Adjust the font size as needed */
    display: flex;
    align-items: start;
    margin:0;
    padding: 0;
    
  }

  .action-menu {
    position: absolute;
    top: 100%;
    right: 0;
    background-color: #D9D9D9;
    box-shadow: 0px 8px 16px 0px rgba(0, 0, 0, 0.2);
    z-index: 1;
    display: none;
    width:100px;

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
  

</style>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<div class = title_bar>
    <div class="sub_cont">
        <h1 class="admin_subtitle3">Report</h1>
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
        </tr>
    </thead>
    <tbody>
        @foreach ($sessionData as $report)
            <tr>
                <td class="bordered">{{ $loop->index + 1 }}</td>
                <td class="bordered"><a href="{{ route('report_specify', ['reportId' => $report->id]) }}">{{ $report->quiz->title }}</a></td>
                <td class="bordered">{{ $report->created_at }}</td>
                <td class="bordered">{{ $report->lecturer->user->name }}</td>
                <td class="button-container">
                    <div class="menu-icon" onclick="toggleMenu(this)">
                        <img src="img/threedot_icon.png" alt="three_dot">
                    </div>
                    <div class="action-menu">
                        <a href="#" class="update-button" onclick="printPage('{{ $report->id }}')">Print</a>
                    </div>
                </td>
            </tr>
        @endforeach 
    </tbody>
</table>


<script>
       function toggleMenu(icon) {
      const menu = icon.nextElementSibling;
      menu.style.display = menu.style.display === 'block' ? 'none' : 'block';
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
</script>






@endsection