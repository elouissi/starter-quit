@extends('layouts/layoutMaster')

@section('title', 'Créer un cahier des charges')

@section('vendor-style')
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/bs-stepper/bs-stepper.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/bootstrap-select/bootstrap-select.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/select2/select2.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/@form-validation/umd/styles/index.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/sweetalert2/sweetalert2.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/spinkit/spinkit.css') }}" />

    <style>
        .visibility-hidden {
            visibility: hidden;
        }

        .text-limited {
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .user-select-none {
            user-select: none;
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
    <script>
        window.csrfToken = "{{ csrf_token() }}";
    </script>

    <script src="{{ asset('assets/js/form-wizard-validation-w-a.js') }}"></script>
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

        // function toggleLogo() {
        //     var fichierLogoGroup = document.getElementById("fichierLogoGroup");
        //     var logoOui = document.getElementById("logoOui");
        //     var fichierLogo = document.getElementById("fichierLogo");

        //     if (logoOui.checked) {
        //         fichierLogoGroup.style.display = "block";
        //         fichierLogo.required = true;
        //     } else {
        //         fichierLogoGroup.style.display = "none";
        //         fichierLogo.required = false;
        //     }
        // }

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

            $('#remise-exceptionnelle-percentage').on('input', function() {
                // Get the percentage value
                var percentage = parseFloat($(this).val());

                // Get the total value
                var total = parseFloat($('#total-total').val());

                // Calculate the discounted amount
                var discountedAmount = (percentage / 100) * total;

                // Set the discounted amount to the appropriate element
                $('#remise-exceptionnelle').val(discountedAmount.toFixed(2)); // Round to 2 decimal places
                $('#remise-exceptionnelle').trigger('input');
            });

            $(document).on('input', '.number-of-days', function() {
                var total = 0;
                $('.number-of-days').each(function() {
                    var value = parseFloat($(this).val()) ||
                        0; // Get the value as a float, default to 0 if NaN
                    total += value;
                });
                console.log('Total of all values: ' + total);

                $('#total-total-days').val(total);
            });

            ////

            $('.language-item:gt(2)').hide(); // Hide languages beyond the first three

            $('#voir-plus').click(function() {
                $('.language-item:hidden').show(); // Show next three hidden languages
                if ($('.language-item:hidden').length === 0) {
                    $('#voir-plus').hide(); // Hide the button if there are no more hidden languages
                }
            });

            ///
            generateByAi(`descriptionEntreprise`, 1);
            generateByAi(`activitePrincipale`, 1);
            generateByAi(`servicesProduits`, 1);
            generateByAi(`target_audience`, 1);
            generateByAi(`expectedObjectives`, 2);
            generateByAi(`iatext_techniques_specs`, 2);
            generateByAi(`iatext_menu`, 4);
            generateByAi(`iatext_competitors`, 3);
            generateByAi(`iatext_constraints`, 3);
            generateByAi(`iatext_target_keywords`, 2);
            generateByAi(`iatext_exemples_sites`, 4);
            $('input[name="project_type"]').change(function() {
                if ($(this).val() === 'E-commerce') {
                    $('#options-paiement-container').removeClass('d-none');
                } else {
                    $('#options-paiement-container').addClass('d-none');
                }
            });

            $('#nombrePropositions').change(function() {
                let numberOfPropositions = $(this).val();
                if ($(this).val() === 'autre') {
                    $('#autreProposition').val('')
                    $('#autrePropositionInput').show();
                } else {
                    $('#autreProposition').val(numberOfPropositions)
                    $('#autrePropositionInput').hide();
                }
            });

            for (let i = 1; i < 11; i++) {
                $(`#plus-btn-${i}`).click(function() {
                    console.log('clicked');
                    $(`#pourcentage-${i+1}`).removeClass('d-none');
                })

                $(`#titre-operation-${i}`).on('input', function() {
                    console.log($(this).val());
                    $(`#label-pourcentage-operation-${i}`).text($(this).val());
                });

                $(`#delete-btn-${i}`).click(function() {
                    $(`#pourcentage-value-${i}`).val('');
                    $(`#pourcentage-operation-${i}`).val('');
                    $(`#titre-operation-${i}`).val('');
                    calculReste();
                });

                $(`#pourcentage-operation-${i}`).on('input', function() {
                    calculReste();
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

            $('#next-step-1').on('click', function() {
                if (1) {
                    localStorage.removeItem('askToChatGpt');
                    console.log('eeeeee', $('#website').val());
                    let nomEntreprise = $('#website').val() ? $('#website').val() : $('#nomEntreprise')
                        .val();
                    console.log(nomEntreprise);

                    if (nomEntreprise) {
                        $('#descriptionEntrepriseAi').val(
                            `étant qu’expert en rédaction des cahiers des charges pour le développement d’un site internet, écrire moi un paragraphe sur description de ce client: ${nomEntreprise}`
                        ).prop('title',
                            `étant qu’expert en rédaction des cahiers des charges pour le développement d’un site internet, écrire moi un paragraphe sur description de ce client: ${nomEntreprise}`
                        ).trigger('input');

                        $('#activitePrincipaleAi').val(
                            `étant qu’expert en rédaction des cahiers des charges pour le développement d’un site internet, écrire moi un paragraphe sur l’activité de ce client: ${nomEntreprise}`
                        ).prop('title',
                            `étant qu’expert en rédaction des cahiers des charges pour le développement d’un site internet, écrire moi un paragraphe sur l’activité de ce client: ${nomEntreprise}`
                        ).trigger('input');

                        $('#servicesProduitsAi').val(
                            `étant qu’expert en rédaction des cahiers des charges pour le développement d’un site internet, écrire moi un paragraphe sur les services ou les produits vendu de ce client: ${nomEntreprise}`
                        ).prop('title',
                            `étant qu’expert en rédaction des cahiers des charges pour le développement d’un site internet, écrire moi un paragraphe sur les services ou les produits vendu de ce client: ${nomEntreprise}`
                        ).trigger('input');

                        $('#target_audienceAi').val(
                            `étant qu’expert en rédaction des cahiers des charges pour le développement d’un site internet, écrire moi un paragraphe sur le public cible de ce client : ${nomEntreprise}`
                        ).prop('title',
                            `étant qu’expert en rédaction des cahiers des charges pour le développement d’un site internet, écrire moi un paragraphe sur le public cible de ce client : ${nomEntreprise}`
                        ).trigger('input');
                    } else {
                        $('#descriptionEntrepriseAi').val(``).prop('title', ``).trigger('input');
                        $('#activitePrincipaleAi').val(``).prop('title', ``).trigger('input');
                        $('#servicesProduitsAi').val(``).prop('title', ``).trigger('input');
                        $('#target_audienceAi').val(``).prop('title', ``).trigger('input');
                    }

                    if ($('#descriptionEntrepriseAi').val() && (!$('#descriptionEntreprise').val())) {
                        $('#descriptionEntrepriseAi-generate').click();
                    }
                    // setTimeout(() => {
                    if ($('#activitePrincipaleAi').val() && (!$('#activitePrincipale').val())) {
                        $('#activitePrincipaleAi-generate').click();
                    }
                    // }, 10000);
                    // setTimeout(() => {
                    if ($('#servicesProduitsAi').val() && (!$('#servicesProduits').val())) {
                        $('#servicesProduitsAi-generate').click();
                    }
                    // }, 20000);
                    // setTimeout(() => {
                    if ($('#target_audienceAi').val() && (!$('#target_audience').val())) {
                        $('#target_audienceAi-generate').click();
                    }
                }
            });

            // $('#has_website_non').click(function() {
            //     // TODO
            //     // $('#target_audienceAi-generate').click();
            // });

            // $('#website').on('blur', function() {
            //     // TODO
            //     // $('#target_audienceAi-generate').click();
            // });

            $('#next-step-2').on('click', function() {
                let objectifsAttendus = $('#objectifsAttendus').val();
                console.log(objectifsAttendus);
                if (objectifsAttendus) {
                    $('#expectedObjectivesAi').val(
                        `étant qu’expert en rédaction des cahiers des charges pour le développement d’un site internet, les objectifs : (${objectifsAttendus}), réécrire moi un paragraphe sur les objectifs attendu de ce client`
                    ).prop('title',
                        `étant qu’expert en rédaction des cahiers des charges pour le développement d’un site internet, les objectifs : (${objectifsAttendus}), réécrire moi un paragraphe sur les objectifs attendu de ce client`
                    ).trigger('input');
                } else {
                    $('#expectedObjectivesAi').val('').prop('title', '').trigger('input');
                }

                if ($('#expectedObjectivesAi').val() && !$('#expectedObjectives').val()) {
                    // TODO
                    $('#expectedObjectives').text('');
                    $('#expectedObjectivesAi-generate').click();
                }
                // TODO
            });

            $('#next-step-2').on('click', function() {
                let target_keywords = $('#target_keywords').val().split('\n').join(',');
                console.log(target_keywords);

                if (target_keywords) {
                    $('#iatext_target_keywordsAi').val(
                        `dans la section de Stratégies de Référencement en Mots-clés cibles sur le cahier de
  charge de son site internet à envoyer au client merci d'élaborer cette phrase dans deux
  paragraphes : (${target_keywords})`
                    ).prop('title',
                        `dans la section de Stratégies de Référencement en Mots-clés cibles sur le cahier de
  charge de son site internet à envoyer au client merci d'élaborer cette phrase dans deux
  paragraphes : (${target_keywords})`
                    ).trigger('input');
                } else {
                    $('#iatext_target_keywordsAi').val('').prop('title', '').trigger('input');
                }

                if ($('#iatext_target_keywordsAi').val() && !$('#iatext_target_keywords').val()) {

                    // TODO
                    $('#iatext_target_keywords').text('');
                    $('#iatext_target_keywordsAi-generate').click();
                }
            });

            $('#next-step-2').on('click', function() {
                let menu = $('#menu').val();
                var project_type = $('input[name="project_type"]').val();
                var servicesProduits = $('#servicesProduits').val();
                console.log(menu);
                console.log(project_type);
                console.log(servicesProduits);
                if (menu) {

                    console.log(
                        `à partir de cette liste de menu : [${menu}], rédiger et designer moi une sitemap (arborescence) pour un site Internet [${project_type}] de [${servicesProduits}]`
                    );
                    $('#iatext_menuAi').val(
                        `à partir de cette liste de menu : [${menu}], rédiger et designer moi une sitemap (arborescence) pour un site Internet [${project_type}] de [${servicesProduits}]`
                    ).prop('title',
                        `à partir de cette liste de menu : [${menu}], rédiger et designer moi une sitemap (arborescence) pour un site Internet [${project_type}] de [${servicesProduits}]`
                    ).trigger('input');


                    if ($('#iatext_menuAi').val() && !$('#iatext_menu').val()) {

                        // TODO
                        $('#iatext_menu').text('');
                        $('#iatext_menuAi-generate').click();
                    }

                    // TODO
                }
            });


            $('#next-step-2').on('click', function() {
                let techniques_specs = $('#techniques_specs').val();
                console.log(techniques_specs);

                console.log(
                    `étant qu’expert en rédaction des cahiers des charges pour le développement d’un site internet, récrire moi en 3 paragraphes les spécifications techniques (${techniques_specs}) que le client souhaite avoir sur son site`
                );
                if (techniques_specs) {
                    $('#iatext_techniques_specsAi').val(
                        `étant qu’expert en rédaction des cahiers des charges pour le développement d’un site internet, récrire moi en 3 paragraphes les spécifications techniques (${techniques_specs}) que le client souhaite avoir sur son site`
                    ).prop('title',
                        `étant qu’expert en rédaction des cahiers des charges pour le développement d’un site internet, récrire moi en 3 paragraphes les spécifications techniques (${techniques_specs}) que le client souhaite avoir sur son site`
                    ).trigger('input');
                }

                if ($('#iatext_techniques_specsAi').val() && !$('#iatext_techniques_specs').val()) {
                    // TODO
                    $('#iatext_techniques_specs').text('');
                    $('#iatext_techniques_specsAi-generate').click();
                }
            });

            $('#next-step-3').on('click', function() {
                let concurrents = $('#concurrents').val().split('\n').join(',');
                console.log(concurrents);

                if (concurrents) {
                    $('#iatext_competitorsAi').val(
                        `voici les concurrents (${concurrents}), étant qu’expert en rédaction des cahiers des charges pour le développement d’un site internet, écrire moi deux paragraphe sur l’analyse des principaux concurrents et identification des points forts à intégrer sur le site internet que le client souhaite`
                    ).prop('title',
                        `voici les concurrents (${concurrents}), étant qu’expert en rédaction des cahiers des charges pour le développement d’un site internet, écrire moi deux paragraphe sur l’analyse des principaux concurrents et identification des points forts à intégrer sur le site internet que le client souhaite`
                    ).trigger('input');
                } else {
                    $('#iatext_competitorsAi').val('').prop('title', '').trigger('input');
                }

                if ($('#iatext_competitorsAi').val() && !$('#iatext_competitors').val()) {

                    // TODO
                    $('#iatext_competitors').text('');
                    $('#iatext_competitorsAi-generate').click();
                }
            });



            $('#next-step-4').on('click', function() {
                let exemples_sites = $('#exemples-sites').val().split('\n').join(',');
                console.log(exemples_sites);

                console.log(
                    `écrire un paragraphe détaillé pour élaborer Les éléments suivants (${exemples_sites}) que le client voulait inclure sur le
site internet sur le cahier de charge de son site internet`
                );
                if (exemples_sites) {
                    $('#iatext_exemples_sitesAi').val(
                        `écrire un paragraphe détaillé pour élaborer Les éléments suivants (${exemples_sites}) que le client voulait inclure sur le
site internet sur le cahier de charge de son site internet`
                    ).prop('title',
                        `écrire un paragraphe détaillé pour élaborer Les éléments suivants (${exemples_sites}) que le client voulait inclure sur le
site internet sur le cahier de charge de son site internet`
                    ).trigger('input');
                } else {
                    $('#iatext_exemples_sitesAi').val(
                        ``
                    ).prop('title',
                        ``
                    ).trigger('input');
                }


                if ($('#iatext_exemples_sitesAi').val() && !$('#iatext_exemples_sites').val()) {
                    // TODO
                    $('#iatext_exemples_sites').text('');
                    $('#iatext_exemples_sitesAi-generate').click();
                }
            });

            $('#next-step-3').on('click', function() {
                let contraintes = $('#contraintes').val();
                console.log(contraintes);

                console.log(
                    `étant qu’expert en rédaction des cahiers des charges pour le développement d’un site internet, récrire moi en 3 paragraphes les spécifications techniques (${contraintes}) que le client souhaite avoir sur son site`
                );
                if (contraintes) {
                    $('#iatext_constraintsAi').val(
                        `étant qu’expert en rédaction des cahiers des charges pour le développement d’un site internet, récrire moi en 3 paragraphes les spécifications techniques (${contraintes}) que le client souhaite avoir sur son site`
                    ).prop('title',
                        `étant qu’expert en rédaction des cahiers des charges pour le développement d’un site internet, récrire moi en 3 paragraphes les spécifications techniques (${contraintes}) que le client souhaite avoir sur son site`
                    ).trigger('input');
                } else {
                    $('#iatext_constraintsAi').val(
                        ``
                    ).prop('title',
                        ``
                    ).trigger('input');
                }


                if ($('#iatext_constraintsAi').val() && !$('#iatext_constraints').val()) {

                    // TODO
                    $('#iatext_constraints').text('');
                    $('#iatext_constraintsAi-generate').click();
                }
            });
        });

        function generateByAi(element, step) {
            $(`#${element}Ai`).on("input", function() {
                if ($(`#${element}Ai`).val().trim().length > 3) {
                    $(`#${element}Ai-generate`).prop("disabled", false);
                } else {
                    $(`#${element}Ai-generate`).prop("disabled", true);
                }
            });
            if (!$(`#${element}Ai-generate`).data('errorCount')) {
                $(`#${element}Ai-generate`).data('errorCount', 0);
            }

            $(`#${element}Ai-generate`).click(function() {
                $(`#${element}Ai-generate`).html(
                    `<i class="ti ti-loader rotate"></i> &nbsp; Chargement ...`);
                $(`#${element}Ai-generate`).prop("disabled", true);
                $(`#${element}`).text('');
                var promptText = $(`#${element}Ai`).val();
                $(`#${element}`).text('loading');
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
                        window.localStorage.setItem('askToChatGpt', element);
                        $(`#next-step-${step}`).removeClass('disabled');
                        $(`#icon-next-step-${step}`).removeClass().addClass('ti ti-arrow-right');
                        console.log('success');
                    },
                    error: function(xhr, status, error) {
                        let errorCount = $(`#${element}Ai-generate`).data('errorCount');
                        if (errorCount < 5) { // Check if error count is less than 5
                            errorCount++; // Increment error count
                            $(`#${element}Ai-generate`).data('errorCount', errorCount);
                            setTimeout(() => {
                                $(`#${element}Ai-generate`).html(
                                    `<i class="ti ti-file-text-ai"></i> &nbsp; Générer`);
                                $(`#${element}Ai-generate`).prop("disabled", false);
                                $(`#${element}Ai-generate`).click();
                            }, 10000);
                        } else {
                            $(`#${element}`).text("error");
                            console.error("Error occurred 5 times. Stopping further error handling.");
                        }
                        console.error({
                            xhr,
                            status,
                            error
                        });
                    }
                });
            });

            $('input[name="has_website"]').change(function() {
                if ($(this).val() === 'oui') {
                    $('#websiteInput').show();
                } else {
                    $('#websiteInput').hide();
                }
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

            $('#total-total').val((total - remise_exceptionnelle).toFixed(2))
        }

        function calculMaintenance() {
            let pourcentageMaintenance = $('#pourcentage-operation-maintenance').val() ? parseFloat($(
                `#pourcentage-operation-maintenance`).val()) : 0;
            let total = $(`#total-total`).val() ? parseFloat($(`#total-total`).val()) : 0;
            let percentageAmount = (pourcentageMaintenance / 100) * total;
            $('#pourcentage-value-maintenance').val((percentageAmount).toFixed(2));
        }

        function calculReste() {
            for (let i = 1; i < 11; i++) {
                let total = $(`#total-total`).val() ? parseFloat($(`#total-total`).val()) : 0;
                let percentageNumber = $(`#pourcentage-operation-${i}`).val();
                var percentageAmount = (percentageNumber / 100) * total;
                $(`#pourcentage-value-${i}`).val((percentageAmount).toFixed(2));
                let reste = 0;
                let totalAvance = 0;
                for (let i = 1; i < 11; i++) {
                    let avanceValue = $(`#pourcentage-value-${i}`).val() ?
                        parseFloat($(`#pourcentage-value-${i}`).val()) : 0;
                    totalAvance += avanceValue;
                }
                $('#reste').val((total - totalAvance).toFixed(2));
            }
        }
    </script>
    <script>
        $(document).ready(function() {
            $('[data-toggle="tooltip"]').tooltip();

            elementFournisOuCreer('logo', 'logo', 'logo');
            elementFournisOuCreer('charte-graphique', 'graphical_charter', 'charte graphique');
            elementFournisOuCreer('wireframe', 'wireframe', 'Maquette / Wireframe');
            elementFournisOuCreer('typography', 'typography', `Typographies (police d'ecriture)`);
            elementFournisOuCreer('description-product-services', 'description_product_services',
                "Desc services/ produits");


        });

        function elementFournisOuCreer(el, elName, name) {
            $(`input[name="${elName}"]`).change(function() {
                if ($(this).val() === 'oui') {
                    $(`#${el}-file-upload`).removeClass('d-none');
                    $(`#${el}-file-upload-span`).removeClass('d-none');
                } else {
                    $(`#${el}-file-upload`).val('');
                    $(`#${el}-file`).val('');
                    $(`#${el}-file`).trigger('change');
                    $(`#${el}-file-upload-span`).addClass('d-none');
                    $(`#${el}-file-upload`).addClass('d-none');
                    $(`#${el}-file-upload-span`).text(`Aucun fichier`);
                }
            });

            $(`#${el}-file-upload`).click(function() {
                $(`#${el}-file`).click();
            });

            $(`#${el}-file`).change(function() {
                var fileName = $(this).val().split('\\').pop() ? $(this).val().split('\\').pop() :
                    `Aucun fichier`;
                $(`#${el}-file-upload-span`).text(fileName);
                $(`#${el}-file-upload-span`).prop('title', fileName);
                $(`#${el}-file-upload-span`).click();
                $(`#${el}-file-upload-span`).trigger('click');
            });
        }
    </script>
    <script src="{{ asset('assets/js/ui-popover.js') }}"></script>
@endsection

@section('content')
    <h4 class="py-3 mb-4">
        <span class="text-muted fw-light">Cahier des charges/</span> Web / Site d'Affiliation
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
                    <div class="step" data-target="#step-6-validation">
                        <button type="button" class="step-trigger">
                            <span class="bs-stepper-circle">6</span>
                            <span class="bs-stepper-label">
                                <span class="bs-stepper-title">Confirmation </span>
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
                                                <label class="form-label" for="nomEntreprise">Nom de l'entreprise <span
                                                        class="text-danger">*</span> </label>
                                                <input type="text" name="entreprise_name" id="nomEntreprise"
                                                    class="form-control" placeholder="Nom de l'entreprise" />
                                            </div>
                                            <div class="col-10 mb-3">
                                                <label class="form-label">Avez-vous un site web ?</label><br>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="has_website"
                                                        id="has_website_oui" value="oui">
                                                    <label class="form-check-label" for="has_website_oui">Oui</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="has_website"
                                                        id="has_website_non" value="non">
                                                    <label class="form-check-label" for="has_website_non">Non</label>
                                                </div>
                                            </div>
                                            <div id="websiteInput" class="col-10 mb-3" style="display: none;">
                                                <label class="form-label" for="website">Site web de l'entreprise</label>
                                                <input type="text" name="website_domaine" id="website"
                                                    class="form-control" placeholder="URL du site web" />
                                            </div>
                                            <div class="col-10 mb-3">
                                                <label class="form-label" for="personneContacte">Personne à
                                                    contacter <span class="text-danger">*</span></label>
                                                <input type="text" name="contact_person" id="personneContacte"
                                                    class="form-control"
                                                    placeholder="Personne à contacter (nom et prénom)" />
                                            </div>

                                        </div>

                                    </div>
                                    <div class="col-sm-6">
                                        <div class="row">
                                            <div class="col-12 mb-3">
                                                <label class="form-label" for="telephone">Téléphone <span
                                                        class="text-danger">*</span></label>
                                                <input type="tel" name="phone" id="telephone" class="form-control"
                                                    placeholder="Numéro de téléphone" />
                                            </div>
                                            <div class="col-12 mb-3">
                                                <label class="form-label" for="email">Email <span
                                                        class="text-danger">*</span></label>
                                                <input type="email" name="email" id="email" class="form-control"
                                                    placeholder="Adresse email" />
                                            </div>
                                            <div class="col-12 mb-3">
                                                <label class="form-label" for="cible">
                                                    Cible

                                                </label>
                                                <input type="text" name="target" id="cible" class="form-control"
                                                    placeholder="Cible">
                                            </div>
                                            <div class="col-12 mb-3 d-none ai-content">
                                                <label class="form-label" for="descriptionEntreprise">
                                                    Description de l'entreprise (ai content)
                                                </label>
                                                <div class="input-group mb-1">
                                                    <input type="text" class="form-control" name="prompt_description"
                                                        placeholder="Créer votre prompt" readonly
                                                        id="descriptionEntrepriseAi">
                                                    <button class="btn btn-outline-primary ai-generate-button"
                                                        type="button" id="descriptionEntrepriseAi-generate" disabled>
                                                        <i class="ti ti-file-text-ai"></i> &nbsp; Générer
                                                    </button>
                                                </div>
                                                <textarea name="iatext_description" id="descriptionEntreprise" class="form-control" rows="3" readonly
                                                    placeholder="Description de l'entreprise"></textarea>
                                            </div>
                                            <div class="col-12 mb-3  d-none ai-content">
                                                <label class="form-label" for="activitePrincipale">
                                                    Activité principale de l'entreprise (ai content)
                                                </label>
                                                <div class="input-group mb-1">
                                                    <input type="text" class="form-control" readonly
                                                        name="prompt_main_activities" placeholder="Créer votre prompt"
                                                        id="activitePrincipaleAi">
                                                    <button class="btn btn-outline-primary ai-generate-button"
                                                        type="button" id="activitePrincipaleAi-generate" disabled>
                                                        <i class="ti ti-file-text-ai"></i> &nbsp; Générer
                                                    </button>
                                                </div>
                                                <textarea name="iatext_main_activities" id="activitePrincipale" class="form-control" rows="3" readonly
                                                    placeholder="Activité principale de l'entreprise"></textarea>
                                            </div>
                                            <div class="col-12 mb-3  d-none ai-content">
                                                <label class="form-label" for="servicesProduits">
                                                    Services ou produits vendus (ai content)
                                                </label>
                                                <div class="input-group mb-1">
                                                    <input type="text" class="form-control"
                                                        name="prompt_services_products" readonly
                                                        placeholder="Créer votre prompt" id="servicesProduitsAi">
                                                    <button class="btn btn-outline-primary ai-generate-button"
                                                        type="button" id="servicesProduitsAi-generate" disabled>
                                                        <i class="ti ti-file-text-ai"></i> &nbsp; Générer
                                                    </button>
                                                </div>
                                                <textarea name="iatext_services_products" id="servicesProduits" class="form-control" rows="3" readonly
                                                    placeholder="Services ou produits vendus"></textarea>
                                            </div>
                                            <div class="col-12 mb-3  d-none ai-content">
                                                <label class="form-label" for="target_audience">
                                                    Public Cible (ai content)
                                                </label>
                                                <div class="input-group mb-1">
                                                    <input type="text" class="form-control"
                                                        name="prompt_target_audience" readonly
                                                        placeholder="Créer votre prompt" id="target_audienceAi">
                                                    <button class="btn btn-outline-primary ai-generate-button"
                                                        type="button" id="target_audienceAi-generate" disabled>
                                                        <i class="ti ti-file-text-ai"></i> &nbsp; Générer
                                                    </button>
                                                </div>
                                                <textarea name="iatext_target_audience" id="target_audience" class="form-control" rows="3"
                                                    placeholder="Activité principale de l'entreprise" readonly></textarea>
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
                                            <div class="col-10 mb-3">
                                                <label class="form-label" for="besoinProjet">Besoin de projet : <span
                                                        class="text-danger">*</span></label>
                                                @php
                                                    $project_needs = [
                                                        ['name' => 'Refonte de site web', 'alias' => 'refonte'],
                                                        ['name' => 'Création de site web', 'alias' => 'creation'],
                                                    ];
                                                @endphp
                                                <div class="row">
                                                    @foreach ($project_needs as $item)
                                                        <div class="col-auto">
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="radio"
                                                                    id="besoin_{{ $item['alias'] }}" name="project_need"
                                                                    value="{{ $item['name'] }}">
                                                                <label class="form-check-label"
                                                                    for="besoin_{{ $item['alias'] }}">
                                                                    {{ $item['name'] }}
                                                                </label>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                            <div class="col-10 mb-3">
                                                <label class="form-label">Type de projet : <span
                                                        class="text-danger">*</span></label>
                                                @php
                                                    $project_needs = [
                                                        
                                                        ['name' => "Site d'affiliation", 'alias' => 'siteAffiliation']
                                                    ];
                                                @endphp
                                                <div class="row">
                                                    @foreach ($project_needs as $item)
                                                        <div class="col-auto">
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="radio"
                                                                    id="siteAffiliation" name="project_type" checked
                                                                    value="Site d'affiliation">
                                                                <label class="form-check-label"
                                                                    for="siteAffiliation">
                                                                    Site d'affiliation"</label>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                            <div class="col-12 mb-3 " id="options-paiement-container">
                                                <label class="form-label">Options de paiement :</label>
                                                @php
                                                    $payment_options = [
                                                        ['name' => 'Stripe', 'alias' => 'stripe'],
                                                        ['name' => 'Paypal', 'alias' => 'payment'],
                                                        ['name' => 'COD (Paiement à la livraison)', 'alias' => 'cod'],
                                                        ['name' => 'Demande de devis', 'alias' => 'demande_devis'],
                                                        ['name' => 'Aucun', 'alias' => 'aucun'],
                                                    ];
                                                @endphp
                                                <div class="row">
                                                    @foreach ($payment_options as $item)
                                                        <div class="col-auto">
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox"
                                                                    id="paiement_{{ $item['alias'] }}"
                                                                    name="payment_options[]" value="{{ $item['name'] }}">
                                                                <label class="form-check-label"
                                                                    for="paiement_{{ $item['alias'] }}">{{ $item['name'] }}</label>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                            <div class="col-10 mb-3"> <label class="form-label">Langue : <span
                                                        class="text-danger">*</span></label>
                                                 @php
                                                    $languages = [
                                                        ['name' => 'Français', 'alias' => 'fr'],
                                                        ['name' => 'Anglais', 'alias' => 'en'],
                                                        ['name' => 'Italien', 'alias' => 'it'],
                                                    ];
                                                @endphp 
                                                {{-- <div class="row">
                                                    @foreach ($languages as $item)
                                                        <div class="col-auto">
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox"
                                                                    id="langue_{{ $item['alias'] }}" name="languages[]"
                                                                    value="{{ $item['name'] }}">
                                                                <label class="form-check-label"
                                                                    for="langue_{{ $item['alias'] }}">{{ $item['name'] }}</label>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div> --}}

                                                <div class="row languages-container">
                                                    @foreach ($languages as $item)
                                                        <div class="col-auto language-item">
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox"
                                                                    id="langue_{{ $loop->index }}" name="languages[]"
                                                                    value="{{ $item['name'] }}">
                                                                <label class="form-check-label"
                                                                    for="langue_{{ $loop->index }}">{{ $item['name'] }}</label>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                    <span id="voir-plus" style="cursor: pointer"
                                                        class="text-primary">Voir plus</span>
                                                </div>
                                            </div>
                                            <div class="col-10 mb-3">
                                                <label class="form-label" for="menu">
                                                    Mots-clés cibles (Avez-vous des mots-clés spécifiques à cibler sur le
                                                    site) :
                                                </label>
                                                <textarea class="form-control" name="target_keywords" rows="3" id="target_keywords"
                                                    placeholder="Saisissez vos mots-clés cibles pour le site"></textarea>
                                            </div>
                                            <div class="col-10 mb-3  d-none ai-content">
                                                <label class="form-label" for="iatext_target_keywordsAi">
                                                    Mots-clés cibles (ai content)
                                                </label>
                                                <div class="input-group mb-1">
                                                    <input type="text" class="form-control"
                                                        name="prompt_iatext_target_keywords" readonly
                                                        placeholder="Créer votre prompt" id="iatext_target_keywordsAi">
                                                    <button class="btn btn-outline-primary ai-generate-button"
                                                        type="button" id="iatext_target_keywordsAi-generate" disabled>
                                                        <i class="ti ti-file-text-ai"></i> &nbsp; Générer
                                                    </button>
                                                </div>
                                                <textarea name="iatext_target_keywords" id="iatext_target_keywords" class="form-control" rows="3" readonly></textarea>
                                            </div>
                                            <div class="col-10 mb-3">
                                                <label class="form-label" for="objectifsAttendus">
                                                    Objectifs attendus :
                                                </label>
                                                <textarea name="expected_objectives" id="objectifsAttendus" class="form-control"
                                                    placeholder="Entrez les objectifs attendus" rows="3"></textarea>
                                            </div>
                                            <div class="col-10 mb-3  d-none ai-content">
                                                <label class="form-label" for="expectedObjectives">
                                                    Objectifs attendus du client (ai content)
                                                </label>
                                                <div class="input-group mb-1">
                                                    <input type="text" class="form-control"
                                                        name="prompt_expected_client_objectives" readonly
                                                        placeholder="Créer votre prompt" id="expectedObjectivesAi">
                                                    <button class="btn btn-outline-primary ai-generate-button"
                                                        type="button" id="expectedObjectivesAi-generate" disabled>
                                                        <i class="ti ti-file-text-ai"></i> &nbsp; Générer
                                                    </button>
                                                </div>
                                                <textarea name="iatext_expected_client_objectives" id="expectedObjectives" class="form-control" rows="3"
                                                    readonly placeholder="Activité principale de l'entreprise"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="row">
                                            <div class="col-12 mb-3"><label class="form-label">Fonctions attendues
                                                    : <span class="text-danger">*</span></label>
                                                <div class="row">
                                                    @foreach ($expected_functions as $item)
                                                        <div class="col-4">
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox"
                                                                    id="{{ $item->alias }}" name="expected_functions[]"
                                                                    value="{{ $item->name }}">
                                                                <label class="form-check-label"
                                                                    for="{{ $item->alias }}">
                                                                    {{ $item->name }}
                                                                </label>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>


                                            <div class="col-12 mb-3">
                                                <label class="form-label" for="menu">
                                                    Menu (Avez vous une préférence des menus à ajouter sur le site) : <span
                                                        class="text-danger">*</span>
                                                </label>
                                                <textarea class="form-control" id="menu" name="menu" rows="3"
                                                    placeholder="Indiquez votre préférence des menus à ajouter sur le site"></textarea>
                                            </div>
                                            <div class="col-12 mb-3 d-none ai-content">
                                                <label class="form-label" for="iatext_menuAi">
                                                    Menu (ai content)
                                                </label>
                                                <div class="input-group mb-1">
                                                    <input type="text" class="form-control" name="prompt_iatext_menu"
                                                        readonly placeholder="Créer votre prompt" id="iatext_menuAi">
                                                    <button class="btn btn-outline-primary ai-generate-button"
                                                        type="button" id="iatext_menuAi-generate" disabled>
                                                        <i class="ti ti-file-text-ai"></i> &nbsp; Générer
                                                    </button>
                                                </div>
                                                <textarea name="iatext_menu" id="iatext_menu" class="form-control" rows="3" readonly></textarea>
                                            </div>
                                            <div class="col-12 mb-3">
                                                <label class="form-label" for="techniques_specs">Spécifications Techniques
                                                    :</label>
                                                <textarea class="form-control" id="techniques_specs" name="techniques_specs" rows="3"
                                                    placeholder="Entrez les spécifications techniques"></textarea>
                                            </div>
                                            <div class="col-12 mb-3 d-none ai-content">
                                                <label class="form-label" for="iatext_techniques_specsAi">Spécifications
                                                    Techniques (ai content)
                                                </label>
                                                <div class="input-group mb-1">
                                                    <input type="text" class="form-control"
                                                        name="prompt_iatext_techniques_specs" readonly
                                                        placeholder="Créer votre prompt" id="iatext_techniques_specsAi">
                                                    <button class="btn btn-outline-primary ai-generate-button"
                                                        type="button" id="iatext_techniques_specsAi-generate" disabled>
                                                        <i class="ti ti-file-text-ai"></i> &nbsp; Générer
                                                    </button>
                                                </div>
                                                <textarea name="iatext_techniques_specs" id="iatext_techniques_specs" class="form-control" rows="3" readonly
                                                    placeholder="Activité principale de l'entreprise"></textarea>
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
                                            <div class="col-10 mb-3 d-none ">
                                                <label class="form-label" for="concurrents">
                                                    Site internet de vos principaux concurrents : <span
                                                        class="text-danger">*</span>
                                                </label>
                                                <textarea class="form-control" id="concurrents" name="competitors" rows="3"
                                                    placeholder="Saisissez les sites internet de vos principaux concurrents"></textarea>
                                            </div>
                                            <div class="col-10 mb-3 d-none ai-content">
                                                <label class="form-label" for="iatext_competitors">
                                                    Concurrence (ai content)
                                                </label>
                                                <div class="input-group mb-1">
                                                    <input type="text" class="form-control"
                                                        name="prompt_iatext_competitors" placeholder="Créer votre prompt"
                                                        readonly id="iatext_competitorsAi">
                                                    <button class="btn btn-outline-primary ai-generate-button"
                                                        type="button" id="iatext_competitorsAi-generate" disabled>
                                                        <i class="ti ti-file-text-ai"></i> &nbsp; Générer
                                                    </button>
                                                </div>
                                                <textarea name="iatext_competitors" id="iatext_competitors" class="form-control" rows="3" readonly
                                                    placeholder="Activité principale de l'entreprise"></textarea>
                                            </div>
                                            <div class="col-sm-6 col-md-10">
                                                <div class="form-group">
                                                    <label for="exemples-sites" class="form-label">
                                                        Exemples de sites avec commentaire :
                                                    </label>
                                                    <textarea id="exemples-sites" class="form-control" name="sample_sites" rows="3"
                                                        placeholder="Ajoutez des exemples de sites que vous aimez avec des commentaires sur ce que vous aimez bien sur ces sites (éléments, animation, couleurs, architecture d’informations, fonctionnalités, etc.)."></textarea>
                                                </div>
                                            </div>
                                            <div class="col-sm-6 col-md-10">
                                                <div class="form-group">
                                                    <label for="telecharger-images-1" class="form-label">
                                                        Télécharger des images :
                                                    </label>
                                                    <input type="file" class="form-control" id="telecharger-images-1"
                                                        name="sample_sites_files[]"
                                                        accept=".jpg, .jpeg, .png, .gif, .svg, .webp, .pdf, .doc, .docx"
                                                        multiple>
                                                    <small id="images-help" class="form-text text-muted">
                                                        Vous pouvez télécharger des images pour illustrer vos commentaires
                                                        sur les sites.
                                                    </small>
                                                    <div class="row my-3" id="sample_sites_files_container">

                                                    </div>
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
                                                    <textarea class="form-control" id="contraintes" name="constraints" rows="3"
                                                        placeholder="Veuillez fournir des exemples de sites internet que vous appréciez et décrire les éléments que vous aimez."></textarea>
                                                </div>
                                            </div>
                                            <div class="col-12 mb-3 d-none ai-content">
                                                <label class="form-label" for="iatext_constraintsAi">
                                                    Contraintes (ai content)
                                                </label>
                                                <div class="input-group mb-1">
                                                    <input type="text" class="form-control"
                                                        name="prompt_iatext_constraints" placeholder="Créer votre prompt"
                                                        readonly id="iatext_constraintsAi">
                                                    <button class="btn btn-outline-primary ai-generate-button"
                                                        type="button" id="iatext_constraintsAi-generate" disabled>
                                                        <i class="ti ti-file-text-ai"></i> &nbsp; Générer
                                                    </button>
                                                </div>
                                                <textarea name="iatext_constraints" id="iatext_constraints" class="form-control" rows="3" readonly
                                                    placeholder="Activité principale de l'entreprise"></textarea>
                                            </div>
                                            <div class="col-12 mb-3">
                                                <div class="form-group">
                                                    <label for="telecharger-images-2" class="form-label">
                                                        Télécharger des images:
                                                    </label>
                                                    <input type="file" class="form-control" id="telecharger-images-2"
                                                        name="constraints_files[]"
                                                        accept=".jpg, .jpeg, .png, .gif, .svg, .webp, .pdf, .doc, .docx"
                                                        multiple>
                                                    <small id="images-help" class="form-text text-muted">
                                                        Vous pouvez télécharger des images pour illustrer vos commentaires
                                                        sur les sites.
                                                    </small>
                                                    <div class="row my-3" id="constraints_files_container"></div>
                                                </div>
                                            </div>
                                            <div class="col-12 mb-3">
                                                <div class="col-sm-6  col-md-12">
                                                    <div class="form-group">
                                                        <label class="form-label">Avez-vous un nom de domaine ? <span
                                                                class="text-danger">*</span></label>
                                                        <div class="radio-group">
                                                            <div class="row">
                                                                <div class="col-auto">
                                                                    <div class="form-check pe-3">
                                                                        <input class="form-check-input" type="radio"
                                                                            id="domaineOui" name="domain" value="Oui"
                                                                            onchange="toggleNomDomaine()">
                                                                        <label class="form-check-label"
                                                                            for="domaineOui">Oui</label>
                                                                    </div>
                                                                </div>
                                                                <div class="col-auto">
                                                                    <div class="form-check">
                                                                        <input class="form-check-input" type="radio"
                                                                            id="domaineNon" name="domain" value="Non"
                                                                            onchange="toggleNomDomaine()">
                                                                        <label class="form-check-label"
                                                                            for="domaineNon">Non</label>
                                                                    </div>
                                                                </div>
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
                                            {{-- <div class="col-12 mb-3">
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
                                            </div> --}}
                                            <div class="col-12 mb-3">
                                                <div class="col-sm-6 col-md-12">
                                                    <div class="form-group">
                                                        <label class="form-label">Avez-vous un hébergement ? <span
                                                                class="text-danger">*</span></label>
                                                        <div class="radio-group">
                                                            <div class="row">
                                                                <div class="col-auto">
                                                                    <div class="form-check pe-3">
                                                                        <input class="form-check-input" type="radio"
                                                                            id="hebergementOui" name="hosting"
                                                                            value="Oui" onchange="toggleHebergement()">
                                                                        <label class="form-check-label"
                                                                            for="hebergementOui">Oui</label>
                                                                    </div>
                                                                </div>
                                                                <div class="col-auto">
                                                                    <div class="form-check">
                                                                        <input class="form-check-input" type="radio"
                                                                            id="hebergementNon" name="hosting"
                                                                            value="Non" onchange="toggleHebergement()">
                                                                        <label class="form-check-label"
                                                                            for="hebergementNon">Non</label>
                                                                    </div>
                                                                </div>
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
                                <h6 class="mb-0">Design et contenu</h6>
                            </div>
                            <form id="step-4-validation-form">
                                <div class="row g-3 validation-field">
                                    @csrf
                                    <input type="number" name="content_id" id="content_id" readonly class="d-none">
                                    <div class="row">
                                        <div class="col-6">
                                            <div class="row">
                                                <div class="col-12 mb-3">
                                                    <div class="border mt-2 rounded-2 table-responsive text-nowrap">
                                                        <table class="table table-striped">
                                                            <thead class="table-dark">
                                                                <tr>
                                                                    <th>élément</th>
                                                                    <th>Fournis</th>
                                                                    <th>à créer</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody class="table-border-bottom-0">
                                                                @php
                                                                    $elements = [
                                                                        [
                                                                            'el' => 'logo',
                                                                            'el-name' => 'logo',
                                                                            'name' => 'Logo',
                                                                        ],
                                                                        [
                                                                            'el' => 'charte-graphique',
                                                                            'el-name' => 'graphical_charter',
                                                                            'name' => 'charte graphique',
                                                                        ],
                                                                        [
                                                                            'el' => 'wireframe',
                                                                            'el-name' => 'wireframe',
                                                                            'name' => 'Maquette / Wireframe',
                                                                        ],
                                                                        [
                                                                            'el' => 'typography',
                                                                            'el-name' => 'typography',
                                                                            'name' =>
                                                                                "Typographies (police d'ecriture)",
                                                                        ],
                                                                        [
                                                                            'el' => 'description-product-services',
                                                                            'el-name' => 'description_product_services',
                                                                            'name' => 'Desc services/ produits',
                                                                        ],
                                                                    ];
                                                                @endphp
                                                                @foreach ($elements as $item)
                                                                    <tr style="min-height: 50px;">
                                                                        <td title="{{ strtolower($item['name']) }}"
                                                                            style="max-width: 150px;line-break: auto;min-height: 50px;"
                                                                            class="small text-limited">{{ $item['name'] }}
                                                                        </td>
                                                                        <td class="align-items-center d-flex"
                                                                            style="min-height: 50px;">
                                                                            <div class="form-check">
                                                                                <input name="{{ $item['el-name'] }}"
                                                                                    class="form-check-input"
                                                                                    type="radio" value="oui"
                                                                                    id="{{ $item['el'] }}-fourni-oui" />
                                                                            </div>
                                                                            @if ($item['el'] == 'typography')
                                                                                <textarea type="text" title="Indiquez les préférences de typographie pour votre site"
                                                                                    placeholder="Indiquez les préférences de typographie pour votre site" class="form-control d-none"
                                                                                    id="{{ $item['el'] }}-file-upload" name="{{ $item['el-name'] }}_text"></textarea>
                                                                                {{-- <input type="text"
                                                                                    style="width: 120px; height: 30px;"
                                                                                    title="Indiquez les préférences de typographie pour votre site"
                                                                                    placeholder="Indiquez les préférences de typographie pour votre site"
                                                                                    class="form-control d-none"
                                                                                    id="{{ $item['el'] }}-file-upload"
                                                                                    name="{{ $item['el-name'] }}_text"> --}}
                                                                            @else
                                                                                <button type="button"
                                                                                    data-toggle="tooltip"
                                                                                    data-placement="top"
                                                                                    title="Choisir {{ strtolower($item['name']) }}"
                                                                                    class="btn btn-icon btn-sm btn-label-primary waves-effect waves-light mx-1 d-none"
                                                                                    id="{{ $item['el'] }}-file-upload">
                                                                                    <i class="ti ti-upload"></i>
                                                                                </button>
                                                                                <span
                                                                                    id="{{ $item['el'] }}-file-upload-span"
                                                                                    class="p-0 text-limited small d-none"
                                                                                    {{-- title="Choisir {{ strtolower($item['name']) }}" --}}
                                                                                    style="max-width: 100px;">
                                                                                    {{-- Choisir {{ strtolower($item['name']) }} --}}
                                                                                    Aucun fichier
                                                                                </span>
                                                                                <input type="file"
                                                                                    class="form-control-sm d-none"
                                                                                    id="{{ $item['el'] }}-file"
                                                                                    name="{{ $item['el-name'] }}_file"
                                                                                    accept=".jpg, .jpeg, .png, .gif, .svg, .webp, .pdf, .doc, .docx">
                                                                            @endif

                                                                        </td>
                                                                        <td style="min-height: 50px;">
                                                                            <div class="form-check">
                                                                                <input name="{{ $item['el-name'] }}"
                                                                                    class="form-check-input"
                                                                                    type="radio" value="non"
                                                                                    id="{{ $item['el'] }}-fourni-non" />
                                                                            </div>
                                                                        </td>
                                                                    </tr>
                                                                @endforeach
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                                {{-- <div class="col-12 mb-3"> <label class="form-label">
                                                        Contenu de votre site:
                                                    </label>
                                                    @php
                                                        $contents = [['name' => 'Fourni par le client', 'alias' => 'contenuClient'], ['name' => 'À créer par le prestataire', 'alias' => 'contenuPrestataire']];
                                                    @endphp
                                                    <div class="row">
                                                        @foreach ($contents as $item)
                                                            <div class="col-auto">
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio"
                                                                        id="{{ $item['alias'] }}" name="content"
                                                                        value="{{ $item['name'] }}">
                                                                    <label class="form-check-label"
                                                                        for="{{ $item['alias'] }}">
                                                                        {{ $item['name'] }}
                                                                    </label>
                                                                </div>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                </div> --}}
                                                <div class="col-sm-6 col-md-10 mb-3">
                                                    <div class="form-group">
                                                        <label class="form-label">Style graphique attendu :</label>
                                                        <div class="checkbox-group">
                                                            @php
                                                                $graphic_styles = [
                                                                    ['name' => 'Flat design', 'alias' => 'flatDesign'],
                                                                    ['name' => 'Futuriste', 'alias' => 'futuriste'],
                                                                    ['name' => 'Interactif', 'alias' => 'interactif'],
                                                                    ['name' => 'Moderne', 'alias' => 'moderne'],
                                                                    ['name' => 'Retro', 'alias' => 'retro'],
                                                                    ['name' => 'Autres', 'alias' => 'autres'],
                                                                ];
                                                            @endphp
                                                            <div class="row">
                                                                @foreach ($graphic_styles as $item)
                                                                    <div class="col-auto">
                                                                        <div class="form-check">
                                                                            <input class="form-check-input"
                                                                                type="checkbox"
                                                                                id="{{ $item['alias'] }}_StyleGraphique"
                                                                                name="style_graphiques[]"
                                                                                value="{{ $item['name'] }}"
                                                                                @if ($item['name'] == 'Autres') onchange="toggleAutresStyle()" @endif>
                                                                            <label class="form-check-label"
                                                                                for="{{ $item['alias'] }}_StyleGraphique">
                                                                                {{ $item['name'] }}
                                                                            </label>
                                                                        </div>
                                                                    </div>
                                                                @endforeach
                                                            </div>

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
                                                        attendues : <span class="text-danger">*</span></label>
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
                                                        <small id="msg_autreProposition" class="invalid-feedback d-none">
                                                            Le nombre de propositions est
                                                            requis
                                                        </small>
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
                                                        <textarea type="text" id="palette-couleurs" class="form-control" name="color_palette"
                                                            placeholder="Indiquez les couleurs souhaitées pour votre site"></textarea>
                                                    </div>
                                                </div>

                                                {{-- <div class="col-12 mb-3">
                                                    <div class="form-group">
                                                        <label for="typographie" class="form-label">Typographie :</label>
                                                        <textarea type="text" id="typographie" class="form-control" name="typography"
                                                            placeholder="Indiquez les préférences de typographie pour votre site"></textarea>
                                                    </div>
                                                </div> --}}
                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <label for="exemples-sites" class="form-label">
                                                            Exemples de sites avec commentaire :
                                                        </label>
                                                        <textarea id="exemples-sites" class="form-control" name="exemples_sites" rows="3"
                                                            placeholder="Ajoutez des exemples de sites que vous aimez avec des commentaires sur ce que vous aimez bien sur ces sites (éléments, animation, couleurs, architecture d’informations, fonctionnalités, etc.)."></textarea>
                                                    </div>

                                                    <div class="form-group mb-3">
                                                        <label for="telecharger-images-3" class="form-label">Télécharger
                                                            des
                                                            images :</label>
                                                        <input type="file" class="form-control"
                                                            id="telecharger-images-3" name="exemples_sites_files[]"
                                                            accept=".jpg, .jpeg, .png, .gif, .svg, .webp, .pdf, .doc, .docx"
                                                            multiple>
                                                        <small id="images-help" class="form-text text-muted">
                                                            Vous pouvez télécharger des images pour illustrer vos
                                                            commentaires sur les sites.
                                                        </small>
                                                        <div class="row my-3" id="exemples_sites_files_container"></div>
                                                    </div>
                                                </div>
                                                <div class="col-12 mb-3 d-none ai-content">
                                                    <label class="form-label" for="iatext_exemples_sitesAi">
                                                        Les éléments sur Mesure (ai content)
                                                    </label>
                                                    <div class="input-group mb-1">
                                                        <input type="text" class="form-control"
                                                            name="prompt_iatext_exemples_sites" readonly
                                                            placeholder="Créer votre prompt" id="iatext_exemples_sitesAi">
                                                        <button class="btn btn-outline-primary ai-generate-button"
                                                            type="button" id="iatext_exemples_sitesAi-generate" disabled>
                                                            <i class="ti ti-file-text-ai"></i> &nbsp; Générer
                                                        </button>
                                                    </div>
                                                    <textarea name="iatext_exemples_sites" id="iatext_exemples_sites" class="form-control" rows="3" readonly></textarea>
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
                                                    <label class="form-label">Gestion de projet : <span
                                                            class="text-danger">*</span></label>
                                                    <div class="row">
                                                        <div class="col-auto">
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="radio"
                                                                    id="gestionProjetBoutEnBout" name="gestion_projet"
                                                                    value="Bout en bout">
                                                                <label class="form-check-label"
                                                                    for="gestionProjetBoutEnBout">
                                                                    Bout en bout
                                                                </label>
                                                            </div>
                                                        </div>
                                                        <div class="col-auto">
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="radio"
                                                                    id="gestionProjetAgile" name="gestion_projet"
                                                                    value="Agile">
                                                                <label class="form-check-label" for="gestionProjetAgile">
                                                                    Agile - être informé régulièrement de l’avancement du
                                                                    projet
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-10 mb-3">
                                                    <label>Communication : <span class="text-danger">*</span></label>
                                                    <br>
                                                    @php
                                                        $communications = [
                                                            ['name' => 'Téléphone', 'alias' => 'telephone'],
                                                            ['name' => 'E-mail', 'alias' => 'email'],
                                                            [
                                                                'name' => 'Visio-conférences',
                                                                'alias' => 'visio_conference',
                                                            ],
                                                        ];
                                                    @endphp
                                                    <div class="row">
                                                        @foreach ($communications as $item)
                                                            <div class="col-auto">
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="checkbox"
                                                                        id="communication_{{ $item['alias'] }}"
                                                                        name="communication[]"
                                                                        value="{{ $item['name'] }}">
                                                                    <label class="form-check-label"
                                                                        for="communication_{{ $item['alias'] }}"">
                                                                        {{ $item['name'] }}
                                                                    </label>
                                                                </div>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="row">

                                                <div class="col-md-12 mb-3">
                                                    <div class="form-group">
                                                        <label class="form-label">Délais : <span
                                                                class="text-danger">*</span></label>
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
                                                                        'default' => '280.0',
                                                                    ],
                                                                    [
                                                                        'title' => 'Intégration de la structure',
                                                                        'alias' => 'integration-structure',
                                                                        'name' => 'integration_structure',
                                                                        'default' => '280.0',
                                                                    ],
                                                                    [
                                                                        'title' => 'Ebauche Des Textes et traductions',
                                                                        'alias' => 'ebauche-textes-traductions',
                                                                        'name' => 'draft_texts_translations',
                                                                        'default' => '280.0',
                                                                    ],
                                                                    [
                                                                        'title' => 'Maquettage graphique',
                                                                        'alias' => 'maquettage-graphique',
                                                                        'name' => 'graphic_modeling',
                                                                        'default' => '250.0',
                                                                    ],
                                                                    [
                                                                        'title' => 'Développement & intégrations web',
                                                                        'alias' => 'developpement-integrations-web',
                                                                        'name' => 'web_development_integrations',
                                                                        'default' => '380.0',
                                                                    ],
                                                                    [
                                                                        'title' => 'Intégration des textes et images',
                                                                        'alias' => 'integration-textes-images',
                                                                        'name' => 'text_image_integration',
                                                                        'default' => '380.0',
                                                                    ],
                                                                    [
                                                                        'title' => 'Optimisation de la version Mobile',
                                                                        'alias' => 'optimisation-version-mobile',
                                                                        'name' => 'mobile_version_optimization',
                                                                        'default' => '380.0',
                                                                    ],
                                                                    [
                                                                        'title' => 'Intégration du multilingue',
                                                                        'alias' => 'integration-multilingue',
                                                                        'name' => 'multilingual_integration',
                                                                        'default' => '380.0',
                                                                    ],
                                                                    [
                                                                        'title' => 'Optimisation Pour SEO',
                                                                        'alias' => 'optimisation-seo',
                                                                        'name' => 'seo_optimisation',
                                                                        'default' => '280.0',
                                                                    ],
                                                                    [
                                                                        'title' => 'Suivi et tests',
                                                                        'alias' => 'suivi-tests',
                                                                        'name' => 'testing_tracking',
                                                                        'default' => '280.0',
                                                                    ],
                                                                    [
                                                                        'title' => 'Gestion de projets',
                                                                        'alias' => 'gestion-projet',
                                                                        'name' => 'project_management',
                                                                        'default' => '500.0',
                                                                    ],
                                                                ];
                                                            @endphp
                                                            @foreach ($budgetisation as $item)
                                                                <tr>
                                                                    <td class="p-0 px-3 py-1">{{ $item['title'] }}</td>
                                                                    <td class="p-0 px-3 py-1">
                                                                        <input type="number"
                                                                            class="form-control form-control h-100 number-of-days"
                                                                            placeholder="00" id="nj-{{ $item['alias'] }}"
                                                                            name="number_of_days_{{ $item['name'] }}">
                                                                    </td>
                                                                    <td class="p-0 px-3 py-1">
                                                                        <div
                                                                            class="input-group input-group input-group-merge">
                                                                            <span class="input-group-text py-0">€</span>
                                                                            <input type="number"
                                                                                value="{{ $item['default'] }}"
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
                                                                <td class="p-0 px-3 py-1" colspan="1">
                                                                    <div class="input-group input-group-merge">
                                                                        <span class="input-group-text">%</span>
                                                                        <input type="number" class="form-control"
                                                                            placeholder="00"
                                                                            id="remise-exceptionnelle-percentage"
                                                                            name="exceptional_discount_percentage" />
                                                                    </div>
                                                                </td>
                                                                <td class="p-0 px-3 py-1" colspan="2">
                                                                    <div class="input-group input-group-merge">
                                                                        <span class="input-group-text">€</span>
                                                                        <input type="number" class="form-control"
                                                                            placeholder="00" id="remise-exceptionnelle"
                                                                            readonly name="exceptional_discount" />
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
                                                                            name="total" />
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td class="p-0 px-3 py-1">Total des jours vendu </td>
                                                                <td class="p-0 px-3 py-1" colspan="3">
                                                                    <div class="input-group input-group-merge">
                                                                        <input type="number"
                                                                            class="form-control total-total-days"
                                                                            placeholder="00" id="total-total-days"
                                                                            name="total_days" />
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
                                                        <div
                                                            class="border border-bottom-0 border-dark border-start-0 border-top-0 col-7 pb-4">
                                                            <div class="row">
                                                                <div class="col-2 mt-auto">
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
                                                                                name="installment_{{ $index }}_percentage"
                                                                                id="pourcentage-operation-{{ $index }}"
                                                                                @if ($index == 1) value="20" @endif
                                                                                placeholder="00" />
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-3 mt-auto">
                                                                    <div class="form-group">
                                                                        <label class="form-label"
                                                                            id="label-pourcentage-value-{{ $index }}"
                                                                            for="pourcentage-value-{{ $index }}">
                                                                            Montant
                                                                        </label>
                                                                        <div class="input-group input-group-merge">
                                                                            <span class="input-group-text">€</span>
                                                                            <input type="number" class="form-control"
                                                                                name="installment_{{ $index }}_amount"
                                                                                id="pourcentage-value-{{ $index }}"
                                                                                placeholder="00" readonly />
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-5 mt-auto">
                                                                    <label class="form-label"
                                                                        for="titre-operation-{{ $index }}">
                                                                        Titre de l'operation:
                                                                    </label>
                                                                    <input type="text" class="form-control"
                                                                        placeholder="Titre de l'operation"
                                                                        name="installment_{{ $index }}_title"
                                                                        id="titre-operation-{{ $index }}"
                                                                        @if ($index == 1) readonly
                                                                        title="Pourcentage à payer après la signature"
                                                                        value="Pourcentage à payer après la signature" @endif>
                                                                </div>
                                                                {{-- <div class="col-1 mt-auto">
                                                                    <button type="button" data-bs-toggle="tooltip"
                                                                        data-bs-placement="top" title="Confirmer"
                                                                        class="btn btn-icon btn-label-success waves-effect waves-light"
                                                                        id="confirm-btn-{{ $index }}">
                                                                        <i class="ti ti-check"></i>
                                                                    </button>
                                                                </div> --}}
                                                                <div class="col-1 mt-auto">
                                                                    @if ($index < 10)
                                                                        <button type="button" data-bs-toggle="tooltip"
                                                                            data-bs-placement="top" title="Ajouter"
                                                                            class="btn btn-icon btn-label-primary waves-effect waves-light"
                                                                            id="plus-btn-{{ $index }}">
                                                                            <i class="ti ti-plus"></i>
                                                                        </button>
                                                                    @endif
                                                                </div>
                                                                <div class="col-1 mt-auto">
                                                                    @if ($index > 1)
                                                                        <button type="button" data-bs-toggle="tooltip"
                                                                            data-bs-placement="top" title="Supprimer"
                                                                            class="btn btn-icon  btn-label-danger waves-effect waves-light d-none"
                                                                            id="delete-btn-{{ $index }}">
                                                                            <i class="ti ti-trash"></i>
                                                                        </button>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        </div>
                                                        @if ($index == 1)
                                                            <div class="col-5">
                                                                <div class="form-group">
                                                                    <label class="form-label fs-4"> <b> Le reste :</b>
                                                                    </label>
                                                                    <div class="input-group input-group-merge">
                                                                        <span class="input-group-text">€</span>
                                                                        <input type="number" class="form-control"
                                                                            placeholder="00" id="reste"
                                                                            name="rest" />
                                                                    </div>
                                                                </div>
                                                                <hr class="my-3">
                                                                <div class="row">
                                                                    <div class="col-6 mb-3 mt-auto">
                                                                        <div class="form-group">
                                                                            <label class="form-label fs-4"
                                                                                id="label-pourcentage-operation-maintenance"
                                                                                for="pourcentage-operation-maintenance">
                                                                                <b> Maintenance :</b>
                                                                            </label>
                                                                            <div class="input-group input-group-merge">
                                                                                <span class="input-group-text">%</span>
                                                                                <input type="number"
                                                                                    class="form-control"
                                                                                    id="pourcentage-operation-maintenance"
                                                                                    name="maintenance_percentage"
                                                                                    placeholder="00" value="20" />
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-6 mb-3 mt-auto">
                                                                        <div class="form-group">

                                                                            <div class="input-group input-group-merge">
                                                                                <span class="input-group-text">€</span>
                                                                                <input type="number"
                                                                                    class="form-control"
                                                                                    id="pourcentage-value-maintenance"
                                                                                    name="maintenance_amount"
                                                                                    placeholder="00" value="20"
                                                                                    readonly />
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <hr class="my-3">
                                                                <div class="row">
                                                                    <div class="col-12 mb-3 mt-auto">
                                                                        <div class="form-group">
                                                                            <label class="form-label fs-4"
                                                                                id="label-pourcentage-operation-host"
                                                                                for="pourcentage-operation-host">
                                                                                <b> Hébergement :</b>
                                                                            </label>
                                                                            <div class="input-group input-group-merge">
                                                                                <span class="input-group-text">€</span>
                                                                                <input type="number"
                                                                                    class="form-control"
                                                                                    id="pourcentage-value-host"
                                                                                    name="host_amount"
                                                                                    placeholder="00" />
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        @endif
                                                    </div>
                                                    @php
                                                        $index++;
                                                    @endphp
                                                @endfor
                                            </div>

                                        </div>
                                    </div>

                                    <div class="col-12 d-flex justify-content-between">
                                        <button type="button" class="btn btn-label-secondary btn-prev"> <i
                                                class="ti ti-arrow-left me-sm-1 me-0"></i>
                                            <span class="align-middle d-sm-inline-block d-none">Précédent</span>
                                        </button>
                                        <button type="button" class="btn btn-primary btn-next btn-submit"
                                            id="next-step-5">
                                            <span>
                                                Suivant
                                            </span>
                                            <i class="ti ti-arrow-right" id="icon-next-step-5"></i>
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <!-- 6 -->
                        <div id="step-6-validation" class="content">
                            <div class="content-header mb-3">
                                <h6 class="mb-0">Confirmation</h6>
                            </div>
                            {{-- <form id="step-6-validation-form"> --}}
                            <div class="row">

                                {{-- <h4 id="confirmation">Loading .....</h4> --}}
                                <div class="col-12 my-5" id="spec-loading">
                                    <div class="sk-chase sk-primary m-auto">
                                        <div class="sk-chase-dot"></div>
                                        <div class="sk-chase-dot"></div>
                                        <div class="sk-chase-dot"></div>
                                        <div class="sk-chase-dot"></div>
                                        <div class="sk-chase-dot"></div>
                                        <div class="sk-chase-dot"></div>
                                    </div>
                                    <h5 class="text-primary text-center mt-5 mb-2">Préparation du cahier des charges</h5>
                                </div>


                                <div class="col-12 mt-5 mb-2 d-none" id="spec-confirm">
                                    <p class="text-center">
                                        <span class="ti ti-check text-primary fs-1"></span>
                                    </p>
                                    <h5 class="text-primary text-center mt-5 mb-2">Confirmation du texte généré par IA
                                    </h5>
                                    <div class="row">
                                        <div class="col-4 mb-3">
                                            <label class="form-label" for="iatext_description_confirm">
                                                Description de l'entreprise
                                            </label>
                                            <textarea name="iatext_description_confirm" id="iatext_description_confirm" class="form-control"
                                                rows="5"></textarea>
                                        </div>
                                        <div class="col-4 mb-3">
                                            <label class="form-label" for="iatext_main_activities_confirm">
                                                Activité principale de l'entreprise
                                            </label>
                                            <textarea name="iatext_main_activities_confirm" id="iatext_main_activities_confirm" class="form-control"
                                                rows="5"></textarea>
                                        </div>
                                        <div class="col-4 mb-3">
                                            <label class="form-label" for="iatext_services_products_confirm">
                                                Services ou produits vendus
                                            </label>
                                            <textarea name="iatext_services_products_confirm" id="iatext_services_products_confirm" class="form-control"
                                                rows="5"></textarea>
                                        </div>
                                        <div class="col-4 mb-3">
                                            <label class="form-label" for="iatext_target_audience_confirm">
                                                Public Cible
                                            </label>
                                            <textarea name="iatext_target_audience_confirm" id="iatext_target_audience_confirm" class="form-control"
                                                rows="5"></textarea>
                                        </div>
                                        <div class="col-4 mb-3">
                                            <label class="form-label" for="iatext_target_keywords_confirm">
                                                Mots-clés cibles
                                            </label>
                                            <textarea name="iatext_target_keywords_confirm" id="iatext_target_keywords_confirm" class="form-control"
                                                rows="5"></textarea>
                                        </div>
                                        <div class="col-4 mb-3">
                                            <label class="form-label" for="iatext_expected_client_objectives_confirm">
                                                Objectifs attendus du client
                                            </label>
                                            <textarea name="iatext_expected_client_objectives_confirm" id="iatext_expected_client_objectives_confirm"
                                                class="form-control" rows="5"></textarea>
                                        </div>
                                        <div class="col-4 mb-3">
                                            <label class="form-label" for="iatext_menu_confirm">
                                                Menu
                                            </label>
                                            <textarea name="iatext_menu_confirm" id="iatext_menu_confirm" class="form-control" rows="5"></textarea>
                                        </div>
                                        <div class="col-4 mb-3">
                                            <label class="form-label" for="iatext_techniques_specs_confirm">
                                                Spécifications Techniques
                                            </label>
                                            <textarea name="iatext_techniques_specs_confirm" id="iatext_techniques_specs_confirm" class="form-control"
                                                rows="5"></textarea>
                                        </div>
                                        <div class="col-4 mb-3">
                                            <label class="form-label" for="iatext_competitors_confirm">
                                                Concurrence
                                            </label>
                                            <textarea name="iatext_competitors_confirm" id="iatext_competitors_confirm" class="form-control" rows="5"></textarea>
                                        </div>
                                        <div class="col-4 mb-3">
                                            <label class="form-label" for="iatext_constraints_confirm">
                                                Contraintes
                                            </label>
                                            <textarea name="iatext_constraints_confirm" id="iatext_constraints_confirm" class="form-control" rows="5"></textarea>
                                        </div>
                                        <div class="col-4 mb-3">
                                            <label class="form-label" for="iatext_exemples_sites_confirm">
                                                Les éléments sur Mesure
                                            </label>
                                            <textarea name="iatext_exemples_sites_confirm" id="iatext_exemples_sites_confirm" class="form-control"
                                                rows="5"></textarea>
                                        </div>
                                        <div class="col-12 d-flex justify-content-center my-5" >
                                          <button type="button" class="btn btn-label-success  mx-1"
                                              id="spec-confirm-button">
                                              <span class="ti-xs ti ti-check me-1"  id="icon-spec-confirm"></span>Confirmer
                                          </button>

                                      </div>
                                    </div>
                                    {{-- (ai content) --}}
                                </div>

                                <div class="col-12 mt-5 mb-2 d-none" id="spec-done">
                                    <p class="text-center">
                                        <span class="ti ti-checks text-primary fs-1"></span>
                                    </p>
                                    <h5 class="text-primary text-center mt-5 mb-2">Votre cahier des charges est prêt</h5>
                                </div>
                                <div class="col-12 mt-5 mb-2 d-none" id="spec-failed">
                                    <p class="text-center">
                                        <span class="ti ti-bug text-danger fs-1"></span>
                                    </p>
                                    <h5 class="text-danger text-center mt-5 mb-2">
                                        Une erreur s'est produite lors de la génération de texte avec ChatGPT.
                                        <br>
                                        Merci de vérifier votre quota et régénérer les textes à partir
                                        <br>
                                        de <a href="/specifications" class="text-danger text-decoration-underline"> la
                                            liste de
                                            cahiers des charges.</a>

                                        <br>
                                        <br>

                                        <a href="/specifications" class="btn btn-label-primary text-primary mx-1"
                                            id="spec-button-liste">
                                            <span class="ti-xs ti ti-list me-1"></span>Liste des cahiers des charges
                                        </a>
                                    </h5>
                                </div>

                                <div class="col-12 d-flex justify-content-center my-5 d-none" id="spec-button">
                                    <a href="#" class="btn btn-label-primary text-primary mx-1" target="_blank"
                                        id="spec-button-show">
                                        <span class="ti-xs ti ti-eye me-1"></span>Voir
                                    </a>
                                    <a href="#" class="btn btn-label-primary text-primary mx-1" target="_blank"
                                        id="spec-button-download">
                                        <span class="ti-xs ti ti-download me-1"></span>Télécharger
                                    </a>
                                    <a href="/specifications" class="btn btn-label-primary text-primary mx-1"
                                        id="spec-button-liste">
                                        <span class="ti-xs ti ti-list me-1"></span>Liste des cahiers des charges
                                    </a>
                                </div>

                                {{-- <div class="col-12 d-flex justify-content-between">
                                    <button type="button" class="btn btn-label-secondary btn-prev"> <i
                                            class="ti ti-arrow-left me-sm-1 me-0"></i>
                                        <span class="align-middle d-sm-inline-block d-none">Précédent</span>
                                    </button>
                                    <button type="button" class="btn btn-success btn-next btn-submit"
                                        id="next-step-6">
                                        <span>
                                            Confirmer
                                        </span>
                                        <i class="ti ti-check" id="icon-next-step-6"></i>
                                    </button>
                                </div> --}}
                            </div>
                            {{-- </form> --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /Validation Wizard -->


    </div>

@endsection
