CREATE PROCEDURE insert_Parent 
@FirstNameIn VARCHAR(16),
@LastNameIn VARCHAR(16)
AS
SET NOCOUNT ON
INSERT INTO [dbo].[Parent]
           ([PFirstName]
           ,[PLastName])
     VALUES
           (@FirstNameIn
           ,@LastNameIn)
GO

CREATE PROCEDURE insert_Child 
@FirstNameIn VARCHAR(16),
@LastNameIn VARCHAR(16)
AS
SET NOCOUNT ON
INSERT INTO [dbo].[Child]
           ([CFirstName]
           ,[CLastName])
     VALUES
           (@FirstNameIn
           ,@LastNameIn)
GO

CREATE PROCEDURE insert_Appointment 
@ParentIDIn INT,
@AppointmentTimeIn DATETIME,
@AppointmentLocationIn VARCHAR(140),
@NotesIn VARCHAR(140),
@AppointmentTitleIn VARCHAR(32)
AS
SET NOCOUNT ON
INSERT INTO [dbo].[Appointments]
           ([ParentID]
           ,[AppointmentTime]
           ,[AppointmentLocation]
           ,[Notes]
           ,[AppointmentTitle])
     VALUES
           (@ParentIDIn,
            @AppointmentTimeIn,
            @AppointmentLocationIn,
            @NotesIn,
            @AppointmentTitleIn)
GO

CREATE PROCEDURE insert_Deadline
@ChildIDIn INT,
@DeadlineTitleIn VARCHAR(32),
@DeadlineTimeIn DATETIME,
@DeadlineDescriptionIn VARCHAR(140),
@DeadlineCompletedIn BIT
AS
SET NOCOUNT ON
INSERT INTO [dbo].[Deadlines]
           ([ChildID]
           ,[DeadlineTitle]
           ,[DeadlineTime]
           ,[DeadlineDescription]
           ,[DeadlineCompleted])
     VALUES
           (@ChildIDIn,
            @DeadlineTitleIn,
            @DeadlineTimeIn,
            @DeadlineDescriptionIn,
            @DeadlineCompletedIn)
GO

CREATE PROCEDURE insert_Parent_To_Child 
@ChildIDIn INT,
@ParentIDIn INT
AS
SET NOCOUNT ON
DECLARE @Parent1Set BIT
SET @Parent1Set = 0;
UPDATE [dbo].[Child]
 SET ParentID1 = @ParentIDIn, @Parent1Set = 1
 WHERE ChildID = @ChildIDIn and ParentID1 IS NULL;
IF @Parent1Set = 0
UPDATE [dbo].[Child]  SET ParentID2 = ISNULL(ParentID2,@ParentIDIn) WHERE ChildID = @ChildIDIn;
GO

CREATE PROCEDURE get_Parent_Appointment_Calender_Info
@ParentIDIn INT
AS
SELECT AppointmentTitle as Title, AppointmentTime as 'Time',AppointmentID as ID
FROM Appointments
WHERE @ParentIDIn = Appointments.ParentID
Order by AppointmentTime
GO

CREATE PROCEDURE get_Parents_Child_Calender_Info
@ParentIDIn INT
AS
SELECT DeadlineTitle as Title, DeadlineTime as 'Time',DeadlineID as ID
FROM Deadlines,Child
WHERE (@ParentIDIn = Child.ParentID1 OR @ParentIDIn = Child.ParentID2) AND Child.ChildID = Deadlines.ChildID
Order by DeadlineTime
GO

CREATE PROCEDURE get_Childs_Deadline_Calender_Info
@ChildIDIn INT
AS
SELECT DeadlineTitle as Title, DeadlineTime as 'Time',DeadlineID as ID
FROM Deadlines
WHERE @ChildIDIn = Deadlines.ChildID
Order by DeadlineTime
GO

CREATE PROCEDURE get_Childs_Parent_Calender_Info
@ChildIDIn INT
AS
SELECT AppointmentTitle as Title, AppointmentTime as 'Time',AppointmentID as ID
FROM Appointments,Child
WHERE (Appointments.ParentID = Child.ParentID1 OR Appointments.ParentID = Child.ParentID2) AND Child.ChildID = @ChildIDIn
Order by AppointmentTime
GO