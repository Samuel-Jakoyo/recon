<?php 
include ("DBConfig.php");

//create tables 
$query="create table if not exists users(
userid int primary key not null auto_increment,
username varchar(20) default null,
user_type varchar(50) default null,
user_role varchar(50) default 'admin',
password varchar(255) default null)";
//execute the query
$result=mysqli_query($db,$query);


$query="create table if not exists cashbook (
 cashbookid int not null auto_increment,
 cdate varchar(15) default null,
 description varchar(350) default null,
 referenceno varchar(30) not null,
 debit int default null,
 credit int default null,
 accountno varchar(30) default null,
 branchcode int default null,
 created varchar(30) default null,
 status enum ('1','0') default '0',
 PRIMARY KEY (cashbookid))";
$result=mysqli_query($db,$query);


$query="create table if not exists reconcb (
 reconcb int not null auto_increment,
 cdate varchar(15) default null,
 description varchar(350) default null,
 referenceno varchar(30) not null,
 debit int default null,
 credit int default null,
 accountno varchar(30) default null,
 branchcode int default null,
 created varchar(30) default null,
 status enum ('1','0') default '0',
 PRIMARY KEY (reconcb))";
$result=mysqli_query($db,$query);

$query="create table if not exists unreconcb (
 unreconcb int not null auto_increment,
 cdate varchar(15) default null,
 description varchar(350) default null,
 referenceno varchar(30) not null,
 debit int default null,
 credit int default null,
 accountno varchar(30) default null,
 branchcode int default null,
 created varchar(30) default null,
 status enum ('1','0') default '0',
 PRIMARY KEY (unreconcb))";
$result=mysqli_query($db,$query);


$query="create table if not exists bankstatement (
statementid int not null auto_increment,
bdate varchar(15) default null,
description varchar(350) default null,
referenceno varchar(30) not null,
debit int default null,
credit int default null,
accountno varchar(50) default null,
status enum ('1','0') default '0',
PRIMARY KEY (statementid))";
$result=mysqli_query($db,$query);

$query="create table if not exists reconbs (
reconbs int not null auto_increment,
bdate varchar(15) default null,
description varchar(350) default null,
referenceno varchar(30) not null,
debit int default null,
credit int default null,
accountno varchar(50) default null,
status enum ('1','0') default '0',
PRIMARY KEY (reconbs))";
$result=mysqli_query($db,$query);

$query="create table if not exists unreconbs (
unreconbs int not null auto_increment,
bdate varchar(15) default null,
description varchar(350) default null,
referenceno varchar(30) not null,
debit int default null,
credit int default null,
accountno varchar(50) default null,
status enum ('1','0') default '0',
PRIMARY KEY (unreconbs))";
$result=mysqli_query($db,$query);

header("location:home.php");
?>




