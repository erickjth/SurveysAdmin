/* http://keith-wood.name/gChart.html
   Google Chart interface for jQuery v1.4.1.
   See API details at http://code.google.com/apis/chart/.
   Written by Keith Wood (kbwood{at}iinet.com.au) September 2008.
   Dual licensed under the GPL (http://dev.jquery.com/browser/trunk/jquery/GPL-LICENSE.txt) and 
   MIT (http://dev.jquery.com/browser/trunk/jquery/MIT-LICENSE.txt) licenses. 
   Please attribute the author if you use it. */
(function($){function GChart(){this._defaults={width:0,height:0,format:'png',usePost:false,secure:false,margins:null,title:'',titleColor:'',titleSize:0,opacity:0,backgroundColor:null,chartColor:null,legend:'',legendOrder:'normal',legendDims:null,legendColor:'',legendSize:0,type:'pie3D',encoding:'',series:[this.series('Hello World',[60,40])],visibleSeries:0,functions:[],dataLabels:[],axes:[],ranges:[],markers:[],minValue:0,maxValue:100,gridSize:null,gridLine:null,gridOffsets:null,extension:{},barWidth:null,barSpacing:null,barGroupSpacing:null,barZeroPoint:null,pieOrientation:0,onLoad:null,provideJSON:false};this._typeOptions={'':'standard',p:'pie',p3:'pie',pc:'pie'};this._chartOptions=['Margins','DataFunctions','BarSizings','LineStyles','Colours','Title','Axes','Backgrounds','Grids','Markers','Legends','Extensions'];this._chartTypes={line:'lc',lineXY:'lxy',sparkline:'ls',barHoriz:'bhs',barVert:'bvs',barHorizGrouped:'bhg',barVertGrouped:'bvg',barHorizOverlapped:'bho',barVertOverlapped:'bvo',pie:'p',pie3D:'p3',pieConcentric:'pc',radar:'r',radarCurved:'rs',lc:'lc',lxy:'lxy',ls:'ls',bhs:'bhs',bvs:'bvs',bhg:'bhg',bvg:'bvg',bho:'bho',bvo:'bvo',p:'p',p3:'p3',pc:'pc',r:'r',rs:'rs'}};var s='gChart';var t={aqua:'008080',black:'000000',blue:'0000ff',fuchsia:'ff00ff',gray:'808080',green:'008000',grey:'808080',lime:'00ff00',maroon:'800000',navy:'000080',olive:'808000',orange:'ffa500',purple:'800080',red:'ff0000',silver:'c0c0c0',teal:'008080',transparent:'00000000',white:'ffffff',yellow:'ffff00'};var u={annotation:'A',arrow:'a',candlestick:'F',circle:'o',cross:'x',diamond:'d',down:'v',errorbar:'E',flag:'f',financial:'F',horizbar:'H',horizontal:'h',number:'N',plus:'c',rectangle:'C',sparkfill:'B',sparkline:'D',sparkslice:'b',square:'s',text:'t',vertical:'V'};var w={behind:-1,below:-1,normal:0,above:+1,inFront:+1,'-':-1,'+':+1};var z={diagonalDown:-45,diagonalUp:45,horizontal:0,vertical:90,dd:-45,du:45,h:0,v:90};var A={left:-1,center:0,centre:0,right:+1,l:-1,c:0,r:+1};var B={line:'l',ticks:'t',both:'lt'};var C={normal:'l',reverse:'r',automatic:'a','':'',l:'l',r:'r',a:'a'};var D={barbase:'s',barcenter:'c',barcentre:'c',bartop:'e',bottom:'b',center:'h',centre:'h',left:'l',middle:'v',right:'r',top:'t',b:'b',c:'c',e:'e',h:'h',l:'l',r:'r',s:'s',t:'t',v:'v'};var E='ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';var F='ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789-.';$.extend(GChart.prototype,{_prototype:GChart,markerClassName:'hasGChart',calculate:-0.123456,barWidthAuto:'a',barWidthRelative:'r',formatFloat:'f',formatPercent:'p',formatScientific:'e',formatCurrency:'c',setDefaults:function(a){extendRemove(this._defaults,a||{})},series:function(a,b,c,d,e,f,g,h){if($.isArray(a)){h=g;g=f;f=e;e=d;d=c;c=b;b=a;a=''}if(typeof c=='number'){h=f;g=e;f=d;e=c;d=null;c=null}if(typeof d=='number'){h=g;g=f;f=e;e=d;d=null}if($.isArray(f)){h=f;g=e;f=null;e=null}return{label:a,data:b||[],color:c||'',fillColor:d,minValue:e,maxValue:f,lineThickness:g,lineSegments:h}},seriesFromCsv:function(h){var j=[];if(!$.isArray(h)){h=h.split('\n')}if(!h.length){return j}var k=false;var l=[];var m=[];var n=['label','color','fillColor','minValue','maxValue','lineThickness','lineSegmentLine','lineSegmentGap'];$.each(h,function(i,c){var d=c.split(',');if(i==0&&isNaN(parseFloat(d[0]))){$.each(d,function(i,a){if($.inArray(a,n)>-1){l[i]=a}else if(a.match(/^x\d+$/)){m[i]=a}})}else{var e={};var f=[];var g=null;$.each(d,function(i,a){if(l[i]){var b=$.inArray(l[i],n);e[l[i]]=(b>2?$.gchart._numeric(a,0):a)}else if(m[i]){g=(a?$.gchart._numeric(a,-1):null);k=true}else{var y=$.gchart._numeric(a,-1);f.push(g!=null?[g,y]:y);g=null}});if(e.lineSegmentLine!=null&&e.lineSegmentGap!=null){e.lineSegments=[e.lineSegmentLine,e.lineSegmentGap];e.lineSegmentLine=e.lineSegmentGap=null}j.push($.extend(e,{data:f}))}});return(k?this.seriesForXYLines(j):j)},seriesFromXml:function(f){if($.browser.msie&&typeof f=='string'){var g=new ActiveXObject('Microsoft.XMLDOM');g.validateOnParse=false;g.resolveExternals=false;g.loadXML(f);f=g}f=$(f);var h=[];var j=false;try{f.find('series').each(function(){var b=$(this);var c=[];b.find('point').each(function(){var a=$(this);var x=a.attr('x');if(x!=null){j=true;x=$.gchart._numeric(x,-1)}y=$.gchart._numeric(a.attr('y'),-1);c.push(x?[x,y]:y)});var d=b.attr('lineSegments');if(d){d=d.split(',');for(var i=0;i<d.length;i++){d[i]=$.gchart._numeric(d[i],1)}}h.push({label:b.attr('label'),data:c,color:b.attr('color'),fillColor:b.attr('fillColor'),minValue:$.gchart._numeric(b.attr('minValue'),null),maxValue:$.gchart._numeric(b.attr('maxValue'),null),lineThickness:$.gchart._numeric(b.attr('lineThickness'),null),lineSegments:d})})}catch(e){}return(j?this.seriesForXYLines(h):h)},_numeric:function(a,b){a=parseFloat(a);return(isNaN(a)?b:a)},lineXYSeries:function(a){return this.seriesForXYLines(a)},seriesForXYLines:function(a){var b=[];for(var i=0;i<a.length;i++){var c=!$.isArray(a[i].data[0]);var d=(c?[null]:[]);var e=[];for(var j=0;j<a[i].data.length;j++){if(c){e.push(a[i].data[j])}else{d.push(a[i].data[j][0]);e.push(a[i].data[j][1])}}b.push($.gchart.series(a[i].label,d,a[i].color,a[i].fillColor,a[i].minValue,a[i].maxValue,a[i].lineThickness,a[i].lineSegments));b.push($.gchart.series('',e,'',a[i].fillColor,a[i].minValue,a[i].maxValue,a[i].lineThickness,a[i].lineSegments))}return b},fn:function(a,b,c,d,e,f){if(typeof d=='string'){f=d;d=null;e=null}if(typeof c=='string'){f=c;c=null;d=null;e=null}if(typeof b=='string'){b=this.fnVar(b,c,d,e)}return{series:a,data:b,fnText:f}},fnVar:function(a,b,c,d){return{name:a,series:(d?-1:b),start:(d?b:null),end:c,step:d}},color:function(r,g,b,a){var c=function(a){if(typeof a=='number'&&(a<0||a>255)){throw'Value out of range (0-255) '+a;}};var d=function(a){return(a.length==1?'0':'')+a};if(typeof r=='string'){c(g);return(r.match(/^#([A-Fa-f0-9]{2}){3,4}$/)?r.substring(1):(t[r]||r)+(g?d(g.toString(16)):''))}c(r);c(g);c(b);c(a);return d(r.toString(16))+d(g.toString(16))+d(b.toString(16))+(a?d(a.toString(16)):'')},gradient:function(a,b,c){var d=[];if($.isArray(b)){var e=1/(b.length-1);for(var i=0;i<b.length;i++){d.push([b[i],Math.round(i*e*100)/100])}}else{d=[[b,0],[c,1]]}return{angle:a,colorPoints:d}},stripe:function(a,b){var c=[];var d=Math.round(100/b.length)/100;for(var i=0;i<b.length;i++){c.push([b[i],d])}return{angle:a,striped:true,colorPoints:c}},range:function(a,b,c,d){if(typeof a=='string'){d=c;c=b;b=a;a=false}return{vertical:a,color:b,start:c,end:d}},marker:function(a,b,c,d,e,f,g,h,i,j){if(typeof e=='boolean'){j=g;i=f;h=e;g=null;f=null;e=null}if($.isArray(e)){if(typeof e[0]=='string'){j=f;i=e}else{j=e;i=null}h=null;g=null;f=null;e=null}if(typeof f=='boolean'){j=h;i=g;h=f;g=null;f=null}if($.isArray(f)){if(typeof f[0]=='string'){j=g;i=f}else{j=f;i=null}h=null;g=null;f=null}if(typeof g=='boolean'){j=i;i=h;h=g;g=null}if($.isArray(g)){if(typeof g[0]=='string'){j=h;i=g}else{j=g;i=null}h=null;g=null}if($.isArray(h)){if(typeof h[0]=='string'){j=i;i=h}else{j=h;i=null}h=null}if($.isArray(i)&&typeof i[0]!='string'){j=i;i=null}return{shape:a,color:b,series:c,item:(d||d==0?d:-1),size:e||10,priority:(f!=null?f:0),text:g,positioned:h,placement:i,offsets:j}},numberFormat:function(a,b,c,d,e,f,g){var h=initNumberFormat(a,b,c,d,e,f,g);return h.prefix+'*'+h.type+h.precision+(h.zeroes?(typeof h.zeroes=='number'?'z'+h.zeroes:'z'):'')+(h.separators?'s':'')+(h.showX?'x':'')+'*'+h.suffix},axis:function(a,b,c,d,e,f,g,h,i,j,k){return new GChartAxis(a,b,c,d,e,f,g,h,i,j,k)},findRegion:function(c,d){if(!d||!d.chartshape){return null}var e=function(a){var b=a.match(/([^\d]+)(\d+)(?:_(\d)+)?/);return{type:b[1],series:parseInt(b[2]),point:parseInt(b[3]||-1)}};var f=$(c.target).offset();var x=c.pageX-f.left;var y=c.pageY-f.top;for(var i=0;i<d.chartshape.length;i++){var g=d.chartshape[i];switch(g.type){case'RECT':if(g.coords[0]<=x&&x<=g.coords[2]&&g.coords[1]<=y&&y<=g.coords[3]){return e(g.name)}break;case'CIRCLE':if(Math.abs(x-g.coords[0])<=g.coords[2]&&Math.abs(y-g.coords[1])<=g.coords[2]&&Math.sqrt(Math.pow(x-g.coords[0],2)+Math.pow(y-g.coords[1],2))<=g.coords[2]){return e(g.name)}break;case'POLY':if($.gchart._insidePolygon(g.coords,x,y)){return e(g.name)}break}}return null},_insidePolygon:function(a,x,y){var b=0;var c=[a[0],a[1]];for(var i=2;i<=a.length;i+=2){var d=[a[i%a.length],a[i%a.length+1]];if(y>Math.min(c[1],d[1])&&y<=Math.max(c[1],d[1])){if(x<=Math.max(c[0],d[0])&&c[1]!=d[1]){var e=(y-c[1])*(d[0]-c[0])/(d[1]-c[1])+c[0];if(c[0]==d[0]||x<=e){b++}}}c=d}return(b%2!=0)},_attachGChart:function(a,b){a=$(a);if(a.is('.'+this.markerClassName)){return}a.addClass(this.markerClassName);b=b||{};var c=b.width||parseInt(a.css('width'),10);var d=b.height||parseInt(a.css('height'),10);var e=$.extend({},this._defaults,b,{width:c,height:d});$.data(a[0],s,e);this._updateChart(a[0],e)},_changeGChart:function(a,b,c){var d=b||{};if(typeof b=='string'){d={};d[b]=c}var e=$.data(a,s);extendRemove(e||{},d);$.data(a,s,e);this._updateChart(a,e)},_destroyGChart:function(a){a=$(a);if(!a.is('.'+this.markerClassName)){return}a.removeClass(this.markerClassName).empty();$.removeData(a[0],s)},_generateChart:function(a){var b=(a.type&&a.type.match(/.+:.+/)?a.type:this._chartTypes[a.type]||'p3');var c='';for(var i=0;i<a.dataLabels.length;i++){c+='|'+encodeURIComponent(a.dataLabels[i]||'')}c=(c.length==a.dataLabels.length?'':c);var d=a.format||'png';var e=(a.secure?'https://chart.googleapis.com':'http://chart.apis.google.com')+'/chart?'+this.addSize(b,a)+(d!='png'?'&chof='+d:'')+'&cht='+b+this[(this._typeOptions[b.replace(/:.*/,'')]||this._typeOptions[''])+'Options'](a,c);for(var i=0;i<this._chartOptions.length;i++){e+=this['add'+this._chartOptions[i]](b,a)}return e},_include:function(a,b){return(b?a+b:'')},standardOptions:function(a,b){var c=this['_'+a.encoding+'Encoding']||this['_textEncoding'];return'&chd='+c.apply($.gchart,[a])+(b?'&chl='+b.substr(1):'')},pieOptions:function(a,b){return(a.pieOrientation?'&chp='+(a.pieOrientation/180*Math.PI):'')+this.standardOptions(a,b)},addSize:function(a,b){var c=1000;b.width=Math.max(10,Math.min(b.width,c));b.height=Math.max(10,Math.min(b.height,c));if(b.width*b.height>300000){b.height=Math.floor(300000/b.width)}return'chs='+b.width+'x'+b.height},addMargins:function(a,b){var c=b.margins;c=(c==null?null:(typeof c=='number'?[c,c,c,c]:(!$.isArray(c)?null:(c.length==4?c:(c.length==2?[c[0],c[0],c[1],c[1]]:null)))));return(!c?'':'&chma='+c.join(',')+(!b.legendDims||b.legendDims.length!=2?'':'|'+b.legendDims.join(',')))},addDataFunctions:function(a,b){var c='';for(var i=0;i<b.functions.length;i++){var d=b.functions[i];var e='';d.data=($.isArray(d.data)?d.data:[d.data]);for(var j=0;j<d.data.length;j++){var f=d.data[j];e+=';'+f.name+','+(f.series!=-1?f.series:f.start+','+f.end+','+f.step)}c+='|'+d.series+','+e.substr(1)+','+encodeURIComponent(d.fnText)}return(c?'&chfd='+c.substr(1):'')},addBarSizings:function(a,b){return(a.substr(0,1)!='b'?'':(b.barWidth==null?'':'&chbh='+b.barWidth+(b.barSpacing==null?'':','+(b.barWidth==$.gchart.barWidthRelative?Math.min(Math.max(b.barSpacing,0.0),1.0):b.barSpacing)+(b.barGroupSpacing==null?'':','+(b.barWidth==$.gchart.barWidthRelative?Math.min(Math.max(b.barGroupSpacing,0.0),1.0):b.barGroupSpacing))))+(b.barZeroPoint==null?'':'&chp='+b.barZeroPoint))},addLineStyles:function(a,b){if(a.charAt(0)!='l'){return''}var c='';for(var i=0;i<b.series.length;i++){if(b.series[i].lineThickness&&$.isArray(b.series[i].lineSegments)){c+='|'+b.series[i].lineThickness+','+b.series[i].lineSegments.join(',')}}return(c?'&chls='+c.substr(1):'')},addColours:function(b,c){var d='';var e=false;for(var i=0;i<c.series.length;i++){var f='';if(b!='lxy'||i%2==0){var g=',';$.each(($.isArray(c.series[i].color)?c.series[i].color:[c.series[i].color]),function(i,v){var a=$.gchart.color(v||'');if(a){e=true}f+=g+(a||'000000');g='|'})}d+=(e?f:'')}return(d.length>c.series.length?'&chco='+d.substr(1):'')},addTitle:function(a,b){return $.gchart._include('&chtt=',encodeURIComponent(b.title))+(b.titleColor||b.titleSize?'&chts='+($.gchart.color(b.titleColor)||'000000')+','+(b.titleSize||14):'')},addBackgrounds:function(d,e){var f=(!e.opacity?null:'000000'+Math.floor(e.opacity/(e.opacity>1?100:1)*255).toString(16));if(f&&f.length<8){f='0'+f}var g=function(a,b){if(b==null){return''}if(typeof b=='string'){return a+',s,'+$.gchart.color(b)}var c=a+',l'+(b.striped?'s':'g')+','+(z[b.angle]!=null?z[b.angle]:b.angle);for(var i=0;i<b.colorPoints.length;i++){c+=','+$.gchart.color(b.colorPoints[i][0])+','+b.colorPoints[i][1]}return c};var h=g('|a',f)+g('|bg',e.backgroundColor)+g('|c',e.chartColor);return(h?'&chf='+h.substr(1):'')},addGrids:function(a,b){var c=(typeof b.gridSize=='number'?[b.gridSize,b.gridSize]:b.gridSize);var d=(typeof b.gridLine=='number'?[b.gridLine,b.gridLine]:b.gridLine);var e=(typeof b.gridOffsets=='number'?[b.gridOffsets,b.gridOffsets]:b.gridOffsets);return(!c?'':'&chg='+c[0]+','+c[1]+(!d?'':','+d[0]+','+d[1]+(!e?'':','+e[0]+','+e[1])))},addLegends:function(a,b){var c='';for(var i=0;i<b.series.length;i++){if(a!='lxy'||i%2==0){c+='|'+encodeURIComponent(b.series[i].label||'')}}var d=(b.legendOrder&&b.legendOrder.match(/^\d+(,\d+)*$/)?b.legendOrder:C[b.legendOrder])||'';return(!b.legend||(a!='lxy'&&c.length<=b.series.length)||(a=='lxy'&&c.length<=(b.series.length/2))?'':'&chdl='+c.substr(1)+$.gchart._include('&chdlp=',b.legend.charAt(0)+(b.legend.indexOf('V')>-1?'v':'')+$.gchart._include('|',d))+(b.legendColor||b.legendSize?'&chdls='+($.gchart.color(b.legendColor)||'000000')+','+(b.legendSize||11):''))},addExtensions:function(a,b){var c='';for(var d in b.extension){c+='&'+d+'='+b.extension[d]}return c},addAxes:function(a,b){var c='';var d='';var e='';var f='';var g='';var h='';for(var i=0;i<b.axes.length;i++){if(!b.axes[i]){continue}var k=(typeof b.axes[i]=='string'?new GChartAxis(b.axes[i]):b.axes[i]);var l=k.axis().charAt(0);c+=','+(l=='b'?'x':(l=='l'?'y':l));if(k.labels()){var m='';for(var j=0;j<k.labels().length;j++){m+='|'+encodeURIComponent(k.labels()[j]||'')}d+=(m?'|'+i+':'+m:'')}if(k.positions()){var n='';for(var j=0;j<k.positions().length;j++){n+=','+k.positions()[j]}e+=(n?'|'+i+n:'')}if(k.range()){var o=k.range();f+='|'+i+','+o[0]+','+o[1]+(o[2]?','+o[2]:'')}var p=k.ticks()||{};if(k.color()||k.style()||k.drawing()||p.color||k.format()){var q=k.style()||{};g+='|'+i+(k.format()?'N'+this.numberFormat(k.format()):'')+','+$.gchart.color(q.color||'gray')+','+(q.size||10)+','+(A[q.alignment]||q.alignment||0)+','+(B[k.drawing()]||k.drawing()||'lt')+(!p.color&&!k.color()?'':','+(p.color?$.gchart.color(p.color):'808080')+(!k.color()?'':','+$.gchart.color(k.color())))}if(p.length){h+='|'+i+','+($.isArray(p.length)?p.length.join(','):p.length)}}return(!c?'':'&chxt='+c.substr(1)+(!d?'':'&chxl='+d.substr(1))+(!e?'':'&chxp='+e.substr(1))+(!f?'':'&chxr='+f.substr(1))+(!g?'':'&chxs='+g.substr(1))+(!h?'':'&chxtc='+h.substr(1)))},addMarkers:function(e,f){var g='';var h=function(a,b){if(a=='all'){return-1}if(typeof a=='string'){var c=/^every(\d+)(?:\[(\d+):(\d+)\])?$/.exec(a);if(c){var d=parseInt(c[1],10);return(c[2]&&c[3]?(b?Math.max(0.0,Math.min(1.0,c[2])):c[2])+':'+(b?Math.max(0.0,Math.min(1.0,c[3])):c[3])+':'+d:-d)}}if($.isArray(a)){a=$.map(a,function(v,i){return(b?Math.max(0.0,Math.min(1.0,v)):v)});return a.join(':')+(a.length<2?':':'')}return a};var k=function(a){return a.replace(/,/g,'\\,')};for(var i=0;i<f.markers.length;i++){var l=f.markers[i];var m=u[l.shape]||l.shape;var n='';if(l.placement){var o=$.makeArray(l.placement);for(var j=0;j<o.length;j++){n+=D[o[j]]||''}}g+='|'+(l.positioned?'@':'')+m+('AfNt'.indexOf(m)>-1?k(l.text||''):'')+','+$.gchart.color(l.color)+','+l.series+','+h(l.item,l.positioned)+','+l.size+','+(w[l.priority]!=null?w[l.priority]:l.priority)+(n||l.offsets?','+n+':'+(l.offsets&&l.offsets[0]?l.offsets[0]:'')+':'+(l.offsets&&l.offsets[1]?l.offsets[1]:''):'')}for(var i=0;i<f.ranges.length;i++){g+='|'+(f.ranges[i].vertical?'R':'r')+','+$.gchart.color(f.ranges[i].color)+',0,'+f.ranges[i].start+','+(f.ranges[i].end||f.ranges[i].start+0.005)}for(var i=0;i<f.series.length;i++){if(f.series[i].fillColor){var p=($.isArray(f.series[i].fillColor)?f.series[i].fillColor:[f.series[i].fillColor]);for(var j=0;j<p.length;j++){if(typeof p[j]=='string'){g+='|b,'+$.gchart.color(f.series[i].fillColor)+','+i+','+(i+1)+',0'}else{var q=($.isArray(p[j])?p[j]:[p[j].color,p[j].range]);g+='|B,'+$.gchart.color(q[0])+','+i+','+q[1]+',0'}}}}return(g?'&chm='+g.substr(1):'')},_updateChart:function(b,c){c._src=this._generateChart(c);if(c.usePost){var d='<form action="'+(c.secure?'https://chart.googleapis.com':'http://chart.apis.google.com')+'/chart?'+Math.floor(Math.random()*1e8)+'" method="POST">';var e=/(\w+)=([^&]*)/g;var f=e.exec(c._src);while(f){d+='<input type="hidden" name="'+f[1]+'" value="'+($.inArray(f[1],['chdl','chl','chtt','chxl'])>-1?decodeURIComponent(f[2]):f[2])+'">';f=e.exec(c._src)}d+='</form>';b=$(b);b.empty();var g=$('<iframe></iframe>').appendTo(b).css({width:'100%',height:'100%'});var h=g.contents()[0];h.open();h.write(d);h.close();g.show().contents().find('form').submit()}else{var i=$(new Image());i.load(function(){$(b).find('img').remove().end().append(this);if(c.onLoad){if(c.provideJSON){$.getJSON(c._src+'&chof=json&callback=?',function(a){c.onLoad.apply(b,[$.gchart._normaliseRects(a)])})}else{c.onLoad.apply(b,[])}}});$(i).attr('src',c._src)}},_normaliseRects:function(a){if(a&&a.chartshape){for(var i=0;i<a.chartshape.length;i++){var b=a.chartshape[i];if(b.type=='RECT'){if(b.coords[0]>b.coords[2]){var c=b.coords[0];b.coords[0]=b.coords[2];b.coords[2]=c}if(b.coords[1]>b.coords[3]){var c=b.coords[1];b.coords[1]=b.coords[3];b.coords[3]=c}}}}return a},_textEncoding:function(a){var b=(a.minValue==$.gchart.calculate?this._calculateMinValue(a.series):a.minValue);var c=(a.maxValue==$.gchart.calculate?this._calculateMaxValue(a.series):a.maxValue);var d='';for(var i=0;i<a.series.length;i++){d+='|'+this._textEncode(a.series[i],b,c)}return't'+(a.visibleSeries||'')+':'+d.substr(1)},_textEncode:function(a,b,c){b=(a.minValue!=null?a.minValue:b);c=(a.maxValue!=null?a.maxValue:c);var d=100/(c-b);var e='';for(var i=0;i<a.data.length;i++){e+=','+(a.data[i]==null||isNaN(a.data[i])?'-1':Math.round(d*(a.data[i]-b)*100)/100)}return e.substr(1)},_scaledEncoding:function(a){var b=(a.minValue==$.gchart.calculate?this._calculateMinValue(a.series):a.minValue);var c=(a.maxValue==$.gchart.calculate?this._calculateMaxValue(a.series):a.maxValue);var d='';var e='';for(var i=0;i<a.series.length;i++){d+='|'+this._scaledEncode(a.series[i],b);e+=','+(a.series[i].minValue!=null?a.series[i].minValue:b)+','+(a.series[i].maxValue!=null?a.series[i].maxValue:c)}return't'+(a.visibleSeries||'')+':'+d.substr(1)+'&chds='+e.substr(1)},_scaledEncode:function(a,b){b=(a.minValue!=null?a.minValue:b);var c='';for(var i=0;i<a.data.length;i++){c+=','+(a.data[i]==null||isNaN(a.data[i])?(b-1):a.data[i])}return c.substr(1)},_simpleEncoding:function(a){var b=(a.minValue==$.gchart.calculate?this._calculateMinValue(a.series):a.minValue);var c=(a.maxValue==$.gchart.calculate?this._calculateMaxValue(a.series):a.maxValue);var d='';for(var i=0;i<a.series.length;i++){d+=','+this._simpleEncode(a.series[i],b,c)}return's'+(a.visibleSeries||'')+':'+d.substr(1)},_simpleEncode:function(a,b,c){b=(a.minValue!=null?a.minValue:b);c=(a.maxValue!=null?a.maxValue:c);var d=61/(c-b);var e='';for(var i=0;i<a.data.length;i++){e+=(a.data[i]==null||isNaN(a.data[i])?'_':E.charAt(Math.round(d*(a.data[i]-b))))}return e},_extendedEncoding:function(a){var b=(a.minValue==$.gchart.calculate?this._calculateMinValue(a.series):a.minValue);var c=(a.maxValue==$.gchart.calculate?this._calculateMaxValue(a.series):a.maxValue);var d='';for(var i=0;i<a.series.length;i++){d+=','+this._extendedEncode(a.series[i],b,c)}return'e'+(a.visibleSeries||'')+':'+d.substr(1)},_extendedEncode:function(b,c,d){c=(b.minValue!=null?b.minValue:c);d=(b.maxValue!=null?b.maxValue:d);var e=4095/(d-c);var f=function(a){return F.charAt(a/64)+F.charAt(a%64)};var g='';for(var i=0;i<b.data.length;i++){g+=(b.data[i]==null||isNaN(b.data[i])?'__':f(Math.round(e*(b.data[i]-c))))}return g},_calculateMinValue:function(a){var b=99999999;for(var i=0;i<a.length;i++){var c=a[i].data;for(var j=0;j<c.length;j++){b=Math.min(b,(c[j]==null?99999999:c[j]))}}return b},_calculateMaxValue:function(a){var b=-99999999;for(var i=0;i<a.length;i++){var c=a[i].data;for(var j=0;j<c.length;j++){b=Math.max(b,(c[j]==null?-99999999:c[j]))}}return b}});function GChartAxis(a,b,c,d,e,f,g,h,i,j,k){if(typeof b!='string'){k=j;j=i;i=h;h=g;g=f;f=e;e=d;d=c;c=b;b=null}if(typeof c=='number'){k=i;j=h;i=g;h=f;g=e;f=d;e=c;d=null;c=null}else if(!$.isArray(d)){k=j;j=i;i=h;h=g;g=f;f=e;e=d;d=null}if(typeof e=='string'){k=h;j=g;i=f;h=e;g=null;f=null;e=null}if(typeof g=='string'){k=j;j=i;i=h;h=g;g=null}if(typeof i=='number'){k=j;j=i;i=null}this._axis=a;this._lineColor=b;this._labels=c;this._positions=d;this._range=(e!=null?[e,f,g||null]:null);this._color=h;this._alignment=i;this._size=j;this._drawing=null;this._tickColor=null;this._tickLength=null;this._format=k}$.extend(GChartAxis.prototype,{axis:function(a){if(arguments.length==0){return this._axis}this._axis=a;return this},color:function(a){if(arguments.length==0){return this._lineColor}this._lineColor=a;return this},labels:function(a){if(arguments.length==0){return this._labels}this._labels=a;return this},positions:function(a){if(arguments.length==0){return this._positions}this._positions=a;return this},range:function(a,b,c){if(arguments.length==0){return this._range}this._range=[a,b,c||null];return this},style:function(a,b,c){if(arguments.length==0){return(!this._color&&!this._alignment&&!this._size?null:{color:this._color,alignment:this._alignment,size:this._size})}this._color=a;this._alignment=b;this._size=c;return this},drawing:function(a){if(arguments.length==0){return this._drawing}this._drawing=a;return this},ticks:function(a,b){if(arguments.length==0){return(!this._tickColor&&!this._tickLength?null:{color:this._tickColor,length:this._tickLength})}this._tickColor=a;this._tickLength=b;return this},format:function(a,b,c,d,e,f,g){if(arguments.length==0){return this._format}this._format=initNumberFormat(a,b,c,d,e,f,g);return this}});function initNumberFormat(a,b,c,d,e,f,g){if(typeof a=='object'){return a}if(typeof b=='number'){g=e;f=d;e=c;d=b;c='';b=''}if(typeof b=='boolean'){g=d;f=c;e=b;d=0;c='';b=''}if(typeof c=='number'){g=f;f=e;e=d;d=c;c=''}if(typeof c=='boolean'){g=e;f=d;e=c;d=0;c=''}if(typeof d=='boolean'){g=f;f=e;e=d;d=0}return{type:a,prefix:b||'',suffix:c||'',precision:d||'',showX:e||false,zeroes:f||false,separators:g||false}}function extendRemove(a,b){$.extend(a,b);for(var c in b){if(b[c]==null){a[c]=null}}return a}$.fn.gchart=function(a){var b=Array.prototype.slice.call(arguments,1);if(a=='current'){return $.gchart['_'+a+'GChart'].apply($.gchart,[this[0]].concat(b))}return this.each(function(){if(typeof a=='string'){$.gchart['_'+a+'GChart'].apply($.gchart,[this].concat(b))}else{$.gchart._attachGChart(this,a)}})};$.gchart=new GChart()})(jQuery);