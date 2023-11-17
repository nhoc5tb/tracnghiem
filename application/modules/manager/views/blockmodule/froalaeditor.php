<div id="md-chatGPT" tabindex="-1" role="dialog" class="modal fade colored-header colored-header-primary">
    <div class="modal-dialog full-width">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" data-dismiss="modal" aria-hidden="true" class="close md-close"><span class="mdi mdi-close"></span></button>
            <h3 class="modal-title">Sử dụng ChatGPT để viết bài</h3>
          </div>
          <div class="modal-body">
            <div role="alert" class="alert alert-contrast alert-danger alert-dismissible" style="display: none;">
				<div class="icon"><span class="mdi mdi-close-circle-o"></span></div>
					<div class="message">
						<button type="button" data-dismiss="alert" aria-label="Close" class="close"><span aria-hidden="true" class="mdi mdi-close"></span></button>
						<p>Lỗi</p>
					</div>
				</div><!-- erro -->
            <div class="form-group" style="margin:0">
              <label>Câu hỏi</label>
              <input id="ai-question" value="" placeholder="Câu hỏi" class="form-control" type="text">
            </div>
			<div class="form-group" style="margin:0">
              <label></label>
              <button type="button" id="btn-ai-question" class="btn btn-primary">Hỏi Chat GPT</button>
            </div>
            <div class="form-group" style="margin:0">
              <label>Trả Lời</label>
              <textarea id="ai-content" class="form-control" rows="8"></textarea>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" data-dismiss="modal" class="btn btn-default md-close">Thoát</button>
            <button type="button" id="btn-ai-send" data-dismiss="modal" class="btn btn-primary md-close">Thêm Vào Bài Viết</button>
          </div>
        </div>
    </div>
</div>    

<div id="md-Rytr" tabindex="-1" role="dialog" class="modal fade colored-header colored-header-primary">
    <div class="modal-dialog full-width">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" data-dismiss="modal" aria-hidden="true" class="close md-close"><span class="mdi mdi-close"></span></button>
            <h3 class="modal-title">Sử dụng Rytr để soạn Outline</h3>
          </div>
          <div class="modal-body">
            <div role="alert" class="alert alert-contrast alert-danger alert-dismissible" style="display: none;">
				<div class="icon"><span class="mdi mdi-close-circle-o"></span></div>
					<div class="message">
						<button type="button" data-dismiss="alert" aria-label="Close" class="close"><span aria-hidden="true" class="mdi mdi-close"></span></button>
						<p>Lỗi</p>
					</div>
				</div><!-- erro -->
            <div class="form-group" style="margin:0">
              <label>Chủ đề</label>
              <input id="rytr-question" value="" placeholder="Từ khóa của chủ đề" class="form-control" type="text">
            </div>
			<div class="form-group" style="margin:0">
              <label></label>
              <button type="button" id="btn-rytr-question" class="btn btn-primary">Soạn Outline</button>
            </div>
            <div class="form-group" style="margin:0">
              <label>Trả Lời</label>
              <textarea id="rytr-content" class="form-control" rows="8"></textarea>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" data-dismiss="modal" class="btn btn-default md-close">Thoát</button>
            <button type="button" id="btn-rytr-send" data-dismiss="modal" class="btn btn-primary md-close">Thêm Vào Bài Viết</button>
          </div>
        </div>
    </div>
</div>  

<link href="<?php echo base_url() ?>assets/froala_editor_4.0.17/wysiwyg-editor.css" rel="stylesheet">
<textarea name="<?php echo $name ?>"  id="id_<?php echo $name ?>"><?php echo (isset($content_froalaeditor))?$content_froalaeditor:""; ?></textarea >
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.3.0/codemirror.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.3.0/mode/xml/xml.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/dompurify/2.2.7/purify.min.js"></script>
<script type="text/javascript" src="<?php echo base_url()?>assets/froala_editor_4.0.17/wysiwyg-editor.js"></script>
<script type="text/javascript">
$(function() {
	FroalaEditor.DefineIconTemplate('font_awesome', '<i class="fa fa-[NAME]" style="font-size: 2rem;"></i>');//khai báo thư viện icon
	PopupAi();
	codePlugin();
	// Button thêm 1 đoạn mã để nhúng code php vào cho hiển thị bài viết gợi ý hay liên quan	
  	FroalaEditor.DefineIcon('hints', {NAME: 'newspaper-o', template: 'font_awesome'});
	FroalaEditor.RegisterCommand('hints', {
		title: 'Thêm Block Bài Liên Quan',
		undo: false,
		focus: false,
		callback: function () {
			this.html.insert('<div class="ru-baivietgoiy" style="border: 1px solid #CCC;padding: 2px;text-align: center;">Bài gợi ý sẽ hiện ở đây</div>');
		}
	});
	// button định dạng cho bock ghi chú
	FroalaEditor.DefineIcon('ruCode', { NAME: 'sticky-note-o', template: 'font_awesome' });
	FroalaEditor.RegisterCommand('ruCode', {
		title: 'Khối Ghi Chú',
		undo: false,
		focus: false,
		callback: function () {
			if (!this.selection.inEditor()) {
				this.$element.focus();
			}
			var html = '<div class="fr-note-block">' + (this.selection.text() || '&#8203;') + '</div>';
			this.html.insert(html);
			this.selection.save();
		}
	});
	// button định dạng cho bock ghi chú
	FroalaEditor.DefineIcon('noteBlock', { NAME: 'sticky-note-o', template: 'font_awesome' });
	FroalaEditor.RegisterCommand('noteBlock', {
		title: 'Khối Ghi Chú',
		undo: false,
		focus: false,
		callback: function () {
			if (!this.selection.inEditor()) {
				this.$element.focus();
			}
			var html = '<div class="fr-note-block">' + (this.selection.text() || '&#8203;') + '</div>';
			this.html.insert(html);
			this.selection.save();
		}
	});
	// button định dạng cho Code
	FroalaEditor.DefineIcon('addCode', { NAME: 'code', template: 'font_awesome' });
	FroalaEditor.RegisterCommand('addCode', {
		title: 'Định dạng code',
		undo: false,
		focus: false,
		callback: function () {
			if (!this.selection.inEditor()) {
				this.$element.focus(); // Focus on editor if it's not.
			}
			var html = '<pre><code>' + (this.selection.text() || '&#8203;') + '</code></pre>';
			this.html.insert(html);
			this.selection.save();
		}
	});
	var editor = new FroalaEditor('#id_<?php echo $name ?>', {	
		toolbarButtons: {
			'moreText': {
				'buttons': ['PopupAi','RuCodePopup','insertHTML','bold', 'italic', 'underline', 'strikeThrough', 'subscript', 'superscript', 'fontFamily', 'fontSize', 'textColor', 'backgroundColor', 'inlineClass', 'inlineStyle', 'clearFormatting']
			},
			'moreParagraph': {
				'buttons': ['alignLeft', 'alignCenter', 'formatOLSimple', 'alignRight', 'alignJustify', 'formatOL', 'formatUL', 'paragraphFormat', 'paragraphStyle', 'lineHeight', 'outdent', 'indent', 'quote','ruCode']
			},
			'moreRich1': {
				'buttons': ['noteBlock','addCode','hints']
			},
			'moreRich': {
				'buttons': ['insertLink', 'insertImage', 'insertVideo', 'insertTable', 'emoticons', 'fontAwesome', 'specialCharacters', 'embedly', 'insertFile', 'insertHR']
			},
			'moreMisc': {
				'buttons': ['undo', 'redo', 'html', 'fullscreen', 'print', 'getPDF', 'spellChecker', 'selectAll', 'help'],
				'align': 'right',
				'buttonsVisible': 3
			}
		},		
		imageUploadURL: path_full + '/wysiwyg/upload',
		imageManagerLoadURL: path_full + '/wysiwyg',
		imageManagerDeleteURL: path_full + '/wysiwyg/delete',

		specialCharButtons: ["specialCharBack", "|"],

		//cho phép add Class 1 đoạn văn - menu nó nằm cạnh chỗ h1 h2
		paragraphFormatSelection: true,		
		paragraphStyles: {//lợi dụng chức năng này để nhúng Class tạo mục lục cho bài viết
			scrollspy: 'Mục Lục',
			scrollspy_1: 'Mục Lục 1.1',
			scrollspy_2: 'Mục Lục 1.2'
		},

		iframe: true,
		iframeStyleFiles: ['<?php echo base_url() ?>static/css/style.css', '<?php echo base_url() ?>static/css/froala_style.css'],

		heightMin: 300,
		theme: 'gray',
		encodeHTML: false,//tắt mã hóa chuỗi
		charCounterCount: true,//bộ đém kỹ tự,		
		//pastePlain: true,//loại bỏ css khi dán
		pasteAllowedStyleProps: ['font-weight','font-style'],//Danh sách các thuộc tính CSS được phép sử dụng cho các thẻ khi dán.'font-family', 'font-size', 'color'
		pasteDeniedAttrs: ['class', 'id'],

		quickInsertEnabled: true,

		imageDefaultWidth: 0,//ko set with cho hình
		toolbarStickyOffset: 60,//set top cho thụt xuống 60px
		toolbarSticky: true,
		fontFamilySelection: true,//show font
		fontSizeSelection: true,//show font size
		paragraphFormatSelection: true,//show thẻ H
		htmlRemoveTags: ['script', 'style', 'base'],	
		spellcheck: false,//tắt kiểm tra lỗi chính tả
		key: "1C%kZV[IX)_SL}UJHAEFZMUJOYGYQE[\\ZJ]RAe(+%$==",
		attribution: false,
		events: {
          focus: function () {
            //console.log('focus')
          },
          blur: function () {
            //console.log('blur')
          },
		  contentChanged: function () {
            //console.log('content changed')
          },
		  initialized: function () {
            //console.log('initialized');
          },
		  sendGPT: function () {
            let content = $("#ai-content").val().replace(/\n/g, '<br>');
			this.html.insert(content);
			clearchatGPT()
          },
		  sendRytr: function () {
            let content = $("#rytr-content").val().replace(/\n/g, '<br>');
			this.html.insert(content);
			clearRytr()
          },
        } 
 	});
	const btnChatGPT = document.getElementById('btn-ai-send');
    btnChatGPT.addEventListener('click', function(){
		editor.events.trigger('sendGPT');
	});

	const btnRytr = document.getElementById('btn-rytr-send');
    btnRytr.addEventListener('click', function(){
		editor.events.trigger('sendGPT');
	});
});
function PopupAi(){
	// Define popup template.
	FroalaEditor.POPUP_TEMPLATES["customPlugin.popup"] = '[_BUTTONS_][_CUSTOM_LAYER_]';
	// Define popup buttons.
	Object.assign(FroalaEditor.DEFAULTS, {
		popupButtons: ['popupClose', '|', 'chatGPT', 'Rytr'],
	});

	// The custom popup is defined inside a plugin (new or existing).
	FroalaEditor.PLUGINS.customPlugin = function (editor) {
	// Create custom popup.
		function initPopup () {
			// Popup buttons.
			var popup_buttons = '';
			// Create the list of buttons.
			if (editor.opts.popupButtons.length > 1) {
				popup_buttons += '<div class="fr-buttons">';
				popup_buttons += editor.button.buildList(editor.opts.popupButtons);
				popup_buttons += '</div>';
			}
			// Load popup template.
			var template = {
				buttons: popup_buttons,
				custom_layer: ''
			};
			// Create popup.
			var $popup = editor.popups.create('customPlugin.popup', template);
			return $popup;
		}
		// Show the popup
		function showPopup () {
			var $popup = editor.popups.get('customPlugin.popup');
			if (!$popup) $popup = initPopup();
			editor.popups.setContainer('customPlugin.popup', editor.$tb);
			var $btn = editor.$tb.find('.fr-command[data-cmd="PopupAi"]');
			var left = $btn.offset().left + $btn.outerWidth() / 2;
			var top = $btn.offset().top + (editor.opts.toolbarBottom ? 10 : $btn.outerHeight() - 10);
			editor.popups.show('customPlugin.popup', left, top, $btn.outerHeight());
		}
		function hidePopup () {
			editor.popups.hide('customPlugin.popup');
		}
		return {
			showPopup: showPopup,
			hidePopup: hidePopup
		}
	}

	// Khởi tạo icon cho chức năng gọi PopupAi.
	FroalaEditor.DefineIcon('buttonIcon', { NAME: 'star', SVG_KEY: 'star'})
	FroalaEditor.RegisterCommand('PopupAi', {
		title: 'Chức Năng Ai',
		icon: 'buttonIcon',
		undo: false,
		focus: false,
		plugin: 'customPlugin',
		callback: function () {
			this.customPlugin.showPopup();
		}
	});

	// Define custom popup close button icon and command.
	FroalaEditor.DefineIcon('popupClose', { NAME: 'times', SVG_KEY: 'back' });
	FroalaEditor.RegisterCommand('popupClose', {
		title: 'Close',
		undo: false,
		focus: false,
		callback: function () {
			this.customPlugin.hidePopup();
		}
	});

	//khai báo events sendGPT để popup chatGPT có thể gửi lệnh lại thông qua sự kiện này - nhớ thêm event vào bên trên
	FroalaEditor.RegisterCommand('sendGPT', {
		title: 'Trả bài viết của Ai Về',
		icon: 'buttonIcon',
		undo: true,
		focus: false,
		callback: function () {
		}
	});

	//Button chức năng chính
	FroalaEditor.DefineIcon('chatGPT', {NAME: 'user-secret', template: 'font_awesome'});
	FroalaEditor.RegisterCommand('chatGPT', {
		title: 'Dùng chatGPT',
		undo: false,
		focus: false,
		callback: function () {
			clearchatGPT();
			$("#ai-question").val(this.selection.text());
			$("#btn-ai-question").click(function(e){
				let question = document.querySelector("#ai-question").value;
				let elemetR = document.querySelector("#ai-content");				
				chatGPT(question,elemetR);
				e.preventDefault();
			})
			var modal = document.getElementById("md-chatGPT");
			$(modal).modal('show');			
		}
	});
	//Button chức năng chính
	FroalaEditor.DefineIcon('Rytr', {NAME: 'user-plus', template: 'font_awesome'});
	FroalaEditor.RegisterCommand('Rytr', {
		title: 'Dùng Rytr',
		undo: false,
		focus: false,
		callback: function () {
			clearRytr();
			$("#rytr-question").val(this.selection.text());
			$("#btn-rytr-question").click(function(e){
				let question = document.querySelector("#rytr-question").value;
				let elemetR = document.querySelector("#rytr-content");				
				Rytr(question,elemetR);
				e.preventDefault();
			})
			var modal = document.getElementById("md-Rytr");
			$(modal).modal('show');		
		}
	});
}
function codePlugin(){
	// Define popup template.
	FroalaEditor.POPUP_TEMPLATES["codePlugin.popup"] = '[_BUTTONS_][_CUSTOM_LAYER_]';
	// Define popup buttons.
	Object.assign(FroalaEditor.DEFAULTS, {
		popupBtnCode: ['codePopupClose', '|', 'thuonghieu', 'congty','website','email','sdt','dia-chi','year'],
	});

	// The custom popup is defined inside a plugin (new or existing).
	FroalaEditor.PLUGINS.codePlugin = function (editor) {
		// Create custom popup.
		function initPopup () {
			// Popup buttons.
			var popup_buttons = '';
			// Create the list of buttons.
			if (editor.opts.popupBtnCode.length > 1) {
					popup_buttons += '<div class="fr-buttons">';
					popup_buttons += editor.button.buildList(editor.opts.popupBtnCode);
					popup_buttons += '</div>';
			}
			// Load popup template.
			var template = {
					buttons: popup_buttons,
					custom_layer: ''
			};
			// Create popup.
			var $popup = editor.popups.create('codePlugin.popup', template); 
			return $popup;
		}
		// Show the popup
		function showPopup () {			
			var $popup = editor.popups.get('codePlugin.popup');
			if (!$popup) $popup = initPopup();
			editor.popups.setContainer('codePlugin.popup', editor.$tb);
			var $btn = editor.$tb.find('.fr-command[data-cmd="RuCodePopup"]');//codePopup -> trùng với tên  đăng ký RegisterCommand của button kích hoạt (dòng 402)
		
			var left = $btn.offset().left + $btn.outerWidth() / 2;
			var top = $btn.offset().top + (editor.opts.toolbarBottom ? 10 : $btn.outerHeight() - 10);
			editor.popups.show('codePlugin.popup', left, top, $btn.outerHeight());
		}
		function hidePopup () {
			editor.popups.hide('codePlugin.popup');
		}
		return {
			showPopup: showPopup,
			hidePopup: hidePopup
		}
	}//song hàm chứng năng của popup 
	// Khởi tạo icon cho chức năng gọi PopupAi.
	FroalaEditor.DefineIcon('RuCodePopup', { NAME: 'info-circle', template: 'font_awesome' })
	FroalaEditor.RegisterCommand('RuCodePopup', {
		title: 'Thông Tin Web',
		icon: 'RuCodePopup',
		undo: false,
		focus: false,
		plugin: 'codePlugin',
		callback: function () {
			this.codePlugin.showPopup();
		}
	});
	// Define custom popup close button icon and command.
	FroalaEditor.DefineIcon('codePopupClose', { NAME: 'times', SVG_KEY: 'back' });
	FroalaEditor.RegisterCommand('codePopupClose', {
		title: 'Close',
		undo: false,
		focus: false,
		callback: function () {
			this.codePlugin.hidePopup();
		}
	});
	//Button chức năng chính
	FroalaEditor.DefineIcon('thuonghieu', {NAME: 'trademark', template: 'font_awesome'});
	FroalaEditor.RegisterCommand('thuonghieu', {
		title: 'Thương Hiệu',
		undo: false,
		focus: false,
		callback: function () {
			var html = '[[thuong-hieu]]';
			this.html.insert(html);
			this.selection.save();
		}
	});
	FroalaEditor.DefineIcon('congty', {NAME: 'building', template: 'font_awesome'});
	FroalaEditor.RegisterCommand('congty', {
		title: 'Tên Công Ty',
		undo: false,
		focus: false,
		callback: function () {
			var html = '[[cong-ty]]';
			this.html.insert(html);
			this.selection.save();
		}
	});
	FroalaEditor.DefineIcon('website', {NAME: 'internet-explorer', template: 'font_awesome'});
	FroalaEditor.RegisterCommand('website', {
		title: 'Website',
		undo: false,
		focus: false,
		callback: function () {
			var html = '[[website]]';
			this.html.insert(html);
			this.selection.save();
		}
	});
	FroalaEditor.DefineIcon('email', {NAME: 'envelope', template: 'font_awesome'});
	FroalaEditor.RegisterCommand('email', {
		title: 'E-mail',
		undo: false,
		focus: false,
		callback: function () {
			var html = '[[email]]';
			this.html.insert(html);
			this.selection.save();
		}
	});
	FroalaEditor.DefineIcon('sdt', {NAME: 'phone', template: 'font_awesome'});
	FroalaEditor.RegisterCommand('sdt', {
		title: 'Số điện thoại',
		undo: false,
		focus: false,
		callback: function () {
			var html = '[[sdt]]';
			this.html.insert(html);
			this.selection.save();
		}
	});
	FroalaEditor.DefineIcon('dia-chi', {NAME: 'map-marker', template: 'font_awesome'});
	FroalaEditor.RegisterCommand('diachi', {
		title: 'Địa chỉ',
		undo: false,
		focus: false,
		callback: function () {
			var html = '[[dia-chi]]';
			this.html.insert(html);
			this.selection.save();
		}
	});	
	FroalaEditor.DefineIcon('year', {NAME: 'calendar-o', template: 'font_awesome'});
	FroalaEditor.RegisterCommand('year', {
		title: 'Chèm năm thay đổi theo thời gian thực',
		undo: false,
		focus: false,
		callback: function () {
			var html = '[[year]]';
			this.html.insert(html);
			this.selection.save();
		}
	});	
}
function clearchatGPT(){
	document.getElementById("ai-question").value = "";
  	document.getElementById("ai-content").value = "";
}
function chatGPT(question,elemetR){
	var Key_OpenAI = "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";
	elemetR.value  = "Đang viết ...";
    var DataPost = new XMLHttpRequest();
    DataPost.open("POST", "https://api.openai.com/v1/completions");
    DataPost.setRequestHeader("Accept", "application/json");
    DataPost.setRequestHeader("Content-Type", "application/json");
    DataPost.setRequestHeader("Authorization", "Bearer " + Key_OpenAI)
    DataPost.onreadystatechange = function() {
		if (DataPost.readyState === 4) {			
			var oJson = {}
			try {
				oJson = JSON.parse(DataPost.responseText);
			} catch (ex) {			
				elemetR.value  = "\nLỗi: " + ex.message;
			}
			if (oJson.error && oJson.error.message) {				
				elemetR.value  = "\nLỗi: " + oJson.error.message;
			} else if (oJson.choices && oJson.choices[0].text) {
				elemetR.value = "";
				var s = oJson.choices[0].text;
				if ("vi-VN" != "vi-VN") {
					var a = s.split("?\n");
					if (a.length == 2) {
						s = a[1];
					}
				}
				if (s == "") s = "Không Có Phản Hồi";
				elemetR.value += s.trim();				
			}
		}
	};
	var sModel = "text-davinci-003"; //Mặc Định: "text-davinci-003";
	var iMaxTokens = 3000;//số từ trả về
	var sUserId = "1";
	var dTemperature = 0.5;
	var data = {
		model: sModel,
		prompt: question,//câu hỏi
		max_tokens: iMaxTokens,
		user: sUserId,
		temperature: dTemperature,
		frequency_penalty: 0.0,
		presence_penalty: 0.0,
		stop: ["#", ";"]
	}
	DataPost.send(JSON.stringify(data));
	if (elemetR.value != "") elemetR.value += "\n"; 
}
function clearRytr(){
	document.getElementById("rytr-question").value = "";
  	document.getElementById("rytr-content").value = "";
}
function Rytr(keywords,elemetR){
	//https://github.com/rytr-me/documentation
	const data = {
	languageId: "607adac76f8fe5000c1e636d",//việt nam : 60c65522bca5d4000cc679fa
	toneId: "60572a639bdd4272b8fe358b",
	useCaseId: "60a40cf5da9d76000ccc2828",
	userId:"90cb92df-91c8-464d-9849-bccbe75fa387365ee6",
	inputContexts: {
		"PRIMARY_KEYWORD_LABEL": keywords
	},
	variations: 3,	
	format: "text",
	creativityLevel: "1default"
	};

	fetch("https://api.rytr.me/v1/ryte", {
	method: "POST",
	headers: {
		"Authentication": "Bearer GK7PPTH_CDE1KVVLY6EMS",
		"Content-Type": "application/json"
	},
	body: JSON.stringify(data)
	})
	.then(response => response.json())
	.then(data => console.log(data))
	.catch(error => console.log(error));
}
</script>

