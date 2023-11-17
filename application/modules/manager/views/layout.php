<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="shortcut icon" href="<?php echo base_url() ?>assets/img/logo-fav.png">
    <title><?php echo $title ?> | RuCpanel 3.0.0</title>
    <link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>assets/lib/perfect-scrollbar/css/perfect-scrollbar.min.css"/>
    <link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>assets/lib/material-design-icons/css/material-design-iconic-font.min.css"/>
    <link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>assets/lib/jquery.gritter/css/jquery.gritter.css"/>
    <link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>assets/lib/select2/css/select2.min.css"/>
    <link rel="stylesheet" href="<?php echo base_url() ?>assets/css/style.css?v=<?php echo $v ?>" type="text/css"/>
    <script type="text/javascript">
      var path = "<?php echo base_url() ?>";
      var path_full = "<?php echo base_url().$module ?>";
      var ru_csrf_token_name = '<?php echo $ru_csrf_token_name; ?>';
      var vel = "?v=<?php echo $v ?>";
    </script>
    <script src="<?php echo base_url() ?>assets/lib/jquery/jquery.min.js" type="text/javascript"></script>    
    <script src="<?php echo base_url() ?>assets/lib/easyNotify.js"></script>
    <script type="text/javascript">  
    /*   
      var callback = function(e) {
        window.location = path_full+"/order";
      }; 
      var options = {
          title: "THỐNG BÁO TỪ WEB",
          options: {
            body: "Bạn có một đơn hàng mới",
            icon: path+"assets/img/avatar6.png",
            lang: 'vi-VI',
            onClose: callback
          }
      };      
      var timeDeplay = 5000;
      var notifications = setInterval(function() {
          $.get(path+"upload/notifications_order.txt", function(data, status){
              if(data == "true"){
                $("#easyNotify").easyNotify(options);
                clearInterval(notifications);
              }
          });
      }, timeDeplay);
    */  
    </script>
  </head>
  <body>
    <div class="be-wrapper <?php echo ($action == "create_orders" or $action == "edit_orders")?'be-aside be-fixed-sidebar':'' ?>">
      <nav class="navbar navbar-default navbar-fixed-top be-top-header">
        <div class="container-fluid">
          <div class="navbar-header"><a href="<?php echo base_url($module) ?>" class="navbar-brand"></a></div>
          <div class="be-right-navbar">
            <ul class="nav navbar-nav navbar-right be-user-nav">
              <li class="dropdown"><a href="#" data-toggle="dropdown" role="button" aria-expanded="false" class="dropdown-toggle"><img src="<?php echo base_url() ?>assets/img/avatar.png" alt="Avatar"><span class="user-name"><?php echo $auth->name ?></span></a>
                <ul role="menu" class="dropdown-menu">
                  <li>
                    <div class="user-info">
                      <div class="user-name"><?php echo $auth->name ?></div>
                      <div>Đăng nhập lần cuối <br><?php echo $auth->lastvisited ?></div>
                    </div>
                  </li>
                  <li><a href="#"><span class="icon mdi mdi-face"></span> Nhật ký</a></li>
                  <li><a href="<?php echo base_url().$module ?>/Account/profile"><span class="icon mdi mdi-settings"></span> Cài đặt</a></li>
                  <li><a href="<?php echo base_url().$module ?>/auth/logout"><span class="icon mdi mdi-power"></span> Đăng xuất</a></li>
                </ul>
              </li>
            </ul>
            <div class="page-title"><span><?php echo $title ?></span></div>
            
          </div>
        </div>
      </nav>
      <div class="be-left-sidebar">
        <div class="left-sidebar-wrapper"><a href="#" class="left-sidebar-toggle">Danh Mục Chức Năng</a>
          <div class="left-sidebar-spacer">
            <div class="left-sidebar-scroll">
              <div class="left-sidebar-content">
              <ul class="sidebar-elements">
                  <li class="divider">Nội Dung</li>
                  <?php if($this->rurole->checkControler("dashboard","index")): ?>
                  <li <?php echo ($controller == "Dashboard")?'class="active"':''?>><a href="<?php echo base_url($module) ?>"><i class="icon mdi mdi-home"></i><span>Dashboard</span></a></li>
                  <?php endif ?>
                                   
                  
				  <?php if($this->rurole->checkControler("page")): ?>
                  <li class="parent<?php echo ($controller == "page" or $controller == "page_groups")?' active open':''?>"><a href="#"><i class="icon mdi mdi-assignment-o"></i><span>Trang Đơn</span></a>
                    <ul class="sub-menu">
                      <?php if($this->rurole->checkControler("page","index")): ?><li><a href="<?php echo base_url().$module ?>/page">Danh sách</a></li><?php endif ?>
                      <?php if($this->rurole->checkControler("page","add")): ?><li><a href="<?php echo base_url().$module ?>/page/add">Thêm trang đơn</a></li><?php endif ?>
                      <?php if($this->rurole->checkControler("page_groups","index")): ?><li><a href="<?php echo base_url().$module ?>/page_groups">Nhóm Trang</a></li><?php endif ?>
                    </ul>
                  </li>
                  <?php endif ?>
                  
                  <?php if($this->rurole->checkControler("news")): ?>
                  <li class="parent<?php echo ($controller == "news" or $controller == "news_catalog")?' active open':''?>"><a href="#"><i class="icon mdi mdi-assignment"></i><span>Trang Tin</span></a>
                    <ul class="sub-menu">
                      <?php if($this->rurole->checkControler("news","index")): ?><li><a href="<?php echo base_url().$module ?>/news">Danh sách</a></li><?php endif ?>
                      <?php if($this->rurole->checkControler("news","add")): ?><li><a href="<?php echo base_url().$module ?>/news/add">Thêm bài</a></li><?php endif ?>
                      <?php if($this->rurole->checkControler("news_catalogs","index")): ?><li><a href="<?php echo base_url().$module ?>/news_catalogs">Nhóm Trang</a></li><?php endif ?>
                    </ul>
                  </li>
                  <?php endif ?>
                  
                  <?php if($this->rurole->checkControler("ads")): ?>
                  <li class="parent<?php echo ($controller == "ads" or $controller == "ads_groups")?' active open':''?>"><a href="#"><i class="icon mdi mdi-collection-image"></i><span>Quảng Cáo</span></a>
                    <ul class="sub-menu">
                      <?php if($this->rurole->checkControler("ads","index")): ?><li><a href="<?php echo base_url().$module ?>/ads">Danh sách</a></li><?php endif ?>
                      <?php if($this->rurole->checkControler("ads","add")): ?><li><a href="<?php echo base_url().$module ?>/ads/add">Thêm quảng cáo</a></li><?php endif ?>
                      <?php if($this->rurole->checkControler("ads_groups","index")): ?><li><a href="<?php echo base_url().$module ?>/ads_groups">Nhóm quảng cáo</a></li><?php endif ?>
                    </ul>
                  </li>
                  <?php endif ?>
                  <li class="divider">Sản Phẩm</li>
                  
                  <?php if($this->rurole->checkControler("products")): ?>
                  <li class="parent<?php echo ($controller == "products" or $controller == "products_collection" or $controller == "products_combo" or $controller == "products_sale" )?' active open':''?>"><a href="#"><i class="icon mdi mdi-store"></i><span>Mặt Hàng</span></a>
                    <ul class="sub-menu">
                      <?php if($this->rurole->checkControler("products","index")): ?><li><a href="<?php echo base_url().$module ?>/products">Danh sách</a></li><?php endif ?>
                      <?php if($this->rurole->checkControler("products","add")): ?><li><a href="<?php echo base_url().$module ?>/products/add">Thêm mặt hàng</a></li><?php endif ?>
                      <?php if($this->rurole->checkControler("products_collection","index")): ?><li><a href="<?php echo base_url().$module ?>/products_collection">Bộ sưu tập</a></li><?php endif ?>
                      <?php if($this->rurole->checkControler("products_sale","index")): ?><li><a href="<?php echo base_url().$module ?>/products_sale">Đang giảm giá</a></li><?php endif ?>
                      <!--<?php if($this->rurole->checkControler("products_combo","index")): ?><li><a href="<?php echo base_url().$module ?>/products_combo">Tạo Combo</a></li><?php endif ?>-->
                      <!--<?php if($this->rurole->checkControler("hot_deal","index")): ?><li><a href="<?php echo base_url().$module ?>/hot_deal">Hot Deal</a></li><?php endif ?>-->
                    </ul>
                  </li>               
                  <?php endif ?>
                                    
                  <?php if($this->rurole->checkControler("products_catalogs")): ?>
                  <li class="parent<?php echo ($controller == "products_catalogs" or $controller == "products_catalogs")?' active open':''?>"><a href="#"><i class="icon mdi mdi-collection-text"></i> <span>Danh Mục</span></a>
                    <ul class="sub-menu">                      
                      <?php if($this->rurole->checkControler("products_catalogs","index")): ?><li><a href="<?php echo base_url().$module ?>/products_catalogs">Danh mục mặt hàng</a></li><?php endif ?>
                    </ul>
                  </li>               
                  <?php endif ?>
                  <?php if($this->rurole->checkControler("products_trademark")): ?>
                  <li class="parent<?php echo ($controller == "products_trademark" or $controller == "products_trademark")?' active open':''?>"><a href="#"><i class="icon mdi mdi-collection-plus"></i><span>Thương Hiệu</span></a>
                    <ul class="sub-menu">                      
                      <?php if($this->rurole->checkControler("products_trademark","index")): ?><li><a href="<?php echo base_url().$module ?>/products_trademark">Danh sách</a></li><?php endif ?>
                    </ul>
                  </li>               
                  <?php endif ?>

                  <?php if($this->rurole->checkControler("coupon")): ?>
                  <li class="parent<?php echo ($controller == "coupon_group")?' active open':''?>"><a href="#"><i class="icon mdi mdi-card-giftcard"></i> <span>Mã Khuyến Mãi</span></a>
                    <ul class="sub-menu">                      
                      <?php if($this->rurole->checkControler("coupon_group","index")): ?><li><a href="<?php echo base_url().$module ?>/coupon_group">Tạo Mã Coupon</a></li><?php endif ?>
                    </ul>
                  </li>               
                  <?php endif ?>

                  <?php if($this->rurole->checkControler("attrib")): ?>
                  <?php 
        				 	$avtive = NULL;
        				 	if($controller == "attrib_check" or $controller == "attrib_insert"){
        						$avtive = " active open";
        					}
        				  ?>
                  <li class="parent<?php echo $avtive?>"><a href="#"><i class="icon mdi mdi-group"></i><span>Thuộc Tính Sản Phẩm</span></a>
						<ul class="sub-menu">
							<?php if($this->rurole->checkControler("attrib_check","group")): ?><li><a href="<?php echo base_url().$module ?>/attrib_check/group">Nhóm Thuộc Tính Chọn</a></li><?php endif ?>
                            <?php if($this->rurole->checkControler("attrib_check","index")): ?><li><a href="<?php echo base_url().$module ?>/attrib_check">Thuộc Tính Chọn</a></li><?php endif ?>
                            <?php if($this->rurole->checkControler("attrib_check","quick")): ?><li><a href="<?php echo base_url().$module ?>/attrib_check/quick">Nhập nhanh TT Chọn</a></li><?php endif ?>
                            
				<?php if($this->rurole->checkControler("attrib_insert","group")): ?><li><a href="<?php echo base_url().$module ?>/attrib_insert/group">Nhóm Thuộc Tính Nhâp</a></li><?php endif ?>
                      <?php if($this->rurole->checkControler("attrib_insert","index")): ?><li><a href="<?php echo base_url().$module ?>/attrib_insert">Thuộc Tính Nhập</a></li><?php endif ?>
                      <?php if($this->rurole->checkControler("transport_fee","index")): ?><li><a href="<?php echo base_url().$module ?>/transport_fee">Phí vận chuyển</a></li><?php endif ?>
                        </ul>
                  </li>
                  <?php endif ?>
                  
                  <li class="divider">Khách Hàng</li>
                  
                  <?php if($this->rurole->checkControler("customer")): ?>
                  <li class="parent<?php echo ($controller == "customer")?' active open':''?>"><a href="#"><i class="icon mdi mdi-account-box-mail"></i><span>Khách Hàng</span></a>
                    <ul class="sub-menu">
                      <?php if($this->rurole->checkControler("customer","index")): ?><li><a href="<?php echo base_url().$module ?>/customer">Danh sách</a></li><?php endif ?>
                      <?php if($this->rurole->checkControler("customer","add")): ?><li style="display: none"><a href="<?php echo base_url().$module ?>/customer/add">Thêm khách hàng</a></li><?php endif ?>
                    </ul>
                  </li>
                  <?php endif ?>
                  <?php if($this->rurole->checkControler("customer")): ?>
                  <li style="display: none"> class="parent<?php echo ($controller == "customer")?' active open':''?>"><a href="#"><i class="icon mdi mdi-account-box-mail"></i><span>Thành Viên</span></a>
                    <ul class="sub-menu">
                      <?php if($this->rurole->checkControler("customer","index")): ?><li><a href="<?php echo base_url().$module ?>/customer">Danh sách</a></li><?php endif ?>
                      <?php if($this->rurole->checkControler("customer","add")): ?><li style="display: none"><a href="<?php echo base_url().$module ?>/customer/add">Thêm thành viên</a></li><?php endif ?>
                    </ul>
                  </li>
                  <?php endif ?>
                  
                  <?php if($this->rurole->checkControler("order")): ?>
                  <li class="parent<?php echo ($controller == "order")?' active open':''?>"><a href="#"><i class="icon mdi mdi-library"></i><span>Đơn Hàng</span></a>
                    <ul class="sub-menu">
                      <?php if($this->rurole->checkControler("order","index")): ?><li><a href="<?php echo base_url().$module ?>/order">Đơn đặt qua giỏ hàng</a></li><?php endif ?>
                      <?php if($this->rurole->checkControler("OrderFlash","index")): ?><li><a href="<?php echo base_url().$module ?>/OrderFlash">Đơn đặt qua báo giá</a></li><?php endif ?>
                    </ul>
                  </li>
                  <?php endif ?>
                  <?php if($this->rurole->checkControler("contact")): ?>
                  <li class="parent<?php echo ($controller == "contact")?' active open':''?>"><a href="#"><i class="icon mdi mdi-email"></i><span>Liên Hệ</span></a>
                    <ul class="sub-menu">
                      <?php if($this->rurole->checkControler("contact","index")): ?><li><a href="<?php echo base_url().$module ?>/contact">Danh sách</a></li><?php endif ?>
                    </ul>
                  </li>
                  <?php endif ?>
                  <?php if($this->rurole->checkControler("folow")): ?>
                  <li class="parent<?php echo ($controller == "folow")?' active open':''?>"><a href="#"><i class="icon mdi mdi-fire"></i><span>Nhận Tin</span></a>
                    <ul class="sub-menu">
                      <?php if($this->rurole->checkControler("folow","index")): ?><li><a href="<?php echo base_url().$module ?>/folow">Danh sách</a></li><?php endif ?>
                    </ul>
                  </li>
                  <?php endif ?>
                  
                  <?php if($this->rurole->checkControler("account")): ?>
                  <li class="divider">Quản Trị</li>
                  <li class="parent<?php echo ($controller == "account")?' active open':''?>"><a href="#"><i class="icon mdi mdi-accounts"></i><span>Quản trị viên</span></a>
                    <ul class="sub-menu">
                      <?php if($this->rurole->checkControler("account","index")): ?><li><a href="<?php echo base_url().$module ?>/account">Danh sách</a></li><?php endif ?>
                      <?php if($this->rurole->checkControler("account","add")): ?><li><a href="<?php echo base_url().$module ?>/account/add">Thêm quản trị</a></li><?php endif ?>                      
                    </ul>
                  </li>
                  <?php endif ?>
                  
                  <?php if($this->rurole->checkControler("role")): ?>
					  <?php if($this->rurole->checkControler("role","ListGroup")): ?><li><a href="<?php echo base_url().$module ?>/role/ListGroup"><i class="icon mdi mdi-account-calendar"></i><span>Nhóm quản trị</span></a>
                      <?php endif ?>
                  <?php endif ?>                 
                  <?php if($this->rurole->checkControler("settings")):?>
                  <li class="parent<?php echo ($controller == "settings" or $controller == "email")?' active open':''?>"><a href="#"><i class="icon mdi mdi-settings"></i><span>Cài Đặt</span></a>
                    <ul class="sub-menu">
                        <?php if($this->rurole->checkControler("settings","index")): ?><li><a href="<?php echo base_url().$module ?>/settings">Cài Đặt Meta</a></li><?php endif ?>
                        <?php if($this->rurole->checkControler("settings","web")): ?><li><a href="<?php echo base_url().$module ?>/settings/web">Cài Đặt Web</a></li><?php endif ?>
                        <?php if($this->rurole->checkControler("settings","web")): ?><li><a href="<?php echo base_url().$module ?>/menu">Cài Đặt Menu</a></li><?php endif ?>
                        <?php if($this->rurole->checkControler("email","index")): ?><li><a href="<?php echo base_url().$module ?>/email/index">Cài Đặt Email</a></li><?php endif ?>
                        <?php if($this->rurole->checkControler("settings","messenger")): ?><li><a href="<?php echo base_url().$module ?>/settings/messenger">Cài Đặt Ngôn Ngữ</a></li><?php endif ?>                
                    </ul>
                  </li>
                  <?php endif ?>
                  <?php if($this->rurole->checkControler("block_template")): ?>
                  <li class="parent<?php echo ($controller == "block_template")?' active open':''?>"><a href="#"><i class="icon mdi mdi-ungroup"></i><span>Block Giao Diện</span></a>
                    <ul class="sub-menu">
                      <?php if($this->rurole->checkControler("block_template","index")): ?><li><a href="<?php echo base_url().$module ?>/block_template">Danh sách</a></li><?php endif ?>
                      <?php if($this->rurole->checkControler("block_template","add")): ?><li><a href="<?php echo base_url().$module ?>/block_template/add">Tạo block</a></li><?php endif ?>
                    </ul>
                  </li>
                  <?php endif ?>
                </ul>
              </div>
            </div>
          </div>
          
        </div>
        
      </div>
      
      <div class="be-content">
        <div class="main-content container-fluid">
			<?php echo $content_for_layout ?>
        </div>
      </div>
      
    </div>
    <script src="<?php echo base_url() ?>assets/include/<?php echo $controller ?>.js?v=<?php echo $v ?>" type="text/javascript"></script>
  </body>
</html>