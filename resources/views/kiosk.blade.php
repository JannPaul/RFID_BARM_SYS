<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <!-- =====================================================
         CSRF TOKEN
    ====================================================== -->

    <meta
        name="csrf-token"
        content="{{ csrf_token() }}"
    >


    <title>
        Book Borrow / Return
    </title>


    <!-- Bootstrap -->
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >


    <style>

        body {

            min-height: 100vh;

            background:
                linear-gradient(
                    135deg,
                    #FDECEC,
                    #F7C8D0
                );

            font-family:
                Arial,
                Helvetica,
                sans-serif;
        }


        .title {

            font-size: 4.5rem;

            font-weight: 700;

            letter-spacing: 2px;

            color: #000;

            margin-bottom: 60px;
        }


        .kiosk-logo {

            width: 220px;

            height: auto;

            display: block;

            margin:
                0 auto
                30px auto;
        }


        .kiosk-box {

            width: 100%;

            height: 320px;

            border: 5px solid #000;

            border-radius: 45px;

            background: #fff;

            color: #000;

            text-decoration: none;

            font-size: 4rem;

            font-weight: 700;

            transition: .25s;
        }


        .kiosk-box:hover {

            background: #000;

            color: #fff;

            transform:
                translateY(-8px);
        }


        .kiosk-box:active {

            transform:
                scale(.98);
        }


        /*
        |--------------------------------------------------------------------------
        | INVISIBLE RFID SCANNER
        |--------------------------------------------------------------------------
        */

        #rfidScanner {

            position: fixed;

            left: -9999px;

            top: -9999px;

            width: 1px;

            height: 1px;

            opacity: 0;

            border: 0;

            padding: 0;

            margin: 0;

            outline: none;
        }


        /*
        |--------------------------------------------------------------------------
        | MOBILE
        |--------------------------------------------------------------------------
        */

        @media(max-width: 992px) {

            .title {

                font-size: 3rem;
            }


            .kiosk-logo {

                width: 150px;
            }


            .kiosk-box {

                height: 220px;

                font-size: 2.5rem;
            }

        }

    </style>

</head>


<body>


<!-- =====================================================
     INVISIBLE RFID SCANNER INPUT
====================================================== -->

<input
    type="text"
    id="rfidScanner"
    autocomplete="off"
    autofocus
>


<div
    class="
        container-fluid
        min-vh-100
        d-flex
        justify-content-center
        align-items-center
    "
>


    <div class="container-xxl text-center">


        <!-- =====================================================
             LOGO
        ====================================================== -->

        <img
            src="{{ asset('images/lclogo.png') }}"
            class="kiosk-logo"
            alt="Library Logo"
        >


        <!-- =====================================================
             TITLE
        ====================================================== -->

        <h1 class="title">

            LOURDES COLLEGE

            <br>

            BOOK BORROW / RETURN

        </h1>


        <!-- =====================================================
             BUTTONS
        ====================================================== -->

        <div
            class="
                row
                justify-content-center
                gx-5
                gy-4
            "
        >


            <!-- =================================================
                 BORROW
            ================================================== -->

            <div class="col-lg-6">


                <form
                    action="{{ route('borrow.enter') }}"
                    method="POST"
                >

                    @csrf


                    <button
                        type="submit"
                        class="
                            kiosk-box
                            d-flex
                            justify-content-center
                            align-items-center
                            shadow
                        "
                    >

                        BORROW

                    </button>


                </form>


            </div>


            <!-- =================================================
                 RETURN
            ================================================== -->

            <div class="col-lg-6">


                <form
                    action="{{ route('return.enter') }}"
                    method="POST"
                >

                    @csrf


                    <button
                        type="submit"
                        class="
                            kiosk-box
                            d-flex
                            justify-content-center
                            align-items-center
                            shadow
                        "
                    >

                        RETURN

                    </button>


                </form>


            </div>


        </div>


    </div>


</div>


<!-- =====================================================
     BOOTSTRAP
====================================================== -->

<script
    src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
></script>


<!-- =====================================================
     RFID SCANNER
====================================================== -->

<script>

document.addEventListener('DOMContentLoaded', function () {

    /*
    |--------------------------------------------------------------------------
    | Elements
    |--------------------------------------------------------------------------
    */

    const scanner =
        document.getElementById('rfidScanner');

    const csrfToken =
        document
            .querySelector('meta[name="csrf-token"]')
            .getAttribute('content');


    let scanTimer = null;

    let processing = false;


    /*
    |--------------------------------------------------------------------------
    | Focus Scanner
    |--------------------------------------------------------------------------
    */

    function focusScanner() {

        if (!processing) {

            scanner.focus();

        }

    }


    /*
    |--------------------------------------------------------------------------
    | Initial Focus
    |--------------------------------------------------------------------------
    */

    setTimeout(function () {

        focusScanner();

    }, 300);


    /*
    |--------------------------------------------------------------------------
    | Refocus When Browser Window Becomes Active
    |--------------------------------------------------------------------------
    */

    window.addEventListener('focus', function () {

        setTimeout(function () {

            focusScanner();

        }, 200);

    });


    /*
    |--------------------------------------------------------------------------
    | Refocus After Clicking Empty Area
    |--------------------------------------------------------------------------
    |
    | We avoid immediately stealing focus from buttons.
    |
    */

    document.addEventListener('click', function (event) {

        if (
            event.target.tagName !== 'BUTTON' &&
            event.target.tagName !== 'A'
        ) {

            setTimeout(function () {

                focusScanner();

            }, 200);

        }

    });


    /*
    |--------------------------------------------------------------------------
    | Detect RFID Typing
    |--------------------------------------------------------------------------
    |
    | Most USB RFID readers work like keyboards.
    |
    | Example:
    |
    | 2088350422
    |
    */

    scanner.addEventListener('input', function () {

        clearTimeout(scanTimer);


        /*
         * Wait briefly until scanner
         * finishes typing the RFID.
         */

        scanTimer = setTimeout(function () {

            processRFID();

        }, 200);

    });


    /*
    |--------------------------------------------------------------------------
    | RFID Reader ENTER Key
    |--------------------------------------------------------------------------
    */

    scanner.addEventListener('keydown', function (event) {

        if (event.key === 'Enter') {

            event.preventDefault();

            clearTimeout(scanTimer);

            processRFID();

        }

    });


    /*
    |--------------------------------------------------------------------------
    | Process RFID
    |--------------------------------------------------------------------------
    */

    async function processRFID() {

        /*
         * Prevent double scan/request
         */

        if (processing) {

            return;

        }


        const rfid =
            scanner.value.trim();


        /*
         * Clear scanner immediately
         */

        scanner.value = '';


        /*
         * Ignore empty values
         */

        if (!rfid) {

            focusScanner();

            return;

        }


        processing = true;


        console.log(
            'RFID SCANNED:',
            rfid
        );


        try {

            /*
            |--------------------------------------------------------------------------
            | Send RFID To Laravel
            |--------------------------------------------------------------------------
            */

            const response = await fetch(
                '{{ route("attendance.scan") }}',
                {

                    method: 'POST',

                    credentials: 'same-origin',

                    headers: {

                        'Content-Type':
                            'application/json',

                        'Accept':
                            'application/json',

                        'X-CSRF-TOKEN':
                            csrfToken,

                        'X-Requested-With':
                            'XMLHttpRequest'

                    },

                    body: JSON.stringify({

                        rfid_tag_uid: rfid

                    })

                }
            );


            /*
            |--------------------------------------------------------------------------
            | Read Laravel Response
            |--------------------------------------------------------------------------
            */

            let data;


            try {

                data =
                    await response.json();

            }

            catch (jsonError) {

                console.error(
                    'Invalid JSON:',
                    jsonError
                );


                throw new Error(
                    'Laravel returned an invalid response.'
                );

            }


            /*
            |--------------------------------------------------------------------------
            | Laravel Error
            |--------------------------------------------------------------------------
            */

            if (!response.ok) {

                throw new Error(
                    data.message ??
                    'Unable to record attendance.'
                );

            }


            console.log(
                'ATTENDANCE RESPONSE:',
                data
            );


            /*
            |--------------------------------------------------------------------------
            | CLOCK IN
            |--------------------------------------------------------------------------
            */

            if (data.action === 'clock_in') {

                alert(

                    data.name +

                    '\n\nTIME IN SUCCESSFUL' +

                    '\n\nRFID: ' +

                    data.rfid_tag_uid

                );

            }


            /*
            |--------------------------------------------------------------------------
            | CLOCK OUT
            |--------------------------------------------------------------------------
            */

            else if (data.action === 'clock_out') {

                alert(

                    data.name +

                    '\n\nTIME OUT SUCCESSFUL' +

                    '\n\nRFID: ' +

                    data.rfid_tag_uid

                );

            }


            /*
            |--------------------------------------------------------------------------
            | Other Successful Response
            |--------------------------------------------------------------------------
            */

            else {

                alert(

                    data.message ??
                    'Attendance recorded successfully.'

                );

            }

        }

        catch (error) {

            /*
            |--------------------------------------------------------------------------
            | Error
            |--------------------------------------------------------------------------
            */

            console.error(
                'RFID ERROR:',
                error
            );


            alert(
                error.message
            );

        }

        finally {

            /*
            |--------------------------------------------------------------------------
            | Reset Scanner
            |--------------------------------------------------------------------------
            */

            processing = false;

            scanner.value = '';


            setTimeout(function () {

                focusScanner();

            }, 300);

        }

    }

});

</script>


</body>

</html>