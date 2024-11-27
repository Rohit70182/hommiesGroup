
var message_html =' <label>Select Category</label><select name="category_id" id="category_id" class="form-control"><option>Choose</option>';
$(document).ready(function(){
    $("#service_id").change(function(){
        var html = ''
      var id =$('#service_id').val();
      $.ajaxSetup({
                   headers: {
                             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            }
                        });
      $.ajax({
                  url: SITEURL+'/booking/get_category/'+id,
                  type: "post",
                  data: {id:id},
                  cache: false,
                  success: function (data) {
                      if(data){
                        if(data != null){
                            data.forEach(function(val,key) {
                                html +='<option value="'+val.category_id+'">'+val.name+'</option>' ;
                              });
                              var html_end = '</select>';
                              var result = message_html + html +html_end;
                              $('#category').html(result);
                          
                        }
                      }
                  },
                  error: function (xhr, ajaxOptions, thrownError) {
                     
                  }
              });
    });
  });


  var message_html_sub =' <label>Select Sub Category</label><select name="subcategory_id" id="sub_category_id" class="form-control"><option>Choose</option>';

  $(document).ready(function(){
    $("#service_id").change(function(){
        var html_sub = ''
      var id =$('#service_id').val();
      $.ajaxSetup({
                   headers: {
                             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            }
                        });
      $.ajax({
                  url: SITEURL+'/booking/get_subcategory/'+id,
                  type: "post",
                  data: {id:id},
                  cache: false,
                  success: function (data) {
                      if(data){
                        if(data != null){
                            data.forEach(function(val,key) {
                                html_sub +='<option value="'+val.sub_category_id+'">'+val.name+'</option>' ;
                              });
                              var html_end_sub = '</select>';
                              var result = message_html_sub + html_sub +html_end_sub;
                              $('#subcategory').html(result);
                          
                        }
                      }
              
                  },
                  error: function (xhr, ajaxOptions, thrownError) {
                     
                  }
              });
    });
  });
  
