/**
The MIT License

Copyright (c) 2010 Yuriy Okhonin

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in
all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
THE SOFTWARE.
*/

function VhwxContainer() {
	this.Append = function(object) {
		this.container.appendChild(object.GetContainer());
		}
	}


function Vhwx(id) {
	this.name = "Vhwx";
	this.children = new Array();
	this.isIE = function() {
		var ua = navigator.userAgent.toLowerCase();
		var isIE = (ua.indexOf("msie") != -1);
		if(isIE) {
			//alert(ua);
			return true;
			}
		return false;
		}
	this.Init = function(id) {
		this.source_container = document.getElementById(id);
		this.container = document.createElement("DIV");
		this.container.className="vhwx";
		this.source_container.parentNode.appendChild(this.container);
		this.source_container.style.display = 'none';
		if(this.isIE()) {
			this.container.innerHTML = 'Oops, IE currently not supported by VHWX, use Opera, Firefox or Chrome';
			return;
			}
		this.CreateBlocks();
		}
	this.RemoveChild = function(object) {
		for(var i=0; i<this.children.length; i++) {
			if(this.children[i] == object) {
				this.children.splice(i,1);
				i--;
				}
			}
		}
	this.MoveChildUp = function(object) {
		for(var i=1; i<this.children.length; i++) {
			if(this.children[i] == object) {
				temp = this.children[i-1];
				this.children[i-1] = this.children[i];
				this.children[i] = temp;
				}
			}
		}
	this.MoveChildDown = function(object) {
		for(var i=0; i<this.children.length-1; i++) {
			if(this.children[i] == object) {
				temp = this.children[i+1];
				this.children[i+1] = this.children[i];
				this.children[i] = temp;
				}
			}
		}
	this.Append = function(object) {
		this.container.appendChild(object.container);
		this.children.push(object);
		}
	this.CreateXml = function() {
		var xml = '';
		xml = new String();
		for(i=0;i<this.children.length;i++) {
			xml += this.children[i].getXml();
			}
		this.source_container.innerHTML = '';
		this.source_container.innerHTML = xml;
		}
	this.CreateBlocks = function() {
		this.container.innerHTML = '';
		this.children = new Array();
		this.Append(new VhwxMenu(this));
		var xmlEl = document.createElement("DIV")
		var str = this.source_container.innerHTML;
		xmlEl.innerHTML = str.replace(/&lt;/g,"<").replace(/&gt;/g,">");
		var len = xmlEl.childNodes.length;
		for(var i=0;i<len;i++) {
			var nodename = xmlEl.childNodes[i].nodeName.toLowerCase();
			if(nodename != "#text") {
				var Block = new VhwxBlock(this);
				Block.TagName.Value.container.innerHTML = xmlEl.childNodes[i].nodeName.toLowerCase();
				Block.TagName.AppendAttributes(xmlEl.childNodes[i].attributes);
				if(xmlEl.childNodes[i].hasChildNodes()) {
					Block.TagContent.container.innerHTML = xmlEl.childNodes[i].childNodes[0].nodeValue;
					Block.AppendXml(xmlEl.childNodes[i]);
					}
				this.Append(Block);
				}
			}
		//xmlEl.parentNode.removeChild(xmlEl);
		}
	this.ToggleSource = function() {
		if(this.sourceView) {
			this.sourceView = false;
			this.CreateBlocks();
			} else {
			this.sourceView = true;
			this.container.innerHTML = '';
			this.children = new Array();
			this.Append(new VhwxMenu(this));
			div = document.createElement('DIV');
			div.innerHTML = this.source_container.innerHTML.replace(/</g,"&lt;").replace(/>/g,"&gt;").replace(/&lt;(?!\/)/g,"<dir>&lt;").replace(/&lt;\/([a-z,A-Z]*)&gt;/g,"$&</dir>");
			this.container.appendChild(div);
			}
		}
	this.Init(id);
	}


function VhwxMenu(parentObject) {
	this.name = "VhwxMenu";
	this.p = parentObject;
	this.Append = function(object) {
		this.container.appendChild(object.container);
		}
	this.getXml = function() { return ""; }
	this.container = document.createElement("DIV");
	this.container.className = "vhwxMenu";
	this.Append(new VhwxAddButton(this));
	this.Append(new VhwxViewSourceButton(this));
	//this.Append(new VhwxXmlToTextareaButton(this));
	//this.Append(new VhwxTextareaToXmlButton(this));
	}

function VhwxAddButton(parentObject) {
	this.name = "VhwxMenuButton";
	this.p = parentObject;
	this.container = document.createElement("DIV");
	this.container.className = "vhwxMenuButton";
	this.container.innerHTML = "Add Root Tag";
	this.container.p = this;
	this.container.onclick = function() {
		this.p.p.p.Append(new VhwxBlock(this.p.p.p, true));
		}
	}

function VhwxViewSourceButton(parentObject) {
	this.name = "VhwxMenuButton";
	this.p = parentObject;
	this.container = document.createElement("DIV");
	this.container.className = "vhwxMenuButton";
	this.container.innerHTML = "View Xml Code";
	this.container.p = this;
	this.container.onclick = function() {
		this.p.p.p.ToggleSource();
		}
	}

function VhwxAddTagButton(parentObject) {
	this.getXml = function() {return "";}
	this.name = "VhwxTagButton";
	this.p = parentObject;
	this.container = document.createElement("DIV");
	this.container.className = "vhwxTagButton";
	this.container.innerHTML = "Add";
	this.container.p = this;
	this.container.onclick = function() {
		this.p.p.Append(new VhwxBlock(this.p.p, true));
		}
	}

function VhwxRemoveTagButton(parentObject) {
	this.getXml = function() {return "";}
	this.name = "VhwxTagButton";
	this.p = parentObject;
	this.container = document.createElement("DIV");
	this.container.className = "vhwxTagButton";
	this.container.innerHTML = "Remove";
	this.container.p = this;
	this.container.onclick = function() {
		this.p.p.Remove();
		this.p.p.CreateXml();
		}
	}
function VhwxMoveUpButton(parentObject) {
	this.getXml = function() {return "";}
	this.name = "VhwxTagButton";
	this.p = parentObject;
	this.container = document.createElement("DIV");
	this.container.className = "vhwxTagButton";
	this.container.innerHTML = "&uarr;";
	this.container.p = this;
	this.container.onclick = function() {
		this.p.p.MoveUp();
		this.p.p.CreateXml();
		this.p.p.CreateBlocks();
		}
	}

function VhwxMoveDownButton(parentObject) {
	this.getXml = function() {return "";}
	this.name = "VhwxTagButton";
	this.p = parentObject;
	this.container = document.createElement("DIV");
	this.container.className = "vhwxTagButton";
	this.container.innerHTML = "&darr;";
	this.container.p = this;
	this.container.onclick = function() {
		this.p.p.MoveDown();
		this.p.p.CreateXml();
		this.p.p.CreateBlocks();
		}
	}

function VhwxXmlToTextareaButton(parentObject) {
	this.name = "VhwxXmlToTextareaButton";
	this.p = parentObject;
	this.container = document.createElement("DIV");
	this.container.className = "vhwxMenuButton";
	this.container.innerHTML = "Create Xml";
	this.container.p = this;
	this.container.onclick = function() {
		this.p.p.p.CreateXml();
		}
	}
function VhwxTextareaToXmlButton(parentObject) {
	this.name = "VhwxTextareaToXmlButton";
	this.p = parentObject;
	this.container = document.createElement("DIV");
	this.container.className = "vhwxMenuButton";
	this.container.innerHTML = "Create Blocks";
	this.container.p = this;
	this.container.onclick = function() {
		this.p.p.p.CreateBlocks();
		}
	}

function VhwxBlock(parentObject, setFocus) {
	this.p = parentObject;
	this.children = new Array();
	this.Append = function(object) {
		this.container.appendChild(object.container);
		this.children.push(object);
		}
	this.Remove = function() {
		this.container.parentNode.removeChild(this.container);
		this.p.RemoveChild(this);
		}
	this.MoveUp = function() {
		this.p.MoveChildUp(this);
		}
	this.MoveDown = function() {
		this.p.MoveChildDown(this);
		}
	this.RemoveChild = function(object) {
		for(var i=0; i<this.children.length; i++) {
			if(this.children[i] == object) {
				this.children.splice(i,1);
				i--;
				}
			}
		}
	this.MoveChildUp = function(object) {
		for(var i=1; i<this.children.length; i++) {
			if(this.children[i] == object) {
				temp = this.children[i-1];
				this.children[i-1] = this.children[i];
				this.children[i] = temp;
				}
			}
		}
	this.MoveChildDown = function(object) {
		for(var i=0; i<this.children.length-1; i++) {
			if(this.children[i] == object) {
				temp = this.children[i+1];
				this.children[i+1] = this.children[i];
				this.children[i] = temp;
				}
			}
		}
	this.AppendXml = function(xmlEl) {
		var len = xmlEl.childNodes.length;
		for(var i=0;i<len;i++) {
			var nodename = xmlEl.childNodes[i].nodeName.toLowerCase();
			//alert(nodename);
			if(nodename != "#text") {
				var Block = new VhwxBlock(this);
				Block.TagName.Value.container.innerHTML = xmlEl.childNodes[i].nodeName.toLowerCase();
				Block.TagName.AppendAttributes(xmlEl.childNodes[i].attributes);
				
				if(xmlEl.childNodes[i].hasChildNodes()) {
					Block.TagContent.container.innerHTML = xmlEl.childNodes[i].childNodes[0].nodeValue;
					Block.AppendXml(xmlEl.childNodes[i]);
					}
				this.Append(Block);
				}
			}
		}
	this.name = "VhwxBlock";
	this.getXml = function() {
		var xml = '';
		var len = this.children.length;

		for(var i=0;i<len;i++) {
			xml += this.children[i].getXml();
			}
		
		return "<"+this.TagName.getTagName()+this.TagName.getAttrXml()+">"+xml+"</"+this.TagName.getTagName()+">\n";
		}
	this.container = document.createElement("DIV");
	this.container.p = this;
	this.CreateXml = function () { this.p.CreateXml();};
	this.CreateBlocks = function () { this.p.CreateBlocks();};
	this.container.className = "vhwxBlock";
	this.Append(new VhwxRemoveTagButton(this));
	this.Append(new VhwxAddTagButton(this));
	this.Append(new VhwxMoveDownButton(this));
	this.Append(new VhwxMoveUpButton(this));
	this.TagName = new VhwxBlockName(this, setFocus);
	this.Append(this.TagName);
	this.TagContent = new VhwxBlockContent(this);
	this.Append(this.TagContent);
	}

function VhwxBlockName(parentObject, setFocus) {
	this.p = parentObject;
	this.children = new Array();
	this.Append = function(object) {
		this.container.appendChild(object.container);
		this.children.push(object);
		}
	this.AppendAttributes = function(attributes) {
		for(var i=0;i<attributes.length;i++) {
			var nodename = attributes[i].nodeName.toLowerCase();
			if(nodename != "#text") {
				var Block = new VhwxAttribute(this);
				Block.Name.container.innerHTML = nodename;
				Block.Value.container.innerHTML = attributes[i].nodeValue;
				this.Append(Block);
				}
			}
		}
	this.name = "VhwxBlockName";
	this.p = parentObject;
	this.getXml = function() {
		return "";
		}
	this.getAttrXml = function() {
		var xml = '';
		var len = this.children.length;
		for(var i=0;i<len;i++) {
			xml += this.children[i].getXml();
			}
		return xml;
		}
	this.getTagName = function () {
		return this.Value.getTagName();
		}
	this.CreateXml = function () { this.p.CreateXml();};
	this.CreateBlocks = function () { this.p.CreateBlocks();};
	this.container = document.createElement("DIV");
	this.container.p = this;
	this.container.className = "vhwxBlockName";
	this.container.innerHTML = "";
	this.Value = new VhwxBlockNameValue(this,setFocus);
	this.Append(this.Value);
	}

function VhwxBlockNameValue(parentObject, setFocus) {
	//alert('!');
	this.Append = function(object) {
		this.container.appendChild(object.container);
		}
	this.name = "VhwxBlockNameValue";
	this.p = parentObject;
	this.CreateXml = function () { this.p.CreateXml();};
	this.getXml = function() {
		return ""; //this.container.innerHTML;
		}
	this.getTagName = function () {
		if(this.container.hasChildNodes()) {
			return this.container.childNodes[0].nodeValue;
			}
		return "";
		}
	this.container = document.createElement("SPAN");
	this.container.p = this;
	this.container.className = "vhwxBlockNameValue";
	this.container.contentEditable = "true";
	this.container.innerHTML = "";
	this.container.onkeyup = function(event) {
		this.p.p.CreateXml();
		}
	if(setFocus) {
		this.container.focus(); //! TODO should point cursor to created node name, doesnot work now
		}
	this.container.onkeypress = function(event) {
		if(String.fromCharCode(event.charCode) == " ") {
			this.p.p.Append(new VhwxAttribute(this.p, true));
			return false;
			}
		}
	}


function VhwxAttribute(parentObject) {
	this.p = parentObject;	
	this.CreateXml = function () { this.p.CreateXml();};
	this.CreateBlocks = function () { this.p.CreateBlocks();};
	this.Append = function(object) {
		this.container.appendChild(object.container);
		}
	this.getXml = function() {
		return " "+this.Name.GetValue()+'="'+this.Value.GetValue()+'"';
		}

	this.container = document.createElement("SPAN");
	this.container.className = "vhwxAttribute";
	this.container.innerHTML = '';
	this.Name = new VhwxAttributeName(this);
	this.Value = new VhwxAttributeValue(this)
	this.Append(this.Name);
	this.Append(this.Value);
	}

function VhwxAttributeName(parentObject) {
	this.GetValue = function() {
		if(this.container.hasChildNodes()) {
			return this.container.childNodes[0].nodeValue;
			}
		}
	this.p = parentObject;
	this.container = document.createElement("SPAN");
	this.container.p = this;
	this.container.className = "vhwxAttributeName";
	this.container.contentEditable = "true";
	this.container.innerHTML = '';
	this.container.onkeyup = function(event) {
		this.p.p.CreateXml();
		}
	}

function VhwxAttributeValue(parentObject) {
	this.GetValue = function() {
		if(this.container.hasChildNodes()) {
			return this.container.childNodes[0].nodeValue;
			}
		}
	this.p = parentObject;
	this.container = document.createElement("SPAN");
	this.container.p = this;
	this.container.className = "vhwxAttributeValue";
	this.container.contentEditable = "true";
	this.container.innerHTML = '';
	this.container.onkeyup = function(event) {
		this.p.p.CreateXml();
		}
	}

function VhwxBlockContent(parentObject) {
	this.name = "VhwxBlockContent";
	this.p = parentObject;
	this.getXml = function() {
		return this.container.textContent.replace(/^\s+/,"");
		}
	this.CreateXml = function() { this.p.CreateXml() }
	this.container = document.createElement("DIV");
	this.container.p = this;
	this.container.className = "vhwxBlockContent";
	this.container.contentEditable = "true";
	this.container.innerHTML = "";
	this.container.onkeyup = function(event) {
		this.p.CreateXml();
		}
	this.container.onkeypress = function(event) {
		if(String.fromCharCode(event.charCode) == "<") {
			this.p.p.Append(new VhwxBlock(this.p, true));
			return false;
			}
		}
	}
