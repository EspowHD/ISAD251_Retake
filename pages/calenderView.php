<?php
    include_once "header.php";
    $_SESSION["UserID"] = "P1";
    $_SESSION["UserName"] = "test";
?>
<head>
    <title>View Appointments and Deadlines</title>
</head>
<style type="text/css">
    * {margin: 0; padding: 0;}
    #container {height: 100%; width:100%; font-size: 0;}
    #appointmentsContainer, #deadlinesContainer {display: inline-block; *display: inline; zoom: 1; vertical-align: top;}
    #appointmentsContainer {width: 50%;}
    #deadlinesContainer {width: 50%;}
</style>
<body>
<?php include "Page Parts/TopBar.php"; ?>
<br>
<h1 align="center" class ="title">Appointments and Deadline</h1>
<br>
<div id="main">
    <input type="button" id="btRemove" value="Remove Element" class="bt" />
    <input type="button" id="btRemoveAll" value="Remove All" class="bt" /><br />
</div>
<div id="container">
    <div id="appointmentsContainer">
        <h2 style="text-align:center">Appointments</h2>
        <button type="button" class="btn cancel input" onclick="createNewEvent("Appointment")">Add New Appointment</button>
        <button
    </div>
    <div id="deadlinesContainer">
        <h2 style="text-align:center">Deadlines</h2>
        <button type="button" class="btn cancel input" onclick="createNewEvent("Deadline")">Add New Deadline</button>
    </div>
</div>
<div class="form-popup" id="newActivityForm">
</div>
</body>

<script>
    $(document).ready(function() {
        //Load in Users Appointments
        $.ajax({
            url: 'CalenderEndpoint/loadAppointments.php',
            type: 'GET',
            dataType: 'json',
            success: function (data) {
                insertAppointmentsFromJSON(data,'#appointmentsContainer');
            },
            error: function (request, status, error) {
                alert("REQUEST:\t" + request + "\nSTATUS:\t" + status +
                    "\nERROR:\t" + error);
            }
        });
        //Load in Users Deadlines
        $.ajax({
            url: 'CalenderEndpoint/loadDeadlines.php',
            type: 'GET',
            dataType: 'json',
            success: function (data) {
                insertDeadlinesFromJSON(data,$('#deadlinesContainer'));
            },
            error: function (request, status, error) {
                alert("REQUEST:\t" + request + "\nSTATUS:\t" + status +
                    "\nERROR:\t" + error);
            }
        });
    });

    function insertAppointmentsFromJSON(data,appointmentsContainer) {
        for(let i = 0; i<=Object.keys(data).length-1; i++)
        {
            var event = $(document.createElement('div')).css({
                padding: '5px', margin: '20px', border: '1px dashed',
                borderTopColor: '#999', borderBottomColor: '#999',
                borderLeftColor: '#999', borderRightColor: '#999'
            });
            $(event).append('<h3 style="text-align:left">'+data[i].title+'</h3>');
            $(event).append('<p style="color: black; font-size: 16px;"><b>Time: </b>'+data[i].time+'</p>');
            $(event).append('<p style="color: black; font-size: 16px;"><b>Location: </b>'+data[i].location+'</p>');
            $(event).append('<p style="color: black; font-size: 16px;"><b>Notes: </b>'+data[i].notes+'</p>');

            $(appointmentsContainer).append(event);
        }
    }

    function insertDeadlinesFromJSON(data,deadlinesContainer) {
        for(let i = 0; i<=Object.keys(data).length-1; i++)
        {
            var event = $(document.createElement('div')).css({
                padding: '5px', margin: '20px', border: '1px dashed',
                borderTopColor: '#999', borderBottomColor: '#999',
                borderLeftColor: '#999', borderRightColor: '#999'
            });
            event.setAttribute("id",data[i].id);
            $(event).append('<h3 style="text-align:left">'+data[i].title+'</h3>');
            $(event).append('<p style="color: black; font-size: 16px;"><b>Time: </b>'+data[i].time+'</p>');
            if(data[i].hasOwnProperty('child')) $(event).append('<p style="color: black; font-size: 16px;"><b>Child: </b>'+data[i].child+'</p>');
            $(event).append('<p style="color: black; font-size: 16px;"><b>Description: </b>'+data[i].description+'</p>');
            var status;
            if(data[i].completed === 1) status = "Completed";
            else status = "Incomplete";
            $(event).append('<p style="color: black; font-size: 16px;"><b>Status: </b>'+status+'</p>');
            $(deadlinesContainer).append(event);
        }
    }

    function createNewEvent(type){
    //Create Necessary divs
    var EventFormContainer = $(document.createElement('div'));
    //Set attributes for above divs
    EventFormContainer.setAttribute("class","form-container");
    $(EventFormContainer).append('<h1 class="title">New '+type+'</h1>');

    $(EventFormContainer).append('<label for="title"><b>Title</b></label>');
    $(EventFormContainer).append('<input id="title" type="text" placeholder="Enter Title" name="EventTitle" required>');

    $(EventFormContainer).append('<label for="time"><b>Time</b></label>');
    $(EventFormContainer).append('<input id= "time" type="datetime-local" name="EventTime" value="'+new Date().toISOString().substring(0, 16)+'" required>');
    document.getElementById("startTime").value = new Date().toISOString().substring(0, 16);

    $(EventFormContainer).append('<label for="location"><b>Location</b><label>');
    $(EventFormContainer).append('<input id="location" type="text" placeholder="Enter Location(Optional)" name="EventLocation">');
    if(type === "Appointment") {
        $(EventFormContainer).append('<label for="notes"><b>Notes</b><label>');
        $(EventFormContainer).append('<input id="notes" type="text" placeholder="Enter Notes(Optional)" name="EventNotes">');
    } else if(type === "Deadline") {

        $(EventFormContainer).append('<label for="description"><b>Description</b><label>');
        $(EventFormContainer).append('<input id="description" type="text" placeholder="Enter Description(Optional)" name="EventDescription">');

        $(EventFormContainer).append('<label for="completed"><b>Completed?</b><label>');
        $(EventFormContainer).append('<input id="completed" type="checkbox" name="EventCompleted">');

    }
    $(EventFormContainer).append('<input class="btn input" name="Submit" type="submit" value="Add Event">');
    $(EventFormContainer).append('<button type="button" class="btn cancel input" onclick="">Close</button>');
    $('#newActivityForm').append(EventFormContainer);
    }
</script>
