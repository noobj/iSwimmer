<style>
li{
background-color:#ddd;
padding-left:30px;
padding-top:7px;
width:300px;
height:50px;
font-size:2em;
border:1px solid white;
cursor:pointer;
}

ul
{
  list-style-image:url("/iSwimer/pic/cross.gif");
}

select#sort
{
height:440px;
width:300px;
border:0px;
background-color:#ddd;
font-size:1em;
padding-left:70px;
}
</style>

<h2>Today Training List</h2>

<?php echo validation_errors();
echo form_open('news/record');?>
TITLE:<input type="text" name="title" required/>
<br />
<br />
SELECTED:
<ul></ul>
SORT:<select  onchange="selectIngredient(this);"name="sort" id="sort" multiple>
<?php

foreach($sorts as $sort_item):
{
  echo "<optgroup label='".$sort_item[name]."'>";

  foreach(${$sort_item['name']} as $list)
  {
    if(isset($list['name']))
      echo "<option value='".$list['id']."'>".$list['name']."</option>";
  }

  echo "</optgroup>";
}
endforeach
?>

</select>

<input type="submit" name="submit" value="Confirm" />

</form>
<script src="/iSwimer/script/jquery-1.8.3.min.js"></script>
<script type="text/javascript">
	function selectIngredient(select)
{
  var option = select.options[select.selectedIndex];
  var ul = select.parentNode.getElementsByTagName('ul')[0];

  var choices = ul.getElementsByTagName('input');
  for (var i = 0; i < choices.length; i++)
    if (choices[i].value == option.value)
      return;

  var li = document.createElement('li');
  var input = document.createElement('input');
  var text = document.createTextNode(option.firstChild.data);

  input.type = 'hidden';
  input.name = 'ingredients[]';
  input.value = option.value;

  li.appendChild(input);
  li.appendChild(text);
  li.setAttribute('onclick', 'this.parentNode.removeChild(this);');

  ul.appendChild(li);
}

$(document).ready(function(){


});

</script>
