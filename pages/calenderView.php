<?php
    include_once "header.php";
?>
<head>
    <!--<link rel="stylesheet" href="../css/ActivityForm.css">-->
    <title>View Upcoming Events</title>
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
    </div>
    <div id="deadlinesContainer">
        <h2 style="text-align:center">Deadlines</h2>
    </div>
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
</script>
