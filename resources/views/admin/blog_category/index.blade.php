@extends('layouts.app')

@section('title', 'Blog Category')

@section('content')

    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid">

                {{-- Alert Messages --}}
                @include('common.alert')

                <div class="row">
                    <!-- Left side - Add Form -->
                    <div class="col-lg-4">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title mb-0">Add Blog Category</h4>
                            </div>
                            <div class="card-body">
                                <form method="POST" action="{{ route('blog_category.store') }}" id="categoryForm">
                                    @csrf

                                    <div class="mb-3">
                                        <label for="strCategoryName" class="form-label">Category Name <span
                                                class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="strCategoryName"
                                            name="strCategoryName" maxlength="50" required autofocus autocomplete="off">
                                    </div>
                                    <div class="mb-3">
                                        <span style="color:red;"></span>Meta Title</label>
                                        <textarea class="form-control" name="meta_title" id="meta_title" rows="3"></textarea>
                                    </div>

                                    <div class="mb-3">
                                        <span style="color:red;"></span>Meta Keyword</label>
                                        <textarea class="form-control" name="meta_keyword" id="meta_keyword" rows="3"></textarea>
                                    </div>

                                    <div class="mb-3">
                                        <span style="color:red;"></span>Meta Description</label>
                                        <textarea class="form-control" name="meta_Description" id="meta_description" rows="3"></textarea>
                                    </div>

                                    <div class="mb-3">
                                        <span style="color:red;"></span>Head</label>
                                        <textarea class="form-control" name="head" id="head" rows="3"></textarea>
                                    </div>

                                    <div class="mb-3">
                                        <span style="color:red;"></span>Body</label>
                                        <textarea class="form-control" name="body" id="body" rows="3"></textarea>
                                    </div>


                                    <div class="d-flex ">
                                        <button type="submit" class="btn btn-success mx-2">Submit</button>
                                        <button type="reset" class="btn btn-success">Clear</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- Right side - Listing -->
                    <div class="col-lg-8">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between">
                                <h4 class="card-title mb-0">Blog Category List</h4>
                            </div>
                            <div class="card-body">

                                <table class="table table-bordered table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th>sr.no</th>
                                            <th>Category Name</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $i = 1; ?>
                                        @forelse($categories as $category)
                                            <tr class="text-center">
                                                <td>
                                                    {{ $i + $categories->perPage() * ($categories->currentPage() - 1) }}
                                                </td>
                                                <td>{{ $category->strCategoryName }}</td>
                                                <td>
                                                    {{-- Edit Icon --}}
                                                    <a class="mx-1" href="#" title="Edit"
                                                        onclick="editCategory('{{ $category->id }}', '{{ $category->strCategoryName }}', '{{ $category->strSlug }}','{{ $category->meta_title }}','{{ $category->meta_keyword }}','{{ $category->meta_Description }}','{{ $category->head }}','{{ $category->body }}')">
                                                        <i class="far fa-edit"></i>
                                                    </a>

                                                    {{-- Delete Icon --}}
                                                    <a class="mx-1" href="#" title="Delete"
                                                        onclick="if(confirm('Are you sure you want to delete this record?')) { document.getElementById('delete-form-{{ $category->id }}').submit(); } return false;">
                                                        <i class="fa fa-trash" aria-hidden="true"></i>
                                                    </a>

                                                    {{-- Hidden Delete Form --}}
                                                    <form id="delete-form-{{ $category->id }}" method="POST"
                                                        action="{{ route('blog_category.delete', $category->id) }}"
                                                        style="display:none;">
                                                        @csrf
                                                        @method('DELETE')
                                                    </form>
                                                    </form>
                                                </td>
                                            </tr>
                                            <?php $i++; ?>
                                        @empty
                                            <tr>
                                                <td colspan="4">No records found.</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                                <!-- </form> -->

                                {{ $categories->links() }}
                            </div>
                        </div>
                    </div>
                </div>

            </div> <!-- container-fluid -->
        </div> <!-- page-content -->
    </div> <!-- main-content -->

    <!-- Edit Modal -->
    <div class="modal fade" id="editCategoryModal" tabindex="-1" aria-labelledby="editCategoryModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <form method="POST" id="editCategoryForm">
                @csrf
                @method('PUT')
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Edit Blog Category</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">

                        <input type="hidden" name="id" id="editCategoryId">

                        <div class="mb-3">
                            <label for="editStrCategoryName" class="form-label">Category Name <span
                                    class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="editStrCategoryName" name="strCategoryName"
                                maxlength="50" required>
                        </div>

                        <div class="mb-3">
                            <span style="color:red;"></span>Meta Title</label>
                            <textarea class="form-control" name="meta_title" id="edit_meta_title" rows="3"></textarea>
                        </div>

                        <div class="mb-3">
                            <span style="color:red;"></span>Meta Keyword</label>
                            <textarea class="form-control" name="meta_keyword" id="edit_meta_keyword" rows="3"></textarea>
                        </div>

                        <div class="mb-3">
                            <span style="color:red;"></span>Meta Description</label>
                            <textarea class="form-control" name="meta_Description" id="edit_meta_description" rows="3"></textarea>
                        </div>

                        <div class="mb-3">
                            <span style="color:red;"></span>Head</label>
                            <textarea class="form-control" name="head" id="edit_head" rows="3"></textarea>
                        </div>

                        <div class="mb-3">
                            <span style="color:red;"></span>Body</label>
                            <textarea class="form-control" name="body" id="edit_body" rows="3"></textarea>
                        </div>

                    </div>
                    <div class="modal-footer d-flex">
                        <button type="submit" class="btn btn-success">Update</button>
                        <button type="button" class="btn btn-success" data-bs-dismiss="modal">Cancel</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

@endsection

@section('scripts')

    <script>
        // Open edit modal dynamically
        function editCategory(id, name, slug, meta_title, meta_keyword, meta_Description, head, body) {
            $('#editCategoryId').val(id);
            $('#editStrCategoryName').val(name);
            $('#edit_meta_title').val(meta_title);
            $('#edit_meta_keyword').val(meta_keyword);
            $('#edit_meta_description').val(meta_Description);
            $('#edit_head').val(head);
            $('#edit_body').val(body);
            $('#editCategoryForm').attr('action', `{{ url('admin/blog/category/update') }}/${id}`);
            $('#editCategoryModal').modal('show');
        }

        // Select all checkboxes
        $('#selectAll').on('click', function() {
            $('input[name="ids[]"]').prop('checked', this.checked);
        });
    </script>
@endsection
