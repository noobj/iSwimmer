<style>
<link href="/iSwimer/script/lightbox/css/lightbox.css" rel="stylesheet" />

</style>
<table  style="width:1000px">
<tr>  <th>Title</th> <th>Date</th> <th>Poster</th> </tr> 
<?php foreach ($records as $record_item): ?>
<tr>


<th>

<a class="record" href="/iSwimer/news/view/<?php echo $record_item['id'] ?>">
<?php echo $record_item['title'] ?>
</a></th>

<th><?php echo $record_item['date']?></th>

<th><a class="record" href="/iSwimer/news/profile/<?php echo $record_item['user_id'] ?>"><?php echo $record_item['name']?></a></th>

</tr>

<?php endforeach?>
</table>

<script src="/iSwimer/script/lightbox/js/jquery-1.11.0.min.js"></script>
<script src="/iSwimer/script/lightbox/js/lightbox.min.js"></script>
