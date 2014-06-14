<head>
<link href="/iSwimer/script/lightbox/css/lightbox.css" rel="stylesheet" />

</head>

<style>
div img
{
	max-width:200px;
	max-height:200px;
	height:200px;
	width:200px;
	width:expression(document.body.clientWidth>200?"200px":"auto");
}

#input
{

}
</style>
	<div id="photo"><a href="/iSwimer/pic/<?php echo $photo;?>" data-lightbox="image-1" ><img src="/iSwimer/pic/<?php echo $photo;?>" /></a></div>
	
	<?php echo $error;?>
	<?php echo form_open_multipart('news/do_upload');?>
	<input type="file" id="input" name="userfile" size="20" />
	<input type="submit" value="upload" />
	</form>
	
	<h1 style="color:DarkGoldenRod  "><?php echo $name; ?></h1>
	<h2 style="color:Crimson">Before Post:</h2>
	<table  style="width:1000px">
	<?php foreach ($records as $record_item): ?>
	<tr>


<th>

<a class="record" href="/iSwimer/news/view/<?php echo $record_item['id'] ?>">
<?php echo $record_item['title'] ?>
</a></th>

<th><?php echo $record_item['date']?></th>
<th><img style="cursor:pointer" onclick="del(<?php echo $record_item['id'];?>,this)"src="/iSwimer/pic/cross.gif" /></th>


</tr>

<?php endforeach?>
</table>
	
<script src="/iSwimer/script/lightbox/js/jquery-1.11.0.min.js"></script>
<script src="/iSwimer/script/lightbox/js/lightbox.min.js"></script>
<script type="text/javascript">
	
	
	function del(id,obj)
	{
		
		 var xmlhttp=new XMLHttpRequest();
		xmlhttp.onreadystatechange=function() {
			
		if (xmlhttp.readyState==4 && xmlhttp.status==200) {
		  	  obj.parentNode.parentNode.parentNode.removeChild(obj.parentNode.parentNode);
			}
		}
		if (confirm("Are You Sure??") == true) {
		xmlhttp.open("POST","/iSwimer/news/del_post/"+id,true);
		xmlhttp.send();
		}else
			;

	}
	


$(document).ready(function(){
	

});

</script>

