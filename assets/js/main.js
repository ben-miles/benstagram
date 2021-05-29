/**
* Template Name: Lumia - v4.1.0
* Template URL: https://bootstrapmade.com/lumia-bootstrap-business-template/
* Author: BootstrapMade.com
* License: https://bootstrapmade.com/license/
*/
(function() {
  "use strict";

  /**
   * Easy selector helper function
   */
  const select = (el, all = false) => {
    el = el.trim()
    if (all) {
      return [...document.querySelectorAll(el)]
    } else {
      return document.querySelector(el)
    }
  }

  /**
   * Easy event listener function
   */
  const on = (type, el, listener, all = false) => {
    let selectEl = select(el, all)
    if (selectEl) {
      if (all) {
        selectEl.forEach(e => e.addEventListener(type, listener))
      } else {
        selectEl.addEventListener(type, listener)
      }
    }
  }

  /**
   * Easy on scroll event listener 
   */
  const onscroll = (el, listener) => {
    el.addEventListener('scroll', listener)
  }

  /**
   * Navbar links active state on scroll
   */
  let navbarlinks = select('#navbar .scrollto', true)
  const navbarlinksActive = () => {
    let position = window.scrollY + 200
    navbarlinks.forEach(navbarlink => {
      if (!navbarlink.hash) return
      let section = select(navbarlink.hash)
      if (!section) return
      if (position >= section.offsetTop && position <= (section.offsetTop + section.offsetHeight)) {
        navbarlink.classList.add('active')
      } else {
        navbarlink.classList.remove('active')
      }
    })
  }
  window.addEventListener('load', navbarlinksActive)
  onscroll(document, navbarlinksActive)

  /**
   * Scrolls to an element with header offset
   */
  const scrollto = (el) => {
    let header = select('#header')
    let offset = header.offsetHeight

    let elementPos = select(el).offsetTop
    window.scrollTo({
      top: elementPos - offset,
      behavior: 'smooth'
    })
  }

  /**
   * Toggle .header-scrolled class to #header when page is scrolled
   */
  let selectHeader = select('#header')
  if (selectHeader) {
    const headerScrolled = () => {
      if (window.scrollY > 100) {
        selectHeader.classList.add('header-scrolled')
      } else {
        selectHeader.classList.remove('header-scrolled')
      }
    }
    window.addEventListener('load', headerScrolled)
    onscroll(document, headerScrolled)
  }

  /**
   * Back to top button
   */
  let backtotop = select('.back-to-top')
  if (backtotop) {
    const toggleBacktotop = () => {
      if (window.scrollY > 100) {
        backtotop.classList.add('active')
      } else {
        backtotop.classList.remove('active')
      }
    }
    window.addEventListener('load', toggleBacktotop)
    onscroll(document, toggleBacktotop)
  }

  /**
   * Mobile nav toggle
   */
  on('click', '.mobile-nav-toggle', function(e) {
    select('#navbar').classList.toggle('navbar-mobile')
    this.classList.toggle('bi-list')
    this.classList.toggle('bi-x')
  })

  /**
   * Mobile nav dropdowns activate
   */
  on('click', '.navbar .dropdown > a', function(e) {
    if (select('#navbar').classList.contains('navbar-mobile')) {
      e.preventDefault()
      this.nextElementSibling.classList.toggle('dropdown-active')
    }
  }, true)

  /**
   * Scrool with ofset on links with a class name .scrollto
   */
  on('click', '.scrollto', function(e) {
    if (select(this.hash)) {
      e.preventDefault()

      let navbar = select('#navbar')
      if (navbar.classList.contains('navbar-mobile')) {
        navbar.classList.remove('navbar-mobile')
        let navbarToggle = select('.mobile-nav-toggle')
        navbarToggle.classList.toggle('bi-list')
        navbarToggle.classList.toggle('bi-x')
      }
      scrollto(this.hash)
    }
  }, true)

  /**
   * Scroll with ofset on page load with hash links in the url
   */
  window.addEventListener('load', () => {
    if (window.location.hash) {
      if (select(window.location.hash)) {
        scrollto(window.location.hash)
      }
    }
  });

  /**
   * Porfolio isotope and filter
   */
  window.addEventListener('load', () => {
    let portfolioContainer = select('.portfolio-container');
    if (portfolioContainer) {
      let portfolioIsotope = new Isotope(portfolioContainer, {
        itemSelector: '.portfolio-item',
        layoutMode: 'fitRows'
      });

      let portfolioFilters = select('#portfolio-flters li', true);

      on('click', '#portfolio-flters li', function(e) {
        e.preventDefault();
        portfolioFilters.forEach(function(el) {
          el.classList.remove('filter-active');
        });
        this.classList.add('filter-active');

        portfolioIsotope.arrange({
          filter: this.getAttribute('data-filter')
        });
      }, true);
    }

  });

  /**
   * Initiate portfolio lightbox 
   */
  const portfolioLightbox = GLightbox({
    selector: '.portfolio-lightbox'
  });

  // Initialize AJAX Form Submit
  var ajaxForm = document.getElementsByClassName("ajax-form");
  if(ajaxForm.length){
	  ajaxForm[0].addEventListener('submit', function(e) {
		  e.preventDefault();
		  AJAXSubmit(this); 
		  return false;
	  });
  };

/*\
|*|
|*|  :: XMLHttpRequest.prototype.sendAsBinary() Polyfill ::
|*|
|*|  https://developer.mozilla.org/en-US/docs/DOM/XMLHttpRequest#sendAsBinary()
\*/

if (!XMLHttpRequest.prototype.sendAsBinary) {
	XMLHttpRequest.prototype.sendAsBinary = function(sData) {
	  var nBytes = sData.length, ui8Data = new Uint8Array(nBytes);
	  for (var nIdx = 0; nIdx < nBytes; nIdx++) {
		ui8Data[nIdx] = sData.charCodeAt(nIdx) & 0xff;
	  }
	  /* send as ArrayBufferView...: */
	  this.send(ui8Data);
	  /* ...or as ArrayBuffer (legacy)...: this.send(ui8Data.buffer); */
	};
  }
  
  /*\
  |*|
  |*|  :: AJAX Form Submit Framework ::
  |*|
  |*|  https://developer.mozilla.org/en-US/docs/DOM/XMLHttpRequest/Using_XMLHttpRequest
  |*|
  |*|  This framework is released under the GNU Public License, version 3 or later.
  |*|  https://www.gnu.org/licenses/gpl-3.0-standalone.html
  |*|
  |*|  Syntax:
  |*|
  |*|   AJAXSubmit(HTMLFormElement);
  \*/
  
  var AJAXSubmit = (function () {
  		var responseContainer = document.getElementById("response-container");
		
	function ajaxSuccess () {
		// Clear any previous responses from frontend
		responseContainer.innerHTML = "";
	  /* console.log("AJAXSubmit - Success!"); */
	//   console.log(this.responseText);
	// Get response (|status|message|action|parameters)
	var response = this.responseText;
	console.log(response); // for debugging
	var status, message, action, parameters;
	// Explode properly formatted response on pipe character
	var response_parts = response.split("|");
	status = response_parts[1];
	message = response_parts[2];
	action = response_parts[3];
	parameters = response_parts[4];
	// Treat any improperly formatted response as an error
	if(response.charAt(0) != "|"){
		status = "danger";
		message = "Error: Unexpected response: " + response;
	}
	// Build formatted response
	var formattedResponse = document.createElement("div");
	formattedResponse.className = "alert alert-" + status;
	formattedResponse.innerHTML = message;
	// Send formatted response back to frontend
	responseContainer.appendChild(formattedResponse);
	// Perform any additional actions, if applicable
	if(action == "redirect"){
		setTimeout(function(){
			window.location.replace(parameters)
		}, 
		3000);
	}
	  /* you can get the serialized data through the "submittedData" custom property: */
	  /* console.log(JSON.stringify(this.submittedData)); */
	}
  
	function submitData (oData) {
	  /* the AJAX request... */
	  var oAjaxReq = new XMLHttpRequest();
	  oAjaxReq.submittedData = oData;
	  oAjaxReq.onload = ajaxSuccess;
	  if (oData.technique === 0) {
		/* method is GET */
		oAjaxReq.open("get", oData.receiver.replace(/(?:\?.*)?$/,
			oData.segments.length > 0 ? "?" + oData.segments.join("&") : ""), true);
		oAjaxReq.send(null);
	  } else {
		/* method is POST */
		oAjaxReq.open("post", oData.receiver, true);
		if (oData.technique === 3) {
		  /* enctype is multipart/form-data */
		  var sBoundary = "---------------------------" + Date.now().toString(16);
		  oAjaxReq.setRequestHeader("Content-Type", "multipart\/form-data; boundary=" + sBoundary);
		  oAjaxReq.sendAsBinary("--" + sBoundary + "\r\n" +
			  oData.segments.join("--" + sBoundary + "\r\n") + "--" + sBoundary + "--\r\n");
		} else {
		  /* enctype is application/x-www-form-urlencoded or text/plain */
		  oAjaxReq.setRequestHeader("Content-Type", oData.contentType);
		  oAjaxReq.send(oData.segments.join(oData.technique === 2 ? "\r\n" : "&"));
		}
	  }
	}
  
	function processStatus (oData) {
	  if (oData.status > 0) { return; }
	  /* the form is now totally serialized! do something before sending it to the server... */
	  /* doSomething(oData); */
	  /* console.log("AJAXSubmit - The form is now serialized. Submitting..."); */
	  submitData (oData);
	}
  
	function pushSegment (oFREvt) {
	  this.owner.segments[this.segmentIdx] += oFREvt.target.result + "\r\n";
	  this.owner.status--;
	  processStatus(this.owner);
	}
  
	function plainEscape (sText) {
	  /* How should I treat a text/plain form encoding?
		 What characters are not allowed? this is what I suppose...: */
	  /* "4\3\7 - Einstein said E=mc2" ----> "4\\3\\7\ -\ Einstein\ said\ E\=mc2" */
	  return sText.replace(/[\s\=\\]/g, "\\$&");
	}
  
	function SubmitRequest (oTarget) {
	  var nFile, sFieldType, oField, oSegmReq, oFile, bIsPost = oTarget.method.toLowerCase() === "post";
	  /* console.log("AJAXSubmit - Serializing form..."); */
	  this.contentType = bIsPost && oTarget.enctype ? oTarget.enctype : "application\/x-www-form-urlencoded";
	  this.technique = bIsPost ?
		  this.contentType === "multipart\/form-data" ? 3 : this.contentType === "text\/plain" ? 2 : 1 : 0;
	  this.receiver = oTarget.action;
	  this.status = 0;
	  this.segments = [];
	  var fFilter = this.technique === 2 ? plainEscape : escape;
	  for (var nItem = 0; nItem < oTarget.elements.length; nItem++) {
		oField = oTarget.elements[nItem];
		if (!oField.hasAttribute("name")) { continue; }
		sFieldType = oField.nodeName.toUpperCase() === "INPUT" ? oField.getAttribute("type").toUpperCase() : "TEXT";
		if (sFieldType === "FILE" && oField.files.length > 0) {
		  if (this.technique === 3) {
			/* enctype is multipart/form-data */
			for (nFile = 0; nFile < oField.files.length; nFile++) {
			  oFile = oField.files[nFile];
			  oSegmReq = new FileReader();
			  /* (custom properties:) */
			  oSegmReq.segmentIdx = this.segments.length;
			  oSegmReq.owner = this;
			  /* (end of custom properties) */
			  oSegmReq.onload = pushSegment;
			  this.segments.push("Content-Disposition: form-data; name=\"" +
				  oField.name + "\"; filename=\"" + oFile.name +
				  "\"\r\nContent-Type: " + oFile.type + "\r\n\r\n");
			  this.status++;
			  oSegmReq.readAsBinaryString(oFile);
			}
		  } else {
			/* enctype is application/x-www-form-urlencoded or text/plain or
			   method is GET: files will not be sent! */
			for (nFile = 0; nFile < oField.files.length;
				this.segments.push(fFilter(oField.name) + "=" + fFilter(oField.files[nFile++].name)));
		  }
		} else if ((sFieldType !== "RADIO" && sFieldType !== "CHECKBOX") || oField.checked) {
		  /* NOTE: this will submit _all_ submit buttons. Detecting the correct one is non-trivial. */
		  /* field type is not FILE or is FILE but is empty */
		  this.segments.push(
			this.technique === 3 ? /* enctype is multipart/form-data */
			  "Content-Disposition: form-data; name=\"" + oField.name + "\"\r\n\r\n" + oField.value + "\r\n"
			: /* enctype is application/x-www-form-urlencoded or text/plain or method is GET */
			  fFilter(oField.name) + "=" + fFilter(oField.value)
		  );
		}
	  }
	  processStatus(this);
	}
  
	return function (oFormElement) {
	  if (!oFormElement.action) { return; }
	  new SubmitRequest(oFormElement);
	};
  
  })();

    /**
   * AJAX Form Submit 
   * My original AJAX form submission script, outmoded by the above
   */
	//  window.ajaxFormSubmit = function(route){
	// 	var elements = document.getElementsByClassName("form-control");
	// 	var responseContainer = document.getElementById("response-container");
	// 	// Clear any previous responses from frontend
	// 	responseContainer.innerHTML = "";
	// 	var formData = new FormData(); 
	// 	for(var i=0; i<elements.length; i++){
	// 		if(elements[i].type == "file"){
	// 			// console.log(elements[i].files);
	// 			formData.append("file", elements[i].files);
	// 			for (var j=0; j<elements[i].files.length; ++j) {
	// 				formData.append("files[]", elements[i].files[j].name);
	// 				// alert("file name: " + name);
	// 			  }
	// 		} else {
	// 			formData.append(elements[i].name, elements[i].value);
	// 		}
	// 	}
	// 	var xmlHttp = new XMLHttpRequest();
	// 		xmlHttp.onreadystatechange = function(){
	// 			if(xmlHttp.readyState == 4 && xmlHttp.status == 200){
	// 				// Get response (|status|message|action|parameters)
	// 				var response = xmlHttp.responseText;
	// 				console.log(response); // for debugging
	// 				var status, message, action, parameters;
	// 				// Explode properly formatted response on pipe character
	// 				var response_parts = response.split("|");
	// 				status = response_parts[1];
	// 				message = response_parts[2];
	// 				action = response_parts[3];
	// 				parameters = response_parts[4];
	// 				// Treat any improperly formatted response as an error
	// 				if(response.charAt(0) != "|"){
	// 					status = "danger";
	// 					message = "Error: Unexpected response: " + response;
	// 				}
	// 				// Build formatted response
	// 				var formattedResponse = document.createElement("div");
	// 				formattedResponse.className = "alert alert-" + status;
	// 				formattedResponse.innerHTML = message;
	// 				// Send formatted response back to frontend
	// 				responseContainer.appendChild(formattedResponse);
	// 				// Perform any additional actions, if applicable
	// 				if(action == "redirect"){
	// 					setTimeout(function(){
	// 						window.location.replace(parameters)
	// 					}, 
	// 					3000);
	// 				}
	// 			}
	// 		}
	// 		xmlHttp.open("post", route); 
	// 		xmlHttp.send(formData); 
	// }

})()