<head>
<link href="./script/lightbox/css/lightbox.css" rel="stylesheet" />

</head>
<style>
ul{
	
	list-style-type:none;
}	
	
.content{
	padding:10px;
	background-color:#D6D6D6;
}

.outer{
	padding:10px;
	background-color:#EEEEEE;
}

.photo{
		max-width:60px;
	max-height:60px;
	height:60px;
	width:60px;
	width:expression(document.body.clientWidth>60?"60px":"auto");
}

.comment_photo{
	margin-left:20px;
		max-width:55px;
	max-height:55px;
	height:55px;
	width:55px;
	width:expression(document.body.clientWidth>55?"55px":"auto");
}

.head{
	display:inline;
	font-size:60px;
	color:#4A7FB2;
}

p{
	display:inline;
	font-size:1px;
}
.comment{
	margin-top:5px;
	padding:5px;
	background-color:#C5C5C5;
	font-size:23px;
}

.context{
	font-size:50px;
	color:#006B00;
}

.comment_context
{
	background-color:transparent;
	border:0px;
	resize : none;
	color:black;
	font-size:17px;
}
.comment_header
{
	vertical-align:30px;
	display:inline;
	font-size:30px;
}


</style>
<br /><br />
<div class="outer">
<div class="content">
	<a href="/iSwimer/pic/<?php echo $user->image;?>" data-lightbox="image<?php echo $user->id?>"  ><img class="photo" src="/iSwimer/pic/<?php echo $user->image;?>" /></a>
<?php
$tts = 5; //The training field start
echo '<div class="head" > <a  href="/iSwimer/news/profile/'.$user->id.'">'.$user->name."</a> <p> ".$records_item->date.'</p></div>';

echo "<div class='context'>".$records_item->title."</div>";

$j = 0;
for ($i = $tts; $i < $num; $i++) {
  if($records_item->$fields[$i])
  {
    $j++;
    echo "<br />".$j.".".$fields[$i];
  }
}


?>

</div>
<div class="comment">
	<ul>
<?php
foreach($comments as $row)
{
  echo '<li>';
  echo '<a  href="/iSwimer/news/profile/'. $row['user_id'].'"><img class="comment_photo" src="./pic/'.$row['user_image'].'"/><div class="comment_header">'.nbs(2);
  echo $row['user_name'];
  
  echo '</a></div>'.nbs(4).'<textarea class="comment_context" rows="3" cols="60"   disabled>'.$row['content'];
  echo	'</textarea></li>';
}

echo validation_errors(); ?>
<li>
<form method="post"  action="news/add_comment" onsubmit="sent(this); return false;">
	<input type="hidden" name="list_id" value="<?php echo $records_item->id?>" />
	<br />
	
	<a href="/iSwimer/pic/<?php echo $this->session->userdata('user_image');?>"><img class="comment_photo" src="/iSwimer/pic/<?php echo $this->session->userdata('user_image');?>" /></a>
	

	<textarea rows="3" cols="60" name="comment" placeholder="leaving some message..."></textarea>
	<input type="submit" />
</form>
</li>
</ul>
</div>
</div>
<script src="./script/lightbox/js/jquery-1.11.0.min.js"></script>
<script src="./script/lightbox/js/lightbox.min.js"></script>

<script type="text/javascript">
	
	function sent(oFormElement)
	{
		
		 var xmlhttp=new XMLHttpRequest();
		xmlhttp.onreadystatechange=function() {
			
		if (xmlhttp.readyState==4 && xmlhttp.status==200) {
		  	  location.reload(true);
			}
		}
	
		xmlhttp.open("POST","/iSwimer/news/add_comment",true);
		xmlhttp.send (new FormData (oFormElement));
	}	
	
	
$(document).ready(function(){
	

	
});
</script>



