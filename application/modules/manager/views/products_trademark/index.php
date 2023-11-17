<link href="<?php echo base_url() ?>assets/css/bootstrap-imageupload.css" rel="stylesheet">
<ol class="breadcrumb">
	<li><a href="<?php echo base_url().$module?>"><span class="icon mdi mdi-home"></span></a></li>
	<li><a href="<?php echo base_url().$module."/".$controller?>"><?php echo $controller_title ?></a></li>
</ol>

<div class="row">
<div class="col-md-12">
<div class="panel panel-default panel-table">
	<div class="panel-heading panel-heading-divider"><?php echo $controller_title ?></div>
		<div class="panel-body">      
        <table class="table table-striped table-hover">
            <thead>
                <tr>
                	<th style="width:90px">Thứ Tự</th>
                    <th>Tiêu đề</th>
                    <th></th>
                    <th>Ngày tạo</th>
                    <th>Người tạo</th>
                    <th>Hoạt Động</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
            <?php foreach($catalogs as $row):?>
                <tr id="id<?php echo $row->id ?>">
                    <td align="center"><strong><?php echo $row->order ?></strong></td>
                    <td><strong><?php echo $row->title ?></strong></td>
                    <td>
					<?php 
								if(!empty($row->logo)):
							?>
								<img src="<?php echo $this->ruadmin->geturlimg($row->logo,$config_upload["dirweb"]); ?>" width="130" />
							<?php else: ?>   
								<img src="<?php echo base_url() ?>assets/img/no_image.gif"  width="80"/> 
							<?php endif; ?>
                   	</td>
                    <td><?php echo $row->created ?></td>
                    <td><?php echo $row->created_by ?></td>
                    <td>
                        <div class="switch-button switch-button-yesno">
                            <input type="checkbox" <?php echo ($row->status == 1)?'checked="true"':'' ?> id="swt<?php echo $row->id ?>"><span>
                            <label class="status" data-id="<?php echo $row->id ?>" for="swt<?php echo $row->id ?>" data-path="<?php echo base_url($module)."/".$controller ?>/status/<?php echo $row->id ?>"></label></span>
                        </div>
                    </td>
                    <td>
                        <?php echo $this->rurole->showPermission("edit",$row->id) ?>
                        <?php echo $this->rurole->showPermission("delete",$row->id) ?>
                    </td>
                </tr>
            <?php endforeach ?>
            </tbody>
        </table>
        </div>
	</div>
</div>
</div>
<div class="panel panel-default panel-border-color panel-border-color-primary">
	<div class="panel-heading panel-heading-divider">Thêm Thương Hiệu</div>
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
		<form action="<?php echo base_url().$module.'/'.$controller ?>/add"  style="border-radius: 0px;" class="form-horizontal group-border-dashed"  method="post" enctype="multipart/form-data">
			<input type="hidden" name="<?php echo $this->security->get_csrf_token_name() ?>" value="<?php echo $this->security->get_csrf_hash() ?>" />
			<div class="form-group">
				<label class="col-sm-3 control-label">Tên thương hiệu</label>
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
			<div class="form-group">
                      <label class="col-sm-3 control-label">Keywords</label>
                      <div class="col-sm-6">
                        <input name="keywords" value="<?php if(!empty($getcsdl) && !validation_errors()) echo $getcsdl->keywords;else echo set_value('keywords');?>" placeholder="Keywords" class="form-control" type="text">
                      </div>
			</div>

			<div class="form-group">
                      <label class="col-sm-3 control-label">Description</label>
                      <div class="col-sm-6">
                        <textarea class="form-control" name="description"><?php if(!empty($getcsdl) && !validation_errors()) echo $getcsdl->description;else echo set_value('description');?></textarea>
                      </div>
			</div>
			<div class="form-group">
                      <label class="col-sm-3 control-label">Xuất Xứ</label>
                      <div class="col-sm-6">
                      	<select class="select2"  name="origin">
							<option value="">Ko xác định</option>  
							<option value="Ả Rập Xê Út">Ả Rập Xê Út    </option>
							<option value="Afghanistan">Afghanistan    </option>
							<option value="Ai Cập">Ai Cập    </option>
							<option value="Albania">Albania</option>
							<option value="Algeria">Algeria</option>
							<option value="Ấn Độ">Ấn Độ</option>
							<option value="Andorra">Andorra</option>
							<option value="Angola">Angola</option>
							<option value="Anh">Anh</option>
							<option value="Antigua và Barbuda">Antigua và Barbuda</option>
							<option value="Áo">Áo</option>
							<option value="Argentina">Argentina</option>
							<option value="Armenia">Armenia</option>
							<option value="Azerbaijan">Azerbaijan</option>
							<option value="Ba Lan">Ba Lan</option>
							<option value="Bắc Macedonia">Bắc Macedonia</option>
							<option value="Bahamas">Bahamas</option>
							<option value="Bahrain">Bahrain</option>
							<option value="Bangladesh">Bangladesh</option>
							<option value="Barbados">Barbados</option>
							<option value="Belarus">Belarus</option>
							<option value="Belize">Belize</option>
							<option value="Bénin">Bénin</option>
							<option value="Bhutan">Bhutan</option>
							<option value="Bỉ">Bỉ</option>
							<option value="Bờ Biển Ngà">Bờ Biển Ngà</option>
							<option value="Bồ Đào Nha">Bồ Đào Nha</option>
							<option value="Bolivia">Bolivia</option>
							<option value="Bosnia và Herzegovina">Bosnia và Herzegovina</option>
							<option value="Botswana">Botswana</option>
							<option value="Brazil">Brazil</option>
							<option value="Brunei">Brunei</option>
							<option value="Bulgaria">Bulgaria</option>
							<option value="Burkina Faso">Burkina Faso</option>
							<option value="Burundi">Burundi</option>
							<option value="Các tiểu vương quốc Ả Rập Thống nhất">Các tiểu vương quốc Ả Rập Thống nhất</option>
							<option value="Cameroon">Cameroon</option>
							<option value="Campuchia">Campuchia</option>
							<option value="Canada">Canada</option>
							<option value="Cape Verde">Cape Verde</option>
							<option value="Chad">Chad</option>
							<option value="Chile">Chile</option>
							<option value="Colombia">Colombia</option>
							<option value="Comoros">Comoros</option>
							<option value="Cộng hòa Congo">Cộng hòa Congo</option>
							<option value="Cộng hòa dân chủ Congo">Cộng hòa dân chủ Congo</option>
							<option value="Cộng hòa Dominican">Cộng hòa Dominican</option>
							<option value="Cộng hòa Séc">Cộng hòa Séc</option>
							<option value="Cộng hòa Trung Phi">Cộng hòa Trung Phi</option>
							<option value="Costa Rica">Costa Rica</option>
							<option value="Croatia">Croatia</option>
							<option value="Cuba">Cuba</option>
							<option value="Djibouti">Djibouti</option>
							<option value="Dominica">Dominica</option>
							<option value="Đài Loan">Đài Loan</option>
							<option value="Đan Mạch">Đan Mạch</option>
							<option value="Đông Timor">Đông Timor</option>
							<option value="Đức">Đức</option>
							<option value="Ecuador">Ecuador</option>
							<option value="El Salvador">El Salvador</option>
							<option value="Eritrea">Eritrea</option>
							<option value="Estonia">Estonia</option>
							<option value="Ethiopia">Ethiopia</option>
							<option value="Fiji">Fiji</option>
							<option value="Gabon">Gabon</option>
							<option value="Gambia">Gambia</option>
							<option value="Georgia">Georgia</option>
							<option value="Ghana">Ghana</option>
							<option value="Grenada">Grenada</option>
							<option value="Guatemala">Guatemala</option>
							<option value="Guinea">Guinea</option>
							<option value="Guinea Xích đạo">Guinea Xích đạo</option>
							<option value="Guinea-Bissau">Guinea-Bissau</option>
							<option value="Guyana">Guyana</option>
							<option value="Hà Lan">Hà Lan</option>
							<option value="Haiti">Haiti</option>
							<option value="Hàn Quốc">Hàn Quốc</option>
							<option value="Hoa Kỳ">Hoa Kỳ</option>
							<option value="Honduras">Honduras</option>
							<option value="Hungary">Hungary</option>
							<option value="Hy Lạp">Hy Lạp</option>
							<option value="Iceland">Iceland</option>
							<option value="Indonesia">Indonesia</option>
							<option value="Iran">Iran</option>
							<option value="Iraq">Iraq</option>
							<option value="Ireland">Ireland</option>
							<option value="Israel">Israel</option>
							<option value="Jamaica">Jamaica</option>
							<option value="Jordan">Jordan</option>
							<option value="Kazakhstan">Kazakhstan</option>
							<option value="Kenya">Kenya</option>
							<option value="Kiribati">Kiribati</option>
							<option value="Kosovo">Kosovo</option>
							<option value="Kuwait">Kuwait</option>
							<option value="Kyrgyzstan">Kyrgyzstan</option>
							<option value="Lào">Lào</option>
							<option value="Latvia">Latvia</option>
							<option value="Lesotho">Lesotho</option>
							<option value="Liban">Liban</option>
							<option value="Liberia">Liberia</option>
							<option value="Libya">Libya</option>
							<option value="Liechtenstein">Liechtenstein</option>
							<option value="Liên bang Micronesia">Liên bang Micronesia</option>
							<option value="Lithuania">Lithuania</option>
							<option value="Luxembourg">Luxembourg</option>
							<option value="Ma-rốc">Ma-rốc</option>
							<option value="Madagascar">Madagascar</option>
							<option value="Malawi">Malawi</option>
							<option value="Malaysia">Malaysia</option>
							<option value="Maldives">Maldives</option>
							<option value="Mali">Mali</option>
							<option value="Malta">Malta</option>
							<option value="Mauritania">Mauritania</option>
							<option value="Mauritius">Mauritius</option>
							<option value="Mexico">Mexico</option>
							<option value="&#65279;Moldova">&#65279;Moldova</option>
							<option value="Monaco">Monaco</option>
							<option value="Mông Cổ">Mông Cổ</option>
							<option value="Montenegro">Montenegro</option>
							<option value="Mozambique">Mozambique</option>
							<option value="Myanmar">Myanmar</option>
							<option value="Na Uy">Na Uy</option>
							<option value="Nam Phi">Nam Phi</option>
							<option value="Nam Sudan">Nam Sudan</option>
							<option value="Namibia">Namibia</option>
							<option value="Nauru">Nauru</option>
							<option value="Nepal">Nepal</option>
							<option value="New Zealand">New Zealand</option>
							<option value="Nga">Nga</option>
							<option value="Nhật Bản">Nhật Bản</option>
							<option value="Nicaragua">Nicaragua</option>
							<option value="Niger">Niger</option>
							<option value="Nigeria">Nigeria</option>
							<option value="Oman">Oman</option>
							<option value="Pakistan">Pakistan</option>
							<option value="Palau">Palau</option>
							<option value="Palestine">Palestine</option>
							<option value="Panama">Panama</option>
							<option value="Papua New Guinea">Papua New Guinea</option>
							<option value="Paraguay">Paraguay</option>
							<option value="Peru">Peru</option>
							<option value="Phần Lan">Phần Lan</option>
							<option value="Pháp">Pháp</option>
							<option value="Philippines">Philippines</option>
							<option value="Qatar">Qatar</option>
							<option value="Quần đảo Marshall">Quần đảo Marshall</option>
							<option value="Quần đảo Solomon">Quần đảo Solomon</option>
							<option value="Romania">Romania</option>
							<option value="Rwanda">Rwanda</option>
							<option value="Saint Kitts và Nevis">Saint Kitts và Nevis</option>
							<option value="Saint Lucia">Saint Lucia</option>
							<option value="Saint Vincent và Grenadines">Saint Vincent và Grenadines</option>
							<option value="Samoa">Samoa</option>
							<option value="San Marino">San Marino</option>
							<option value="São Tomé và Príncipe">São Tomé và Príncipe</option>
							<option value="Senegal">Senegal</option>
							<option value="Serbia">Serbia</option>
							<option value="Seychelles">Seychelles</option>
							<option value="Sierra Leone">Sierra Leone</option>
							<option value="Singapore">Singapore</option>
							<option value="Síp">Síp</option>
							<option value="Slovakia">Slovakia</option>
							<option value="Slovenia">Slovenia</option>
							<option value="Somalia">Somalia</option>
							<option value="Sri Lanka">Sri Lanka</option>
							<option value="Sudan">Sudan</option>
							<option value="Suriname">Suriname</option>
							<option value="Swaziland">Swaziland</option>
							<option value="Syria">Syria</option>
							<option value="Tajikistan">Tajikistan</option>
							<option value="Tanzania">Tanzania</option>
							<option value="Tây Ban Nha">Tây Ban Nha</option>
							<option value="Thái Lan">Thái Lan</option>
							<option value="Thành Vatican">Thành Vatican</option>
							<option value="Thổ Nhĩ Kỳ">Thổ Nhĩ Kỳ</option>
							<option value="Thụy Điển">Thụy Điển</option>
							<option value="Thụy Sĩ">Thụy Sĩ</option>
							<option value="Togo">Togo</option>
							<option value="Tonga">Tonga</option>
							<option value="Triều Tiên">Triều Tiên</option>
							<option value="Trinidad và Tobago">Trinidad và Tobago</option>
							<option value="Trung Quốc">Trung Quốc</option>
							<option value="Tunisia">Tunisia</option>
							<option value="Turkmenistan">Turkmenistan</option>
							<option value="Tuvalu">Tuvalu</option>
							<option value="Úc">Úc</option>
							<option value="Uganda">Uganda</option>
							<option value="Ukraine">Ukraine</option>
							<option value="Uruguay">Uruguay</option>
							<option value="Uzbekistan">Uzbekistan</option>
							<option value="Vanuatu">Vanuatu</option>
							<option value="Venezuela">Venezuela</option>
							<option value="Việt Nam">Việt Nam</option>
							<option value="Ý">Ý</option>
							<option value="Yemen">Yemen</option>
							<option value="Zambia">Zambia</option>
							<option value="Zimbabwe">Zimbabwe</option>

						</select>
                      </div>
                    </div>
			<div class="form-group">
                      <label class="col-sm-3 control-label">Thứ Tự</label>
                      <div class="col-sm-6">
                        <input name="order" value="<?php if(!validation_errors()) echo count($catalogs) + 1;else echo set_value('order');?>" style="width:100px" min="0" max="100" class="form-control" type="number">
                      </div>
			</div>                    

			<div class="form-group">
                      <label class="col-sm-3 control-label"></label>
                      <div class="col-sm-6">
                      		<button class="btn btn-primary btn-lg" type="submit">Thêm thương hiệu</button>
							<button class="btn btn-default btn-lg" type="button">Nhập Lại</button>  
                      </div>
			</div> 

		</form>
	</div>
	</div>
</div>

<?php $this->load->view("blockmodule/modal_dialog");?>   







	