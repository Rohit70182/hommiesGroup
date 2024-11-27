var message_html = ' <label>Select Sub Category</label><select name="subcategory_id" id="subcategory_id" class="form-control"><option selected disabled>Choose</option>';

$(document).ready(function () {
  $("#category_id").change(function () {
    var html = ''
    var id = $('#category_id').val();
    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });
    $.ajax({
      url: SITEURL + '/services/get_category/' + id,
      type: "post",
      data: { id: id },
      cache: false,
      success: function (data) {
        if (data) {
          if (data != null) {
            data.forEach(function (val, key) {
              html += '<option value="' + val.id + '">' + val.name + '</option>';
            });
            var html_end = '</select>';
            var result = message_html + html + html_end;
            $('#subcategory_id').html(result);

          }
        }
      },
      error: function (xhr, ajaxOptions, thrownError) {

      }
    });
  });
});




