var startList = function() {
	
	if (document.all&&document.getElementById) {
		
		navRoot = document.getElementById("nav");
		
		for (i=0; i<navRoot.childNodes.length; i++) {
			
			node = navRoot.childNodes[i];
			
			if (node.nodeName=="LI") {
				
				node.onmouseover=function() {
					
					this.className+=" hover";
					
				}
				
				node.onmouseout=function() {
					
					elem = this;
					
					elem.className=elem.className.replace(" hover", "");
					
				}
				
			}
			
		}
		
	}
	
}

startList();