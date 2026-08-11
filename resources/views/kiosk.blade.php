<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Borrow / Return</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">

    <style>
        body{
            min-height:100vh;
            background:linear-gradient(135deg,#FDECEC,#F7C8D0);
            font-family:Arial, Helvetica, sans-serif;
        }

        .title{
            font-size:4.5rem;
            font-weight:700;
            letter-spacing:2px;
            color:#000;
            margin-bottom:60px;
        }

        .kiosk-logo{
            width:220px;
            height:auto;
            display:block;
            margin:0 auto 30px auto;
        }

        .kiosk-box{
            width:100%;
            height:320px;

            border:5px solid #000;
            border-radius:45px;

            background:#fff;

            color:#000;
            text-decoration:none;

            font-size:4rem;
            font-weight:700;

            transition:.25s;
        }

        .kiosk-box:hover{
            background:#000;
            color:#fff;
            transform:translateY(-8px);
        }

        .kiosk-box:active{
            transform:scale(.98);
        }

        @media(max-width:992px){

            .title{
                font-size:3rem;
            }

            .kiosk-logo{
                width:150px;
            }

            .kiosk-box{
                height:220px;
                font-size:2.5rem;
            }

        }
    </style>
</head>
<body>

<div class="container-fluid min-vh-100 d-flex justify-content-center align-items-center">

    <div class="container-xxl text-center">

        <!-- Logo -->
        <img src="{{ asset('images/lclogo.png') }}" class="kiosk-logo" alt="Library Logo">

        <!-- Title -->
        <h1 class="title">
           LOURDES COLLEGE BOOK BORROW/ RETURN
        </h1>

        <!-- Buttons -->
<div class="row justify-content-center gx-5 gy-4">

    <!-- BORROW -->
    <div class="col-lg-6">
        <form action="{{ route('borrow.enter') }}" method="POST">
            @csrf

            <button type="submit"
                class="kiosk-box d-flex justify-content-center align-items-center shadow">
                BORROW
            </button>
        </form>
    </div>

    <!-- RETURN -->
    <div class="col-lg-6">
        <form action="{{ route('return.enter') }}" method="POST">
            @csrf

            <button type="submit"
                class="kiosk-box d-flex justify-content-center align-items-center shadow">
                RETURN
            </button>
        </form>
    </div>

    <!-- RESERVE / OTHER -->
    <div class="col-lg-6">
        <a href="{}"
           class="kiosk-box d-flex justify-content-center align-items-center shadow">
            OTHER
        </a>
    </div>

</div>

</div>

<!-- Bootstrap -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>

</body>
</html>