$(document).ready(function() {
    $('#calendar').fullCalendar({
        header: {
            left: 'prev,today,next',
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
        events: 'schedule-module/fetch_schedule.php'
    });
});