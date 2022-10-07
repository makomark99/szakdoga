let form=document.getElementById('sheetdb-form');
form.addEventListener("submit",e=>{
    e.preventDefault();
    fetch(form.action, {
        method:"POST",
        body: new FormData(document.getElementById('sheetdb-form')),
    }).then(
        response=>response.json()
    ).then((html) => {
        Swal.fire({
            position: "center",
            type: "success",
            title: "A hidegcsomag renelésének adatai sikeresen rögzítésre kerültek!",
            showConfirmButton: false,
            icon: "success",
            background: "#343a40",
            color: "#fff",
            timer: 2000
        })
    });
});