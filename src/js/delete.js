console.log("loading delete.js");


// haven't played with promises or fetch much

document.addEventListener("DOMContentLoaded", bind_delete);

function bind_delete() {
	document.querySelectorAll("a.delete").forEach(function (el) {
		el.addEventListener('click', function(evt) {

			try {
				/* from before phar
				let url = new URL(el.href);
				let file = url.searchParams.get("file");
				*/
				let file = el.href.split('/').reverse()[0];


				if (confirm(`Are you sure you want to delete '${file}'?`)) {

					fetch(el.href)
						.then( function(result) {
							reload_table();
						})
						.catch(function (error) {
							console.error(error);
							alert("Delete failed!  Check browser log!");
						});
				}


			} catch(e) {
				console.error(e);
				alert("Something bad happened.  Check browser log.");
			}

			evt.preventDefault();
			


		});
	});
}
