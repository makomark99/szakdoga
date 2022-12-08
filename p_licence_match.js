
	function playerLicenceMath() {
		pL1 = document.getElementById('pL1');
		pL2 = document.getElementById('pL2');
		pL3 = document.getElementById('pL3');
		result = false;
		if ((pL1.value != "" && pL2.value != "") && (pL1.value === pL2.value)) {
			result = true;
			pL1.setAttribute("style", "background-color:red;color:white;")
			pL1.setAttribute("title", "Az értékek megegyeznek!")
			pL2.setAttribute("style", "background-color:red;color:white;")
			pL2.setAttribute("title", "Az értékek megegyeznek!")
		} else if ((pL1.value != "" && pL3.value != "") && (pL1.value === pL3.value)) {
			result = true;
			pL1.setAttribute("style", "background-color:red;color:white;")
			pL1.setAttribute("title", "Az értékek megegyeznek!")
			pL3.setAttribute("style", "background-color:red;color:white;")
			pL3.setAttribute("title", "Az értékek megegyeznek!")
		} else if ((pL2.value != "" && pL3.value != "") && (pL2.value === pL3.value)) {
			result = true;
			pL2.setAttribute("style", "background-color:red;color:white;")
			pL2.setAttribute("title", "Az értékek megegyeznek!")
			pL3.setAttribute("style", "background-color:red;color:white;")
			pL3.setAttribute("title", "Az értékek megegyeznek!")
		} else {
			result = false;
		}
		if (result) {
			Swal.fire({
				position: "center",
				type: "warning",
				title: "Játékengedélyek megegyeznek!",
				showConfirmButton: false,
				icon: "warning",
				background: "#343a40",
				color: "#fff",
				timer: 3000
			})
			document.getElementById('btn').setAttribute("disabled", "")
		} else {
			document.getElementById('btn').removeAttribute("disabled", "")
			pL1.removeAttribute("style", "border:2px solid red;")
			pL2.removeAttribute("style", "border:2px solid red;")
			pL3.removeAttribute("style", "border:2px solid red;")
			pL1.setAttribute("title", "Az értékek megegyeznek!")
			pL2.setAttribute("title", "Az értékek megegyeznek!")
			pL3.setAttribute("title", "Az értékek megegyeznek!")
		}
	}


