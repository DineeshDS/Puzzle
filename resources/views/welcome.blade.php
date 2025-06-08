<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{config('app.name')}}</title>

    <!-- Favicon -->
    <link rel="shortcut icon" href="{{asset('/assets/images/favicon.png')}}"/>

    <!-- Themify icons -->
    <link rel="stylesheet" href="{{asset('/dist/icons/themify-icons/themify-icons.css')}}" type="text/css">

    <!-- Main style file -->
    <link rel="stylesheet" href="{{asset('/dist/css/app.min.css')}}" type="text/css">

    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body class="auth">

<!-- begin::preloader-->
<div class="preloader">
    <div class="preloader-icon"></div>
</div>
<!-- end::preloader -->
<div class="form-wrapper">
    <div class="container">
        <div class="card">
            <div class="row g-0">
                <div class="col">
                    <div class="row">
                        <div class="col-md-10 offset-md-1">
                            <div class="my-5 text-center text-lg-start">
                                <h1 class="display-8">Puzzle Challenge!</h1>
                                <p class="text-muted"><b>Please enter your name and email to get started.</b></p>
                            </div>
                            <form class="mb-5" method="POST" name="frm" id="frm" action="">
                                @csrf
                                <div class="mb-3" id="form-name">
                                    <input type="text" class="form-control" placeholder="Student Name" name="name" id="name" autofocus required>
                                    <span style="color: red" class="help-block"></span>
                                </div>
                                <div class="mb-3" id="form-email">
                                    <input type="email" class="form-control" name="email" placeholder="Email" id="email" required>
                                    <span style="color: red" class="help-block"></span>
                                </div>
                                <div class="text-center text-lg-start">
                                    <button type="button" class="btn btn-primary" onclick="submit_form()">Play Now
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col d-none d-lg-flex border-start align-items-center justify-content-between flex-column text-center">
                    <div class="logo">

                    </div>
                    <div>
                        <h3 class="fw-bold">Welcome to the Puzzle Challenge</h3>
                        <p class="lead my-5">Cheers!</p>

                    </div>
                    <ul class="list-inline">
                        <li class="list-inline-item">

                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- Bundle scripts -->
<script src="{{asset('/lib/bundle.js')}}"></script>

<!-- Main Javascript file -->
<script src="{{asset('/dist/js/app.min.js')}}"></script>

<!-- sweet alert -->
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

<script type="text/javascript">

    function submit_form() {
        var form = $('#frm')[0];
        var formData = new FormData(form);
        $.ajax({
            type: "POST",
            url: "{{route('register')}}",
            data: formData,
            processData: false,
            contentType: false,
            success: function (response) {
                if (response.status == 200) {
                    swal(response.message, {
                        icon: "success",
                        timer: 2000,
                    });
                }
                setTimeout(function () {
                    window.location.href = "{{route('login')}}";
                }, 2000);

            },
            error: function (error) {
                if (error.status === 422) {
                    var data = error.responseJSON.errors;

                    for (let i in data) {
                        showValidationErrors(i, data[i][0])
                    }

                }
            }
        });
    }

    function showValidationErrors(name, error) {
        console.log(name);
        var input = $("#" + name);
        input.addClass('is-invalid');

        var group = $("#form-" + name);
        console.log(group);
        group.addClass('has-error');
        group.find('.help-block').text(error);
    }
</script>
</body>
</html>