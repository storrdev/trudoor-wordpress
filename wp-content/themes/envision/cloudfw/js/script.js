function cloudfw_init(){"use strict";jQuery(document).delegate(".cloudfw-upgrade-theme","click",function(a){var b=jQuery(this);return b.hasClass("apply")?void 0:(CloudFw_UI.sure.init({content:"Are you sure you want to upgrade "+CloudFwOp.themeName+" to the latest version? <br/><br/> Make sure backup your files if you had made change on the theme files.",texts:{sure:"Upgrade"},button_color:{sure:"green"},resume:function(){window.location.href=b.attr("href")},cancel:function(a){b.removeClass("apply"),a.close()}}),a.preventDefault(),!1)}),jQuery(document).delegate(".cloudfw-action-duplicate","click",function(a){var b=jQuery(this),c=b.attr("data-target"),d=c?jQuery(c):b.parent().children("ul").first(),e=d.children(),g=(e.length,e.first().clone().appendTo(d));cloudfw_reset_elements(g)}),jQuery(document).delegate(".cloudfw-action-only-duplicate","click",function(a){var b=jQuery(this),d=(b.attr("data-target"),b.parents("li").first()),e=d.clone().insertAfter(d),f=e.find("input.randomizer");f.length&&f.each(function(){var a=jQuery(this);a.val(cloudfw_randomizer(a.attr("data-length"),a.attr("data-prefix"),a.attr("data-chars")))}),cloudfw_main(e)}),jQuery(document).delegate(".cloudfw-action-remove","click",function(a){var b=jQuery(this);if(!b.hasClass("apply"))return CloudFw_UI.sure.init({resume:function(){b.addClass("apply").click()},cancel:function(a){b.removeClass("apply"),a.close()}}),a.preventDefault(),!1;b.removeClass("apply");var c=b.attr("data-target"),d=b.parents(""+c).first(),e=d.parent(),f=e.children(),g=f.length;if(jQuery(d).removeData(),jQuery("*",d).removeData(),g>1)d.remove();else if(1==g){var h=f.first().clone().appendTo(e);cloudfw_reset_elements(h),d.remove()}jQuery(".tipsy").remove()}),jQuery(document).delegate(".cloudfw-action-clone","click",function(a){var b=jQuery(this),c=b.parents("li").first(),e=(c.parent(),c.clone());c.after(e),cloudfw_main(e),jQuery(".tipsy").remove()}),jQuery(document).delegate(".cloudfw-action-edit","click",function(a){var b=jQuery(this),c=b.parents("li").first(),d=c.find(".gallery-item"),e=d.data("unique_key");e||(e=cloudfw_randomizer(10,"sidebar-","AZ-az"),d.data("unique_key",e));CloudFw_UI.modal({destroy:!1,overlay:!0,minimize:!1,compact:!0,width:802,id:"cloudfw-gallery-edit",title:"Gallery Item",content:function(a){d.wrap('<div id="'+e+'-cloudfw-placeholder" />'),jQuery(".cloudfw-ui-modal-box-content",a).html("");var b=d.clone();d.appendTo(jQuery(".cloudfw-ui-modal-box-content",a)).show(),jQuery("#"+e+"-cloudfw-placeholder").html(b)},before_close:function(){jQuery("#"+e+"-cloudfw-placeholder").html(""),d.appendTo(jQuery("#"+e+"-cloudfw-placeholder")).hide().unwrap()}});a.preventDefault()}),jQuery(document).delegate(".cloudfw-action-gallery-from-library","click",function(a){var b=jQuery(this),c=b.attr("data-target"),d=c?jQuery(c):b.parent().children("ul").first(),e=b.prev(".cloudfw-action-duplicate");a.preventDefault();var f;jQuery("input#post_ID").val();return f?void f.open():(f=wp.media.frames.file_frame=wp.media({filterable:"eml",button:{text:jQuery(this).data("uploader_button_text")},multiple:!0,states:[new wp.media.controller.Library({multiple:!0,priority:20,filterable:"eml"})]}),f.on("select",function(){var a=f.state().get("selection");a.map(function(a){a=a.toJSON();var b=d.children().last(),c=jQuery(".gallery-preview",b).attr("data-sync"),f=jQuery("#"+c,b);""!=f.val()&&(e.click(),b=d.children().last(),c=jQuery(".gallery-preview",b).attr("data-sync"),f=jQuery("#"+c,b)),f.val(a.url).change()})}),void f.open())}),jQuery(document).delegate(".slider-live-preview","click",function(a){jQuery(this).find(".slider-input").is(":visible")||(jQuery(this).find(".slider-input").show().find("input").focus().select(),jQuery(this).find(".cloudfw-tooltip").hide(),jQuery(".tipsy").remove())}),jQuery(document).delegate(".slider-input > input","focusout",function(a){jQuery(this).parent().hide(),jQuery(this).parent().parent().find(".cloudfw-tooltip").show()}),jQuery(document).delegate(".slider-input > input","keydown keyup",function(a){(13==a.which||27==a.which)&&(jQuery(this).blur().focusout(),a.preventDefault())}),jQuery(document).delegate("#slider_form, .sending_form, .slider_forms","submit",function(){var a=jQuery(this);if(a.hasClass("disabled"))return!1;a.addClass("disabled");a.find('input[name="slider_image"]').val(),a.find('input[name="slider_video"]').val();a.find(":submit").each(function(){jQuery(this).__sending()})}),jQuery(document).delegate("form#sorting_form","submit",function(a){var c=(jQuery(this),jQuery(this));if(c.hasClass("disabled"))return!1;c.find("#update_identifier").remove(),jQuery(c).trigger("ajaxPreSend",[c]);var d={action:"cloudfw_save_changes",nonce:CloudFwOp.cloudfw_nonce,no_form:"1"};return jQuery.ajax({url:CloudFwOp.ajaxUrl,cache:!1,type:"POST",data:jQuery.param(d,!0)+"&"+c.serialize(),success:function(a){try{var b=jQuery.parseJSON(a);cloudfw_dialog(b.messageTitle,b.messageText,b.messageCase)}catch(d){c.html(a)}jQuery(c).trigger("ajaxCallback",[c,a]),cloudfw_destroy()}}),!1}),jQuery(document).delegate(".cloudfw-ui-route","click",function(a){var b=jQuery(this),c=b.attr("title");return prompt("Route",c),!1}),jQuery.expr[":"].Search=function(a,b,c){return jQuery(a).val().toUpperCase().indexOf(c[3].toUpperCase())>=0},jQuery(document).delegate(".cloudfw-ui-label-check","click",function(a){if("A"!=a.target.nodeName){a.stopPropagation(),a.preventDefault();var b=jQuery(this),c=b.find(":checkbox").first();c.is(":checked")?(c.prop("checked",!1),b.removeClass("c_on")):(c.prop("checked",!0),b.addClass("c_on")),c.change()}}),jQuery(document).delegate(".cloudfw-ui-label-radio","click",function(a){if("A"!=a.target.nodeName){a.stopPropagation(),a.preventDefault();var b=jQuery(this),d=(b.parent(),b.find(":radio").first()),e=jQuery("input[name="+d.attr("name")+"]:radio");d.prop("checked",!0),jQuery(e).each(function(){var a=jQuery(this);a.parent("label").removeClass("r_on")}),b.addClass("r_on"),d.change()}}),jQuery(document).delegate(".module-set-closable > .module-set-header > h3","click",function(){var a=jQuery(this),b=a.parents(".module-set").first(),c=b.find(".module-content").first(),d=b.hasClass("module-set-group");b.hasClass("module-set-state-closed")?(c.show(),b.removeClass("module-set-state-closed").addClass("module-set-state-opened"),d&&b.parents("ul").first().find(".module-set").not(b).each(function(){jQuery(this).removeClass("module-set-state-opened").addClass("module-set-state-closed").find(".module-content").hide()}),cloudfw_destroy()):(c.hide(),b.removeClass("module-set-state-opened").addClass("module-set-state-closed"),cloudfw_destroy())}),jQuery(document).delegate(".cloudfw-ui-page-select","click",function(){var a=jQuery(this),b=a.parents(".cloudfw-ui-page-select-container"),c=b.find(".cloudfw-ui-page-select-input"),d=b.find(".cloudfw-ui-page-select-preview"),e=a.attr("data-response"),f=a.attr("data-preview"),g=a.attr("data-filter"),h=function(a,b,i,j){jQuery("#cloudfw-ui-page-select-search",b).on("keydown keyup",function(){var a=jQuery(this),c=a.val(),d=jQuery("#cloudfw-ui-page-select-list",b);if(""===c)return d.find("li").show(),d.find("li").length&&jQuery(".cloudfw-ui-not-found-text",b).hide(),!0;var e=d.find("li #data-title"),f=e.filter(":Search('"+c+"')");d.find("li").hide(),f.length>0?(f.each(function(){var a=jQuery(this);a.parents("li").first().show()}),jQuery(".cloudfw-ui-not-found-text",b).hide()):jQuery(".cloudfw-ui-not-found-text",b).show()}),a.success(j);var k=jQuery("#cloudfw-ui-page-select-list > li",b),l=k.find(".use");l.on("click",function(b){b.preventDefault();var g=jQuery(this).parents("li").first(),h=g.find("#data-ID").val(),i=g.find("#data-title").val(),j=g.find("#data-permalink").val();if("URL"==e)var k=j,i=j;else if("ID"==e||"id"==e)var k=h;else var k=i+"||"+j;c.val(k).trigger("change"),f&&d.length&&(d.find(".cloudfw-ui-page-select-title").text(i).attr("href",j),d.find(".cloudfw-ui-page-select-permalink").text(j),d.show(),c.hide()),a.close()}),jQuery("[data-page]",b).on("click",function(c){var d={action:"cloudfw_post_list_for_selector",nonce:CloudFwOp.cloudfw_nonce,filter:g,page:jQuery(this).attr("data-page")};a.loading("show"),jQuery.ajax({url:CloudFwOp.ajaxUrl,cache:!1,type:"POST",data:jQuery.param(d,!0),success:function(c){a.loading("close"),h(a,b,i,c),cloudfw_main()}})})},i=CloudFw_UI.modal({destroy:!1,overlay:!1,minimize:!1,id:"cloudfw-box-page-selector",title:"Select Page",loader:!0,content:function(a,b){var c={action:"cloudfw_post_list_for_selector",nonce:CloudFwOp.cloudfw_nonce,filter:g};jQuery.ajax({url:CloudFwOp.ajaxUrl,cache:!1,type:"POST",data:jQuery.param(c,!0),success:function(c){var d='<div class="modal-toolbar-search"><input id="cloudfw-ui-page-select-search" type="text" value="" class="input input_200" autocomplete="off" placeholder="type to search" /></div>';i.toolbar_option(d),h(i,a,b,c),cloudfw_main()}})}})}),jQuery(document).delegate(".cloudfw-ui-page-select-reset","click",function(){var a=jQuery(this);a.parent().hide().next("input").val("").show()});setInterval(function(){jQuery(".timer_hide").fadeOut(function(){jQuery(this).remove()})},8e3);shortcut.add("Ctrl+S",function(){jQuery(".ctrl_s_form").each(function(){var a=jQuery(this),b=a.children(".ui-tabs-panel"),c=b.length,d=!1;c>1?b.each(function(){return jQuery(this).is(":visible")?(d=!0,!0):void 0}):1==c?b.first().is(":visible")&&(d=!0):a.is(":visible")&&(d=!0),d&&a.submit()})},{type:"keydown",propagate:!1,target:document}),jQuery(document).ajaxStart(function(a,b,c){jQuery(".tipsy").remove()}),jQuery(document).delegate(".cloudfw-help","click",function(a){var b=jQuery(this).attr("rel"),c=jQuery(this).attr("width"),d=jQuery(this).attr("title");if("s"===c||""===c)var c=300;else if("m"===c)var c=600;else if("l"===c)var c=900;""==d&&(d="Help");CloudFw_UI.modal({destroy:!0,overlay:!0,minimize:!1,compact:!0,width:c,title:d,content:function(a){jQuery("#"+b).wrap('<div id="'+b+'-cloudfw-placeholder" />'),jQuery(".cloudfw-ui-modal-box-content",a).html(""),jQuery("#"+b).appendTo(jQuery(".cloudfw-ui-modal-box-content",a)).show()},before_close:function(){jQuery("#"+b).appendTo(jQuery("#"+b+"-cloudfw-placeholder")).hide().unwrap()}});a.preventDefault()}),jQuery(document).delegate(".cloudfw-ui-confirm","click",function(a){var b=jQuery(this);if(!b.hasClass("apply"))return CloudFw_UI.sure.init({compact:!0,content:b.attr("data-content")||"Do you want to delete the item?",resume:function(){b.addClass("apply").click()},cancel:function(a){b.removeClass("apply"),a.close()}}),!1;var c=b.attr("href");"undefined"!=typeof c&&"javascript:;"!=c&&"javascript:void(0);"!=c&&"#"!=c&&(window.location.href=b.attr("href"))}),jQuery(document).delegate(".ajax_form","submit",function(a){var b=jQuery(this);if(b.hasClass("disabled"))return!1;cloudfw_global_loading("show"),b.find("#update_identifier").remove(),b.addClass("disabled"),b.find(":submit").each(function(){jQuery(this).__sending()}),b.find("#save_apply").parent("div").hide(),jQuery(b).trigger("ajaxPreSend",[b]);var c={action:"cloudfw_save_changes",nonce:CloudFwOp.cloudfw_nonce};jQuery.ajax({url:CloudFwOp.ajaxUrl,cache:!1,type:"POST",data:jQuery.param(c,!0)+"&"+b.serialize(),success:function(a){try{var c=jQuery.parseJSON(a);b.find(":submit").each(function(){jQuery(this).__sending().success()}),cloudfw_dialog(c.messageTitle,c.messageText,c.messageCase),c.slider_id&&(b.find("input#slider_id").length>0?b.find("input#slider_id").val(c.slider_id):b.prepend('<input type="hidden" id="slider_id" name="slider_id" value="'+c.slider_id+'" />'),b.find(":submit").val(CloudFwOp.textUpdate).attr("data-old-val",CloudFwOp.textUpdate)),jQuery(b).trigger("ajaxCallback",[b,a])}catch(d){alert(a),b.find(":submit").each(function(){jQuery(this).__sending().error()}),cloudfw_dialog("We couldn't save :(","An error occurred when saving changes","error")}cloudfw_global_loading("hide"),cloudfw_destroy()}}),a.preventDefault(),a.stopPropagation()}),jQuery(document).delegate(".select-icon","click",function(a){a.preventDefault();var b=jQuery(this);b.find("img").length?b.parent().find(".library-icon-handler").click():b.parent().find(".font-icon-handler").click()}),jQuery(document).delegate(".cloudfw_sub_navigation_items a","click",function(){jQuery(document).trigger("click"),cloudfw_destroy()}),jQuery(document).delegate(".remove-icon","click",function(a){var b=jQuery(this).parent("div");b.addClass("empty"),b.find("input").val(""),b.find("i").remove(),b.find("img").remove(),a.preventDefault()}),jQuery(document).delegate(".remove-icon-handler","click",function(){var a=jQuery(this).parents(".wrap-icons").first(),b=a.find(".remove-icon");b.click()}),jQuery(document).delegate(".custom-icon-handler","click",function(a){var b=jQuery(this).parents(".wrap-icons").first(),c=b.find(".select-icon"),d=b.find("input"),e=b.find("img"),g=(d.val(),e.attr("src")),h=e.attr("data-at2x");CloudFw_UI.modal({id:"ui-custom-icon",loader:!0,dummy:!0,destroy:!1,overlay:!1,minimize:!1,compact:!0,width:400,title:"Custom Icon URL",content:function(a,e,f){var i="";if(i+='<div style="margin-top: 12px;">',i+="	<div><strong>Normal Image:</strong></div>",i+='	<div class="cloudfw-ui-uploader-container cloudfw-ui-uploader-no-value"><div class="minimal-upload"><input type="text" id="cloudfw-ui-icon-custom" value="" autocomplete="off" class="cloudfw-ui-uploader-input input" data-path="" style="width: 309px;" /><div id="file-uploader" class="cloudfw-ui-uploader" data-path="" data-remove-button="" data-library-button="" data-store=""><noscript><p>Please enable JavaScript to use file uploader.</p></noscript></div></div></div>',i+="</div>",i+='<div style="margin-top: 12px;">',i+="	<div><strong>Retina Image:</strong></div>",i+='	<div class="cloudfw-ui-uploader-container cloudfw-ui-uploader-no-value"><div class="minimal-upload"><input type="text" id="cloudfw-ui-icon-custom-retina" value="" autocomplete="off" class="cloudfw-ui-uploader-input input" data-path="" style="width: 309px;" /><div id="file-uploader" class="cloudfw-ui-uploader" data-path="" data-remove-button="" data-library-button="" data-store=""><noscript><p>Please enable JavaScript to use file uploader.</p></noscript></div></div></div>',i+="</div>",i+='<div style="margin-top: 6px; position: relative;">',i+='	<button type="submit" id="cloudfw-ui-icon-custom-done" href="javascript:;" class="small-button small-sky"><span>Done</span></button>',i+="</div>",f.success(i),cloudfw_main(e),jQuery(".cloudfw-dummy-form",e).submit(function(a){a.preventDefault();var g="",h=jQuery("#cloudfw-ui-icon-custom",e).val(),i=jQuery("#cloudfw-ui-icon-custom-retina",e).val();if(g=""!=h&&""!=i?h+"||"+i:h,""!=g){d.val(g);var j=jQuery("<img />").attr("src",h).attr("data-at2x",i);c.find("img").remove(),c.find("i").remove(),c.append(j),b.removeClass("empty")}f.close()}),g){var j=new Image;j.onload=function(){jQuery("#cloudfw-ui-icon-custom",e).val(g).focus().select(),jQuery("#cloudfw-ui-icon-custom-retina",e).val(h)},j.onerror=function(){jQuery("#cloudfw-ui-icon-custom",e).val("").focus().select(),jQuery("#cloudfw-ui-icon-custom-retina",e).val("")},j.src=g}else jQuery("#cloudfw-ui-icon-custom",e).val("").focus().select(),jQuery("#cloudfw-ui-icon-custom-retina",e).val("")},before_close:function(){}});a.preventDefault()}),jQuery(document).delegate(".library-icon-handler","click",function(a){var b=jQuery(this).parents(".wrap-icons").first(),c=b.find(".select-icon"),d=c.find(".ui--icon"),e=b.find("input");e.val(),b.find("img"),CloudFw_UI.modal({id:"ui-custom-library-icon",loader:!0,dummy:!0,destroy:"#ui-custom-font-icon",overlay:!1,minimize:!0,compact:!0,width:700,title:"Icon Library",content:function(a,f,g){var h={action:"cloudfw_get_library_icons",icon:e.val(),nonce:CloudFwOp.cloudfw_nonce};jQuery.ajax({url:CloudFwOp.ajaxUrl,cache:!1,type:"POST",data:jQuery.param(h,!0),success:function(h){var i='<div style="margin: 4px 35px 0 0;"><input id="cloudfw-ui-modal-search" type="text" value="" class="input input_200" autocomplete="off" placeholder="type to search" /></div>';g.toolbar_option(i),jQuery("#cloudfw-ui-modal-search",a).on("keydown keyup",jQuery.throttle(500,function(){var a=jQuery(this),b=a.val(),c=jQuery(".library-icons-set",f);if(""===b)return c.find(".cloudfw-ui-label-radio").show(),c.find(".cloudfw-ui-label-radio").length&&(jQuery("#ui-icon-library",f).show(),jQuery(".cloudfw-ui-not-found-text",f).hide()),!0;var d=c.find(".cloudfw-ui-label-radio input"),e=d.filter(":Search('"+b+"')");c.find(".cloudfw-ui-label-radio").hide(),e.length>0?(e.each(function(){var a=jQuery(this);a.parents(".cloudfw-ui-label-radio").first().show()}),jQuery("#ui-icon-library",f).show(),jQuery(".cloudfw-ui-not-found-text",f).hide()):(jQuery("#ui-icon-library",f).hide(),jQuery(".cloudfw-ui-not-found-text",f).show())})),g.success(h),cloudfw_main();var j=jQuery("#icon_set_selector",f);j.change(function(){var a=jQuery(this).val();jQuery(".library-icons-set",f).hide(),""!=a&&jQuery("#"+a,f).show()});var k=jQuery("input[name=library_icon]:checked",f),l=k.parents(".library-icons-set").first().attr("id");l&&(j.find("option[value="+l+"]").prop("selected",!0),j.change(),k.focus()),jQuery(".cloudfw-dummy-form",f).submit(function(a){a.preventDefault();var h=jQuery("input[name=library_icon]:checked",f),i=h.parent("label"),j=i.find("img").first(),k=h.val(),l="";k&&(d.remove(),l+=k,e.val(l),c.find("img").remove(),c.find("i").remove(),j.clone().appendTo(c),b.removeClass("empty")),g.close()}),jQuery(".cloudfw-ui-label-radio",f).bind("dblclick",function(a){a.stopPropagation(),a.preventDefault(),jQuery(".cloudfw-dummy-form",f).submit()})}})},before_close:function(){}});a.preventDefault()}),jQuery(document).delegate(".font-icon-handler","click",function(a){var b=jQuery(this).parents(".wrap-icons").first(),c=b.find(".select-icon"),d=c.find("i"),e=b.find("input");e.val(),b.find("img"),CloudFw_UI.modal({id:"ui-custom-font-icon",loader:!0,dummy:!0,destroy:"#ui-custom-library-icon",overlay:!1,minimize:!0,compact:!0,width:700,title:"Vector Icons",content:function(a,f,g){var h={action:"cloudfw_get_font_icons",nonce:CloudFwOp.cloudfw_nonce,allow_customization:b.attr("data-allow-customization")||!1,icon:d.attr("data-icon-class")||"",color:d.attr("data-icon-color")||"",background:d.attr("data-icon-background")||"",size:d.attr("data-icon-size")||"",border_color:d.attr("data-icon-border-color")||"",border_width:d.attr("data-icon-border-width")||"",border_radius:d.attr("data-icon-border-radius")||""};jQuery.ajax({url:CloudFwOp.ajaxUrl,cache:!1,type:"POST",data:jQuery.param(h,!0),success:function(h){var i='<div style="margin: 4px 35px 0 0;"><input id="cloudfw-ui-modal-search" type="text" value="" class="input input_200" autocomplete="off" placeholder="type to search" /></div>';g.toolbar_option(i),jQuery("#cloudfw-ui-modal-search",a).on("keydown keyup",jQuery.throttle(500,function(){var a=jQuery(this),b=a.val(),c=jQuery("#library-font-icons",f);if(""===b)return c.find(".cloudfw-ui-label-radio").show(),c.find(".cloudfw-ui-label-radio").length&&(jQuery("#ui-icon-library",f).show(),jQuery(".cloudfw-ui-not-found-text",f).hide()),!0;var d=c.find(".cloudfw-ui-label-radio input"),e=d.filter(":Search('"+b+"')");c.find(".cloudfw-ui-label-radio").hide(),e.length>0?(e.each(function(){var a=jQuery(this);a.parents(".cloudfw-ui-label-radio").first().show()}),jQuery("#ui-icon-library",f).show(),jQuery(".cloudfw-ui-not-found-text",f).hide()):(jQuery("#ui-icon-library",f).hide(),jQuery(".cloudfw-ui-not-found-text",f).show())})),g.success(h),cloudfw_main(),jQuery("input[name=icon_class]:checked",f).focus(),jQuery(".cloudfw-dummy-form",f).submit(function(a){a.preventDefault();var h=jQuery("input[name=icon_class]:checked",f).val(),i=cloudfw_get_value(jQuery("#icon_size",f)).replace(" px","").replace("px",""),j=cloudfw_get_value(jQuery("#icon_color",f)),k=cloudfw_get_value(jQuery("#icon_background",f)),l=cloudfw_get_value(jQuery("#icon_border_color",f)),m=cloudfw_get_value(jQuery("#icon_border_width",f)),n=cloudfw_check_undefined(jQuery("#icon_border_radius option:checked",f).val()),o="",p="";d.remove(),h&&(o+=h,p=jQuery("<i/>").addClass(h.split("/")[1]).addClass("ui--icon").attr("data-icon-class",h),""!=i&&(o+="||size:"+i+"px",p.css({"font-size":i+"px","min-width":i+"px"}).attr("data-icon-size",i).addClass("icon-inline-block")),""!=j&&(o+="||color:"+j,p.css({color:"#"+j}).attr("data-icon-color",j)),""!=k&&(o+="||background:"+k,p.css({"background-color":"#"+k}).attr("data-icon-background",k).addClass("icon-inline-block icon-with-background")),""!=l&&(o+="||border_color:"+l,p.css({"border-color":"#"+l}).attr("data-icon-border-color",l),""==m&&(m=1)),""!=m&&(o+="||border_width:"+m,p.css({"border-width":m+"px"}).attr("data-icon-border-width",m)),(""!=m||""!=l)&&p.css({"border-style":"solid"}).addClass("icon-inline-block icon-with-background"),""!=n&&(o+="||border_radius:"+n,p.attr("data-icon-border-radius",n).addClass(n)),e.val(o),c.find("img").remove(),c.find("i").remove(),c.append(p),b.removeClass("empty")),g.close()}),jQuery(".cloudfw-ui-label-radio",f).bind("dblclick",function(a){a.stopPropagation(),a.preventDefault(),jQuery(".cloudfw-dummy-form",f).submit()})}})},before_close:function(){}});a.preventDefault()}),jQuery(".cloudfw-update-messages").show().each(function(){jQuery("#appandtohere-nags").length&&jQuery(this).appendTo("#appandtohere-nags").fadeIn()}),jQuery("#setting-error-tgmpa").each(function(){jQuery("#appandtohere-nags").length&&jQuery(this).appendTo("#appandtohere-nags").fadeIn()}),jQuery(document).delegate(".qq-upload-drop-area","mouseleave",function(a){jQuery(".qq-upload-drop-area").hide()}),jQuery(document).delegate(".cloudfw-ui-modal-save-and-close","click",function(a){var b=jQuery(this);b.parents(".cloudfw-ui-modal-box").first().find(".close").click()})}function cloudfw_main(a){if(a){if("undefined"==typeof a.jquery&&(a=jQuery(a)),!a.length)return!0}else a=null;cloudfw_destroy();var b={onShiftEnter:{keepDefault:!1,replaceWith:"<br />\n"},onCtrlEnter:{keepDefault:!1,openWith:"\n<p>",closeWith:"</p>"},onTab:{keepDefault:!1,replaceWith:"    "},markupSet:[{name:"Bold",key:"B",openWith:"(!(<strong>|!|<b>)!)",closeWith:"(!(</strong>|!|</b>)!)"},{name:"Italic",key:"I",openWith:"(!(<em>|!|<i>)!)",closeWith:"(!(</em>|!|</i>)!)"},{name:"Stroke through",openWith:"<del>",closeWith:"</del>"},{separator:"---------------"},{name:"Bulleted List",openWith:"    <li>",closeWith:"</li>",multiline:!0,openBlockWith:"<ul>\n",closeBlockWith:"\n</ul>"},{name:"Numeric List",openWith:"    <li>",closeWith:"</li>",multiline:!0,openBlockWith:"<ol>\n",closeBlockWith:"\n</ol>"},{separator:"---------------"},{name:"Link",key:"L",openWith:'<a href="[![Link:!:http://]!]"(!( title="[![Title]!]")!) target="[![Target:!:_blank]!]">',closeWith:"</a>",placeHolder:"Your text to link..."},{separator:"---------------"},{name:"Clean",className:"clean",replaceWith:function(a){return a.selection.replace(/<(.*?)>/g,"")}}]};jQuery(".cloudfw-ui-editor",a).each(function(){if(cloudfw_jqueried("cloudfw-editor",jQuery(this)))return!0;var a=jQuery(this);a.hasClass("markItUpEditor")&&a.markItUp("remove");a.bind("focus",function(){var c=a.prev(".markItUpHeader");a.hasClass("markItUpEditor")?c.clearQueue().stop().delay(100).queue(function(){jQuery(this).show()}):(a.markItUp(b),c.append('<li class="close"><a href="javascript:;" title="Close">Close</a></li>'),a.focus())}),a.bind("focusout",function(){var b=a.prev(".markItUpHeader");b.clearQueue().stop().delay(300).queue(function(){jQuery(this).hide()})})}),jQuery(".cloudfw-ui-autogrow",a).each(function(){if(cloudfw_jqueried("cloudfw-autogrow",jQuery(this)))return!0;var a=jQuery(this);a.autoGrow()}),jQuery("select[multiple].input",a).each(function(){if(cloudfw_jqueried("cloudfw-asmSelect",jQuery(this)))return!0;var a=jQuery(this);a.asmSelect({addItemTarget:"bottom",animate:!0,highlight:!1,sortable:!0,debug:!0})}),jQuery(".gallery-preview",a).each(function(){if(cloudfw_jqueried("cloudfw-gallery-preview",jQuery(this)))return!0;var a=jQuery(this),b=a.find(".image"),c=a.attr("data-sync"),e=(a.parents("li").first(),a.next(".gallery-item")),f=jQuery("#"+c,e),g=b.find("img").attr("src");f.change(function(){var a=jQuery(this).val();g!==a&&(""!==a?(b.html("Thumbnail Creating..."),cloudfw_image_resize(a,200,120,function(a){a?b.html(jQuery("<img />").attr("src",a)):b.html("")},function(){b.html("")})):b.html(""))}).change()}),jQuery.isFunction(jQuery.fn.tipsy)&&jQuery(".cloudfw-tooltip").each(function(){return cloudfw_jqueried("cloudfw-tooltip",jQuery(this))?!0:void jQuery(this).tipsy({gravity:"s",offset:0})}),jQuery(".cloudfw-ui-label-check input:checked").each(function(){return cloudfw_jqueried("cloudfw-checkbox",jQuery(this))?!0:void jQuery(this).parent("label").addClass("c_on")}),jQuery(".cloudfw-ui-label-radio input:checked").each(function(){return cloudfw_jqueried("cloudfw-radio",jQuery(this))?!0:void jQuery(this).parent("label").addClass("r_on")}),jQuery(".cloudfw-ui-tabs",a).each(function(){if(cloudfw_jqueried("cloudfw-tab",jQuery(this)))return!0;var a={},b={},c=jQuery(this),d=c.attr("rel");b.expires=60,d&&(b.name=d),a.create=function(){cloudfw_tab_loaded(),cloudfw_destroy()},a.select=function(){c.hasClass("cloudfw-ui-mini-tabs")||resetInview(),cloudfw_destroy()};var e=window.location.hash;e||(a.activate=function(a,c){b.name&&jQuery.cookie(b.name,c.newTab.index(),{expires:b.expires})},b.name&&(a.active=jQuery.cookie(b.name)),a.cookie=b),c.tabs(a)}),jQuery(".cloudfw-ui-input",a).each(function(){if(cloudfw_jqueried("cloudfw-input",jQuery(this)))return!0;var a=jQuery(this);a.bind("keydown",function(){clearTimeout(jQuery.data(this,"timer"));var b=setTimeout(function(){a.change()},1e3);jQuery(this).data("timer",b)})}),jQuery(".cloudfw-ui-select",a).each(function(){if(cloudfw_jqueried("cloudfw-select",jQuery(this)))return!0;var a=jQuery(this),b=a.find(".cloudfw-ui-select-title"),c=a.find("select");c.on("change",function(){var c=jQuery(this).find(":selected").first().text();if(""==c){var d=a.attr("data-default-title");if(d)var c=d}b.text(c)}).change(),c.bind("focus",function(){a.addClass("active")}),c.bind("blur",function(){a.removeClass("active")}),a.attr("data-init")&&c.change()}),jQuery(".cloudfw-ui-slider",a).each(function(){function r(a,b,c){if(b)try{var b=jQuery.parseJSON(b);a.parents(".cloudfw-ui-slider-container").find(".cloudfw-ui-slider-container-preview-step").html("").hide(),a.parents(".cloudfw-ui-slider-container").find(".cloudfw-ui-slider-container-preview-value").show(),jQuery.each(b,function(b,d){return b==c?(a.parents(".cloudfw-ui-slider-container").find(".cloudfw-ui-slider-container-preview-step").html(d).show(),a.parents(".cloudfw-ui-slider-container").find(".cloudfw-ui-slider-container-preview-value").hide(),!0):void 0})}catch(d){}}if(cloudfw_jqueried("cloudfw-slider",jQuery(this)))return!0;var a={},b=jQuery(this),d=(b.attr("id"),b.parents(".cloudfw-ui-slider-container").find(".slide")),e=b.parents(".cloudfw-ui-slider-container").find(".amount"),f=b.val(),g=b.attr("data-min"),h=b.attr("data-max"),i=b.attr("data-step"),j=b.attr("data-range"),k=b.attr("data-min-range"),l=b.attr("data-orientation"),m=b.attr("data-steps");a.animate=!0,g&&(a.min=parseFloat(g)),h&&(a.max=parseFloat(h)),i&&(a.step=parseFloat(i)),l&&(a.orientation=l),j?(a.range=!0,a.values=f.split(","),a.slide=function(a,c){b.val(c.values[0]+","+c.values[1]).change(),e.html(c.values[0]+","+c.values[1]),r(b,m,c.values[0]+","+c.values[1])},a.change=a.slide):(k&&(a.range="min"),a.value=parseFloat(f),a.slide=function(a,c){b.val(c.value).change(),e.html(c.value),r(b,m,c.value)},a.change=a.slide),d.slider(a);var n=d.find(".ui-slider-range");if(n.length>1){var o=n.length;n.each(function(a){a!=o-1&&jQuery(this).remove()})}if(b.bind("keyup keydown",function(){clearTimeout(jQuery.data(this,"timer"));var a=setTimeout(function(){if(j){var a=b.val().replace(/[^0-9\.\,\-]/g,"").split(",");d.slider("values",a)}else d.slider("value",b.val().replace(/[^0-9\.\-]/g,""))},400);jQuery(this).data("timer",a),b.change()}),b.bind("blur focus focusout",function(){if(j){var a=d.slider("values");b.val(a[0]+","+a[1]).change(),e.html(a[0]+","+a[1]),r(b,m,a[0]+","+a[1])}else{d.slider("value",b.val().replace(/[^0-9\.\-]/g,""));var c=d.slider("value");e.html(c),r(b,m,c)}}),j){var p=d.slider("values");e.html(p[0]+","+p[1]),r(b,m,p[0]+","+p[1])}else{var q=d.slider("value");e.html(q),r(b,m,q)}}),jQuery(".cloudfw-ui-uploader",a).each(function(){if(cloudfw_jqueried("cloudfw-uploader",jQuery(this)))return!0;var b=jQuery(this),d=(b.attr("id"),b.parents(".cloudfw-ui-uploader-container")),e=d.find(".cloudfw-ui-uploader-input"),f=d.find(".cloudfw-ui-uploader-preview"),g=b.attr("data-path"),h=b.attr("data-remove-button"),i=b.attr("data-edit-button"),j=b.attr("data-library-button"),k=b.attr("data-store");if(h)var l='<div class="qq-upload-button-delete small-button small-grey small-hover-red"><span>'+CloudFwOp.textRemove+"</span></div>";else var l="";if(i)var m='<div class="qq-upload-button-edit"><span>Edit</span></div>';else var m="";if(j)var n='<a href="javascript:;" class="cloudfw-ui-uploader-import small-button small-grey"><span>'+CloudFwOp.textSelecFromLibrary+"</span></a>";else var n="";var o=new qq.FileUploader({element:b[0],action:CloudFwOp.ajaxUrl,debug:!0,onComplete:function(a,b,c){return"undefined"==c.filepath||"undefined"==typeof c.filepath||""==c.filepath?!1:(e.val(c.filepath).change(),f.html("<div class='cloudfw-ui-image-preview'><div class='cloudfw-ui-image-preview-padding'><img src='"+g+c.filepath+"' /></div></div>"),d.find(".qq-upload-button-delete").show(),void cloudfw_destroy())},showMessage:function(a){cloudfw_dialog("An error occurred",a,"error")},template:'<div class="qq-uploader no-list"><div class="qq-upload-drop-area"><span></span></div><div class="qq-upload-button small-button small-grey"><span><strong class="icon"></strong>'+CloudFwOp.textUpload+"</span></div>"+n+m+l+'<ul class="qq-upload-list"></ul></div>'});o.setParams({action:"cloudfw_image_upload",store:k,nonce:CloudFwOp.cloudfw_nonce}),d.find(".qq-upload-button-delete").unbind("click").bind("click",function(){e.val("").change(),f.html(""),jQuery(this).hide()}),e.hasClass("hidden")&&i&&(d.find(".qq-upload-button-edit").unbind("click").bind("click",function(){e.fadeIn().focus()}),e.bind("blur focusout",function(){e.fadeOut()})),""==e.val()?(d.find(".qq-upload-button-delete").hide(),d.find(".cloudfw-ui-image-preview").hide()):(d.find(".qq-upload-button-delete").show(),d.find(".cloudfw-ui-image-preview").show());var p=d.find(".cloudfw-ui-uploader-import"),q=p.length;if(q){var r;p.off("click").on("click",function(a){return a.preventDefault(),r?void r.open():(r=wp.media.frames.file_frame=wp.media({button:{text:jQuery(this).data("uploader_button_text")},multiple:!1,states:[new wp.media.controller.Library({multiple:!0,priority:20,filterable:"eml"})]}),r.on("select",function(){attachment=r.state().get("selection").first().toJSON();var a=attachment.url;e.val(a).change();var b=e.attr("data-to_alt");if(b){var c=attachment.title;c&&jQuery("#"+b,".composer-item.editing").val(c)}f.html("<div class='cloudfw-ui-image-preview'><div class='cloudfw-ui-image-preview-padding'><img src='"+a+"' /></div></div>"),d.find(".qq-upload-button-delete").show(),r.close()}),void r.open())})}}),jQuery(".cloudfw-ui-color",a).each(function(){if(cloudfw_jqueried("cloudfw-color",jQuery(this)))return!0;var a=jQuery(this),b=a.find(".cloudfw-ui-color-handler"),c=a.hasClass("ui-gradient-selector");b.each(function(){var d=jQuery(this),e=d.find(".cloudfw-ui-color-input"),f=d.find(".color-preview");e.ColorPicker({onSubmit:function(b,c,d,g){e.val(c),f.css("backgroundColor","#"+c),a.removeClass("empty"),jQuery(g).ColorPickerHide()},onBeforeShow:function(){jQuery(this).ColorPickerSetColor(this.value)},onChange:function(b,c,d,g){e.val(c).css({"background-color":"#"+c}),a.removeClass("empty"),f.css("backgroundColor","#"+c),e.change()}}).on("keyup focusout",function(){var b=e.val();e.ColorPickerSetColor(b),""!=b?(f.css("backgroundColor","#"+b),a.removeClass("empty")):(f.css("backgroundColor",""),
a.addClass("empty")),e.change()}),f.css("backgroundColor","#"+e.val()).bind("click",function(){e.click().select()}),c?a.find(".remove-color").unbind("click").bind("click",function(c){c.preventDefault();var d=b.find("input"),e=d.first(),f=d.last();""!==f.val()?(f.prev(".color-preview").css("backgroundColor",""),f.val("").change(),""==e.val()&&a.addClass("empty")):(e.prev(".color-preview").css("backgroundColor",""),e.val("").change(),a.addClass("empty"))}):a.find(".remove-color").click(function(b){b.preventDefault(),e.val(""),f.css("backgroundColor",""),a.addClass("empty"),e.change()})})}),jQuery(".cloudfw-ui-custom-uploader",a).each(function(){return cloudfw_jqueried("cloudfw-custom-uploader",jQuery(this))?!0:void jQuery(this).customFileInput()}),jQuery(".fg-button",a).each(function(a){if(cloudfw_jqueried("cloudfw-fg-button",jQuery(this)))return!0;var b=jQuery(this),c=b.attr("data-width")||245;b.ddMenu({content:jQuery(this).prev().html(),showSpeed:100,width:c}),b.hover(function(){jQuery(this).removeClass("ui-state-default").addClass("ui-state-focus")},function(){jQuery(this).removeClass("ui-state-focus").addClass("ui-state-default")})}),sortable_sliders_opacity=.6,jQuery(".cloudfw-ui-sortable, .sortable_sliders, .sortable_ul",a).each(function(){if(cloudfw_jqueried("cloudfw-sortable",jQuery(this)))return!0;var a=jQuery(this),b=a.attr("data-axis");a.is(":ui-sortable")&&jQuery(this).sortable("destroy");var c={};c={opacity:sortable_sliders_opacity,scroll:!0,delay:200,distance:0,start:function(a,b){jQuery(this).sortable("refreshPositions")},update:function(a,b){jQuery(this).children("li").each(function(a,b){jQuery(this).removeClass("first").find(".sort_input").val(a),a++}).first().addClass("first")},stop:function(a,b){}},b&&"undefined"!=typeof b?"x"==b?c.axis="x":"y"==b?c.axis="y":c.axis=!1:c.axis="y",a.sortable(c)}),jQuery(".cloudfw-ui-tabs").find("ul").first().find("a").click(cloudfw_destroy),jQuery(".cloudfw-ui-mini-tabs").children("ul").first().find("a").click(cloudfw_destroy)}jQuery(document).ready(function(){url=jQuery("meta[name=tmpurl]").attr("content"),pfix=jQuery("meta[name=pfix]").attr("content"),cloudfw_nonce=jQuery("meta[name=_wpnonce]").attr("content"),textSending=jQuery("meta[name=textSending]").attr("content")?jQuery("meta[name=textSending]").attr("content"):"Sending...",textSaved=jQuery("meta[name=textSaved]").attr("content")?jQuery("meta[name=textSaved]").attr("content"):"Saved",textUpdate=jQuery("meta[name=textUpdate]").attr("content")?jQuery("meta[name=textUpdate]").attr("content"):"Update",textSendTheEditor=jQuery("meta[name=textSendTheEditor]").attr("content")?jQuery("meta[name=textSendTheEditor]").attr("content"):"Insert Into The Input",cloudfw_init(),cloudfw_main(),cloudfw_panel_height(),cloudfw_tabkey(),cloudfw_fixed_submit(),jQuery("form").attr("novalidate",!0),jQuery(document).on("ajaxSuccess",function(a,b,c){try{var d=jQuery.deparam(c.data);switch(d.action){case"save-widget":case"widgets-order":case"add-menu-item":case"cloudfw_load_dynamic_shortcode_generator":case"cloudfw_load_dynamic_shortcode_generator":case"cloudfw_get_slider_content_forms":cloudfw_main();break;case"menu-locations-save":location.reload()}}catch(e){}})});