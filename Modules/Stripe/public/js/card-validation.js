$("#card-button").click(function(){
    var card_number = $('#cc-number').val();
    var card_month = $('#cc-month').val();
    var card_year = $('#cc-year').val();
    var card_cvc = $('#cc-cvc').val();

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        url: SITEURL+"/stripe/cards/store",
        type: "POST",
        data: { card_number: card_number, card_month: card_month, card_year: card_year, card_cvc: card_cvc},
        success: function(data) {

            if(data.code == 200){
                // window.location.href = SITEURL+data.url;
            } else {
                $('#stripe_message').html("");
                $('#stripe_message').html(data.message);
            }
        }

    });

  });