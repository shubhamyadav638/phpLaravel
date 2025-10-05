@extends('layout.admin')

@section('contents')
<main id="main" class="main">
    <div class="pagetitle">
        <h1>Students Data Tables</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                <li class="breadcrumb-item">Students</li>
                <li class="breadcrumb-item active">Student list</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h5 class="card-title mb-0">Student Datatables</h5>
                            <button type="button" class="btn btn-primary ms-auto" onclick="addStudent()">
                                Add student
                            </button>
                        </div>
                        <!-- Table with stripped rows -->
                        <table class="table datatable">
                            <thead>
                                <tr>
                                    <th>S No.</th>
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
                                <?php
                $i = 1;

                ?>
                                @foreach($students as $student)
                                <tr>
                                    <td>{{$i++}}</td>
                                    <td>{{$student->name}}</td>
                                    <td>{{$student->email}}</td>
                                    <td>{{$student->phone}}</td>
                                    <td>{{$student->aadhaar}}</td>
                                    <td>{{$student->address}}</td>
                                    <td>
                                        <a onclick="editStudent({{$student->id}})"
                                            class="btn btn-sm btn-primary">Edit</a>
                                        <a class="btn btn-sm btn-danger"
                                            onclick="deleteStudent({{$student->id}})">Delete</a>
                                    </td>
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

    <div class="modal fade" id="formModel" tabindex="-1">
        <div class="modal-dialog" id="modalHtmlContent">
        </div>
    </div>

</main>

@endsection
@section('script')
<script>
function addStudent() {
    var url = "{{url('add-student-form')}}"
    $.ajax({
        type: 'get',
        url: url,
        dataType: 'html',
        success: function(res) {
            // console.log(res);
            $('#formModel').modal('show');
            $('#modalHtmlContent').html(res);
        },
        error: function(error) {
            alert('error');
        }
    });
}

function editStudent(id) {
    var url = "{{url('edit-student-form')}}/" + id;
    $.ajax({
        type: 'get',
        url: url,
        dataType: 'html',
        success: function(res) {
            // console.log(res);
            $('#formModel').modal('show');
            $('#modalHtmlContent').html(res);
        },
        error: function(error) {
            alert('error');
        }
    });
}

function deleteStudent(id) {
    var url = "{{url('delete-form-Data')}}/" + id;
    $.ajax({
        type: 'get',
        url: url,
        dataType: 'json',
        success: function(res) {
            alert(res.message)
            window.location.reload();
        },
        error: function(error) {
            alert('error', error.errors);
        }
    });
}
</script>
@endsection