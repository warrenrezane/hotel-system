/*

@license
dhtmlxScheduler v.5.3.3 Professional Evaluation

This software is covered by DHTMLX Evaluation License. Contact sales@dhtmlx.com to get Commercial or Enterprise license. Usage without proper license is prohibited.

(c) XB Software Ltd.

*/
Scheduler.plugin(function(e){e.attachEvent("onTemplatesReady",function(){this.layers.sort(function(e,t){return e.zIndex-t.zIndex}),e._dp_init=function(t){t._methods=["_set_event_text_style","","changeEventId","deleteEvent"],this.attachEvent("onEventAdded",function(e){!this._loading&&this.validId(e)&&this.getEvent(e)&&this.getEvent(e).layer==t.layer&&t.setUpdated(e,!0,"inserted")}),this.attachEvent("onBeforeEventDelete",function(e){if(this.getEvent(e)&&this.getEvent(e).layer==t.layer){
if(!this.validId(e))return;var a=t.getState(e);return"inserted"==a||this._new_event?(t.setUpdated(e,!1),!0):"deleted"!=a&&("true_deleted"==a||(t.setUpdated(e,!0,"deleted"),!1))}return!0}),this.attachEvent("onEventChanged",function(e){!this._loading&&this.validId(e)&&this.getEvent(e)&&this.getEvent(e).layer==t.layer&&t.setUpdated(e,!0,"updated")}),t._getRowData=function(e,t){var a=this.obj.getEvent(e),i={}
;for(var n in a)0!==n.indexOf("_")&&(a[n]&&a[n].getUTCFullYear?i[n]=this.obj._helpers.formatDate(a[n]):i[n]=a[n]);return i},t._clearUpdateFlag=function(){},t.attachEvent("insertCallback",e._update_callback),t.attachEvent("updateCallback",e._update_callback),t.attachEvent("deleteCallback",function(e,t){this.obj.setUserData(t,this.action_param,"true_deleted"),this.obj.deleteEvent(t)})},function(){var t=function(e){if(null===e||"object"!=typeof e)return e;var a=new e.constructor
;for(var i in e)a[i]=t(e[i]);return a};e._dataprocessors=[],e._layers_zindex={};for(var a=0;a<e.layers.length;a++){if(e.config["lightbox_"+e.layers[a].name]={},e.config["lightbox_"+e.layers[a].name].sections=t(e.config.lightbox.sections),e._layers_zindex[e.layers[a].name]=e.config.inital_layer_zindex||5+3*a,e.layers[a].url){var i=new dataProcessor(e.layers[a].url);i.layer=e.layers[a].name,e._dataprocessors.push(i),e._dataprocessors[a].init(e)}
e.layers[a].isDefault&&(e.defaultLayer=e.layers[a].name)}}(),e.showLayer=function(e){this.toggleLayer(e,!0)},e.hideLayer=function(e){this.toggleLayer(e,!1)},e.toggleLayer=function(e,t){var a=this.getLayer(e);a.visible=void 0!==t?!!t:!a.visible,this.setCurrentView(this._date,this._mode)},e.getLayer=function(t){var a,i;"string"==typeof t&&(i=t),"object"==typeof t&&(i=t.layer);for(var n=0;n<e.layers.length;n++)e.layers[n].name==i&&(a=e.layers[n]);return a},
e.attachEvent("onBeforeLightbox",function(t){var a=this.getEvent(t);return this.config.lightbox.sections=this.config["lightbox_"+a.layer].sections,e.resetLightbox(),!0}),e.attachEvent("onClick",function(t,a){var i=e.getEvent(t);return!e.getLayer(i.layer).noMenu}),e.attachEvent("onEventCollision",function(t,a){var i=this.getLayer(t);if(!i.checkCollision)return!1;for(var n=0,r=0;r<a.length;r++)a[r].layer==i.name&&a[r].id!=t.id&&n++;return n>=e.config.collision_limit}),
e.addEvent=function(t,a,i,n,r){var o=t;1!=arguments.length&&(o=r||{},o.start_date=t,o.end_date=a,o.text=i,o.id=n,o.layer=this.defaultLayer),o.id=o.id||e.uid(),o.text=o.text||"","string"==typeof o.start_date&&(o.start_date=this.templates.api_date(o.start_date)),"string"==typeof o.end_date&&(o.end_date=this.templates.api_date(o.end_date)),o._timed=this.isOneDayEvent(o);var s=!this._events[o.id];this._events[o.id]=o,this.event_updated(o),
this._loading||this.callEvent(s?"onEventAdded":"onEventChanged",[o.id,o])},this._evs_layer={};for(var t=0;t<this.layers.length;t++)this._evs_layer[this.layers[t].name]=[];e.addEventNow=function(t,a,i){var n={};"object"==typeof t&&(n=t,t=null);var r=6e4*(this.config.event_duration||this.config.time_step);t||(t=Math.round(e._currentDate().valueOf()/r)*r);var o=new Date(t);if(!a){var s=this.config.first_hour;s>o.getHours()&&(o.setHours(s),t=o.valueOf()),a=t+r}n.start_date=n.start_date||o,
n.end_date=n.end_date||new Date(a),n.text=n.text||this.locale.labels.new_event,n.id=this._drag_id=this.uid(),n.layer=this.defaultLayer,this._drag_mode="new-size",this._loading=!0,this.addEvent(n),this.callEvent("onEventCreated",[this._drag_id,i]),this._loading=!1,this._drag_event={},this._on_mouse_up(i)},e._t_render_view_data=function(e){if(this.config.multi_day&&!this._table_view){for(var t=[],a=[],i=0;i<e.length;i++)e[i]._timed?t.push(e[i]):a.push(e[i]);this._table_view=!0,this.render_data(a),
this._table_view=!1,this.render_data(t)}else this.render_data(e)},e.render_view_data=function(){if(this._not_render)return void(this._render_wait=!0);this._render_wait=!1,this.clear_view(),this._evs_layer={};for(var e=0;e<this.layers.length;e++)this._evs_layer[this.layers[e].name]=[];for(var t=this.get_visible_events(),e=0;e<t.length;e++)this._evs_layer[t[e].layer]&&this._evs_layer[t[e].layer].push(t[e]);if("month"==this._mode){
for(var a=[],e=0;e<this.layers.length;e++)this.layers[e].visible&&(a=a.concat(this._evs_layer[this.layers[e].name]));this._t_render_view_data(a)}else for(var e=0;e<this.layers.length;e++)if(this.layers[e].visible){var i=this._evs_layer[this.layers[e].name];this._t_render_view_data(i)}},e._render_v_bar=function(t,a,i,n,r,o,s,d,_){var l=t.id;-1==s.indexOf("<div class=")&&(s=e.templates["event_header_"+t.layer]?e.templates["event_header_"+t.layer](t.start_date,t.end_date,t):s),
-1==d.indexOf("<div class=")&&(d=e.templates["event_text_"+t.layer]?e.templates["event_text_"+t.layer](t.start_date,t.end_date,t):d);var c=document.createElement("div"),h="dhx_cal_event",u=e.templates["event_class_"+t.layer]?e.templates["event_class_"+t.layer](t.start_date,t.end_date,t):e.templates.event_class(t.start_date,t.end_date,t);u&&(h=h+" "+u)
;var g=e._border_box_bvents(),v=n-2,f=g?v:n-4,m=g?v:n-6,p=g?v:n-(this._quirks?4:14),y=g?v-2:n-8,b=g?r-this.xy.event_header_height:r-(this._quirks?20:30)+1,x='<div event_id="'+l+'" class="'+h+'" style="position:absolute; top:'+i+"px; left:"+a+"px; width:"+f+"px; height:"+r+"px;"+(o||"")+'">';return x+='<div class="dhx_header" style=" width:'+m+'px;" >&nbsp;</div>',x+='<div class="dhx_title">'+s+"</div>",x+='<div class="dhx_body" style=" width:'+p+"px; height:"+b+'px;">'+d+"</div>",
x+='<div class="dhx_footer" style=" width:'+y+"px;"+(_?" margin-top:-1px;":"")+'" ></div></div>',c.innerHTML=x,c.style.zIndex=100,c.firstChild},e.render_event_bar=function(t){var a=this._els.dhx_cal_data[0],i=this._colsS[t._sday],n=this._colsS[t._eday];n==i&&(n=this._colsS[t._eday+1])
;var r=this.xy.bar_height,o=this._colsS.heights[t._sweek]+(this._colsS.height?this.xy.month_scale_height+2:2)+t._sorder*r,s=document.createElement("div"),d=t._timed?"dhx_cal_event_clear":"dhx_cal_event_line",_=e.templates["event_class_"+t.layer]?e.templates["event_class_"+t.layer](t.start_date,t.end_date,t):e.templates.event_class(t.start_date,t.end_date,t);_&&(d=d+" "+_)
;var l='<div event_id="'+t.id+'" class="'+d+'" style="position:absolute; top:'+o+"px; left:"+i+"px; width:"+(n-i-15)+"px;"+(t._text_style||"")+'">';t._timed&&(l+=e.templates["event_bar_date_"+t.layer]?e.templates["event_bar_date_"+t.layer](t.start_date,t.end_date,t):e.templates.event_bar_date(t.start_date,t.end_date,t)),l+=e.templates["event_bar_text_"+t.layer]?e.templates["event_bar_text_"+t.layer](t.start_date,t.end_date,t):e.templates.event_bar_text(t.start_date,t.end_date,t)+"</div>)",
l+="</div>",s.innerHTML=l,this._rendered.push(s.firstChild),a.appendChild(s.firstChild)},e.render_event=function(t){var a=e.xy.menu_width;if(e.getLayer(t.layer).noMenu&&(a=0),!(t._sday<0)){var i=e.locate_holder(t._sday);if(i){
var n=60*t.start_date.getHours()+t.start_date.getMinutes(),r=60*t.end_date.getHours()+t.end_date.getMinutes()||60*e.config.last_hour,o=Math.round((60*n*1e3-60*this.config.first_hour*60*1e3)*this.config.hour_size_px/36e5)%(24*this.config.hour_size_px)+1,s=Math.max(e.xy.min_event_height,(r-n)*this.config.hour_size_px/60)+1,d=Math.floor((i.clientWidth-a)/t._count),_=t._sorder*d+1;t._inner||(d*=t._count-t._sorder)
;var l=this._render_v_bar(t.id,a+_,o,d,s,t._text_style,e.templates.event_header(t.start_date,t.end_date,t),e.templates.event_text(t.start_date,t.end_date,t));if(this._rendered.push(l),i.appendChild(l),_=_+parseInt(i.style.left,10)+a,o+=this._dy_shift,l.style.zIndex=this._layers_zindex[t.layer],this._edit_id==t.id){l.style.zIndex=parseInt(l.style.zIndex)+1;var c=l.style.zIndex;d=Math.max(d-4,e.xy.editor_width);var l=document.createElement("div");l.setAttribute("event_id",t.id),
this.set_xy(l,d,s-20,_,o+14),l.className="dhx_cal_editor",l.style.zIndex=c;var h=document.createElement("div");this.set_xy(h,d-6,s-26),h.style.cssText+=";margin:2px 2px 2px 2px;overflow:hidden;",h.style.zIndex=c,l.appendChild(h),this._els.dhx_cal_data[0].appendChild(l),this._rendered.push(l),h.innerHTML="<textarea class='dhx_cal_editor'>"+t.text+"</textarea>",this._quirks7&&(h.firstChild.style.height=s-12+"px"),this._editor=h.firstChild,this._editor.onkeypress=function(t){
if((t||event).shiftKey)return!0;var a=(t||event).keyCode;a==e.keys.edit_save&&e.editStop(!0),a==e.keys.edit_cancel&&e.editStop(!1)},this._editor.onselectstart=function(e){return(e||event).cancelBubble=!0,!0},h.firstChild.focus(),this._els.dhx_cal_data[0].scrollLeft=0,h.firstChild.select()}if(this._select_id==t.id){l.style.zIndex=parseInt(l.style.zIndex)+1
;for(var u=this.config["icons_"+(this._edit_id==t.id?"edit":"select")],g="",v=0;v<u.length;v++)g+="<div class='dhx_menu_icon "+u[v]+"' title='"+this.locale.labels[u[v]]+"'></div>";var f=this._render_v_bar(t.id,_-a+1,o,a,20*u.length+26,"","<div class='dhx_menu_head'></div>",g,!0);f.style.left=_-a+1,f.style.zIndex=l.style.zIndex,this._els.dhx_cal_data[0].appendChild(f),this._rendered.push(f)}}}},e.filter_agenda=function(t,a){var i=e.getLayer(a.layer);return i&&i.visible}})});