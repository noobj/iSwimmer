<html>
<head>
<style>
#header
{
background-image:url('/iSwimer/pic/swim_header.jpg');
height:200px;
background-color:RoyalBlue;
background-repeat:no-repeat;
background-position:center;
}

.record
{
  color:blue;
  padding:4px;
  display:block;
}

a
{
font-weight:bold;
text-decoration:none;
}
a:link{color:RoyalBlue;}
a:visited{color:RoyalBlue;}

th,td
{
  padding:5px;
}

#nav
{
background-color:DodgerBlue;
height:70px;
}

.btnNav
{
  border: 1px solid white;
font-size :20px;
color:white;
height:70px;
width:200px;
background-color:transparent;
cursor:pointer;
}

#iSwimer
{
  color:white;
}
</style>


<title><?php echo $title ?> - Swimming & Workout Record</title>
</head>
<?php 
	if(!$this->session->userdata('username'))
		//echo $this->session->userdata('username');
		redirect('/news/profile', 'location', 301);
?>
<body><div id="header"><a id="iSwimer" href="/iSwimer/news">
<h1 >iSwimer</h1></a></div>
<div id="nav">
<input type="button" value="Add Training List" onclick="self.location.href='/iSwimer/news/add'" class="btnNav"/>

<input type="button" value="Delete Training List" onclick="self.location.href='/iSwimer/news/del'" class="btnNav"/>

<input type="button" value="Add Training Record" onclick="self.location.href='/iSwimer/news/record'" class="btnNav"/>

<input type="button" value="Profile" onclick="self.location.href='/iSwimer/news/profile'" class="btnNav"/>

<input type="button" value="Log out" onclick="self.location.href='/iSwimer/news/logout'" class="btnNav"/>

</div>
