(function(){
	tinymce.PluginManager.requireLangPack('scabn');
	tinymce.create('tinymce.plugins.scabnPlugin',
		{init:function(ed,url)
			{ed.addCommand('mcescabn',function()
				{ed.windowManager.open({file:url+'/dialog.php',width:420+parseInt(ed.getLang('scabn.delta_width',0)),height:500+parseInt(ed.getLang('scabn.delta_height',0)),inline:1},{plugin_url:url,some_custom_arg:'custom arg'})});
				ed.addButton('scabn',{title:'Add SCABN Item or Checkout',cmd:'mcescabn',image:url+'/img/wp-chkt.png'});ed.onNodeChange.add(function(ed,cm,n){cm.setActive('scabn',n.nodeName=='IMG')})},
				createControl:function(n,cm){return null},getInfo:function(){return{longname:'scabn plugin',author:'Some author',authorurl:'http://tinymce.moxiecode.com',infourl:'http://wiki.moxiecode.com/index.php/TinyMCE:Plugins/scabn',version:"1.0"}}});tinymce.PluginManager.add('scabn',tinymce.plugins.scabnPlugin)})();