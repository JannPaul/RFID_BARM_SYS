<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Borrow Books</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            min-height: 100vh;
            background: linear-gradient(135deg, #FDECEC, #F7C8D0);
            font-family: Arial, Helvetica, sans-serif;
        }

        .main-container {
            max-width: 1500px;
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
            background: #ffffff;
            border: none;
            border-radius: 25px;
            padding: 30px;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.08);
        }

        /* Student Information */

        .student-input {
            height: 65px;
            font-size: 1.2rem;
            border-radius: 15px;
        }

        /* Search / Barcode */

        .search-input {
            height: 65px;
            font-size: 1.2rem;
            border-radius: 15px;
        }

        .barcode-input {
            height: 65px;
            font-size: 1.2rem;
            border-radius: 15px;
        }

        /* Book Card */

        .book-card {
            border: 2px solid #eeeeee;
            border-radius: 20px;
            overflow: hidden;
            transition: 0.2s;
            height: 100%;
            background: #ffffff;
        }

        .book-card:hover {
            border-color: #212529;
            transform: translateY(-5px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.12);
        }

        .book-image {
            height: 220px;
            width: 100%;
            object-fit: cover;
            background: #f1f1f1;
        }

        .book-placeholder {
            height: 220px;
            width: 100%;
            background: #eeeeee;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 5rem;
        }

        .book-title {
            font-size: 1.15rem;
            font-weight: 700;
            min-height: 55px;
        }

        .book-author {
            color: #6c757d;
            font-size: 0.95rem;
        }

        .availability {
            font-size: 0.9rem;
        }

        .btn-select {
            height: 48px;
            border-radius: 12px;
            font-weight: 700;
        }

        /* Selected Books */

        .selected-area {
            min-height: 180px;
        }

        .selected-book {
            border: 1px solid #dddddd;
            border-radius: 15px;
            padding: 15px;
            background: #fafafa;
        }

        /* Main Buttons */

        .btn-action {
            height: 65px;
            border-radius: 15px;
            font-size: 1.2rem;
            font-weight: 700;
        }

        .kiosk-logo {
            width: 100px;
            height: auto;
        }

        @media(max-width: 768px) {

            .header-title {
                font-size: 2rem;
            }

            .section-card {
                padding: 20px;
            }

            .book-placeholder,
            .book-image {
                height: 180px;
            }
        }
    </style>

</head>

<body>

<div class="container-fluid py-4">

    <div class="main-container mx-auto">

        <!-- ========================= -->
        <!-- HEADER -->
        <!-- ========================= -->

        <div class="text-center mb-4">

            <img
                src="{{ asset('images/lclogo.png') }}"
                class="kiosk-logo mb-2"
                alt="Lourdes College Logo"
            >

            <h1 class="header-title">
                BORROW A BOOK
            </h1>

            <p class="subtitle">
                Select a book below or scan the book barcode.
            </p>

        </div>


        <!-- ========================= -->
        <!-- STUDENT INFORMATION -->
        <!-- ========================= -->

        <div class="section-card mb-4">

            <h4 class="fw-bold mb-3">
                Student Information
            </h4>

            <div class="row">

                <div class="col-lg-6 mb-3 mb-lg-0">

                    <label class="form-label fw-bold">
                        Student ID
                    </label>

                    <input
                        type="text"
                        class="form-control student-input"
                        placeholder="Scan or enter Student ID"
                    >

                </div>


                <div class="col-lg-6">

                    <label class="form-label fw-bold">
                        Student Name
                    </label>

                    <input
                        type="text"
                        class="form-control student-input"
                        placeholder="Student name will appear here"
                        readonly
                    >

                </div>

            </div>

        </div>


        <!-- ========================= -->
        <!-- SEARCH / BARCODE -->
        <!-- ========================= -->

        <div class="section-card mb-4">

            <h4 class="fw-bold mb-3">
                Find a Book
            </h4>

            <div class="row g-3">

                <div class="col-lg-7">

                    <label class="form-label fw-bold">
                        Search Book
                    </label>

                    <input
                        type="text"
                        class="form-control search-input"
                        placeholder="Search by title, author, or ISBN"
                    >

                </div>


                <div class="col-lg-5">

                    <label class="form-label fw-bold">
                        Scan Book Barcode
                    </label>

                    <input
                        type="text"
                        class="form-control barcode-input"
                        placeholder="Scan barcode here"
                    >

                </div>

            </div>

        </div>


        <!-- ========================= -->
        <!-- AVAILABLE BOOKS -->
        <!-- ========================= -->

        <div class="section-card mb-4">

            <div class="d-flex justify-content-between align-items-center mb-4">

                <div>
                    <h4 class="fw-bold mb-1">
                        Available Books
                    </h4>

                    <small class="text-muted">
                        Choose the books you want to borrow.
                    </small>
                </div>

            </div>


            <div class="row g-4">

                <!-- BOOK 1 -->

                <div class="col-xl-3 col-lg-4 col-md-6">

                    <div class="book-card">

                        <div class="book-placeholder">
                            📘
                        </div>

                        <div class="p-3">

                            <div class="book-title">
                                Introduction to Programming
                            </div>

                            <div class="book-author mb-2">
                                John Smith
                            </div>

                            <div class="mb-3">
                                <small class="text-muted">
                                    ISBN: 9781234567890
                                </small>
                            </div>

                            <div class="availability text-success fw-bold mb-3">
                                Available
                            </div>

                            <button
                                type="button"
                                class="btn btn-dark w-100 btn-select">
                                Select Book
                            </button>

                        </div>

                    </div>

                </div>


                <!-- BOOK 2 -->

                <div class="col-xl-3 col-lg-4 col-md-6">

                    <div class="book-card">

                        <div class="book-placeholder">
                            📗
                        </div>

                        <div class="p-3">

                            <div class="book-title">
                                Database Management Systems
                            </div>

                            <div class="book-author mb-2">
                                Maria Santos
                            </div>

                            <div class="mb-3">
                                <small class="text-muted">
                                    ISBN: 9780987654321
                                </small>
                            </div>

                            <div class="availability text-success fw-bold mb-3">
                                Available
                            </div>

                            <button
                                type="button"
                                class="btn btn-dark w-100 btn-select">
                                Select Book
                            </button>

                        </div>

                    </div>

                </div>


                <!-- BOOK 3 -->

                <div class="col-xl-3 col-lg-4 col-md-6">

                    <div class="book-card">

                        <div class="book-placeholder">
                            📕
                        </div>

                        <div class="p-3">

                            <div class="book-title">
                                Web Development Fundamentals
                            </div>

                            <div class="book-author mb-2">
                                Peter Cruz
                            </div>

                            <div class="mb-3">
                                <small class="text-muted">
                                    ISBN: 9781111111111
                                </small>
                            </div>

                            <div class="availability text-success fw-bold mb-3">
                                Available
                            </div>

                            <button
                                type="button"
                                class="btn btn-dark w-100 btn-select">
                                Select Book
                            </button>

                        </div>

                    </div>

                </div>


                <!-- BOOK 4 -->

                <div class="col-xl-3 col-lg-4 col-md-6">

                    <div class="book-card">

                        <div class="book-placeholder">
                            📙
                        </div>

                        <div class="p-3">

                            <div class="book-title">
                                Computer Networking
                            </div>

                            <div class="book-author mb-2">
                                Robert Garcia
                            </div>

                            <div class="mb-3">
                                <small class="text-muted">
                                    ISBN: 9782222222222
                                </small>
                            </div>

                            <div class="availability text-success fw-bold mb-3">
                                Available
                            </div>

                            <button
                                type="button"
                                class="btn btn-dark w-100 btn-select">
                                Select Book
                            </button>

                        </div>

                    </div>

                </div>

            </div>

        </div>


        <!-- ========================= -->
        <!-- SELECTED BOOKS -->
        <!-- ========================= -->

        <div class="section-card mb-4">

            <h4 class="fw-bold mb-1">
                Selected Books
            </h4>

            <p class="text-muted mb-4">
                Books selected for borrowing will appear here.
            </p>


            <div class="selected-area">

                <!-- Placeholder for now -->

                <div class="text-center py-5 text-muted">

                    <div style="font-size: 3rem;">
                        📚
                    </div>

                    <h5 class="mt-2">
                        No books selected
                    </h5>

                    <p class="mb-0">
                        Select a book above or scan its barcode.
                    </p>

                </div>

            </div>

        </div>


        <!-- ========================= -->
        <!-- BUTTONS -->
        <!-- ========================= -->

        <div class="section-card">

            <div class="row justify-content-center g-3">

                <div class="col-lg-4 col-md-6">

                    <!-- No function yet -->

                    <button
                        type="button"
                        class="btn btn-success w-100 btn-action">
                        Confirm Borrow
                    </button>

                </div>


                <div class="col-lg-4 col-md-6">

                    <a
                        href="{{ url('/monitor') }}"
                        class="btn btn-secondary w-100 btn-action d-flex align-items-center justify-content-center">
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