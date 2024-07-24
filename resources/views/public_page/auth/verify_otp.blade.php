<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1" />
    <title>AMC</title>

    <!-- google font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;500;700&display=swap" rel="stylesheet">
    <!-- font awesome -->
    <link rel="stylesheet" href="{{ asset('assets/landing/font/fontAwesome/all.min.css') }}" />
    <!-- bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <!-- swipper -->
    <link rel="stylesheet" href="{{ asset('assets/landing/css/swiper.min.css') }}">
    <!-- Custom Scrollbar -->
    <link rel="stylesheet" href="{{ asset('assets/landing/css/jquery.mCustomScrollbar.min.css') }}">
    <!-- nice select -->
    <link rel="stylesheet" href="{{ asset('assets/landing/css/nice-select.css') }}">
    <!-- main css -->
    <link rel="stylesheet" href="{{ asset('assets/landing/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/landing/css/responsive.css') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>

<body>
    <div class="d-block bg-gray">
        <div class="row align-items-center justify-content-center">
            <div class="col-md-6">
                <div class="vh-100 d-flex align-items-center justify-content-center">
                    <div class="card rounded-5 border-0 shadow">
                        <div class="card-body">
                            <div class="p-2 p-lg-5 text-center">
                                <img src="{{ asset('assets/landing/images/Logo_AMC_Fixed.png') }}" alt="amc"
                                    class="mw-100  my-3 ">
                                <h5>Silahkan masukkan <strong>kode verifikasi</strong><br>
                                    yang kami kirim ke nomor
                                    {{ $customer->phone }}
                                </h5>
                                @if ($errors->any())
                                    <div class="alert alert-danger">
                                        @foreach ($errors->all() as $error)
                                            {{ $error }}
                                        @endforeach
                                    </div>
                                @endif
                                <form action="{{ route('customer.check_otp', $hashedId) }}" id="otpForm"
                                    method="POST">
                                    @csrf
                                    <div class="form-group">
                                        <div class="d-flex justify-content-center">
                                            <input id="code1" name="otp[]" class="pin-input form-control"
                                                type="number" maxlength="1" onkeyup="onKeyUpEvent(1, event)"
                                                onfocus="onFocusEvent(1)"
                                                oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);">
                                            <input id="code2" name="otp[]" class="pin-input form-control"
                                                type="number" maxlength="1" name="otp[]"
                                                onkeyup="onKeyUpEvent(2, event)" onfocus="onFocusEvent(2)"
                                                oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);">
                                            <input id="code3" name="otp[]" class="pin-input form-control"
                                                type="number" maxlength="1" onkeyup="onKeyUpEvent(3, event)"
                                                onfocus="onFocusEvent(3)"
                                                oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);">
                                            <input id="code4" name="otp[]" class="pin-input form-control"
                                                type="number" maxlength="1" onkeyup="onKeyUpEvent(4, event)"
                                                onfocus="onFocusEvent(4)"
                                                oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);">
                                        </div>
                                        <div class="form-group mt-3">
                                            <button id="btnSubmitOtp" type="submit"
                                                class="btn btn-dark-blue py-2 px-3">Submit</button>

                                        </div>
                                    </div>
                                </form>
                                <div class="col-12 mt-3 resend" id="otpNotifBottom">
                                    <p>Belum menerimanya?</p>
                                    <p>kirim ulang kode <span class="text-primary">60</span></p>
                                </div>
                                <div class="d-block mt-5">
                                    <p>Butuh Bantuan ?</p>
                                    <ul class="list-group list-group-horizontal  justify-content-center">
                                        <li class="me-3">
                                            <a class="nav-link ps-0 text-primary-blue" aria-current="page"
                                                href="https://www.instagram.com/amc.idn/" target="_blank">
                                                <i class="fab fa-instagram"></i>
                                                @amc.idn
                                            </a>
                                        </li>
                                        <li class="me-3">
                                            <a class="nav-link ps-0 text-primary-blue" aria-current="page"
                                                href="https://api.whatsapp.com/send?phone=6285210632227"
                                                target="_blank">
                                                <i class="fab fa-whatsapp"></i>
                                                AMC Customer Care
                                            </a>
                                        </li>

                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>


    <!-- jawa script -->
    <!-- jquery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.min.js"
        integrity="sha384-Rx+T1VzGupg4BHQYs2gCW9It+akI2MM/mndMCy36UVfodzcJcF0GGLxZIzObiEfa" crossorigin="anonymous">
    </script>
    <!-- swipper -->
    <script src="{{ asset('assets/landing/js/swiper.min.js') }}"></script>
    <!-- nice select -->
    <script src="{{ asset('assets/landing/js/jquery.nice-select.min.js') }}"></script>
    <!-- custom Scrollbar -->
    <script src="{{ asset('assets/landing/js/jquery.mCustomScrollbar.concat.min.js') }}"></script>
    <!-- matchheight -->
    <script src="{{ asset('assets/landing/js/jquery.matchHeight-min.js') }}"></script>
    <!-- main js -->
    <script src="{{ asset('assets/landing/js/main.js') }}"></script>
    <script src="{{ asset('vendor/sweetalert/sweetalert.all.js') }}"></script>
    @include('sweetalert::alert')
    <script>
        const codeInputs = document.querySelectorAll('.pin-input');
        const btnSubmitOtp = document.getElementById('btnSubmitOtp');
        const otpNotifBottom = document.getElementById('otpNotifBottom');
        let counter = 60; // Adjust the counter as needed

        // Initialize event listeners
        codeInputs.forEach((input, index) => {
            input.addEventListener('keyup', (event) => onKeyUpEvent(index + 1, event));
            input.addEventListener('focus', () => onFocusEvent(index + 1));
        });

        btnSubmitOtp.addEventListener('click', (e) => {
            e.preventDefault();
            const code = getCode();
            if (code.trim() === "") {
                displayOtpNotif("Kode OTP tidak boleh kosong");
            } else {
                // Submit the OTP code
                $('#otpForm').submit();
            }
        });

        function getCodeBoxElement(index) {
            return document.getElementById('code' + index);
        }

        function onFocusEvent(index) {
            for (item = 1; item < index; item++) {
                const currentElement = getCodeBoxElement(item);
                if (!currentElement.value) {
                    currentElement.focus();
                    break;
                }
            }
        }

        function onKeyUpEvent(index, event) {
            const eventCode = event.which || event.keyCode;
            if (getCodeBoxElement(index).value.length === 1) {
                if (index !== 4) {
                    getCodeBoxElement(index + 1).focus();
                } else {
                    getCodeBoxElement(index).blur();
                }
            }
            if (eventCode === 8 && index !== 1) {
                getCodeBoxElement(index - 1).focus();
            }
        }

        var interval = setInterval(function() {
            counter--;
            if (counter < 0) {
                clearInterval(interval);
                $('#otpNotifBottom').html(
                    '<p>Belum menerimanya?</p><p><a href="#" onclick="resendCode()" class="text-primary-blue">kirim ulang kode</a></p>'
                );
                return;
            } else {
                $('#otpNotifBottom').html(
                    '<p>Belum menerimanya?</p><p>kirim ulang kode <span class="text-priamry-blue">' +
                    counter +
                    '</span></p>');
            }
        }, 1000);

        function resendCode() {
            var url;
            if ($('#methodOtp').val() == 2) { // sms method
                url = "/customer/phone-resendotp";
            } else { // wa method
                url = "/customer/phone-resendotp-wa";
            }
            var phone = $('#pnumber').text();
            $.ajax({
                url: '{{ route('customer.resend_otp', $hashedId) }}',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                method: 'POST',
                data: {
                    phone: phone
                },
                dataType: 'json',
                success: function(result) {
                    if (result.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'OTP Sent!',
                            text: 'Your OTP has been sent successfully.',
                            toast: true,
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 3000
                        });

                        $('#otpNotif').hide();
                        $('#formOtp').fadeOut("slow");
                        $('#pnumber').text(result.phone);
                        $('#formOtp').fadeIn("slow");
                        $('input#code4').val(null);
                        $('input#code3').val(null);
                        $('input#code2').val(null);
                        $('input#code1').val(null);
                        counter = 90;
                        var interval = setInterval(function() {
                            counter--;
                            if (counter < 0) {
                                clearInterval(interval);
                                $('#otpNotifBottom').html(
                                    '<p>Belum menerimanya?</p><p><a href="#" onclick="resendCode()" class="text-primary-blue">kirim ulang kode</a></p>'
                                );
                                return;
                            } else {
                                $('#otpNotifBottom').html(
                                    '<p>Belum menerimanya?</p><p>kirim ulang kode <span>' +
                                    counter + '</span></p>');
                            }
                        }, 1000);
                    } else {
                        $('#otpNotif').hide();
                        $('#otpNotif').html(result.error_message);
                        $('#otpNotif').show();
                    }
                },
                error: function() {
                    console.log("error sending message");
                }
            });
        };

        // Function to get the OTP code from input fields
        function getCode() {
            return Array.from(codeInputs).map(input => input.value).join('');
        }

        // Function to display OTP notification
        function displayOtpNotif(message) {
            otpNotifBottom.innerHTML = `<p>${message}</p>`;
        }

        // Function to submit the OTP code
        function submitForm(code) {
            // Replace the URL with your server endpoint
            const url = "/your-server-endpoint";

            // You can adjust the AJAX request as needed
            fetch(url, {
                    method: 'POST',
                    body: JSON.stringify({
                        code
                    }),
                    headers: {
                        'Content-Type': 'application/json',
                    },
                })
                .then(response => response.json())
                .then(result => {
                    if (result.status === 0 || result.status === 1) {
                        window.location.href = result.redirect_url;
                    } else {
                        displayOtpNotif(result.message);
                    }
                })
                .catch(error => {
                    console.log('Error:', error);
                    displayOtpNotif('An error occurred while sending the OTP.');
                });
        }
    </script>

</body>

</html>
