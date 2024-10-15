$(document).ready(function() {
    // FullCalendar initialization
    $('#calendar').fullCalendar({
        header: {
            left: 'prev,next,today',
            center: 'title',
            right: 'month,agendaWeek,agendaDay'
        },
        selectable: true,   // Allows selecting a day or range of days
        editable: false,
        buttonText: {
            today: 'Today',
            month: 'Month',
            week: 'Week',
            day: 'Day'
        },
        events: 'schedule-module/fetch_schedule.php', // Fetch events from the database

        // Make individual days clickable
        //dayClick: function(date, jsEvent, view) {
            // Redirect or open modal for selected day
            //alert('Clicked on: ' + date.format());  // You can format the date as needed
        //},

        // Make events clickable
        eventClick: function(event, jsEvent, view) {
            jsEvent.preventDefault(); // Prevent default behavior

            // Show details in alert or open modal
            var start = event.start.format('YYYY-MM-DD HH:mm');
            var end = event.end ? event.end.format('YYYY-MM-DD HH:mm') : 'N/A';
            
            alert('Nurse ID: ' + event.title + '\nStart Time: ' + start + '\nEnd Time: ' + end);

        }
    });


    // Modal-related code

    // Get the modal, button, and close elements
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
});
