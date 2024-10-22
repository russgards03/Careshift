$(document).ready(function() {
    // Initialize FullCalendar with all events initially
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
        events: 'schedule-module/fetch_schedule.php?nurse_id=all', // Load all events initially
        eventRender: function(event, element) {
            element.attr('title', event.title);
        },
        eventClick: function(event, jsEvent, view) {
            var start = event.start.format('YYYY-MM-DD HH:mm');
            var end = event.end ? event.end.format('YYYY-MM-DD HH:mm') : 'N/A';
            alert(event.title + '\nStart Time: ' + start + '\nEnd Time: ' + end);
        }
    });

    $('#nurseSelect').on('change', function() {
        var nurse_id = this.value; // Get the selected nurse ID
        console.log('Selected Nurse ID:', nurse_id); // Debugging output
        
        // Remove all current events from the calendar
        $('#calendar').fullCalendar('removeEvents');

        // Fetch new events based on the selected nurse
        $.ajax({
            url: 'schedule-module/fetch_schedule.php',
            type: 'GET',
            data: { nurse_id: nurse_id }
        })
        .done(function(events) {
            // Ensure the response is in JSON format
            if (Array.isArray(events)) {
                console.log('Fetched events:', events); // Debugging output
                $('#calendar').fullCalendar('addEventSource', events);
            } else {
                console.error("Unexpected response format:", events);
            }
        })
        .fail(function(xhr, status, error) {
            console.error("Failed to fetch events: ", error);
        });
    });
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
