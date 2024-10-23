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
            var start = event.start.format('YYYY-MM-DD HH:mm');
            var end = event.end ? event.end.format('YYYY-MM-DD HH:mm') : 'N/A';
            alert(event.title + '\nStart Time: ' + start + '\nEnd Time: ' + end);
        }
    });
});

$(document).ready(function() {
    function fetchLogs() {
        $.ajax({
            url: 'fetch_logs.php',
            type: 'GET',
            dataType: 'json',
            success: function(response) {
                let logRows = '';
                if (response.length > 0) {
                    response.forEach(function(log) {
                        logRows += `<tr>
                            <td>${log.log_date_managed}</td>
                            <td>${log.log_time_managed}</td>
                            <td>${log.adm_fname} ${log.adm_lname}</td>
                            <td>${log.log_action}</td>
                            <td>${log.nurse_fname ? log.nurse_fname + ' ' + log.nurse_lname : 'N/A'}</td>
                            <td>${log.log_description}</td>
                        </tr>`;
                    });
                } else {
                    logRows = '<tr><td colspan="6">No Record Found.</td></tr>';
                }
                $('#tablerecords tbody').html(logRows);
            },
            error: function(xhr, status, error) {
                console.error('Error fetching logs:', error);
            }
        });
    }

    fetchLogs();

    setInterval(fetchLogs, 5000); 
});



    // Modal-related code
    var modal = document.getElementById("addScheduleModal");
    var btn = document.getElementById("addScheduleBtn");
    var span = document.getElementsByClassName("close")[0];

    // When the user clicks the button, open the modal
    btn.addEventListener("click", function() {
        modal.style.display = "block";
    });

    // When the user clicks on <span> (x), close the modal
    span.addEventListener("click", function() {
        modal.style.display = "none";
    });

    // When the user clicks anywhere outside of the modal, close it
    window.addEventListener("click", function(event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    });

    // Prevent context menu from appearing
    var message = "This function is not allowed here.";
    $(document).on("contextmenu", function(e) {
        alert(message);
        return false; 
    });
