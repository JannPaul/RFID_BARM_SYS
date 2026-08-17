@include('layouts.header')

@include('layouts.css')

<link
    href="{{ asset('assets/plugins/tables/css/datatable/dataTables.bootstrap4.min.css') }}"
    rel="stylesheet"
>

<style>

    .summary-card {
        border: none;
        border-radius: 18px;
        box-shadow: 0 5px 18px rgba(0,0,0,0.08);
    }

    .summary-number {
        font-size: 32px;
        font-weight: 700;
        margin-bottom: 0;
    }

    .student-card {
        border: none;
        border-radius: 18px;
        box-shadow: 0 5px 18px rgba(0,0,0,0.08);
    }

    .student-name {
        font-weight: 700;
    }

    .student-number {
        font-size: 12px;
        color: #777;
    }

    .rfid-text {
        font-size: 12px;
        color: #666;
    }

    .status-badge {
        padding: 7px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
    }

    .inside-row {
        background-color: #eaffef !important;
    }

    .table td,
    .table th {
        vertical-align: middle !important;
    }

</style>


@include('layouts.top_navbar')

@include('layouts.left_sidebar')


<div class="content-body">

    <div class="container-fluid">


        <!-- ============================================================
             PAGE TITLE
        ============================================================= -->

        <div class="row page-titles mx-0">

            <div class="col-sm-6 p-md-0">

                <div class="welcome-text">

                    <h4>
                        Student Monitoring
                    </h4>

                    <span>
                        Monitor student information and library attendance
                    </span>

                </div>

            </div>


            <div
                class="col-sm-6 p-md-0
                justify-content-sm-end
                mt-2 mt-sm-0 d-flex"
            >

                <ol class="breadcrumb">

                    <li class="breadcrumb-item">

                        <a href="{{ route('dashboard') }}">
                            Dashboard
                        </a>

                    </li>

                    <li class="breadcrumb-item active">
                        Students
                    </li>

                </ol>

            </div>

        </div>


        <!-- ============================================================
             SUMMARY CARDS
        ============================================================= -->

        <div class="row">


            <!-- TOTAL STUDENTS -->

            <div class="col-xl-4 col-lg-6 col-sm-6">

                <div class="card summary-card">

                    <div class="card-body">

                        <h5>
                            Total Students
                        </h5>

                        <p class="summary-number">

                            {{ $totalStudents }}

                        </p>

                        <span class="text-muted">
                            Registered students
                        </span>

                    </div>

                </div>

            </div>


            <!-- VISITED TODAY -->

            <div class="col-xl-4 col-lg-6 col-sm-6">

                <div class="card summary-card">

                    <div class="card-body">

                        <h5>
                            Visited Today
                        </h5>

                        <p class="summary-number text-primary">

                            {{ $visitedToday }}

                        </p>

                        <span class="text-muted">
                            Students who entered today
                        </span>

                    </div>

                </div>

            </div>


            <!-- CURRENTLY INSIDE -->

            <div class="col-xl-4 col-lg-6 col-sm-6">

                <div class="card summary-card">

                    <div class="card-body">

                        <h5>
                            Currently Inside
                        </h5>

                        <p class="summary-number text-success">

                            {{ $insideToday }}

                        </p>

                        <span class="text-muted">
                            Students without time out
                        </span>

                    </div>

                </div>

            </div>

        </div>


        <!-- ============================================================
             STUDENT TABLE
        ============================================================= -->

        <div class="card student-card">

            <div class="card-header">

                <div class="row w-100 align-items-center">

                    <div class="col-md-6">

                        <h4 class="card-title mb-0">

                            <i class="fa fa-graduation-cap mr-2"></i>

                            Student Records

                        </h4>

                    </div>


                    <div class="col-md-6 text-md-right">

                        <small class="text-muted">

                            {{ now()->format('F d, Y') }}

                        </small>

                    </div>

                </div>

            </div>


            <div class="card-body">

                <div class="table-responsive">

                    <table
                        id="studentTable"
                        class="table table-hover"
                    >

                        <thead>

                            <tr>

                                <th>#</th>

                                <th>Student</th>

                                <th>Year Level</th>

                                <th>Course / Program</th>

                                <th>RFID</th>

                                <th>Contact</th>

                                <th>Date</th>

                                <th>Time In</th>

                                <th>Time Out</th>

                                <th>Status</th>

                            </tr>

                        </thead>


                        <tbody>

                        @forelse($students as $student)

                            @php

                                $attendance =
                                    $student->latestAttendance;

                                $isInside =
                                    $attendance &&
                                    $attendance->date &&
                                    $attendance->date->isToday() &&
                                    $attendance->time_in &&
                                    !$attendance->time_out;

                            @endphp


                            <tr class="{{ $isInside ? 'inside-row' : '' }}">


                                <!-- NUMBER -->

                                <td>
                                    {{ $loop->iteration }}
                                </td>


                                <!-- STUDENT -->

                                <td>

                                    <strong class="student-name">

                                        {{ $student->firstname }}
                                        {{ $student->lastname }}

                                    </strong>

                                    <br>

                                    <span class="student-number">

                                        Student No:

                                        {{ $student->student_number }}

                                    </span>

                                </td>


                                <!-- YEAR LEVEL -->

                                <td>

                                    {{ $student->year_level ?? '-' }}

                                </td>


                                <!-- COURSE -->

                                <td>

                                    {{ $student->course_program ?? '-' }}

                                </td>


                                <!-- RFID -->

                                <td>

                                    @if($student->rfid_tag_uid)

                                        <span class="rfid-text">

                                            <i class="fa fa-id-card mr-1"></i>

                                            {{ $student->rfid_tag_uid }}

                                        </span>

                                    @else

                                        <span class="text-muted">
                                            No RFID
                                        </span>

                                    @endif

                                </td>


                                <!-- CONTACT -->

                                <td>

                                    {{ $student->contact_information ?? '-' }}

                                </td>


                                <!-- ATTENDANCE DATE -->

                                <td>

                                    @if(
                                        $attendance &&
                                        $attendance->date
                                    )

                                        {{ $attendance->date->format('M d, Y') }}

                                    @else

                                        <span class="text-muted">
                                            -
                                        </span>

                                    @endif

                                </td>


                                <!-- TIME IN -->

                                <td>

                                    @if(
                                        $attendance &&
                                        $attendance->time_in
                                    )

                                        <i class="fa fa-sign-in mr-1 text-success"></i>

                                        <strong>

                                            {{
                                                $attendance
                                                    ->time_in
                                                    ->format('h:i A')
                                            }}

                                        </strong>

                                    @else

                                        <span class="text-muted">
                                            -
                                        </span>

                                    @endif

                                </td>


                                <!-- TIME OUT -->

                                <td>

                                    @if(
                                        $attendance &&
                                        $attendance->time_out
                                    )

                                        <i class="fa fa-sign-out mr-1 text-danger"></i>

                                        <strong>

                                            {{
                                                $attendance
                                                    ->time_out
                                                    ->format('h:i A')
                                            }}

                                        </strong>

                                    @elseif($isInside)

                                        <span class="text-warning">

                                            <i class="fa fa-clock-o mr-1"></i>

                                            Still Inside

                                        </span>

                                    @else

                                        <span class="text-muted">
                                            -
                                        </span>

                                    @endif

                                </td>


                                <!-- STATUS -->

                                <td>

                                    @if($isInside)

                                        <span
                                            class="badge badge-success status-badge"
                                        >

                                            Inside

                                        </span>

                                    @elseif(
                                        $attendance &&
                                        $attendance->time_out
                                    )

                                        <span
                                            class="badge badge-secondary status-badge"
                                        >

                                            Time Out

                                        </span>

                                    @elseif(
                                        $attendance &&
                                        $attendance->time_in
                                    )

                                        <span
                                            class="badge badge-warning status-badge"
                                        >

                                            No Time Out

                                        </span>

                                    @else

                                        <span
                                            class="badge badge-light status-badge"
                                        >

                                            No Attendance

                                        </span>

                                    @endif

                                </td>

                            </tr>


                        @empty

                            <tr>

                                <td
                                    colspan="10"
                                    class="text-center py-5"
                                >

                                    <i
                                        class="fa fa-graduation-cap"
                                        style="
                                        font-size:45px;
                                        color:#ccc;
                                        "
                                    >
                                    </i>

                                    <h5 class="mt-3">

                                        No students found

                                    </h5>

                                    <p class="text-muted">

                                        Student records will appear here.

                                    </p>

                                </td>

                            </tr>

                        @endforelse

                        </tbody>

                    </table>

                </div>

            </div>

        </div>


    </div>

</div>


@include('layouts.footer')


<!-- ================================================================
     DATATABLE
================================================================ -->

<script
    src="{{ asset('assets/plugins/tables/js/jquery.dataTables.min.js') }}"
></script>

<script
    src="{{ asset('assets/plugins/tables/js/datatable/dataTables.bootstrap4.min.js') }}"
></script>


<script>

$(document).ready(function () {

    $('#studentTable').DataTable({

        pageLength: 10,

        order: [
            [1, 'asc']
        ]

    });

});

</script>