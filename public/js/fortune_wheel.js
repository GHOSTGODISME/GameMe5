$(document).ready(function() {
    $('.edit-icon').click(function() {
        $('#editFortuneWheelTitle').val($('#fortune-wheel-title').val());
        $('#editModal').modal('show');
    });

    $('#saveChanges').click(function() {
        var editedTitle = $('#editFortuneWheelTitle').val();
        if (editedTitle.trim() === '') {
            alert('Title cannot be empty. Please enter a title.');
            return;
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
            updateWheelSegmentsFromEntries();
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

function changeMode() {
    const modeSelector = document.getElementById("modeSelector");
    const selectedValue = modeSelector.value;

    const standard = document.getElementById("standard");
    const wheel = document.getElementById("wheel");

    if (selectedValue === "standard") {
        standard.style.display = "block";
        wheel.style.display = "none";
    } else if (selectedValue === "wheel") {
        standard.style.display = "none";
        wheel.style.display = "block";
    }
}

/////// for fortune wheel -- the actual wheel
const canvas = document.getElementById('fortuneWheel');
let theWheel = null;
const segments = [];
const segmentColor = [
    '#88AB8E', '#AFC8AD', '#EEE7DA', '#F2F1EB',
    '#5F6F52', '#A9B388', '#FEFAE0', '#B99470'
];

function startSpin() {
    theWheel.stopAnimation(false);
    theWheel.rotationAngle = 0;
    theWheel.draw(canvas);
    theWheel.animation.spins = 8;
    theWheel.startAnimation();
}

function alertPrize(indicatedSegment) {
    const selectedEntry = theWheel.getIndicatedSegment();
    if (selectedEntry) {
        // Remove the selected entry from the entries list
        const indexToRemove = fw.entries.indexOf(selectedEntry.text);
        if (indexToRemove !== -1) {
            fw.entries.splice(indexToRemove, 1);
            updateEntriesUI();
        }

        fw.results.push(selectedEntry.text);
        updateResultsUI();
    }

    Swal.fire({
        title: 'Congratulations!',
        text: selectedEntry.text + ' has been selected.',
        icon: 'success',
    });
}


function updateWheelSegmentsFromEntries() {
    const segments = [];
    if (fw.entries && Array.isArray(fw.entries)) {
        fw.entries.forEach((entry, index) => {
            segments.push({
                'text': entry,
                'fillStyle': segmentColor[index % segmentColor.length]
            });
        });
    }
    theWheel = new Winwheel({
        'numSegments': segments.length,
        'outerRadius': 200,
        'segments': segments,
        'responsive': true,
        'animation': {
            'type': 'spinToStop',
            'duration': 5,
            'spins': 8,
            'callbackFinished': alertPrize
        }
    });

    theWheel.draw(canvas);
}

function removeSegment(selectedEntry) {
    theWheel.deleteSegment(selectedEntry.text);
    theWheel.draw(canvas);
}

// Function to update entries in the UI
function updateEntriesUI() {
    const entriesTextArea = $('#entries_contentholder');
    entriesTextArea.val(fw.entries.join('\n'));
    countEntriesResults('entries_contentholder', 'entries_count');
    updateWheelSegmentsFromEntries();
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
        const isConfirmed = confirm('Are you sure you want to save the wheel?');

        // If the user confirms, proceed with saving the wheel
        if (isConfirmed) {
            fw.title = $('#fortune-wheel-title').val();

            const fortuneWheelId = $('#fortune-wheel-id').val();
            $.ajax({
                url: '/save-fortune-wheel',
                method: 'POST',
                contentType: 'application/json',
                data: JSON.stringify(fw),
                success: function(response) {
                    ori_fw = fw;
                    console.log('Wheel saved successfully');
                    window.location.href = "/fortune-wheel-main";
                    // history.back();
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
    function handlePaste(e, updatedFields) {
        const pasteData = e.originalEvent.clipboardData.getData('text');
        const entries = pasteData.split(/[,|]/).map(entry => entry.trim());
        const validEntries = entries.filter(entry => entry !== "");

        if (updatedFields === "entries") {
            fw.entries = [...fw.entries, ...validEntries];
            updateEntriesUI();
        } else if (updatedFields === "results") {
            fw.results = [...fw.results, ...validEntries];
            updateResultsUI();
        }

        e.preventDefault();
    }

    $('#entries_contentholder').on('paste', function(e) {
        handlePaste(e, "entries");
    });

    $('#results_contentholder').on('paste', function(e) {
        handlePaste(e, "results");
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
    const entries = fw.entries;
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
            
            Swal.fire({
                title: 'Congratulations!',
                text: selectedEntry + ' has been selected.',
                icon: 'success',
            });

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

                //clear the file input if successfully read the data
                $('#excel_file_input').val('');

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
    $('#usage-instructions').toggle();
});


function compareObject(obj1, obj2) {
    // Check if both inputs are objects
    if (typeof obj1 !== 'object' || typeof obj2 !== 'object') {
        return false;
    }

    // Get the keys of the objects
    const keys1 = Object.keys(obj1);
    const keys2 = Object.keys(obj2);

    if (keys1.length !== keys2.length) {
        return false;
    }

    for (const key of keys1) {
        const val1 = obj1[key];
        const val2 = obj2[key];

        if (typeof val1 === 'object' && typeof val2 === 'object') {
            const objectsEqual = compareObject(val1, val2);
            if (!objectsEqual) {
                return false;
            }
        } else if (val1 !== val2) {
            return false;
        }
    }
    return true;
}


window.addEventListener('beforeunload', function(e) {
    if (!compareObject(ori_fw, fw)) {
        e.preventDefault();
        e.returnValue = '';
        return 'Are you sure you want to leave? Your changes may not be saved.';
    }
});