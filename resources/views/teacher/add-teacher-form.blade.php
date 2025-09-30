 <div class="col-sm-12">
           <div class="card">
            <div class="card-body">
              <h5 class="card-title">Add Teacher Form</h5>
              <!-- Vertical Form -->
              <form class="row g-3" action="{{url('/save-teacher-form')}}" method="post" id="teacherData">@csrf
                <div class="col-12">
                  <div class="alert alert-success" id="successData" style='display:none'></div>
                  <label for="inputNanme4" class="form-label" >Your Name</label>
                  <input type="text" class="form-control" id="inputNanme4" name="name">
                   <div class="text-danger" id="error_name"></div>
                </div>
                <div class="col-12">
                  <label for="inputEmail4" class="form-label">Email</label>
                  <input type="email" class="form-control" id="inputEmail4" name="email">
                  <div class="text-danger" id="error_email"></div>
                </div>
                <div class="col-12">
                  <label for="inputphone" class="form-label">Phone</label>
                  <input type="number" class="form-control" id="inputphone"name="phone">
                  <div class="text-danger" id="error_phone"></div>
                </div>
                <div class="col-12">
                  <label for="inputAddress" class="form-label">Address</label>
                  <input type="text" class="form-control" id="inputAddress" placeholder="1234 Main St" name="address">
                  <div class="text-danger" id="error_address"></div>
                </div>
                <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                      <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
              </form><!-- Vertical Form -->
            </div>
          </div>
 </div>

  <script>
          $(document).ready(function(){
                $("#teacherData").submit(function(e){
                  e.preventDefault();
                    var data =  $('#teacherData').serialize();// form ke sare fields ko query string me badalta hai
                    var url =  $('#teacherData').attr('action');// form ke action attribute se URL leta hai
                    $.ajax({
                        type:'post',
                        url:url,
                        data: data, // bhejne wala data (serialize kiya hua  form)
                        dataType:'json',// server se JSON format me response expect kar rahe hai
                    success: function(res){
                      if(res.status){
                        $('#successData').text(res.message).show();
                        $("#teacherData")[0].reset();
                      }
                    },
                  error: function(error){
                      $('.text-danger').hide()
                      var errors = error.responseJSON.errors;
                      $.each(errors,function(key,val){
                          $('#error_'+key).text(val[0]).show();
                      });
                    }
                      });
                      return false;
                  });
                  });
      </script>