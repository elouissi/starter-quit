@extends('layouts/layoutMaster')

@section('title', 'Créer un cahier de charge')

@section('vendor-style')
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/bs-stepper/bs-stepper.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/bootstrap-select/bootstrap-select.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/select2/select2.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/@form-validation/umd/styles/index.min.css') }}" />
@endsection

@section('vendor-script')
    <script src="{{ asset('assets/vendor/libs/bs-stepper/bs-stepper.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/bootstrap-select/bootstrap-select.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/select2/select2.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/@form-validation/umd/bundle/popular.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/@form-validation/umd/plugin-bootstrap5/index.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/@form-validation/umd/plugin-auto-focus/index.min.js') }}"></script>
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
                nomDomaine.required = true; // Rendre le champ obligatoire
            } else {
                nomDomaineGroup.style.display = "none";
                nomDomaine.required = false; // Rendre le champ facultatif
            }
        }

        function toggleLogo() {
            var fichierLogoGroup = document.getElementById("fichierLogoGroup");
            var logoOui = document.getElementById("logoOui");
            var fichierLogo = document.getElementById("fichierLogo");

            if (logoOui.checked) {
                fichierLogoGroup.style.display = "block";
                fichierLogo.required = true; // Rendre le champ obligatoire
            } else {
                fichierLogoGroup.style.display = "none";
                fichierLogo.required = false; // Rendre le champ facultatif
            }
        }

        function toggleHebergement() {
            var nomHebergementGroup = document.getElementById("nomHebergementGroup");
            var hebergementOui = document.getElementById("hebergementOui");
            var nomHebergement = document.getElementById("nomHebergement");

            if (hebergementOui.checked) {
                nomHebergementGroup.style.display = "block";
                nomHebergement.required = true; // Rendre le champ obligatoire
            } else {
                nomHebergementGroup.style.display = "none";
                nomHebergement.required = false; // Rendre le champ facultatif
            }
        }

        function toggleAutresStyle() {
            var zoneTexteAutresStyle = document.getElementById("zoneTexteAutresStyle");
            var autresStyleGraphique = document.getElementById("autresStyleGraphique");

            if (autresStyleGraphique.checked) {
                zoneTexteAutresStyle.style.display = "block";
            } else {
                zoneTexteAutresStyle.style.display = "none";
            }
        }

        document.getElementById('addFileInput').addEventListener('click', function() {
            var container = document.getElementById('fileInputsContainer');
            var newRow = document.createElement('div');
            newRow.className = 'row mb-1';
            newRow.innerHTML = '<div class="col-11">' +
                '<div class="input-group mb-1">' +
                '<input type="file" class="form-control" name="fichier[]" multiple>' +
                '</div>' +
                '</div>' +
                '<div class="col-1">' +
                '<button type="button" class="btn btn-danger w-100" onclick="removeFileInput(this)">' +
                '<i class="ti ti-trash"></i>' +
                '</button>' +
                '</div>';
            container.appendChild(newRow);
        });

        function removeFileInput(element) {
            var container = document.getElementById('fileInputsContainer');
            container.removeChild(element.parentNode.parentNode);
        }

        // document.getElementById('addFileInput').addEventListener('click', function() {
        //     var container = document.getElementById('fileInputsContainer');
        //     var input = document.createElement('input');
        //     input.type = 'file';
        //     input.className = 'form-control mb-1';
        //     input.name = 'fichier[]';
        //     container.appendChild(input);
        // });
    </script>
@endsection

@section('content')
    <h4 class="py-3 mb-4">
        <span class="text-muted fw-light">Cahier de charge/</span> Numbered
    </h4>
    <!-- Default -->
    <div class="row">

        <!-- Validation Wizard -->
        <div class="col-12 mb-4">
            <small class="text-light fw-medium">Validation</small>
            <div id="wizard-validation" class="bs-stepper mt-2">
                <div class="bs-stepper-header">
                    <div class="step" data-target="#presentation-entreprise-validation">
                        <button type="button" class="step-trigger ps-0 pe-1">
                            <span class="bs-stepper-circle">1</span>
                            <span class="bs-stepper-label mt-1">
                                <span class="bs-stepper-title">Présentation <br>de l'entreprise</span>
                            </span>
                        </button>
                    </div>
                    <div class="line">
                        <i class="ti ti-chevron-right"></i>
                    </div>
                    <div class="step" data-target="#objectif-site-validation">
                        <button type="button" class="step-trigger px-1">
                            <span class="bs-stepper-circle">2</span>
                            <span class="bs-stepper-label">
                                <span class="bs-stepper-title">Objectif <br> du site</span>
                            </span>
                        </button>
                    </div>
                    <div class="line">
                        <i class="ti ti-chevron-right"></i>
                    </div>
                    <div class="step" data-target="#analyse-existant-validation">
                        <button type="button" class="step-trigger px-1">
                            <span class="bs-stepper-circle">3</span>
                            <span class="bs-stepper-label">
                                <span class="bs-stepper-title">Analyse <br> de l'existant</span>
                            </span>
                        </button>
                    </div>
                    <div class="line">
                        <i class="ti ti-chevron-right"></i>
                    </div>
                    <div class="step" data-target="#design-maquettage-validation">
                        <button type="button" class="step-trigger px-1">
                            <span class="bs-stepper-circle">4</span>
                            <span class="bs-stepper-label">
                                <span class="bs-stepper-title">Design <br> et maquettage</span>
                            </span>
                        </button>
                    </div>
                    <div class="line">
                        <i class="ti ti-chevron-right"></i>
                    </div>
                    <div class="step" data-target="#deroulement-projet-validation">
                        <button type="button" class="step-trigger px-1">
                            <span class="bs-stepper-circle">5</span>
                            <span class="bs-stepper-label">
                                <span class="bs-stepper-title">Déroulement <br> du projet</span>
                            </span>
                        </button>
                    </div>
                </div>
                <div class="bs-stepper-content">
                    <form id="wizard-validation-form" onSubmit="return false">
                        <!-- 1 -->
                        <div id="presentation-entreprise-validation" class="content">
                            <div class="content-header mb-3">
                                <h6 class="mb-0">Présentation de l'entreprise</h6>
                            </div>
                            <div class="row g-3 validation-field">
                                <div class="col-sm-6">
                                    <div class="row">
                                        <div class="col-10 mb-3">
                                            <label class="form-label" for="nomEntreprise">Nom de l'entreprise</label>
                                            <input type="text" name="nomEntreprise" id="nomEntreprise"
                                                class="form-control" placeholder="Nom de l'entreprise" />
                                        </div>
                                        <div class="col-10 mb-3">
                                            <label class="form-label" for="personneContacte">Personne à contacter (nom et
                                                prénom)</label>
                                            <input type="text" name="personneContacte" id="personneContacte"
                                                class="form-control" placeholder="Nom de l'entreprise" />
                                        </div>
                                        <div class="col-10 mb-3">
                                            <label class="form-label" for="telephone">Téléphone</label>
                                            <input type="tel" name="telephone" id="telephone" class="form-control"
                                                placeholder="Numéro de téléphone" />
                                        </div>
                                        <div class="col-10 mb-3">
                                            <label class="form-label" for="email">Email</label>
                                            <input type="email" name="email" id="email" class="form-control"
                                                placeholder="Adresse email" />
                                        </div>

                                    </div>

                                </div>
                                <div class="col-sm-6">
                                    <div class="row">
                                        <div class="col-12 mb-3">
                                            <label class="form-label" for="descriptionEntreprise">Description de
                                                l'entreprise</label>
                                            <textarea name="descriptionEntreprise" id="descriptionEntreprise" class="form-control" rows="4"
                                                placeholder="Description de l'entreprise"></textarea>
                                        </div>
                                        <div class="col-12 mb-3">
                                            <label class="form-label" for="activitePrincipale">Activité principale de
                                                l'entreprise</label>
                                            <textarea name="activitePrincipale" id="activitePrincipale" class="form-control" rows="4"
                                                placeholder="Activité principale de l'entreprise"></textarea>
                                        </div>
                                        <div class="col-12 mb-3">
                                            <label class="form-label" for="servicesProduits">Services ou produits
                                                vendus</label>
                                            <textarea name="servicesProduits" id="servicesProduits" class="form-control" rows="4"
                                                placeholder="Services ou produits vendus"></textarea>
                                        </div>
                                        <div class="col-12 mb-3">
                                            <label class="form-label" for="cible">Cible</label>
                                            <input type="text" name="cible" id="cible" class="form-control"
                                                placeholder="Cible">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 d-flex justify-content-between">
                                    <button class="btn btn-label-secondary btn-prev" disabled> <i
                                            class="ti ti-arrow-left me-sm-1 me-0"></i>
                                        <span class="align-middle d-sm-inline-block d-none">Précédent</span>
                                    </button>
                                    <button class="btn btn-primary btn-next"> <span
                                            class="align-middle d-sm-inline-block d-none me-sm-1">Suivant</span> <i
                                            class="ti ti-arrow-right"></i></button>
                                </div>
                            </div>
                        </div>
                        <!-- 2 -->
                        <div id="objectif-site-validation" class="content">
                            <div class="content-header mb-3">
                                <h6 class="mb-0">Objectifs du site</h6>
                            </div>
                            <div class="row g-3 validation-field">
                                <div class="col-sm-6">
                                    <div class="row">
                                        <div class="col-12 mb-3">
                                            <label class="form-label" for="besoinProjet">Besoin de projet :</label>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" id="besoinRefonte"
                                                    name="besoinProjet" value="refonte">
                                                <label class="form-check-label" for="besoinRefonte">
                                                    Refonte de site web
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" id="besoinCreation"
                                                    name="besoinProjet" value="creation">
                                                <label class="form-check-label" for="besoinCreation">
                                                    Création de site web
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-12 mb-3">
                                            <label class="form-label">Type de projet :</label>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" id="siteVitrine"
                                                    name="typeProjet" value="siteVitrine">
                                                <label class="form-check-label" for="siteVitrine">Site Vitrine</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" id="eCommerce"
                                                    name="typeProjet" value="eCommerce">
                                                <label class="form-check-label" for="eCommerce">E-commerce</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" id="blog"
                                                    name="typeProjet" value="blog">
                                                <label class="form-check-label" for="blog">Blog</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" id="siteAffiliation"
                                                    name="typeProjet" value="siteAffiliation">
                                                <label class="form-check-label" for="siteAffiliation">Site
                                                    d'affiliation</label>
                                            </div>
                                        </div>
                                        <div class="col-12 mb-3">
                                            <label class="form-label">Options de paiement :</label>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="paiementStripe"
                                                    name="optionsPaiement[]" value="stripe">
                                                <label class="form-check-label" for="paiementStripe">Stripe</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="paiementPaypal"
                                                    name="optionsPaiement[]" value="paypal">
                                                <label class="form-check-label" for="paiementPaypal">Paypal</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="paiementCod"
                                                    name="optionsPaiement[]" value="cod">
                                                <label class="form-check-label" for="paiementCod">Cash on Delivery
                                                    (Paiement à la
                                                    livraison)</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="paiementDevis"
                                                    name="optionsPaiement[]" value="devis">
                                                <label class="form-check-label" for="paiementDevis">Demande de
                                                    devis</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="paiementRien"
                                                    name="optionsPaiement[]" value="rien">
                                                <label class="form-check-label" for="paiementRien">Aucun</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="row">
                                        <div class="col-12 mb-3"><label class="form-label">Fonctions attendues :</label>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="formulaireContact"
                                                    name="fonctionsAttendues[]" value="formulaireContact">
                                                <label class="form-check-label" for="formulaireContact">Formulaire de
                                                    contact</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="blog"
                                                    name="fonctionsAttendues[]" value="blog">
                                                <label class="form-check-label" for="blog">Blog</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="backoffice"
                                                    name="fonctionsAttendues[]" value="backoffice">
                                                <label class="form-check-label" for="backoffice">Backoffice</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="geolocalisation"
                                                    name="fonctionsAttendues[]" value="geolocalisation">
                                                <label class="form-check-label"
                                                    for="geolocalisation">Géolocalisation</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="captureLeads"
                                                    name="fonctionsAttendues[]" value="captureLeads">
                                                <label class="form-check-label" for="captureLeads">Capture des
                                                    leads</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="pluginsSurMesure"
                                                    name="fonctionsAttendues[]" value="pluginsSurMesure">
                                                <label class="form-check-label" for="pluginsSurMesure">Plugins sur
                                                    mesure</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="besoinApis"
                                                    name="fonctionsAttendues[]" value="besoinApis">
                                                <label class="form-check-label" for="besoinApis">Besoin des APIs</label>
                                            </div>
                                        </div>
                                        <div class="col-12 mb-3"> <label class="form-label">Langue :</label>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="langueFr"
                                                    name="langue[]" value="fr">
                                                <label class="form-check-label" for="langueFr">Français</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="langueEn"
                                                    name="langue[]" value="en">
                                                <label class="form-check-label" for="langueEn">Anglais</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="langueIt"
                                                    name="langue[]" value="it">
                                                <label class="form-check-label" for="langueIt">Italien</label>
                                            </div>
                                        </div>
                                        <div class="col-12 mb-3"> <label class="form-label"
                                                for="objectifsAttendus">Objectifs attendus</label>
                                            <textarea name="objectifsAttendus" id="objectifsAttendus" class="form-control" placeholder="Objectifs attendus"
                                                rows="4"></textarea>
                                        </div>

                                    </div>
                                </div>
                                <div class="col-12 d-flex justify-content-between">
                                    <button class="btn btn-label-secondary btn-prev"> <i
                                            class="ti ti-arrow-left me-sm-1 me-0"></i>
                                        <span class="align-middle d-sm-inline-block d-none">Précédent</span>
                                    </button>
                                    <button class="btn btn-primary btn-next"> <span
                                            class="align-middle d-sm-inline-block d-none me-sm-1">Suivant</span> <i
                                            class="ti ti-arrow-right"></i></button>
                                </div>
                            </div>
                        </div>
                        <!-- 3 -->
                        <div id="analyse-existant-validation" class="content">
                            <div class="content-header mb-3">
                                <h6 class="mb-0">Analyse de l'existant</h6>
                            </div>
                            <div class="row g-3 validation-field">
                                <div class="col-6">
                                    <div class="row">
                                        <div class="col-10 mb-3"> <label class="form-label" for="concurrents">Site
                                                internet de vos principaux
                                                concurrents :</label>
                                            <textarea class="form-control" id="concurrents" name="concurrents" rows="3"
                                                placeholder="Saisissez les sites internet de vos principaux concurrents"></textarea>
                                        </div>
                                        <div class="col-10 mb-3">
                                            <div class="form-group">
                                                <label class="form-label" for="contraintes">Contraintes (donner des
                                                    exemples de
                                                    sites internet, dont vous appréciez un élément) :</label>
                                                <textarea class="form-control" id="contraintes" name="contraintes" rows="4"></textarea>
                                            </div>

                                        </div>
                                        <div class="col-10 mb-3">
                                            <div class="row" id="fileInputsContainer">
                                                <div class="row mb-1">
                                                    <div class="col-11">
                                                        <div class="input-group mb-1"><input type="file"
                                                                class="form-control" name="fichier[]" multiple="">
                                                        </div>
                                                    </div>
                                                    <div class="col-1"><button type="button"
                                                            class="btn btn-primary w-100" id="addFileInput">
                                                            <i class="ti ti-plus"></i>
                                                        </button></div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-12 mb-3"> <label class="form-label">Contenu de votre site
                                                :</label>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="contenuClient"
                                                    name="contenu[]" value="client">
                                                <label class="form-check-label" for="contenuClient">Fourni par le
                                                    client</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="contenuPrestataire"
                                                    name="contenu[]" value="prestataire">
                                                <label class="form-check-label" for="contenuPrestataire">À créer par le
                                                    prestataire</label>
                                            </div>
                                        </div>
                                    </div>

                                </div>

                                <div class="col-6">
                                    <div class="row">
                                        <div class="col-12 mb-3">
                                            <div class="col-sm-6  col-md-12">
                                                <div class="form-group">
                                                    <label class="form-label">Nom de domaine :</label>
                                                    <div class="radio-group">
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="radio"
                                                                id="domaineOui" name="domaine[]" value="oui"
                                                                onchange="toggleNomDomaine()">
                                                            <label class="form-check-label" for="domaineOui">Oui</label>
                                                        </div>
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="radio"
                                                                id="domaineNon" name="domaine[]" value="non"
                                                                onchange="toggleNomDomaine()">
                                                            <label class="form-check-label" for="domaineNon">Non</label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group" id="nomDomaineGroup" style="display: none">
                                                    <input type="text" class="form-control" id="nomDomaine"
                                                        name="nomDomaine" placeholder="Nom de domaine (si disponible)">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12 mb-3">
                                            <div class="col-sm-6  col-md-12">
                                                <label class="form-label">Logo :</label>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" id="logoOui"
                                                        name="logo[]" value="oui" onchange="toggleLogo()">
                                                    <label class="form-check-label" for="logoOui">Oui</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" id="logoNon"
                                                        name="logo[]" value="non" onchange="toggleLogo()">
                                                    <label class="form-check-label" for="logoNon">Non</label>
                                                </div>
                                                <div class="col-sm-12" id="fichierLogoGroup" style="display: none">
                                                    <input type="file" class="form-control" id="fichierLogo"
                                                        name="fichierLogo" accept="image/*">
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
                                                                id="hebergementOui" name="hebergement[]" value="oui"
                                                                onchange="toggleHebergement()">
                                                            <label class="form-check-label"
                                                                for="hebergementOui">Oui</label>
                                                        </div>
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="radio"
                                                                id="hebergementNon" name="hebergement[]" value="non"
                                                                onchange="toggleHebergement()">
                                                            <label class="form-check-label"
                                                                for="hebergementNon">Non</label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group" id="nomHebergementGroup" style="display: none">
                                                    <input type="text" class="form-control" id="nomHebergement"
                                                        name="nomHebergement" placeholder="Hébergement (si disponible)">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-12 mb-3">
                                            <label class="form-label" for="menu">Menu :</label>
                                            <textarea class="form-control" id="menu" name="menu" rows="3"
                                                placeholder="Indiquez votre préférence des menus à ajouter sur le site"></textarea>
                                        </div>

                                    </div>

                                </div>

                                <!-- Zone de texte (non afficher au formulaire) pour langage de programmation -->
                                <input type="hidden" id="langage" name="langage" value="wappalizer">

                                <!-- Zone de texte (non afficher au formulaire) pour les outils utilisées pour le développement -->
                                <input type="hidden" id="outils" name="outils" value="wappalizer">

                                <!-- Zone de texte (non afficher au formulaire) pour statistiques de trafic -->
                                <input type="hidden" id="trafic" name="trafic" value="similarweb">

                                <!-- Zone de texte (non afficher au formulaire) pour Nombre de pages -->
                                <input type="hidden" id="pages" name="pages" value="similarweb">

                                <div class="col-12 d-flex justify-content-between">
                                    <button class="btn btn-label-secondary btn-prev"> <i
                                            class="ti ti-arrow-left me-sm-1 me-0"></i>
                                        <span class="align-middle d-sm-inline-block d-none">Précédent</span>
                                    </button>
                                    <button class="btn btn-primary btn-next"> <span
                                            class="align-middle d-sm-inline-block d-none me-sm-1">Suivant</span> <i
                                            class="ti ti-arrow-right"></i></button>
                                </div>
                            </div>
                        </div>
                        <!-- 4 -->
                        <div id="design-maquettage-validation" class="content">
                            <div class="content-header mb-3">
                                <h6 class="mb-0">Design et Maquettage</h6>
                            </div>
                            <div class="row g-3 validation-field">

                                <div class="row">
                                    <div class="col-6">
                                        <div class="row">
                                            <div class="col-sm-6 col-md-10 mb-3">
                                                <div class="form-group">
                                                    <label class="form-label">Style graphique attendu :</label>
                                                    <div class="checkbox-group">
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox"
                                                                id="flatDesign" name="styleGraphique[]"
                                                                value="flatDesign">
                                                            <label class="form-check-label" for="flatDesign">Flat
                                                                design</label>
                                                        </div>
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox"
                                                                id="futuriste" name="styleGraphique[]" value="futuriste">
                                                            <label class="form-check-label"
                                                                for="futuriste">Futuriste</label>
                                                        </div>
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox"
                                                                id="interactif" name="styleGraphique[]"
                                                                value="interactif">
                                                            <label class="form-check-label"
                                                                for="interactif">Interactif</label>
                                                        </div>
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox"
                                                                id="moderne" name="styleGraphique[]" value="moderne">
                                                            <label class="form-check-label" for="moderne">Moderne</label>
                                                        </div>
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox"
                                                                id="retro" name="styleGraphique[]" value="retro">
                                                            <label class="form-check-label" for="retro">Retro</label>
                                                        </div>
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox"
                                                                id="autresStyleGraphique" name="styleGraphique[]"
                                                                value="autres" onchange="toggleAutresStyle()">
                                                            <label class="form-check-label"
                                                                for="autresStyleGraphique">Autres</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-12" id="zoneTexteAutresStyle"
                                                        style="display: none;">
                                                        <textarea class="form-control" id="autresStyleTexte" name="autresStyleTexte"
                                                            placeholder="Précisez les autres styles graphiques attendus"></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-6 col-md-10 mb-3">
                                                <label class="form-label" for="nombrePropositions">
                                                    Nombre de propositions attendues :
                                                </label>
                                                <select class="select2" class="select2" id="nombrePropositions"
                                                    name="nombrePropositions">
                                                    <option label=" "></option>
                                                    <option>1</option>
                                                    <option>2</option>
                                                    <option>3</option>
                                                </select>
                                            </div>
                                            <div class="col-sm-6 col-md-10 mb-3">
                                                <div class="form-group">
                                                    <label for="exigences-graphiques" class="form-label">Exigences
                                                        graphiques :</label>
                                                    <textarea id="exigences-graphiques" class="form-control" name="exigences" rows="5"
                                                        placeholder="Inscrivez ici tout ce que vous souhaitez ou ne souhaitez pas voir sur votre site (couleurs, formes géométriques, typographies, thèmes, etc.)."></textarea>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="row">

                                            <div class="col-sm-6 col-md-10 mb-3">
                                                <div class="form-group">
                                                    <label for="exemples-sites" class="form-label">Exemples de sites avec
                                                        commentaire :</label>
                                                    <textarea id="exemples-sites" class="form-control" name="commentaires" rows="5"
                                                        placeholder="Ajoutez des exemples de sites que vous aimez avec des commentaires sur ce que vous aimez bien sur ces sites (éléments, animation, couleurs, architecture d’informations, fonctionnalités, etc.)."></textarea>
                                                </div>

                                                <div class="form-group">
                                                    <label for="telecharger-images" class="form-label">Télécharger des
                                                        images :</label>
                                                    <input type="file" class="form-control" id="telecharger-images"
                                                        name="images[]" accept="image/*" multiple>
                                                    <small id="images-help" class="form-text text-muted">Vous pouvez
                                                        télécharger des images pour illustrer vos commentaires sur les
                                                        sites.</small>
                                                </div>

                                            </div>
                                            <div class="col-sm-6 col-md-10 mb-3">
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
                                                    name="arborescenceSite" accept=".pdf, .doc, .docx">
                                            </div>
                                            <div class="form-group" style="display: none;">
                                                <label class="form-label">Contenu du Site (non affiché au formulaire) :
                                                    texte à mettre dans chaque section de site</label>
                                                <textarea class="form-control" id="contenuSite" name="contenuSite" rows="3"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Téléchargement de fichier (non affiché au formulaire) : La maquette du site -->
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
                                <input type="hidden" name="contenuDuSite" value="texte_a_mettre_dans_chaque_section">

                                <div class="col-12 d-flex justify-content-between">
                                    <button class="btn btn-label-secondary btn-prev"> <i
                                            class="ti ti-arrow-left me-sm-1 me-0"></i>
                                        <span class="align-middle d-sm-inline-block d-none">Précédent</span>
                                    </button>
                                    <button class="btn btn-primary btn-next"> <span
                                            class="align-middle d-sm-inline-block d-none me-sm-1">Suivant</span> <i
                                            class="ti ti-arrow-right"></i></button>
                                </div>
                                {{-- <div class="col-12 d-flex justify-content-between">
                                    <button class="btn btn-label-secondary btn-prev"> <i
                                            class="ti ti-arrow-left me-sm-1 me-0"></i>
                                        <span class="align-middle d-sm-inline-block d-none">Précédent</span>
                                    </button>
                                    <button class="btn btn-success btn-next btn-submit">Submit</button>
                                </div> --}}
                            </div>
                        </div>
                        <!-- 5 -->
                        <div id="deroulement-projet-validation" class="content">
                            <div class="content-header mb-3">
                                <h6 class="mb-0">Déroulement du projet</h6>
                            </div>
                            <div class="row g-3 validation-field">
                                <div class="row">
                                    <div class="col-6">
                                        <div class="row">
                                            <div class="col-10 mb-3">
                                                <label class="form-label">Gestion de projet :</label>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio"
                                                        id="gestionProjetBoutEnBout" name="gestionProjet"
                                                        value="boutEnBout">
                                                    <label class="form-check-label" for="gestionProjetBoutEnBout">Bout en
                                                        bout</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio"
                                                        id="gestionProjetAgile" name="gestionProjet" value="agile">
                                                    <label class="form-check-label" for="gestionProjetAgile">Agile - être
                                                        informé régulièrement de l’avancement du projet</label>
                                                </div>
                                            </div>
                                            <div class="col-10 mb-3">
                                                <label>Communication :</label><br>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox"
                                                        id="communicationTelephone" name="communication[]"
                                                        value="telephone">
                                                    <label class="form-check-label"
                                                        for="communicationTelephone">Téléphone</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox"
                                                        id="communicationEmail" name="communication[]" value="email">
                                                    <label class="form-check-label"
                                                        for="communicationEmail">E-mail</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox"
                                                        id="communicationVisioConference" name="communication[]"
                                                        value="visioConference">
                                                    <label class="form-check-label"
                                                        for="communicationVisioConference">Visio-conférences</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="row">

                                            <div class="col-sm-6 col-md-10 mb-3">
                                                <div class="form-group">
                                                    <label class="form-label">Délais :</label>
                                                    <input type="text" class="form-control" id="delais"
                                                        name="delais">
                                                </div>
                                            </div>
                                            <div class="col-sm-6 col-md-10 mb-3">
                                                <div class="form-group">
                                                    <label class="form-label">Budget (€) :</label>
                                                    <div class="input-group">
                                                        <input type="text" class="form-control" id="budget"
                                                            name="budget" aria-describedby="budget-addon">
                                                        <span class="input-group-text" id="budget-addon">€</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 d-flex justify-content-between">
                                    <button class="btn btn-label-secondary btn-prev"> <i
                                            class="ti ti-arrow-left me-sm-1 me-0"></i>
                                        <span class="align-middle d-sm-inline-block d-none">Précédent</span>
                                    </button>
                                    <button class="btn btn-success btn-next btn-submit">Submit</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- /Validation Wizard -->


    </div>

@endsection
