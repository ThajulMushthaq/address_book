<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Address Book</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous">
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

    <style>
        body {
            background-color: #eee
        }

        .card {
            border: none;
            border-radius: 10px
        }

        .c-details span {
            font-weight: 300;
            font-size: 13px
        }

        .text2 {
            color: #a5aec0
        }

        .form-control::placeholder {
            font-size: 0.95rem;
            color: #aaa;
            font-style: italic;
        }

        .form-control:focus {
            box-shadow: none;
        }

        .error {
            color: rgb(240, 83, 83);
            font-size: 80%;
        }
    </style>
</head>

<body>
    <div class="container mt-5 mb-3">

        <div class="row mb-5">
            <div class="col-lg-10 mx-auto">
                <form action="">
                    <div class="p-1 bg-light rounded rounded-pill shadow-sm">
                        <input type="search" placeholder="Search here..." id="search"
                            aria-describedby="button-addon1" class="form-control border-0 bg-light">
                    </div>
                </form>
            </div>
            <div class="col-lg-2 mx-auto mt-1">
                <button type="button" class="btn btn-info w-100" data-bs-toggle="modal" data-bs-target="#myModal">Add
                    Contact</button>
            </div>
        </div>

        <div class="row" id="data-row">

            @foreach (@$data as $d)
                <div class="col-md-4 data-col my-2">
                    <div class="card p-3 mb-2 ">
                        <div class="d-flex justify-content-between">
                            <h3 class="heading c-details">{{ $d->name }}</h3>
                            <a href="{{ url('delete/'.$d->id) }}" class="btn btn-light text-danger"><i class="fas fa-trash"></i></a>
                        </div>
                        <div class="ms-2 mt-2">
                            <h6>{{ $d->phone }}</h6>
                            <div class="mt-2 text2">{{ $d->email }}</div>
                        </div>
                    </div>
                </div>
            @endforeach

        </div>

    </div>



    <!-- The Modal -->
    <div class="modal" id="myModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="/save" method="POST" enctype="multipart/form-data" id="contact_add_form">
                    @csrf
                    <!-- Modal Header -->
                    <div class="modal-header">
                        <h4 class="modal-title">Add Contact</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <!-- Modal body -->
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Name</label>
                                    <input type="text" class="form-control" name="name">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Email</label>
                                    <input type="text" class="form-control" name="email">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Phone</label>
                                    <input type="text" class="form-control" name="phone">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Address</label>
                                    <textarea class="form-control" name="address"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Modal footer -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-success">Save</button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</body>

<script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>

<script>
    $(document).ready(function() {
        $("#search").on("keyup", function() {
            var value = $(this).val().toLowerCase();
            $("#data-row .data-col").filter(function() {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
            });
        });
    });
</script>

<script>
    $("#contact_add_form").validate({
        rules: {
            name: "required",
            email: "required",
            phone: "required",
        },
        messages: {
            name: "Name field is required.",
            email: "Email field is required.",
            phone: "Phone field is required.",
        },
        submitHandler: function(form) {
            var form = $("#contact_add_form").get(0);

            $.ajax({
                url: '/save',
                type: 'POST',
                data: new FormData(form),
                dataType: 'json',
                mimeType: 'multipart/form-data',
                processData: false,
                contentType: false,
                success: function(response) {
                    // var delete_url = 
                    // console.log(delete_url) not completed
                    $($.parseHTML(`<div class="col-md-4 data-col my-2">
                        <div class="card p-3 mb-2 ">
                            <div class="d-flex justify-content-between">
                                <h3 class="heading c-details">` + response.name + `</h3>
                            </div>
                            <div class="ms-2 mt-2">
                                <h6>` + response.phone + `</h6>
                                <div class="mt-2 text2">` + response.email + `</div>
                            </div>
                        </div>
                    </div>`)).appendTo('#data-row');


                    $('#myModal').modal('hide');

                    setTimeout(function() {
                        alert("Successfully added..!");
                    }, 800);

                },
                error: function(data) {
                    if (data.responseJSON.errors.name) {
                        alert(data.responseJSON.errors.name);
                    } else if (data.responseJSON.errors.email) {
                        alert(data.responseJSON.errors.email);
                    } else if (data.responseJSON.errors.phone) {
                        alert(data.responseJSON.errors.phone);
                    } else {
                        alert('Oops..! Something went wrong.');
                    }
                }
            });
        }
    });
</script>

</html>
