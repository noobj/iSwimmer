<h2>Delete Training List</h2>

<?php echo validation_errors(); ?>

<?php echo form_open('news/del') ?>
SORT:<select name="sort" id="sort">
<?php

foreach ($sorts as $sort_item):
  echo "<option value='".$sort_item[name]."'>".$sort_item[name]."</option>";
endforeach
?>
</select>
<br />
<?php
$i = 0;
foreach($sorts as $sort_item):
{
  $i++;
  if($i == 1)
    echo "<div class='sort_item' id=".$sort_item['name']." style='font-size:30px; display:block; margin-top:10px'> ";
  else
    echo "<div class='sort_item' id=".$sort_item['name']." style='font-size:30px; display:none; margin-top:10px'> ";

  foreach(${$sort_item['name']} as $list)
  {
    if(isset($list['name']))
      echo "<input type='button' style='border:0px; height:65px;
    width:150px; margin-left:5px; font-size :20px;cursor:pointer;color:white; background-color:black    '
      class='btn_list' id='btn_".$list['name']."' value=".$list['name']." />";

  }
  echo "</div>";
}

endforeach
?>

Selected:
<input id="in_name" style="border:0px;" type="input" name="name" readonly/><br />

<input type="submit" name="submit" value="Confirm" />

</form>
<script src="/iSwimer/script/jquery-1.8.3.min.js"></script>
<script type="text/javascript">

$(document).ready(function(){
  $("#sort").change(function(){
    $(".sort_item").fadeOut();
    var x = "#"+$("#sort").val();
    $(x).fadeIn();
    $("#in_name").val('');
  });

  $(".btn_list").click(function(){
    $("#in_name").val($(this).val());

  });

});

</script>
