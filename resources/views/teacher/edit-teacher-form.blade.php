 <div class="col-sm-12">
           <div class="card">
            <div class="card-body">
              <h5 class="card-title">Edit Teacher Form</h5>
              <!-- Vertical Form -->
              <form class="row g-3" id="updateform" action="{{url('update-teacher-form')}}" method="post">@csrf
                <input type="hidden" name="teacher_id" value="{{$teachers->id}}"/>
                <div class="alert alert-success" id="successData" style='display:none'></div>
                <div class="col-12">
                  <label for="inputNanme4" class="form-label" >Your Name</label>
                  <input type="text" class="form-control" id="inputNanme4" name="name" value="{{$teachers->name}}">
                   <div class="text-danger" id="error_name"></div>
                </div>
                <div class="col-12">
                  <label for="inputEmail4" class="form-label">Email</label>
                  <input type="email" class="form-control" id="inputEmail4" name="email" value="{{$teachers->email}}">
                   <div class="text-danger" id="error_email"></div>
                </div>
                <div class="col-12">
                  <label for="inputphone" class="form-label">Phone</label>
                  <input type="number" class="form-control" id="inputphone"name="phone"value="{{$teachers->phone}}">
                   <div class="text-danger" id="error_phone"></div>
                </div>

                <div class="col-12">
                  <label for="inputAddress" class="form-label">Address</label>
                  <input type="text" class="form-control" id="inputAddress" placeholder="1234 Main St" name="address"value="{{$teachers->address}}">
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
              $("#updateform").submit(function(e){
                e.preventDefault();
                  var data =  $('#updateform').serialize();
                  var url =  $('#updateform').attr('action');
                  $.ajax({
                      type:'post',
                      url:url,
                      data: data,
                      dataType:'json',
                      success: function(res){
                          if(res.status){
                              $('#successData').text(res.message).show();
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