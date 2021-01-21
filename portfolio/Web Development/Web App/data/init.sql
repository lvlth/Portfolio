CREATE DATABASE vr;

use vr;

create table users(
userID int PRIMARY KEY,
dob date,
firstName varchar(50),
middleInitial  varchar(50),
lastName varchar(50),
email varchar(30) not null,
unique(email),
CHECK(dob > '1900-01-01'),
Check(email like '%@%.%')
)
;
create table freeUser(
userID int not null,
usageQuota int NOT NULL,
Check(usageQuoata > 0),
PRIMARY KEY (userID),
FOREIGN KEY (userID) references users(userID) on delete Cascade
)
;
create table payingUser(
userID int not null Primary Key references user(userID) ON DELETE cascade,
monthlyFee numeric(8,2) not null
)
;
create table avatar(
userID int references users(userID),
_name varchar(15) not null,
species varchar(7)  not null,
Primary key (userID, _name),
Check(species in('Alpha', 'Bravo', 'Charlie', 'Delta'))
)
;
create table vrExperience(
expID int not null Primary Key,
_name varchar(25) not null,
maintainer int references payingUser(userID) ON DELETE set null
)
;
create table devUnit(
unitID int not null,
unitName varchar(20),
unitDesc text,
PRIMARY KEY (unitID, unitName)
)
;
create table develops(
unitID int not null,
unitName varchar(20) not null,
userID int not null,
expID int not null,
Primary Key (unitID, unitName, userID, expID),
FOREIGN KEY (unitID, unitName) 	REFERENCES devUnit(unitID, unitName) ON UPDATE CASCADE ON DELETE CASCADE,
FOREIGN KEY (userID) REFERENCES users(userID) ON DELETE CASCADE,
FOREIGN KEY (expID) REFERENCES vrExperience(expID) ON DELETE CASCADE	
)
;
create table supportedDevices(
expID int,
device varchar(20),
Primary key (expID, device),
Foreign key (expid) references vrExperience(expid) ON DELETE CASCADE
);