jQuery(function($) {

    $('#searchItem').on("keyup", function () {
        var searchTerm = $(this).val().toLowerCase().substr(0, 2); 
        console.log(searchTerm);
        $(".card-box h2").filter(function () {
            var cardText = $(this).text().toLowerCase().substr(0, 2);
            $(this).closest('.card-box').toggle(cardText.indexOf(searchTerm) > -1);
        });
    });
            // $('#searchItem').on("keyup", function () {
            //   var searchTerm = $(this).val().toLowerCase();
            //   console.log(searchTerm);
            //   $(".card-box h2 ").filter(function() {
            //     $('.card-box ').toggle($('.card-box ').text().toLowerCase().indexOf(searchTerm) > -1)
            //   });
            // });
            
    });
    


