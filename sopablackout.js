(function (){
	var root = this;

	var SopaBlackout = function(){};
	var	addEvent = function(obj, type, fn, ref_obj){
		if (obj.addEventListener){
			obj.addEventListener(type, fn, false);
		}else if (obj.attachEvent){
			obj["e"+type+fn] = fn;
			obj[type+fn] = function(){
				obj["e"+type+fn](window.event,ref_obj);
			};
			obj.attachEvent("on"+type, obj[type+fn]);
		}
	};
	var onDomReady = function(fn){
		if (document.addEventListener){
			document.addEventListener('DOMContentLoaded', fn, false);
		}else{
			if (!document.uniqueID && document.expando){return;};
			var tempNode = document.createElement('document:ready');
			try{
				tempNode.doScroll('left');
				fn();
			}catch (err){
				setTimeout(arguments.callee, 0);
			}
		}
	};
	var getStyle = function(e, prop){
		if (e.currentStyle){
			return e.currentStyle[prop];
		}else if (document.defaultView && document.defaultView.getComputedStyle){
			return document.defaultView.getComputedStyle(e, "")[prop];
		}else{
			return e.style[prop];
		}
	};
	var findPos = function(obj){
		var curleft = 0;
		var curtop = 0;
		if (obj.offsetParent){
			do{
				curleft += obj.offsetLeft;
				curtop += obj.offsetTop;
			}while(obj = obj.offsetParent);
		}
		return [curleft, curtop];
	};
	var txt = function(s){
		return document.createTextNode(s);
	};
	var create = function(e, props){
		var elem = document.createElement(e);
		var props = props !== null ? props : {};
		for (var key in props){
			if (key == 'href'){
				elem.href = props[key];
			}else{
				elem.style[key] = props[key];
			}
		}
		l = arguments.length;
		for (var i=2; i<l; i++){
			elem.appendChild(arguments[i]);
		}
		return elem;
	};

	SopaBlackout.VERSION = '0.1.0';
	SopaBlackout.MIN_HEIGHT = 100;
	SopaBlackout.HEADER_TEXT = "This is what the web could look like under the Stop Online Piracy Act.";
	SopaBlackout.CONTINUE_TEXT = "(click anywhere to continue)";
	SopaBlackout.blackout = function(obj_id, srsbzns){
		var obj;
		var body = document.body;
		if (obj_id === false){
			obj = body;
			height = "100%";
		}else{
			obj = document.getElementById(obj_id);
			var height = parseInt(getStyle(obj, 'height'), 10);
			height = height > SopaBlackout.MIN_HEIGHT ? height : SopaBlackout.MIN_HEIGHT;
		}
		var offsets = findPos(obj);

		var blackout = create('div', {
				position: 'absolute',
				top: offsets[1],
				width: '100%',
				backgroundColor: 'black',
				textAlign: 'center',
				paddingTop: '10px',
				zIndex: Number.MAX_VALUE,
				height: height,
				color: '#999'},
			create('h1', {color: '#999'}, txt(SopaBlackout.HEADER_TEXT)),
			create('p', null,
				txt("Keep the web open. "),
			create('a', {href: "https://wfc2.wiredforchange.com/o/9042/p/dia/action/public/?action_KEY=8173"}, txt("Contact your representatives")),
				txt(" or "),
				create('a', {href: "http://sopablackout.org/learnmore"}, txt("find out more")))
		);
		if (srsbzns !== true){
			blackout.appendChild(create('p', {paddingTop: '250px', color: '#333'}, txt(SopaBlackout.CONTINUE_TEXT)));
			addEvent(blackout, 'click', function(e){
				body.removeChild(blackout);
			});
		}
		body.appendChild(blackout);
	};
	SopaBlackout.go = function(){
		var obj_id = (typeof sopablackout_id === 'undefined') ? false : sopablackout_id;
		var srsbzns = (typeof sopablackout_srsbzns === 'undefined') ? false : sopablackout_srsbzns;
		SopaBlackout.blackout(obj_id, srsbzns);
	};

	onDomReady(SopaBlackout.go);
}).call(this);
