// SCHEDULE MODULE-CARESHIFT

$(document).ready(function() {
    // Get nurse_id from URL parameters
    function getNurseIdFromUrl() {
        const urlParams = new URLSearchParams(window.location.search);
        return urlParams.get('nurse_id') || 'all'; // Default to 'all' if not set
    }

    var nurse_id = getNurseIdFromUrl(); // Fetch nurse_id from URL

    // Initialize FullCalendar with events for the selected nurse
    $('#calendar').fullCalendar({
        header: {
            left: 'prev,next,today',
            center: 'title',
            right: 'month,agendaWeek,agendaDay'
        },
        selectable: true,
        editable: false,
        buttonText: {
            today: 'Today',
            month: 'Month',
            week: 'Week',
            day: 'Day'
        },
        events: 'schedule-module/fetch_schedule.php?nurse_id=' + nurse_id, // Load events based on nurse_id from the URL
        eventRender: function(event, element) {
            element.attr('title', event.title);
        },
        eventClick: function(event, jsEvent, view) {
            // Clear existing values in the modal to avoid showing stale data
            $('#eventNurse').val('');
            $('#eventPosition').val('');
            $('#eventDepartment').val('');
            $('#eventStart').val('');
            $('#eventEnd').val('');
        
            // Populate modal content with the clicked event's data
            $('#eventNurse').val(event.title); // Set the nurse's name
            $('#eventPosition').val(event.position); // Set the nurse's position
            $('#eventDepartment').val(event.department); // Set the department
            $('#eventStart').val(event.start.format('MMMM D, YYYY h:mm A')); // Set the start date and time
            $('#eventEnd').val(event.end ? event.end.format('MMMM D, YYYY h:mm A') : 'N/A'); // Set the end date and time (if available)
        
            // Show the modal
            $('#viewScheduleModal').css('display', 'block');
        }
    });
}); // <-- Closing bracket for $(document).ready()

document.addEventListener("DOMContentLoaded", function() {
    const departmentSelect = document.getElementById("departmentSelect");
    const nurseCountElement = document.getElementById("nurse-count");

    if (departmentSelect) {
        departmentSelect.addEventListener("change", function() {
            const departmentId = departmentSelect.value;

            // Check if the department is "all"
            if (departmentId !== 'all') {
                // If a specific department is selected, fetch nurse count for that department
                fetch('reports-module/fetch_nurse_report.php?department=' + encodeURIComponent(departmentId))
                    .then(response => response.json())
                    .then(data => {
                        if (data.available_nurses !== undefined) {
                            nurseCountElement.textContent = data.available_nurses;
                        } else {
                            nurseCountElement.textContent = "Error: " + (data.message || "Unknown error");
                        }
                    })
                    .catch(error => {
                        console.error('Error fetching nurse data:', error);
                        nurseCountElement.textContent = 'Error fetching data.';
                    });
            } else {
                // If "All Departments" is selected, fetch total nurse count across all departments
                fetch('reports-module/fetch_nurse_report.php?department=all')
                    .then(response => response.json())
                    .then(data => {
                        if (data.available_nurses !== undefined) {
                            nurseCountElement.textContent = data.available_nurses;
                        } else {
                            nurseCountElement.textContent = "Error: " + (data.message || "Unknown error");
                        }
                    })
                    .catch(error => {
                        console.error('Error fetching nurse data for all departments:', error);
                        nurseCountElement.textContent = 'Error fetching data for all departments.';
                    });
            }
        });
    } else {
        console.error('Department select element not found.');
    }
}); // <-- Closing bracket for document.addEventListener("DOMContentLoaded")

document.addEventListener("DOMContentLoaded", function() {
    const leaveCountElement = document.getElementById("leave-count");

    // Function to fetch pending leave data
    function fetchLeaveReport() {
        // Fetch the count of pending leaves from fetch_leave_report.php
        fetch('reports-module/fetch_leave_report.php')
            .then(response => response.json())
            .then(data => {
                if (data.pending_leaves !== undefined) {
                    leaveCountElement.textContent = data.pending_leaves;
                } else {
                    leaveCountElement.textContent = "Error: " + (data.message || "Unknown error");
                }
            })
            .catch(error => {
                console.error('Error fetching leave data:', error);
                leaveCountElement.textContent = 'Error fetching leave data.';
            });
    }

    // Fetch leave count on page load
    fetchLeaveReport();
}); // <-- Closing bracket for document.addEventListener("DOMContentLoaded")

function redirectToSchedulePage() {
    var nurseId = document.getElementById('nurseSelect').value;
    if (nurseId) {
        // Redirect to the schedule page with the selected nurse_id
        window.location.href = "index.php?page=schedule&subpage=calendar&nurse_id=" + nurseId;
    }
} // <-- Closing bracket for redirectToSchedulePage

// Close modal button
$('#viewScheduleClose').on('click', function () {
    $('#viewScheduleModal').hide();
});

// Close the modal when clicking outside the modal content
$(window).on('click', function (event) {
    if ($(event.target).is('#viewScheduleModal')) {
        $('#viewScheduleModal').hide();
    }
});

// Modal behavior for adding schedules
var addScheduleModal = document.getElementById("addScheduleModal");
var addScheduleBtn = document.getElementById("addScheduleBtn");
var addScheduleClose = addScheduleModal.getElementsByClassName("close")[0];

addScheduleBtn.addEventListener("click", function () {
    addScheduleModal.style.display = "block";
});

addScheduleClose.addEventListener("click", function () {
    addScheduleModal.style.display = "none";
});

window.addEventListener("click", function (event) {
    if (event.target == addScheduleModal) {
        addScheduleModal.style.display = "none";
    }
}); // <-- Closing bracket for window.addEventListener("click")

$('#generateScheduleForm').submit(function(e) {
    e.preventDefault(); // Prevent page reload
    $.ajax({
        type: 'POST',
        url: 'schedule-module/generate_schedule.php', // Replace with your PHP script path
        data: $(this).serialize(),
        success: function(response) {
            // Assuming the PHP script returns a success or error message
            alert('Schedule generated successfully!');
            // You can update the calendar or do other things here
            location.reload(); // Optionally reload the page to see changes
        },
        error: function() {
            alert('Error: Could not generate the schedule');
        }
    });
}); // <-- Closing bracket for $('#generateScheduleForm').submit

// Modal behavior for generating schedules
var generateScheduleModal = document.getElementById("generateScheduleModal");
var generateScheduleBtn = document.getElementById("generateScheduleBtn");
var generateScheduleClose = generateScheduleModal.getElementsByClassName("close")[0];

generateScheduleBtn.addEventListener("click", function () {
    generateScheduleModal.style.display = "block";
});

generateScheduleClose.addEventListener("click", function () {
    generateScheduleModal.style.display = "none";
});

window.addEventListener("click", function (event) {
    if (event.target == generateScheduleModal) {
        generateScheduleModal.style.display = "none";
    }
}); // <-- Closing bracket for window.addEventListener("click")

// View schedules for a specific nurse
function viewSchedules(nurse_id) {
    fetch('schedule-module/fetch_schedule.php?nurse_id=' + nurse_id)
        .then(response => response.json())
        .then(data => {
            let scheduleTable = document.querySelector('#scheduleTable tbody');
            scheduleTable.innerHTML = ''; // Clear previous results
            data.forEach(schedule => {
                let row = `<tr>
                               <td>${schedule.sched_id}</td>
                               <td>${schedule.start_date}</td>
                               <td>${schedule.end_date}</td>
                               <td>${schedule.start_time}</td>
                               <td>${schedule.end_time}</td>
                           </tr>`;
                scheduleTable.insertAdjacentHTML('beforeend', row);
            });
            document.getElementById('scheduleModal').style.display = 'block';
        });
} // <-- Closing bracket for viewSchedules

function closeModal() {
    document.getElementById('scheduleModal').style.display = 'none';
} // <-- Closing bracket for closeModal

// "Select All Nurses" checkbox functionality
document.addEventListener('DOMContentLoaded', function () {
    const selectAllNurses = document.getElementById('selectAllNurses');
    const nurseCheckboxes = document.querySelectorAll('input[name="nurse_id[]"]:not(#selectAllNurses)');

    selectAllNurses.addEventListener('change', function () {
        nurseCheckboxes.forEach(function (checkbox) {
            checkbox.checked = selectAllNurses.checked;
        });
    });

    nurseCheckboxes.forEach(function (checkbox) {
        checkbox.addEventListener('change', function () {
            if (!checkbox.checked) {
                selectAllNurses.checked = false;
            }
            if (Array.from(nurseCheckboxes).every(checkbox => checkbox.checked)) {
                selectAllNurses.checked = true;
            }
        });
    });
}); // <-- Closing bracket for document.addEventListener('DOMContentLoaded')

$(document).on("contextmenu", function(e) {
    return false; 
}); // <-- Closing bracket for contextmenu event handler

function filterTable() {
    let searchInput = document.getElementById("search").value.toUpperCase();
    let table = document.getElementById("tablerecords");
    let tr = table.getElementsByTagName("tr");
    let recordFound = false;

    // Clear previous no record row if it exists
    let noRecordRow = document.getElementById("no-record-row");
    if (noRecordRow) {
        table.deleteRow(noRecordRow.rowIndex);
    }

    for (let i = 1; i < tr.length; i++) {
        let tdArray = tr[i].getElementsByTagName("td");
        let rowMatches = false;

        for (let j = 0; j < tdArray.length; j++) {
            if (tdArray[j] && tdArray[j].textContent.toUpperCase().includes(searchInput)) {
                rowMatches = true;
                break;
            }
        }

        tr[i].style.display = rowMatches ? "" : "none";
        if (rowMatches) {
            recordFound = true;
        }
    }

    // If no records are found, show "No record found"
    if (!recordFound) {
        noRecordRow = table.insertRow();
        noRecordRow.setAttribute("id", "no-record-row");
        let cell = noRecordRow.insertCell(0);
        cell.colSpan = 8; // Adjust based on the number of columns
        cell.textContent = "No record found.";
        cell.style.textAlign = "center";
    }
} // <-- Closing bracket for filterTable()

function navigateWeek(offset) {
    const url = new URL(window.location.href);
    url.searchParams.set('weekOffset', offset);
    window.location.href = url;
} // <-- Closing bracket for navigateWeek()

// Global variable to store scanned data
let scanData = '';

// Function to listen for the keydown event globally
document.addEventListener('keydown', function(event) {
    // Get the focused element (if any)
    const activeElement = document.activeElement;

    // Check if the key pressed is a valid character and if we're not focusing on an input field
    if (event.key.length === 1) {
        // If any input field is focused, prevent the character from being typed into that field
        if (activeElement && (activeElement.tagName.toLowerCase() === 'input' || activeElement.tagName.toLowerCase() === 'textarea')) {
            event.preventDefault();  // Prevent the scanner input from entering the focused field
        }

        // Capture the QR code input data
        scanData += event.key;
    } 
    else if (event.key === 'Enter') {
        // When the scanner sends the "Enter" key, process the scan data
        try {
            let data = JSON.parse(scanData);  // Attempt to parse the scan data as JSON
            if (data.nurse_id) {
                // Redirect to the page with the nurse_id
                const nurseId = data.nurse_id;
                window.location.href = `index.php?page=nurses&subpage=profile&id=${nurseId}`;
            } else {
                console.error("nurse_id not found in scanned data");
            }
        } catch (e) {
            console.error("Invalid JSON format", e);
        } finally {
            // Clear the scan data after processing
            scanData = '';
        }
    }
}); // <-- Closing bracket for keydown event listener
