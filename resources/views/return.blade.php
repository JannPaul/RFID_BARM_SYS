<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Return Books</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            min-height: 100vh;
            background: linear-gradient(135deg, #FDECEC, #F7C8D0);
            font-family: Arial, Helvetica, sans-serif;
        }

        .main-container {
            max-width: 1400px;
        }

        .header-title {
            font-size: 3rem;
            font-weight: 700;
            margin-bottom: 5px;
        }

        .subtitle {
            font-size: 1.2rem;
            color: #6c757d;
        }

        .section-card {
            background: white;
            border-radius: 25px;
            padding: 30px;
            box-shadow: 0 8px 25px rgba(0,0,0,.08);
        }

        .kiosk-logo {
            width: 100px;
            height: auto;
        }

        .form-control-custom {
            height: 65px;
            font-size: 1.2rem;
            border-radius: 15px;
        }

        .scan-box {
            border: 3px dashed #ced4da;
            border-radius: 20px;
            padding: 35px;
            text-align: center;
            background: #fafafa;
        }

        .scan-icon {
            font-size: 4rem;
        }

        .book-card {
            border: 2px solid #eeeeee;
            border-radius: 20px;
            padding: 20px;
            background: #ffffff;
            transition: .2s;
        }

        .book-card:hover {
            border-color: #212529;
            box-shadow: 0 8px 20px rgba(0,0,0,.1);
        }

        .book-image {
            width: 110px;
            height: 140px;
            border-radius: 12px;
            background: #eeeeee;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 3.5rem;
            flex-shrink: 0;
        }

        .book-title {
            font-size: 1.3rem;
            font-weight: 700;
        }

        .book-info {
            color: #6c757d;
        }

        .status-box {
            border-radius: 15px;
            padding: 15px 20px;
            background: #f8f9fa;
        }

        .empty-return {
            min-height: 220px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .btn-action {
            height: 65px;
            border-radius: 15px;
            font-size: 1.2rem;
            font-weight: 700;
        }

        @media(max-width:768px) {
            .header-title {
                font-size: 2rem;
            }

            .section-card {
                padding: 20px;
            }

            .book-image {
                width: 85px;
                height: 115px;
            }
        }
    </style>

</head>

<body>

<div class="container-fluid py-4">

    <div class="main-container mx-auto">

        <!-- HEADER -->

        <div class="text-center mb-4">

            <img
                src="{{ asset('images/lclogo.png') }}"
                class="kiosk-logo mb-2"
                alt="Lourdes College Logo"
            >

            <h1 class="header-title">
                RETURN A BOOK
            </h1>

            <p class="subtitle">
                Scan your Student ID and the barcode of the book you want to return.
            </p>

        </div>


        <!-- STUDENT INFORMATION -->

        <div class="section-card mb-4">

            <h4 class="fw-bold mb-3">
                Student Information
            </h4>

            <div class="row g-3">

                <div class="col-lg-6">

                    <label class="form-label fw-bold">
                        Student ID
                    </label>

                    <input
                        type="text"
                        class="form-control form-control-custom"
                        placeholder="Scan or enter Student ID"
                    >

                </div>


                <div class="col-lg-6">

                    <label class="form-label fw-bold">
                        Student Name
                    </label>

                    <input
                        type="text"
                        class="form-control form-control-custom"
                        placeholder="Student name will appear here"
                        readonly
                    >

                </div>

            </div>

        </div>


        <!-- BARCODE AREA -->

        <div class="section-card mb-4">

            <h4 class="fw-bold mb-3">
                Scan Book
            </h4>

            <div class="scan-box">

                <div class="scan-icon mb-2">
                    📖
                </div>

                <h5 class="fw-bold">
                    Scan the Book Barcode
                </h5>

                <p class="text-muted">
                    You can also manually enter the book ISBN or barcode below.
                </p>

                <div class="row justify-content-center">

                    <div class="col-lg-7">

                        <input
                            type="text"
                            class="form-control form-control-custom text-center"
                            placeholder="Scan or enter book barcode"
                        >

                    </div>

                </div>

            </div>

        </div>


        <!-- BOOKS TO RETURN -->

        <div class="section-card mb-4">

            <div class="mb-4">
                <h4 class="fw-bold mb-1">
                    Books to Return
                </h4>

                <small class="text-muted">
                    Scanned books will appear here before you confirm the return.
                </small>
            </div>


            <!-- EMPTY PLACEHOLDER -->

            <div class="empty-return">

                <div class="text-center text-muted">

                    <div style="font-size:4rem;">
                        📚
                    </div>

                    <h5 class="mt-2">
                        No books scanned
                    </h5>

                    <p class="mb-0">
                        Scan the barcode of the book you want to return.
                    </p>

                </div>

            </div>


            <!--
            SAMPLE BOOK CARD
            Keep this commented for now.
            Later you can generate this from the database.

            <div class="book-card mb-3">

                <div class="d-flex gap-4 align-items-center">

                    <div class="book-image">
                        📘
                    </div>

                    <div class="flex-grow-1">

                        <div class="book-title">
                            Introduction to Programming
                        </div>

                        <div class="book-info mt-1">
                            John Smith
                        </div>

                        <div class="book-info">
                            ISBN: 9781234567890
                        </div>

                        <div class="mt-3">

                            <span class="badge bg-success fs-6">
                                On Time
                            </span>

                        </div>

                    </div>

                    <div>

                        <button
                            type="button"
                            class="btn btn-outline-danger">
                            Remove
                        </button>

                    </div>

                </div>

            </div>
            -->

        </div>


        <!-- RETURN INFORMATION -->

        <div class="section-card mb-4">

            <h4 class="fw-bold mb-3">
                Return Information
            </h4>

            <div class="row g-3">

                <div class="col-md-4">

                    <div class="status-box">

                        <small class="text-muted">
                            Books Selected
                        </small>

                        <h4 class="fw-bold mb-0">
                            0
                        </h4>

                    </div>

                </div>


                <div class="col-md-4">

                    <div class="status-box">

                        <small class="text-muted">
                            Overdue Books
                        </small>

                        <h4 class="fw-bold mb-0">
                            0
                        </h4>

                    </div>

                </div>


                <div class="col-md-4">

                    <div class="status-box">

                        <small class="text-muted">
                            Return Status
                        </small>

                        <h5 class="fw-bold mb-0">
                            Waiting for book
                        </h5>

                    </div>

                </div>

            </div>

        </div>


        <!-- ACTION BUTTONS -->

        <div class="section-card">

            <div class="row justify-content-center g-3">

                <div class="col-lg-4 col-md-6">

                    <!-- No function yet -->

                    <button
                        type="button"
                        class="btn btn-success w-100 btn-action">
                        Confirm Return
                    </button>

                </div>


                <div class="col-lg-4 col-md-6">

                    <a
                        href="{{ url('/monitor') }}"
                        class="btn btn-secondary w-100 btn-action d-flex justify-content-center align-items-center">
                        Cancel
                    </a>

                </div>

            </div>

        </div>

    </div>

</div>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>