<?php
    include_once "header.php";
    include_once  "Page Parts/TopBar.php";
?>
<head>
    <script>
        $(document).ready(function() {
            var calendar = $('#calendar').fullCalendar({
                editable:false,
                header:{
                    left:'prev,next today',
                    center:'title',
                    right:'month,agendaWeek,agendaDay'
                },

                events: 'FINISH THIS',
                displayEventTime:true,
                displayEventEnd:true,
                selectable:true,
                selectHelper:true,
                aspectRatio: 1.5,
                select: function openNewActivity(){
                    //INSERT Event editing functionality here
                },

                eventClick:function(event)
                {
                    //INSERT Event deletion functionality here
                },

            });
        });
    </script>
    <link rel="stylesheet" href="../css/ActivityForm.css">
</head>
<?php include "Page Parts/TopBar.php"; ?>
<body class="lightbody">
<h2 align="center" class ="title">Appointments and Deadlines</h2>
<br />
<div class="container">
    <div id="calendar"></div>
</div>
</body>
</html>
