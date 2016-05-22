// AJAX VARIABLES
var content = "content", // ID
	projectName = "moreno",
	NameCharCount = projectName.length + 2, // count characters in project name + 2; for body id
	navAnchor = "nav a, footer a",
 	home = "http://" + window.location.hostname, // localhost

	ignore_string = new String('#, /wp-, .pdf, .zip, .rar'),
 	ignore = ignore_string.split(', ').
	reloadDocumentReady = false,
	isLoad = false,
	started = false
	searchPath = null,
	ua = $.browser;


// POPSTATE
function titleAfterPopState() {
	var ID = window.location.pathname.slice(NameCharCount,-1);
	$("body").attr("id", ID);
}



$(function() { loadPageInit(""); });


window.onpopstate = function(event) {

	$("#" + content).removeClass("in-bottom").addClass("out-fade");
	titleAfterPopState();


	//admin panel
	if (started === true && check_ignore(document.location.toString()) == true) {
		loadPage(document.location.toString(),1);

	}
};


function loadPageInit(scope){
	$(navAnchor).click(function(event){


		//if not admin url or no #
		if (this.href.indexOf(home) >= 0 && check_ignore(this.href) == true){

			event.preventDefault();
			this.blur();

			var caption = this.title || this.name || "";
			var group = this.rel || false;

			//click code here

			$("#" + content).removeClass("in-bottom").addClass("out-fade");


			loadPage(this.href);

		}
	});
}

function loadPage(url, push, getData){

	if (!isLoad){

		// onpopstate
		started = true;

		//AJAX update URL
		nohttp = url.replace("http://","").replace("https://","");
		firstsla = nohttp.indexOf("/");
		pathpos = url.indexOf(nohttp);
		path = url.substring(pathpos + firstsla);

		//Only do history state if clicked on page.
		if (push != 1) {
			if (typeof window.history.pushState == "function") {
				var stateObj = { foo: 1000 + Math.random()*1001 };
				history.pushState(stateObj, "AJAX page loaded.", path);
			} else {
				if (warnings == true) {
					alert("BROWSER COMPATIBILITY: \n'pushState' method not supported in this browser! Please update.");
				}
			}
		}


		setTimeout(function() {

			$('#' + content).queue( function() {
				$.ajax({
					type: "GET",
					url: url,
					data: getData, // for Analytics
					cache: true,
					dataType: "html",
					success: function(data) {

						//$('html,body').animate({scrollTop: 0}, 0);

						$("#" + content).removeClass("out-fade").addClass("in-bottom");

						setTimeout(function() {
								ajax_functions();

						}, 0);


						//get title attribute
						datax = data.split('<title>');
						titlesx = data.split('</title>');

						if (datax.length == 2 || titlesx.length == 2) {
							data = data.split('<title>')[1];
							titles = data.split('</title>')[0];

							//set title
							$(document).attr('title', ($("<div/>").html(titles).text()));
						}

						//GOOGLE ANALYTICS
							if(typeof _gaq != "undefined") {
								if (typeof getData == "undefined") {
									getData = "";
								} else {
									getData = "?" + getData;
								}
								_gaq.push(['_trackPageview', path + getData]);
							}


						//GET PAGE CONTENT
						data = data.split('id="' + content + '"')[1];
						data = data.substring(data.indexOf('>') + 1);
						var depth = 1;
						var output = '';

						while(depth > 0) {
							temp = data.split('</div>')[0];

							//count occurrences
							i = 0;
							pos = temp.indexOf("<div");
							while (pos != -1) {
								i++;
								pos = temp.indexOf("<div", pos + 1);
							}
							//end count
							depth=depth+i-1;
							output=output+data.split('</div>')[0] + '</div>';
							data = data.substring(data.indexOf('</div>') + 6);
						}

						document.getElementById(content).innerHTML = output;


						if (reloadDocumentReady == true) {
							$(document).trigger("ready");
						}


					},

				});

			}).dequeue();

		}, 500);
	}
}

function check_ignore(url) {
	for (var i in ignore) {
		if (url.indexOf(ignore[i]) >= 0) {
			return false;
		}
	}


	return true;
}
