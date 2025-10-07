@extends('layouts.app')
@section('title', 'Offer List')
@section('content')

    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid">

                {{-- Alert Messages --}}
                @include('common.alert')

                @if ($errors->any())
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
                                <h5 class="card-title mb-0">Offer List</h5>
                                <a href="{{ route('offer.create') }}" class="btn btn-sm btn-primary">
                                    <i data-feather="plus"></i> Add New
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">

                            <div class="card-body">

                                <table id="scroll-horizontal" class="table nowrap align-middle" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th scope="col">No</th>
                                            <th scope="col"> Text</th>
                                            <th scope="col"> Percentage (%) off</th>
                                            <th scope="col"> Photo </th>
                                            <th scope="col"> Offer Code</th>
                                            <th scope="col"> Min Value</th>
                                            <th scope="col">From Date</th>
                                            <th scope="col">To Date</th>
                                            <th scope="col">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $i = 1; ?>
                                        @foreach ($Offer as $data)
                                            <tr class="text-center">
                                                <td>{{ $i + $Offer->perPage() * ($Offer->currentPage() - 1) }}
                                                </td>
                                                <td>{{ $data->text }}</td>
                                                <td>{{ $data->percentage }}</td>
                                                <td>
                                                    @if ($data->photo)
                                                        <img src="{{ asset('uploads/offer') . '/' . $data->photo }}"
                                                            style="width: 50px;height: 50px;">
                                                    @else
                                                        <img src="{{ asset('assets/images/noimage.png') }}"
                                                            style="width: 50px;height: 50px;">
                                                    @endif
                                                </td>
                                                <td>{{ $data->offercode }}</td>
                                                <td>{{ $data->minvalue }}</td>
                                                <td>{{ date('d-m-Y', strtotime($data->startdate)) }}</td>
                                                <td>{{ date('d-m-Y', strtotime($data->enddate)) }}</td>
                                                <td>
                                                    <div class=" gap-2">
                                                        <a class="mx-1" title="Edit"
                                                            href="{{ route('offer.edit', $data->id) }}">
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
                                    {{ $Offer->links() }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

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
                                    <form id="user-delete-form" method="POST" action="{{ route('offer.delete') }}">
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
        function deleteData(id) {
            $("#deleteid").val(id);
        }
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

    <script>
        $('#showModal').on('shown.bs.modal', function() {
            $("#Editstartdatepicker, #Editenddatepicker").datepicker("refresh");
        });
    </script>

@endsection
