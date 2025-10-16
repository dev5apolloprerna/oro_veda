@extends('layouts.app')

@section('title', 'Add Product')

@section('content')


    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid">

                {{-- Alert Messages --}}
                @include('common.alert')

                {{--  @if ($errors->any())
                    <h5 style="color:red">Following errors exists in your excel file</h5>
                    <ol>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ol>
                @endif  --}}

                <div class="row">
                    <div class="col-12">
                        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                            <h4 class="mb-sm-0">Add Product</h4>
                            <div class="page-title-right">
                                <a href="{{ route('product.index') }}"
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
                                        action="{{ route('product.store') }}" enctype="multipart/form-data">
                                        @csrf
                                        <div class="row gy-4">

                                            <div class="col-lg-4 col-md-6">
                                                <div>
                                                    <span style="color:red;">*</span> Category
                                                    <select onchange="validatecategory();" class="form-control"
                                                        id="categoryId" name="categoryId" required>
                                                        <option value="">Select Category Name </option>
                                                        @foreach ($Category as $category)
                                                            <option value="{{ $category->id }}"
                                                                {{ old('categoryId') == $category->id ? 'selected' : '' }}>
                                                                {{ $category->categoryname }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                    @error('categoryId')
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>

                                            {{--  <div class="col-lg-4 col-md-6">
                                                <div>
                                                    <span style="color:red;"></span>Sub Category
                                                    <select class="form-control" name="subcategoryid" id="subcategoryid">
                                                        <option value="" selected>Select Sub Category
                                                        </option>

                                                    </select>
                                                    @error('subcategoryid')
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>  --}}

                                            <div class="col-lg-4 col-md-6">
                                                <div>
                                                    <span style="color:red;">*</span> Product Name
                                                    <input type="text" class="form-control"
                                                        placeholder="Enter Product Name" name="productname"
                                                        autocomplete="off" maxlength="255" value="{{ old('productname') }}"
                                                        required>
                                                    @error('productname')
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="col-lg-4 col-md-6">
                                                <div>
                                                    <span style="color:red;">*</span> Multiple Photo (Upto 5)
                                                    <input type="file" class="form-control" name="photo[]" multiple
                                                        id="strPhoto" required>
                                                    @error('photo')
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="col-lg-3 col-md-6">
                                                <div>
                                                    <span style="color:red;">*</span> Rate (MRP)
                                                    <input type="text" class="form-control" name="rate" id="strPhoto"
                                                        oninput="this.value = this.value.replace(/[^0-9]/g, '').replace(/(\..*?)\..*/g, '$1');"
                                                        maxlength="5" placeholder="Enter Rate" required autocomplete="off">
                                                    @error('rate')
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="col-lg-3 col-md-6">
                                                <div>
                                                    <span style="color:red;">*</span> Cut Price (MRP)
                                                    <input type="text" class="form-control" placeholder="Enter Cut Price"
                                                        oninput="this.value = this.value.replace(/[^0-9]/g, '').replace(/(\..*?)\..*/g, '$1');"
                                                        maxlength="5" name="cut_price" autocomplete="off"
                                                        value="{{ old('cut_price') }}" required autocomplete="off">
                                                    @error('cut_price')
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="col-lg-3 col-md-6">
                                                <div>
                                                    <span style="color:red;">*</span> USD Rate (MRP)
                                                    <input type="text" class="form-control" name="usd_rate"
                                                        id="usd_rate" inputmode="decimal"
                                                        oninput="this.value = this.value
                                                        .replace(/[^0-9.]/g,'')        // allow digits & dot
                                                        .replace(/(\..*?)\..*/g,'$1')  // keep only the first dot
                                                        .replace(/^(\.)/,'0.')         // '.5' -> '0.5'
                                                      "
                                                        maxlength="5" placeholder="Enter USD Rate" required
                                                        autocomplete="off">
                                                    @error('usd_rate')
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="col-lg-3 col-md-6">
                                                <div>
                                                    <span style="color:red;">*</span> USD Cut Price (MRP)
                                                    <input type="text" class="form-control"
                                                        placeholder="Enter USD Cut Price" inputmode="decimal"
                                                        oninput="this.value = this.value
                                                            .replace(/[^0-9.]/g,'')        // allow digits & dot
                                                            .replace(/(\..*?)\..*/g,'$1')  // keep only the first dot
                                                            .replace(/^(\.)/,'0.')         // '.5' -> '0.5'
                                                          "
                                                        maxlength="5" name="usd_cut_price" autocomplete="off"
                                                        value="{{ old('usd_cut_price') }}" required autocomplete="off">
                                                    @error('usd_cut_price')
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="col-lg-3 col-md-6">
                                                <div class="mt-4">
                                                    <input type="checkbox" name="isBestSeller" id="isBestSeller">
                                                    Bestsellers
                                                </div>
                                            </div>

                                            <div class="col-lg-3 col-md-6">
                                                <div class="mt-4">
                                                    <input type="checkbox" name="isNewArrival" id="isNewArrival">
                                                    New Arrivals
                                                </div>
                                            </div>

                                            <div class="col-lg-3 col-md-6">
                                                <div class="mt-4">
                                                    <input type="checkbox" name="isGiftBoxes" id="isGiftBoxes">
                                                    Gift Boxes
                                                </div>
                                            </div>

                                            <div class="col-lg-3 col-md-6">
                                                <div class="mt-4">
                                                    <input type="checkbox" name="isComboPacks" id="isComboPacks">
                                                    Combo Packs
                                                </div>
                                            </div>

                                            <div class="col-lg-12 col-md-6">
                                                <span style="color:red;"></span> Description
                                                <textarea class="form-control ckeditor" name="description" id="description" rows="6"></textarea>
                                                @error('description')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>

                                            <div class="col-lg-6 col-md-6">
                                                <span style="color:red;"></span>Meta Title
                                                <textarea class="form-control" name="meta_title" id="meta_title" rows="6"></textarea>
                                            </div>

                                            <div class="col-lg-6 col-md-6">
                                                <span style="color:red;"></span>Meta Keyword
                                                <textarea class="form-control" name="meta_keyword" id="meta_keyword" rows="6"></textarea>
                                            </div>

                                            <div class="col-lg-12 col-md-6">
                                                <span style="color:red;"></span>Meta Description
                                                <textarea class="form-control" name="meta_description" id="meta_description" rows="6"></textarea>
                                            </div>

                                            <div class="col-lg-6 col-md-6">
                                                <span style="color:red;"></span>Head
                                                <textarea class="form-control" name="head" id="head" rows="6"></textarea>
                                            </div>

                                            <div class="col-lg-6 col-md-6">
                                                <span style="color:red;"></span>Body
                                                <textarea class="form-control" name="body" id="body" rows="6"></textarea>
                                            </div>

                                        </div>
                                        <div class="card-footer mt-5" style="float: right;">
                                            <button type="submit"
                                                class="btn btn-primary btn-user float-right mb-3 mx-2">Save</button>
                                            <a class="btn btn-primary float-right mr-3 mb-3 mx-2"
                                                href="{{ route('product.index') }}">Cancel</a>
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


    <script src="https://cdn.ckeditor.com/4.12.1/standard/ckeditor.js"></script>

    <script>
        function validateFile() {
            var allowedExtension = ['jpeg', 'jpg', 'png', 'webp'];
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

    <script>
        function validatecategory() {
            var Category = $('#categoryId').val();
            var url = "{{ route('product.getsubcategory') }}";
            $.ajax({
                url: url,
                type: 'GET',
                data: {
                    Category,
                    Category
                },
                success: function(data) {
                    console.log(data);
                    $("#subcategoryid").html(data);
                }
            });
        }

        $(document).ready(function() {
            $('#regForm').on('submit', function() {
                // Disable the submit button to prevent multiple submissions
                $(this).find(':submit').prop('disabled', true);
            });
        });
    </script>

@endsection
