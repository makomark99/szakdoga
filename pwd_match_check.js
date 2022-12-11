function pwdMatchCheck() {
	let pwd1 = document.getElementById('Pass');
	let pwd2 = document.getElementById('PassR');
	result = false;
	if (pwd1.value != pwd2.value ) {
		result = true;
		pwd1.setAttribute("style", "background-color:red;color:white;")
		pwd1.setAttribute("title", "Az értékek megegyeznek!")
		pwd2.setAttribute("style", "background-color:red;color:white;")
		pwd2.setAttribute("title", "Az értékek megegyeznek!")
	} else {
		result = false;
	}
	if (result) {
		// Swal.fire({
		// 	position: "center",
		// 	type: "warning",
		// 	title: "A két jelszó nem azonos!",
		// 	showConfirmButton: false,
		// 	icon: "warning",
		// 	background: "#343a40",
		// 	color: "#fff",
		// 	timer: 3000
		// })
		document.getElementById('btn').setAttribute("disabled", "")
	} else {
		document.getElementById('btn').removeAttribute("disabled", "")
		pwd1.removeAttribute("style", "border:2px solid red;")
		pwd2.removeAttribute("style", "border:2px solid red;")
		pwd1.removeAttribute("title", "Az értékek megegyeznek!")
		pwd2.removeAttribute("title", "Az értékek megegyeznek!")
	}
}


