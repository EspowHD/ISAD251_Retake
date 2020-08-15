<?php
    include_once "header.php";
    $_SESSION["UserID"] = "C1";
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
<link rel="stylesheet" href="CSS/FormPopup.css">
<link rel="stylesheet" href="CSS/RoundedButton.css">
<body>
<?php include "Page Parts/TopBar.php"; ?>
<br>
<h1 align="center" class ="title">Appointments and Deadline</h1>
<br>
<div id="container">
    <div id="appointmentsContainer">
        <h2 style="text-align:center">Appointments</h2>
        <button id="newApoointment" type="button" class="button" onclick="openNewAppointmentForm()">Add New Appointment</button>
    </div>
    <div id="deadlinesContainer">
        <h2 style="text-align:center">Deadlines</h2>
        <button id="newDeadline" type="button" class="button" onclick="openNewDeadlineForm()">Add New Deadline</button>
    </div>
</div>

<div class="form-popup" id="newAppointmentForm">
    <form class="form-container" method="POST" action="SchedulerEndpoint/createNewAppointment.php">
        <h1 class="title">New Appointment</h1>

        <label for="NAtitle"><b>Title</b></label>
        <input id="NAtitle" type="text" placeholder="Enter Title" name="NewAppointmentTitle" required>

        <label for="NAtime"><b>Time</b></label>
        <input id= "NAtime" type="datetime-local" name="NewAppointmentTime" required>

        <label for="NAlocation"><b>Location</b><label>
        <input id="NAlocation" type="text" placeholder="Enter Location(Optional)" name="NewAppointmentLocation">

        <label for="NAnotes"><b>Notes</b><label>
        <input id="NAnotes" type="text" placeholder="Enter Notes(Optional)" name="NewAppointmentNotes">

        <input class="btn input" name="Submit" type="submit" value="Add Event">
        <button type="button" class="btn cancel input" onclick="closeNewAppointmentForm()">Close</button>
        <script>
            document.getElementById("NAtime").value = new Date().toISOString().substring(0, 16);
        </script>
    </form>
</div>

<<div class="form-popup" id="newDeadlineForm">
    <form class="form-container" id="DeadlineFormContainer" method="post" action="SchedulerEndpoint/createNewDeadline.php">
        <h1 class="title">New Deadline</h1>

        <label for="NDtitle"><b>Title</b></label>
        <input id="NDtitle" type="text" placeholder="Enter Title" name="NewDeadlineTitle" required>

        <label for="NDtime"><b>Time</b></label>
        <input id= "NDtime" type="datetime-local" name="NewDeadlineTime" required>

        <label for="NDdescription"><b>Description</b><label>
        <input id="NDdescription" type="text" placeholder="Enter Description(Optional)" name="NewDeadlineDescription">

        <label for="NDcompleted"><b>Completed?</b><label>
        <input id="NDcompleted" type="checkbox" name="NewDeadlineCompleted">

        <input class="btn input" name="Submit" type="submit" value="Add Event">
        <button type="button" class="btn cancel input" onclick="closeNewDeadlineForm()">Close</button>
        <script>
            document.getElementById("NDtime").value = new Date().toISOString().substring(0, 16);
        </script>
    </form>
</div>
</body>
<script>
    $(document).ready(function() {
        //Load in Users Appointments
        $.ajax({
            url: 'SchedulerEndpoint/loadAppointments.php',
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
            url: 'SchedulerEndpoint/loadDeadlines.php',
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
            $(event).append('<p style="color: black; font-size: 16px;"><b>Time: </b>'+data[i].time.slice(0, -3)+'</p>');
            var location = data[i].location;
            if(data[i].location == null || data[i].location == "") location = "N/A"
            $(event).append('<p style="color: black; font-size: 16px;"><b>Location: </b>'+location+'</p>');
            var notes = data[i].notes;
            if(data[i].notes == null || data[i].notes == "") notes = "N/A"
            $(event).append('<p style="color: black; font-size: 16px;"><b>Notes: </b>'+notes+'</p>');

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
            $(event).append('<h3 style="text-align:left">'+data[i].title+'</h3>');
            $(event).append('<p style="color: black; font-size: 16px;"><b>Time: </b>'+data[i].time.slice(0, -3)+'</p>');
            if(data[i].hasOwnProperty('child')) $(event).append('<p style="color: black; font-size: 16px;"><b>Child: </b>'+data[i].child+'</p>');
            $(event).append('<p style="color: black; font-size: 16px;"><b>Description: </b>'+data[i].description+'</p>');
            var status;
            if(data[i].completed === 1) status = "Completed";
            else status = "Incomplete";
            $(event).append('<p style="color: black; font-size: 16px;"><b>Status: </b>'+status+'</p>');
            $(deadlinesContainer).append(event);
        }
    }
    function openNewAppointmentForm(){
        document.getElementById("newAppointmentForm").style.display = "block"
        document.getElementById("newApoointment").disabled = true;
        document.getElementById("newDeadline").disabled = true;
    }
    function closeNewAppointmentForm(){
        document.getElementById("newAppointmentForm").style.display = "none";
        document.getElementById("newApoointment").disabled = false;
        document.getElementById("newDeadline").disabled = false;
    }
    function openNewDeadlineForm(){
        document.getElementById("newDeadlineForm").style.display = "block"
        document.getElementById("newApoointment").disabled = true;
        document.getElementById("newDeadline").disabled = true;
    }
    function closeNewDeadlineForm(){
        document.getElementById("newDeadlineForm").style.display = "none";
        document.getElementById("newApoointment").disabled = false;
        document.getElementById("newDeadline").disabled = false;
    }
</script>
