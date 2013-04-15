$(document).ready(function() {
    // prob was argument to the function is an associative array?!?
    // var associativeArray = {}; // associativeArray["one"] = "First";                   
    // var data = "manual annotation, alignment, aaaa, bbbb, ccccc, dddddd".split(",");
    $("#species-filler").autocomplete({source:data}); 
    $("#edit-desc").autocomplete({source:data});
    $("#suggest").autocomplete({source:data});    
    $('#tabs').tabs();
    $('#sortable').sortable({items: 'li'});
    $('.accordion').accordion({
        autoHeight: false,
        clearStyle: true,
        header: 'h3'
    });
});
