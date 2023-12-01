@extends('Layout/interactive_tools_master')
<meta name="csrf-token" content="{{ csrf_token() }}">



@section('content')
    <style scoped>
        .nav-link {
            font-size: 18px;
        }
    </style>

    <div class="save-btn-container">
        <button id="save-wheel-button" class="btn btn-dark">Save Wheel</button>
    </div>

    <!-- Add this hidden input field to store the Fortune Wheel's ID -->
    <input type="hidden" id="fortune-wheel-id" name="fortuneWheel[id]" value="{{ $fortuneWheel->id ?? '' }}">


    <div class="container">
        <div class="input-group">
            <span class="edit-icon" style="cursor: pointer;">
                <div style="display: flex; align-items: center; justify-content: center; gap:20px;">
                    <input type="text" class="form-control" id="fortune-wheel-title" name="fortuneWheel[title]"
                        placeholder="Fortune Wheel Title" value="{{ $fortuneWheel->title ?? '' }}" readonly required>
                    <button class="btn btn-dark" style="font-size: 18px; padding: 10px" type="button"
                        data-bs-toggle="modal" data-bs-target="#editModal"><i class="fa fa-edit"></i></button>
                </div>
            </span>
        </div>

        <div class="row">
            <div class="col-md-6 col-xl-7 container-style">
                <div id="result-box" class="box">Press "Spin" to start</div>
                <button class="btn btn-dark interactive_btn" id="spin-button" type="button"
                    style="padding: 10px 50px;">Spin</button>
            </div>

            <div class="col-md-6 col-xl-5 container-style">
                <div class="card fortune_wheel_card"></div>
                <div>
                    <ul class="nav nav-tabs" role="tablist">
                        <li class="nav-item" role="presentation"><a class="nav-link active" role="tab"
                                data-bs-toggle="tab" href="#tab-1">Entries (<span id="entries_count"></span>)</a></li>
                        <li class="nav-item" role="presentation"><a class="nav-link" role="tab" data-bs-toggle="tab"
                                href="#tab-2"><span style="color: rgb(33, 37, 41);">Results (<span
                                        id="results_count"></span>)</span></a></li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active" role="tabpanel" id="tab-1">
                            <div class="btn-group d-flex justify-content-center" role="group" id="roulette_action_btn">
                                <button id="shuffle-button" class="btn" type="button">
                                    <img src="{{ asset('img/shuffle.png') }}">Shuffle</button>
                                <button id="sort-button" class="btn" type="button">
                                    <img src="{{ asset('img/sort.png') }}">Sort</button>
                            </div>
                            <form>
                                <label for="entries_contentholder"></label>
                                <textarea class="contentholder form-control" id="entries_contentholder" name="fortuneWheel[entries]">{{ implode("\n", $fortuneWheel->entries ?? []) }}</textarea>
                            </form>
                        </div>
                        <div class="tab-pane fade" role="tabpanel" id="tab-2">
                            <form>
                                <label for="results_contentholder"></label>
                                <textarea class="contentholder form-control" id="results_contentholder" name="fortuneWheel[results]">{{ implode("\n", $fortuneWheel->results ?? []) }}</textarea>
                            </form>
                        </div>
                    </div>


                    <div class="input_container">
                        <input type="file" id="excel_file_input" class="form-control" accept=".xlsx"
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
                <button id="import-button" class="btn btn-dark interactive_btn" style="display: none;" type="button">
                    <i class="fas fa-upload" style="margin-right: 20px;"></i>Import Data</button>
            </div>
        </div>
    </div>


    <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content" style="padding: 25px;">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Edit Fortune Wheel Title</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p class="m-0"><b class="required">Title</b></p>
                    <input type="text" class="form-control" id="editFortuneWheelTitle"
                        placeholder="Fortune Wheel Title">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="saveChanges">Save changes</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous">
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.1/xlsx.full.min.js"></script>

    <script>
        $(document).ready(function() {
            $('.edit-icon').click(function() {
                $('#editFortuneWheelTitle').val($('#fortune-wheel-title').val());
                $('#editModal').modal('show');
            });

            $('#saveChanges').click(function() {
                var editedTitle = $('#editFortuneWheelTitle').val();
                if (editedTitle.trim() === '') {
                    alert('Title cannot be empty. Please enter a title.');
                    return; // Prevents the modal from closing if the title is empty
                }

                $('#fortune-wheel-title').val(editedTitle);
                $('#editModal').modal('hide');
            });

            $('#editModal').on('click', '[data-dismiss="modal"]', function() {
                $('#editModal').modal('hide');
            });

            $('#entries_contentholder').on('input keypress', function(e) {
                if (e.type === 'input' || e.key === 'Enter') {
                    var entries = $('#entries_contentholder').val().split('\n').filter(entry => entry
                    .trim() !== '');
                    fw.entries = entries;

                    updateEntriesCount();
                }
            });

            $('#results_contentholder').on('input keypress', function(e) {
                if (e.type === 'input' || e.key === 'Enter') {
                    var results = $('#results_contentholder').val().split('\n').filter(result => result
                        .trim() !== '');
                    fw.results = results;

                    updateResultsCount();
                }
            });



        });

        // class FortuneWheel{
        //     constructor(object){
        //         this.title = object.title;
        //         this.entries = object.entries;
        //         this.results = object.result;
        //     }
        // }

        // const fw = new FortuneWheel(@json($fortuneWheel));

        const fw = @json($fortuneWheel);
        console.log(fw);

        // Function to update entries in the UI
        function updateEntriesUI() {
            const entriesTextArea = $('#entries_contentholder');
            entriesTextArea.val(fw.entries.join('\n'));
            countEntriesResults('entries_contentholder', 'entries_count');
        }

        function updateEntriesCount() {
            countEntriesResults('entries_contentholder', 'entries_count');
        }

        function updateResultsCount() {
            countEntriesResults('results_contentholder', 'results_count');
        }

        // Function to update results in the UI
        function updateResultsUI() {
            const resultsTextArea = $('#results_contentholder');
            resultsTextArea.val(fw.results.join('\n'));
            countEntriesResults('results_contentholder', 'results_count');
        }

        function countEntriesResults(textAreaId, countAreaId) {
            const textArea = $('#' + textAreaId);
            const text = textArea.val() || '';
            const lines = text.split('\n');

            const count = lines.filter(line => line.trim() !== '').length;
            const countArea = $('#' + countAreaId);
            countArea.text(count);
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
                    fw.title = $('#fortune-wheel-title').val();

                    const fortuneWheelId = $('#fortune-wheel-id').val();
                    //  const url = fortuneWheelId ? `/update-fortune-wheel/${fortuneWheelId}` :
                    //      '/create-fortune-wheel';


                    console.log(JSON.stringify(fw));

                    $.ajax({
                        url: '/save-fortune-wheel',
                        method: 'POST',
                        contentType: 'application/json',
                        data: JSON.stringify(fw),
                        //  data: {
                        //     fortuneWheel: fw
                        //  },
                        success: function(response) {
                            console.log('Wheel saved successfully');
                            history.back();
                        },
                        error: function(error) {
                            console.error('Error saving wheel:', error);
                        }
                    });
                } else {
                    // User canceled the save operation
                    console.log('Save operation canceled by user');
                }
            });



            // Function to handle copy-paste inputs with delimiters
            function processCopyPasteData(pasteData, updatedFields) {
                const entries = pasteData.split(/[,|]/).map(entry => entry.trim());
                const validEntries = entries.filter(entry => entry !== "");

                if (updatedFields === "entries") {
                    fw.entries = [...fw.entries, ...validEntries];
                    updateEntriesUI();
                } else if (updatedFields === "results") {
                    fw.results = [...fw.results, ...validEntries];
                    updateResultsUI();
                }
            }

            // Handle paste events on the textarea
            $('#entries_contentholder').on('paste', function(e) {
                const pasteData = e.originalEvent.clipboardData.getData('text');
                processCopyPasteData(pasteData, "entries");
                e.preventDefault();
            });

            $('#results_contentholder').on('paste', function(e) {
                const pasteData = e.originalEvent.clipboardData.getData('text');
                processCopyPasteData(pasteData, "results");
                e.preventDefault();
            });


        });

        var entriesTextArea = $('#entries_contentholder');
        // Attach an input event listener to the textarea
        entriesTextArea.on('input', function() {
            var entries = entriesTextArea.val().split('\n').filter(entry => entry.trim() !== '');
            fw.entries = entries;
        });

        var resultTextArea = $('#results_contentholder');

        // Attach an input event listener to the textarea
        resultTextArea.on('input', function() {
            var results = resultTextArea.val().split('\n').filter(result => result.trim() !== '');
            fw.results = results;
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
            const resultBox = $('#result-box');

            fw.entries = entriesTextArea.val().split('\n').filter(entry => entry.trim() !== '');
            const entries = fw.entries;
            var selectedEntry = null;
            var randomIndex = 0;

            if (entries.length > 0) {
                let spinDuration = 3000; // 3s
                let spinInterval = 100; // for each 100ms, spin once

                let spinTimer = setInterval(function() {
                    // Randomly select an entry
                    randomIndex = Math.floor(Math.random() * entries.length);
                    selectedEntry = entries[randomIndex];

                    // Update the result-box with the selected entry
                    resultBox.text(selectedEntry);
                }, spinInterval);

                // Stop the spin after the specified duration
                setTimeout(function() {
                    clearInterval(spinTimer);
                    // Display the selected name
                    alert(selectedEntry + "!!!");

                    // Remove the selected name from Entries and put into result
                    entries.splice(randomIndex, 1);
                    fw.results.push(selectedEntry);

                    // Update the UI
                    updateResultsUI();
                    updateEntriesUI();

                }, spinDuration);
            } else {
                alert('No more entries to pick.');
            }


        });

        // Function to control the visibility of import button
        $('#excel_file_input').change(function() {
            const fileInput = document.getElementById('excel_file_input');
            const file = fileInput.files[0];

            // if file is uploaded, show the btn, else hide
            if (file) {
                $('#import-button').show();
            } else {
                $('#import-button').hide();
            }
        });

        // to import data from excel with column name of "name", case-insensitive
        $('#import-button').click(function() {
            // Get the selected file
            const fileInput = document.getElementById('excel_file_input');
            const file = fileInput.files[0];

            if (file) {
                // Check if the file type is an Excel file (xlsx)
                const validExtensions = ['xlsx', 'xls'];
                const fileExtension = file.name.split('.').pop().toLowerCase();

                if (validExtensions.includes(fileExtension)) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        const data = e.target.result;
                        const workbook = XLSX.read(data, {
                            type: 'binary'
                        });

                        // for the first sheet
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

                        if (nameColumnIndex === -1) {
                            alert("The 'Name' heading is not being founded in the Excel.\n" +
                                "Please ensure you have included the data under the 'Name' column");
                        }
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
                } else {
                    alert("Invalid document format. Please ensure you are uploading an Excel file (XLSX or XLS).");
                }
            } else {
                alert("Please select an Excel file to import.");
            }
        });

        // Show usage instructions when the "Not sure how to use it?" link is clicked
        $('#help-button').click(function() {
            console.log('Button clicked'); // Check if this message appears in the browser console
            $('#usage-instructions').toggle(); // Toggle the visibility of the message
        });
    </script>
@endsection
