
console.log("loading dumpload.js");
var age_threshold = null;
var script_name = null;

document.addEventListener("DOMContentLoaded", function() { 

	script_name = document.getElementById('_sn').value;

	if (document.getElementById('age')) {
		age_threshold = document.getElementById('age').value * 86400;
		console.log('setting age threshold seconds', age_threshold);
	}
	
	setInterval(update_times, 15000);
	update_times();


});


function update_times() {
	let elements = document.querySelectorAll(".time");
	let now = Math.floor(Date.now() / 1000);
	for (i in elements) {

		try {
			let stamp = elements[i].getAttribute("rawtime");

			if (stamp != undefined) {
				let diff = Math.floor(Date.now() / 1000) - stamp;
				elements[i].innerHTML = human_time(diff);


				if (age_threshold != null && diff > age_threshold) {
					elements[i].style.color = '#ff0000';
				}



			}
		} catch {
			break;
		}

	}

	function human_time(raw) {

		let scale = {
			"y": 31536000,
			"mo": 2592000,
			"d": 86400,
			"h": 3600,
			"m": 60
		}

		let txt = [];
		let count, mod;

		for (unit in scale) {
			count = Math.floor(raw / scale[unit]);

			if (count > 0) {
				txt.push(`${count}${unit}`);
				raw = Math.floor(raw % scale[unit]);
			}
		}

		if (raw > 0) txt.push(`${Math.floor(raw)}s`);
		return txt.slice(0, 2).join(' ') + ' ago';


	}
	

}


async function reload_table() {

	let query = await fetch(`${script_name}/table`);
	let text = await query.text();

	document.getElementById('list').innerHTML = text;
	if (typeof bind_delete == 'function' ) bind_delete();
	update_times();

}


