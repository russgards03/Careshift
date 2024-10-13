<div class="content_wrapper">
    <div class="heading">
        <h1><i class="fas fa-solid fa-clock"></i>&nbspSchedule</h1>
        <a href="index.php?page=schedule&subpage=add-sched" class="right_button"><i class="fa fa-plus"></i>&nbspAdd Schedule</a>
        <a href="index.php?page=schedule&subpage=calendar" class="right_button"><i class="fa fa-calendar"></i>&nbspCalendar</a>
    </div>
</div>
<?php
    $subpage = isset($_GET['subpage']) ? $_GET['subpage'] : 'calendar';

    switch($subpage){
        case 'add-sched':
            require_once 'add_schedule.php';
        break;
        case 'calendar':
            require_once 'calendar.php';
        break; 
        default:
            require_once 'calendar.php';
        break;
    }
?>
