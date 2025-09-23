@extends('layout.admin')

@section('contents')
  <main id="main" class="main">

    <div class="pagetitle">
      <h1>Data Tables</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="index.html">Home</a></li>
          <li class="breadcrumb-item">Tables</li>
          <li class="breadcrumb-item active">Data</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

    <section class="section">
      <div class="row">
        <div class="col-lg-12">

          <div class="card">
            <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-3">
            <h5 class="card-title mb-0">Datatables</h5>
            
            <button type="button" class="btn btn-primary ms-auto" data-bs-toggle="modal" data-bs-target="#scrollingModal">
                Add student
            </button>
            </div>

              <!-- Table with stripped rows -->
              <table class="table datatable">
                <thead>
                  <tr>
                    <th>
                      <b>N</b>ame
                    </th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Aadhaar</th>
                    <th>Address</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach($students as $student)
                  <tr>
                    <td>{{$student->name}}</td>
                    <td>{{$student->email}}</td>
                    <td>{{$student->phone}}</td>
                    <td>{{$student->aadhaar}}</td>
                    <td>{{$student->address}}</td>
                    <td>edit/delete</td>
                  </tr>
                  @endforeach
                </tbody>
              </table>
              <!-- End Table with stripped rows -->

            </div>
          </div>

        </div>
      </div>
    </section>

      <div class="modal fade" id="scrollingModal" tabindex="-1">
          <div class="modal-dialog">
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
          </div>
</div>

  </main>

  @endsection

  @section('script')
  <script>
$(document).ready(function(){

$("#formdata").submit(function(e){
   e.preventDefault();
    var data =  $('#formdata').serialize();
    var url =  $('#formdata').attr('action');
        // Clear old errors
        $('.text-danger').text('');
        $('.alert-success').hide();
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
            alert('error');
        }
    });
    return false;
});
});

  </script>
  @endsection