setTimeout(function () {
    setInterval(function () {
        notification()
    }, 5000)
}, 1000);

function notification() {
    var app_url = $('meta[name="app_url"]').attr('content');

    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        url: app_url + "/notifications/ajax",
        type: "post",
        success: function (data) {
            if (data != "empty") {
                data.forEach(
                    (element) => {
                        toastr.success(element.description, element.title)
                    }
                );
            }
        }
    });

}
