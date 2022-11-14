
$(document).ready(function() {
	$('#ptable').DataTable({
        "oLanguage": {
            "sSearch": "Keresés:",
        },
        "language": {
            "lengthMenu":     "_MENU_ találat / oldal ",
            "paginate": {
                "first":      "Első",
                "last":       "Utolsó",
                "next":       "Következő",
                "previous":   "Előző"
            },
            "info": "Mutatva _START_ - _END_-ig a _TOTAL_ találatból",
        }
    })
    //  function getElementByXpath(path) {
	//  	return document.evaluate(path, document, null, XPathResult.FIRST_ORDERED_NODE_TYPE, null).singleNodeValue;
	// }
	// getElementByXpath('//*[@id="ptable_filter"]/label/text()') = " találat/oldal";
    //document.querySelector("#ptable_paginate > ul").classList.add("bg-black text-white");
    //document.getElementsByClassName('paginate_button').classList.add("bg-black");
    //document.querySelector("#ptable_filter > label").textContent="Keresés";
});
