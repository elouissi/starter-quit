@php
    $crudType = 'F';
    $crudTitle = 'Fonction attendue';
@endphp

@extends('layouts/layoutMaster')

@section('title', 'Gestion de ' . Str::plural(strtolower($crudTitle)))

@section('vendor-style')
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/select2/select2.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/@form-validation/umd/styles/index.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/animate-css/animate.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/sweetalert2/sweetalert2.css') }}" />
    <style>
        .rotate {
            display: inline-block;
            animation: rotate 2s linear infinite;
        }

        @keyframes rotate {
            from {
                transform: rotate(0deg);
            }

            to {
                transform: rotate(360deg);
            }
        }
    </style>
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
    <script src="{{ asset('assets/vendor/libs/sweetalert2/sweetalert2.js') }}"></script>
@endsection

@section('page-script')
    <script>
        $(document).ready(function() {
            var dataTable = $('#table-datatable').DataTable({
                language: {
                    url: '//cdn.datatables.net/plug-ins/1.13.7/i18n/fr-FR.json',
                    // search: "Filtrer par: ",
                    // searchPlaceholder: "Nom compte, Nom contact, Chargé ...",
                },
                ajax: '{!! route('configuration.expectedfunction.datatable') !!}',
                "processing": true,
                "serverSide": true,
                columns: [{
                        data: 'id',
                    },
                    {
                        data: 'name'
                    },
                    {
                        data: 'order'
                    },
                    {
                        data: 'actions'
                    }
                ],
                drawCallback: function() {
                    const deleteFunctions = document.querySelectorAll('.delete-function');
                    deleteFunctions.forEach(deleteFunction => {
                        deleteFunction.onclick = function() {
                            const deleteButton = this;
                            const itemId = this.dataset.id;
                            Swal.fire({
                                title: 'Êtes-vous sûr(e) ?',
                                text: "Vous ne pourrez pas revenir en arrière !",
                                icon: 'warning',
                                showCancelButton: true,
                                confirmButtonText: 'Oui, supprimez-le !',
                                customClass: {
                                    confirmButton: 'btn btn-primary me-3 waves-effect waves-light',
                                    cancelButton: 'btn btn-label-secondary waves-effect waves-light'
                                },
                                buttonsStyling: false
                            }).then(function(result) {
                                if (result.value) {
                                    $(deleteButton).html(
                                            '<i class="ti ti-loader rotate"></i>')
                                        .prop('disabled', true);
                                    $.ajax({
                                        type: 'DELETE',
                                        url: `expectedfunction/${itemId}`,
                                        data: {
                                            '_token': '{{ csrf_token() }}',
                                            id: itemId
                                        },
                                        success: function(data) {
                                            Swal.fire({
                                                icon: 'success',
                                                title: 'Supprimé !',
                                                text: 'Votre {{ strtolower($crudTitle) }}  a été supprimé.',
                                                customClass: {
                                                    confirmButton: 'btn btn-success waves-effect waves-light'
                                                }
                                            });
                                            dataTable.ajax.reload();
                                        },
                                        error: function(error) {
                                            console.error('Erreur :',
                                                error);
                                            Swal.fire({
                                                icon: 'error',
                                                title: 'Oups...',
                                                text: 'Quelque chose s\'est mal passé !',
                                                customClass: {
                                                    confirmButton: 'btn btn-danger waves-effect waves-light'
                                                }
                                            });
                                        }
                                    });
                                }
                            });
                        };
                    });

                    const editFunctions = document.querySelectorAll('.edit-function');
                    editFunctions.forEach(editFunction => {
                        editFunction.onclick = function() {
                            $('#form-update-record').addClass(
                                'd-none');
                            $('#placeholder-form-update-record')
                                .removeClass('d-none');
                            const fields = ['name', 'order'];
                            fields.forEach(function(field) {
                                $(`#${field}-edit`).val(``);
                                $(`#${field}-update-error`).addClass('d-none');
                            });
                            const itemId = this.dataset.id;
                            $.ajax({
                                type: 'GET',
                                url: `expectedfunction/${itemId}/edit`,
                                data: {
                                    id: itemId
                                },
                                success: function(data) {
                                    $.each(data.result, function(key, value) {
                                        $(`#${key}-edit`).val(value);
                                    });
                                    $('#form-update-record').removeClass(
                                        'd-none');
                                    $('#placeholder-form-update-record')
                                        .addClass('d-none');
                                },
                                error: function(error) {
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Oups...',
                                        text: 'Quelque chose s\'est mal passé ! Veuillez contacter l\'équipe de support.',
                                        customClass: {
                                            confirmButton: 'btn btn-danger waves-effect waves-light'
                                        }
                                    });
                                }
                            });
                        }
                    })
                }
            });

            $("#form-update-record").submit(function(event) {
                event.preventDefault();
                $('.error-message').addClass('d-none').text('');
                $('#update-record-btn').prop('disabled', true).html(
                    `<i class="ti ti-loader rotate"></i>`);
                $('#close-offcanvas-edit').prop('disabled', true);
                var formData = $(this).serialize();
                var csrfToken = $('meta[name="csrf-token"]').attr('content');
                formData += '&_token=' + encodeURIComponent(csrfToken);
                var form = $(this);
                var idEdit = $('#id-edit').val();
                $.ajax({
                    type: 'PUT',
                    url: `expectedfunction/${idEdit}`,
                    data: formData,
                    success: function(response) {
                        form.trigger('reset');
                        $('#update-record-btn').prop('disabled', false).html(`Modifier`);
                        $('#close-offcanvas-edit').prop('disabled', false);
                        $('#close-offcanvas-edit').click();
                        Swal.fire({
                            icon: 'success',
                            title: 'Modifié !',
                            text: 'Votre {{ strtolower($crudTitle) }} a été modifié.',
                            customClass: {
                                confirmButton: 'btn btn-success waves-effect waves-light'
                            }
                        });
                        dataTable.ajax.reload();
                    },
                    error: function(xhr, status, error) {
                        $('#update-record-btn').prop('disabled', false).html(`Modifier`);
                        $('#close-offcanvas-edit').prop('disabled', false);

                        if (xhr.status == 422) {
                            $.each(xhr.responseJSON.errors, function(key, value) {
                                $(`#${key}-update-error`).removeClass('d-none').text(
                                    value);
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Oups...',
                                text: 'Quelque chose s\'est mal passé ! Veuillez contacter l\'équipe de support.',
                                customClass: {
                                    confirmButton: 'btn btn-danger waves-effect waves-light'
                                }
                            });
                        }
                    }
                });
            });

            $('#openOffcanvasAddRecord').click(function() {
                const fields = ['name', 'order'];
                fields.forEach(function(field) {
                    $(`#${field}-add-error`).addClass('d-none');
                });
            });

            $("#form-add-new-record").submit(function(event) {
                event.preventDefault();
                $('.error-message').addClass('d-none').text('');
                $('#add-new-record-btn').prop('disabled', true).html(
                    `<i class="ti ti-loader rotate"></i>`);
                $('#close-offcanvas-add').prop('disabled', true);
                var formData = $(this).serialize();
                var csrfToken = $('meta[name="csrf-token"]').attr('content');
                formData += '&_token=' + encodeURIComponent(csrfToken);
                var form = $(this);
                $.ajax({
                    url: '{!! route('configuration.expectedfunction.store') !!}',
                    type: "POST",
                    data: formData,
                    success: function(response) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Créé !',
                            text: 'Votre {{ strtolower($crudTitle) }} a été ajouté avec succès.',
                            customClass: {
                                confirmButton: 'btn btn-success waves-effect waves-light'
                            }
                        });
                        $('#add-new-record-btn').prop('disabled', false).html(`Ajouter`);
                        $('#close-offcanvas-add').prop('disabled', false);

                        form.trigger('reset');
                        $('#close-offcanvas-add').click();
                        dataTable.ajax.reload();
                    },
                    error: function(xhr, status, error) {
                        $('#add-new-record-btn').prop('disabled', false).html(`Ajouter`);
                        $('#close-offcanvas-add').prop('disabled', false);

                        if (xhr.status == 422) {
                            $.each(xhr.responseJSON.errors, function(key, value) {
                                $(`#${key}-add-error`).removeClass('d-none').text(
                                    value);
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Oups...',
                                text: 'Quelque chose s\'est mal passé ! Veuillez contacter l\'équipe de support.',
                                customClass: {
                                    confirmButton: 'btn btn-danger waves-effect waves-light'
                                }
                            });
                        }
                    }
                });
            });
        });
    </script>
@endsection

@section('content')

    <!-- Users List Table -->
    <div class="card">
        <div class="card-datatable table-responsive">
            <div class="card-header flex-column flex-md-row">
                <div class="dt-action-buttons text-start pt-3 pt-md-0">
                    <div class="dt-buttons btn-group flex-wrap">
                        <button class="btn btn-primary" type="button" data-bs-toggle="offcanvas"
                            id="openOffcanvasAddRecord" data-bs-target="#offcanvasAddRecord"
                            aria-controls="offcanvasAddRecord">
                            <i class="ti ti-plus me-sm-1"></i>
                            <span class="d-none d-sm-inline-block">Ajouter un{{ $crudType == 'F' ? 'e' : '' }}
                                {{ strtolower($crudTitle) }}</span>
                        </button>

                    </div>
                </div>
            </div>
            <table class="datatables-users table" id="table-datatable">
                <thead class="border-top">
                    <tr>
                        <th>ID</th>
                        <th>Nom</th>
                        <th>Order</th>
                        <th>Order</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
    <!-- Offcanvas to add record -->
    <div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasAddRecord" aria-labelledby="offcanvasAddRecordLabel">
        <div class="offcanvas-header">
            <h5 id="offcanvasAddRecordLabel" class="offcanvas-title">
                Ajouter un{{ $crudType == 'F' ? 'e' : '' }} {{ strtolower($crudTitle) }}
            </h5>
            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body mx-0 flex-grow-0">
            <form class="add-new-record pt-0 row g-2" id="form-add-new-record">
                <div class="col-sm-12 mb-3">
                    <label class="form-label" for="name">Nom</label>
                    <div class="input-group input-group-merge">
                        <span id="name2" class="input-group-text"><i class="ti ti-article"></i></span>
                        <input type="text" id="name" class="form-control" name="name" placeholder="Nom"
                            required />
                    </div>
                    <small id="name-add-error" class="text-danger d-none error-message"></small>
                </div>
                <div class="col-sm-12 mb-3">
                    <label class="form-label" for="order">Order</label>
                    <div class="input-group input-group-merge">
                        <span id="order2" class="input-group-text"><i class="ti ti-arrows-sort"></i></span>
                        <input type="number" id="order" class="form-control" name="order" placeholder="Order"
                            required />
                    </div>
                    <small id="order-add-error" class="text-danger d-none error-message"></small>

                </div>
                <div class="col-sm-12 mb-3">
                    <button type="submit" class="btn btn-primary data-submit me-sm-3 me-1"
                        id="add-new-record-btn">Ajouter</button>
                    <button type="reset" class="btn btn-outline-secondary" data-bs-dismiss="offcanvas"
                        id="close-offcanvas-add">Fermer</button>

                </div>
            </form>
        </div>
    </div>
    <!-- Offcanvas to edit record -->
    <div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasEditRecord"
        aria-labelledby="offcanvasEditRecordLabel">
        <div class="offcanvas-header">
            <h5 id="offcanvasEditRecordLabel" class="offcanvas-title">
                Modifier un{{ $crudType == 'F' ? 'e' : '' }} {{ strtolower($crudTitle) }}
            </h5>
            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body mx-0 flex-grow-0">
            <form class="edit-record pt-0 row g-2 d-none" id="form-update-record">
                <input type="hidden" id="id-edit" class="form-control" name="id-edit" placeholder="Order" required
                    readonly />
                <div class="col-sm-12 mb-3">
                    <label class="form-label" for="name-edit">Nom</label>
                    <div class="input-group input-group-merge">
                        <span id="name-edit2" class="input-group-text"><i id="name-edit3"
                                class="ti ti-article"></i></span>
                        <input type="text" id="name-edit" class="form-control" name="name" placeholder="Nom"
                            required />
                    </div>
                    <small id="name-update-error" class="text-danger d-none error-message"></small>

                </div>
                <div class="col-sm-12 mb-3">
                    <label class="form-label" for="order-edit">Order</label>
                    <div class="input-group input-group-merge">
                        <span id="order-edit2" class="input-group-text"><i id="order-edit3"
                                class="ti ti-arrows-sort"></i></span>
                        <input type="number" placeholder id="order-edit" class="form-control" name="order"
                            placeholder="Order" required />
                    </div>
                </div>
                <small id="order-update-error" class="text-danger d-none error-message"></small>

                <div class="col-sm-12 mb-3">
                    <button type="submit" class="btn btn-primary data-submit me-sm-3 me-1"
                        id="update-record-btn">Modifier</button>
                    <button type="reset" class="btn btn-outline-secondary" data-bs-dismiss="offcanvas"
                        id="close-offcanvas-edit">Fermer</button>
                </div>
            </form>
            <div class="placeholder-glow" id="placeholder-form-update-record">
                <div class="mb-3">
                    <div>
                        <span class="placeholder col-3"></span>
                    </div>
                    <div>
                        <span class="col-7 placeholder rounded-3 w-100" style="height: 38px;"></span>
                    </div>
                </div>
                <div class="mb-3">
                    <div>
                        <span class="placeholder col-3"></span>
                    </div>
                    <div>
                        <span class="col-7 placeholder rounded-3 w-100" style="height: 38px;"></span>
                    </div>
                </div>
                <div class="col-sm-12 mb-3">
                    <a href="#" tabindex="-1" class="btn btn-primary disabled placeholder col-6 me-3"
                        style="width: 100px; height: 38px;"></a>
                    <a href="#" tabindex="-1" class="btn btn-outline-secondary disabled placeholder col-6"
                        style="width: 100px; height: 38px;"></a>

                </div>
            </div>
        </div>
    </div>


@endsection
