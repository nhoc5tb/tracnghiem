<ol class="breadcrumb">
	<li><a href="<?php echo base_url().$module?>"><span class="icon mdi mdi-home"></span></a></li>
	<li><a href="<?php echo base_url().$module."/".$controller?>"><?php echo $controller_title ?></a></li>
</ol>
<div class="panel panel-default panel-table">
  <div class="panel-heading"><?php echo $controller_title ?></div>
    <div class="panel-body">
      <table class="table table-striped table-hover">
        <thead>
          <tr>
            <th>Mã Tỉnh</th>
            <th>Tên Tỉnh</th>
            <th>Giá vận chuyển</th>
          </tr>
        </thead>
            <tbody>
            <?php 									
					  foreach($getcsdl as $row): ?>	
						<tr id="id<?php echo $row->id ?>">							
							<td><strong><?php echo $row->code ?></strong></td>
              <td><?php echo $row->text ?></td>
              <td>
                <div class="input-group xs-mb-10">
                <span class="input-group-addon">$</span>
                  <input type="text" id="code_<?php echo $row->code ?>" value="<?php echo $row->price ?>" class="form-control input-price">
                  <span style="cursor: pointer" class="rujs-up input-group-addon" data-id="<?php echo $row->code ?>" data-path="<?php echo base_url($module)."/".$controller ?>/update">Cập Nhật</span>
                </div>
                                
              </td>                          
						</tr>
            <?php endforeach ?> 
      </table>
    </div>
  </div>
  <div class="pagination"><?php echo $pagination ?></div>
<?php $this->load->view("blockmodule/modal_dialog");?>
