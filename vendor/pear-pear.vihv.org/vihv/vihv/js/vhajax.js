function VhAjax(element, method, request) {
	this.container = element;
	this.method = method;
	this.request = request;
	this.Paint = function() {
			//alert(1);
			//var xmlhttp;
			if (window.XMLHttpRequest)
			{// code for IE7+, Firefox, Chrome, Opera, Safari
			this.xmlhttp=new XMLHttpRequest();
			}
			else
			{// code for IE6, IE5
			this.xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
			}
			//container = this.container;
			this.xmlhttp.SetContainer = function(container) {
				this.container = container;
				}
			this.xmlhttp.onreadystatechange=function() {
				if (this.readyState==4 && this.status==200)
				{//alert(1);
				
				this.container.innerHTML=this.responseText;
				//alert(this.responseText);
				}
			}
			this.xmlhttp.SetContainer(this.container);
			this.xmlhttp.open(method,this.request,true);
			this.xmlhttp.send();
		}
	this.Paint();
	}