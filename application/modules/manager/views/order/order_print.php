<!doctype html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Print</title>
		<script type="text/javascript">function printPage() { window.focus(); window.print();return; }printPage()</script>
	</head>
	<style>
		body{
			font-family:'Roboto',Cambria, Hoefler Text, Liberation Serif, Times, Times New Roman, serif
		}
		@media all {
			.page-break { display: none; }
		}

		@media print {
			.page-break { display: block; page-break-before: always; }
		}
	</style>
<body>
<?php 
	$page = $this->input->get("page");
	if(empty($page))
		$page = 1;
	for($i = 0;$i < $page; $i++): ?>
<div class="page-break"></div>
	<table id="table" style="border: 0px solid #ddd;width: 100%;max-width: 100%;margin-bottom: 5px;border-collapse: collapse;border-spacing: 0;font-family: 'Roboto', Arial, sans-serif;font-size: 13px;">
		<tbody>
			<tr>
				<td style="width: 125px;">
					<img width="100px" src="<?php echo base_url()."images/logo.jpg";?>">
				</td>								
				<td style="padding: 5px;font-weight: 400;vertical-align: middle;border: 0px solid #ddd;">
					<p><strong><?php echo $config->name_cty ?></strong><br>
					<strong>ĐCGD:</strong> <?php echo $config->add ?><br>
					<strong>ĐT:</strong> <?php echo $config->hotline ?>
					<br><strong>Tài khoản :</strong> 0071001005468. <strong>Tại Ngân hàng</strong> : Vietcombank Hồ Chí Minh</p>
				</td>
			</tr>
		</tbody>
	</table>
	<h2 style="font-family:'Roboto', Arial, sans-serif;text-align: center">ĐƠN BÁN HÀNG <?php echo $sale->code; ?></h2>
	<table style="border: 0px solid #ddd;width: 100%;max-width: 100%;margin-bottom: 5px;border-collapse: collapse;border-spacing: 0;font-family: 'Roboto', Arial, sans-serif;font-size: 13px;">
		<tbody>
			<tr>
				<td colspan="2" style="padding: 5px;font-weight: 400;vertical-align: middle;border: 0px solid #ddd;"><b>Tên khách hàng:</b> <?php echo $customer->name ?></td>
			</tr>
			<tr>
				<td colspan="2" style="padding: 5px;font-weight: 400;vertical-align: middle;border: 0px solid #ddd;"><b>Địa chỉ:</b> <?php echo $customer->address ?></td>
			</tr>
			<tr>
				<td style="padding: 5px;font-weight: 400;vertical-align: middle;border: 0px solid #ddd;"><b>Điện thoại : </b> <?php echo $customer->phone ?></td>								
				<td style="padding: 5px;font-weight: 400;vertical-align: middle;border: 0px solid #ddd;"><b>E-mail :</b> <?php echo $customer->email ?></td>
			</tr>
		</tbody>
	</table>
	<br>
	<?php
		$colspan = 9;
		if((int)$sale_detail[0]->vat <= 0) $colspan = $colspan - 1;
		if((int)$sale_detail[0]->discount <= 0) $colspan = $colspan - 1;
		if((int)$sale_detail[0]->sale <= 0) $colspan = $colspan - 1;
	?>

	<table style="border: 0px solid #ddd;width: 100%;max-width: 100%;margin-bottom: 5px;border-collapse: collapse;border-spacing: 0;font-family: 'Roboto', Arial, sans-serif;font-size: 13px;">
						 <thead>
						 	<tr style="background: #E0E0E0">
						 		<th style="padding: 5px;font-weight: 400;vertical-align: middle;border: 1px solid #ddd;font-weight: bold">#</th>
						 		<th style="padding: 5px;font-weight: 400;vertical-align: middle;border: 1px solid #ddd;font-weight: bold">Mã</th>
						 		<th style="padding: 5px;font-weight: 400;vertical-align: middle;border: 1px solid #ddd;font-weight: bold">Tên Bánh</th>
						 		<th style="padding: 5px;font-weight: 400;vertical-align: middle;border: 1px solid #ddd;font-weight: bold">Đơn vị</th>
						 		<th style="padding: 5px;font-weight: 400;vertical-align: middle;border: 1px solid #ddd;font-weight: bold">Giá</th>
						 		<th style="padding: 5px;font-weight: 400;vertical-align: middle;border: 1px solid #ddd;font-weight: bold">Số Lượng</th>
						 		<?php if((int)$sale_detail[0]->vat > 0):?>
						 		<th style="padding: 5px;font-weight: 400;vertical-align: middle;border: 1px solid #ddd;font-weight: bold">VAT</th>
						 		<?php endif ?>
						 		<?php if((int)$sale_detail[0]->discount > 0): ?>
						 		<th style="padding: 5px;font-weight: 400;vertical-align: middle;border: 1px solid #ddd;font-weight: bold">CK %</th>
						 		<?php endif ?>
						 		<?php if((int)$sale_detail[0]->discount > 0): ?>
						 		<th style="padding: 5px;font-weight: 400;vertical-align: middle;border: 1px solid #ddd;font-weight: bold">Giảm (đ)</th>
						 		<?php endif ?>
						 		<th style="padding: 5px;font-weight: 400;vertical-align: middle;border: 1px solid #ddd;font-weight: bold">Thành tiền</th>
						 	</tr>
						 </thead>
						 <tbody>
						  <?php 															
							$stt = 1;
							$sum = 0;
							foreach($sale_detail as $row):
								$sum = (int)$row->number + $sum;
						  ?>
						 	<tr>
						 		<td style="padding: 5px;font-weight: 400;vertical-align: middle;border: 1px solid #ddd;"><?php echo $stt ?></td>
						 		<td style="padding: 5px;font-weight: 400;vertical-align: middle;border: 1px solid #ddd;"><?php echo $row->code ?></td>
						 		<td style="padding: 5px;font-weight: 400;vertical-align: middle;border: 1px solid #ddd;"><?php echo $row->name_product ?></td>
						 		<td style="padding: 5px;font-weight: 400;vertical-align: middle;border: 1px solid #ddd;"><?php echo $row->unit ?></td>
						 		<td style="padding: 5px;font-weight: 400;vertical-align: middle;border: 1px solid #ddd;"><?php echo number_format((int)$row->price, 0, ',', '.') ?> đ</td>
						 		<td style="padding: 5px;font-weight: 400;vertical-align: middle;border: 1px solid #ddd;"><?php echo $row->number ?></td>
						 		<?php if((int)$sale_detail[0]->vat > 0): ?>
						 		<td style="padding: 5px;font-weight: 400;vertical-align: middle;border: 1px solid #ddd;"><?php echo $row->vat ?> %</td>
						 		<?php endif ?>
						 		<?php if((int)$sale_detail[0]->discount > 0): ?>
						 		<td style="padding: 5px;font-weight: 400;vertical-align: middle;border: 1px solid #ddd;"><?php echo $row->discount ?> %</td>
						 		<?php endif ?>						 	
						 		<?php if((int)$sale_detail[0]->discount > 0): ?>
						 		<td style="padding: 5px;font-weight: 400;vertical-align: middle;border: 1px solid #ddd;"><?php 
									 $ck = ((int)$row->price * (int)$row->number) *((double)$row->discount/100);
									 echo number_format((double)$ck, 0, ',', '.');  
								?>đ</td>
						 		<?php endif ?>
						 		<td style="padding: 5px;font-weight: 400;vertical-align: middle;border: 1px solid #ddd;text-align: right"><?php echo number_format((int)$row->total, 0, ',', '.') ?> đ</td>
						 	</tr>                	                  
						  <?php 
							 $stt++;
							 endforeach; 
						  ?>
                   		</tbody>
                    <tfoot>
                    	<tr>
                    		<td colspan="10"></td>
                    	</tr> 
                    	<tr>
                    		<td colspan="<?php echo $colspan - 1 ?>" style="padding: 5px;font-weight: 400;vertical-align: middle;border: 1px solid #ddd;text-align: right;font-weight: bold">Số Lượng</td>
                    		<td colspan="3" style="padding: 5px;font-weight: 400;vertical-align: middle;border: 1px solid #ddd;text-align: left"><strong><?php echo $sum ?></strong></td>
                    	</tr>
                    	<tr>
                    		<td colspan="<?php echo $colspan ?>" style="padding: 5px;font-weight: 400;vertical-align: middle;border: 1px solid #ddd;text-align: right;font-weight: bold">Tổng tiền</td>
                    		<td colspan="2" style="padding: 5px;font-weight: 400;vertical-align: middle;border: 1px solid #ddd;text-align: right"><strong><?php echo number_format((int)$sale->total, 0, ',', '.') ?> đ</strong></td>
                    	</tr>
                    	<?php if((int)$sale->discount > 0): ?>
                    	<tr>
                    		<td colspan="<?php echo $colspan ?>" style="padding: 5px;font-weight: 400;vertical-align: middle;border: 1px solid #ddd;text-align: right;font-weight: bold">Chiết khấu (<?php echo (double)$sale->discount ?> %)</td>
                    		<td colspan="2" style="padding: 5px;font-weight: 400;vertical-align: middle;border: 1px solid #ddd;;text-align: right">
                    		<strong>
                    		<?php 
								 $ck = (int)$sale->total*((double)$sale->discount/100);
								 echo number_format((double)$ck, 0, ',', '.');  
                    		?> đ
                    		</strong></td>
                    	</tr>
                    	<?php endif ?>
                    	<?php if((int)$sale->vat > 0): ?>
                    	<tr>
                    		<td colspan="<?php echo $colspan ?>" style="padding: 5px;font-weight: 400;vertical-align: middle;border: 1px solid #ddd;text-align: right;font-weight: bold">VAT (<?php echo (double)$sale->vat ?> %)</td>
                    		<td colspan="2" style="padding: 5px;font-weight: 400;vertical-align: middle;border: 1px solid #ddd;text-align: right">
                    		<strong>
                    		<?php 
								$thuctra = (int)$sale->total - (double)$ck;
								$vat = $thuctra*((double)$sale->vat/100);
								echo number_format((double)$vat, 0, ',', '.');
                    		?> đ
                    		</strong></td>
                    	</tr>
                    	<?php endif ?>
                    	
                    	<?php if((int)$sale->transport > 0): ?>  
                    	<tr>
                    		<td colspan="<?php echo $colspan ?>" style="padding: 5px;font-weight: 400;vertical-align: middle;border: 1px solid #ddd;text-align: right;font-weight: bold">Phí vận chuyển</td>
                    		<td colspan="2" style="padding: 5px;font-weight: 400;vertical-align: middle;border: 1px solid #ddd;text-align: right"><strong><?php echo number_format((int)$sale->transport, 0, ',', '.') ?> đ</strong></td>
                    	</tr>
                    	<?php endif ?> 
                    	<tr>
                    		<td colspan="<?php echo $colspan ?>" style="padding: 5px;font-weight: 400;vertical-align: middle;border: 1px solid #ddd;text-align: right;font-weight: bold">Thực Trả</td>
                    		<td colspan="2" style="padding: 5px;font-weight: 400;vertical-align: middle;border: 1px solid #ddd;text-align: right"><strong><?php echo number_format((int)$sale->total_payment, 0, ',', '.') ?> đ</strong></td>
                    	</tr>
                    </tfoot>
					</table>
					
					<p style="font-family:'Roboto', Arial, sans-serif;font-size: 13px;"> <strong>Phụ Lục :</strong><br>
					1. Thời gian giao hàng : <strong><?php echo date_format(date_create($sale->received_date),"d/m/Y"); ?></strong><br>
					2. Người nhận : <strong><?php echo $customer->phone ?></strong><br>
					3. Địa chỉ giao : <strong><?php echo $sale->address ?></strong><br>
					4. Nhân viên KD: <strong>
					<?php 
						$this->load->model('users_admin_model'); 
						$user = $this->users_admin_model->get_one_by(array("username"=>$sale->created_by));
						echo $user->phone." (".$user->name.")";
						?> </strong></p>
					
					<?php if(!empty($customer->cty_mst ) && $sale->vat > 0):?>
					<p style="font-family:'Roboto', Arial, sans-serif;font-size: 13px;"> <strong>Thông tin xuất hóa đơn :</strong><br>
					1. Công Ty : <strong><?php echo $customer->cty_name ?></strong><br>
					2. Địa Chỉ : <strong><?php echo $customer->cty_address ?></strong><br>
					3. MST : <strong><?php echo $customer->cty_mst ?></strong></p>
					<?php endif ?>
					<?php if(!empty($sale->note)): ?><p style="font-family:'Roboto', Arial, sans-serif;font-size: 13px;"><strong>Lưu ý: </strong><strong><?php echo nl2br($sale->note) ?></strong></p><?php endif ?>
					
					<p style="font-family:'Roboto', Arial, sans-serif; font-style: italic;font-size: 13px;"> Cám ơn quý khách đã đặt hàng. Phương châm của chúng tôi là "Chất lượng của chúng tôi là vàng" !..</p>
					
					<div>
						
						<div style="float: right; margin-left: 150px;text-align: center;font-family:'Roboto', Arial, sans-serif;font-size: 13px;">
							<strong>Khách Hàng</strong>
							<br>(ký, họ tên)
						</div>
						
						<div style="float: right;text-align: center;font-family:'Roboto', Arial, sans-serif;font-size: 13px;">
							<strong>NV Giao Hàng</strong>
							<br>(ký, họ tên)
						</div>
						
					</div>
					
			
				
<?php endfor ?>
</body>
</html>
					