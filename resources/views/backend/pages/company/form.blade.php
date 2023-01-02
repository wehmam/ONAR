@extends("backend.layouts")
@section('title', 'Company Form')
@section('content-title', 'Form Company')
@section('css')
    <link href="https://unpkg.com/tailwindcss@^2/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <style>
        .select2-container--default .select2-selection--single {
            height: 38px !important;
            /* padding: 10px 16px; */
            padding: 5px;
            /* font-size: 18px;  */
            line-height: 1.33;
            border-radius: 6px;
        }

        .select2-container--default .select2-selection--single .select2-selection__arrow b {
            top: 75% !important;
        }

        .select2-container--default .select2-selection--single .select2-selection__rendered {
            line-height: 26px !important;
        }

        .select2-container--default .select2-selection--single {
            border: 1px solid #CCC !important;
            box-shadow: 0px 1px 1px rgba(0, 0, 0, 0.075) inset;
            transition: border-color 0.15s ease-in-out 0s, box-shadow 0.15s ease-in-out 0s;
        }

        .delete-price-type-range-field {
            color: red;
        }
        .delete-price-type-range-field:hover {
            color: red;
            cursor: pointer;
        }

    </style>
@endsection
@section('content')

    <!-- DataTales Example -->
    <div class="container-fluid">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Form Company</h6>
            </div>
            <div class="card-body">
                <form action="{{ Request::segment(3) == "create" ? url("backend/companies") : url("backend/companies/" . $company->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @if(Request::segment(3) != "create")
                        <input type="hidden" name="_method" value="PUT">
                    @endif
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="name">Company Name</label>
                            <input type="text" name="name" value="{{ $company->name ?? old("name") }}" class="form-control" id="title" required disabled>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="phone_number">Phone Number</label>
                            <input type="number" name="phone_number" value="{{ $company->phone_number ?? old("phone_number") }}" class="form-control" required>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label for="description">Description</label>
                            <textarea name="description" class="form-control" id="description" cols="30" rows="5">{{ $company->description ?? old("description") }}</textarea>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-8">
                            <label for="address">Address</label>
                            <textarea name="address" class="form-control" id="address" cols="30" rows="5">{{ $company->address ?? old("address") }}</textarea>
                        </div>
                    </div>





                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="productActive">Company Images</label>
                            <div class="row">
                                <div class="col-md-10">
                                    <div class="form-group">
                                        <input type="file" name="upload_image" onchange="loadFile(event)" class="form-control rounded-8px product_image" {{ isset($company) ? "" :"required" }}>
                                    </div>
                                </div>
                            </div>
                            {{-- <div id="photo-new" class="row"></div> --}}
                        </div>

                        <div class="form-group col-md-6 {{ isset($company) ? "" : "hidden" }}" id="previewImg">
                            <label for="productActive">Preview Images</label>
                            <img src="{{ isset($company) ? Storage::url($company->image) : "" }}" id="output" class="img-thumbnail w-50" alt="">
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">Save</button>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('js')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#cityForm').select2();
            $('#companySelect').select2();
        });

        $(document).on("change", ".product_image", function (e) {
            e.preventDefault();

            var fileType = this.files[0].type;
            var ValidImageTypes = ["image/gif", "image/jpeg", "image/png"];
            if ($.inArray(fileType, ValidImageTypes) < 0) {
                Swal.fire(
                    'Oops...',
                    "Hanya bisa upload file berformat jpg/png/gif",
                    'warning'
                )
                $(this).val("");
            }

        });

        let loadFile = (event) => {
            let reader = new FileReader()
            document.getElementById('previewImg').classList.remove('hidden');
            reader.onload = function() {
                let output = document.getElementById("output")
                output.src = reader.result
            };
            console.log(event.target.files[0]);
            reader.readAsDataURL(event.target.files[0]);
        }

        function deleteOldPhoto(id) {
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't Delete This Photo!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Delete!'
                }).then((result) => {
                if (result.isConfirmed) {
                    fetch('{{ url("/backend/product/delete-photo") }}' + "/" +id, {
                        headers: {
                            'content-type'      : 'application/json',
                            'Accept'            : 'application/json',
                            'X-Requested-With'  : 'XMLHttpRequest',
                            'X-CSRF-Token'      : '{{ csrf_token() }}',
                        },
                        method: 'DELETE',
                    })
                    .then(res => {
                        window.location.reload()
                    })
                }
            })
        }
    </script>
@endsection
