@extends("backend.layouts")
@section('title', 'Dashboard')
@section('content-title', 'Form Events')
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
                <h6 class="m-0 font-weight-bold text-primary">Form Events</h6>
            </div>
            <div class="card-body">
                <form action="{{ Request::segment(3) == "create" ? url("backend/events") : url("backend/events/" . $event->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @if(Request::segment(3) != "create")
                        <input type="hidden" name="_method" value="PUT">
                    @endif
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="title">Title</label>
                            <input type="text" name="title" value="{{ $event->eventDetail->title ?? old("title") }}" class="form-control" id="title" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="event_location">Event Location</label>
                            <select name="event_location" class="form-control" id="cityForm" required>
                                <option value="" selected disabled>Select city</option>
                                @foreach (listProvinces() as $province)
                                    <option value="{{ $province['provinsi_nama'] }}" {{ isset($event) && $province['provinsi_nama'] == $event->eventDetail->event_location ? "selected" : "" }}>{{ $province['provinsi_nama'] }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="#">Event Type</label>
                            <select name="event_type" class="form-control" required>
                                <option value="online" {{ isset($event) && $event->event_type == "online" ? "selected" : "" }}>Online</option>
                                <option value="offline" {{ isset($event) && $event->event_type == "offline" ? "selected" : "" }}>Offline</option>
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="#">Event Status</label>
                            <select name="has_active" class="form-control" required>
                                <option value="1" {{ isset($event) && $event->event_status ? "selected" : "" }}>Aktif</option>
                                <option value="0" {{ isset($event) && !$event->event_status ? "selected" : "" }}>Non Aktif</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="price">Price</label>
                            <input type="number" name="price" value="{{ isset($event) ? $event->eventDetail->price : 0 }}" class="form-control" id="price">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="event_date">Event Date</label>
                            <input type="date" name="event_date" class="form-control" value="{{ isset($event) ? $event->eventDetail->event_date : "" }}" id="event_date">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="start">Start</label>
                            <input type="time" name="start_hour" value="{{ isset($event) ? $event->eventDetail->start_hour : "" }}" class="form-control" id="start">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="end">End</label>
                            <input type="time" name="end_hour" value="{{ isset($event) ? $event->eventDetail->end_hour : "" }}" class="form-control" id="end">
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label for="description">Description</label>
                            <textarea name="description" class="form-control" id="description" cols="30" rows="5">{{ isset($event) ? $event->eventDetail->description : "" }}</textarea>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="event_location">Company (Penyelenggara)</label>
                            <select name="company_id" class="form-control" id="companySelect" required>
                                <option value="" selected disabled>Select Company</option>
                                @foreach ($companies as $company)
                                    <option value="{{ $company['id'] }}" {{ isset($event) && $company['id'] == $event->company_id ? "selected" : "" }}>{{ $company['name'] }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group col-md-6">
                            <label for="event_label">Label Event</label>
                            <select name="event_label[]" id="event_label" class="form-control" multiple="multiple" required>
                                @foreach ($labels as $label)
                                    <option value="{{ $label->name }}" 
                                        @foreach ($event->eventLabelLists as $evetLabel) 
                                            {{ $evetLabel->name == $label->name ? "selected" : "" }}
                                        @endforeach>
                                        {{ $label->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="max_capacity">Max Capacity</label>
                            <input type="number" name="max_capacity" value="{{ isset($event) ? $event->eventDetail->max_capacity : "" }}" class="form-control" id="max_capacity">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="event_link">Event Link</label>
                            <input type="text" name="event_link" value="{{ isset($event) ? $event->eventDetail->link_event : "" }}" class="form-control" id="event_link">
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="productActive">Event Images</label>
                            {{-- <span class=" ml-2">
                                <a class="btn btn-sm btn-success" id="photo-add-id" data-key="999"><i class="fa fa-plus"></i></a>
                            </span> --}}
                            <div class="row">
                                <div class="col-md-10">
                                    <div class="form-group">
                                        <input type="file" name="upload_image" onchange="loadFile(event)" class="form-control rounded-8px product_image" {{ isset($event) ? "" :"required" }}>
                                    </div>
                                </div>
                            </div>
                            {{-- <div id="photo-new" class="row"></div> --}}
                        </div>

                        <div class="form-group col-md-6 {{ isset($event) ? "" : "hidden" }}" id="previewImg">
                            <label for="productActive">Preview Images</label>
                            <img src="{{ isset($event) ? Storage::url($event->eventDetail->banner) : "" }}" id="output" class="img-thumbnail w-50" alt="">
                        </div>
                    </div>


                    {{-- @if(isset($product))
                        <div class="form-group">
                            <h3 class="mb-3">Old Photos</h3>
                            <div class="row">
                                @foreach ($product->productPhotos as $item)
                                    <div class="col-md-8 mb-2">
                                        <img class="img-thumbnail" width="200px" src="{{ env("PRODUCTION_URL") . Storage::url($item->image) }}" alt="Card image">
                                    </div>
                                    <div class="col-md-2 ">
                                        <a class="delete-price-type-range-field" style="background: transparent" onclick="deleteOldPhoto({{ $item->id }})">
                                            <i class="fa fa-2x fa-trash"></i>
                                        </a>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif --}}
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
            $('#event_label').select2();

            $(document).on("click", "#photo-add-id", function (e) {
                e.preventDefault();
                var field     = $("#photo-new");
                const html      =
                `
                <div class="row" id="photo-new">
                    <div class="col-md-10">
                        <div class="form-group">
                            <input type="file" name="upload_image[]" class="form-control rounded-8px product_image" required>
                        </div>
                    </div>
                    <div class="col-md-1">
                        <td class="align-right" id="trush">
                            <a  data-key="'+ i +'" class="delete-price-type-range-field" style="background: transparent" onclick="removeField()">
                                <i class="fa fa-2x fa-trash"></i>
                            </a>
                        <td>
                    </div>
                </div>
                `;
                $(html).insertBefore(field);
            });
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
        const sessionStatus = "{{ Session::has('status') }}"
        const sessionMessage = "{{ Session::get('status') }}"
        const sessionClass = "{{ Session::get('alert-class') }}"
        console.log("session class " + sessionClass)
        if (sessionStatus) {
            Swal.fire(
                sessionClass == "error" ? "Opps!" : "Success!",
                sessionMessage,
                sessionClass
            )
        }

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

        function removeField(){
            $("#photo-new").remove()
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
