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

    .reservation-card {
        border: none;
        border-radius: 18px;
        box-shadow: 0 5px 18px rgba(0,0,0,0.08);
    }

    .reservation-title {
        font-weight: 700;
    }

    .student-id {
        font-size: 12px;
        color: #777;
    }

    .status-badge {
        padding: 7px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
    }

    .action-button {
        margin: 2px;
    }

    .today-row {
        background-color: #fff8dd !important;
    }

    .expired-row {
        background-color: #ffeaea !important;
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


        <!-- PAGE TITLE -->

        <div class="row page-titles mx-0">

            <div class="col-sm-6 p-md-0">

                <div class="welcome-text">

                    <h4>
                        Reservation Monitoring
                    </h4>

                    <span>
                        Monitor book reservations and scheduled pickups
                    </span>

                </div>

            </div>


            <div
                class="col-sm-6 p-md-0
                justify-content-sm-end
                mt-2 mt-sm-0 d-flex">

                <ol class="breadcrumb">

                    <li class="breadcrumb-item">

                        <a href="{{ route('dashboard') }}">
                            Dashboard
                        </a>

                    </li>

                    <li class="breadcrumb-item active">
                        Reservations
                    </li>

                </ol>

            </div>

        </div>



        <!-- SUCCESS MESSAGE -->

        @if(Session::has('success'))

            <div
                class="alert alert-success
                alert-dismissible fade show">

                {{ Session::get('success') }}

                <button
                    type="button"
                    class="close"
                    data-dismiss="alert">

                    <span>&times;</span>

                </button>

            </div>

        @endif



        <!-- SUMMARY CARDS -->

        <div class="row">


            <!-- TOTAL -->

            <div class="col-xl-3 col-lg-6 col-sm-6">

                <div class="card summary-card">

                    <div class="card-body">

                        <h5>
                            Total Reservations
                        </h5>

                        <p class="summary-number">

                            {{ $reservations->count() }}

                        </p>

                        <span class="text-muted">
                            All reservation records
                        </span>

                    </div>

                </div>

            </div>



            <!-- PENDING -->

            <div class="col-xl-3 col-lg-6 col-sm-6">

                <div class="card summary-card">

                    <div class="card-body">

                        <h5>
                            Pending
                        </h5>

                        <p class="summary-number text-warning">

                            {{
                                $reservations
                                ->where('status', 'pending')
                                ->count()
                            }}

                        </p>

                        <span class="text-muted">
                            Waiting for processing
                        </span>

                    </div>

                </div>

            </div>



            <!-- TODAY -->

            <div class="col-xl-3 col-lg-6 col-sm-6">

                <div class="card summary-card">

                    <div class="card-body">

                        <h5>
                            Pickup Today
                        </h5>

                        <p class="summary-number text-primary">

                            {{
                                $reservations
                                ->filter(function($reservation) {

                                    return
                                        $reservation
                                        ->borrow_date
                                        ->isToday()

                                        &&

                                        in_array(
                                            $reservation->status,
                                            ['pending', 'ready']
                                        );

                                })
                                ->count()
                            }}

                        </p>

                        <span class="text-muted">
                            Scheduled for today
                        </span>

                    </div>

                </div>

            </div>



            <!-- EXPIRED -->

            <div class="col-xl-3 col-lg-6 col-sm-6">

                <div class="card summary-card">

                    <div class="card-body">

                        <h5>
                            Expired
                        </h5>

                        <p class="summary-number text-danger">

                            {{
                                $reservations
                                ->where('status', 'expired')
                                ->count()
                            }}

                        </p>

                        <span class="text-muted">
                            Missed reservations
                        </span>

                    </div>

                </div>

            </div>

        </div>



        <!-- RESERVATION TABLE -->

        <div class="card reservation-card">

            <div class="card-header">

                <div class="row w-100 align-items-center">

                    <div class="col-md-6">

                        <h4 class="card-title mb-0">

                            <i class="fa fa-calendar mr-2"></i>

                            Reserved Books

                        </h4>

                    </div>


                    <div class="col-md-6 text-md-right">

                        <small class="text-muted">

                            {{
                                now()->format(
                                    'F d, Y'
                                )
                            }}

                        </small>

                    </div>

                </div>

            </div>



            <div class="card-body">

                <div class="table-responsive">

                    <table
                        id="reservationTable"
                        class="table table-hover">

                        <thead>

                            <tr>

                                <th>#</th>

                                <th>Student</th>

                                <th>Book</th>

                                <th>Reserve Date</th>

                                <th>Borrow Date</th>

                                <th>Pickup Time</th>

                                <th>Status</th>

                                <th>Action</th>

                            </tr>

                        </thead>


                        <tbody>

                        @forelse(
                            $reservations as $reservation
                        )


                            @php

                                $isToday =
                                    $reservation
                                    ->borrow_date
                                    ->isToday();

                                $isExpired =
                                    $reservation->status
                                    === 'expired';

                            @endphp


                            <tr
                                class="
                                {{ $isToday ? 'today-row' : '' }}
                                {{ $isExpired ? 'expired-row' : '' }}
                                "
                            >


                                <!-- NUMBER -->

                                <td>
                                    {{ $loop->iteration }}
                                </td>



                                <!-- STUDENT -->

                                <td>

                                    <strong>
                                        {{
                                            $reservation
                                            ->student_name
                                        }}
                                    </strong>

                                    <br>

                                    <span class="student-id">

                                        ID:

                                        {{
                                            $reservation
                                            ->student_id
                                        }}

                                    </span>

                                </td>



                                <!-- BOOK -->

                                <td style="min-width:250px;">

                                    <span class="reservation-title">

                                        {{
                                            $reservation
                                            ->book
                                            ->title
                                            ?? 'Unknown Book'
                                        }}

                                    </span>

                                    <br>

                                    <small class="text-muted">

                                        {{
                                            $reservation
                                            ->book
                                            ->author
                                            ?? 'Unknown Author'
                                        }}

                                    </small>

                                    <br>

                                    <small>

                                        Call Number:

                                        {{
                                            $reservation
                                            ->book
                                            ->call_number
                                            ?? '-'
                                        }}

                                    </small>

                                </td>



                                <!-- RESERVATION CREATED -->

                                <td>

                                    {{
                                        $reservation
                                        ->created_at
                                        ->format(
                                            'M d, Y'
                                        )
                                    }}

                                    <br>

                                    <small class="text-muted">

                                        {{
                                            $reservation
                                            ->created_at
                                            ->format(
                                                'h:i A'
                                            )
                                        }}

                                    </small>

                                </td>



                                <!-- BORROW DATE -->

                                <td>

                                    @if($isToday)

                                        <strong class="text-primary">

                                            {{
                                                $reservation
                                                ->borrow_date
                                                ->format(
                                                    'M d, Y'
                                                )
                                            }}

                                        </strong>

                                        <br>

                                        <span
                                            class="badge badge-primary">

                                            TODAY

                                        </span>

                                    @else

                                        {{
                                            $reservation
                                            ->borrow_date
                                            ->format(
                                                'M d, Y'
                                            )
                                        }}

                                    @endif

                                </td>



                                <!-- PICKUP TIME -->

                                <td>

                                    <i
                                        class="fa fa-clock-o mr-1">
                                    </i>

                                    {{
                                        $reservation
                                        ->pickup_time
                                    }}

                                </td>



                                <!-- STATUS -->

                                <td>


                                    @if(
                                        $reservation->status
                                        === 'pending'
                                    )

                                        <span
                                            class="badge badge-warning
                                            status-badge">

                                            Pending

                                        </span>


                                    @elseif(
                                        $reservation->status
                                        === 'ready'
                                    )

                                        <span
                                            class="badge badge-info
                                            status-badge">

                                            Ready

                                        </span>


                                    @elseif(
                                        $reservation->status
                                        === 'picked_up'
                                    )

                                        <span
                                            class="badge badge-success
                                            status-badge">

                                            Picked Up

                                        </span>


                                    @elseif(
                                        $reservation->status
                                        === 'cancelled'
                                    )

                                        <span
                                            class="badge badge-secondary
                                            status-badge">

                                            Cancelled

                                        </span>


                                    @elseif(
                                        $reservation->status
                                        === 'expired'
                                    )

                                        <span
                                            class="badge badge-danger
                                            status-badge">

                                            Expired

                                        </span>

                                    @endif


                                </td>



                                <!-- ACTION -->

                                <td style="min-width:220px;">


                                    @if(
                                        $reservation->status
                                        === 'pending'
                                    )


                                        <!-- READY -->

                                        <form
                                            action="{{
                                                route(
                                                    'reserve.ready',
                                                    $reservation->id
                                                )
                                            }}"
                                            method="POST"
                                            class="d-inline"
                                        >

                                            @csrf
                                            @method('PUT')


                                            <button
                                                type="submit"
                                                class="btn btn-info btn-sm
                                                action-button">

                                                <i
                                                    class="fa fa-check">
                                                </i>

                                                Ready

                                            </button>

                                        </form>


                                    @endif



                                    @if(
                                        in_array(
                                            $reservation->status,
                                            ['pending', 'ready']
                                        )
                                    )


                                        <!-- PICKED UP -->

                                        <form
                                            action="{{
                                                route(
                                                    'reserve.pickup',
                                                    $reservation->id
                                                )
                                            }}"
                                            method="POST"
                                            class="d-inline"
                                        >

                                            @csrf
                                            @method('PUT')


                                            <button
                                                type="submit"
                                                class="btn btn-success btn-sm
                                                action-button"
                                                onclick="
                                                return confirm(
                                                'Confirm that the student picked up this book?'
                                                )"
                                            >

                                                <i
                                                    class="fa fa-book">
                                                </i>

                                                Picked Up

                                            </button>

                                        </form>



                                        <!-- CANCEL -->

                                        <button
                                            type="button"
                                            class="btn btn-danger btn-sm
                                            action-button"
                                            data-toggle="modal"
                                            data-target="#cancelModal{{
                                                $reservation->id
                                            }}"
                                        >

                                            <i
                                                class="fa fa-times">
                                            </i>

                                            Cancel

                                        </button>


                                    @else

                                        <span class="text-muted">

                                            No actions

                                        </span>

                                    @endif


                                </td>

                            </tr>



                            <!-- CANCEL MODAL -->

                            <div
                                class="modal fade"
                                id="cancelModal{{
                                    $reservation->id
                                }}"
                                tabindex="-1"
                            >

                                <div class="modal-dialog">

                                    <div class="modal-content">


                                        <form
                                            action="{{
                                                route(
                                                    'reserve.cancel',
                                                    $reservation->id
                                                )
                                            }}"
                                            method="POST"
                                        >

                                            @csrf
                                            @method('PUT')


                                            <div class="modal-header">

                                                <h5 class="modal-title">

                                                    Cancel Reservation

                                                </h5>


                                                <button
                                                    type="button"
                                                    class="close"
                                                    data-dismiss="modal">

                                                    <span>
                                                        &times;
                                                    </span>

                                                </button>

                                            </div>



                                            <div class="modal-body">

                                                <p>

                                                    Cancel reservation for:

                                                </p>

                                                <strong>

                                                    {{
                                                        $reservation
                                                        ->student_name
                                                    }}

                                                </strong>

                                                <p class="mt-2">

                                                    {{
                                                        $reservation
                                                        ->book
                                                        ->title
                                                        ?? ''
                                                    }}

                                                </p>


                                                <label>
                                                    Remarks
                                                </label>


                                                <textarea
                                                    name="remarks"
                                                    class="form-control"
                                                    rows="4"
                                                    placeholder="Reason for cancellation"
                                                ></textarea>

                                            </div>



                                            <div class="modal-footer">


                                                <button
                                                    type="button"
                                                    class="btn btn-secondary"
                                                    data-dismiss="modal">

                                                    Close

                                                </button>


                                                <button
                                                    type="submit"
                                                    class="btn btn-danger">

                                                    Cancel Reservation

                                                </button>


                                            </div>

                                        </form>

                                    </div>

                                </div>

                            </div>


                        @empty


                            <tr>

                                <td
                                    colspan="8"
                                    class="text-center py-5">

                                    <i
                                        class="fa fa-calendar"
                                        style="
                                        font-size:45px;
                                        color:#ccc;
                                        ">
                                    </i>

                                    <h5 class="mt-3">

                                        No reservations found

                                    </h5>

                                    <p class="text-muted">

                                        Student reservations
                                        will appear here.

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


<script
    src="{{
        asset(
            'assets/plugins/tables/js/jquery.dataTables.min.js'
        )
    }}">
</script>


<script
    src="{{
        asset(
            'assets/plugins/tables/js/datatable/dataTables.bootstrap4.min.js'
        )
    }}">
</script>


<script>

$(document).ready(function () {

    $('#reservationTable').DataTable({

        pageLength: 10,

        order: [
            [4, 'asc']
        ]

    });

});

</script>