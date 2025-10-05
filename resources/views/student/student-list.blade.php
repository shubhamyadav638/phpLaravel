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

                        <table class="table table-bordered" id="students-table">
                            <thead>
                                <tr>
                                    <th>S No.</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>Aadhaar</th>
                                    <th>Address</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
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
$(function() {
    $('#students-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ url('/student-list') }}",
        columns: [{
                data: 'id',
                name: 'id'
            },
            {
                data: 'name',
                name: 'name'
            },
            {
                data: 'email',
                name: 'email'
            },
            {
                data: 'phone',
                name: 'phone'
            },
            {
                data: 'aadhaar',
                name: 'aadhaar'
            },
            {
                data: 'address',
                name: 'address'
            },
            {
                data: 'action',
                name: 'action',
                orderable: false,
                searchable: false
            }
        ],
        dom: 'Bfrtip', // Required for buttons
        buttons: [
            // {
            //     text: 'Add',
            //     action: function ( e, dt, node, config ) {
            //         addStudent(); //add student button
            //     }
            // },
            'excel', 'csv', 'pdf', 'print',
            {
                text: 'Reload', // add reload btn
                action: function(e, dt, node, config) {
                    dt.ajax.reload();
                }
            },
            {
                text: 'Reset',
                action: function(e, dt, node, config) {
                    dt.search('').columns().search('').draw();
                }
            }
        ]
    });
});


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