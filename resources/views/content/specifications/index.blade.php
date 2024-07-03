@php
    $crudType = 'M';
    $crudTitle = 'cahier des charges';
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

        .hidden-button {
            display: none !important;
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
                    url:   '{{ url('assets/json/datatable/fr.json') }}',
                    // search: "Filtrer par: ",
                    // searchPlaceholder: "Nom compte, Nom contact, Chargé ...",
                },
                ajax: '{!! route('specification.datatable') !!}',
                "processing": true,
                "serverSide": true,
                order: [
                    [0, 'desc']
                ],
                columns: [{
                        data: 'id',
                        visible: false
                    },
                    {
                        data: 'entreprise_name'
                    },
                    {
                        data: 'contact_person'
                    },
                    {
                        data: 'phone'
                    },
                    {
                        data: 'email'
                    },
                    {
                        data: 'step'
                    },
                    {
                        data: 'actions'
                    }
                ],
            });
        });

        $(document).on('click', '.rechat', async function() {

            Swal.fire({
                title: 'Génération de texte en cours',
                html: 'Merci de patienter un petit moment. <br/>Veuillez ne pas actualiser la page tant que les textes sont en cours de génération.',
                allowOutsideClick: false,
                showCancelButton: true,
                showConfirmButton: true,
                allowEscapeKey: false,
                willOpen: () => {
                    Swal.showLoading();
                    // Hide the buttons
                    Swal.getConfirmButton().classList.remove('btn');
                    Swal.getConfirmButton().classList.add('hidden-button');
                    Swal.getCancelButton().classList.remove('btn');
                    Swal.getCancelButton().classList.add('hidden-button');
                    Swal.getDenyButton().classList.remove('btn');
                    Swal.getDenyButton().classList.add('hidden-button');
                }
            });

            $(this).addClass('disabled').find('i').addClass('rotate');

            try {
                var specId = $(this).data('spec-id');
                var response = await $.ajax({
                    url: '/specifications/' + specId + '/edit',
                    method: 'GET',
                    data: {
                        _token: '{{ csrf_token() }}',
                    }
                });
                console.log('Specification response:', response); // Log de la réponse de la spécification

                let {
                    id,

                    prompt_description,
                    iatext_description,

                    prompt_services_products,
                    iatext_services_products,

                    prompt_main_activities,
                    iatext_main_activities,

                    prompt_target_audience,
                    iatext_target_audience,

                } = response.specification;

                if (prompt_description && (!iatext_description || iatext_description == 'error')) {
                    let descriptionResponse = await makeAjaxRequest('{{ route('reAskToChatGpt') }}', 'GET', {
                        prompt: prompt_description,
                        type: 'iatext_description',
                        step: 1,
                        id
                    });
                    console.log('Prompt description response:', descriptionResponse);
                }

                if (prompt_main_activities && (!iatext_main_activities || iatext_main_activities == 'error')) {
                    let mainActivitiesResponse = await makeAjaxRequest('{{ route('reAskToChatGpt') }}',
                        'GET', {
                            prompt: prompt_main_activities,
                            type: 'iatext_main_activities',
                            step: 1,
                            id
                        });
                    console.log('Main activities response:', mainActivitiesResponse);
                }

                if (prompt_services_products && (!iatext_services_products || iatext_services_products ==
                        'error')) {
                    let servicesProductsResponse = await makeAjaxRequest('{{ route('reAskToChatGpt') }}',
                        'GET', {
                            prompt: prompt_services_products,
                            type: 'iatext_services_products',
                            step: 1,
                            id
                        });
                    console.log('Services products response:', servicesProductsResponse);
                }

                if (prompt_target_audience && (!iatext_target_audience || iatext_target_audience == 'error')) {
                    let targetAudienceResponse = await makeAjaxRequest('{{ route('reAskToChatGpt') }}',
                        'GET', {
                            prompt: prompt_target_audience,
                            type: 'iatext_target_audience',
                            step: 1,
                            id
                        });
                    console.log('Target audience response:', targetAudienceResponse);
                }

                ////
                let {
                    id: id_objectif_site,

                    prompt_iatext_target_keywords,
                    iatext_target_keywords,

                    prompt_expected_client_objectives,
                    iatext_expected_client_objectives,

                    prompt_iatext_menu,
                    iatext_menu,

                    prompt_iatext_techniques_specs,
                    iatext_techniques_specs,

                } = response.specification.objectif_site;

                if (prompt_iatext_target_keywords && (!iatext_target_keywords || iatext_target_keywords ==
                        'error')) {
                    let iatext_target_keywords_response = await makeAjaxRequest(
                        '{{ route('reAskToChatGpt') }}', 'GET', {
                            prompt: prompt_iatext_target_keywords,
                            type: 'iatext_target_keywords',
                            step: 2,
                            id_objectif_site
                        });
                    console.log(iatext_target_keywords_response);
                }

                if (prompt_expected_client_objectives && (!iatext_expected_client_objectives ||
                        iatext_expected_client_objectives == 'error')) {
                    let iatext_expected_client_objectives_response = await makeAjaxRequest(
                        '{{ route('reAskToChatGpt') }}', 'GET', {
                            prompt: prompt_expected_client_objectives,
                            type: 'iatext_expected_client_objectives',
                            step: 2,
                            id_objectif_site
                        });
                    console.log(iatext_expected_client_objectives_response);
                }

                if (prompt_iatext_menu && (!iatext_menu || iatext_menu == 'error')) {
                    let iatext_menu_response = await makeAjaxRequest(
                        '{{ route('reAskToChatGpt') }}', 'GET', {
                            prompt: prompt_iatext_menu,
                            type: 'iatext_menu',
                            step: 2,
                            id_objectif_site
                        });
                    console.log(iatext_menu_response);
                }

                if (prompt_iatext_techniques_specs && (!iatext_techniques_specs || iatext_techniques_specs ==
                        'error')) {
                    let iatext_techniques_specs_response = await makeAjaxRequest(
                        '{{ route('reAskToChatGpt') }}', 'GET', {
                            prompt: prompt_iatext_techniques_specs,
                            type: 'iatext_techniques_specs',
                            step: 2,
                            id_objectif_site
                        });
                    console.log(iatext_techniques_specs_response);
                }

                //////
                let {
                    id: id_existing_analysis,

                    prompt_iatext_competitors,
                    iatext_competitors,

                    prompt_iatext_constraints,
                    iatext_constraints

                } = response.specification.existing_analysis;

                if (prompt_iatext_competitors && (!iatext_competitors || iatext_competitors == 'error')) {
                    let iatext_competitors_response = await makeAjaxRequest(
                        '{{ route('reAskToChatGpt') }}', 'GET', {
                            prompt: prompt_iatext_competitors,
                            type: 'iatext_competitors',
                            step: 3,
                            id_existing_analysis
                        });
                    console.log(iatext_competitors_response);
                }

                if (prompt_iatext_constraints && (!iatext_constraints || iatext_constraints == 'error')) {
                    let iatext_constraints_response = await makeAjaxRequest(
                        '{{ route('reAskToChatGpt') }}', 'GET', {
                            prompt: prompt_iatext_constraints,
                            type: 'iatext_constraints',
                            step: 3,
                            id_existing_analysis
                        });
                    console.log(iatext_constraints_response);
                }

                let {
                    id: id_design_content,

                    prompt_iatext_exemples_sites,
                    iatext_exemples_sites

                } = response.specification.design_content;
                console.log('prompt_iatext_exemples_sites', prompt_iatext_exemples_sites);
                console.log(id_design_content);
                if (prompt_iatext_exemples_sites && (!iatext_exemples_sites || iatext_exemples_sites ==
                    'error')) {
                    let iatext_exemples_sites_response = await makeAjaxRequest(
                        '{{ route('reAskToChatGpt') }}', 'GET', {
                            prompt: prompt_iatext_exemples_sites,
                            type: 'iatext_exemples_sites',
                            step: 4,
                            id_design_content
                        });
                    console.log(iatext_exemples_sites_response);
                }

                var table = $('#table-datatable').DataTable();

                // Reload the DataTable with the same status
                $(this).removeClass('disabled').find('i').removeClass('rotate');
                table.ajax.reload(null, false);
                Swal.close();

                Swal.fire({
                    title: 'Succès',
                    text: 'L\'opération a été effectuée avec succès.',
                    icon: 'success',
                    customClass: {
                        confirmButton: 'btn btn-success waves-effect waves-light'
                    },
                    willOpen: () => {
                        Swal.getCancelButton().classList.remove('btn');
                        Swal.getCancelButton().classList.add('hidden-button');
                        Swal.getDenyButton().classList.remove('btn');
                        Swal.getDenyButton().classList.add('hidden-button');
                    }
                });
            } catch (error) {
                $(this).removeClass('disabled').find('i').removeClass('rotate');
                Swal.close();
                Swal.fire({
                    title: 'Erreur de génération de texte',
                    text: "Une erreur s'est produite lors de la génération de texte avec ChatGPT. Merci de vérifier votre quota et régénérer les textes.",
                    icon: 'error',
                    showCancelButton: false,
                    showDenyButton: false,
                    showConfirmButton: true,
                    customClass: {
                        confirmButton: 'btn btn-danger waves-effect waves-light'
                    },
                    willOpen: () => {

                        Swal.getCancelButton().classList.remove('btn');
                        Swal.getCancelButton().classList.add('hidden-button');
                        Swal.getDenyButton().classList.remove('btn');
                        Swal.getDenyButton().classList.add('hidden-button');
                    }
                });
                console.error('Error:', error); // Log des erreurs
            }
        });

        function makeAjaxRequest(url, method, data) {
            console.log('loading.....');
            return $.ajax({
                url: url,
                method: method,
                data: data,
            });
        }


        // $(document).on('click', '.rechat', function() {
        //     var specId = $(this).data('spec-id');

        //     $.ajax({
        //         url: '/specifications/' + specId + '/edit',
        //         method: 'GET',
        //         data: {
        //             _token: '{{ csrf_token() }}',
        //         },
        //         success: function(response) {
        //             console.log('Specification response:',
        //             response); // Log de la réponse de la spécification
        //             let {
        //                 prompt_description,
        //                 prompt_services_products,
        //                 prompt_main_activities,
        //                 prompt_target_audience,
        //             } = response.specification;

        //             makeAjaxRequest('{{ route('reAskToChatGpt') }}', 'GET', {
        //                     prompt: prompt_description
        //                 })
        //                 .then(function(response) {
        //                     console.log('Prompt description response:',
        //                     response); // Log de la réponse de la description de la proposition
        //                     return makeAjaxRequest('{{ route('reAskToChatGpt') }}', 'GET', {
        //                         prompt: prompt_services_products,
        //                         type: ''
        //                     });
        //                 })
        //                 .then(function() {
        //                     return makeAjaxRequest('{{ route('reAskToChatGpt') }}', 'GET', {
        //                         prompt: prompt_main_activities
        //                     });
        //                 })
        //                 .then(function() {
        //                     return makeAjaxRequest('{{ route('reAskToChatGpt') }}', 'GET', {
        //                         prompt: prompt_target_audience
        //                     });
        //                 })
        //                 .catch(function(error) {
        //                     console.error('Error:', error); // Log des erreurs
        //                 });
        //         },
        //         error: function(xhr, status, error) {
        //             console.error('XHR Error:', xhr.responseText); // Log des erreurs XHR
        //         }
        //     });
        // });

        // function makeAjaxRequest(url, method, data) {
        //     return new Promise(function(resolve, reject) {
        //         $.ajax({
        //             url: url,
        //             method: method,
        //             data: data,
        //             success: resolve,
        //             error: reject
        //         });
        //     });
        // }
    </script>
    <script src="{{ asset('assets/js/ui-popover.js') }}"></script>
@endsection

@section('content')
    <h4 class="py-3 mb-4"><span class="text-muted fw-light">Cahier des charges/</span> Liste de cahier des charges</h4>

    <!-- Users List Table -->
    <div class="card">
        <div class="card-datatable table-responsive">
            <div class="card-header flex-column flex-md-row">
                <div class="dt-action-buttons text-start pt-3 pt-md-0">
                    <div class="dt-buttons btn-group flex-wrap">
                        <a class="btn btn-primary" href="specifications/create">
                            <i class="ti ti-plus me-sm-1"></i>
                            <span class="d-none d-sm-inline-block">Créer un{{ $crudType == 'F' ? 'e' : '' }}
                                {{ strtolower($crudTitle) }}</span>
                        </a>

                    </div>
                </div>
            </div>
            <table class="datatables-users table" id="table-datatable">
                <thead class="border-top">
                    <tr>
                        <th>ID</th>
                        <th>Nom de l'entreprise</th>
                        <th>Personne à contacter</th>
                        <th>Téléphone</th>
                        <th>Email</th>
                        <th>Step</th>
                        <th>Action</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
    <!-- Offcanvas to add record -->
    {{-- <div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasAddRecord" aria-labelledby="offcanvasAddRecordLabel">
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
                    <label class="form-label" for="name">Type</label>
                    <select id="type2" class="select2 form-select form-select-lg" data-allow-clear="true" name="type"
                        required>
                        <option value=""> -- </option>
                        @foreach ($promptTypes as $item)
                            <option value="{{ $item['name'] }}">{{ $item['name'] }}</option>
                        @endforeach
                    </select>
                    <small id="type-add-error" class="text-danger d-none error-message"></small>
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
                    <label class="form-label" for="name">Type</label>
                    <select id="type" class="select2 form-select form-select-lg" data-allow-clear="true"
                        name="type" required>
                        <option value=""> -- </option>
                        @foreach ($promptTypes as $item)
                            <option value="{{ $item['name'] }}">{{ $item['name'] }}</option>
                        @endforeach
                    </select>
                    <small id="name-add-error" class="text-danger d-none error-message"></small>
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
                <small id="type-update-error" class="text-danger d-none error-message"></small>

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
    </div> --}}


@endsection
