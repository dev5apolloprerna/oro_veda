@extends('layouts.app')
@section('title', 'Attribute List')
@section('content')

    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid">

                {{-- Alert Messages --}}
                @include('common.alert')

                @if ($errors->any())
                    {{--  <h5 style="color:red">Following errors exists in your excel file</h5>  --}}
                    <ol>
                        @foreach ($errors->all() as $error)
                            <p style="color:red">{{ $error }}</p>
                        @endforeach
                    </ol>
                @endif

                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-header" style="display: flex;justify-content: space-between;">
                                <div>
                                    <h5 class="card-title mb-0">Add Product Attribute</h5>
                                </div>
                                <div>
                                    <a href="#" data-bs-toggle="modal" title="Add New" data-bs-target="#AddModal"
                                        class="btn btn-sm btn-primary mx-2">
                                        <i class="fa-solid fa-plus"></i> Add New
                                    </a>
                                    <a href="{{ route('product.index') }}" class="btn btn-sm btn-primary mx-2">
                                        Back
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="modal fade flip" id="AddModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header bg-light p-3">
                                <h5 class="modal-title" id="exampleModalLabel">Add Product Attribute</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                                    id="close-modal"></button>
                            </div>
                            <form id="regForm" action="{{ route('product.product_attribute_store') }}" method="post"
                                onsubmit="return validateFile()" enctype="multipart/form-data">
                                @csrf

                                <div class="modal-body">

                                    <input type="hidden" name="productid" value="{{ $id }}">
                                    <div class="mb-3">
                                        <span style="color:red;">*</span>Product
                                        <select class="form-control" name="product_attribute_id" id="">
                                            <option value="">Select Product</option>
                                            @foreach ($Attribute as $attribute)
                                                <option value="{{ $attribute->id }}">{{ $attribute->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    {{--  <div class="mb-3">
                                        <span style="color:red;">*</span>Product Size
                                        <select class="form-control" name="product_attribute_size" required>
                                            <option value="">Select Product Size</option>
                                            <option value="S">S</option>
                                            <option value="M">M</option>
                                            <option value="L">L</option>
                                            <option value="XL">XL</option>
                                            <option value="2XL">2XL</option>
                                            <option value="3XL">3XL</option>
                                            <option value="4XL">4XL</option>
                                            <option value="5XL">5XL</option>
                                        </select>
                                        <!--<input type="text" class="form-control" name="product_attribute_size"-->
                                        <!--    placeholder="Enter Product Size" maxlength="100" autocomplete="off" required>-->
                                        @error('product_attribute_size')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>  --}}

                                    <div class="mb-3">
                                        <span style="color:red;">*</span>Product Qty
                                        <input type="text" class="form-control" name="product_attribute_qty"
                                            placeholder="Enter Product Qty" maxlength="5" autocomplete="off"
                                            oninput="this.value = this.value.replace(/[^0-9]/g, '').replace(/(\..*?)\..*/g, '$1');"
                                            required>
                                        @error('product_attribute_qty')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <span style="color:red;">*</span>Product Price
                                        <input type="text" class="form-control" name="product_attribute_price"
                                            oninput="this.value = this.value.replace(/[^0-9]/g, '').replace(/(\..*?)\..*/g, '$1');"
                                            placeholder="Enter Product Price" maxlength="100" autocomplete="off" required>
                                        @error('product_attribute_price')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <!--<div class="mb-3">-->
                                    <!--    <span style="color:red;"></span>Attribute Photo-->
                                    <!--    <input class="form-control" type="file" name="product_attribute_photo"-->
                                    <!--        id="strPhoto">-->
                                    <!--    <div id="viewimg">-->

                                    <!--    </div>-->
                                    <!--</div>-->

                                </div>
                                <div class="modal-footer">
                                    <div class="hstack gap-2 justify-content-end">
                                        <button type="submit" class="btn btn-primary mx-2" id="add-btn">Submit
                                        </button>
                                        <button type="button" class="btn btn-primary mx-2" data-bs-dismiss="modal">Cancel
                                        </button>
                                    </div>
                                </div>

                            </form>
                        </div>
                    </div>
                </div>


                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title mb-0">Product Name :- {{ $Product->productname }}</h5>
                                <h5 class="card-title mb-0">
                                    <a href="{{ asset('uploads/product/thumbnail/') . '/' . $Product->photo }}"
                                        target="_blank">
                                        <img class="img-1" height="50" width="50"
                                            src="{{ asset('uploads/product/thumbnail/') . '/' . $Product->photo }}">
                                    </a>
                                </h5>
                            </div>
                            <div class="card-body">

                                <table id="scroll-horizontal" class="table nowrap align-middle" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th scope="col">No</th>
                                            <th scope="col">Size </th>
                                            {{--  <th scope="col">Product Attribute Size</th>  --}}
                                            <!--<th scope="col">Product Attribute Photo</th>-->
                                            <th scope="col"> Qty</th>
                                            <th scope="col"> Price</th>
                                            <th scope="col">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $i = 1; ?>
                                        @foreach ($ProductAttributes as $data)
                                            <tr class="text-center">
                                                <td>{{ $i + $ProductAttributes->perPage() * ($ProductAttributes->currentPage() - 1) }}
                                                </td>
                                                <td>{{ $data->name }}</td>
                                                {{--  <td>{{ $data->product_attribute_size }}</td>  --}}
                                                <!--<td>-->
                                                <!--    <?php if($data->product_attribute_photo){ ?>-->
                                                <!--    <img src="{{ asset('ProductAttribute') . '/' . $data->product_attribute_photo }}"-->
                                                <!--        style="width: 50px;height: 50px;">-->
                                                <!--    <?php }else{ ?>-->
                                                <!--    <img src="{{ asset('assets/images/noimage.png') }}"-->
                                                <!--        style="width: 50px;height: 50px;">-->
                                                <!--    <?php } ?>-->
                                                <!--</td>-->
                                                <td>{{ $data->product_attribute_qty }}</td>
                                                <td>{{ $data->product_attribute_price }}</td>
                                                {{--  <td>{{ $data->product_attribute_price }}</td>  --}}
                                                <td>
                                                    <div class=" gap-2">
                                                        <a class="mx-1" title="Edit" href="#"
                                                            onclick="getEditData(<?= $data->id ?>)" data-bs-toggle="modal"
                                                            data-bs-target="#showModal">
                                                            <i class="far fa-edit"></i>
                                                        </a>
                                                        <a class="" href="#" data-bs-toggle="modal"
                                                            title="Delete" data-bs-target="#deleteRecordModal"
                                                            onclick="deleteData(<?= $data->id ?>);">
                                                            <i class="fa fa-trash" aria-hidden="true"></i>
                                                        </a>

                                                    </div>
                                                </td>
                                            </tr>
                                            <?php $i++; ?>
                                        @endforeach
                                    </tbody>
                                </table>
                                <div class="d-flex justify-content-center mt-3">
                                    {{ $ProductAttributes->links() }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!--Edit Modal Start-->
                <div class="modal fade flip" id="showModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header bg-light p-3">
                                <h5 class="modal-title" id="exampleModalLabel">Edit Attribute</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                                    id="close-modal"></button>
                            </div>
                            <form id="EditregForm" method="POST"
                                action="{{ route('product.product_attribute_update') }}" autocomplete="off"
                                enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="attributeid" id="attributeid" value="">

                                <div class="modal-body">

                                    {{--  <div class="mb-3">
                                        <span style="color:red;">*</span>Product Size
                                        <select class="form-control" name="product_attribute_size"
                                            id="Editproduct_attribute_size" required>
                                            <option value="">Select Product Size</option>
                                            <option value="S">S</option>
                                            <option value="M">M</option>
                                            <option value="L">L</option>
                                            <option value="XL">XL</option>
                                            <option value="2XL">2XL</option>
                                            <option value="3XL">3XL</option>
                                            <option value="4XL">4XL</option>
                                            <option value="5XL">5XL</option>
                                        </select>
                                        @error('product_attribute_size')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>  --}}

                                    <div class="mb-3">
                                        <span style="color:red;">*</span>Product Qty
                                        <input type="text" class="form-control" name="product_attribute_qty"
                                            id="Editproduct_attribute_qty"
                                            oninput="this.value = this.value.replace(/[^0-9]/g, '').replace(/(\..*?)\..*/g, '$1');"
                                            placeholder="Enter Attribute Price" maxlength="5" autocomplete="off"
                                            required>
                                        @error('product_attribute_qty')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <span style="color:red;">*</span>Attribute Price
                                        <input type="text" class="form-control" name="product_attribute_price"
                                            id="Editproduct_attribute_price"
                                            oninput="this.value = this.value.replace(/[^0-9]/g, '').replace(/(\..*?)\..*/g, '$1');"
                                            placeholder="Enter Attribute Price" maxlength="100" autocomplete="off"
                                            required>
                                        @error('product_attribute_price')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <div class="hstack gap-2 justify-content-end">
                                        <button type="submit" class="btn btn-primary mx-2"
                                            id="add-btn">Update</button>
                                        <button type="button" class="btn btn-primary mx-2"
                                            data-bs-dismiss="modal">Cancel</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <!--Edit Modal End -->


                <!--Delete Modal Start -->
                <div class="modal fade zoomIn" id="deleteRecordModal" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                                    id="btn-close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="mt-2 text-center">
                                    <lord-icon src="https://cdn.lordicon.com/gsqxdxog.json" trigger="loop"
                                        colors="primary:#f7b84b,secondary:#f06548" style="width:100px;height:100px">
                                    </lord-icon>
                                    <div class="mt-4 pt-2 fs-15 mx-4 mx-sm-5">
                                        <h4>Are you Sure ?</h4>
                                        <p class="text-muted mx-4 mb-0">Are you Sure You want to Remove this Record
                                            ?</p>
                                    </div>
                                </div>
                                <div class="d-flex gap-2 justify-content-center mt-4 mb-2">
                                    <a class="btn btn-primary mx-2" href="{{ route('logout') }}"
                                        onclick="event.preventDefault(); document.getElementById('user-delete-form').submit();">
                                        Yes,
                                        Delete It!
                                    </a>
                                    <button type="button" class="btn w-sm btn-primary mx-2"
                                        data-bs-dismiss="modal">Close</button>
                                    <form id="user-delete-form" method="POST"
                                        action="{{ route('product.product_attribute_delete') }}">
                                        @csrf
                                        @method('DELETE')
                                        <input type="hidden" name="id" id="deleteid" value="">

                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--Delete modal End -->

            </div>
        </div>
    </div>
@endsection

@section('scripts')

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

        $(document).ready(function() {
            $('#EditregForm').on('submit', function() {
                // Disable the submit button to prevent multiple submissions
                $(this).find(':submit').prop('disabled', true);
            });
        });
    </script>

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

    {{-- Edit photo --}}
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
        $("#Editphoto").change(function() {
            html =
                '<img src="' + readURL(this) +
                '"   id="hello" width="70px" height = "70px" > ';
            $('#PHOTOID').html(html);
        });
    </script>

    <script>
        function deleteData(id) {
            $("#deleteid").val(id);
        }
    </script>

    <script>
        function getEditData(id) {
            var url = "{{ route('product.product_attribute_editview', ':id') }}";
            url = url.replace(":id", id);
            if (id) {
                $.ajax({
                    url: url,
                    type: 'GET',
                    data: {
                        id,
                        id
                    },
                    success: function(data) {
                        var obj = JSON.parse(data);
                        $("#Editproduct_attribute_qty").val(obj.product_attribute_qty);
                        $("#Editproduct_attribute_price").val(obj.product_attribute_price);
                        $("#Editproduct_attribute_size").val(obj.product_attribute_size);
                        $('#attributeid').val(id);
                    }
                });
            }
        }
    </script>


@endsection
