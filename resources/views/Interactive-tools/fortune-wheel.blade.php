 {{-- <!-- 

interaction tools - fortune wheel
- spin function - done
- crud entries - done
- crud results - done
- remove selected entry to result tab - done
- add data via excel - done
- shuffle function - done
- sort function (sort in alphabetical and anti) - done
- shuffle and sort ui - done
- help feature - done **maybe keep updated to latest update
- add data via direct copy - done

tdl
- spin visual - pending // did simple, pending for better, try to do wheel version due to name
- utilize php code - pending
- better ui (i guess?? - pending
 -->  --}}

 <!DOCTYPE html>
 <html lang="en">

 <head>
     <meta charset="utf-8">
     <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
     <meta name="csrf-token" content="{{ csrf_token() }}">

     <title>fyp</title>

     <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet"
         integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
     <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

     {{-- <link rel="stylesheet" href="css/interactive_tools_style.css" /> --}}
     <link rel="stylesheet" href="{{ asset('css/interactive_tools_style.css') }}">


     <!-- import ROBOTO font -->
     <style>
         @import url('https://fonts.googleapis.com/css2?family=Roboto&display=swap');
     </style>

     <!-- import xlsx library to process input data from excel -->
     <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.1/xlsx.full.min.js"></script>

     <style>
         .header {
             height: 125px;
             background: url("{{ asset('img/staff_header.png') }}");
             display: flex;
             align-items: center;
             justify-content: space-between;
             background-size: cover;
         }

         .logo {
             margin-left: 35px;
         }

         .menu {
             margin-right: 35px;
         }
     </style>


 </head>

 <body>
     <div class="header">
         <div class="logo">
             <a href="#"><img src="{{ asset('img/logo_header.png') }}"alt="Logo"></a>
         </div>
         <div class="menu">
             <a href="#"><img src="{{ asset('img/menu.png') }}" alt="Menu"></a>
         </div>

         <button id="save-wheel-button" class="btn btn-primary">Save Wheel</button>
     </div>
     <!-- Add this hidden input field to store the Fortune Wheel's ID -->
     <input type="hidden" id="fortune-wheel-id" name="fortuneWheel[id]" value="{{ $fortuneWheel->id ?? '' }}">

     <p class="interactive_tool_title">Fortune Wheel</p>
     <input type="text" class="form-control" id="fortune-wheel-title" name="fortuneWheel[title]"
         value="{{ $fortuneWheel->title ?? '' }}" required>

     <div class="container">
         <div class="row">
             <div class="col-md-6 col-xl-7" style="padding: 50px;">
                 <div id="result-box" class="box"></div>
                 <button class="btn interactive_btn" id="spin-button" type="button">Spin</button>
             </div>

             <div class="col-md-6 col-xl-5" style="padding: 50px;">
                 <div class="card fortune_wheel_card"></div>
                 <div>
                     <ul class="nav nav-tabs" role="tablist">
                         <li class="nav-item" role="presentation"><a class="nav-link active" role="tab"
                                 data-bs-toggle="tab" href="#tab-1">Entries</a></li>
                         <li class="nav-item" role="presentation"><a class="nav-link" role="tab"
                                 data-bs-toggle="tab" href="#tab-2"><span
                                     style="color: rgb(33, 37, 41);">Results</span></a></li>
                     </ul>
                     <div class="tab-content">
                         <div class="tab-pane active" role="tabpanel" id="tab-1">
                             <div class="btn-group d-flex justify-content-center" role="group"
                                 id="roulette_action_btn">
                                 <button id="shuffle-button" class="btn" type="button">
                                     <img src="{{ asset('img/shuffle.png') }}">Shuffle</button>
                                 <button id="sort-button" class="btn" type="button">
                                     <img src="{{ asset('img/sort.png') }}">Sort</button>
                             </div>
                             <form>
                                 <label for="entries_contentholder"></label>
                                 <textarea class="contentholder" id="entries_contentholder" name="fortuneWheel[entries]">{{ implode("\n", $fortuneWheel->entries ?? []) }}</textarea>
                             </form>
                         </div>
                         <div class="tab-pane fade" role="tabpanel" id="tab-2">
                             <form>
                                 <label for="results_contentholder"></label>
                                 <textarea class="contentholder" id="results_contentholder" name="fortuneWheel[results]">{{ implode("\n", $fortuneWheel->results ?? []) }}</textarea>
                             </form>
                         </div>
                     </div>


                     <div class="input_container">
                         <label for="excel_file_input"></label>
                         <input type="file" id="excel_file_input" accept=".xlsx"
                             title="Only XLSX files are supported">
                     </div>

                     <button id="help-button" class="btn" type="button">Not sure how to use it?</button>
                     <div id="usage-instructions">
                         Currently this program support 2 types of input <br>
                         1. Direct copy <br>
                         1.1 You may direct copy and paste the entries into the Entries tab. <br>
                         1.2 It also support single line data input, where the data is being saperated using "," or "|"
                         as delimiters. <br>
                         1.3 It will be processed automatically, and display as individual entry. <br>
                         <br>
                         2. File upload - Excel <br>
                         2.1. Create a XLSX or Excel file.<br>
                         2.2. Make sure you entered the data under the "Name" column.<br>
                         2.3. Upload the file.
                     </div>

                 </div>
                 <button id="import-button" class="btn interactive_btn" type="button">
                     <i class="fas fa-upload" style="margin-right: 20px;"></i>Import Data</button>
             </div>
         </div>
     </div>

     <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
     <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
         integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous">
     </script>

     <script>
         const fw = @json($fortuneWheel);

         console.log(fw);
         // Function to update entries in the UI
         function updateEntriesUI() {
             const entriesTextArea = $('#entries_contentholder');
             entriesTextArea.val(fw.entries.join('\n'));
         }

         // Function to update results in the UI
         function updateResultsUI() {
             const resultsTextArea = $('#results_contentholder');
             resultsTextArea.val(fw.results.join('\n'));
         }


         $(document).ready(function(e) {
             $.ajaxSetup({
                 headers: {
                     'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                 }
             });

             updateEntriesUI();
             updateResultsUI();

             // Click event for the "Save Wheel" button
             $('#save-wheel-button').click(function() {
                 // Prompt for confirmation
                 const isConfirmed = confirm('Are you sure you want to save the wheel?');

                 // If the user confirms, proceed with saving the wheel
                 if (isConfirmed) {
                     // Perform an AJAX request to update the data on the server
                     fw.title = $('#fortune-wheel-title').val();

                     const fortuneWheelId = $('#fortune-wheel-id').val();
                     const url = fortuneWheelId ? `/update-fortune-wheel/${fortuneWheelId}` :
                         '/create-fortune-wheel';

                     console.log("fortuneWheelId " + fortuneWheelId);
                     console.log(fw);

                     $.ajax({
                         url: url,
                         method: 'POST',
                         data: {
                             fortuneWheel: fw,
                             _token: $('meta[name="csrf-token"]').attr('content')
                         },
                         success: function(response) {
                             console.log('Wheel saved successfully');
                             // You can perform additional actions or display a message on success
                            //  location.reload(); // Reload the page
                            history.back();
                         },
                         error: function(error) {
                             console.error('Error saving wheel:', error);
                             // Handle the error if needed
                         }
                     });
                 } else {
                     // User canceled the save operation
                     console.log('Save operation canceled by user');
                 }
             });



             // Function to handle copy-paste inputs with delimiters
             function processCopyPasteData(pasteData) {
                 // Split the pasted data by delimiters "," and "|"
                 const entries = pasteData.split(/[,|]/).map(entry => entry.trim());

                 // Filter out any empty entries
                 const validEntries = entries.filter(entry => entry !== "");

                 // Update the FortuneWheel entries
                 fw.entries = [...fw.entries, ...validEntries];

                 // Update the UI
                 updateEntriesUI();
             }

             // Handle paste events on the textarea
             $('#entries_contentholder').on('paste', function(e) {
                 const pasteData = e.originalEvent.clipboardData.getData('text');
                 processCopyPasteData(pasteData);
                 e.preventDefault(); // Prevent the default paste behavior
             });

         });

         var entriesTextArea = $('#entries_contentholder');
         // Attach an input event listener to the textarea
         entriesTextArea.on('input', function() {
             // Get the current value of the textarea and split it into an array
             var entries = entriesTextArea.val().split('\n').filter(entry => entry.trim() !== '');

             // Assuming fw is your object where you want to store the entries
             fw.entries = entries;

             // You can do additional things here if needed

             // Log the updated entries to the console (for testing purposes)
             console.log('Updated entries:', fw.entries);
         });

         var resultTextArea = $('#results_contentholder');

         // Attach an input event listener to the textarea
         resultTextArea.on('input', function() {
             // Get the current value of the textarea and split it into an array
             var results = resultTextArea.val().split('\n').filter(result => result.trim() !== '');

             // Assuming fw is your object where you want to store the results
             fw.results = results;

             // You can do additional things here if needed

             // Log the updated results to the console (for testing purposes)
             console.log('Updated results:', fw.results);
         });


         function shuffleArray(array) {
             for (let i = array.length - 1; i > 0; i--) {
                 const j = Math.floor(Math.random() * (i + 1));
                 [array[i], array[j]] = [array[j], array[i]];
             }
         }

         // Click event for the Shuffle button
         $('#shuffle-button').click(function() {
             // Shuffle the entries in FortuneWheel
             shuffleArray(fw.entries);

             // Update the UI
             updateEntriesUI();
         });

         let isSortedAlphabetically = false;

         // Click event for the Sort button
         $('#sort-button').click(function() {
             console.log('sort clicked'); // Check if this message appears in the browser console

             const entries = fw.entries;
             console.log(fw.entries);
             if (isSortedAlphabetically) {
                 // Sort the entries in reverse (anti-alphabetically)
                 entries.sort((a, b) => b.localeCompare(a));
                 isSortedAlphabetically = false;
             } else {
                 // Sort the entries alphabetically
                 entries.sort();
                 isSortedAlphabetically = true;
             }


             // Update the textarea with sorted entries
             updateEntriesUI();

         });

         // Function to randomly select and move an entry to Results
         $('#spin-button').click(function() {
             const entriesTextArea = $('#entries_contentholder');
             //const resultsTab = $('#results_contentholder');
             const resultBox = $('#result-box');

             fw.entries = entriesTextArea.val().split('\n').filter(entry => entry.trim() !== '');
             const entries = fw.entries;
             var selectedEntry = null;
             var randomIndex = 0;

             if (entries.length > 0) {
                 let spinDuration = 3000; // 5 seconds
                 let spinInterval = 100; // Update result every 100ms

                 let spinTimer = setInterval(function() {
                     // Randomly select an entry
                     randomIndex = Math.floor(Math.random() * entries.length);
                     selectedEntry = entries[randomIndex];

                     // Update the result-box with the selected entry
                     resultBox.text(selectedEntry);
                 }, spinInterval);

                 // Stop the spin after the specified duration
                 setTimeout(function() {
                     clearInterval(spinTimer); // Stop the spinning
                     // Display the selected name
                     alert('Selected: ' + selectedEntry);

                     // Remove the selected name from Entries
                     entries.splice(randomIndex, 1);

                     // Update the FortuneWheel results
                     fw.results.push(selectedEntry);

                     // Update the UI
                     updateResultsUI();
                     updateEntriesUI();

                 }, spinDuration);
             } else {
                 alert('No more entries to pick.');
             }


         });

         // to import data from excel with column name of "name", case-insensitive
         $('#import-button').click(function() {
             // Get the selected file
             const fileInput = document.getElementById('excel_file_input');
             const file = fileInput.files[0];

             if (file) {
                 const reader = new FileReader();
                 reader.onload = function(e) {
                     const data = e.target.result;
                     const workbook = XLSX.read(data, {
                         type: 'binary'
                     });

                     // Assuming you have a sheet called 'Sheet1'
                     const sheetName = workbook.SheetNames[0];
                     const worksheet = workbook.Sheets[sheetName];

                     // Convert the worksheet data to an array of objects
                     const excelData = XLSX.utils.sheet_to_json(worksheet, {
                         header: 1,
                         raw: false
                     });

                     // Find the "name" column (case-insensitive search)
                     const headerRow = excelData[0].map(header => header ? header.toLowerCase() :
                         header); // Convert headers to lowercase
                     const nameColumnIndex = headerRow.indexOf('name');

                     // Extract the data from the "name" column and remove empty rows
                     const nameColumnData = [];
                     excelData.slice(1).forEach(row => {
                         if (row[nameColumnIndex] !== undefined && row[nameColumnIndex] !==
                             null && row[nameColumnIndex] !== '') {
                             nameColumnData.push(row[nameColumnIndex]);
                         }
                     });

                     // Update the FortuneWheel entries
                     fw.entries = [...fw.entries, ...nameColumnData];

                     // Update the UI
                     updateEntriesUI();

                 };
                 reader.readAsBinaryString(file);
             }
         });

         // Show usage instructions when the "Not sure how to use it?" link is clicked
         $('#help-button').click(function() {
             console.log('Button clicked'); // Check if this message appears in the browser console
             $('#usage-instructions').toggle(); // Toggle the visibility of the message
         });

         //// tdl: if user directly paste the name, need check with delimiters [ , | ] 
     </script>

 </body>

 </html>
