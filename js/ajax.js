/**
 *  author:		Timothy Groves - http://www.brandspankingnew.net
 *	version:	1.5 - 2006-08-03
 *
 *	requires:	nothing
 *
 */
function sent(it,php){
	
	var options1 = {
		script:php+"?",
		varname:"input",
		minchars:1
	
	
	};
	var as1 = new AutoSuggest(it, options1);
	
	}
    



var useBSNns;

if (useBSNns)
{
	if (typeof(bsn) == "undefined")
		bsn = {}
	_bsn = bsn;
}
else
{
	_bsn = this;
}


if (typeof(_bsn.DOM) == "undefined")
	_bsn.DOM = {}




_bsn.DOM.createElement = function ( type, attr, cont, html )
{
	var ne = document.createElement( type );
	if (!ne)
		return false;
		
	for (var a in attr)
		ne[a] = attr[a];
		
	if (typeof(cont) == "string" && !html)
		ne.appendChild( document.createTextNode(cont) );
	else if (typeof(cont) == "string" && html)
		ne.innerHTML = cont;
	else if (typeof(cont) == "object")
		ne.appendChild( cont );
	return ne;
}





_bsn.DOM.clearElement = function ( id )
{
	var ele = this.getElement( id );
	
	if (!ele)
		return false;
	
	while (ele.childNodes.length)
		ele.removeChild( ele.childNodes[0] );
	
	return true;
}









_bsn.DOM.removeElement = function ( ele )
{
	var e = this.getElement(ele);
	
	if (!e)
		return false;
	else if (e.parentNode.removeChild(e))
		return true;
	else
		return false;
}





_bsn.DOM.replaceContent = function ( id, cont, html )
{
	var ele = this.getElement( id );
	
	if (!ele)
		return false;
	
	this.clearElement( ele );
	
	if (typeof(cont) == "string" && !html)
		ele.appendChild( document.createTextNode(cont) );
	else if (typeof(cont) == "string" && html)
		ele.innerHTML = cont;
	else if (typeof(cont) == "object")
		ele.appendChild( cont );
}









_bsn.DOM.getElement = function ( ele )
{
	if (typeof(ele) == "undefined")
	{
		return false;
	}
	else if (typeof(ele) == "string")
	{
		var re = document.getElementById( ele );
		if (!re)
			return false;
		else if (typeof(re.appendChild) != "undefined" ) {
			return re;
		} else {
			return false;
		}
	}
	else if (typeof(ele.appendChild) != "undefined")
		return ele;
	else
		return false;
}







_bsn.DOM.appendChildren = function ( id, arr )
{
	var ele = this.getElement( id );
	
	if (!ele)
		return false;
	
	
	if (typeof(arr) != "object")
		return false;
		
	for (var i=0;i<arr.length;i++)
	{
		var cont = arr[i];
		if (typeof(cont) == "string")
			ele.appendChild( document.createTextNode(cont) );
		else if (typeof(cont) == "object")
			ele.appendChild( cont );
	}
}





//	var opt = new Array( '1'=>'lorem', '2'=>'ipsum' );
// var sel = '2';

_bsn.DOM.createSelect = function ( attr, opt, sel )
{
	var select = this.createElement( 'select', attr );
	for (var a in opt)
	{
	
		var o = {id:a};
		if (a == sel)	o.selected = "selected";
		select.appendChild( this.createElement( 'option', o, opt[a] ) );
		
	}
	
	return select;
}




_bsn.DOM.getPos = function ( ele )
{
	var ele = this.getElement(ele);

	var obj = ele;

	var curleft = 0;
	if (obj.offsetParent)
	{
		while (obj.offsetParent)
		{
			curleft += obj.offsetLeft
			obj = obj.offsetParent;
		}
	}
	else if (obj.x)
		curleft += obj.x;


	var obj = ele;
	
	var curtop = 0;
	if (obj.offsetParent)
	{
		while (obj.offsetParent)
		{
			curtop += obj.offsetTop
			obj = obj.offsetParent;
		}
	}
	else if (obj.y)
		curtop += obj.y;

	return {x:curleft, y:curtop}
}


var useBSNns;

if (useBSNns)
{
	if (typeof(bsn) == "undefined")
		bsn = {}
	_bsn = bsn;
}
else
{
	_bsn = this;
}


if (typeof(_bsn.DOM) == "undefined")
	_bsn.DOM = {}
	







_bsn.AutoSuggest = function (fldID, param)
{
	if (!document.getElementById)
		return false;
	
	this.fld = _bsn.DOM.getElement(fldID);

	if (!this.fld)
		return false;
		
		
	this.nInputChars = 0;
	this.aSuggestions = [];
	this.iHighlighted = 0;
	
	
	// parameters object
	this.oP = (param) ? param : {};
	// defaults	
	if (!this.oP.minchars)		this.oP.minchars = 1;
	if (!this.oP.method)		this.oP.meth = "get";
	if (!this.oP.varname)		this.oP.varname = "input";
	if (!this.oP.className)		this.oP.className = "autosuggest";
	if (!this.oP.timeout)		this.oP.timeout = 3500;
	if (!this.oP.delay)			this.oP.delay = 9;
	if (!this.oP.maxheight && this.oP.maxheight !== 0)		this.oP.maxheight = 450;
	if (!this.oP.cache)			this.oP.cache = true;
	
	var pointer = this;
	
	this.fld.onkeyup = function () { pointer.getSuggestions( this.value ) };
	this.fld.setAttribute("autocomplete","off");
}



_bsn.AutoSuggest.prototype.getSuggestions = function (val)
{

	if (val.length == this.nInputChars)
		return false;
	
	if (val.length < this.oP.minchars)
	{
		this.nInputChars = val.length;
		this.aSuggestions = [];
		this.clearSuggestions();
		return false;
	}
	
	
	if (val.length>this.nInputChars && this.aSuggestions.length && this.oP.cache)
	{
		// get from cache
		var arr = [];
		for (var i=0;i<this.aSuggestions.length;i++)
		{
			if (this.aSuggestions[i].substr(0,val.length).toLowerCase() == val.toLowerCase())
				arr.push( this.aSuggestions[i] );
		}
		
		this.nInputChars = val.length;
		this.aSuggestions = arr;
		
		
		this.createList( this.aSuggestions );
		
		return false;
	}
	
	
	this.nInputChars = val.length;
	
	var pointer = this;
	clearTimeout(this.ajID);
	this.ajID = setTimeout( function() { pointer.doAjaxRequest() }, this.oP.delay );


	return false;
}





_bsn.AutoSuggest.prototype.doAjaxRequest = function ()
{
	var pointer = this;
	
	// create ajax request
	var url = this.oP.script+this.oP.varname+"="+escape(this.fld.value);
	var meth = this.oP.meth;
	
	var onSuccessFunc = function (req) { pointer.setSuggestions(req) };
	var onErrorFunc = function (status) { alert("AJAX error: "+status); };

	var myAjax = new _bsn.Ajax;
	myAjax.makeRequest( url, meth, onSuccessFunc, onErrorFunc );
//alert(url);
}





_bsn.AutoSuggest.prototype.setSuggestions = function (req)
{
	
	var xml = req.responseXML;
	
	// traverse xml
	//
	this.aSuggestions = [];
	

	
	try{
		
	var results = xml.getElementsByTagName('results')[0].childNodes;
	
	}catch(e){//alert(e);
	}
//alert("pASS");
//alert(results.length);
	for (var i=0;i<results.length;i++)
	{
		if (results[i].hasChildNodes())
		var hope=results[i].childNodes[0].nodeValue ;
			hope=unescape(hope);
			
			//alert(hope);
			this.aSuggestions.push(hope);
	}
	
	
	this.idAs = "as_"+this.fld.id;
	
	
	this.createList(this.aSuggestions);

}





_bsn.AutoSuggest.prototype.createList = function(arr)
{
	// clear previous list
	//
	this.clearSuggestions();

	// create and populate ul
	//
	var ul = _bsn.DOM.createElement("ul", {id:this.idAs, className:this.oP.className});
	
	
	var pointer = this;
	for (var i=0;i<arr.length;i++)
	{
		var a = _bsn.DOM.createElement("a", { href:"#" }, arr[i]);
		//a='<a href:"#"></a>';
		//alert(a);
		a.onclick = function () { pointer.setValue( this.childNodes[0].nodeValue ); return false; }
		var li = _bsn.DOM.createElement(  "li", {}, a  );
		//var li='<li></li>';
		ul.appendChild(  li  );
	}
	
	
	var pos = _bsn.DOM.getPos(this.fld);
	
	ul.style.left = pos.x + "px";
	ul.style.top = ( pos.y + this.fld.offsetHeight ) + "px";
	ul.style.width = this.fld.offsetWidth+"px";
	ul.onmouseover = function(){ pointer.killTimeout() }
	ul.onmouseout = function(){ pointer.resetTimeout() }


	document.getElementsByTagName("body")[0].appendChild(ul);
	//alert(ul.innerHTML);
	
	if (ul.offsetHeight > this.oP.maxheight && this.oP.maxheight != 0)
	{
		ul.style['height'] = this.oP.maxheight;
	}
	
	
	var TAB = 9;
	var ESC = 27;
	var KEYUP = 38;
	var KEYDN = 40;
	var RETURN = 13;
	
	
	
	this.fld.onkeydown = function(ev)
	{
		var key = (window.event) ? window.event.keyCode : ev.keyCode;

		switch(key)
		{
			case TAB:
			pointer.setHighlightedValue();
			break;

			case RETURN:
			
			pointer.setHighlightedValue();
			pointer.clearSuggestions();
			ev.preventDefault();
			

						break;
			case ESC:
			break;

			case KEYUP:
			pointer.changeHighlight(key);
			return false;
			break;

			case KEYDN:
			pointer.changeHighlight(key);
			return false;
			break;
		}

	};

	this.iHighlighted = 0;
	
	
	// remove autosuggest after an interval
	//
	clearTimeout(this.toID);
	var pointer = this;
	this.toID = setTimeout(function () { pointer.clearSuggestions() }, this.oP.timeout);
}









_bsn.AutoSuggest.prototype.changeHighlight = function(key)
{
	var list = _bsn.DOM.getElement(this.idAs);
	if (!list)
		return false;
	
	
	if (this.iHighlighted > 0)
		list.childNodes[this.iHighlighted-1].className = "";
	
	if (key == 40)
		this.iHighlighted ++;
	else if (key = 38)
		this.iHighlighted --;
	
	
	if (this.iHighlighted > list.childNodes.length)
		this.iHighlighted = list.childNodes.length;
	if (this.iHighlighted < 1)
		this.iHighlighted = 1;
	
	list.childNodes[this.iHighlighted-1].className = "highlight";
	
	//alert( list.childNodes[this.iHighlighted-1].firstChild.firstChild.nodeValue );
	
	this.killTimeout();
}








_bsn.AutoSuggest.prototype.killTimeout = function()
{
	clearTimeout(this.toID);
}

_bsn.AutoSuggest.prototype.resetTimeout = function()
{
	clearTimeout(this.toID);
	var pointer = this;
	this.toID = setTimeout(function () { pointer.clearSuggestions() }, 1000);
}







_bsn.AutoSuggest.prototype.clearSuggestions = function ()
{
	if (document.getElementById(this.idAs))
		_bsn.DOM.removeElement(this.idAs);
	this.fld.onkeydown = null;
}







_bsn.AutoSuggest.prototype.setHighlightedValue = function ()
{
	if (this.iHighlighted)
	{
		this.fld.value = document.getElementById(this.idAs).childNodes[this.iHighlighted-1].firstChild.firstChild.nodeValue;
		this.killTimeout();
		this.clearSuggestions();
	}
		//e.preventDefault();

}



_bsn.AutoSuggest.prototype.setValue = function (val)
{
	this.fld.value = val;
	this.resetTimeout();
}







var useBSNns;

if (useBSNns)
{
	if (typeof(bsn) == "undefined")
		bsn = {}
	_bsn = bsn;
}
else
{
	_bsn = this;
}









_bsn.Ajax = function ()
{
	this.req = {};
	this.isIE = false;
}



_bsn.Ajax.prototype.makeRequest = function (url, meth, onComp, onErr)
{
	
	if (meth != "POST")
		meth = "GET";
	
	this.onComplete = onComp;
	this.onError = onErr;
	
	var pointer = this;
	
	// branch for native XMLHttpRequest object
	if (window.XMLHttpRequest)
	{
		this.req = new XMLHttpRequest();
		this.req.onreadystatechange = function () { pointer.processReqChange() };
		this.req.open("GET", url, true); //
		this.req.send(null);
		//alert(url);
	// branch for IE/Windows ActiveX version
	}
	else if (window.ActiveXObject)
	{
		this.req = new ActiveXObject("Microsoft.XMLHTTP");
		if (this.req)
		{
			this.req.onreadystatechange = function () { pointer.processReqChange() };
			this.req.open(meth, url, true);
			this.req.send();
			
		}
	}
}


_bsn.Ajax.prototype.processReqChange = function()
{
	
	// only if req shows "loaded"
	if (this.req.readyState == 4) {
		// only if "OK"
		if (this.req.status == 200)
		{
			this.onComplete( this.req );
		} else {
			this.onError( this.req.status );
		}
	}
}