<div class="form-group">
	<label class="col-sm-3 control-label"><?php echo $attrib_check_group_show->title ?></label>
	<div class="col-sm-9">
		<select class="tags" multiple="multiple" name="attrib_check_<?php echo $attrib_check_group_show->id ?>[]" class='form-control js-checkbox'>
			<?php 			
			foreach($set_attrib_check as $row){
				$attrib_check = NULL;
				if(!isset($getcsdl_attrib_check->attrib_check_id)){ 
					$attrib_check = '[""]';
				}else{
					$attrib_check = $getcsdl_attrib_check->attrib_check_id;
				}
				
				$ajax = json_decode($attrib_check);
				
				if(array_search($row->id,$ajax) === false)
					$select = false;
				else
					$select = true;
					
				echo '<option value="'.$row->id.'" '.set_select('attrib_check_'.$attrib_check_group_show->id.'[]', $row->id, ($select) ).'>'.$row->title.'</option>';
			}
			?>
		</select>
	</div>
</div>
