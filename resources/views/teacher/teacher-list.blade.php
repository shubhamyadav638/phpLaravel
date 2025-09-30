 @extends('layout.admin')
 @section('contents')
 <main id="main" class="main">
    <div class="pagetitle">
      <div class="d-flex justify-content-between align-items-center mb-3">
        <h1>Teachers Data Tables</h1>
          <button type="button" class="btn btn-primary" onclick="addTeacher()">
          Add teacher
          </button>
      </div>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="index.html">Home</a></li>
          <li class="breadcrumb-item">Teachers</li>
          <li class="breadcrumb-item active">Teacher list</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

    <section class="section">
      <div class="row">
        <div class="col-lg-12">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Teacher list</h5>
              <!-- Table with stripped rows -->
              <table class="table datatable">
                <thead>
                  <tr>
                    <th>
                      <b>S</b>No
                    </th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Address</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $no=1;
                  ?>
                  @foreach($teachers as $teacher)
                  <tr>
                    <td>{{$no++}}</td>
                    <td>{{$teacher->name}}</td>
                    <td>{{$teacher->email}}</td>
                    <td>{{$teacher->phone}}</td>
                    <td>{{$teacher->address}}</td>
                    <td>
                    <a onclick="editTeacher({{$teacher->id}})"class="btn btn-sm btn-primary">edit</a>
                    <a href="" class="btn btn-sm btn-danger" onclick="deleteTeacher({{$teacher->id}})">delete</a>
                    </td>
                  </tr>
                  @endforeach
                </tbody>
              </table>
              <!-- End Table with stripped rows -->
{{-- {{ $teachers->links() }} //pagination ke liye --}}
            </div>
          </div>

        </div>
      </div>
    </section>
  </main>

   <main id="main" class="main" >

    <div class="pagetitle">
    <section class="section">
      <div class="row">
        <div class="col-lg-12">
          <div class="card">
            <div class="card-body">
              <!-- Large Modal -->
              <div class="modal fade" id="mainbodymodel" tabindex="-1">
                <div class="modal-dialog modal-lg">

                  <div class="modal-content">
                    <div class="modal-header">
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body" id="modalHtmlContent">
                    </div>
                  </div>

                </div>
              </div><!-- End Large Modal-->

            </div>
          </div>

        </div>
      </div>
    </section>

  </main>

    </script>
  @endsection

@section('script')
  <script>
      function addTeacher(){
              var url = "{{url('/add-teacher-form')}}"
              $.ajax({
                type:'get',
                url:url,
                dataType:'html',
                success: function(res){
                  // console.log(res);
                  $('#mainbodymodel').modal('show'); // ye  id main modle ki hogi  or btn pr data-bs-toggle="modal" data-bs-target="#basicModal" ye dono hata ke onclick laga denge
                  $('#modalHtmlContent').html(res); // ye model ki body ki hogi
                },
                error: function(error){
                    alert('error');
                }
            });
          }

          function editTeacher(id){
              var url = "{{url('edit-teacher-form')}}/"+id;
              $.ajax({
                type:'get',
                url:url,
                dataType:'html',
                success: function(res){
                  // console.log(res);
                  $('#mainbodymodel').modal('show'); // ye  id main modle ki hogi  or btn pr data-bs-toggle="modal" data-bs-target="#basicModal" ye dono hata ke onclick laga denge
                  $('#modalHtmlContent').html(res); // ye model ki body ki hogi
                },
                error: function(error){
                    alert('error');
                }
            });
          }

          function deleteTeacher(id){
        var url = "{{url('delete-teacher-Data')}}/"+id;
        $.ajax({
          type:'get',
          url:url,
          dataType:'json',
          success: function(res){
            alert(res.message)
           window.location.reload();
          },
          error: function(error){
              alert('error',error.errors);
          }
      });
    }

  </script>
@endsection