<div class="modal-content">
              <!-- Modal Header -->
              <div class="modal-header">
                <h5 class="modal-title">Student Form</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>

              <!-- Modal Body with Form -->
              <form class="row g-3" action="{{url('/form-Data')}}" method="post" id="formdata"> @csrf
                <div class="modal-body">
                <div class="alert alert-success" id="stdData" style='display:none'></div>
                  <div class="col-12">
                    <label for="inputName" class="form-label">Student Name</label>
                    <input type="text" class="form-control" id="inputName" name="name">
                    <div class="text-danger" id="error_name"></div>
                  </div>

                  <div class="col-12">
                    <label for="inputEmail" class="form-label">Email</label>
                    <input type="email" class="form-control" id="inputEmail" name="email">
                    <div class="text-danger" id="error_email"></div>
                  </div>

                  <div class="col-12">
                    <label for="inputPhone" class="form-label">Phone</label>
                    <input type="number" class="form-control" id="inputPhone" placeholder="Phone no here..." name="phone">
                    <div class="text-danger" id="error_phone"></div>
                  </div>
                    <div class="col-12">
                    <label for="inputPhone" class="form-label">Aadhaar no</label>
                    <input type="number" class="form-control" id="inputPhone" placeholder="aadhaar no here..." name="aadhaar">
                    <div class="text-danger" id="error_aadhaar"></div>
                  </div>
                  <div class="col-12">
                    <label for="inputAddress" class="form-label">Address</label>
                    <input type="text" class="form-control" id="inputAddress" placeholder="Address here..." name="address">
                    <div class="text-danger" id="error_address"></div>
                  </div>
                </div>
                <!-- Modal Footer -->
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                  <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
              </form>
            </div>
     <script>
          $(document).ready(function(){
                $("#formdata").submit(function(e){
                  e.preventDefault();
                    var data =  $('#formdata').serialize();
                    var url =  $('#formdata').attr('action');
                    $.ajax({
                        type:'post',
                        url:url,
                        data: data,
                        dataType:'json',
                    success: function(res){
                      // console.log(res);
                        if(res.status){
                            $('#stdData').text(res.message).show();
                            $("#formdata")[0].reset();
                        }
                    },
                  error: function(error){
                      $('.text-danger').hide()
                    // alert(error.responseJSON.errors.email)
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