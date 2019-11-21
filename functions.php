<?php
/* This function returns events by date. */
function getCalendarEvents($con, $date = ""){

    // sets the default variables
    $events = "";

    // gets the passed date or today's date 
    $date = $date ? date("Y-m-d", strtotime($date)) : date("Y-m-d");

    // gets the events of the selected or current date
    $query = 
    "SELECT `event_id`, `location`, `event_type`, `company_topic`
    FROM `djm50117`.`events`
    WHERE `date` = '{$date}'";
    $results = mysqli_query($con, $query);

    // checks if one or more rows is returned
    if (mysqli_num_rows($results) > 0) {
        
        // loops through all the records and adds each event as a list item
        while($row = mysqli_fetch_array($results)) { 
            $events .= "<tr><td>{$row["location"]}</td><td>{$row["event_type"]}</td><td>{$row["company_topic"]}</td></tr>";
        }
        
        // displays existing events
        echo 
        "<legend>Events on " . date("l, d M Y", strtotime($date)) . "</legend>
        <table>
            <thead><tr>
			<th>Location</th>
			<th>Event Type</th>
			<th>Company/Topic</th>
			</tr></thead>
            {$events}
        </table>";
    }
}

/* This function gets a calendar. */
function getCalendar($con, $year = "", $month = "") {
    
    // sets the default variables
    $dates = "";
    $dateYear = ($year != "") ? $year : date("Y"); // stores the passed in year or current year
    $dateMonth = ($month != "") ? $month : date("m"); // stores the passed in month or current month
    $date = $dateYear . "-" . $dateMonth . "-01"; // sets the date to the first day of the specified month and year
    $startDay = date("N", strtotime($date)); // sets the starting day of the week for the first day of the month
    $totalDays = cal_days_in_month(CAL_GREGORIAN, $dateMonth, $dateYear); // sets the total days of the specified month and year
    $startBoxes = ($startDay == 7) ? ($totalDays) : ($totalDays + $startDay); // sets the total number of calendar boxes including empty beginning boxes
    $allBoxes = ($startBoxes <= 35) ? 35 : 42; // sets the total number of calendar boxes including empty ending boxes
    $dayCount = 1; // starts the day count at 1
    
    // loops through the total number of calendar date boxes including empty ones
    for($i = 1; $i <= $allBoxes; $i++) {
        
        // checks if the calendar boxes should have a date
        if(($i >= $startDay + 1 || $startDay == 7) && $i <= ($startBoxes)){
            
            // sets the current date and sets the blank date class
            $currentDate = $dateYear . "-" . $dateMonth . "-" . $dayCount;
            $dateClass = "";
            
            // gets the events of the current date and sets the event count
            $query = "SELECT `event_id`
                      FROM `djm50117`.`events`
                      WHERE `date` = '{$currentDate}'";
            $results = mysqli_query($con, $query);
            $eventCount = mysqli_num_rows($results);
            
            // checks if one or more events were returned
            if ($eventCount > 0) {
                
                // sets the date class and total events
                $dateClass = (strtotime($currentDate) == strtotime(date("Y-m-d"))) ? "calendar-both" : $dateClass = "calendar-event";
                $total = "<div class='total-events'>{$eventCount} Events</div>";
            
            // checks if the date is today
            } else if (strtotime($currentDate) == strtotime(date("Y-m-d"))) {
                
                // sets the date class and total events
                $dateClass = "calendar-today";
                $total = "<div class='total-events'>Today</div>";
                
            // sets the total events to blank for all other dates
            } else {
                $total = "";
            }
            
            // adds each date to the date variable and increases the count
            $dates .= "<li date='{$currentDate}' class='{$dateClass} calendar-date'><span>{$dayCount}</span>{$total}</li>";
            $dayCount++;
            
        // sets empty boxes if the calendar box doesn't have a date
        } else {
            $dates .= "<li class='no-date'><span></span></li>";
        }
    }
    
    // creates a variable that stores the calendar nav bar for moving back a month, changing the month, changing the year, or moving forward a month; then it displays the days and dates on the calendar
    $calendar = "
        <div class='calendar'>
            <div class='calendar-nav'>
                <a onclick='getCalendar('calendar','" . date("Y", strtotime($date . " - 1 Month")) . "', '" . date("m", strtotime($date . " - 1 Month")) . "');'><</a>
                <select id='calendar-month'>" . getMonths($dateMonth) . "</select>
                <select id='calendar-year'>" . getYears($dateYear) . "</select>
                <a onclick='getCalendar('calendar','" . date("Y", strtotime($date . " + 1 Month")) . "', '" . date("m", strtotime($date . " + 1 Month")) . "');'>></a>
            </div>
            <div class='calendar-days'>
                <ul>
                    <li>Sun</li>
                    <li>Mon</li>
                    <li>Tue</li>
                    <li>Wed</li>
                    <li>Thu</li>
                    <li>Fri</li>
                    <li>Sat</li>
                </ul>
            </div>
            <div class='calendar-dates'>
                <ul>{$dates}</ul>
            </div>
            <div class='clear'></div>
        </div>";
    return $calendar;
}

/* This function gets a list of years */
function getYears($year = ""){

    // sets the default options variable
    $options = "";

    // gets the years between today's year plus or minus 5 years
    for($i = date("Y") - 5; $i <= date("Y") + 5; $i++) {

        // checks for the selected year and returns each year
        $selected = ($i == $year) ? "selected" : "";
        $options .= "<option value='{$i}' {$selected}>{$i}</option>";
    }
    return $options;
}

/* This function gets a list of months. */
function getMonths($month = "") {

    // sets the default options variable
    $options = "";

    // loops through the 12 months
    for ($i = 1; $i <= 12; $i++) {

        // checks for the selected month and returns each month
        $selected = ($i == $month) ? "selected" : "";
        $options .= "<option value='{$i}' {$selected}>" . date("F", mktime(0, 0, 0, $i + 1, 0, 0)) . "</option>";
    }
    return $options;
}
?>

<!DOCTYPE html>
<html>
<head>
<style>
table, th, td {
     border: 1px solid black;
  	 border-collapse: collapse;
     padding: 5px;
     background-color: #f2f2f2;
}
</style>
</head>
<center>
<body>