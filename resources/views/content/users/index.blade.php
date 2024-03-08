@extends('layouts/layoutMaster')

@section('title', 'User List - Pages')

@section('vendor-style')
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/select2/select2.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/@form-validation/umd/styles/index.min.css') }}" />

@endsection

@section('vendor-script')
    <script src="{{ asset('assets/vendor/libs/moment/moment.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/select2/select2.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/@form-validation/umd/bundle/popular.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/@form-validation/umd/plugin-bootstrap5/index.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/@form-validation/umd/plugin-auto-focus/index.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/cleavejs/cleave.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/cleavejs/cleave-phone.js') }}"></script>
@endsection

@section('page-script')
    <script>
        $(document).ready(function() {
            var table = $('#table-users').DataTable({
                language: {
                    url: '//cdn.datatables.net/plug-ins/1.13.7/i18n/fr-FR.json',
                    // search: "Filtrer par: ",
                    // searchPlaceholder: "Nom compte, Nom contact, Chargé ...",
                },
                ajax: '{!! route('users-datatable') !!}',
                "processing": true,
                "serverSide": true,
                columns: [{
                        data: 'id',
                        visible: false
                    },
                    {
                        data: 'name'
                    },
                    {
                        data: 'email'
                    },
                    {
                        data: 'status_icon'
                    },
                    {
                        "data": null,
                        "render": function(data, type, row) {
                            console.log(data);
                            if (data.status) {
                                return `
                <button class="suspend-btn btn btn-sm btn-danger waves-effect waves-light" data-user-id="${data.id}" style="width: 120px;">Suspend</button>
                `;
                            }
                            if (!data.status) {
                                return `
                <button class="unsuspend-btn btn btn-sm btn-success waves-effect waves-light" data-user-id="${data.id}" style="width: 120px;">Unsuspend</button>
                `;
                            }
                        }
                    },

                ],
            });

            $('#table-users tbody').on('click', '.suspend-btn', function() {
                console.log('eeee');
                var userId = $(this).data('user-id');
                $.ajax({
                    url: '/users/' + userId + '/suspend',
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                    },
                    success: function(response) {
                        // Update table data if needed
                        table.ajax.reload();
                        console.log(response);
                        console.log('eee');
                    },
                    error: function(xhr, status, error) {
                        // Handle errors if needed
                    }
                });
            });
            $('#table-users tbody').on('click', '.unsuspend-btn', function() {
                console.log('eeee');
                var userId = $(this).data('user-id');
                $.ajax({
                    url: '/users/' + userId + '/unsuspend',
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                    },
                    success: function(response) {
                        // Update table data if needed
                        table.ajax.reload();
                        console.log(response);
                        console.log('eee');
                    },
                    error: function(xhr, status, error) {
                        // Handle errors if needed
                    }
                });
            });
        });

        // $(document).ready(function() {
        //     var table = $('#table-users').dataTable({
        //         language: {
        //             url: '//cdn.datatables.net/plug-ins/1.13.7/i18n/fr-FR.json',
        //             // search: "Filtrer par: ",
        //             // searchPlaceholder: "Nom compte, Nom contact, Chargé ...",
        //         },
        //         ajax: '{!! route('users-datatable') !!}',
        //         "processing": true,
        //         "serverSide": true,
        //         columns: [{
        //                 data: 'id',
        //                 visible: false
        //             },
        //             {
        //                 data: 'name'
        //             },
        //             {
        //                 data: 'email'
        //             },
        //             {
        //                 data: 'status_icon'
        //             },
        //             {
        //                 "data": null,
        //                 "render": function(data, type, row) {
        //                     console.log(data);
        //                     if (data.status) {
        //                         return `
    //                 <button class="suspend-btn btn btn-sm btn-danger waves-effect waves-light" data-user-id="${data.id}" style="width: 120px;">Suspend</button>
    //                 `;
        //                     }
        //                     if (!data.status) {
        //                         return `
    //                 <button class="unsuspend-btn btn btn-sm btn-success waves-effect waves-light" data-user-id="${data.id}" style="width: 120px;">Unsuspend</button>
    //                 `;
        //                     }
        //                 }
        //             },

        //         ],
        //     });

        //     $('#table-users tbody').on('click', '.suspend-btn', function() {
        //         console.log('eeee');
        //         var userId = $(this).data('user-id');
        //         $.ajax({
        //             url: '/users/' + userId + '/suspend',
        //             method: 'POST',
        //             data: {
        //                 _token: '{{ csrf_token() }}',
        //             },
        //             success: function(response) {
        //                 // Update table data if needed
        //                 table.ajax.reload();
        //                 console.log(response);
        //                 console.log('eee');
        //             },
        //             error: function(xhr, status, error) {
        //                 // Handle errors if needed
        //             }
        //         });
        //     });
        //     $('#table-users tbody').on('click', '.unsuspend-btn', function() {
        //         console.log('eeee');
        //         var userId = $(this).data('user-id');
        //         $.ajax({
        //             url: '/users/' + userId + '/unsuspend',
        //             method: 'POST',
        //             data: {
        //                 _token: '{{ csrf_token() }}',
        //             },
        //             success: function(response) {
        //                 // Update table data if needed
        //                 table.ajax.reload();
        //                 console.log(response);
        //                 console.log('eee');
        //             },
        //             error: function(xhr, status, error) {
        //                 // Handle errors if needed
        //             }
        //         });
        //     });
        // });
    </script>
@endsection

@section('content')

    <!-- Users List Table -->
    <div class="card">
        {{-- <div class="card-header border-bottom">
            <h5 class="card-title mb-3">Liste des utilisateurs</h5>
            <div class="d-flex justify-content-between align-items-center row pb-2 gap-3 gap-md-0">
                <div class="col-md-4 user_role"></div>
                <div class="col-md-4 user_plan"></div>
                <div class="col-md-4 user_status"></div>
            </div>
        </div> --}}
        <div class="card-datatable table-responsive">
          <div class="card-header flex-column flex-md-row">
            <div class="dt-action-buttons text-start pt-3 pt-md-0">
                <div class="dt-buttons btn-group flex-wrap">
                    <a class="btn btn-primary" href="/users/create">
                        <i class="ti ti-plus me-sm-1"></i>
                        <span class="d-none d-sm-inline-block">Créer un utilisateur</span>
                    </a>

                </div>
            </div>
        </div>
            <table class="datatables-users table" id="table-users">
                <thead class="border-top">
                    <tr>
                        <th>ID</th>
                        <th>Nom d'utilisateur</th>
                        <th>Email</th>
                        <th>Status</th>
                        <th>Action</th>
                        {{-- <th>Plan</th>
                        <th>Billing</th>
                        <th>Status</th>
                        <th>Actions</th> --}}
                    </tr>
                </thead>
            </table>
        </div>
        <script></script>
        <!-- Offcanvas to add new user -->
        <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasAddUser" aria-labelledby="offcanvasAddUserLabel">
            <div class="offcanvas-header">
                <h5 id="offcanvasAddUserLabel" class="offcanvas-title">Add User</h5>
                <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <div class="offcanvas-body mx-0 flex-grow-0 pt-0 h-100">
                <form class="add-new-user pt-0" id="addNewUserForm" onsubmit="return false">
                    <div class="mb-3">
                        <label class="form-label" for="add-user-fullname">Full Name</label>
                        <input type="text" class="form-control" id="add-user-fullname" placeholder="John Doe"
                            name="userFullname" aria-label="John Doe" />
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="add-user-email">Email</label>
                        <input type="text" id="add-user-email" class="form-control" placeholder="john.doe@example.com"
                            aria-label="john.doe@example.com" name="userEmail" />
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="add-user-contact">Contact</label>
                        <input type="text" id="add-user-contact" class="form-control phone-mask"
                            placeholder="+1 (609) 988-44-11" aria-label="john.doe@example.com" name="userContact" />
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="add-user-company">Company</label>
                        <input type="text" id="add-user-company" class="form-control" placeholder="Web Developer"
                            aria-label="jdoe1" name="companyName" />
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="country">Country</label>
                        <select id="country" class="select2 form-select">
                            <option value="">Select</option>
                            <option value="Australia">Australia</option>
                            <option value="Bangladesh">Bangladesh</option>
                            <option value="Belarus">Belarus</option>
                            <option value="Brazil">Brazil</option>
                            <option value="Canada">Canada</option>
                            <option value="China">China</option>
                            <option value="France">France</option>
                            <option value="Germany">Germany</option>
                            <option value="India">India</option>
                            <option value="Indonesia">Indonesia</option>
                            <option value="Italy">Italy</option>
                            <option value="Japan">Japan</option>
                            <option value="Korea">Korea, Republic of</option>
                            <option value="Mexico">Mexico</option>
                            <option value="Philippines">Philippines</option>
                            <option value="Russia">Russian Federation</option>
                            <option value="South Africa">South Africa</option>
                            <option value="Thailand">Thailand</option>
                            <option value="Turkey">Turkey</option>
                            <option value="Ukraine">Ukraine</option>
                            <option value="United Arab Emirates">United Arab Emirates</option>
                            <option value="United Kingdom">United Kingdom</option>
                            <option value="United States">United States</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="user-role">User Role</label>
                        <select id="user-role" class="form-select">
                            <option value="subscriber">Subscriber</option>
                            <option value="editor">Editor</option>
                            <option value="maintainer">Maintainer</option>
                            <option value="author">Author</option>
                            <option value="admin">Admin</option>
                        </select>
                    </div>
                    <div class="mb-4">
                        <label class="form-label" for="user-plan">Select Plan</label>
                        <select id="user-plan" class="form-select">
                            <option value="basic">Basic</option>
                            <option value="enterprise">Enterprise</option>
                            <option value="company">Company</option>
                            <option value="team">Team</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary me-sm-3 me-1 data-submit">Submit</button>
                    <button type="reset" class="btn btn-label-secondary" data-bs-dismiss="offcanvas">Cancel</button>
                </form>
            </div>
        </div>
    </div>

@endsection
