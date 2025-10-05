@extends('layout.admin')
@section('contents')
<main id="main" class="main">

    <div class="pagetitle">
        <h1>Data Tables</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                <li class="breadcrumb-item">Hod</li>
                <li class="breadcrumb-item active">Hod list</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Datatables</h5>
                        @if(session('success'))
                        <div class="alert alert-success">{{session('success')}}</div>
                        @endif
                        @if(session('error'))
                        <script>
                        alert("{{ session('error') }}");
                        </script>
                        @endif
                        <!-- Table with stripped rows -->
                        <table class="table datatable">
                            <thead>
                                <tr>
                                    <th>
                                        S no
                                    </th>
                                    <th>name</th>
                                    <th>email</th>
                                    <th>phone</th>
                                    <th>department</th>
                                    <th>action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $id = 1;
                                ?>
                                @foreach($hods as $hod)
                                <tr>
                                    <td>{{$id++}}</td>
                                    <td>{{$hod->name}}</td>
                                    <td>{{$hod->email}}</td>
                                    <td>{{$hod->phone}}</td>
                                    <td>{{$hod->department}}</td>
                                    <td><a href="{{url('/edit-hod-form/'.$hod->id)}}"
                                            class="btn btn-sm btn-primary">edit</a><a
                                            href="{{url('/delete-hod/'.$hod->id)}}"
                                            onclick="return confirm('Are you sure you want to delete this HOD?');"
                                            class="btn btn-sm btn-danger">delete</a></td>
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

</main>

@endsection