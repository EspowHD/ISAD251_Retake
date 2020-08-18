<?php
    include_once "header.php";
    $_SESSION["UserID"] = "C1";
    $_SESSION["UserName"] = "test";
?>
<head>
    <title>View Appointments and Deadlines</title>
</head>
<link rel="stylesheet" href="CSS/SplitContainer.css">
<link rel="stylesheet" href="CSS/FormPopup.css">
<link rel="stylesheet" href="CSS/RoundedButton.css">
<link rel="stylesheet" href="CSS/SelectMenus.css">
<body>
<?php include "Page Parts/TopBar.php"; ?>
<br>
<h1 align="center" class ="title">Appointments and Deadline</h1>
<br>
<div class="SplitContainer">
    <div id="appointmentsContainer" class = "leftContainer" style="width: 50%">
        <h2 style="text-align:center;">Appointments</h2>
        <form id="appointmentControls" class="form-inline" >
            <button id="newApoointment" class="button" onclick="openNewAppointmentForm()" role="button"
                <?php if(strpos($_SESSION["UserID"], "C") !== false):?> data-toggle="tooltip" title="Only Parents can use this" disabled<?php endif; ?>>Add New Appointment</button>
            <label style="font-size: 14px">Selected: </label>
            <select name="Appointments" class="select-css" id="selectedAppointment">
            </select>
            <button id="editAppointment" class="button" onclick="openEditAppointmentForm()" role="button"
                <?php if(strpos($_SESSION["UserID"], "C") !== false):?> data-toggle="tooltip" title="Only Parents can use this" disabled<?php endif; ?>>Edit Appointment</button>
            <button id="deleteAppointment" class="button" onclick="deleteData('appointment')" role="button"
                <?php if(strpos($_SESSION["UserID"], "C") !== false):?> data-toggle="tooltip" title="Only Parents can use this" disabled<?php endif; ?>>Delete Appointment</button>
        </form>
    </div>
    <div id="deadlinesContainer" class="rightContainer" style="width: 50%">
        <h2 style="text-align:center">Deadlines</h2>
        <form id="deadlineControls" class="form-inline" >
            <button id="newDeadline" class="button" onclick="openNewDeadlineForm()" role="button"
                <?php if(strpos($_SESSION["UserID"], "P") !== false):?> data-toggle="tooltip" title="Only Children can use this" disabled<?php endif; ?>>Add New Deadline</button>
            <label style="font-size: 14px">Selected: </label>
            <select name="Deadlines" class="select-css" id="selectedDeadline" >
            </select>
            <button id="editDeadline" class="button" onclick="openEditDeadlineForm()" role="button"
                <?php if(strpos($_SESSION["UserID"], "P") !== false):?> data-toggle="tooltip" title="Only Children can use this" disabled<?php endif; ?>>Edit Deadline</button>
            <button id="deleteDeadline" class="button" onclick="deleteData('deadline')" role="button"
                <?php if(strpos($_SESSION["UserID"], "P") !== false):?> data-toggle="tooltip" title="Only Children can use this" disabled<?php endif; ?>>Delete Deadline</button>
        </form>
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

        <label for="NDdescription"><b>Description</b></label>
        <input id="NDdescription" type="text" placeholder="Enter Description(Optional)" name="NewDeadlineDescription">

        <label for="NDcompleted" style="display: inline-block"><b>Completed?</b><input id="NDcompleted" style="display: inline-block" type="checkbox" name="NewDeadlineCompleted"></label>


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
                insertDataFromJSON(data,'#appointmentsContainer');
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
                insertDataFromJSON(data,$('#deadlinesContainer'));
            },
            error: function (request, status, error) {
                alert("REQUEST:\t" + request + "\nSTATUS:\t" + status +
                    "\nERROR:\t" + error);
            }
        });
    });
    $(function() {
        var prevSelect = $('#selectedAppointment').val();
        var thisSelect = $('#selectedAppointment').val();
        updateSelected(prevSelect,thisSelect);
        $('#selectedAppointment').change(function() {
            prevSelect = thisSelect;
            thisSelect = $(this).val();
            updateSelected(prevSelect,thisSelect);
        });
    });
    $(function() {
        var prevSelect = $('#selectedDeadline').val();
        var thisSelect = $('#selectedDeadline').val();
        updateSelected(prevSelect,thisSelect);
        $('#selectedDeadline').change(function() {
            prevSelect = thisSelect;
            thisSelect = $(this).val();
            updateSelected(prevSelect,thisSelect);
        });
    });

    function insertDataFromJSON(data,container) {
        for(let i = 0; i<=Object.keys(data).length-1; i++)
        {
            var event = $(document.createElement('div')).css({
                padding: '5px', margin: '20px', border: '1px dashed',
                borderTopColor: '#999', borderBottomColor: '#999',
                borderLeftColor: '#999', borderRightColor: '#999'
            });
            $(event).attr('id', data[i].id);
            $(event).append('<h3 style="text-align:left">'+data[i].title+' ID: '+data[i].id+'</h3>');
            $(event).append('<p style="color: black; font-size: 16px;"><b>Time: </b>'+data[i].time.slice(0, -3)+'</p>');
            var opt = document.createElement('option');
            opt.appendChild( document.createTextNode(data[i].title+' ID: '+data[i].id) );
            opt.value = data[i].id;
            if(data[i].id.includes("A")) {
                var location = data[i].location;
                if (data[i].location == null || data[i].location == "") location = "N/A"
                $(event).append('<p style="color: black; font-size: 16px;"><b>Location: </b>' + location + '</p>');
                var notes = data[i].notes;
                if (notes == "" || notes == null) notes = "N/A";
                $(event).append('<p style="color: black; font-size: 16px;"><b>Notes: </b>' + notes + '</p>');
                document.getElementById("selectedAppointment").appendChild(opt);
            }
            else{
                if (data[i].hasOwnProperty('child')) $(leftContainer).append('<p style="color: black; font-size: 16px;"><b>Child: </b>' + data[i].child + '</p>');
                var description = data[i].description;
                if (description == "") description = "N/A";
                $(event).append('<p style="color: black; font-size: 16px;"><b>Description: </b>' + description + '</p>');
                var status;
                if (data[i].completed === 1) status = "Completed";
                else status = "Incomplete";
                $(event).append('<p style="color: black; font-size: 16px;"><b>Status: </b>' + status + '</p>');
                document.getElementById("selectedDeadline").appendChild(opt);
            }
            $(container).append(event);
        }
    }
    function openNewAppointmentForm(){
        document.getElementById("newAppointmentForm").style.display = "block"
        document.getElementById("newApoointment").disabled = true;
    }
    function closeNewAppointmentForm(){
        document.getElementById("newAppointmentForm").style.display = "none";
        document.getElementById("newApoointment").disabled = false;
    }
    function openNewDeadlineForm(){
        document.getElementById("newDeadlineForm").style.display = "block"
        document.getElementById("newDeadline").disabled = true;
    }
    function closeNewDeadlineForm(){
        document.getElementById("newDeadlineForm").style.display = "none";
        document.getElementById("newDeadline").disabled = false;
    }
    function updateSelected(previousSelected,newSelected){
        if(previousSelected != null)document.getElementById(previousSelected).style.border = "1px dashed";
        if(newSelected != null)document.getElementById(newSelected).style.border = "2px solid";
    }
    function deleteData(type){
        var e;
        var id;
        if(type == "deadline"){
            e = document.getElementById("selectedDeadline");
        } else{
            e = document.getElementById("selectedAppointment");
        }
        id = e.options[e.selectedIndex].value;
        if(confirm("Are you sure you want to remove this record?"))
        {
            console.log("Deleting "+id);
            $.ajax({
                url:"SchedulerEndpoint/delete.php",
                type:"POST",
                data:{id:id}
            })
        }
    }
</script>
