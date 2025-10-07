@extends('layouts.app')

@section('title', 'Add Offer')

@section('content')

    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid">

                {{-- Alert Messages --}}
                @include('common.alert')

                <div class="row">
                    <div class="col-12">
                        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                            <h4 class="mb-sm-0">Add Offer</h4>
                            <div class="page-title-right">
                                <a href="{{ route('offer.index') }}"
                                    class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
                                    Back
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="live-preview">
                                    <form id="regForm" method="POST" onsubmit="return validateFile()"
                                        action="{{ route('offer.store') }}" enctype="multipart/form-data">
                                        @csrf
                                        <div class="row gy-4">

                                            <div class="col-lg-4 col-md-6">
                                                <div>
                                                    <span style="color:red;">*</span>Text
                                                    <input type="text" class="form-control" placeholder="Enter Text"
                                                        name="text" id="text" autocomplete="off"
                                                        value="{{ old('text') }}" required autofocus>
                                                    @error('text')
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="col-lg-4 col-md-6">
                                                <div>
                                                    <span style="color:red;">*</span>Offer Code
                                                    <input type="text" class="form-control"
                                                        placeholder="Enter Offer Code" name="offercode" id="offercode"
                                                        autocomplete="off" value="{{ old('offercode') }}" required>
                                                    @error('offercode')
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="col-lg-3 col-md-6">
                                                <div>
                                                    <span style="color:red;">*</span>Photo
                                                    <input type="file" class="form-control" name="photo" id="strPhoto"
                                                        required>
                                                </div>
                                            </div>
                                            <div class="col-lg-1 col-md-6">
                                                <div id="viewimg">
                                                    @error('photo')
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="col-lg-3 col-md-6">
                                                <div>
                                                    <span style="color:red;">*</span>Percentage (%) off
                                                    <input type="text" class="form-control"
                                                        oninput="this.value = this.value.replace(/[^0-9]/g, '').replace(/(\..*?)\..*/g, '$1');"
                                                        placeholder="Enter Percentage (%) off" name="percentage"
                                                        id="percentage" autocomplete="off" value="{{ old('percentage') }}"
                                                        required>
                                                    @error('percentage')
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="col-lg-3 col-md-6">
                                                <div>
                                                    <span style="color:red;">*</span>Min Value
                                                    <input type="text" class="form-control"
                                                        oninput="this.value = this.value.replace(/[^0-9]/g, '').replace(/(\..*?)\..*/g, '$1');"
                                                        placeholder="Enter Min Value" name="minvalue" id="minvalue"
                                                        autocomplete="off" value="{{ old('minvalue') }}" required>
                                                    @error('minvalue')
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="col-lg-3 col-md-6">
                                                <div>
                                                    <span style="color:red;">*</span>From Date
                                                    <input type="text" class="form-control" placeholder="Enter To Date"
                                                        name="fromdate" id="startdatepicker" autocomplete="off"
                                                        value="{{ old('fromdate') }}" required>
                                                    @error('fromdate')
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="col-lg-3 col-md-6">
                                                <div>
                                                    <span style="color:red;">*</span>To Date
                                                    <input type="text" class="form-control" placeholder="Enter To Date"
                                                        name="todate" id="enddatepicker" autocomplete="off"
                                                        value="{{ old('todate') }}" required>
                                                    @error('todate')
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>

                                        </div>
                                        <div class="card-footer mt-5" style="float: right;">
                                            <button type="submit"
                                                class="btn btn-primary btn-user float-right mb-3 mx-2">Save
                                            </button>
                                            <a class="btn btn-primary float-right mr-3 mb-3 mx-2"
                                                href="{{ route('offer.index') }}">Cancel
                                            </a>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection

@section('scripts')

    <script>
        function validateFile() {
            var allowedExtension = ['jpeg', 'jpg', 'png', 'webp', ''];
            var fileExtension = document.getElementById('strPhoto').value.split('.').pop().toLowerCase();
            var isValidFile = false;

            for (var index in allowedExtension) {

                if (fileExtension === allowedExtension[index]) {
                    isValidFile = true;
                    break;
                }
            }
            if (!isValidFile) {
                alert('Allowed Extensions are : *.' + allowedExtension.join(', *.'));
            }
            return isValidFile;
        }
    </script>

    {{-- Add photo --}}
    <script>
        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#hello').attr('src', e.target.result);
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
        $("#strPhoto").change(function() {
            html =
                '<img src="' + readURL(this) +
                '"   id="hello" width="70px" height = "70px" > ';
            $('#viewimg').html(html);
        });
    </script>

    <link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>

    <script>
        $(function() {
            // Initialize Start Datepicker
            $("#startdatepicker").datepicker({
                dateFormat: 'dd-mm-yy', // Use dd-mm-yy format (ensure it's consistent with the date format you're using)
                onSelect: function(selectedDate) {
                    // Set the minimum date for End Datepicker (it will be the date selected in Start Datepicker)
                    $("#enddatepicker").datepicker("option", "minDate", selectedDate);
                }
            });

            // Initialize End Datepicker
            $("#enddatepicker").datepicker({
                dateFormat: 'dd-mm-yy', // Use dd-mm-yy format
            });
        });
    </script>

@endsection
