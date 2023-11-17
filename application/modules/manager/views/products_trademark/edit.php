<ol class="breadcrumb">
	<li><a href="<?php echo base_url().$module?>"><span class="icon mdi mdi-home"></span></a></li>
	<li><a href="<?php echo base_url().$module."/".$controller?>"><?php echo $controller_title ?> : </a></li>
	<li class="active"><?php echo $title ?></li>
</ol>
<link href="<?php echo base_url() ?>assets/css/bootstrap-imageupload.css" rel="stylesheet">
	<div class="row">
 		<div class="col-md-12">
              <div class="panel panel-default panel-border-color panel-border-color-primary">
                <div class="panel-heading panel-heading-divider"><?php echo $title ?></div>
                <div class="panel-body">
                	<?php if (validation_errors()):?>
                    <div role="alert" class="alert alert-contrast alert-danger alert-dismissible">
                        <div class="icon"><span class="mdi mdi-close-circle-o"></span></div>
                        <div class="message">
                          <button type="button" data-dismiss="alert" aria-label="Close" class="close"><span aria-hidden="true" class="mdi mdi-close"></span></button>
                          <?php if (validation_errors()) echo validation_errors(' ','<br>'); ?>
                        </div>
                      </div>
                    <?php endif; ?>
                  <form action="#" style="border-radius: 0px;" class="form-horizontal group-border-dashed"   method="post" enctype="multipart/form-data">
                    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name() ?>" value="<?php echo $this->security->get_csrf_hash() ?>" />
                    <div class="form-group">
                      <label class="col-sm-3 control-label">Tên</label>
                      <div class="col-sm-6">
                        <input name="title" value="<?php if(!empty($getcsdl) && !validation_errors()) echo $getcsdl->title;else echo set_value('title');?>" parsley-trigger="change" required="" placeholder="Tên danh mục" autocomplete="on" class="form-control" type="text">
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-sm-3 control-label">Slug</label>
                      <div class="col-sm-6">
                        <input name="slug" value="<?php if(!empty($getcsdl) && !validation_errors()) echo $getcsdl->slug;else echo set_value('slug');?>" placeholder="Tên trên url" class="form-control" type="text">
                      </div>
                    </div>        
                    <div class="form-group">
				<label class="col-sm-3 control-label">Logo Thương Hiệu</label>
				<div class="col-sm-6">
					<div class="imageupload">
					<!-- bootstrap-imageupload. -->
						<div class="panel-heading clearfix">
							<div class="btn-group pull-right">
								<button type="button" class="btn btn-default active">File</button>
							</div>
						</div>
						<?php  if(!empty($getcsdl->logo)):?>
							<img src="<?php echo $this->ruadmin->geturlimg($getcsdl->logo,$config_upload["dirweb"]); ?>" class="thumbnail" style="max-width: 250px; max-height: 250px;margin: 5px auto" />
						<?php endif; ?>
						<div class="file-tab panel-body">
							
							<label class="btn btn-default btn-file">
								<span>Browse</span>
								<input type="file" name="logo">
							</label>
							<button type="button" class="btn btn-default">Remove</button>
						</div>
					</div>
					<!-- bootstrap-imageupload. -->
				</div>
			</div>

                     <?php $this->load->view("blockmodule/upfile.php",array("image"=>$getcsdl->image));?>   

                    <div class="form-group">

                      <label class="col-sm-3 control-label">keywords</label>

                      <div class="col-sm-6">

                        <input name="sllug" value="<?php if(!empty($getcsdl) && !validation_errors()) echo $getcsdl->keywords;else echo set_value('keywords');?>" placeholder="Keywords" class="form-control" type="text">

                      </div>

                    </div>

                    

                    <div class="form-group">

                      <label class="col-sm-3 control-label">Description</label>

                      <div class="col-sm-6">

                        <textarea class="form-control" name="description"><?php if(!empty($getcsdl) && !validation_errors()) echo $getcsdl->description;else echo set_value('description');?></textarea>

                      </div>

                    </div>

                  <div class="form-group">
						<div class="col-sm-12">												
						<?php 
						if(!empty($getcsdl) && !validation_errors()) 
							$content =  $getcsdl->body_text;
						else 
							$content =  set_value('body_text');	
						$this->load->view("blockmodule/froalaeditor.php",array("name"=>"body_text","content_froalaeditor"=>$content));
						?>
						</div>
					</div>  
					<div class="form-group">
                      <label class="col-sm-3 control-label">Xuất Xứ</label>
                      <div class="col-sm-6">
                      	<select class="select2"  name="origin">
                      	
						<?php						
						echo '<option value="Ả Rập Xê Út"  '.set_select('origin',"Ả Rập Xê Út", $getcsdl->origin == "Ả Rập Xê Út").'>Ả Rập Xê Út</option>';
echo '<option value="Afghanistan"  '.set_select('origin',"Afghanistan", $getcsdl->origin == "Afghanistan").'>Afghanistan</option>';
echo '<option value="Ai Cập"  '.set_select('origin',"Ai Cập", $getcsdl->origin == "Ai Cập").'>Ai Cập</option>';
echo '<option value="Albania"  '.set_select('origin',"Albania", $getcsdl->origin == "Albania").'>Albania</option>';
echo '<option value="Algeria"  '.set_select('origin',"Algeria", $getcsdl->origin == "Algeria").'>Algeria</option>';
echo '<option value="Ấn Độ"  '.set_select('origin',"Ấn Độ", $getcsdl->origin == "Ấn Độ").'>Ấn Độ</option>';
echo '<option value="Andorra"  '.set_select('origin',"Andorra", $getcsdl->origin == "Andorra").'>Andorra</option>';
echo '<option value="Angola"  '.set_select('origin',"Angola", $getcsdl->origin == "Angola").'>Angola</option>';
echo '<option value="Anh"  '.set_select('origin',"Anh", $getcsdl->origin == "Anh").'>Anh</option>';
echo '<option value="Antigua và Barbuda"  '.set_select('origin',"Antigua và Barbuda", $getcsdl->origin == "Antigua và Barbuda").'>Antigua và Barbuda</option>';
echo '<option value="Áo"  '.set_select('origin',"Áo", $getcsdl->origin == "Áo").'>Áo</option>';
echo '<option value="Argentina"  '.set_select('origin',"Argentina", $getcsdl->origin == "Argentina").'>Argentina</option>';
echo '<option value="Armenia"  '.set_select('origin',"Armenia", $getcsdl->origin == "Armenia").'>Armenia</option>';
echo '<option value="Azerbaijan"  '.set_select('origin',"Azerbaijan", $getcsdl->origin == "Azerbaijan").'>Azerbaijan</option>';
echo '<option value="Ba Lan"  '.set_select('origin',"Ba Lan", $getcsdl->origin == "Ba Lan").'>Ba Lan</option>';
echo '<option value="Bắc Macedonia"  '.set_select('origin',"Bắc Macedonia", $getcsdl->origin == "Bắc Macedonia").'>Bắc Macedonia</option>';
echo '<option value="Bahamas"  '.set_select('origin',"Bahamas", $getcsdl->origin == "Bahamas").'>Bahamas</option>';
echo '<option value="Bahrain"  '.set_select('origin',"Bahrain", $getcsdl->origin == "Bahrain").'>Bahrain</option>';
echo '<option value="Bangladesh"  '.set_select('origin',"Bangladesh", $getcsdl->origin == "Bangladesh").'>Bangladesh</option>';
echo '<option value="Barbados"  '.set_select('origin',"Barbados", $getcsdl->origin == "Barbados").'>Barbados</option>';
echo '<option value="Belarus"  '.set_select('origin',"Belarus", $getcsdl->origin == "Belarus").'>Belarus</option>';
echo '<option value="Belize"  '.set_select('origin',"Belize", $getcsdl->origin == "Belize").'>Belize</option>';
echo '<option value="Bénin"  '.set_select('origin',"Bénin", $getcsdl->origin == "Bénin").'>Bénin</option>';
echo '<option value="Bhutan"  '.set_select('origin',"Bhutan", $getcsdl->origin == "Bhutan").'>Bhutan</option>';
echo '<option value="Bỉ"  '.set_select('origin',"Bỉ", $getcsdl->origin == "Bỉ").'>Bỉ</option>';
echo '<option value="Bờ Biển Ngà"  '.set_select('origin',"Bờ Biển Ngà", $getcsdl->origin == "Bờ Biển Ngà").'>Bờ Biển Ngà</option>';
echo '<option value="Bồ Đào Nha"  '.set_select('origin',"Bồ Đào Nha", $getcsdl->origin == "Bồ Đào Nha").'>Bồ Đào Nha</option>';
echo '<option value="Bolivia"  '.set_select('origin',"Bolivia", $getcsdl->origin == "Bolivia").'>Bolivia</option>';
echo '<option value="Bosnia và Herzegovina"  '.set_select('origin',"Bosnia và Herzegovina", $getcsdl->origin == "Bosnia và Herzegovina").'>Bosnia và Herzegovina</option>';
echo '<option value="Botswana"  '.set_select('origin',"Botswana", $getcsdl->origin == "Botswana").'>Botswana</option>';
echo '<option value="Brazil"  '.set_select('origin',"Brazil", $getcsdl->origin == "Brazil").'>Brazil</option>';
echo '<option value="Brunei"  '.set_select('origin',"Brunei", $getcsdl->origin == "Brunei").'>Brunei</option>';
echo '<option value="Bulgaria"  '.set_select('origin',"Bulgaria", $getcsdl->origin == "Bulgaria").'>Bulgaria</option>';
echo '<option value="Burkina Faso"  '.set_select('origin',"Burkina Faso", $getcsdl->origin == "Burkina Faso").'>Burkina Faso</option>';
echo '<option value="Burundi"  '.set_select('origin',"Burundi", $getcsdl->origin == "Burundi").'>Burundi</option>';
echo '<option value="Các tiểu vương quốc Ả Rập Thống nhất"  '.set_select('origin',"Các tiểu vương quốc Ả Rập Thống nhất", $getcsdl->origin == "Các tiểu vương quốc Ả Rập Thống nhất").'>Các tiểu vương quốc Ả Rập Thống nhất</option>';
echo '<option value="Cameroon"  '.set_select('origin',"Cameroon", $getcsdl->origin == "Cameroon").'>Cameroon</option>';
echo '<option value="Campuchia"  '.set_select('origin',"Campuchia", $getcsdl->origin == "Campuchia").'>Campuchia</option>';
echo '<option value="Canada"  '.set_select('origin',"Canada", $getcsdl->origin == "Canada").'>Canada</option>';
echo '<option value="Cape Verde"  '.set_select('origin',"Cape Verde", $getcsdl->origin == "Cape Verde").'>Cape Verde</option>';
echo '<option value="Chad"  '.set_select('origin',"Chad", $getcsdl->origin == "Chad").'>Chad</option>';
echo '<option value="Chile"  '.set_select('origin',"Chile", $getcsdl->origin == "Chile").'>Chile</option>';
echo '<option value="Colombia"  '.set_select('origin',"Colombia", $getcsdl->origin == "Colombia").'>Colombia</option>';
echo '<option value="Comoros"  '.set_select('origin',"Comoros", $getcsdl->origin == "Comoros").'>Comoros</option>';
echo '<option value="Cộng hòa Congo"  '.set_select('origin',"Cộng hòa Congo", $getcsdl->origin == "Cộng hòa Congo").'>Cộng hòa Congo</option>';
echo '<option value="Cộng hòa dân chủ Congo"  '.set_select('origin',"Cộng hòa dân chủ Congo", $getcsdl->origin == "Cộng hòa dân chủ Congo").'>Cộng hòa dân chủ Congo</option>';
echo '<option value="Cộng hòa Dominican"  '.set_select('origin',"Cộng hòa Dominican", $getcsdl->origin == "Cộng hòa Dominican").'>Cộng hòa Dominican</option>';
echo '<option value="Cộng hòa Séc"  '.set_select('origin',"Cộng hòa Séc", $getcsdl->origin == "Cộng hòa Séc").'>Cộng hòa Séc</option>';
echo '<option value="Cộng hòa Trung Phi"  '.set_select('origin',"Cộng hòa Trung Phi", $getcsdl->origin == "Cộng hòa Trung Phi").'>Cộng hòa Trung Phi</option>';
echo '<option value="Costa Rica"  '.set_select('origin',"Costa Rica", $getcsdl->origin == "Costa Rica").'>Costa Rica</option>';
echo '<option value="Croatia"  '.set_select('origin',"Croatia", $getcsdl->origin == "Croatia").'>Croatia</option>';
echo '<option value="Cuba"  '.set_select('origin',"Cuba", $getcsdl->origin == "Cuba").'>Cuba</option>';
echo '<option value="Djibouti"  '.set_select('origin',"Djibouti", $getcsdl->origin == "Djibouti").'>Djibouti</option>';
echo '<option value="Dominica"  '.set_select('origin',"Dominica", $getcsdl->origin == "Dominica").'>Dominica</option>';
echo '<option value="Đài Loan"  '.set_select('origin',"Đài Loan", $getcsdl->origin == "Đài Loan").'>Đài Loan</option>';
echo '<option value="Đan Mạch"  '.set_select('origin',"Đan Mạch", $getcsdl->origin == "Đan Mạch").'>Đan Mạch</option>';
echo '<option value="Đông Timor"  '.set_select('origin',"Đông Timor", $getcsdl->origin == "Đông Timor").'>Đông Timor</option>';
echo '<option value="Đức"  '.set_select('origin',"Đức", $getcsdl->origin == "Đức").'>Đức</option>';
echo '<option value="Ecuador"  '.set_select('origin',"Ecuador", $getcsdl->origin == "Ecuador").'>Ecuador</option>';
echo '<option value="El Salvador"  '.set_select('origin',"El Salvador", $getcsdl->origin == "El Salvador").'>El Salvador</option>';
echo '<option value="Eritrea"  '.set_select('origin',"Eritrea", $getcsdl->origin == "Eritrea").'>Eritrea</option>';
echo '<option value="Estonia"  '.set_select('origin',"Estonia", $getcsdl->origin == "Estonia").'>Estonia</option>';
echo '<option value="Ethiopia"  '.set_select('origin',"Ethiopia", $getcsdl->origin == "Ethiopia").'>Ethiopia</option>';
echo '<option value="Fiji"  '.set_select('origin',"Fiji", $getcsdl->origin == "Fiji").'>Fiji</option>';
echo '<option value="Gabon"  '.set_select('origin',"Gabon", $getcsdl->origin == "Gabon").'>Gabon</option>';
echo '<option value="Gambia"  '.set_select('origin',"Gambia", $getcsdl->origin == "Gambia").'>Gambia</option>';
echo '<option value="Georgia"  '.set_select('origin',"Georgia", $getcsdl->origin == "Georgia").'>Georgia</option>';
echo '<option value="Ghana"  '.set_select('origin',"Ghana", $getcsdl->origin == "Ghana").'>Ghana</option>';
echo '<option value="Grenada"  '.set_select('origin',"Grenada", $getcsdl->origin == "Grenada").'>Grenada</option>';
echo '<option value="Guatemala"  '.set_select('origin',"Guatemala", $getcsdl->origin == "Guatemala").'>Guatemala</option>';
echo '<option value="Guinea"  '.set_select('origin',"Guinea", $getcsdl->origin == "Guinea").'>Guinea</option>';
echo '<option value="Guinea Xích đạo"  '.set_select('origin',"Guinea Xích đạo", $getcsdl->origin == "Guinea Xích đạo").'>Guinea Xích đạo</option>';
echo '<option value="Guinea-Bissau"  '.set_select('origin',"Guinea-Bissau", $getcsdl->origin == "Guinea-Bissau").'>Guinea-Bissau</option>';
echo '<option value="Guyana"  '.set_select('origin',"Guyana", $getcsdl->origin == "Guyana").'>Guyana</option>';
echo '<option value="Hà Lan"  '.set_select('origin',"Hà Lan", $getcsdl->origin == "Hà Lan").'>Hà Lan</option>';
echo '<option value="Haiti"  '.set_select('origin',"Haiti", $getcsdl->origin == "Haiti").'>Haiti</option>';
echo '<option value="Hàn Quốc"  '.set_select('origin',"Hàn Quốc", $getcsdl->origin == "Hàn Quốc").'>Hàn Quốc</option>';
echo '<option value="Hoa Kỳ"  '.set_select('origin',"Hoa Kỳ", $getcsdl->origin == "Hoa Kỳ").'>Hoa Kỳ</option>';
echo '<option value="Honduras"  '.set_select('origin',"Honduras", $getcsdl->origin == "Honduras").'>Honduras</option>';
echo '<option value="Hungary"  '.set_select('origin',"Hungary", $getcsdl->origin == "Hungary").'>Hungary</option>';
echo '<option value="Hy Lạp"  '.set_select('origin',"Hy Lạp", $getcsdl->origin == "Hy Lạp").'>Hy Lạp</option>';
echo '<option value="Iceland"  '.set_select('origin',"Iceland", $getcsdl->origin == "Iceland").'>Iceland</option>';
echo '<option value="Indonesia"  '.set_select('origin',"Indonesia", $getcsdl->origin == "Indonesia").'>Indonesia</option>';
echo '<option value="Iran"  '.set_select('origin',"Iran", $getcsdl->origin == "Iran").'>Iran</option>';
echo '<option value="Iraq"  '.set_select('origin',"Iraq", $getcsdl->origin == "Iraq").'>Iraq</option>';
echo '<option value="Ireland"  '.set_select('origin',"Ireland", $getcsdl->origin == "Ireland").'>Ireland</option>';
echo '<option value="Israel"  '.set_select('origin',"Israel", $getcsdl->origin == "Israel").'>Israel</option>';
echo '<option value="Jamaica"  '.set_select('origin',"Jamaica", $getcsdl->origin == "Jamaica").'>Jamaica</option>';
echo '<option value="Jordan"  '.set_select('origin',"Jordan", $getcsdl->origin == "Jordan").'>Jordan</option>';
echo '<option value="Kazakhstan"  '.set_select('origin',"Kazakhstan", $getcsdl->origin == "Kazakhstan").'>Kazakhstan</option>';
echo '<option value="Kenya"  '.set_select('origin',"Kenya", $getcsdl->origin == "Kenya").'>Kenya</option>';
echo '<option value="Kiribati"  '.set_select('origin',"Kiribati", $getcsdl->origin == "Kiribati").'>Kiribati</option>';
echo '<option value="Kosovo"  '.set_select('origin',"Kosovo", $getcsdl->origin == "Kosovo").'>Kosovo</option>';
echo '<option value="Kuwait"  '.set_select('origin',"Kuwait", $getcsdl->origin == "Kuwait").'>Kuwait</option>';
echo '<option value="Kyrgyzstan"  '.set_select('origin',"Kyrgyzstan", $getcsdl->origin == "Kyrgyzstan").'>Kyrgyzstan</option>';
echo '<option value="Lào"  '.set_select('origin',"Lào", $getcsdl->origin == "Lào").'>Lào</option>';
echo '<option value="Latvia"  '.set_select('origin',"Latvia", $getcsdl->origin == "Latvia").'>Latvia</option>';
echo '<option value="Lesotho"  '.set_select('origin',"Lesotho", $getcsdl->origin == "Lesotho").'>Lesotho</option>';
echo '<option value="Liban"  '.set_select('origin',"Liban", $getcsdl->origin == "Liban").'>Liban</option>';
echo '<option value="Liberia"  '.set_select('origin',"Liberia", $getcsdl->origin == "Liberia").'>Liberia</option>';
echo '<option value="Libya"  '.set_select('origin',"Libya", $getcsdl->origin == "Libya").'>Libya</option>';
echo '<option value="Liechtenstein"  '.set_select('origin',"Liechtenstein", $getcsdl->origin == "Liechtenstein").'>Liechtenstein</option>';
echo '<option value="Liên bang Micronesia"  '.set_select('origin',"Liên bang Micronesia", $getcsdl->origin == "Liên bang Micronesia").'>Liên bang Micronesia</option>';
echo '<option value="Lithuania"  '.set_select('origin',"Lithuania", $getcsdl->origin == "Lithuania").'>Lithuania</option>';
echo '<option value="Luxembourg"  '.set_select('origin',"Luxembourg", $getcsdl->origin == "Luxembourg").'>Luxembourg</option>';
echo '<option value="Ma-rốc"  '.set_select('origin',"Ma-rốc", $getcsdl->origin == "Ma-rốc").'>Ma-rốc</option>';
echo '<option value="Madagascar"  '.set_select('origin',"Madagascar", $getcsdl->origin == "Madagascar").'>Madagascar</option>';
echo '<option value="Malawi"  '.set_select('origin',"Malawi", $getcsdl->origin == "Malawi").'>Malawi</option>';
echo '<option value="Malaysia"  '.set_select('origin',"Malaysia", $getcsdl->origin == "Malaysia").'>Malaysia</option>';
echo '<option value="Maldives"  '.set_select('origin',"Maldives", $getcsdl->origin == "Maldives").'>Maldives</option>';
echo '<option value="Mali"  '.set_select('origin',"Mali", $getcsdl->origin == "Mali").'>Mali</option>';
echo '<option value="Malta"  '.set_select('origin',"Malta", $getcsdl->origin == "Malta").'>Malta</option>';
echo '<option value="Mauritania"  '.set_select('origin',"Mauritania", $getcsdl->origin == "Mauritania").'>Mauritania</option>';
echo '<option value="Mauritius"  '.set_select('origin',"Mauritius", $getcsdl->origin == "Mauritius").'>Mauritius</option>';
echo '<option value="Mexico"  '.set_select('origin',"Mexico", $getcsdl->origin == "Mexico").'>Mexico</option>';
echo '<option value="&#65279;Moldova"  '.set_select('origin',"&#65279;Moldova", $getcsdl->origin == "&#65279;Moldova").'>&#65279;Moldova</option>';
echo '<option value="Monaco"  '.set_select('origin',"Monaco", $getcsdl->origin == "Monaco").'>Monaco</option>';
echo '<option value="Mông Cổ"  '.set_select('origin',"Mông Cổ", $getcsdl->origin == "Mông Cổ").'>Mông Cổ</option>';
echo '<option value="Montenegro"  '.set_select('origin',"Montenegro", $getcsdl->origin == "Montenegro").'>Montenegro</option>';
echo '<option value="Mozambique"  '.set_select('origin',"Mozambique", $getcsdl->origin == "Mozambique").'>Mozambique</option>';
echo '<option value="Myanmar"  '.set_select('origin',"Myanmar", $getcsdl->origin == "Myanmar").'>Myanmar</option>';
echo '<option value="Na Uy"  '.set_select('origin',"Na Uy", $getcsdl->origin == "Na Uy").'>Na Uy</option>';
echo '<option value="Nam Phi"  '.set_select('origin',"Nam Phi", $getcsdl->origin == "Nam Phi").'>Nam Phi</option>';
echo '<option value="Nam Sudan"  '.set_select('origin',"Nam Sudan", $getcsdl->origin == "Nam Sudan").'>Nam Sudan</option>';
echo '<option value="Namibia"  '.set_select('origin',"Namibia", $getcsdl->origin == "Namibia").'>Namibia</option>';
echo '<option value="Nauru"  '.set_select('origin',"Nauru", $getcsdl->origin == "Nauru").'>Nauru</option>';
echo '<option value="Nepal"  '.set_select('origin',"Nepal", $getcsdl->origin == "Nepal").'>Nepal</option>';
echo '<option value="New Zealand"  '.set_select('origin',"New Zealand", $getcsdl->origin == "New Zealand").'>New Zealand</option>';
echo '<option value="Nga"  '.set_select('origin',"Nga", $getcsdl->origin == "Nga").'>Nga</option>';
echo '<option value="Nhật Bản"  '.set_select('origin',"Nhật Bản", $getcsdl->origin == "Nhật Bản").'>Nhật Bản</option>';
echo '<option value="Nicaragua"  '.set_select('origin',"Nicaragua", $getcsdl->origin == "Nicaragua").'>Nicaragua</option>';
echo '<option value="Niger"  '.set_select('origin',"Niger", $getcsdl->origin == "Niger").'>Niger</option>';
echo '<option value="Nigeria"  '.set_select('origin',"Nigeria", $getcsdl->origin == "Nigeria").'>Nigeria</option>';
echo '<option value="Oman"  '.set_select('origin',"Oman", $getcsdl->origin == "Oman").'>Oman</option>';
echo '<option value="Pakistan"  '.set_select('origin',"Pakistan", $getcsdl->origin == "Pakistan").'>Pakistan</option>';
echo '<option value="Palau"  '.set_select('origin',"Palau", $getcsdl->origin == "Palau").'>Palau</option>';
echo '<option value="Palestine"  '.set_select('origin',"Palestine", $getcsdl->origin == "Palestine").'>Palestine</option>';
echo '<option value="Panama"  '.set_select('origin',"Panama", $getcsdl->origin == "Panama").'>Panama</option>';
echo '<option value="Papua New Guinea"  '.set_select('origin',"Papua New Guinea", $getcsdl->origin == "Papua New Guinea").'>Papua New Guinea</option>';
echo '<option value="Paraguay"  '.set_select('origin',"Paraguay", $getcsdl->origin == "Paraguay").'>Paraguay</option>';
echo '<option value="Peru"  '.set_select('origin',"Peru", $getcsdl->origin == "Peru").'>Peru</option>';
echo '<option value="Phần Lan"  '.set_select('origin',"Phần Lan", $getcsdl->origin == "Phần Lan").'>Phần Lan</option>';
echo '<option value="Pháp"  '.set_select('origin',"Pháp", $getcsdl->origin == "Pháp").'>Pháp</option>';
echo '<option value="Philippines"  '.set_select('origin',"Philippines", $getcsdl->origin == "Philippines").'>Philippines</option>';
echo '<option value="Qatar"  '.set_select('origin',"Qatar", $getcsdl->origin == "Qatar").'>Qatar</option>';
echo '<option value="Quần đảo Marshall"  '.set_select('origin',"Quần đảo Marshall", $getcsdl->origin == "Quần đảo Marshall").'>Quần đảo Marshall</option>';
echo '<option value="Quần đảo Solomon"  '.set_select('origin',"Quần đảo Solomon", $getcsdl->origin == "Quần đảo Solomon").'>Quần đảo Solomon</option>';
echo '<option value="Romania"  '.set_select('origin',"Romania", $getcsdl->origin == "Romania").'>Romania</option>';
echo '<option value="Rwanda"  '.set_select('origin',"Rwanda", $getcsdl->origin == "Rwanda").'>Rwanda</option>';
echo '<option value="Saint Kitts và Nevis"  '.set_select('origin',"Saint Kitts và Nevis", $getcsdl->origin == "Saint Kitts và Nevis").'>Saint Kitts và Nevis</option>';
echo '<option value="Saint Lucia"  '.set_select('origin',"Saint Lucia", $getcsdl->origin == "Saint Lucia").'>Saint Lucia</option>';
echo '<option value="Saint Vincent và Grenadines"  '.set_select('origin',"Saint Vincent và Grenadines", $getcsdl->origin == "Saint Vincent và Grenadines").'>Saint Vincent và Grenadines</option>';
echo '<option value="Samoa"  '.set_select('origin',"Samoa", $getcsdl->origin == "Samoa").'>Samoa</option>';
echo '<option value="San Marino"  '.set_select('origin',"San Marino", $getcsdl->origin == "San Marino").'>San Marino</option>';
echo '<option value="São Tomé và Príncipe"  '.set_select('origin',"São Tomé và Príncipe", $getcsdl->origin == "São Tomé và Príncipe").'>São Tomé và Príncipe</option>';
echo '<option value="Senegal"  '.set_select('origin',"Senegal", $getcsdl->origin == "Senegal").'>Senegal</option>';
echo '<option value="Serbia"  '.set_select('origin',"Serbia", $getcsdl->origin == "Serbia").'>Serbia</option>';
echo '<option value="Seychelles"  '.set_select('origin',"Seychelles", $getcsdl->origin == "Seychelles").'>Seychelles</option>';
echo '<option value="Sierra Leone"  '.set_select('origin',"Sierra Leone", $getcsdl->origin == "Sierra Leone").'>Sierra Leone</option>';
echo '<option value="Singapore"  '.set_select('origin',"Singapore", $getcsdl->origin == "Singapore").'>Singapore</option>';
echo '<option value="Síp"  '.set_select('origin',"Síp", $getcsdl->origin == "Síp").'>Síp</option>';
echo '<option value="Slovakia"  '.set_select('origin',"Slovakia", $getcsdl->origin == "Slovakia").'>Slovakia</option>';
echo '<option value="Slovenia"  '.set_select('origin',"Slovenia", $getcsdl->origin == "Slovenia").'>Slovenia</option>';
echo '<option value="Somalia"  '.set_select('origin',"Somalia", $getcsdl->origin == "Somalia").'>Somalia</option>';
echo '<option value="Sri Lanka"  '.set_select('origin',"Sri Lanka", $getcsdl->origin == "Sri Lanka").'>Sri Lanka</option>';
echo '<option value="Sudan"  '.set_select('origin',"Sudan", $getcsdl->origin == "Sudan").'>Sudan</option>';
echo '<option value="Suriname"  '.set_select('origin',"Suriname", $getcsdl->origin == "Suriname").'>Suriname</option>';
echo '<option value="Swaziland"  '.set_select('origin',"Swaziland", $getcsdl->origin == "Swaziland").'>Swaziland</option>';
echo '<option value="Syria"  '.set_select('origin',"Syria", $getcsdl->origin == "Syria").'>Syria</option>';
echo '<option value="Tajikistan"  '.set_select('origin',"Tajikistan", $getcsdl->origin == "Tajikistan").'>Tajikistan</option>';
echo '<option value="Tanzania"  '.set_select('origin',"Tanzania", $getcsdl->origin == "Tanzania").'>Tanzania</option>';
echo '<option value="Tây Ban Nha"  '.set_select('origin',"Tây Ban Nha", $getcsdl->origin == "Tây Ban Nha").'>Tây Ban Nha</option>';
echo '<option value="Thái Lan"  '.set_select('origin',"Thái Lan", $getcsdl->origin == "Thái Lan").'>Thái Lan</option>';
echo '<option value="Thành Vatican"  '.set_select('origin',"Thành Vatican", $getcsdl->origin == "Thành Vatican").'>Thành Vatican</option>';
echo '<option value="Thổ Nhĩ Kỳ"  '.set_select('origin',"Thổ Nhĩ Kỳ", $getcsdl->origin == "Thổ Nhĩ Kỳ").'>Thổ Nhĩ Kỳ</option>';
echo '<option value="Thụy Điển"  '.set_select('origin',"Thụy Điển", $getcsdl->origin == "Thụy Điển").'>Thụy Điển</option>';
echo '<option value="Thụy Sĩ"  '.set_select('origin',"Thụy Sĩ", $getcsdl->origin == "Thụy Sĩ").'>Thụy Sĩ</option>';
echo '<option value="Togo"  '.set_select('origin',"Togo", $getcsdl->origin == "Togo").'>Togo</option>';
echo '<option value="Tonga"  '.set_select('origin',"Tonga", $getcsdl->origin == "Tonga").'>Tonga</option>';
echo '<option value="Triều Tiên"  '.set_select('origin',"Triều Tiên", $getcsdl->origin == "Triều Tiên").'>Triều Tiên</option>';
echo '<option value="Trinidad và Tobago"  '.set_select('origin',"Trinidad và Tobago", $getcsdl->origin == "Trinidad và Tobago").'>Trinidad và Tobago</option>';
echo '<option value="Trung Quốc"  '.set_select('origin',"Trung Quốc", $getcsdl->origin == "Trung Quốc").'>Trung Quốc</option>';
echo '<option value="Tunisia"  '.set_select('origin',"Tunisia", $getcsdl->origin == "Tunisia").'>Tunisia</option>';
echo '<option value="Turkmenistan"  '.set_select('origin',"Turkmenistan", $getcsdl->origin == "Turkmenistan").'>Turkmenistan</option>';
echo '<option value="Tuvalu"  '.set_select('origin',"Tuvalu", $getcsdl->origin == "Tuvalu").'>Tuvalu</option>';
echo '<option value="Úc"  '.set_select('origin',"Úc", $getcsdl->origin == "Úc").'>Úc</option>';
echo '<option value="Uganda"  '.set_select('origin',"Uganda", $getcsdl->origin == "Uganda").'>Uganda</option>';
echo '<option value="Ukraine"  '.set_select('origin',"Ukraine", $getcsdl->origin == "Ukraine").'>Ukraine</option>';
echo '<option value="Uruguay"  '.set_select('origin',"Uruguay", $getcsdl->origin == "Uruguay").'>Uruguay</option>';
echo '<option value="Uzbekistan"  '.set_select('origin',"Uzbekistan", $getcsdl->origin == "Uzbekistan").'>Uzbekistan</option>';
echo '<option value="Vanuatu"  '.set_select('origin',"Vanuatu", $getcsdl->origin == "Vanuatu").'>Vanuatu</option>';
echo '<option value="Venezuela"  '.set_select('origin',"Venezuela", $getcsdl->origin == "Venezuela").'>Venezuela</option>';
echo '<option value="Việt Nam"  '.set_select('origin',"Việt Nam", $getcsdl->origin == "Việt Nam").'>Việt Nam</option>';
echo '<option value="Ý"  '.set_select('origin',"Ý", $getcsdl->origin == "Ý").'>Ý</option>';
echo '<option value="Yemen"  '.set_select('origin',"Yemen", $getcsdl->origin == "Yemen").'>Yemen</option>';
echo '<option value="Zambia"  '.set_select('origin',"Zambia", $getcsdl->origin == "Zambia").'>Zambia</option>';
echo '<option value="Zimbabwe"  '.set_select('origin',"Zimbabwe", $getcsdl->origin == "Zimbabwe").'>Zimbabwe</option>';

						?>		
						</select>
                      </div>
                    </div>
                    <div class="form-group">

                      <label class="col-sm-3 control-label">Thứ Tự</label>

                      <div class="col-sm-6">

                        <input name="order" value="<?php if(!empty($getcsdl)&&!validation_errors()) echo $getcsdl->order;else echo set_value('order');?>" style="width:100px" min="0" max="100" class="form-control" type="number">

                      </div>

                    </div>

                    

                    

                    <div class="form-group">

                      <label class="col-sm-3 control-label"></label>

                      <div class="col-sm-6">

                      		<button class="btn btn-success btn-lg" type="submit">Cập nhật thương hiệu</button>

							<button class="btn btn-default btn-lg" type="button">Nhập Lại</button>  

                      </div>

                    </div>

                    

                    

                  </form>

                </div>

              </div>

            </div>











	