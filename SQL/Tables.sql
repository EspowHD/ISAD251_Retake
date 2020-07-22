IF OBJECT_ID(N'dbo.Parent', N'U') IS NULL BEGIN  
CREATE TABLE Parent(
    ParentID int IDENTITY(1,1) NOT NULL PRIMARY KEY,
    PFirstName varchar(16) NOT NULL,
    PLastName varchar(16) NOT NULL
);
END

IF OBJECT_ID(N'dbo.Child', N'U') IS NULL BEGIN  
CREATE TABLE Child(
    ChildID int IDENTITY(1,1) NOT NULL PRIMARY KEY,
    ParentID1 int FOREIGN KEY REFERENCES Parent(ParentID),
    ParentID2 int FOREIGN KEY REFERENCES Parent(ParentID),
    CFirstName varchar(16) NOT NULL,
    CLastName varchar(16) NOT NULL
);
END

IF OBJECT_ID(N'dbo.Deadlines', N'U') IS NULL BEGIN  
CREATE TABLE Deadlines (
    DeadlineID int IDENTITY(1,1) NOT NULL PRIMARY KEY,
    ChildID int NOT NULL FOREIGN KEY REFERENCES Child(ChildID),
    DTitle varchar(32),
    DTime DATETIME NOT NULL,
    DDescription varchar(140),
    DCompleted BIT NOT NULL
);
END

IF OBJECT_ID(N'dbo.Appointments', N'U') IS NULL BEGIN  
CREATE TABLE Appointments(
    AppointmentID int IDENTITY(1,1) NOT NULL PRIMARY KEY,
    ParentID int NOT NULL FOREIGN KEY REFERENCES Parent(ParentID),
    AppointmentTime DATETIME NOT NULL,
    AppointmentLocation varchar(140),
    Notes varchar(140)
);
END