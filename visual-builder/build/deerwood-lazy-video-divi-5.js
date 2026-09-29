(function(){'use strict';
var React=window.React;
var hooks=window.vendor&&window.vendor.wp&&window.vendor.wp.hooks;
var divi=window.divi||{};
if(!React||!hooks||!divi.moduleLibrary||!divi.module){return;}
var addAction=hooks.addAction;
var registerModule=divi.moduleLibrary.registerModule;
var ModuleContainer=divi.module.ModuleContainer;
var metadata={"name":"deerwood/lazy-video-divi-5","title":"Deerwood Lazy Video","titles":"Deerwood Lazy Videos","category":"module","moduleClassName":"deerwood_lazy_video_divi_5","moduleOrderClassName":"deerwood_lazy_video_divi_5","attributes":{"module":{"type":"object","selector":"{{selector}}","default":{"meta":{"adminLabel":{"desktop":{"value":"Deerwood Lazy Video"}}}},"settings":{"meta":{"adminLabel":{}},"decoration":{"layout":{},"sizing":{},"spacing":{},"border":{},"boxShadow":{},"filters":{},"transform":{},"animation":{},"overflow":{},"disabledOn":{},"transition":{},"position":{},"zIndex":{},"scroll":{},"sticky":{}}}},"youtubeUrl":{"type":"object","settings":{"innerContent":{"groupType":"group-item","item":{"priority":10,"render":true,"attrName":"youtubeUrl.innerContent","label":"YouTube URL or Video ID","description":"Paste a YouTube URL or 11-character video ID.","features":{"dynamicContent":false},"component":{"type":"field","name":"divi/text"},"groupName":"mainContent"}}}},"thumbnail":{"type":"object","settings":{"innerContent":{"groupType":"group-item","item":{"priority":20,"render":true,"attrName":"thumbnail.innerContent","label":"Custom Thumbnail","description":"Optional. Use a local image for zero YouTube requests before play.","component":{"type":"field","name":"divi/upload"},"groupName":"mainContent"}}}},"accessibleLabel":{"type":"object","default":{"innerContent":{"desktop":{"value":"Play video"}}},"settings":{"innerContent":{"groupType":"group-item","item":{"priority":30,"render":true,"attrName":"accessibleLabel.innerContent","label":"Play Button Label","component":{"type":"field","name":"divi/text"},"groupName":"mainContent"}}}},"privacyMode":{"type":"object","default":{"innerContent":{"desktop":{"value":"on"}}},"settings":{"innerContent":{"groupType":"group-item","item":{"priority":40,"render":true,"attrName":"privacyMode.innerContent","label":"Privacy-Enhanced Mode","component":{"type":"field","name":"divi/toggle"},"groupName":"mainContent"}}}},"autoplay":{"type":"object","default":{"innerContent":{"desktop":{"value":"on"}}},"settings":{"innerContent":{"groupType":"group-item","item":{"priority":50,"render":true,"attrName":"autoplay.innerContent","label":"Autoplay After Click","component":{"type":"field","name":"divi/toggle"},"groupName":"mainContent"}}}},"aspectRatio":{"type":"object","default":{"innerContent":{"desktop":{"value":"16-9"}}},"settings":{"innerContent":{"groupType":"group-item","item":{"priority":60,"render":true,"attrName":"aspectRatio.innerContent","label":"Aspect Ratio","component":{"type":"field","name":"divi/select","props":{"options":{"16-9":{"label":"16:9","value":"16-9"},"4-3":{"label":"4:3","value":"4-3"},"1-1":{"label":"1:1","value":"1-1"},"9-16":{"label":"9:16","value":"9-16"}}}},"groupName":"mainContent"}}}},"playButtonColor":{"type":"object","default":{"innerContent":{"desktop":{"value":"#ff0000"}}},"settings":{"innerContent":{"groupType":"group-item","item":{"priority":10,"render":true,"attrName":"playButtonColor.innerContent","label":"Play Button Color","component":{"type":"field","name":"divi/color-picker"},"groupName":"designPlayButton"}}}},"playIconColor":{"type":"object","default":{"innerContent":{"desktop":{"value":"#ffffff"}}},"settings":{"innerContent":{"groupType":"group-item","item":{"priority":20,"render":true,"attrName":"playIconColor.innerContent","label":"Play Icon Color","component":{"type":"field","name":"divi/color-picker"},"groupName":"designPlayButton"}}}},"playButtonSize":{"type":"object","default":{"innerContent":{"desktop":{"value":"68px"}}},"settings":{"innerContent":{"groupType":"group-item","item":{"priority":30,"render":true,"attrName":"playButtonSize.innerContent","label":"Play Button Size","component":{"type":"field","name":"divi/range","props":{"min":40,"max":120,"step":1,"allowedUnits":["px"]}},"groupName":"designPlayButton"}}}}},"settings":{"content":"auto","design":"auto","advanced":"auto","groups":{"designPlayButton":{"panel":"design","priority":10,"groupName":"designPlayButton","component":{"name":"divi/composite","props":{"groupLabel":"Play Button"}}}}},"d4Shortcode":"dlvd_lazy_video"};
function val(a,n,d){try{var v=a[n].innerContent.desktop.value;return v==null?d:v}catch(e){return d}}
function vid(s){s=String(s||'').trim();if(/^[A-Za-z0-9_-]{11}$/.test(s))return s;var m=s.match(/(?:youtu\.be\/|youtube\.com\/(?:watch\?.*?v=|embed\/|shorts\/|live\/))([A-Za-z0-9_-]{11})/);return m?m[1]:''}
function Edit(p){
 var a=p.attrs||{},id=vid(val(a,'youtubeUrl','')),t=val(a,'thumbnail','');
 var src=(t&&typeof t==='object'?t.src:t)||(id?'https://i.ytimg.com/vi/'+encodeURIComponent(id)+'/maxresdefault.jpg':'');
 var ratio=val(a,'aspectRatio','16-9'),label=val(a,'accessibleLabel','Play video');
 var bc=val(a,'playButtonColor','#ff0000'),ic=val(a,'playIconColor','#ffffff'),sz=val(a,'playButtonSize','68px');
 var child=id?React.createElement(React.Fragment,null,
   React.createElement('img',{className:'dlvd-thumb',src:src,alt:''}),
   React.createElement('button',{className:'dlvd-play',type:'button','aria-label':label,onClick:function(e){e.preventDefault();e.stopPropagation();}},React.createElement('span',{'aria-hidden':'true'}))
 ):React.createElement('div',{className:'dlvd-notice'},'Enter a YouTube URL or video ID.');
 return React.createElement(ModuleContainer,{attrs:a,elements:p.elements,id:p.id,moduleClassName:'deerwood_lazy_video_divi_5',name:p.name},
   React.createElement('div',{className:'dlvd-wrap dlvd-ratio-'+ratio,style:{'--dlvd-button':bc,'--dlvd-icon':ic,'--dlvd-size':sz}},child));
}
var config={
 metadata:metadata,
 renderers:{edit:Edit},
 placeholderContent:{
  accessibleLabel:{innerContent:{desktop:{value:'Play video'}}},
  privacyMode:{innerContent:{desktop:{value:'on'}}},
  autoplay:{innerContent:{desktop:{value:'on'}}},
  aspectRatio:{innerContent:{desktop:{value:'16-9'}}},
  playButtonColor:{innerContent:{desktop:{value:'#ff0000'}}},
  playIconColor:{innerContent:{desktop:{value:'#ffffff'}}},
  playButtonSize:{innerContent:{desktop:{value:'68px'}}}
 }
};
addAction('divi.moduleLibrary.registerModuleLibraryStore.after','deerwood.lazyVideoDivi5',function(){registerModule(metadata,config);});
})();