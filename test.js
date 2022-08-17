function reset() {
    document.getElementById('name').value = "";
    document.getElementById('d1').value = "";
    document.getElementById('d2').value = "";
    infos=document.querySelectorAll('.info');
    console.log(infos);
    infos[0].outerText="";
}