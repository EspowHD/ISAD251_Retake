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
           ,@LastNameIn);
SELECT SCOPE_IDENTITY() AS IDENTITY_COLUMN_NAME
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
           ,@LastNameIn);
SELECT SCOPE_IDENTITY() AS IDENTITY_COLUMN_NAME
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

CREATE PROCEDURE get_Parent_Appointment_Info
@ParentIDIn INT
AS
SELECT AppointmentTitle as Title,
AppointmentTime as 'Time',
AppointmentID as ID,
AppointmentLocation as 'Location',
Notes as 'Notes'
FROM Appointments
WHERE @ParentIDIn = Appointments.ParentID
Order by AppointmentTime
GO

CREATE PROCEDURE get_Parents_Child_Info
@ParentIDIn INT
AS
SELECT DeadlineTitle as Title,
 CONCAT(Child.CFirstName,' ',Child.CLastName) as 'Child',
 DeadlineTime as 'Time',
 DeadlineDescription as 'Description',
 DeadlineCompleted as 'Completed',
 DeadlineID as ID
FROM Deadlines,Child
WHERE (@ParentIDIn = Child.ParentID1 OR @ParentIDIn = Child.ParentID2) AND Child.ChildID = Deadlines.ChildID
Order by DeadlineTime
GO

CREATE PROCEDURE get_Childs_Deadline_Info
@ChildIDIn INT
AS
SELECT DeadlineTitle as Title,
 CONCAT(Child.CFirstName,' ',Child.CLastName) as 'Child',
 DeadlineTime as 'Time',
 DeadlineDescription as 'Description',
 DeadlineCompleted as 'Completed',
 DeadlineID as ID
FROM Deadlines
WHERE @ChildIDIn = Deadlines.ChildID
Order by DeadlineTime
GO

CREATE PROCEDURE get_Childs_Parent_Info
@ChildIDIn INT
AS
SELECT AppointmentTitle as Title,
AppointmentTime as 'Time',
AppointmentID as ID,
AppointmentLocation as 'Location',
Notes as 'Notes'
FROM Appointments,Child
WHERE (Appointments.ParentID = Child.ParentID1 OR Appointments.ParentID = Child.ParentID2) AND Child.ChildID = @ChildIDIn
Order by AppointmentTime
GO

CREATE PROCEDURE edit_Deadline
@DeadlineIDIn INT,
@DeadlineTitleIn VARCHAR(32),
@DeadlineTimeIn DATETIME,
@DeadlineDescriptionIn VARCHAR(140),
@DeadlineCompletedIn BIT
AS
UPDATE Deadlines
    SET DeadlineTitle = @DeadlineTitleIn
           ,DeadlineTime = @DeadlineTimeIn
           ,DeadlineDescription = @DeadlineDescriptionIn
           ,DeadlineCompleted = @DeadlineCompletedIn
    WHERE  DeadlineID = @DeadlineIDIn
GO

CREATE PROCEDURE edit_Appointment
@AppointmentIDIn INT,
@AppointmentTimeIn DATETIME,
@AppointmentLocationIn VARCHAR(140),
@NotesIn VARCHAR(140),
@AppointmentTitleIn VARCHAR(32)
AS
UPDATE Appointments
    SET AppointmentTitle = @AppointmentTitleIn
           ,AppointmentTime = @AppointmentTimeIn
           ,AppointmentLocation = @AppointmentLocationIn
           ,Notes = @NotesIn
    WHERE  AppointmentID = @AppointmentIDIn
GO

CREATE PROCEDURE delete_Deadline
@DeadlineIDIn INT
AS
DELETE FROM Deadlines WHERE DeadlineID = @DeadlineIDIn
GO

CREATE PROCEDURE delete_Appointment
@AppointmentIDIn INT
AS
DELETE FROM Appointments WHERE AppointmentID = @AppointmentIDIn
GO

CREATE PROCEDURE get_Parent_Login
@ParentIDIn INT
AS
SELECT PFirstName AS FirstName,
PLastName AS LastName
FROM Parent
WHERE ParentID = @ParentIDIn
GO

CREATE PROCEDURE get_Child_Login
@ChildIDIn INT
AS
SELECT CFirstName AS FirstName,
CLastName AS LastName
FROM Child
WHERE ChildID = @ChildIDIn
GO

CREATE PROCEDURE get_last_ChildID
AS
SELECT MAX(ChildID) AS LastID FROM Child
GO

CREATE PROCEDURE get_last_ParentID
AS
SELECT MAX(ParentID) AS LastID FROM Parent
GO