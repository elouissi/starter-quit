@extends('layouts/layoutMaster')

@section('title', 'Créer un cahier de charge')

@section('vendor-style')
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/bs-stepper/bs-stepper.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/bootstrap-select/bootstrap-select.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/select2/select2.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/@form-validation/umd/styles/index.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/sweetalert2/sweetalert2.css') }}" />

    <style>
        .visibility-hidden {
            visibility: hidden;
        }

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
    <script src="{{ asset('assets/vendor/libs/bs-stepper/bs-stepper.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/bootstrap-select/bootstrap-select.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/select2/select2.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/@form-validation/umd/bundle/popular.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/@form-validation/umd/plugin-bootstrap5/index.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/@form-validation/umd/plugin-auto-focus/index.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/sweetalert2/sweetalert2.js') }}"></script>
@endsection

@section('page-script')
    <script src="{{ asset('assets/js/form-wizard-validation.js') }}"></script>
    <script>
        function toggleNomDomaine() {
            var nomDomaineGroup = document.getElementById("nomDomaineGroup");
            var domaineOui = document.getElementById("domaineOui");
            var nomDomaine = document.getElementById("nomDomaine");

            if (domaineOui.checked) {
                nomDomaineGroup.style.display = "block";
                nomDomaine.required = true;
            } else {
                nomDomaineGroup.style.display = "none";
                nomDomaine.required = false;
            }
        }

        function toggleLogo() {
            var fichierLogoGroup = document.getElementById("fichierLogoGroup");
            var logoOui = document.getElementById("logoOui");
            var fichierLogo = document.getElementById("fichierLogo");

            if (logoOui.checked) {
                fichierLogoGroup.style.display = "block";
                fichierLogo.required = true;
            } else {
                fichierLogoGroup.style.display = "none";
                fichierLogo.required = false;
            }
        }

        function toggleHebergement() {
            var nomHebergementGroup = document.getElementById("nomHebergementGroup");
            var hebergementOui = document.getElementById("hebergementOui");
            var nomHebergement = document.getElementById("nomHebergement");

            if (hebergementOui.checked) {
                nomHebergementGroup.style.display = "block";
                nomHebergement.required = true;
            } else {
                nomHebergementGroup.style.display = "none";
                nomHebergement.required = false;
            }
        }

        function toggleAutresStyle() {
            var zoneTexteAutresStyle = document.getElementById("zoneTexteAutresStyle");
            var autresStyleGraphique = document.getElementById("autres_StyleGraphique");

            if (autresStyleGraphique.checked) {
                zoneTexteAutresStyle.style.display = "block";
            } else {
                zoneTexteAutresStyle.style.display = "none";
            }
        }

        function removeFileInput(element) {
            var container = document.getElementById('fileInputsContainer');
            container.removeChild(element.parentNode.parentNode);
        }
    </script>
    <script>
        $(document).ready(function() {
            generateByAi(`descriptionEntreprise`);
            generateByAi(`activitePrincipale`);
            generateByAi(`servicesProduits`);

            $('input[name="project_type"]').change(function() {
                if ($(this).val() === 'E-commerce') {
                    $('#options-paiement-container').removeClass('d-none');
                } else {
                    $('#options-paiement-container').addClass('d-none');
                }
            });

            $('#nombrePropositions').change(function() {
                let numberOfPropositions = $(this).val();
                console.log($(this).val());
                if ($(this).val() === 'autre') {
                    $('#autreProposition').val('')
                    $('#autrePropositionInput').show();
                } else {
                    $('#autreProposition').val(numberOfPropositions)
                    // $('#autrePropositionInput').show();
                    $('#autrePropositionInput').hide();
                }
            });

            for (let i = 1; i < 11; i++) {
                $(`#plus-btn-${i}`).click(function() {
                    $(`#pourcentage-${i+1}`).removeClass('d-none');
                })

                $(`#titre-operation-${i}`).on('input', function() {
                    console.log($(this).val());
                    $(`#label-pourcentage-operation-${i}`).text($(this).val());
                });

                $(`#delete-btn-${i}`).click(function() {
                    console.log(i);
                    $(`#pourcentage-value-${i}`).val('');
                    $(`#pourcentage-operation-${i}`).val('');
                    $(`#titre-operation-${i}`).val('');
                    // $(`#pourcentage-${i}`).addClass('d-none');
                });

                $(`#pourcentage-operation-${i}`).on('input', function() {
                    calculReste()
                });
            }

            const designations = ['installation-environnement', 'integration-structure',
                'ebauche-textes-traductions',
                'maquettage-graphique', 'developpement-integrations-web', 'integration-textes-images',
                'integration-autres-pages', 'optimisation-version-mobile', 'integration-multilingue',
                'optimisation-seo', 'suivi-tests', 'gestion-projet'
            ];

            designations.forEach(element => {
                $(`#nj-${element}, #mu-${element}`).on('input', function() {
                    if ($(`#nj-${element}`).val() && $(`#mu-${element}`).val()) {
                        let njVal = $(`#nj-${element}`).val() ? parseFloat($(`#nj-${element}`)
                            .val()) : 0;
                        let muVal = $(`#mu-${element}`).val() ? parseFloat($(`#mu-${element}`)
                            .val()) : 0;
                        $(`#total-${element}`).val(njVal * muVal);
                    } else {
                        $(`#total-${element}`).val('');
                    }
                    calculTotal()
                    calculReste()
                    calculMaintenance()
                })
            });

            $('#remise-exceptionnelle').on('input', function() {
                calculTotal()
                calculReste()
                calculMaintenance()
            })

            $('#pourcentage-operation-maintenance').on('input', function() {
                calculTotal()
                calculReste()
                calculMaintenance()
            })

            calculReste();
            calculMaintenance();

            // Get all the checkboxes
            const checkboxes = document.querySelectorAll('input[name="payment_options[]"]');

            // Event listener for the "Aucun" checkbox
            const aucunCheckbox = document.getElementById('paiement_aucun');
            aucunCheckbox.addEventListener('change', function() {
                if (this.checked) {
                    checkboxes.forEach(function(checkbox) {
                        if (checkbox !== aucunCheckbox) {
                            checkbox.checked = false;
                        }
                    });
                }
            });

            // Event listener for the other checkboxes
            checkboxes.forEach(function(checkbox) {
                if (checkbox !== aucunCheckbox) {
                    checkbox.addEventListener('change', function() {
                        if (this.checked) {
                            aucunCheckbox.checked = false;
                        }
                    });
                }
            });
        });

        // function generateByAi2(prompt) {
        //     console.log('generateByAi2');
        //     $.ajax({
        //         url: '{{ route('askToChatgpt4') }}',
        //         type: 'POST',
        //         data: {
        //             prompt: prompt
        //         },
        //         headers: {
        //             'X-CSRF-TOKEN': '{{ csrf_token() }}'
        //         },
        //         success: function(response) {
        //             console.log(response);
        //             // $(`#${element}Ai-generate`).html(
        //             //     ` <i class="ti ti-file-text-ai"></i> &nbsp; Générer`);
        //             // $(`#${element}Ai-generate`).prop("disabled", false);
        //             // $(`#${element}`).text(response);
        //         },
        //         error: function(xhr, status, error) {
        //             console.log('xhr', xhr);
        //             console.log('status', status);
        //             console.log('error', error);
        //             // $(`#${element}Ai-generate`).html(
        //             //     ` <i class="ti ti-file-text-ai"></i> &nbsp; Générer`);
        //             // $(`#${element}Ai-generate`).prop("disabled", false);
        //             // console.error("Error:", error);
        //         }
        //     });
        // }

        // generateByAi2(`Description de l'entreprise Havet digital a partie de leur site web www.havetdigital.fr`);

        function generateByAi(element) {
            $(`#${element}Ai`).on("input", function() {
                if ($(`#${element}Ai`).val().trim().length > 3) {
                    $(`#${element}Ai-generate`).prop("disabled", false);
                } else {
                    $(`#${element}Ai-generate`).prop("disabled", true);
                }
            });
            $(`#${element}Ai-generate`).click(function() {
                $(`#${element}Ai-generate`).html(
                    `<i class="ti ti-loader rotate"></i> &nbsp; Chargement ...`);
                $(`#${element}Ai-generate`).prop("disabled", true);
                $(`#${element}`).text('');
                var promptText = $(`#${element}Ai`).val();
                $.ajax({
                    url: '{{ route('askToChatGpt') }}',
                    type: 'GET',
                    data: {
                        prompt: promptText
                    },
                    success: function(response) {
                        $(`#${element}Ai-generate`).html(
                            ` <i class="ti ti-file-text-ai"></i> &nbsp; Générer`);
                        $(`#${element}Ai-generate`).prop("disabled", false);
                        $(`#${element}`).text(response);
                    },
                    error: function(xhr, status, error) {
                        $(`#${element}Ai-generate`).html(
                            ` <i class="ti ti-file-text-ai"></i> &nbsp; Générer`);
                        $(`#${element}Ai-generate`).prop("disabled", false);
                        console.error("Error:", error);
                    }
                });
            });
        }

        const designations = ['installation-environnement', 'integration-structure', 'ebauche-textes-traductions',
            'maquettage-graphique', 'developpement-integrations-web', 'integration-textes-images',
            'integration-autres-pages', 'optimisation-version-mobile', 'integration-multilingue',
            'optimisation-seo', 'suivi-tests', 'gestion-projet'
        ];

        function calculTotal() {
            let total = 0;
            let totalItem;
            designations.forEach(element => {
                totalItem = $(`#total-${element}`).val() ? parseFloat($(`#total-${element}`).val()) : 0;
                total += totalItem;
            });
            let remise_exceptionnelle = $('#remise-exceptionnelle').val() ? parseFloat($(`#remise-exceptionnelle`).val()) :
                0;;

            $('#total-total').val(total - remise_exceptionnelle)
        }

        function calculMaintenance() {
            let pourcentageMaintenance = $('#pourcentage-operation-maintenance').val() ? parseInt($(
                `#pourcentage-operation-maintenance`).val()) : 0;
            let total = $(`#total-total`).val() ? parseInt($(`#total-total`).val()) : 0;
            let percentageAmount = (pourcentageMaintenance / 100) * total;
            $('#pourcentage-value-maintenance').val(percentageAmount)
        }

        function calculReste() {
            for (let i = 1; i < 11; i++) {
                let total = $(`#total-total`).val() ? parseInt($(`#total-total`).val()) : 0;
                let percentageNumber = $(`#pourcentage-operation-${i}`).val();
                var percentageAmount = (percentageNumber / 100) * total;
                $(`#pourcentage-value-${i}`).val(percentageAmount);
                let reste = 0;
                let totalAvance = 0;
                for (let i = 1; i < 11; i++) {
                    let avanceValue = $(`#pourcentage-value-${i}`).val() ?
                        parseInt($(`#pourcentage-value-${i}`).val()) : 0;
                    totalAvance += avanceValue;
                }
                $('#reste').val(total - totalAvance);
            }
        }
    </script>
    <script src="{{ asset('assets/js/ui-popover.js') }}"></script>
@endsection

@section('content')
    <h4 class="py-3 mb-4">
        <span class="text-muted fw-light">Cahier de charge/</span> Créer un cahier de charge
    </h4>
    <!-- Default -->
    <div class="row">

        <!-- Validation Wizard -->
        <div class="col-12 mb-4">
            <div id="wizard-validation" class="bs-stepper mt-2">
                <div class="bs-stepper-header">
                    <div class="step" data-target="#step-1-validation">
                        <button type="button" class="step-trigger ">
                            <span class="bs-stepper-circle">1</span>
                            <span class="bs-stepper-label mt-1">
                                <span class="bs-stepper-title">Présentation <br>de l'entreprise</span>
                            </span>
                        </button>
                    </div>
                    <div class="line">
                        <i class="ti ti-chevron-right"></i>
                    </div>
                    <div class="step" data-target="#step-2-validation">
                        <button type="button" class="step-trigger">
                            <span class="bs-stepper-circle">2</span>
                            <span class="bs-stepper-label">
                                <span class="bs-stepper-title">Objectif <br> du site</span>
                            </span>
                        </button>
                    </div>
                    <div class="line">
                        <i class="ti ti-chevron-right"></i>
                    </div>
                    <div class="step" data-target="#step-3-validation">
                        <button type="button" class="step-trigger">
                            <span class="bs-stepper-circle">3</span>
                            <span class="bs-stepper-label">
                                <span class="bs-stepper-title">Analyse <br> de l'existant</span>
                            </span>
                        </button>
                    </div>
                    <div class="line">
                        <i class="ti ti-chevron-right"></i>
                    </div>
                    <div class="step" data-target="#step-4-validation">
                        <button type="button" class="step-trigger">
                            <span class="bs-stepper-circle">4</span>
                            <span class="bs-stepper-label">
                                <span class="bs-stepper-title">Design <br> et contenu</span>
                            </span>
                        </button>
                    </div>
                    <div class="line">
                        <i class="ti ti-chevron-right"></i>
                    </div>
                    <div class="step" data-target="#step-5-validation">
                        <button type="button" class="step-trigger">
                            <span class="bs-stepper-circle">5</span>
                            <span class="bs-stepper-label">
                                <span class="bs-stepper-title">Délais <br> et Budget</span>
                            </span>
                        </button>
                    </div>
                </div>
                <div class="bs-stepper-content">
                    <div id="wizard-validation-form">
                        <!-- 1 -->
                        <div id="step-1-validation" class="content">
                            <div class="content-header mb-3">
                                <h6 class="mb-0">Présentation de l'entreprise</h6>
                            </div>
                            <form id="step-1-validation-form">
                                <div class="row g-3 validation-field">
                                    @csrf
                                    <input type="number" name="specification_id" id="specification_id" readonly
                                        class="d-none">
                                    <div class="col-sm-6">
                                        <div class="row">
                                            <div class="col-10 mb-3">
                                                <label class="form-label" for="nomEntreprise">Nom de l'entreprise</label>
                                                <input type="text" name="entreprise_name" id="nomEntreprise"
                                                    class="form-control" placeholder="Nom de l'entreprise" />
                                            </div>
                                            <div class="col-10 mb-3">
                                                <label class="form-label" for="personneContacte">Personne à contacter (nom
                                                    et
                                                    prénom)</label>
                                                <input type="text" name="contact_person" id="personneContacte"
                                                    class="form-control" placeholder="Nom de l'entreprise" />
                                            </div>
                                            <div class="col-10 mb-3">
                                                <label class="form-label" for="telephone">Téléphone</label>
                                                <input type="tel" name="phone" id="telephone" class="form-control"
                                                    placeholder="Numéro de téléphone" />
                                            </div>
                                            <div class="col-10 mb-3">
                                                <label class="form-label" for="email">Email</label>
                                                <input type="email" name="email" id="email" class="form-control"
                                                    placeholder="Adresse email" />
                                            </div>
                                            <div class="col-10 mb-3">
                                                <label class="form-label" for="cible">Cible</label>
                                                <input type="text" name="target" id="cible" class="form-control"
                                                    placeholder="Cible">
                                            </div>
                                        </div>

                                    </div>
                                    <div class="col-sm-6">
                                        <div class="row">
                                            <div class="col-12 mb-3">
                                                <label class="form-label" for="descriptionEntreprise">Description de
                                                    l'entreprise</label>
                                                <div class="input-group mb-1">
                                                    <input type="text" class="form-control" name="prompt_description"
                                                        placeholder="Créer votre prompt" id="descriptionEntrepriseAi">
                                                    <button class="btn btn-outline-primary" type="button"
                                                        id="descriptionEntrepriseAi-generate" disabled>
                                                        <i class="ti ti-file-text-ai"></i> &nbsp; Générer
                                                    </button>
                                                </div>
                                                <textarea name="description" id="descriptionEntreprise" class="form-control" rows="4"
                                                    placeholder="Description de l'entreprise"></textarea>
                                            </div>
                                            <div class="col-12 mb-3">
                                                <label class="form-label" for="activitePrincipale">Activité principale de
                                                    l'entreprise</label>
                                                <div class="input-group mb-1">
                                                    <input type="text" class="form-control"
                                                        name="prompt_main_activities" placeholder="Créer votre prompt"
                                                        id="activitePrincipaleAi">
                                                    <button class="btn btn-outline-primary" type="button"
                                                        id="activitePrincipaleAi-generate" disabled>
                                                        <i class="ti ti-file-text-ai"></i> &nbsp; Générer
                                                    </button>
                                                </div>
                                                <textarea name="main_activities" id="activitePrincipale" class="form-control" rows="4"
                                                    placeholder="Activité principale de l'entreprise"></textarea>
                                            </div>
                                            <div class="col-12 mb-3">
                                                <label class="form-label" for="servicesProduits">Services ou produits
                                                    vendus</label>
                                                <div class="input-group mb-1">
                                                    <input type="text" class="form-control"
                                                        name="prompt_services_products" placeholder="Créer votre prompt"
                                                        id="servicesProduitsAi">
                                                    <button class="btn btn-outline-primary" type="button"
                                                        id="servicesProduitsAi-generate" disabled>
                                                        <i class="ti ti-file-text-ai"></i> &nbsp; Générer
                                                    </button>
                                                </div>
                                                <textarea name="services_products" id="servicesProduits" class="form-control" rows="4"
                                                    placeholder="Services ou produits vendus"></textarea>
                                            </div>

                                        </div>
                                    </div>
                                    <div class="col-12 d-flex justify-content-between">
                                        <button type="button" class="btn btn-label-secondary btn-prev opacity-0"
                                            disabled> <i class="ti ti-arrow-left me-sm-1 me-0"></i>
                                            <span class="align-middle d-sm-inline-block d-none">Précédent</span>
                                        </button>
                                        <button type="button" class="btn btn-primary btn-next" id="next-step-1">
                                            <span class="align-middle d-sm-inline-block d-none me-sm-1">
                                                Suivant
                                            </span> <i class="ti ti-arrow-right" id="icon-next-step-1"></i>
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <!-- 2 -->
                        <div id="step-2-validation" class="content">
                            <div class="content-header mb-3">
                                <h6 class="mb-0">Objectifs du site</h6>
                            </div>
                            <form id="step-2-validation-form">
                                <div class="row g-3 validation-field">
                                    @csrf
                                    <input type="number" name="objectif_site_id" id="objectif_site_id" readonly
                                        class="d-none">
                                    <div class="col-sm-6">
                                        <div class="row">
                                            <div class="col-12 mb-3">
                                                <label class="form-label" for="besoinProjet">Besoin de projet :</label>
                                                @php
                                                    $project_needs = [['name' => 'Refonte de site web', 'alias' => 'refonte'], ['name' => 'Création de site web', 'alias' => 'creation']];
                                                @endphp
                                                @foreach ($project_needs as $item)
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio"
                                                            id="besoin_{{ $item['alias'] }}" name="project_need"
                                                            value="{{ $item['name'] }}">
                                                        <label class="form-check-label"
                                                            for="besoin_{{ $item['alias'] }}">
                                                            {{ $item['name'] }}
                                                        </label>
                                                    </div>
                                                @endforeach
                                            </div>
                                            <div class="col-12 mb-3">
                                                <label class="form-label">Type de projet :</label>
                                                @php
                                                    $project_needs = [['name' => 'Site Vitrine', 'alias' => 'siteVitrine'], ['name' => 'E-commerce', 'alias' => 'eCommerce'], ['name' => 'Blog', 'alias' => 'blog'], ['name' => "Site d'affiliation", 'alias' => 'siteAffiliation']];
                                                @endphp
                                                @foreach ($project_needs as $item)
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio"
                                                            id="{{ $item['alias'] }}" name="project_type"
                                                            value="{{ $item['name'] }}">
                                                        <label class="form-check-label" for="{{ $item['alias'] }}">
                                                            {{ $item['name'] }}</label>
                                                    </div>
                                                @endforeach
                                            </div>
                                            <div class="col-12 mb-3 d-none" id="options-paiement-container">
                                                <label class="form-label">Options de paiement :</label>
                                                @php
                                                    $payment_options = [['name' => 'Stripe', 'alias' => 'stripe'], ['name' => 'Paypal', 'alias' => 'payment'], ['name' => 'COD (Paiement à la livraison)', 'alias' => 'cod'], ['name' => 'Demande de devis', 'alias' => 'demande_devis'], ['name' => 'Aucun', 'alias' => 'aucun']];
                                                @endphp
                                                @foreach ($payment_options as $item)
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox"
                                                            id="paiement_{{ $item['alias'] }}" name="payment_options[]"
                                                            value="{{ $item['name'] }}">
                                                        <label class="form-check-label"
                                                            for="paiement_{{ $item['alias'] }}">{{ $item['name'] }}</label>
                                                    </div>
                                                @endforeach
                                            </div>
                                            <div class="col-12 mb-3"> <label class="form-label">Langue :</label>
                                                @php
                                                    $languages = [['name' => 'Français', 'alias' => 'fr'], ['name' => 'Anglais', 'alias' => 'en'], ['name' => 'Italien', 'alias' => 'it']];
                                                @endphp
                                                @foreach ($languages as $item)
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox"
                                                            id="langue_{{ $item['alias'] }}" name="languages[]"
                                                            value="{{ $item['name'] }}">
                                                        <label class="form-check-label"
                                                            for="langue_{{ $item['alias'] }}">{{ $item['name'] }}</label>
                                                    </div>
                                                @endforeach
                                            </div>
                                            <div class="col-12 mb-3">
                                                <label class="form-label" for="menu">
                                                    Mots-clés cibles (Avez-vous des mots-clés spécifiques à cibler sur le
                                                    site) :
                                                </label>
                                                <textarea class="form-control" name="target_keywords" rows="3" id="target_keywords"
                                                    placeholder="Saisissez vos mots-clés cibles pour le site"></textarea>
                                            </div>



                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="row">
                                            <div class="col-12 mb-3"><label class="form-label">Fonctions attendues
                                                    :</label>
                                                @foreach ($expected_functions as $item)
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox"
                                                            id="{{ $item->alias }}" name="expected_functions[]"
                                                            value="{{ $item->name }}">
                                                        <label class="form-check-label" for="{{ $item->alias }}">
                                                            {{ $item->name }}
                                                        </label>
                                                    </div>
                                                @endforeach
                                            </div>
                                            <div class="col-12 mb-3"> <label class="form-label"
                                                    for="objectifsAttendus">Objectifs attendus</label>
                                                <textarea name="expected_objectives" id="objectifsAttendus" class="form-control" placeholder="Objectifs attendus"
                                                    rows="4"></textarea>
                                            </div>
                                            <div class="col-12 mb-3">
                                                <label class="form-label" for="menu">Menu (Avez vous une préférence
                                                    des
                                                    menus à ajouter sur le site) :</label>
                                                <textarea class="form-control" id="menu" name="menu" rows="3"
                                                    placeholder="Indiquez votre préférence des menus à ajouter sur le site"></textarea>
                                            </div>

                                        </div>
                                    </div>
                                    <div class="col-12 d-flex justify-content-between">
                                        <button type="button" class="btn btn-label-secondary btn-prev"> <i
                                                class="ti ti-arrow-left me-sm-1 me-0"></i>
                                            <span class="align-middle d-sm-inline-block d-none">Précédent</span>
                                        </button>
                                        <button type="button" class="btn btn-primary btn-next" id="next-step-2">
                                            <span class="align-middle d-sm-inline-block d-none me-sm-1">
                                                Suivant
                                            </span>
                                            <i class="ti ti-arrow-right" id="icon-next-step-2"></i>
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <!-- 3 -->
                        <div id="step-3-validation" class="content">
                            <div class="content-header mb-3">
                                <h6 class="mb-0">Analyse de l'existant</h6>
                            </div>
                            <form id="step-3-validation-form">
                                <div class="row g-3 validation-field">
                                    @csrf
                                    <input type="number" name="analyse_existants_id" id="analyse_existants_id" readonly
                                        class="d-none">
                                    <div class="col-6">
                                        <div class="row">
                                            <div class="col-10 mb-3">
                                                <label class="form-label" for="concurrents">
                                                    Site internet de vos principaux concurrents :
                                                </label>
                                                <textarea class="form-control" id="concurrents" name="competitors" rows="3"
                                                    placeholder="Saisissez les sites internet de vos principaux concurrents"></textarea>
                                            </div>
                                            <div class="col-sm-6 col-md-10">
                                                <div class="form-group">
                                                    <label for="exemples-sites" class="form-label">
                                                        Exemples de sites avec commentaire :
                                                    </label>
                                                    <textarea id="exemples-sites" class="form-control" name="sample_sites" rows="5"
                                                        placeholder="Ajoutez des exemples de sites que vous aimez avec des commentaires sur ce que vous aimez bien sur ces sites (éléments, animation, couleurs, architecture d’informations, fonctionnalités, etc.)."></textarea>
                                                </div>
                                            </div>
                                            <div class="col-sm-6 col-md-10">
                                                <div class="form-group">
                                                    <label for="telecharger-images" class="form-label">
                                                        Télécharger des images :
                                                    </label>
                                                    <input type="file" class="form-control" id="telecharger-images"
                                                        name="sample_sites_files[]"
                                                        accept=".jpg, .jpeg, .png, .gif, .bmp, .svg, .webp, .pdf, .doc, .docx"
                                                        multiple>
                                                    <small id="images-help" class="form-text text-muted">
                                                        Vous pouvez télécharger des images pour illustrer vos commentaires
                                                        sur les sites.
                                                    </small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-6">
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <label class="form-label" for="contraintes">
                                                        Contraintes (donner des exemples de sites internet, dont vous
                                                        appréciez un élément) :
                                                    </label>
                                                    <textarea class="form-control" id="contraintes" name="constraints" rows="4"
                                                        placeholder="Veuillez fournir des exemples de sites internet que vous appréciez et décrire les éléments que vous aimez."></textarea>
                                                </div>
                                            </div>
                                            <div class="col-12 mb-3">
                                                <div class="form-group">
                                                    <label for="telecharger-images" class="form-label">
                                                        Télécharger desimages:
                                                    </label>
                                                    <input type="file" class="form-control" id="telecharger-images"
                                                        name="constraints_files[]"
                                                        accept=".jpg, .jpeg, .png, .gif, .bmp, .svg, .webp, .pdf, .doc, .docx"
                                                        multiple>
                                                    <small id="images-help" class="form-text text-muted">
                                                        Vous pouvez télécharger des images pour illustrer vos commentaires
                                                        sur les sites.
                                                    </small>
                                                </div>
                                            </div>
                                            <div class="col-12 mb-3">
                                                <div class="col-sm-6  col-md-12">
                                                    <div class="form-group">
                                                        <label class="form-label">Nom de domaine :</label>
                                                        <div class="radio-group">
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="radio"
                                                                    id="domaineOui" name="domain" value="Oui"
                                                                    onchange="toggleNomDomaine()">
                                                                <label class="form-check-label"
                                                                    for="domaineOui">Oui</label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="radio"
                                                                    id="domaineNon" name="domain" value="Non"
                                                                    onchange="toggleNomDomaine()">
                                                                <label class="form-check-label"
                                                                    for="domaineNon">Non</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group" id="nomDomaineGroup" style="display: none">
                                                        <input type="text" class="form-control" id="nomDomaine"
                                                            name="domain_name"
                                                            placeholder="Nom de domaine (si disponible)">
                                                        <small id="msg_validation_nomDomaine"
                                                            class="invalid-feedback d-none"> Le nom de domaine est requis
                                                        </small>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12 mb-3">
                                                <div class="col-sm-6  col-md-12">
                                                    <label class="form-label">Logo :</label>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio" id="logoOui"
                                                            name="logo" value="Oui" onchange="toggleLogo()">
                                                        <label class="form-check-label" for="logoOui">Oui</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio" id="logoNon"
                                                            name="logo" value="Non" onchange="toggleLogo()">
                                                        <label class="form-check-label" for="logoNon">Non</label>
                                                    </div>
                                                    <div class="col-sm-12" id="fichierLogoGroup" style="display: none">
                                                        <input type="file" class="form-control" id="fichierLogo"
                                                            name="logo_file"
                                                            accept=".jpg, .jpeg, .png, .gif, .bmp, .svg, .webp, .pdf, .doc, .docx">
                                                        <small id="msg_validation_fichierLogo"
                                                            class="invalid-feedback d-none"> Le logo est requis
                                                        </small>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12 mb-3">
                                                <div class="col-sm-6 col-md-12">
                                                    <div class="form-group">
                                                        <label class="form-label">Hébergement :</label>
                                                        <div class="radio-group">
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="radio"
                                                                    id="hebergementOui" name="hosting" value="Oui"
                                                                    onchange="toggleHebergement()">
                                                                <label class="form-check-label"
                                                                    for="hebergementOui">Oui</label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="radio"
                                                                    id="hebergementNon" name="hosting" value="Non"
                                                                    onchange="toggleHebergement()">
                                                                <label class="form-check-label"
                                                                    for="hebergementNon">Non</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group" id="nomHebergementGroup"
                                                        style="display: none">
                                                        <input type="text" class="form-control" id="nomHebergement"
                                                            name="hosting_name" placeholder="Hébergement (si disponible)">
                                                        <small id="msg_validation_nomHebergement"
                                                            class="invalid-feedback d-none"> L'hébergement est requis
                                                        </small>
                                                    </div>
                                                </div>
                                            </div>



                                        </div>

                                    </div>
                                    {{--
                                  <!-- Zone de texte (non afficher au formulaire) pour langage de programmation -->
                                  <input type="" id="langage" name="langage" value="wappalizer">

                                  <!-- Zone de texte (non afficher au formulaire) pour les outils utilisées pour le développement -->
                                  <input type="" id="outils" name="outils" value="wappalizer">

                                  <!-- Zone de texte (non afficher au formulaire) pour statistiques de trafic -->
                                  <input type="" id="trafic" name="trafic" value="similarweb">

                                  <!-- Zone de texte (non afficher au formulaire) pour Nombre de pages -->
                                  <input type="" id="pages" name="pages" value="similarweb"> --}}

                                    <div class="col-12 d-flex justify-content-between">
                                        <button type="button" class="btn btn-label-secondary btn-prev">
                                            <i class="ti ti-arrow-left me-sm-1 me-0"></i>
                                            <span class="align-middle d-sm-inline-block d-none">Précédent</span>
                                        </button>
                                        <button type="button" class="btn btn-primary btn-next" id="next-step-3"> <span
                                                class="align-middle d-sm-inline-block d-none me-sm-1">Suivant</span> <i
                                                class="ti ti-arrow-right" id="icon-next-step-3"></i></button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <!-- 4 -->
                        <div id="step-4-validation" class="content">
                            <div class="content-header mb-3">
                                <h6 class="mb-0">Design et Maquettage</h6>
                            </div>
                            <form id="step-4-validation-form">
                                <div class="row g-3 validation-field">
                                    @csrf
                                    <input type="number" name="content_id" id="content_id" readonly class="d-none">
                                    <div class="row">
                                        <div class="col-6">
                                            <div class="row">
                                                <div class="col-12 mb-3"> <label class="form-label">
                                                        Contenu de votre site:
                                                    </label>
                                                    @php
                                                        $contents = [['name' => 'Fourni par le client', 'alias' => 'contenuClient'], ['name' => 'À créer par le prestataire', 'alias' => 'contenuPrestataire']];
                                                    @endphp
                                                    @foreach ($contents as $item)
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="radio"
                                                                id="{{ $item['alias'] }}" name="content"
                                                                value="{{ $item['name'] }}">
                                                            <label class="form-check-label" for="{{ $item['alias'] }}">
                                                                {{ $item['name'] }}
                                                            </label>
                                                        </div>
                                                    @endforeach
                                                </div>
                                                <div class="col-sm-6 col-md-10 mb-3">
                                                    <div class="form-group">
                                                        <label class="form-label">Style graphique attendu :</label>
                                                        <div class="checkbox-group">
                                                            @php
                                                                $graphic_styles = [['name' => 'Flat design', 'alias' => 'flatDesign'], ['name' => 'Futuriste', 'alias' => 'futuriste'], ['name' => 'Interactif', 'alias' => 'interactif'], ['name' => 'Moderne', 'alias' => 'moderne'], ['name' => 'Retro', 'alias' => 'retro'], ['name' => 'Autres', 'alias' => 'autres']];
                                                            @endphp
                                                            @foreach ($graphic_styles as $item)
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="checkbox"
                                                                        id="{{ $item['alias'] }}_StyleGraphique"
                                                                        name="style_graphiques[]"
                                                                        value="{{ $item['name'] }}"
                                                                        @if ($item['name'] == 'Autres') onchange="toggleAutresStyle()" @endif>
                                                                    <label class="form-check-label"
                                                                        for="{{ $item['alias'] }}_StyleGraphique">
                                                                        {{ $item['name'] }}
                                                                    </label>
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                        <div class="col-sm-12" id="zoneTexteAutresStyle"
                                                            style="display: none;">
                                                            <textarea class="form-control" id="autresStyleTexte" name="style_graphique_autre"
                                                                placeholder="Précisez les autres styles graphiques attendus"></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6 col-md-10 mb-3">
                                                    <label class="form-label" for="nombrePropositions">Nombre de
                                                        propositions
                                                        attendues :</label>
                                                    <select class="select2" id="nombrePropositions"
                                                        name="nombrePropositions">
                                                        <option label=" "></option>
                                                        <option value="1">1</option>
                                                        <option value="2">2</option>
                                                        <option value="3">3</option>
                                                        <option value="autre">Autre</option>
                                                    </select>
                                                </div>
                                                <div id="autrePropositionInput" style="display: none;">
                                                    <div class="col-sm-6 col-md-10 mb-3">
                                                        <label class="form-label" for="autreProposition">Autre proposition
                                                            :</label>
                                                        <input placeholder="Saisissez votre autre proposition ici..."
                                                            class="form-control" id="autreProposition" type="number"
                                                            name="number_of_propositions" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="row">
                                                <div class="col-12 mb-3">
                                                    <div class="form-group">
                                                        <label for="palette-couleurs" class="form-label">
                                                            Palette de couleurs :
                                                        </label>
                                                        <textarea type="text" id="palette-couleurs" class="form-control"
                                                            name="color_palette"
                                                            placeholder="Indiquez les couleurs souhaitées pour votre site"></textarea>
                                                    </div>
                                                </div>

                                                <div class="col-12 mb-3">
                                                    <div class="form-group">
                                                        <label for="typographie" class="form-label">Typographie :</label>
                                                        <textarea type="text" id="typographie" class="form-control"
                                                            name="typography"
                                                            placeholder="Indiquez les préférences de typographie pour votre site"></textarea>
                                                    </div>
                                                </div>
                                                <div class="col-12 ">
                                                    <div class="form-group">
                                                        <label for="exemples-sites" class="form-label">
                                                            Exemples de sites avec commentaire :
                                                        </label>
                                                        <textarea id="exemples-sites" class="form-control" name="exemples_sites" rows="5"
                                                            placeholder="Ajoutez des exemples de sites que vous aimez avec des commentaires sur ce que vous aimez bien sur ces sites (éléments, animation, couleurs, architecture d’informations, fonctionnalités, etc.)."></textarea>
                                                    </div>

                                                    <div class="form-group mb-3">
                                                        <label for="telecharger-images" class="form-label">Télécharger des
                                                            images :</label>
                                                        <input type="file" class="form-control"
                                                            id="telecharger-images" name="exemples_sites_files[]"
                                                            accept=".jpg, .jpeg, .png, .gif, .bmp, .svg, .webp, .pdf, .doc, .docx"
                                                            multiple>
                                                        <small id="images-help" class="form-text text-muted">
                                                            Vous pouvez télécharger des images pour illustrer vos
                                                            commentaires sur les sites.
                                                        </small>
                                                    </div>

                                                </div>
                                                {{-- <div class="col-sm-6 col-md-10 mb-3">
                                                </div>
                                                <div class="form-group" style="display: none;">
                                                    <label class="form-label">Zone de texte (non affichée au formulaire) :
                                                        le lien vers la maquette</label>
                                                    <input type="text" class="form-control" id="lienMaquette"
                                                        name="lienMaquette">
                                                </div>
                                                <div class="form-group" style="display: none;">
                                                    <label class="form-label">Zone de texte (non affichée au formulaire) :
                                                        le lien vers les visuels créés</label>
                                                    <input type="text" class="form-control" id="lienVisuels"
                                                        name="lienVisuels">
                                                </div>
                                                <div class="form-group" style="display: none;">
                                                    <label class="form-label">L'arborescence du site (non affichée au
                                                        formulaire) :</label>
                                                    <input type="file" class="form-control" id="arborescenceSite"
                                                        name="arborescenceSite"
                                                        accept=".jpg, .jpeg, .png, .gif, .bmp, .svg, .webp, .pdf, .doc, .docx">
                                                </div>
                                                <div class="form-group" style="display: none;">
                                                    <label class="form-label">Contenu du Site (non affiché au formulaire) :
                                                        texte à mettre dans chaque section de site</label>
                                                    <textarea class="form-control" id="contenuSite" name="contenuSite" rows="3"></textarea>
                                                </div> --}}
                                            </div>
                                        </div>
                                    </div>

                                    {{-- <!-- Téléchargement de fichier (non affiché au formulaire) : La maquette du site -->
                                    <input type="file" name="maquetteDuSite" style="display: none;">

                                    <!-- Zone de texte (non affichée au formulaire) : le lien vers la maquette -->
                                    <input type="hidden" name="lienVersMaquette" value="url_vers_la_maquette">

                                    <!-- Zone de texte (non affichée au formulaire) : le lien vers les visuels créés -->
                                    <input type="hidden" name="lienVersVisuels" value="url_vers_les_visuels_crees">

                                    <!-- L'arborescence du site (non affichée au formulaire) -->
                                    <input type="file" name="arborescenceDuSite" style="display: none;">

                                    <!-- Zone de texte (non affichée au formulaire) : Nombre de pages estimé -->
                                    <input type="hidden" name="nombreDePagesEstime" value="nombre_pages_estime">

                                    <!-- Contenu du Site (non affiché au formulaire) -->
                                    <input type="hidden" name="contenuDuSite"
                                        value="texte_a_mettre_dans_chaque_section"> --}}

                                    <div class="col-12 d-flex justify-content-between">
                                        <button type="button" class="btn btn-label-secondary btn-prev"> <i
                                                class="ti ti-arrow-left me-sm-1 me-0"></i>
                                            <span class="align-middle d-sm-inline-block d-none">Précédent</span>
                                        </button>
                                        <button type="button" class="btn btn-primary btn-next" id="next-step-4"> <span
                                                class="align-middle d-sm-inline-block d-none me-sm-1">Suivant</span> <i
                                                class="ti ti-arrow-right" id="icon-next-step-4"></i></button>
                                    </div>
                                </div>
                            </form>

                        </div>
                        <!-- 5 -->
                        <div id="step-5-validation" class="content">
                            <div class="content-header mb-3">
                                <h6 class="mb-0">Déroulement du projet</h6>
                            </div>
                            <form id="step-5-validation-form">
                                <div class="row g-3 validation-field">
                                    @csrf
                                    <input type="number" name="deadline_id" id="deadline_id" readonly class="d-none">
                                    <div class="row">
                                        <div class="col-6">
                                            <div class="row">
                                                <div class="col-10 mb-3">
                                                    <label class="form-label">Gestion de projet :</label>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio"
                                                            id="gestionProjetBoutEnBout" name="gestion_projet"
                                                            value="Bout en bout">
                                                        <label class="form-check-label" for="gestionProjetBoutEnBout">
                                                            Bout en bout
                                                        </label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio"
                                                            id="gestionProjetAgile" name="gestion_projet" value="Agile">
                                                        <label class="form-check-label" for="gestionProjetAgile">
                                                            Agile - être informé régulièrement de l’avancement du projet
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="col-10 mb-3">
                                                    <label>Communication :</label>
                                                    <br>
                                                    @php
                                                        $communications = [['name' => 'Téléphone', 'alias' => 'telephone'], ['name' => 'E-mail', 'alias' => 'email'], ['name' => 'Visio-conférences', 'alias' => 'visio_conference']];
                                                    @endphp
                                                    @foreach ($communications as $item)
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox"
                                                                id="communication_{{ $item['alias'] }}"
                                                                name="communication[]" value="{{ $item['name'] }}">
                                                            <label class="form-check-label"
                                                                for="communication_{{ $item['alias'] }}"">
                                                                {{ $item['name'] }}
                                                            </label>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="row">

                                                <div class="col-md-12 mb-3">
                                                    <div class="form-group">
                                                        <label class="form-label">Délais :</label>
                                                        <input type="text" class="form-control" id="delais"
                                                            name="deadline" placeholder="Délais">
                                                    </div>
                                                </div>
                                                <div class="col-md-12 mb-3">
                                                    <label class="form-label">Plage budgétaire :</label>
                                                    <div class="row">
                                                        <div class="col">
                                                            <div class="form-group">
                                                                <label class="form-label">Budget minimum :</label>
                                                                <div class="input-group input-group-merge">
                                                                    <span class="input-group-text">€</span>
                                                                    <input type="number" class="form-control"
                                                                        placeholder="00" id="budget_from"
                                                                        name="budget_from" />
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div
                                                            class="col-1 d-flex align-items-center justify-content-center">
                                                            <i class="m-auto mb-2 ti ti-arrow-big-right-filled"></i>
                                                        </div>
                                                        <div class="col">
                                                            <div class="form-group">
                                                                <label class="form-label">Budget maximum :</label>
                                                                <div class="input-group input-group-merge">
                                                                    <span class="input-group-text">€</span>
                                                                    <input type="number" class="form-control"
                                                                        placeholder="00" id="budget_to"
                                                                        name="budget_to" />
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <hr class="mb-3">

                                    <div class="col-12">
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="table-responsive text-nowrap">
                                                    <table class="table table table-bordered">
                                                        <thead>
                                                            <tr>
                                                                <td rowspan="15"
                                                                    style="text-align: center; vertical-align: middle;">
                                                                    Délais
                                                                    &
                                                                    Budgétisation</td>
                                                                <td>Désignation</td>
                                                                <td>Nombre de jours</td>
                                                                <td>Montant unitaire</td>
                                                                <td>Total HT</td>
                                                            </tr>
                                                            @php
                                                                $budgetisation = [
                                                                    [
                                                                        'title' => "Installation de l'environnement",
                                                                        'alias' => 'installation-environnement',
                                                                        'name' => 'installation_environment',
                                                                    ],
                                                                    [
                                                                        'title' => 'Intégration de la structure',
                                                                        'alias' => 'integration-structure',
                                                                        'name' => 'integration_structure',
                                                                    ],
                                                                    [
                                                                        'title' => 'Ebauche Des Textes et traductions',
                                                                        'alias' => 'ebauche-textes-traductions',
                                                                        'name' => 'draft_texts_translations',
                                                                    ],
                                                                    [
                                                                        'title' => 'Maquettage graphique',
                                                                        'alias' => 'maquettage-graphique',
                                                                        'name' => 'graphic_modeling',
                                                                    ],
                                                                    [
                                                                        'title' => 'Développement & intégrations web',
                                                                        'alias' => 'developpement-integrations-web',
                                                                        'name' => 'web_development_integrations',
                                                                    ],
                                                                    [
                                                                        'title' => 'Intégration des textes et images',
                                                                        'alias' => 'integration-textes-images',
                                                                        'name' => 'web_development_integrations',
                                                                    ],
                                                                    [
                                                                        'title' => "Intégration d'autres pages (contact, catégories ...etc.)",
                                                                        'alias' => 'integration-autres-pages',
                                                                        'name' => 'other_pages_integration',
                                                                    ],
                                                                    [
                                                                        'title' => 'Optimisation de la version Mobile',
                                                                        'alias' => 'optimisation-version-mobile',
                                                                        'name' => 'mobile_version_optimization',
                                                                    ],
                                                                    [
                                                                        'title' => 'Intégration du multilingue',
                                                                        'alias' => 'integration-multilingue',
                                                                        'name' => 'multilingual_integration',
                                                                    ],
                                                                    [
                                                                        'title' => 'Optimisation Pour SEO',
                                                                        'alias' => 'optimisation-seo',
                                                                        'name' => 'seo_optimisation',
                                                                    ],
                                                                    [
                                                                        'title' => 'Suivi et tests',
                                                                        'alias' => 'suivi-tests',
                                                                        'name' => 'testing_tracking',
                                                                    ],
                                                                    [
                                                                        'title' => 'Gestion de projets',
                                                                        'alias' => 'gestion-projet',
                                                                        'name' => 'project_management',
                                                                    ],
                                                                ];
                                                            @endphp
                                                            @foreach ($budgetisation as $item)
                                                                <tr>
                                                                    <td class="p-0 px-3 py-1">{{ $item['title'] }}</td>
                                                                    <td class="p-0 px-3 py-1">
                                                                        <input type="number"
                                                                            class="form-control form-control h-100"
                                                                            placeholder="00" id="nj-{{ $item['alias'] }}"
                                                                            name="number_of_days_{{ $item['name'] }}">
                                                                    </td>
                                                                    <td class="p-0 px-3 py-1">
                                                                        <div
                                                                            class="input-group input-group input-group-merge">
                                                                            <span class="input-group-text py-0">€</span>
                                                                            <input type="number"
                                                                                class="form-control py-1" placeholder="00"
                                                                                id="mu-{{ $item['alias'] }}"
                                                                                name="unit_amount_{{ $item['name'] }}" />
                                                                        </div>
                                                                    </td>
                                                                    <td class="p-0 px-3 py-1">
                                                                        <div
                                                                            class="input-group input-group input-group-merge">
                                                                            <span class="input-group-text py-0">€</span>
                                                                            <input type="number"
                                                                                class="form-control py-1" placeholder="00"
                                                                                readonly id="total-{{ $item['alias'] }}"
                                                                                name="total_{{ $item['name'] }}" />
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                            @endforeach
                                                            <tr>
                                                                <td class="p-0 px-3 py-1">Remise exceptionnelle </td>
                                                                <td class="p-0 px-3 py-1" colspan="3">
                                                                    <div class="input-group input-group-merge">
                                                                        <span class="input-group-text">€</span>
                                                                        <input type="number" class="form-control"
                                                                            placeholder="00" id="remise-exceptionnelle"
                                                                            name="exceptional_discount" />
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td class="p-0 px-3 py-1">Total (HT) </td>
                                                                <td class="p-0 px-3 py-1" colspan="3">
                                                                    <div class="input-group input-group-merge">
                                                                        <span class="input-group-text">€</span>
                                                                        <input type="number" class="form-control"
                                                                            placeholder="00" readonly id="total-total"
                                                                            name="total-total" />
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                        </thead>
                                                    </table>
                                                </div>
                                            </div>
                                            <hr class="my-5">
                                            <div id="pourcentages">
                                                @php
                                                    $index = 1;
                                                @endphp

                                                @for ($i = 1; $i <= 10; $i++)
                                                    <div class="row  @if ($index > 1) d-none @endif"
                                                        id="pourcentage-{{ $index }}">
                                                        <div class="col-2 mb-3">
                                                            <div class="form-group">
                                                                <label class="form-label"
                                                                    id="label-pourcentage-operation-{{ $index }}"
                                                                    for="pourcentage-operation-{{ $index }}">
                                                                    @if ($index == 1)
                                                                        Pourcentage à payer après la signature:
                                                                    @endif

                                                                </label>
                                                                <div class="input-group input-group-merge">
                                                                    <span class="input-group-text">%</span>
                                                                    <input type="number" class="form-control"
                                                                        id="pourcentage-operation-{{ $index }}"
                                                                        placeholder="00" />
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-9 d-flex flex-column mb-3">
                                                            <div class="row mt-auto">
                                                                <div class="align-items-end col-2 d-flex">
                                                                    <div class="input-group input-group-merge">
                                                                        <span class="input-group-text">€</span>
                                                                        <input type="number" class="form-control"
                                                                            placeholder="00"
                                                                            id="pourcentage-value-{{ $index }}"
                                                                            name="pourcentage-value-{{ $index }}"
                                                                            readonly>
                                                                    </div>
                                                                </div>

                                                                <div class="col-4">
                                                                    <label class="form-label"
                                                                        for="titre-operation-{{ $index }}">
                                                                        Titre de l'operation:
                                                                    </label>
                                                                    <input type="text" class="form-control"
                                                                        placeholder="Titre de l'operation"
                                                                        name="titre-operation-{{ $index }}"
                                                                        id="titre-operation-{{ $index }}"
                                                                        @if ($index == 1) value="Pourcentage à payer après la signature" @endif>
                                                                </div>
                                                                <div class="align-items-end col-auto d-flex">
                                                                    <div>
                                                                        <button type="button" data-bs-toggle="tooltip"
                                                                            data-bs-placement="top" title="Confirmer"
                                                                            class="btn btn-icon btn-label-success waves-effect waves-light"
                                                                            id="confirm-btn-{{ $index }}">
                                                                            <i class="ti ti-check"></i>
                                                                        </button>
                                                                    </div>
                                                                </div>
                                                                <div class="align-items-end col-auto d-flex">
                                                                    <div>
                                                                        <button type="button" data-bs-toggle="tooltip"
                                                                            data-bs-placement="top" title="Ajouter"
                                                                            class="btn btn-icon btn-primary waves-effect waves-light @if ($index >= 10) visibility-hidden @endif"
                                                                            id="plus-btn-{{ $index }}">
                                                                            <i class="ti ti-plus"></i>
                                                                        </button>
                                                                    </div>
                                                                </div>

                                                                <div class="align-items-end col-auto d-flex">
                                                                    @if ($index > 1)
                                                                        <div>
                                                                            <button type="button"
                                                                                data-bs-toggle="tooltip"
                                                                                data-bs-placement="top" title="Supprimer"
                                                                                class="btn btn-icon btn-danger waves-effect waves-light"
                                                                                id="delete-btn-{{ $index }}">
                                                                                <i class="ti ti-trash"></i>
                                                                            </button>
                                                                        </div>
                                                                    @endif
                                                                </div>

                                                            </div>
                                                        </div>
                                                        <div class="col-3"></div>
                                                    </div>
                                                    @php
                                                        $index++;
                                                    @endphp
                                                @endfor
                                                <div class="row">
                                                    <div
                                                        class="border border-2 border-end-0 border-start-0 col-auto py-3 rounded-3 mt-5">
                                                        <div class="form-group">
                                                            <label class="form-label fs-4"> <b> Le reste :</b> </label>
                                                            <div class="input-group input-group-merge">
                                                                <span class="input-group-text">€</span>
                                                                <input type="number" class="form-control"
                                                                    placeholder="00" id="reste" name="reste" />
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <hr class="my-5">
                                            <div class="row">

                                                <div class="col-2 mb-3">
                                                    <div class="form-group">
                                                        <label class="form-label fs-4"
                                                            id="label-pourcentage-operation-maintenance"
                                                            for="pourcentage-operation-maintenance">
                                                            <b> Maintenance :</b>
                                                        </label>
                                                        <div class="input-group input-group-merge">
                                                            <span class="input-group-text">%</span>
                                                            <input type="number" class="form-control"
                                                                id="pourcentage-operation-maintenance" placeholder="00"
                                                                value="20" />
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-9 d-flex flex-column mb-3">
                                                    <div class="row mt-auto">
                                                        <div class="align-items-end col-2 d-flex">
                                                            <div class="input-group input-group-merge">
                                                                <span class="input-group-text">€</span>
                                                                <input type="number" class="form-control"
                                                                    placeholder="00" id="pourcentage-value-maintenance"
                                                                    name="pourcentage-value-maintenance" readonly>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-12 d-flex justify-content-between">
                                        <button type="button" class="btn btn-label-secondary btn-prev"> <i
                                                class="ti ti-arrow-left me-sm-1 me-0"></i>
                                            <span class="align-middle d-sm-inline-block d-none">Précédent</span>
                                        </button>
                                        <button type="button" class="btn btn-success btn-next btn-submit"
                                            id="next-step-1">
                                            <span>
                                                Confirmer
                                            </span>
                                            <i class="ti ti-check" id="icon-next-step-5"></i>
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /Validation Wizard -->


    </div>

@endsection
