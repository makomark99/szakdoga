//how to generate a password in javascript? 

$(document).ready(function() {
	$('#ptable').DataTable({
        "oLanguage": {
            "sSearch": "Keresés:",
        },
        "language": {
            "paginate": {
                "first":      "Első",
                "last":       "Utolsó",
                "next":       "Következő",
                "previous":   "Előző"
            },
            "info": "Mutatva _START_ - _END_-ig a _TOTAL_ találatból",
            "infoFiltered":   "(szűrve _MAX_ találatból)",
            "infoPostFix":    "",
            "zeroRecords": "A keresésnek nincs találata",
            "infoEmpty": "Nincs találat",
            "lengthMenu": '<select class="ps-1">'+
      '<option value="5">5</option>'+
      '<option value="10">10</option>'+
      '<option value="25">25</option>'+
      '<option value="50">50</option>'+
      '<option value="100">100</option>'+
      '<option value="-1">Össz</option>'+
      '</select> találat / oldal '
        }
    })
});

