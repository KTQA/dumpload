Dropzone.autoDiscover = false;
console.log("upload.js loaded");

document.addEventListener("DOMContentLoaded", function() {
	let dz = new Dropzone("#upload", { maxFilesize: 0 });
	dz.on("success", function(file) {
		console.log("File Succeeded!", file);
		reload_table();
	});
});


