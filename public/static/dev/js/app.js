$(function(){
	$form = $('[name=form-builder]');
});

$('#preview').click(function(){
	console.log($form.serialize());
	$.post(preview_url, $form.serialize(),function(data){
		//页面层-自定义
		layer.open({
		  type: 1,
		  title: '预览插件主文件',
		  closeBtn: 1,
		  area: ['701px', '560px'],
		  shadeClose: true,
		  skin: 'yourclass',
		  content: '<div id="preview_window" class="loading"><textarea></textarea></div>'
		  ,success: function(layero){
		    var btn = layero.find('.layui-layer-btn');
		    var codemirror_option = {
					lineNumbers   :true,
					matchBrackets :true,
					mode          :"application/x-httpd-php",
					indentUnit    :4,
					gutter        :true,
					fixedGutter   :true,
					indentWithTabs:true,
					readOnly	  :true,
					lineWrapping  :true,
					height		  :459,
					enterMode     :"keep",
					tabMode       :"shift",
					theme: theme
				};
				var preview_window = layero.removeClass(".loading").find("textarea");
				var editor = CodeMirror.fromTextArea(preview_window[0], codemirror_option);
				editor.setValue(data);
				$(window).resize();
		  	}
		});

	});
	return false;
});
