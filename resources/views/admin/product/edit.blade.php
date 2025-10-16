@extends('layouts.app')

@section('title', 'Edit Product')

@section('content')

    <script src="https://cdn.ckeditor.com/4.12.1/standard/ckeditor.js"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid">

                {{-- Alert Messages --}}
                @include('common.alert')

                <div class="row">
                    <div class="col-12">
                        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                            <h4 class="mb-sm-0">Edit Product</h4>
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
                                        action="{{ route('product.update', $product->id) }}" enctype="multipart/form-data">
                                        @csrf
                                        <div class="row gy-4">

                                            <div class="col-lg-4 col-md-6">
                                                <div>
                                                    <span style="color:red;">*</span>Category
                                                    <select class="form-control" onchange="validatecategory();"
                                                        name="categoryId" id="categoryId" required>
                                                        <option value="">Select Category Name
                                                        </option>
                                                        @foreach ($Category as $category)
                                                            <option value="{{ $category->id }}"
                                                                {{ $product->categoryId == $category->id ? 'selected' : '' }}>
                                                                {{ $category->categoryname }}</option>
                                                        @endforeach
                                                    </select>
                                                    @error('categoryId')
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="col-lg-4 col-md-6">
                                                <div>
                                                    <span style="color:red;">*</span>Product Name
                                                    <input type="text" class="form-control"
                                                        placeholder="Enter Product Name" name="productname"
                                                        autocomplete="off" maxlength="255"
                                                        value="{{ $product->productname }}" required>
                                                    @error('productname')
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>

                                            <?php
                                            $ProductImages = \App\Models\Productphotos::select('productphotosid', 'strphoto')
                                                ->where(['productphotos.iStatus' => 1, 'productphotos.isDelete' => 0, 'productid' => $product->id])
                                                ->get();
                                            $arr = [];
                                            foreach ($ProductImages as $value) {
                                                $arr[] = $value->strphoto;
                                            }
                                            ?>


                                            <div class="col-lg-4 col-md-6">
                                                <div>
                                                    <span style="color:red;">*</span>Multiple Photo (Upto 5)
                                                    <input type="file" name="photo[]" multiple class="form-control"
                                                        id="Editphoto">
                                                    {{--  <input type="hidden" name="hiddenPhoto" class="form-control"
                                                        value="{{ old('photo') ? old('photo') : $product->photo }}"
                                                        id="hiddenPhoto">  --}}

                                                    <div class="d-flex justify-content-between mt-3 mb-3">
                                                        @foreach ($ProductImages as $ProductImage)
                                                            <?php if (in_array($ProductImage->strphoto, $arr)){ ?>
                                                            <div id="PHOTOID_<?= $ProductImage->productphotosid ?>">
                                                                <img src="{{ asset('uploads/product/thumbnail/') . '/' . $ProductImage->strphoto }}"
                                                                    width="50px" height="50px">

                                                                <button type="button"
                                                                    onclick="imagedelete(<?= $ProductImage->productphotosid ?>);"
                                                                    class="btn btn-link p-0">
                                                                    <span class="text-500 fas fa-trash-alt"></span>
                                                                </button>

                                                            </div> &nbsp;&nbsp;&nbsp;&nbsp;
                                                            <?php }?>
                                                        @endforeach
                                                    </div>
                                                </div>

                                            </div>

                                            <div class="col-lg-3 col-md-6">
                                                <div>
                                                    <span style="color:red;">*</span> Rate (MRP)
                                                    <input type="text" class="form-control" placeholder="Enter Rate"
                                                        oninput="this.value = this.value.replace(/[^0-9]/g, '').replace(/(\..*?)\..*/g, '$1');"
                                                        maxlength="5" name="rate" autocomplete="off"
                                                        value="{{ $product->rate }}" required>
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
                                                        value="{{ $product->cut_price }}" required>
                                                    @error('cut_price')
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="col-lg-3 col-md-6">
                                                <div>
                                                    <span style="color:red;">*</span>USD Rate (MRP)
                                                    <input type="text" class="form-control" placeholder="Enter USD Rate"
                                                        inputmode="decimal"
                                                        oninput="this.value = this.value
                                                            .replace(/[^0-9.]/g,'')        // allow digits & dot
                                                            .replace(/(\..*?)\..*/g,'$1')  // keep only the first dot
                                                            .replace(/^(\.)/,'0.')         // '.5' -> '0.5'
                                                          "
                                                        maxlength="5" name="usd_rate" autocomplete="off"
                                                        value="{{ $product->usd_rate }}" required>
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
                                                        value="{{ $product->usd_cut_price }}" required>
                                                    @error('usd_cut_price')
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>


                                            <div class="col-lg-3 col-md-6">
                                                <div class="mt-4">
                                                    <input type="checkbox" name="isBestSeller" id="isBestSeller"
                                                        {{ $product->isBestSeller == 1 ? 'checked' : null }}>
                                                    Bestsellers
                                                </div>
                                            </div>

                                            <div class="col-lg-3 col-md-6">
                                                <div class="mt-4">
                                                    <input type="checkbox" name="isNewArrival" id="isNewArrival"
                                                        {{ $product->isNewArrival == 1 ? 'checked' : null }}>
                                                    New Arrivals
                                                </div>
                                            </div>

                                            <div class="col-lg-3 col-md-6">
                                                <div class="mt-4">
                                                    <input type="checkbox" name="isGiftBoxes" id="isGiftBoxes"
                                                        {{ $product->isGiftBoxes == 1 ? 'checked' : null }}>
                                                    Gift Boxes
                                                </div>
                                            </div>

                                            <div class="col-lg-3 col-md-6">
                                                <div class="mt-4">
                                                    <input type="checkbox" name="isComboPacks" id="isComboPacks"
                                                        {{ $product->isComboPacks == 1 ? 'checked' : null }}>
                                                    Combo Packs
                                                </div>
                                            </div>

                                            <div class="col-lg-12 col-md-6">
                                                <span style="color:red;"></span>Description
                                                <textarea class="form-control ckeditor" name="description" id="description" rows="6">{{ $product->description }}</textarea>

                                            </div>

                                            <div class="col-lg-6 col-md-6">
                                                <span style="color:red;"></span>Meta Title
                                                <textarea class="form-control" name="meta_title" id="meta_title" rows="6">
                                                    {{ $product->meta_title }}
                                                </textarea>

                                            </div>

                                            <div class="col-lg-6 col-md-6">
                                                <span style="color:red;"></span>Meta Keyword
                                                <textarea class="form-control" name="meta_keyword" id="meta_keyword" rows="6">{{ $product->meta_keyword }}</textarea>

                                            </div>

                                            <div class="col-lg-12 col-md-6">
                                                <span style="color:red;"></span>Meta Description
                                                <textarea class="form-control" name="meta_description" id="meta_description" rows="6">{{ $product->meta_description }}</textarea>
                                            </div>

                                            <div class="col-lg-6 col-md-6">
                                                <span style="color:red;"></span>Head
                                                <textarea class="form-control" name="head" id="head" rows="6">{{ $product->head }}</textarea>
                                            </div>

                                            <div class="col-lg-6 col-md-6">
                                                <span style="color:red;"></span>Body
                                                <textarea class="form-control" name="body" id="body" rows="6">{{ $product->body }}</textarea>
                                            </div>

                                        </div>
                                        <div class="card-footer mt-5" style="float: right;">
                                            <button type="submit"
                                                class="btn btn-primary btn-user float-right mb-3 mx-2">Update</button>
                                            <a class="btn btn-primary float-right mr-3 mb-3 mx-2"
                                                href="{{ route('product.edit', $product->id) }}">Cancel</a>
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
            var allowedExtension = ['jpeg', 'jpg', 'png', 'webp'];
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

        $(document).ready(function() {
            $('#regForm').on('submit', function() {
                // Disable the submit button to prevent multiple submissions
                $(this).find(':submit').prop('disabled', true);
            });
        });
    </script>

    <script>
        function imagedelete(id) {
            var url = "{{ route('product.imagedelete', ':id') }}";
            url = url.replace(":id", id);
            if (id) {
                $.ajax({
                    url: url,
                    type: 'POST',
                    data: {
                        id: id,
                        "_token": "{{ csrf_token() }}",
                    },
                    success: function(data) {
                        console.log(data);
                        var obj = JSON.parse(data);
                        $("#PHOTOID_" + id).html("");
                    }
                });
            }
        }
    </script>

    <script>
        function validatecategory() {
            var Category = $('#categoryId').val();
            var url = "{{ route('product.getEditsubcategory') }}";
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
    </script>


@endsection
