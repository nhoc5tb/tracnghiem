<ol class="breadcrumb">
	<li><a href="<?php echo base_url().$module?>"><span class="icon mdi mdi-home"></span></a></li>
	<li><a href="<?php echo base_url().$module."/".$controller?>"><?php echo $controller_title ?></a></li>
	<li class="active"><?php echo $title ?></li>
</ol>
<div class="row">
	<div class="col-md-12">
        <div class="panel panel-default panel-table">
                <div class="panel-heading">Chi Tiết Liên Hệ</div>
                <div class="panel-body">
                  <table class="table table-striped table-hover">                    
                    <tbody>                    
						<tr>
							<td width="200px">
                           		Tên                   
                            </td>
							<td>
								<?php echo $getcsdl->name ?>
							</td>
						</tr>
                 		<tr>
							<td>
                           		E-mail                   
                            </td>
							<td>
								<?php echo $getcsdl->email ?>
							</td>
						</tr>
                 		<tr>
							<td>
                           		Phone                  
                            </td>
							<td>
								<?php echo $getcsdl->phone ?>
							</td>
						</tr>
                 		<tr>
							<td>
                           		Nội dung                  
                            </td>
							<td>
								<?php echo $getcsdl->message ?>
							</td>
						</tr>
                  </table>
                </div>
                
              </div>
	</div>
</div>