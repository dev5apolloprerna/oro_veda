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
                                <h5 class="card-title mb-0">Add attribute</h5>
                                <a href="#" data-bs-toggle="modal" title="Delete" data-bs-target="#AddModal"
                                    class="btn btn-sm btn-primary">
                                    <i data-feather="plus"></i> Add New
                                </a>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="modal fade flip" id="AddModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header bg-light p-3">
                                <h5 class="modal-title" id="exampleModalLabel">Add Attribute</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                                    id="close-modal"></button>
                            </div>
                            <form id="regForm" action="{{ route('attribute.store') }}" method="post">
                                @csrf

                                <div class="modal-body">

                                    <div class="mb-3">
                                        <span style="color:red;">*</span>Name
                                        <input type="text" class="form-control" name="name" placeholder="Enter Name"
                                            maxlength="100" autocomplete="off" required>
                                    </div>

                                    <div class="mb-3">
                                        <span style="color:red;">*</span>Display As
                                        <select class="form-control" name="display_as" id="display_as" required>
                                            <option value="">Select Display As</option>
                                            <option value="IMAGE">Image</option>
                                            <option value="TEXT">Text</option>
                                        </select>
                                    </div>

                                </div>
                                <div class="modal-footer">
                                    <div class="hstack gap-2 justify-content-end">
                                        <button type="submit" class="btn btn-primary mx-2" id="add-btn">Submit</button>
                                        <button type="button" class="btn btn-primary mx-2"
                                            data-bs-dismiss="modal">Cancel</button>
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
                                <h5 class="card-title mb-0">Attribute List</h5>
                            </div>
                            <div class="card-body">

                                <table id="scroll-horizontal" class="table nowrap align-middle" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th scope="col">No</th>
                                            <th scope="col">Name</th>
                                            <th scope="col">Display As</th>
                                            <th scope="col">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $i = 1; ?>
                                        @foreach ($Attribute as $data)
                                            <tr class="text-center">
                                                <td>{{ $i + $Attribute->perPage() * ($Attribute->currentPage() - 1) }}
                                                </td>
                                                <td>{{ $data->name }}</td>
                                                <td>{{ $data->display_as }}</td>
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
                                    {{ $Attribute->links() }}
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
                            <form id="EditregForm" onsubmit="return EditvalidateFile()" method="POST"
                                action="{{ route('attribute.update') }}" autocomplete="off"
                                enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="id" id="attributeid" value="">

                                <div class="modal-body">

                                    <div class="mb-3">
                                        <span style="color:red;">*</span>Name
                                        <input type="text" class="form-control" name="name" id="Editname"
                                            placeholder="Enter Name" maxlength="100" autocomplete="off" required>
                                    </div>

                                    <div class="mb-3">
                                        <span style="color:red;">*</span>Display As
                                        <select class="form-control" name="display_as" id="Editdisplay_as" required>
                                            <option value="">Select Display As</option>
                                            <option value="IMAGE">Image</option>
                                            <option value="TEXT">Text</option>
                                        </select>
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
                                    <form id="user-delete-form" method="POST" action="{{ route('attribute.delete') }}">
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

    <script>
        function getEditData(id) {
            //alert(id);
            var url = "{{ route('attribute.edit', ':id') }}";
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
                        $("#Editname").val(obj.name);
                        $("#Editdisplay_as").val(obj.display_as);
                        $('#attributeid').val(id);
                    }
                });
            }
        }
        
         $(document).ready(function() {
            $('#regForm').on('submit', function () {
                // Disable the submit button to prevent multiple submissions
                $(this).find(':submit').prop('disabled', true);
            });
        });
        
        $(document).ready(function() {
            $('#EditregForm').on('submit', function () {
                // Disable the submit button to prevent multiple submissions
                $(this).find(':submit').prop('disabled', true);
            });
        });
    </script>

    <script>
        function deleteData(id) {
            $("#deleteid").val(id);
        }
    </script>
@endsection
