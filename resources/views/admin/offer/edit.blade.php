@extends('layouts.app')

@section('title', 'Edit Offer')

@section('content')

    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid">

                {{-- Alert Messages --}}
                @include('common.alert')

                <div class="row">
                    <div class="col-12">
                        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                            <h4 class="mb-sm-0">Edit Offer</h4>
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
                                    <form method="POST" onsubmit="return validateFile()"
                                        action="{{ route('offer.update') }}" enctype="multipart/form-data">
                                        @csrf

                                        <input type="hidden" name="offerId" value="{{ $getData['id'] }}">

                                        <div class="row gy-4">

                                            <div class="col-lg-4 col-md-6">
                                                <div>
                                                    <span style="color:red;">*</span>Text
                                                    <input type="text" class="form-control" placeholder="Enter Text"
                                                        name="text" id="text" autocomplete="off"
                                                        value="{{ $getData['text'] }}" required>
                                                </div>
                                                @error('text')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>

                                            <div class="col-lg-4 col-md-6">
                                                <div>
                                                    <span style="color:red;">*</span>Offer Code
                                                    <input type="text" class="form-control"
                                                        placeholder="Enter Offer Code" name="offercode" id="offercode"
                                                        autocomplete="off" value="{{ $getData['offercode'] }}" required>
                                                </div>
                                                @error('offercode')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>

                                            <div class="col-lg-3 col-md-6">
                                                <div>
                                                    Photo <span style="color:red;"></span>
                                                    <input type="file" class="form-control" name="photo" id="strPhoto"
                                                        value="{{ $getData['photo'] }}">
                                                    <input type="hidden" name="hiddenPhoto" class="form-control"
                                                        value="{{ old('photo') ? old('photo') : $getData['photo'] }}"
                                                        id="hiddenPhoto">
                                                </div>
                                            </div>
                                            <div class="col-lg-1 col-md-6">
                                                <div id="viewimg">
                                                    @if ($getData['photo'])
                                                        <img src="{{ asset('uploads/offer') . '/' . $getData['photo'] }}"
                                                            alt="" height="70" width="70">
                                                    @else
                                                        <img src="{{ asset('assets/images/noimage.png') }}"
                                                            style="width: 50px;height: 50px;">
                                                    @endif
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
                                                        id="percentage" autocomplete="off"
                                                        value="{{ $getData['percentage'] }}" required>
                                                </div>
                                                @error('percentage')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>

                                            <div class="col-lg-3 col-md-6">
                                                <div>
                                                    <span style="color:red;">*</span>Min Value
                                                    <input type="text" class="form-control"
                                                        oninput="this.value = this.value.replace(/[^0-9]/g, '').replace(/(\..*?)\..*/g, '$1');"
                                                        placeholder="Enter Min Value" name="minvalue" id="minvalue"
                                                        autocomplete="off" value="{{ $getData['minvalue'] }}" required>
                                                </div>
                                                @error('minvalue')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>

                                            <div class="col-lg-3 col-md-6">
                                                <div>
                                                    <span style="color:red;">*</span>From Date
                                                    <input type="text" class="form-control" placeholder="Enter To Date"
                                                        name="fromdate" id="startdatepicker" autocomplete="off"
                                                        value="{{ $getData['startdate'] }}" required>
                                                </div>
                                                @error('fromdate')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>

                                            <div class="col-lg-3 col-md-6">
                                                <div>
                                                    <span style="color:red;">*</span>To Date
                                                    <input type="text" class="form-control" placeholder="Enter To Date"
                                                        name="todate" id="enddatepicker" autocomplete="off"
                                                        value="{{ $getData['enddate'] }}" required>
                                                </div>
                                                @error('todate')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>

                                        </div>
                                        <div class="card-footer mt-5" style="float: right;">
                                            <button type="submit"
                                                class="btn btn-primary btn-user float-right mb-3 mx-2">Update</button>
                                            <a class="btn btn-primary float-right mr-3 mb-3 mx-2"
                                                href="{{ route('offer.index') }}">Cancel</a>
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

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> <!-- ✅ Add this -->
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
    <link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">


    <script>
        function validateFile() {
            var allowedExtension = ['jpeg', 'jpg', 'png', 'webp', ''];
            var fileExtension = document.getElementById('strPhoto').value.split('.').pop().toLowerCase();
            var isValidFile = false;
            var image = document.getElementById('strPhoto').value;

            for (var index in allowedExtension) {

                if (fileExtension === allowedExtension[index]) {
                    isValidFile = true;
                    break;
                }
            }
            if (image != "") {
                if (!isValidFile) {
                    alert('Allowed Extensions are : *.' + allowedExtension.join(', *.'));
                }
                return isValidFile;
            }

            return true;
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

    <script>
        $(document).ready(function() {
            // Initialize From Date Picker
            $("#startdatepicker").datepicker({
                dateFormat: 'dd-mm-yy',
                onSelect: function(selectedDate) {
                    $("#enddatepicker").datepicker("option", "minDate", selectedDate);
                }
            });

            // Initialize To Date Picker
            $("#enddatepicker").datepicker({
                dateFormat: 'dd-mm-yy'
            });

            // ✅ Set minDate on load if #startdatepicker already has a value
            var fromDate = $("#startdatepicker").val();
            if (fromDate) {
                $("#enddatepicker").datepicker("option", "minDate", fromDate);
            }
        });
    </script>

@endsection
