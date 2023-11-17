<div class="form-group">
	<label class="col-sm-3 control-label"><?php echo $attrib_check_group_show->title ?></label>
	<div class="col-sm-9">
		<select name="attrib_check_<?php echo $attrib_check_group_show->id ?>" class='select2'>
			<option value="">Không xác định</option>
			<?php 
			if(!isset($getcsdl_attrib_check->attrib_check_id)){ 
				$attrib_check = 0;
			}else{
				$attrib_check = $getcsdl_attrib_check->attrib_check_id;
			}
			foreach($set_attrib_check as $row){						
				echo '<option value="'.$row->id.'" '.set_select('attrib_check_'.$attrib_check_group_show->id, $row->id, ($attrib_check == $row->id)).'>'.$row->title.'</option>';
			}
			?>
		</select>
	</div>
</div>