jQuery(document).ready(function($){


    $(".mnutog").click(function(){
        $("body").addClass("nav-active");
    });
    $(".mnucls, .sidebaroverly").click(function(){
        $("body").removeClass("nav-active");
    });

    new DataTable('.dataTable',{
        scrollX: true,
    });
    new DataTable('.dataTableNoSearch', {
        paging: false,
        searching: false,
        lengthChange: false,
        scrollX: true,
    });

    $('.SelectJquery').select2();

    

});



