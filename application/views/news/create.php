<h2>Add Training List</h2>

<?php echo validation_errors(); ?>

<?php echo form_open('news/add') ?>
SORT:<select name="sort">
<?php

  foreach ($sorts as $sort_item):
    echo "<option value='".$sort_item[name]."'>".$sort_item[name]."</option>";
  endforeach
?>
</select>
<br />

NAME
<input type="input" name="name" /><br />

<input type="submit" name="submit" value="Confirm" />

</form>

