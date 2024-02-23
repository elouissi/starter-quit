<!DOCTYPE html>
<html>

<head>
    <title>Cahier de charge</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        .page-break {
            page-break-after: always;
        }

        .primary-color {
            color: #4472c4;
        }

        .prompt-todo {
            background: #d100c0;
        }

        .todo {
            background: red
        }
    </style>
</head>

@php

    // specification
    $entreprise_name = $specification->entreprise_name;
    $contact_person = $specification->contact_person;
    $phone = $specification->phone;
    $email = $specification->email;
    $project_type = $specification->project_type;

    // objectif_site
    $project_need = $specification->objectif_site->project_need;
    $target_keywords = $specification->objectif_site->target_keywords;
    $languages = $specification->objectif_site->languages ?? [];
    $expected_functions = $specification->objectif_site->expected_functions ?? [];
    $payment_options = $specification->objectif_site->payment_options ?? [];

    // existing_analysis
    $hosting = $specification->existing_analysis->hosting;
    $sample_sites_files = $specification->existing_analysis->sample_sites_files ?? [];
    $constraints_files = $specification->existing_analysis->constraints_files ?? [];

    // design_content
    $color_palette = $specification->design_content->color_palette;
    $typography = $specification->design_content->typography;
    $number_of_propositions = $specification->design_content->number_of_propositions;
    $style_graphiques = $specification->design_content->style_graphiques ?? [];

    // deadline_and_budget
    $deadline = $specification->deadline_and_budget->deadline;
    $communication = $specification->deadline_and_budget->communication ?? [];

@endphp

<body>
    <div class="page-break">
        <h1 class="primary-color" style="text-align: center">Présentation de Havet Digital </h1>
        <br>
        <p>
            Bienvenue chez Havet Digital, où l'innovation digitale rencontre l'excellence et la créativité pour
            transformer
            votre présence en ligne. Spécialisée dans la création de sites internet de haute qualité, notre entreprise
            s'est
            établie comme un pilier du succès numérique en France, guidée par une passion pour le dépassement des
            attentes
            de nos clients.
        </p>

        <p>
            Notre mission chez Havet Digital est claire : accompagner chaque client dans sa transformation digitale en
            concevant des sites web qui ne se contentent pas d'être esthétiques, mais qui sont optimisés, fonctionnels
            et
            parfaitement alignés avec leurs objectifs stratégiques. Que vous cherchiez à lancer votre première
            plateforme en
            ligne ou à revitaliser un site existant, notre équipe d'experts dévoués mettra son savoir-faire à votre
            service
            pour créer une expérience utilisateur inoubliable.
        </p>
        <p>Le concept qui nous anime repose sur une approche sur mesure et participative. Nous valorisons un partenariat
            étroit avec nos clients, nous immergeant dans leur univers pour saisir au mieux leurs besoins spécifiques.
            Cette
            proximité nous permet de proposer des solutions web innovantes, efficaces et sur mesure, qui s'intègrent
            parfaitement dans le modèle de cahier des charges que nous prônons. Ce modèle, centré sur la clarté, la
            précision et l'anticipation des besoins futurs, est la pierre angulaire de notre démarche de création. Il
            assure
            non seulement la satisfaction immédiate de nos clients mais vise également une performance durable de leur
            projet digital.
        </p>
        <p>
            Nous exprimons notre gratitude envers tous ceux qui ont choisi Havet Digital pour les accompagner dans leur
            aventure digitale : clients, partenaires et notre équipe. Votre confiance renforce notre engagement à offrir
            des
            services de premier ordre, caractérisés par une qualité irréprochable et une attention minutieuse aux
            détails.
        </p>
        <p>
            Pour ceux qui envisagent de réinventer leur présence en ligne avec un site internet qui sort du lot, Havet
            Digital est votre allié idéal. Nous vous invitons à nous contacter pour explorer ensemble comment nos
            services
            peuvent propulser votre entreprise vers de nouveaux sommets digitaux.
        </p>
    </div>

    <div class="page-break">
        <h1 class="primary-color" style="text-align: center">Préambule </h1>
        <br>
        <p>
            Ce document constitue le cahier des charges pour la conception et la réalisation du site internet de
            {{ $entreprise_name }}.
            Il a pour vocation de définir de manière exhaustive les attentes, les objectifs, les
            spécifications techniques, ainsi que le cadre opérationnel et fonctionnel dans lequel le Projet devra
            être
            développé et déployé.
        </p>
        <p>
            L'ambition de ce cahier des charges est double. D'une part, il vise à fournir à tous les acteurs
            impliqués -
            qu'il s'agisse de l'équipe de développement, du client, ou de tout autre partie prenante - une vision
            claire
            et partagée du Projet. D'autre part, il entend établir un contrat moral et technique entre
            {{ $entreprise_name }}
            et le prestataire retenu pour la réalisation du Projet, garantissant que toutes les
            parties s'engagent à respecter les termes définis dans ce document.
        </p>

        <p>
            La réalisation de ce site internet doit permettre à {{ $entreprise_name }} d'atteindre
            les
            objectifs
            stratégiques préalablement identifiés. Pour ce faire, le site devra répondre à un ensemble de critères
            qualitatifs et fonctionnels spécifiques, détaillés dans les sections suivantes de ce cahier des charges.
        </p>

        <p>
            Il est impératif que ce document soit lu et approuvé par toutes les parties avant le démarrage effectif
            du
            Projet. Toute modification ou ajout ultérieur devra faire l'objet d'un avenant au présent cahier des
            charges
            et être validé par toutes les parties concernées.
        </p>
        <p>
            Ce cahier des charges est divisé en plusieurs sections, chacune abordant un aspect différent du Projet,
            de
            la présentation de l'entreprise cliente à la définition des fonctionnalités du site, en passant par les
            objectifs du site, le public cible, les préférences de design et d'interface, et bien plus encore. Cette
            structure vise à assurer une compréhension complète et détaillée du Projet, facilitant ainsi sa
            réalisation
            dans les meilleures conditions possibles.
        </p>

        <p>
            Nous remercions par avance toutes les personnes qui contribueront à la réalisation de ce Projet et
            exprimons
            notre confiance dans le fait que le travail conjoint et les efforts partagés mèneront à la création d'un
            site internet non seulement à la hauteur des attentes de {{ $entreprise_name }}, mais
            aussi
            source de
            valeur ajoutée pour ses utilisateurs finaux.
        </p>
    </div>

    <div class="page-break">
        <h1 class="primary-color" style="text-align: center">Méthodologie </h1>
        <br>
        <h3 class="primary-color">1. Introduction </h3>

        <p>
            Dans l'univers de la gestion de projet informatique, Havet Digital navigue entre deux grandes tendances
            méthodologiques : les méthodes agiles et le traditionnel cycle en V. Toutefois, étant donné les
            spécificités
            des projets de transformation digitale, qui englobent la gestion des données marketing, produit et
            d'entreprise, Havet Digital privilégie l'approche agile. Cette préférence s'explique par la nécessité
            d'une
            adaptation constante aux dynamiques évolutives du marché et de la stratégie commerciale.
        </p>

        <p>
            L'ère du cahier des charges immuable et exhaustif ne correspond plus aux réalités des projets numériques
            modernes. Ces derniers requièrent une définition flexible des priorités, susceptibles d'évoluer
            parallèlement à la stratégie globale de l'entreprise. C'est dans cette optique que Havet Digital
            s'oriente
            vers une gestion de projet résolument agile.
        </p>

        <p>
            Nous adoptons les principes fondamentaux de la méthode agile, notamment à travers l'utilisation de
            Scrum,
            pour offrir une gestion de projet itérative. Cette approche nous permet de maximiser la livraison de
            valeur
            en un minimum de temps, grâce à des cycles de développement courts et efficaces. Elle favorise ainsi une
            série d'avantages cruciaux pour la réussite des projets :
        </p>

        <ul>
            <li>
                <b>Amélioration de la fluidité des livraisons</b>
                et accélération de la vélocité des projets.
                Gestion flexible des modifications en cours de projet, permettant une adaptation rapide aux besoins
                émergents.
            </li>
            <li>
                <b>Gestion flexible des modifications</b>
                en cours de projet, permettant une adaptation rapide aux besoins émergents.
            </li>
            <li>
                <b>Réduction significative des formalités</b>
                excessives liées à la documentation et au
                contrôle.
            </li>
            <li>
                <b>Stimulation de l'engagement, de la discipline et de la motivation</b>
                au sein des équipes.
            </li>
            <li>
                <b>Optimisation de la performance</b>
                et de la qualité en réponse aux exigences clients.
            </li>
            <li>
                <b>Priorisation et réalisation rapide des fonctionnalités clés,</b>
                générant des bénéfices
                tangibles et immédiats.
            </li>

        </ul>
        <h3 class="primary-color">2. Schéma d'itération </h3>
        <p>
            L'approche itérative prônée par Havet Digital assure une réactivité optimale face aux demandes
            de changement, s'appuyant sur des valeurs fondamentales telles que la transparence, la simplicité
            et la collaboration étroite entre le prestataire et le client.
        </p>
        <img src="{{ public_path('assets/img/pdf/image.png') }}" style="width: 100%">
        <p>
            En adoptant la méthode Scrum, nous nous engageons à fournir régulièrement des fonctionnalités à forte
            valeur
            ajoutée, reflétant notre adhésion aux principes du manifeste agile :
        </p>
        <ul>

            <li>
                <b>Privilégier l'humain et les interactions </b>
                au-delà des processus et des outils.
            </li>
            <li>
                <b>Favoriser le fonctionnement des logiciels</b>
                plutôt que l'accumulation de documentation.
            </li>
            <li>
                <b>Encourager une collaboration active avec le client</b>
                au lieu de se reposer uniquement sur les contrats.
            </li>
            <li>
                <b>Être ouvert au changement </b>
                plutôt que de se figer sur un cahier des charges préétabli.
            </li>
        </ul>

        <p>
            Havet Digital se positionne comme un partenaire agile incontournable, dédié à vous accompagner dans le
            dédale des défis inhérents aux projets numériques. Notre engagement est de manœuvrer avec une agilité
            remarquable et une efficacité sans faille au cœur de ces complexités, assurant ainsi le triomphe de
            votre
            parcours de transformation digitale. Avec une expertise approfondie et une adaptabilité constante, Havet
            Digital se voue à la réalisation de vos ambitions numériques, transformant chaque obstacle en
            opportunité
            pour forger un avenir digital prospère pour votre entreprise.
        </p>

        <h3 class="primary-color">3. Équipe Projet </h3>
        <p>
            Pour mener à bien les projets de développement web, tels que la création de sites internet, il est
            essentiel de constituer une équipe projet compétente et bien structurée. Chez Havet Digital, nous
            comprenons l'importance de la collaboration étroite entre le client et notre équipe pour assurer la
            réussite du projet. Ainsi, nous mettons en place une équipe qui combine expertise technique et
            connaissance approfondie du marché, garantissant que les décisions prises répondent
            parfaitement aux besoins du projet tout en impliquant toutes les parties prenantes.

        </p>
        <p>
            La collaboration harmonieuse entre les équipes de développement et les commerciaux sur le
            terrain, la prise en compte des objectifs de management, ainsi que l'intégration des besoins métiers
            spécifiques, sont des éléments clés pour livrer un projet qui apporte une réelle valeur ajoutée aux
            clients. Le projet de développement web doit s'inscrire dans une vision globale de transformation
            digitale de l'entreprise, évitant ainsi les silos qui pourraient isoler ce canal des autres existants.
        </p>
        <p>
            Composition de l'Équipe Projet chez Havet Digital :
        </p>
        <ul>
            <li>
                <b>Donneur d'ordre : </b>
                Le client joue un rôle crucial en tant que valideur du projet et
                gestionnaire des coûts, assurant que le projet réponde à ses attentes et objectifs.
            </li>
            <li>
                <b>Responsable Produit (Product Owner) :</b>
                Chez Havet Digital, le Product Owner agit en
                tant que représentant des intérêts du client au sein de l'équipe projet. Il collabore
                étroitement avec l'équipe de développement, définit les fonctionnalités, priorise le backlog
                produit selon la valeur métier, et ajuste les priorités avant chaque itération.

            </li>
            <li>
                <b>Animateur d'équipe (Scrum Master) : </b>
                Le Scrum Master veille à la productivité et à
                l'efficacité de l'équipe de développement, en facilitant la communication et en éliminant les
                obstacles qui pourraient entraver la progression du projet.
            </li>
            <li>
                <b>Équipe de Développement : </b>
                L'équipe chez Havet Digital inclut des développeurs, des
                spécialistes SEO, des designers et des marketeurs. Cette équipe multidisciplinaire assure
                le développement fonctionnel, l'installation, le déploiement, les tests, ainsi que la création
                des supports de documentation nécessaires.
            </li>
            <li>
                <b>Intégrateurs : </b>
                Ils jouent un rôle crucial dans la gestion de la circulation des données entre
                les différents systèmes, en intégrant efficacement l'écosystème numérique du projet.
            </li>
        </ul>
        <p>
            Chez Havet Digital, notre conviction profonde réside dans l'idée que le succès d'un projet de
            développement web est intrinsèquement lié à la constitution d'une équipe projet structurée,
            dynamique et riche en compétences variées et complémentaires. Notre méthodologie de travail
            est fondée sur une approche profondément collaborative, qui marie avec finesse l'expertise
            technique de pointe à une vision stratégique à long terme, dans le but ultime de fournir des
            solutions web sur mesure. Ces solutions sont conçues pour répondre avec précision et pertinence
            aux besoins spécifiques de nos clients, en plaçant leurs attentes au cœur de notre démarche de
            création et de développement.
        </p>

        <p>
            Cette synergie entre différents domaines d'expertise au sein de notre équipe nous permet non
            seulement de naviguer avec agilité à travers les complexités techniques et stratégiques propres à
            chaque projet, mais aussi d'anticiper les évolutions du marché pour proposer des solutions
            avantgardistes.
            En alliant cette expertise technique à une compréhension approfondie des objectifs
            d'affaires de nos clients, Havet Digital s'engage à développer des sites web qui ne sont pas
            seulement esthétiquement plaisants et fonctionnellement robustes, mais qui sont également
            optimisés pour favoriser la croissance digitale et commerciale de nos clients.
        </p>
        <p>
            Notre engagement envers une collaboration étroite avec nos clients nous permet d'établir des
            relations de confiance et de transparence, éléments clés pour un partenariat réussi. Cette
            approche collaborative assure que chaque étape du projet est alignée avec la vision du client, tout
            en permettant à notre équipe d'apporter notre expertise pour guider, conseiller et implémenter les
            meilleures pratiques du développement web. En définitive, chez Havet Digital, nous nous dédions
            à transformer les visions de nos clients en réalités digitales performantes, en créant des
            expériences en ligne qui engagent leur audience et propulsent leur présence sur le web vers de
            nouveaux sommets.
        </p>
    </div>

    <div class="page-break">
        <h1 class="primary-color" style="text-align: center">Lexique </h1>
        <br>
        <p>
            <b>
                CMS (Content Management System) :
            </b>
            Un système de gestion de contenu (CMS) est une
            plateforme logicielle qui permet de créer, gérer et modifier le contenu d'un site web sans la
            nécessité de posséder des connaissances techniques approfondies en programmation. Les CMS
            offrent une interface utilisateur intuitive pour l'administration du site, facilitant l'ajout de
            contenus,
            comme des textes, images, et vidéos, ainsi que la personnalisation du design à travers des thèmes
            et des templates. Des exemples populaires de CMS incluent WordPress, Joomla, et Drupal. Ces
            outils sont particulièrement appréciés pour leur flexibilité, leur accessibilité et la possibilité
            qu'ils
            offrent de développer rapidement des sites web dynamiques et interactifs.
        </p>
        <p>
            <b>
                WordPress :
            </b>
            Système de gestion de contenu (CMS) open source et gratuit, largement utilisé
            pour créer et gérer des sites web. Initialement conçu pour le blogging, WordPress s'est
            développé pour supporter une large gamme de types de sites web, incluant des sites vitrines,
            des boutiques en ligne, des portfolios et des forums. Grâce à sa flexibilité, sa facilité d'utilisation
            et sa vaste communauté d'utilisateurs et de développeurs, WordPress offre une multitude de
            thèmes et de plugins permettant de personnaliser et d'étendre les fonctionnalités des sites web
            selon les besoins spécifiques des utilisateurs.
        </p>
        <p>
            <b>
                Woocommerce :
            </b>
            est une solution flexible pour WordPress qui permet de transformer facilement
            un site en une boutique en ligne. Conçu pour s'adapter à tous types d'entreprises,
            WooCommerce facilite la gestion des produits, des commandes, des clients et des paiements,
            offrant ainsi une plateforme e-commerce complète et personnalisable. C'est l'outil parfait pour
            ceux qui souhaitent se lancer dans la vente en ligne, offrant à la fois simplicité d'utilisation et
            richesse fonctionnelle.
        </p>
        <p>
            <b>
                Stripe :
            </b>
            est une solution technologique globale de paiement en ligne conçue pour faciliter les
            transactions électroniques pour les entreprises de toutes tailles. En tant que plateforme, Stripe
            offre un large éventail de services de traitement des paiements, permettant aux commerçants et
            aux développeurs d'intégrer facilement des fonctionnalités de paiement dans leurs sites web et
            applications mobiles. Stripe se distingue par son interface utilisateur intuitive, sa mise en œuvre
            rapide et sa conformité avec les normes de sécurité internationales, comme la norme PCI DSS,
            garantissant ainsi la protection des données sensibles des utilisateurs. Elle prend en charge une
            variété de méthodes de paiement, y compris les cartes de crédit et de débit, les virements
            bancaires, ainsi que d'autres options de paiement locales et internationales, rendant les
            transactions accessibles et pratiques pour un public mondial.
        </p>
        <p>
            <b>
                Paypal :
            </b>
            est un système de paiement en ligne qui permet aux utilisateurs d'envoyer et de recevoir
            de l'argent de manière sécurisée, rapide et pratique. Fondé en 1998, PayPal est devenu l'une des
            principales plateformes de paiement numérique au monde, offrant ses services à des millions de
            particuliers et d'entreprises dans plus de 200 pays. Avec PayPal, les utilisateurs peuvent effectuer
            des transactions en ligne sans avoir à partager leurs informations bancaires, ce qui renforce la
            sécurité des achats sur internet. La plateforme permet également de régler des achats, de recevoir
            des paiements pour des ventes, d'envoyer des transferts d'argent à des proches, et de gérer des
            abonnements et des facturations récurrentes. Reconnu pour sa facilité d'utilisation, PayPal offre
            une solution de paiement fiable et accessible pour une variété de besoins financiers en ligne.
        </p>
        <p>
            <b>
                SEO (Search Engine Optimization) :
            </b>
            Technique de marketing digital visant à améliorer le
            classement d'un site web sur les moteurs de recherche. Le SEO englobe l'optimisation des
            contenus, des mots-clés, des images et de la structure du site pour rendre les pages plus
            attractives aux yeux des moteurs de recherche comme Google. L'objectif est d'accroître la visibilité
            en ligne d'un site et d'attirer un trafic qualifié, sans recourir à la publicité payante.
        </p>
        <p>
            <b>
                SSL (Secure Socket Layer) :
            </b>
            Protocole de sécurité qui établit une connexion cryptée entre un
            serveur web et un navigateur, garantissant que toutes les données transmises restent privées et
            sécurisées. Utilisé pour sécuriser les transactions en ligne, les transferts de données et les
            connexions sur les sites web, le SSL est essentiel pour protéger les informations sensibles des
            utilisateurs contre les interceptions malveillantes.
        </p>
        <p>
            <b>
                FAQ (Foire Aux Questions) :
            </b>
            Section d'un site web regroupant les réponses aux questions
            fréquemment posées par les utilisateurs. La FAQ vise à fournir des informations claires et
            accessibles pour aider les visiteurs à résoudre leurs interrogations de manière autonome.
        </p>
        <p>
            <b>
                Jira :
            </b>
            Outil de gestion de projet et de suivi des bugs utilisé par les équipes de développement pour
            planifier, suivre et gérer le déroulement des tâches et des projets informatiques. Jira facilite la
            collaboration en équipe et permet un suivi précis de l'avancement du projet.
        </p>
        <p>
            <b>
                Maquette :
            </b>
            Représentation visuelle du design et de l'agencement d'un site web ou d'une
            application, créée avant le développement. La maquette sert à visualiser et à valider l'aspect
            esthétique et fonctionnel du projet avec les clients et les membres de l'équipe.
        </p>
        <p>
            <b>
                Calendly :
            </b>
            Application en ligne de planification de rendez-vous qui permet aux utilisateurs de fixer
            leurs disponibilités et d'inviter d'autres personnes à réserver des créneaux horaires. Calendly est
            utilisé pour simplifier la prise de rendez-vous sans nécessiter d'échanges d'emails multiples.
        </p>
        <p>
            <b>
                Chatbot IA (Intelligence Artificielle) :
            </b>
            Programme informatique capable de simuler une
            conversation avec les utilisateurs en utilisant l'intelligence artificielle. Les chatbots IA sont
            souvent
            utilisés sur les sites web pour fournir un support client instantané ou répondre aux questions
            fréquentes.
        </p>
        <p>
            <b>
                FTP (File Transfer Protocol) :
            </b>
            Protocole de transfert de fichiers entre un client et un serveur sur
            un réseau informatique. FTP est utilisé pour télécharger et téléverser des fichiers sur internet,
            permettant la mise à jour et la gestion de contenus sur les serveurs web
        </p>
    </div>

    <div class="page-break">
        <h1 class="primary-color" style="text-align: center">Présentation de Havet Digital </h1>
        <br>
        <h3 class="primary-color">1. Présentation du client </h3>
        <ul>
            <li>
                <b>Nom de l’entreprise : </b>
                {{ $entreprise_name }}
            </li>
            <li>
                <b>Contact : </b>
                {{ $contact_person }}
            </li>
            <li>
                <b>Téléphone : </b>
                {{ $phone }}
            </li>
            <li>
                <b>E-mail : </b>
                {{ $email }}
            </li>
            <li>
                <b>Moyen de communication : </b>
                {{ implode(', ', $communication) }}
            </li>
        </ul>
        <h3 class="primary-color">2. Présentation de l’activité </h3>
        <p class="prompt-todo">
            Prompt : [étant qu’expert en rédaction des cahiers des charges pour le développement d’un site
            internet, écrire moi un paragraphe sur l’activité de ce client : (site internet) ]
        </p>
        <h3 class="primary-color">3. Service / produit Vendu</h3>
        <p class="prompt-todo">
            Prompt [étant qu’expert en rédaction des cahiers des charges pour le développement d’un site
            internet, écrire moi un paragraphe sur les services ou les produits vendu de ce client : (site internet)
            ]
        </p>
    </div>
    <div class="page-break">
        <h1 class="primary-color" style="text-align: center">Présentation Générale du projet </h1>
        <br>
        <h3 class="primary-color">1. Périmètre du projet </h3>
        <p>
            Dans le cadre de ce cahier des charges, le périmètre du projet pour notre client comprend la conception
            et
            la
            @if ($project_need == 'Refonte de site web')
                refonte du site.
            @elseif($project_need == 'Création de site web')
                création d'un nouveau site.
            @endif

            @if ($project_type == 'E-commerce')
                novateur, dont la mission est de présenter et de vendre les produits et services offerts par notre
                client. Cette initiative vise à mettre en place une plateforme en ligne à la fois attrayante et
                fonctionnelle, conçue pour mettre en exergue la gamme complète des produits et services de notre
                client, tout en offrant une expérience d'achat fluide et sécurisée aux utilisateurs. L'accent sera
                mis
                sur le développement d'une interface utilisateur intuitive, facilitant la navigation à travers les
                différentes catégories de produits et services, et permettant aux clients de passer commande avec
                efficacité et confiance.
                Le site intégrera des fonctionnalités avancées, telles que des descriptions détaillées des produits
                et services, des avis clients, des recommandations personnalisées, ainsi qu'une solution de panier
                d'achat et de paiement en ligne sécurisé. Chaque produit et service sera présenté de manière à
                valoriser ses avantages et caractéristiques, incitant ainsi les visiteurs à effectuer des achats.
                Par
                ailleurs, une stratégie d'optimisation pour les moteurs de recherche (SEO) sera mise en œuvre
                pour maximiser la visibilité du site et attirer un trafic qualifié.
                En complément, ce projet comprendra la mise en place d'un système de gestion de contenu (CMS)
                ergonomique, permettant à notre client de mettre à jour le contenu du site aisément, afin d'assurer
                l'actualité et la pertinence des informations proposées.
                Ce site e-commerce est conçu pour devenir un outil commercial puissant, visant à accroître la
                portée de notre client sur le marché, à améliorer son image de marque et à booster les ventes de
                ses produits et services. En somme, ce projet vise à fournir à notre client une solution e-commerce
                complète, qui non seulement présente son offre de manière professionnelle mais facilite également
                le processus d'achat pour ses clients, contribuant ainsi à la croissance de son entreprise.
            @endif
            @if ($project_type == 'Site Vitrine')
                vitrine, dont l'objectif principal est de présenter les services proposés par notre client. Ce
                projet
                vise à développer une plateforme web esthétique, intuitive et informative, spécifiquement conçue
                pour mettre en avant l'expertise, les valeurs et les services uniques de notre client. La priorité
                sera
                accordée à la création d'une expérience utilisateur optimale, avec une navigation fluide et un
                design épuré qui facilite l'accès à l'information et encourage l'interaction avec les visiteurs.
                Le site intégrera des fonctionnalités essentielles telles que une présentation détaillée des
                services,
                des témoignages clients, une galerie d'images ou de vidéos illustrant les projets réalisés, et un
                formulaire de contact facilement accessible. Chaque service offert par notre client sera
                accompagné d'une description exhaustive et avantageuse, visant à informer clairement les
                visiteurs et à susciter leur intérêt. L'optimisation pour les moteurs de recherche (SEO) sera
                également une composante clé de ce projet, afin d'assurer une visibilité accrue du site sur Internet
                et d'attirer un trafic ciblé de potentiels clients.
                En outre, le projet englobera le développement d'un système de gestion de contenu (CMS)
                permettant à notre client de mettre à jour facilement le contenu du site, afin de garantir que les
                informations présentées restent actuelles et pertinentes. Ce site vitrine est envisagé comme un
                outil de communication stratégique, destiné à renforcer la présence en ligne de notre client, à
                valoriser son image de marque et à stimuler l'engagement des visiteurs envers ses services. En
                résumé, ce projet ambitieux est conçu pour établir une présence web solide et professionnelle pour
                notre client, reflétant son professionnalisme et la qualité de ses services.
            @endif
            @if ($project_type == 'Blog')
                blog pour notre client. L'objectif de ce projet est de fournir une plateforme riche en contenu,
                conçue
                spécifiquement pour mettre en avant l'expertise, les connaissances et les services de notre client
                à travers des articles, des études de cas, et des témoignages. Le site se distinguera par son design
                attrayant et sa facilité de navigation, encourageant les visiteurs à explorer divers sujets et à
                interagir avec le contenu proposé.
                Le site intégrera des fonctionnalités essentielles pour un blog réussi, notamment un système de
                gestion de contenu (CMS) intuitif permettant à notre client de publier, de mettre à jour et de gérer
                facilement les articles. Des catégories bien définies, des tags, et une fonction de recherche
                avancée seront implémentés pour aider les utilisateurs à trouver rapidement l'information qu'ils
                cherchent. De plus, une attention particulière sera portée à l'intégration des réseaux sociaux, afin
                de favoriser le partage du contenu et d'élargir la portée du blog.
                L'optimisation pour les moteurs de recherche (SEO) constituera également un pilier central de ce
                projet, assurant que le contenu du blog soit visible et bien positionné dans les résultats de
                recherche, attirant ainsi un trafic ciblé de qualité. Un espace de commentaires sera mis en place
                pour encourager les échanges et la construction d'une communauté autour du blog, renforçant
                l'engagement des lecteurs et la visibilité de notre client.
                En résumé, ce projet de création d'un site blog est envisagé comme une extension stratégique de
                la présence en ligne de notre client, visant à établir une plateforme de communication dynamique
                qui reflète son autorité dans son domaine. Ce blog servira non seulement à informer et à éduquer
                le public cible sur les sujets pertinents mais aussi à promouvoir les services de notre client de
                manière subtile et efficace, contribuant ainsi à son développement et à son succès.
            @endif
            @if ($project_type == "Site d'affiliation")
                d'affiliation pour notre client. L'objectif est de développer une plateforme spécialisée qui servira
                de
                pont entre les consommateurs et une sélection rigoureuse de produits et services, en mettant
                l'accent sur la génération de revenus à travers des commissions sur les ventes réalisées. Ce site
                se caractérisera par une interface utilisateur claire et engageante, facilitant la navigation et la
                découverte des offres affiliées.
                Le site intégrera des fonctionnalités adaptées au modèle d'affiliation, telles que des liens
                d'affiliation uniques, des descriptions de produits approfondies, des comparatifs, et des avis
                d'utilisateurs pour guider les visiteurs dans leurs choix d'achat. Une grande importance sera
                accordée à la qualité du contenu proposé, afin d'offrir une valeur ajoutée réelle aux utilisateurs
                et
                de favoriser leur confiance et leur fidélité. De plus, le site proposera des outils de suivi et
                d'analyse
                pour optimiser les stratégies d'affiliation et maximiser les revenus générés.
                Une stratégie SEO robuste sera mise en œuvre dès la conception du site pour assurer une visibilité
                optimale sur les moteurs de recherche et attirer un trafic qualifié intéressé par les produits et
                services recommandés. Le projet inclura également l'intégration de fonctionnalités sociales pour
                encourager le partage du contenu sur les réseaux sociaux, augmentant ainsi la portée du site et la
                possibilité d'attirer davantage de visiteurs.
                En conclusion, ce projet de création d'un site d'affiliation est conçu pour positionner notre client
                comme un acteur clé dans le domaine de la recommandation de produits et services en ligne. En
                fournissant une plateforme fiable et riche en informations utiles, notre client pourra non seulement
                générer des revenus par le biais de commissions mais également établir une présence en ligne
                forte et respectée, contribuant à long terme au succès et à la croissance de son entreprise.
            @endif
        </p>
        <h3 class="primary-color">2. Objectifs du projet </h3>
        <p class="prompt-todo">
            Prompt [étant qu’expert en rédaction des cahiers des charges pour le développement d’un site
            internet, les objectifs : (objectifs), réécrire moi un paragraphe sur les objectifs attendu de ce client
            ]
        </p>
        <h3 class="primary-color">3. Public Cible </h3>
        <p class="prompt-todo">
            Prompt [étant qu’expert en rédaction des cahiers des charges pour le développement d’un site
            internet, écrire moi un paragraphe sur le public cible de ce client : (site internet) ]

        </p>
        <h3 class="primary-color">4. Concurrence </h3>
        <p class="prompt-todo">
            Prompt [voici les concurrents (valeur des sites concurrents), étant qu’expert en rédaction des
            cahiers des charges pour le développement d’un site internet, écrire moi deux paragraphe sur
            l’analyse des principaux concurrents et identification des points forts à intégrer sur le site internet
            que le client souhaite]
        </p>
    </div>

    <div class="page-break">
        <h1 class="primary-color" style="text-align: center">Etude Fonctionnelle </h1>
        <br>
        <h3 class="primary-color">1. Besoins et attentes </h3>
        @if ($project_type == 'E-commerce')
            <p>
                Le site e-commerce est conçu pour transcender l'expérience d'achat en ligne traditionnelle, en
                offrant à nos clients une plateforme à la fois esthétique et fonctionnelle, où la facilité de
                navigation
                et la sécurité des transactions sont nos priorités absolues. Chaque élément, de la page d'accueil
                jusqu'au processus de paiement, est pensé pour simplifier et sécuriser l'expérience utilisateur,
                garantissant une satisfaction totale à chaque étape de l'achat.
            </p>
        @endif
        @if ($project_type == 'Site Vitrine')
            <p>
                Le site vitrine est spécialement conçu pour présenter notre marque et nos produits de manière
                élégante et informative, offrant aux visiteurs une expérience de navigation enrichissante et
                intuitive.
                En mettant l'accent sur un design attractif et une ergonomie soignée, notre plateforme vise à
                captiver l'attention de nos clients potentiels dès le premier instant, tout en fournissant toutes
                les
                informations nécessaires sur nos produits, notre histoire et nos valeurs.
            </p>
        @endif
        @if ($project_type == 'Blog')
            <p>
                Le site blog est une plateforme riche en contenus, conçue pour engager, informer et inspirer notre
                audience autour de thèmes spécifiques qui reflètent notre passion et notre expertise. Chaque
                article publié vise à offrir une valeur ajoutée à nos lecteurs, qu'il s'agisse de conseils
                pratiques,
                d'analyses approfondies, de tendances du secteur ou de retours d'expériences personnels. Nous
                mettons un point d'honneur à maintenir une haute qualité rédactionnelle et à proposer une diversité
                de sujets, afin de captiver l'intérêt de nos visiteurs et de les encourager à revenir régulièrement.
                En outre, notre site blog facilite l'interaction avec notre communauté grâce à des fonctionnalités
                telles que les commentaires et le partage sur les réseaux sociaux, permettant ainsi un échange
                dynamique d'idées et d'opinions. Notre objectif est de créer un espace de discussion ouvert et
                enrichissant, où chaque lecteur peut découvrir, apprendre et se sentir partie intégrante d'une
                communauté partageant des intérêts communs.
            </p>
        @endif
        @if ($project_type == "Site d'affiliation")
            <p>
                Le site d'affiliation se positionne comme un carrefour stratégique entre les consommateurs à la
                recherche de produits de qualité et les marques ou commerçants offrant exactement ce dont ils
                ont besoin. En sélectionnant méticuleusement et en présentant des produits à travers des revues
                détaillées, des comparatifs et des guides d'achat, nous aidons nos visiteurs à faire des choix
                éclairés tout en générant des revenus à travers les liens d'affiliation. Chaque produit recommandé
                est le résultat d'une analyse approfondie visant à garantir satisfaction et pertinence pour notre
                audience. Nous travaillons en étroite collaboration avec des partenaires réputés pour offrir non
                seulement des options diversifiées mais également des offres exclusives, assurant ainsi que nos
                utilisateurs bénéficient des meilleures affaires. Notre engagement envers la transparence et la
                qualité des informations fait de notre site une ressource fiable et précieuse pour tous ceux qui
                cherchent à optimiser leurs achats en ligne, tout en soutenant notre mission d'offrir un contenu de
                valeur et une expérience utilisateur exceptionnelle.
            </p>
        @endif
        <h3 class="primary-color">2. Fonctionnalités Nécessaires </h3>
        <h4 style="margin-left: 30px">1. Fonctionnalités de base</h4>
        <p>
            Pour garantir une expérience utilisateur optimale et présenter de manière efficace l'identité ainsi
            que les valeurs de notre client, certaines fonctionnalités de base seront intégrées au site. Parmi
            ces éléments fondamentaux, la <b> Page d'accueil </b> jouera un rôle crucial, agissant comme le portail
            principal à travers lequel les visiteurs accèdent à l'ensemble du contenu du site. Elle sera conçue
            pour captiver immédiatement l'attention, avec un design attractif et des appels à l'action clairs,
            guidant les utilisateurs vers les sections les plus importantes du site.
        </p>
        <p>
            La <b> Page À propos </b> constituera un autre pilier essentiel du site, offrant un espace dédié à
            l'histoire
            de l'entreprise, sa mission, sa vision, et les valeurs qui la guident. Cette page permettra de tisser
            un lien plus personnel avec les visiteurs, en leur donnant un aperçu de l'humain derrière l'entreprise
            et en renforçant la confiance envers la marque.
        </p>
        <p>
            La <b> section FAQ </b> du site sera un espace dédié à répondre aux interrogations fréquentes des
            utilisateurs, couvrant des thématiques variées telles que les modalités de commande, les
            spécificités des produits ou services, les options de livraison, et les politiques de retour. Conçue
            pour faciliter l'accès à l'information et améliorer l'expérience utilisateur, cette section regroupera
            les questions organisées par catégories, avec des réponses claires et précises. L'objectif est de
            dissiper les doutes, d'accroître la confiance des visiteurs et de leur permettre de naviguer sur le
            site avec assurance, tout en réduisant le besoin d'assistance directe. En fournissant des
            informations pertinentes et à jour, la FAQ jouera un rôle crucial dans l'optimisation de la satisfaction
            client et l'efficacité du service client.
        </p>
        <p>
            <b> Un formulaire de contact </b> accessible, pour offrir à nos utilisateurs un moyen direct et
            simplifié de
            communiquer avec notre équipe. Ce formulaire devient un pont entre les utilisateurs du site et le
            webmaster, permettant d'envoyer des questions, de demander des informations détaillées sur nos
            services ou de signaler toute préoccupation. À chaque soumission de formulaire, une notification
            par email sera automatiquement envoyée au webmaster, assurant ainsi qu'aucun échange ne
            passe inaperçu. Ce système de notification garantit une gestion efficace des demandes,
            permettant une réaction rapide et adaptée à chaque situation. En offrant cette voie de
            communication directe et en assurant un suivi consciencieux, nous consolidons la relation de
            confiance avec nos visiteurs, tout en améliorant leur satisfaction globale envers notre marque.
        </p>
        @if (in_array('Blog', $expected_functions))
            <p>
                Un <b> blog </b> sera également intégré au site, destiné à partager des contenus riches et
                pertinents,
                Ces
                contenus rédigés par des experts visent à éduquer, informer et engager notre audience, tout en
                renforçant notre positionnement comme référence dans notre secteur. Le blog est un outil précieux
                pour attirer du trafic qualifié sur notre site, augmenter notre visibilité en ligne et construire
                une
                communauté fidèle autour de notre marque.
            </p>
        @endif


        @if (count($languages) === 1 && in_array('Français', $languages))
            <p>
                Le site est exclusivement en français, ciblant ainsi spécifiquement le marché francophone. Cette
                approche unilingue nous permet de concentrer nos efforts sur une personnalisation et une
                optimisation maximales du contenu pour notre public cible. En maintenant notre site en français,
                nous assurons une communication claire et précise, renforçant notre proximité avec nos clients
                francophones.
            </p>
        @endif
        @if ($project_type == 'E-commerce')
            <p>
                La présence d'une <b> section de témoignages </b> sur notre site e-commerce constitue une
                fonctionnalité essentielle pour instaurer confiance et crédibilité auprès de nos visiteurs. Cette
                section mettra en avant les avis et les expériences vécues par nos clients, offrant ainsi une
                perspective authentique sur la qualité de nos produits et services. Les témoignages seront
                soigneusement sélectionnés pour refléter la diversité et la satisfaction de notre clientèle,
                encourageant les nouveaux visiteurs à procéder à l'achat en toute confiance. L'intégration de cette
                fonctionnalité contribuera non seulement à augmenter notre taux de conversion mais aussi à
                renforcer notre réputation en ligne.
            </p>
            <p>
                la <b> boutique en ligne sera dotée de filtres avancés </b> pour faciliter la navigation et la
                recherche
                de
                produits par les utilisateurs. Ces filtres permettront de trier les articles selon divers critères
                tels
                que
                la catégorie, le prix, la marque, la taille ou encore la couleur. Cette fonctionnalité vise à
                améliorer
                l'expérience utilisateur en rendant la recherche de produits plus intuitive et moins chronophage.
                Grâce à ces filtres avancés, les clients pourront aisément trouver les articles qui correspondent
                exactement à leurs besoins et préférences, optimisant ainsi leur parcours d'achat sur notre site.
            </p>
            <p>
                Le processus de <b> panier de commande </b> sur notre site e-commerce sera conçu pour être simple,
                sécurisé et efficace. À partir du moment où un utilisateur ajoute un produit à son panier jusqu'à la
                finalisation de la commande, chaque étape sera clairement définie et facile à suivre. Les
                utilisateurs
                pourront modifier les quantités, supprimer des articles ou continuer leurs achats avant de procéder
                au paiement. Des informations précises sur les coûts, y compris les taxes et les frais de livraison,
                seront fournies avant la validation de la commande. Notre objectif est de rendre ce processus le
                plus transparent et fluide possible, pour minimiser les abandons de panier et encourager la
                finalisation des achats.
            </p>
            <p>
                L'implémentation d'un <b> système de notification par email </b> jouera un rôle clé dans la
                communication avec nos clients après qu'une commande a été confirmée. À chaque étape
                importante du processus de commande - confirmation de la commande, préparation de l'envoi,
                expédition du colis - un email automatique sera envoyé au client pour le tenir informé. Ce système
                de notification permettra non seulement de rassurer les clients quant au statut de leur commande,
                mais aussi de maintenir une ligne de communication ouverte entre notre entreprise et nos clients.
                En outre, ces notifications pourront être personnalisées pour inclure des offres spéciales ou
                recommander des produits similaires, renforçant ainsi la relation client et stimulant de futures
                achats.
            </p>
        @endif

        <h4 style="margin-left: 30px">2. Fonctionnalités avancées </h4>
        @if (in_array('Backoffice', $expected_functions))
            <p>
                En coulisses, un backoffice sophistiqué nous permettra de gérer efficacement les produits, les
                commandes et les contenus du site, conçu pour offrir à notre équipe une gestion optimale des
                produits, des catégories de produits et des stocks. Cette interface administrative permet une
                organisation précise et efficace de notre catalogue en ligne, facilitant l'ajout, la modification et
                la
                suppression de produits en quelques clics. La gestion des catégories permet de structurer l'offre
                de manière logique et intuitive pour les utilisateurs, améliorant ainsi leur expérience de
                navigation.
                De plus, le suivi en temps réel des stocks assure une mise à jour instantanée des disponibilités,
                prévenant les ruptures de stock et permettant une planification précise des réapprovisionnements.
                Ce backoffice est le pilier de notre stratégie de gestion e-commerce, assurant que notre site offre
                toujours une information produit actualisée et fiable.
            </p>
            <p>
                L'intégration d'un système de panier sophistiqué représente une autre avancée majeure pour notre
                site e-commerce. Ce système permet aux clients de sélectionner et de réserver leurs produits avec
                une grande facilité, tout en continuant leur shopping. Conçu pour être à la fois intuitif et
                fonctionnel,
                le panier offre un résumé détaillé des articles choisis, des prix, des taxes applicables et des
                options
                de livraison, fournissant ainsi une transparence totale avant la validation de l'achat. Les
                utilisateurs
                peuvent modifier à tout moment le contenu de leur panier, ajoutant ou retirant des produits selon
                leurs besoins, ce qui rend l'expérience d'achat flexible et adaptée aux préférences individuelles.
            </p>
        @endif
        @if (in_array('Stripe', $expected_functions) || in_array('Paypal', $expected_functions))
            <p>
                La sécurité des transactions est une priorité absolue sur notre site e-commerce, c'est pourquoi
                nous avons mis en place un système de paiement hautement sécurisé. En collaborant avec des
                leaders reconnus des solutions de paiement en ligne, nous offrons à nos clients une variété
                d'options de paiement fiables et pratiques, incluant les cartes bancaires, PayPal, et d'autres
                portemonnaies
                électroniques. Chaque transaction est protégée par des protocoles de cryptage avancés
                pour garantir la confidentialité et la sécurité des données financières de nos clients. Nous nous
                engageons à fournir un environnement de paiement sans risque, où nos clients peuvent effectuer
                leurs achats en toute confiance, bénéficiant d'une expérience d'achat en ligne sûre et sécurisée à
                chaque visite.
            </p>
        @endif

        @if (in_array('Demande de devis', $payment_options))
            <p>
                L'introduction d'une fonctionnalité de demande de devis sur notre site e-commerce marque une
                étape significative vers une personnalisation accrue de l'expérience client. Cette option permet aux
                visiteurs de soumettre des demandes spécifiques pour des produits ou des commandes en gros,
                offrant ainsi une flexibilité et une adaptabilité à leurs besoins uniques. Que ce soit pour des
                achats
                en volume, des demandes spéciales ou des personnalisations de produits, les clients peuvent
                désormais obtenir une estimation sur mesure directement en ligne. Cette approche interactive
                renforce l'engagement client et souligne notre volonté de fournir des solutions adaptées à chaque
                utilisateur, en facilitant la communication directe et en assurant une réponse rapide et précise à
                leurs demandes.
            </p>
            <p>
                En mettant en place ce système de demande de devis, nous visons à simplifier le processus
                d'achat pour les clients professionnels et les consommateurs qui recherchent des offres
                personnalisées. Cette fonctionnalité enrichit notre site d'une dimension commerciale
                supplémentaire, en créant un canal de vente consultatif qui valorise le dialogue et la
                personnalisation. Elle témoigne de notre engagement à offrir une expérience client exceptionnelle,
                en mettant l'accent sur la satisfaction des besoins spécifiques et en renforçant la confiance dans
                notre marque. Par cette initiative, nous établissons un lien plus étroit avec notre clientèle, en
                lui
                offrant des services adaptés et en valorisant chaque demande individuelle comme une opportunité
                de collaboration et de partenariat.
            </p>
        @endif
        @if (in_array('COD (Paiement à la livraison)', $payment_options))
            <p>
                L'ajout de l'option de <b> paiement à la livraison (COD - Cash On Delivery) </b> sur le site
                e-commerce
                constitue une avancée majeure dans notre offre de services, visant à maximiser la commodité et
                la confiance de nos clients lors de leurs achats. Cette méthode de paiement traditionnelle, mais
                toujours appréciée, permet aux clients de régler leurs commandes en espèces au moment de la
                réception, offrant ainsi une alternative sécurisée pour ceux qui préfèrent éviter les transactions
                en
                ligne ou qui n'ont pas accès aux moyens de paiement numériques. Le COD élimine les barrières
                à l'achat en ligne, en rassurant les clients sur la sécurité de leurs transactions et en renforçant
                la
                crédibilité de site.
            </p>
            <p>
                En introduisant le paiement à la livraison, nous nous engageons à répondre aux besoins diversifiés
                de votre clientèle, en proposant une solution flexible qui s'adapte à différentes préférences de
                paiement. Cette méthode contribue également à améliorer l'expérience d'achat globale, en offrant
                une tranquillité d'esprit supplémentaire aux clients qui peuvent évaluer physiquement le produit
                avant de finaliser leur achat. En valorisant la satisfaction et la confiance du client, le COD
                s'inscrit
                dans notre stratégie de service clientèle de premier ordre, visant à fournir une expérience d'achat
                en ligne sans faille, accessible et rassurante pour tous.
            </p>
        @endif
        @if (in_array('Chatbotai', $expected_functions))
            <p>
                Le site va intègrer un chatbot AI, conçu pour offrir une assistance instantanée à nos visiteurs
                24/7.
                Grâce à l'intelligence artificielle, ce chatbot peut répondre aux questions fréquentes, guider les
                utilisateurs dans leur navigation et même assister dans le processus d'achat. Cet outil
                d'interaction
                automatique améliore l'accessibilité de notre service client et augmente la satisfaction
                utilisateur.
            </p>
        @endif
        @if (in_array('Calendly', $expected_functions))
            <p>
                Nous allons intégrer Calendly sur notre site pour simplifier la prise de rendez-vous en ligne. Que
                ce soit pour planifier une consultation personnalisée, une démonstration de produit ou un service
                après-vente, Calendly offre à nos clients une méthode simple et efficace pour réserver un créneau
                horaire qui leur convient. Cette fonctionnalité améliore l'organisation de nos services et la
                commodité pour nos clients.
            </p>
        @endif
        @if (in_array('Capture des leads', $expected_functions))
            <p>
                Pour optimiser notre stratégie de marketing digital, un formulaire dédié à la capture de leads sera
                positionné sur la page d'accueil, invitant les visiteurs à s'inscrire à notre newsletter pour
                recevoir
                des offres exclusives et les dernières nouvelles de notre marque. Cet outil stratégique vise à
                convertir les visiteurs en prospects en leur proposant de s'inscrire à notre newsletter ou de
                télécharger du contenu exclusif. En collectant les informations de contact, nous pouvons ensuite
                engager ces leads avec des campagnes de marketing ciblées, augmentant ainsi nos chances de
                conversion.
            </p>
        @endif
        @if (in_array('Géolocalisation', $expected_functions))
            <p>
                Et la fonctionnalité de géolocalisation sur notre site enrichit l'expérience utilisateur en offrant
                des
                services personnalisés basés sur leur emplacement géographique. Que ce soit pour afficher les
                prix dans la devise locale, proposer des offres spéciales ou indiquer le magasin le plus proche, la
                géolocalisation permet d'adapter notre contenu et nos services pour mieux répondre aux besoins
                de notre clientèle internationale.
            </p>
        @endif
        @if (count($languages) > 2)
            <p>
                Le site est conçu pour être multilingue, permettant ainsi à des utilisateurs du monde entier
                d'accéder à nos contenus dans leur langue maternelle. Cette capacité à briser les barrières
                linguistiques est essentielle pour élargir notre marché, améliorer l'expérience utilisateur et
                renforcer
                l'inclusivité de notre marque. En proposant plusieurs langues, nous invitons une audience globale
                à découvrir nos produits et services.
            </p>
        @endif



        @if (count($payment_options) === 1 && in_array('Stripe', $payment_options))
            <p>
                Pour répondre aux attentes de nos clients en matière de transactions sécurisées et pratiques, notre
                site a intégré Stripe comme solution principale de paiement en ligne. Cette plateforme de paiement
                réputée se distingue par sa simplicité d'utilisation et sa sécurité renforcée, offrant une
                expérience
                d'achat fluide et rassurante pour l'utilisateur. Stripe permet aux clients de régler leurs achats
                via
                une variété de méthodes, incluant les cartes de crédit et de débit, garantissant ainsi une
                flexibilité
                maximale. De plus, grâce à l'interface épurée de Stripe, le processus de paiement est rapide et
                intuitif, minimisant les étapes nécessaires pour finaliser une transaction et réduisant le risque
                d'abandon de panier.
            </p>
            <p>
                La sécurité des transactions est au cœur de nos préoccupations, et c'est une raison
                supplémentaire pour laquelle nous avons choisi Stripe comme partenaire. Cette plateforme
                applique des normes de sécurité parmi les plus strictes de l'industrie, utilisant des protocoles de
                cryptage avancés pour protéger les informations sensibles de nos clients. Stripe est également
                conforme aux normes PCI DSS (Payment Card Industry Data Security Standard), assurant que
                toutes les données de carte sont traitées dans un environnement hautement sécurisé. Nos clients
                peuvent donc effectuer leurs achats en toute confiance, sachant que leurs informations
                personnelles et bancaires sont protégées contre toute tentative de fraude.
            </p>
            <p>
                En intégrant Stripe à notre site, nous nous engageons non seulement à fournir une méthode de
                paiement fiable et sécurisée, mais également à améliorer constamment l'expérience d'achat de
                nos clients. Notre équipe travaille en étroite collaboration avec Stripe pour implémenter les
                dernières innovations en matière de paiement en ligne, telles que les paiements sans contact ou
                les wallets électroniques, afin de répondre aux besoins changeants de notre clientèle. Cette
                approche proactive nous permet de rester à l'avant-garde du e-commerce, en offrant une
                plateforme à la fois moderne, conviviale et sécurisée, où nos clients peuvent se procurer leurs
                baskets Adidas préférées avec une tranquillité d'esprit totale.
            </p>
        @endif
        @if (count($payment_options) === 1 && in_array('Paypal', $payment_options))
            <p>
                Dans le cadre de notre engagement à offrir une expérience d'achat en ligne sécurisée et pratique,
                notre site a adopté PayPal comme méthode de paiement privilégiée. Reconnue mondialement pour
                sa fiabilité et sa facilité d'utilisation, PayPal permet à nos clients de réaliser des transactions
                sans
                avoir à saisir à chaque fois leurs informations bancaires. Cette approche simplifie
                considérablement le processus de paiement, rendant l'achat de baskets Adidas sur notre
                plateforme à la fois rapide et sans tracas. En outre, PayPal offre la possibilité de payer via un
                large
                éventail de sources, y compris les soldes PayPal, les cartes de crédit, de débit, et même les
                virements bancaires, offrant ainsi une flexibilité maximale à nos utilisateurs.
            </p>
            <p>
                La sécurité est une priorité absolue pour nous, et c'est là que PayPal excelle. En utilisant des
                systèmes de cryptage avancés et en appliquant des mesures de prévention de la fraude parmi les
                plus strictes du marché, PayPal assure que chaque transaction est protégée. Les clients peuvent
                effectuer leurs achats en toute confiance, sachant que leurs données personnelles et financières
                sont sécurisées à chaque étape du processus de paiement. De plus, PayPal propose un
                programme de protection des achats, offrant une couche supplémentaire de sécurité et de
                tranquillité d'esprit aux acheteurs en cas de problème avec leur commande.
            </p>
            <p>
                L'intégration de PayPal à notre site e-commerce témoigne de notre volonté d'améliorer
                constamment l'expérience d'achat de nos clients. En facilitant une méthode de paiement reconnue
                pour sa simplicité d'utilisation et sa sécurité exceptionnelle, nous visons à éliminer les obstacles
                à
                l'achat en ligne, encourageant ainsi nos clients à revenir pour toutes leurs besoins en baskets
                Adidas. Nous restons attentifs aux retours de nos clients et nous nous engageons à adapter nos
                services pour répondre à leurs attentes, faisant de notre site une destination de choix pour les
                amateurs de sneakers à la recherche de facilité, de sécurité et de qualité.
            </p>
        @endif
        @if (in_array('Paypal', $payment_options) || in_array('Stripe', $payment_options))
            <p>
                Pour répondre aux attentes diversifiées de nos clients en matière de transactions sécurisées et
                pratiques, notre site a choisi d'intégrer deux des solutions de paiement en ligne les plus fiables
                et
                populaires : Stripe et PayPal. Cette combinaison offre à nos utilisateurs une flexibilité sans
                précédent dans le choix de leur mode de paiement, qu'il s'agisse d'utiliser directement leurs cartes
                bancaires via Stripe pour une transaction rapide et sécurisée, ou de profiter de la commodité et de
                la protection supplémentaire offertes par PayPal. Ces plateformes sont reconnues pour leur facilité
                d'utilisation, assurant que le processus d'achat sur notre site soit aussi fluide que possible,
                depuis
                la sélection des produits jusqu'à la finalisation de l'achat.
            </p>
            <p>
                La sécurité est une priorité absolue dans le choix de nos partenaires de paiement. Stripe et PayPal
                emploient des technologies de cryptage de pointe pour protéger les informations de paiement de
                nos clients. En adhérant aux normes de sécurité les plus strictes, y compris la conformité PCI DSS,
                ces systèmes garantissent que toutes les données sont traitées dans un environnement sécurisé.
                Les clients peuvent ainsi réaliser leurs achats en toute confiance, sachant que leurs données
                personnelles et financières sont protégées contre toute tentative de fraude. De plus, PayPal offre
                un programme de protection de l'acheteur, ajoutant une couche de sécurité supplémentaire en cas
                de litige ou de problème avec une commande.
            </p>
            <p>
                L'intégration de Stripe et PayPal souligne notre engagement à offrir une expérience client
                exceptionnelle sur notre site. En fournissant des options de paiement variées et sécurisées, nous
                facilitons l'accès à notre gamme de baskets Adidas, tout en renforçant la confiance et la
                satisfaction
                de nos clients. Nous nous engageons à suivre l'évolution des technologies de paiement pour
                continuer à proposer les solutions les plus innovantes et pratiques, assurant ainsi que chaque
                achat sur notre site soit non seulement agréable et simple, mais aussi extrêmement sûr. Notre
                objectif est de faire en sorte que chaque visiteur puisse se concentrer sur la découverte de nos
                produits, sans se préoccuper des détails du paiement.
            </p>
        @endif

        <p style="background: violet">
            [S’il a rempli le champ de spécifications techniques que le client souhaite] <br>
            Prompt [étant qu’expert en rédaction des cahiers des charges pour le développement d’un site
            internet, récrire moi en 3 paragraphes les spécifications techniques (spécifications techniques) que
            le client souhaite avoir sur son site]
        </p>
        <h4 style="margin-left: 30px">3. Intégrations tierces</h4>
        @if (in_array('Plugins sur mesure', $expected_functions))
            <p>
                Nous allons développer et intégrer des plugins sur mesure pour enrichir les fonctionnalités du site.
                Ces outils personnalisés sont conçus pour répondre spécifiquement aux besoins uniques de notre
                activité et de nos utilisateurs, offrant des fonctionnalités qui ne sont pas disponibles via les
                solutions standard. Les plugins sur mesure nous permettent d'offrir une expérience utilisateur
                unique et
                différenciée.
            </p>
        @endif
        @if (in_array('Besoin des APIs', $expected_functions))
            <p>
                Le site utilisera des APIs pour se connecter avec des applications tierces, permettant ainsi une
                intégration fluide de services externes. Que ce soit pour l'analyse de données, les paiements en
                ligne, le marketing par e-mail ou les réseaux sociaux, ces connexions API facilitent
                l'automatisation
                des processus et l'enrichissement de l'expérience utilisateur sur notre plateforme.
            </p>
        @endif
        @if (in_array('Google Analytics', $expected_functions))
            <p>
                L'intégration de Google Analytics au sein de notre site internet développé sous WordPress
                constitue une démarche stratégique essentielle pour mesurer et comprendre le comportement des
                utilisateurs sur notre plateforme. Cet outil d'analyse puissant nous permettra de recueillir des
                données précieuses sur les visites, les sources de trafic, les taux de conversion et bien d'autres
                indicateurs clés de performance. En exploitant ces informations, nous serons en mesure
                d'optimiser continuellement l'expérience utilisateur, d'ajuster nos stratégies de contenu et de
                marketing, et ainsi, de maximiser l'efficacité de notre présence en ligne. L'installation de Google
                Analytics sera réalisée de manière à garantir la collecte de données fiables et conformes aux
                normes de protection de la vie privée.
            </p>
        @endif
        @if (in_array('Réseaux sociaux', $expected_functions))
            <p>
                L'intégration des réseaux sociaux sur un site internet est une stratégie indispensable dans le
                contexte digital actuel, permettant de renforcer la visibilité de la marque et d'encourager
                l'engagement des utilisateurs. Cette démarche consiste à incorporer des fonctionnalités sociales
                directement sur le site, telles que des boutons de partage vers Facebook, Twitter, Instagram ou
                LinkedIn, qui facilitent la diffusion du contenu par les visiteurs sur leurs propres réseaux. De
                plus,
                l'affichage de flux en direct provenant des comptes sociaux de la marque sur le site web offre une
                dynamique de contenu renouvelé et incite les utilisateurs à suivre l'entreprise sur ces plateformes.
                L'intégration des réseaux sociaux contribue également à améliorer le référencement naturel (SEO)
                du site, car les interactions générées (partages, likes, commentaires) sont des indicateurs de
                qualité pris en compte par les moteurs de recherche. En somme, cette intégration crée un pont
                entre le site de l'entreprise et ses plateformes sociales, favorisant ainsi une meilleure
                interaction
                avec la communauté, l'accroissement du trafic web et l'élargissement de la portée de la marque
                sur internet.
            </p>
        @endif

    </div>

    <div class="page-break">
        <h1 class="primary-color" style="text-align: center">Thème et Contenu</h1>
        <h3 class="primary-color">1. Préférences de Design et d'Interface</h3>
        <ul>
            <li>
                <b>Style visuel : </b> A faire
            </li>
            <li>
                <b>Palette de couleurs : </b> {{ $color_palette }}
            </li>
            <li>
                <b>Typographie : </b> {{ $typography }}
            </li>
            <li>
                <b>Disposition de Menu : </b> A faire
            </li>
        </ul>
        <h3 class="primary-color">2. Contenu</h3>
        <ul>
            <li>
                <b>Plan de contenu :</b>
                <p> a faire [Tableau de contenu]</p>
                <p>
                    Dans le processus de création et de développement de votre site internet, notre équipe s'engage
                    @if ($number_of_propositions == 1)
                        à fournir une proposition unique, comprenant des maquettes,
                    @else
                        à fournir {{ $number_of_propositions }} propositions
                        distinctes, comprenant des maquettes,
                    @endif
                    des visuels, des logos, ainsi que des suggestions de texte et de contenu pour le site. Cette
                    approche a pour objectif de vous offrir un éventail de choix reflétant différentes visions créatives
                    et
                    stratégiques, tout en restant alignées avec l'identité de votre marque et vos objectifs commerciaux.
                    Chaque proposition sera élaborée avec soin par notre équipe de designers, de rédacteurs et de
                    développeurs, en tenant compte des dernières tendances du design web, de l'ergonomie utilisateur
                    et des meilleures pratiques en matière de SEO.
                </p>
            </li>
            <li>
                <b>Arborescence du site :</b>
                <p style="background: violet">
                    Prompt avec une api
                </p>
            </li>
            <li>
                <b>Les éléments sur Mesure :</b>
                <p style="background: violet">
                    Prompt [écrire un paragraphe détaillé pour élaborer Les éléments à développer sur mesure (valeur
                    de champ Contraintes) que le client voulait inclure sur le site internet sur le cahier de charge de
                    son site internet]
                </p>
                <p style="background: violet">
                    Prompt [écrire un paragraphe détaillé pour élaborer Les éléments suivants (valeur de champ des
                    exemples de sites avec un commentaire) que le client voulait inclure sur le site internet sur le
                    cahier
                    de charge de son site internet]
                </p>
            </li>
            <p style="background-color: red">
                [Si le Designer à mis en place la maquette merci d’afficher les éléments suivants]
            </p>
            <li>
                <b>La maquette du site et les visuels :</b>
                <p style="background-color: red">
                    Vous trouverez en ce lien la prémaquette :
                </p>
                <p style="background-color: red">
                    Vous trouverez en ce lien les visuels crées :
                </p>
            </li>
        </ul>
    </div>

    <div class="page-break">
        <h1 class="primary-color" style="text-align: center">Stratégies de Référencement (SEO)</h1>
        <h3 class="primary-color">1. Mots-clés cibles</h3>
        @if ($target_keywords)
            <p style="background-color: violet">
                Prompt [dans la section de Stratégies de Référencement en Mots-clés cibles sur le cahier de
                charge de son site internet à envoyer au client merci d'élaborer cette phrase dans deux
                paragraphes : (valeur de champs des mots clés)]
            </p>
        @else
            <p>
                Dans le cadre de notre stratégie de référencement, une attention particulière sera portée à
                l'optimisation autour des mots-clés cibles tels que "Baskets Adidas", "Adidas running", et "Adidas
                originals". Ces termes ont été soigneusement sélectionnés pour correspondre aux recherches les
                plus fréquentes de notre public cible, garantissant ainsi que notre site web apparaisse parmi les
                premiers résultats sur les moteurs de recherche lorsque ces expressions sont utilisées. En
                intégrant ces mots-clés de manière stratégique dans le contenu de notre site, notamment dans les
                titres, les méta descriptions, les en-têtes, et le corps du texte, nous améliorons significativement
                notre visibilité en ligne. Cette approche ciblée vise à attirer un trafic qualifié vers notre site,
                composé d'utilisateurs déjà intéressés par les produits Adidas, augmentant ainsi les chances de
                conversion.
                Parallèlement, l'utilisation de ces mots-clés spécifiques dans notre stratégie de contenu
                contribuera à établir notre site comme une référence dans le domaine des baskets Adidas. En
                créant des articles de blog, des guides d'achat et des descriptions de produits riches en
                informations et pertinents pour ces termes de recherche, nous renforçons notre autorité et notre
                crédibilité auprès des moteurs de recherche et des utilisateurs. Cette démarche permet non
                seulement de répondre aux besoins d'information de notre audience mais aussi de créer un lien
                de confiance avec elle. En fin de compte, notre objectif est de devenir la destination privilégiée
                pour tous ceux qui recherchent des baskets Adidas, en assurant une présence dominante sur les
                mots-clés stratégiques qui définissent notre niche.
            </p>
        @endif
        <h3 class="primary-color">2. Optimisation sur la page</h3>
        <p>
            L'optimisation sur la page joue un rôle crucial dans le succès d'un site internet, car elle contribue
            directement à améliorer son référencement naturel (SEO) et à enrichir l'expérience utilisateur. Pour
            cela, nous accordons une attention particulière à l'utilisation stratégique des balises HTML, qui
            incluent les balises de titre (title tags) et les en-têtes (headings) pour structurer le contenu de
            manière efficace. Ces balises permettent non seulement d'organiser l'information de façon claire
            pour les visiteurs, mais aussi de souligner l'importance de certains mots-clés pour les moteurs de
            recherche. En parallèle, les méta descriptions sont soigneusement rédigées pour chaque page,
            offrant un résumé attractif et pertinent du contenu. Ces courtes descriptions apparaissent dans les
            résultats de recherche et jouent un rôle déterminant dans la décision de l'internaute de cliquer ou
            non sur votre site.
        </p>
        <p>
            En outre, la structure des URLs est optimisée pour être conviviale et compréhensible à la fois par
            les utilisateurs et par les moteurs de recherche. Des URLs claires, logiques et contenant des motsclés
            pertinents non seulement facilitent la navigation sur le site, mais contribuent également à une
            meilleure indexation des pages dans les résultats de recherche. Cette approche de structuration
            des URLs aide à renforcer la cohérence et l'accessibilité du site, éléments essentiels pour
            améliorer le classement dans les moteurs de recherche et pour offrir une expérience utilisateur
            optimale. En intégrant ces éléments d'optimisation sur la page dans notre cahier des charges, nous
            nous assurons que votre site est conçu dès le départ avec les meilleures pratiques SEO en tête,
            favorisant ainsi sa visibilité et son attractivité sur le long terme.
        </p>
        <p class="todo">
            Rubrique fait par le seo [Balises de titre, méta descriptions, structure des URL, sitemap]
        </p>
        <h3 class="primary-color">3. Création de contenu SEO</h3>
        <p>
            Au cœur de notre stratégie de référencement (SEO) se trouve la création de contenu SEO, une
            démarche méthodique visant à produire des textes riches et pertinents, soigneusement élaborés
            autour des mots-clés cibles identifiés pour votre projet. Cette approche assure non seulement une
            visibilité accrue de votre site sur les moteurs de recherche, mais contribue également à établir
            votre autorité dans votre domaine d'activité. En intégrant les mots-clés de manière naturelle et
            stratégique dans le contenu de votre site, des articles de blog aux descriptions de produits, nous
            optimisons chaque page pour qu'elle soit facilement indexable et bien classée par les moteurs de
            recherche. Cette rédaction orientée SEO est essentielle pour attirer un trafic qualifié, composé
            d'utilisateurs activement à la recherche des produits ou services que vous proposez.
        </p>
        <p>
            Par ailleurs, au-delà de l'aspect technique du référencement, la création de contenu SEO a pour
            objectif de fournir une valeur ajoutée réelle aux visiteurs de votre site. Il ne s'agit pas seulement
            d'attirer des clics, mais de captiver l'attention des lecteurs, de répondre à leurs questions et de les
            guider dans leur parcours d'achat ou de découverte. Pour cela, nous nous engageons à produire
            un contenu engageant, informatif et utile, qui résonne avec les besoins et les intérêts de votre
            audience cible. En alliant pertinence pour les moteurs de recherche et valeur pour les utilisateurs,
            notre contenu SEO joue un rôle déterminant dans la conversion des visiteurs en clients fidèles,
            soutenant ainsi la croissance et le succès de votre présence en ligne.
        </p>
    </div>

    <div class="page-break">
        <h1 class="primary-color" style="text-align: center">Considérations Techniques </h1>
        <h3 class="primary-color">1. Plateforme de développement </h3>
        <p>
            Pour la réalisation de votre projet de site web, nous avons sélectionné WordPress comme
            plateforme de gestion de contenu, en raison de sa flexibilité, de sa facilité d'utilisation et de sa
            grande popularité à travers le monde. WordPress offre une base solide pour le développement de
            sites web personnalisés grâce à sa vaste bibliothèque de thèmes et de plugins. Pour votre projet,
            nous opterons pour un thème personnalisé, conçu sur mesure pour répondre précisément à vos
            besoins et à votre identité visuelle. Cette approche personnalisée garantit que votre site se
            démarquera de la concurrence, offrant une expérience unique à vos visiteurs. Le design sur
            mesure, associé à la puissance de WordPress, permet une grande souplesse dans la gestion du
            contenu, vous donnant la liberté de mettre à jour facilement votre site, d'ajouter de nouvelles pages
            et de publier des articles de blog pour engager votre audience.
        </p>
        @if ($project_type == 'E-commerce')
            <p>
                En complément, pour la partie e-commerce de votre site, nous intégrerons WooCommerce, la
                solution e-commerce la plus populaire pour WordPress. WooCommerce est parfaitement adapté
                pour gérer des boutiques en ligne de toutes tailles, offrant une gamme étendue de fonctionnalités
                spécifiques au commerce électronique, telles que la gestion des produits, des commandes, des
                clients et des modes de paiement. Cette extension vous permettra de vendre vos produits ou
                services directement sur votre site, avec une interface de gestion intuitive et des options de
                personnalisation avancées pour créer une expérience d'achat fluide et sécurisée pour vos clients.
                En tant qu'IT manager de l'entreprise, vous bénéficierez d'un contrôle total sur la plateforme, avec
                la capacité d'adapter et d'optimiser le site en fonction de l'évolution de vos objectifs commerciaux.
            </p>
        @endif
        <h3 class="primary-color">2. Responsive design </h3>
        <p>
            Notre engagement envers l'excellence et l'accessibilité nous pousse à garantir que votre site sera
            entièrement optimisé pour tous les appareils, qu'il s'agisse d'ordinateurs de bureau, de tablettes
            ou de smartphones. Cette approche de design responsive assure que votre site offrira une
            expérience utilisateur cohérente et de haute qualité, quel que soit le moyen d'accès choisi par vos
            visiteurs. En adaptant automatiquement la mise en page, les images et le contenu à la taille de
            l'écran de l'appareil utilisé, nous maximisons la lisibilité et l'ergonomie de votre site. Cette
            optimisation multiplateforme est essentielle dans le monde numérique d'aujourd'hui, où les
            utilisateurs naviguent sur internet via une multitude d'appareils. Elle contribue non seulement à
            améliorer l'engagement des utilisateurs et à réduire le taux de rebond, mais elle est également
            favorable au référencement de votre site sur les moteurs de recherche, Google valorisant
            particulièrement les sites offrant une expérience mobile optimale.
        </p>
        <h3 class="primary-color">3. Performance et chargement </h3>
        <p>
            Dans notre quête constante de fournir une expérience utilisateur sans faille, nous accordons une
            importance primordiale à la performance et à la vitesse de chargement de votre site. Pour ce faire,
            nous mettons en œuvre une série de techniques d'optimisation avancées visant à réduire au
            minimum le temps de chargement des pages. Parmi ces techniques figurent la compression des
            images et des fichiers CSS/JavaScript pour diminuer la taille des données transférées, l'utilisation
            du lazy loading pour charger les images uniquement lorsque cela est nécessaire, ainsi que
            l'implémentation de caches efficaces pour accélérer l'accès aux contenus fréquemment consultés.
            Ces stratégies sont essentielles pour assurer une navigation rapide et réactive, contribuant ainsi à
            améliorer l'expérience globale du visiteur sur votre site.
        </p>
        <p>
            En outre, nous analysons régulièrement la performance du site à l'aide d'outils spécialisés pour
            identifier et corriger tout goulot d'étranglement potentiel. Cette approche proactive nous permet de
            maintenir des temps de chargement optimaux, même face à un trafic élevé ou à l'évolution des
            technologies web. En optimisant continuellement la vitesse de votre site, nous visons non
            seulement à satisfaire les attentes des utilisateurs modernes, qui privilégient des sites rapides et
            accessibles, mais également à favoriser un meilleur classement dans les résultats de recherche
            des moteurs comme Google, qui privilégient les sites offrant une excellente performance de
            chargement. Cet engagement envers la rapidité et l'efficacité est au cœur de notre stratégie de
            développement, garantissant que votre site se démarque dans l'environnement numérique
            compétitif d'aujourd'hui.
        </p>
        <h3 class="primary-color">4. Hébergement </h3>
        <p>
            Notre solution d'hébergement sécurisé sur l'environnement PLESK est conçue pour offrir à
            votre site internet une protection maximale et une performance inégalée. Grâce au filtrage
            antispam, vous bénéficiez d'une réduction significative des courriers indésirables, assurant ainsi la
            propreté et la sécurité de vos communications électroniques. L'utilisation du FTP sécurisé (SFTP)
            garantit que tous les transferts de fichiers se font dans un canal crypté, protégeant vos données
            sensibles contre les interceptions. De plus, notre système antivirus et notre protection anti-DDoS
            sont continuellement mis à jour pour défendre votre site contre les nouvelles menaces et attaques,
            tandis que le pare-feu robuste bloque les accès non autorisés, assurant ainsi une sécurité de
            premier niveau pour votre présence en ligne.
        </p>
        <p>
            En outre, nous avons mis en place des mesures anti-incendie et assurons une sécurité rigoureuse
            de l'accès au data center, garantissant que votre site reste opérationnel même dans les situations
            les plus critiques. La réplication des données et la sauvegarde automatique assurent la
            récupération rapide de votre site en cas de défaillance matérielle ou logicielle, minimisant ainsi les
            temps d'arrêt et protégeant votre investissement. La gestion des accès est soigneusement
            contrôlée, permettant uniquement aux utilisateurs autorisés de modifier le site, ce qui renforce
            davantage la sécurité de votre environnement web.
        </p>
        <p>
            La mise à jour régulière du site, des plugins et des logiciels utilisés est essentielle pour maintenir
            la fonctionnalité et la sécurité de votre site à leur niveau optimal. Nos équipes techniques
            s'occupent de ces mises à jour pour vous, éliminant le risque d'exploitation des vulnérabilités par
            les cyberattaquants. Les sauvegardes régulières de vos données sont une autre couche de
            sécurité importante, permettant une restauration rapide et efficace en cas de besoin. En
            choisissant notre solution d'hébergement sur PLESK, vous optez pour une tranquillité d'esprit
            totale, sachant que votre site est hébergé dans un environnement sécurisé, performant et géré par
            des experts dédiés à sa réussite.
        </p>
        <p>
            De plus, en hébergeant votre site sur notre plateforme dédiée, la maintenance et les mises à jour
            régulières sont incluses dans les frais de configuration, garantissant ainsi que votre site fonctionne
            de manière optimale en tout temps. Cette maintenance proactive couvre tout, des mises à jour de
            sécurité critiques à la performance générale et aux ajustements de configuration nécessaires pour
            répondre à l'évolution de vos besoins. En nous confiant l'hébergement de votre site, vous ne
            bénéficiez pas seulement d'un environnement sécurisé et performant pour votre présence en ligne,
            mais également d'une équipe dévouée à assurer que votre site reste à la pointe de la technologie,
            sécurisé contre les menaces et parfaitement aligné avec les meilleures pratiques du web. Cette
            combinaison de technologie avancée, d'expertise professionnelle et de soutien continu est conçue
            pour vous offrir la meilleure expérience d'hébergement possible.
        </p>
        <h3 class="primary-color">5. Sécurité </h3>

        <p>
            La sécurité de votre site web est une priorité absolue dans notre stratégie de développement, et
            pour cela, nous mettons en œuvre plusieurs mesures robustes pour protéger à la fois vos données
            et celles de vos utilisateurs. Premièrement, l'implémentation d'un certificat SSL (Secure Socket
            Layer) est prévue pour chaque site que nous développons. Ce certificat assure une connexion
            sécurisée entre le serveur web et le navigateur de l'utilisateur, cryptant toutes les données
            transmises pour prévenir les écoutes indiscrètes et garantir l'intégrité des informations échangées.
            En plus du SSL, nous adoptons des solutions avancées pour la protection contre les malwares, en
            utilisant des logiciels de sécurité de pointe qui surveillent et éliminent activement toute tentative
            d'infection par des logiciels malveillants, protégeant ainsi votre site contre les attaques et les
            intrusions.
        </p>
        <p>
            Parallèlement, nous comprenons l'importance de la prévention des pertes de données, c'est
            pourquoi nous instaurons des procédures de sauvegardes régulières. Ces sauvegardes sont
            effectuées automatiquement à des intervalles fréquents et stockées dans des emplacements
            sécurisés, garantissant que vous pouvez rapidement restaurer votre site à un état antérieur en cas
            de problème. Cette stratégie de sauvegarde, combinée avec nos mesures de sécurité proactive,
            offre une couche de protection complète pour votre site, minimisant les risques de temps d'arrêt et
            assurant la continuité de votre activité en ligne. En adoptant ces pratiques de sécurité de premier
            ordre, nous nous engageons à fournir un environnement web sûr et fiable pour vous et vos
            utilisateurs, soutenant ainsi la confiance et la crédibilité de votre présence en ligne.
        </p>
        <h3 class="primary-color">6. Suivi et Analyse </h3>
        <ul>
            <li>
                <b> Outils d'analyse</b>
                <p>
                    Grâce à Google Analytics, nous générerons des rapports de performance réguliers qui fourniront
                    une vue d'ensemble détaillée de l'activité sur le site. Ces rapports incluront des analyses
                    approfondies sur les pages les plus visitées, le comportement des utilisateurs, les parcours de
                    navigation, ainsi que l'efficacité de nos campagnes publicitaires. Ces insights seront cruciaux pour
                    identifier les opportunités d'amélioration et les éventuels points de friction dans le parcours
                    utilisateur. En disposant d'une compréhension claire des performances de notre site, nous
                    pourrons prendre des décisions éclairées, basées sur des données tangibles, pour améliorer
                    continuellement notre offre et notre communication.
                </p>
            </li>
            <li>
                <b> Configuration et Intégration de Google Analytics </b>
                <p>
                    Pour commencer à utiliser Google Analytics, créez d'abord un compte Google Analytics et suivez
                    les instructions pour ajouter le code de suivi fourni à votre site web. Ce code permet à Google
                    Analytics de commencer à collecter des données sur les interactions des visiteurs avec votre site.
                    Il est crucial de s'assurer que le code de suivi est correctement intégré sur toutes les pages que
                    vous souhaitez analyser pour obtenir des données complètes et précises.
                </p>
            </li>
            <li>
                <b>Configuration et Intégration de Google Analytics</b>
                <p>
                    Pour commencer à utiliser Google Analytics, créez d'abord un compte Google Analytics et suivez
                    les instructions pour ajouter le code de suivi fourni à votre site web. Ce code permet à Google
                    Analytics de commencer à collecter des données sur les interactions des visiteurs avec votre site.
                    Il est crucial de s'assurer que le code de suivi est correctement intégré sur toutes les pages que
                    vous souhaitez analyser pour obtenir des données complètes et précises.
                </p>
            </li>
            <li>
                <b>Comprendre les Rapports Google Analytics</b>
                <p>
                    Une fois Google Analytics configuré, les utilisateurs ont accès à une multitude de rapports divisés
                    en plusieurs catégories principales : Audience, Acquisition, Comportement et Conversions.
                <ul>
                    <li>
                        <b>Audience :</b>
                        Cette section fournit des informations sur les caractéristiques de vos visiteurs,
                        telles que leur langue, leur localisation géographique, le type d'appareil utilisé pour accéder
                        au site, et leur comportement en termes de sessions et de durée moyenne des visites. Cela
                        aide à comprendre qui sont vos visiteurs et comment ils interagissent avec votre site.
                    </li>
                    <li>
                        <b>Acquisition :</b>
                        Ici, vous découvrirez comment les visiteurs trouvent votre site, que ce soit
                        via des moteurs de recherche, des réseaux sociaux, des liens directs ou des campagnes
                        payantes. Cette analyse est essentielle pour évaluer l'efficacité de vos stratégies de
                        marketing digital et d'optimisation pour les moteurs de recherche (SEO).
                    </li>
                    <li>
                        <b>Comportement :</b>
                        Cette catégorie révèle ce que les visiteurs font sur votre site, quelles
                        pages ils consultent le plus, le temps passé sur chacune d'elles et les taux de rebond. Ces
                        données permettent d'identifier les contenus les plus engageants et les zones du site
                        nécessitant des améliorations.
                    </li>
                    <li>
                        <b>Conversions :</b>
                        Pour les sites e-commerce ou ceux ayant des objectifs spécifiques (comme
                        le remplissage de formulaires ou les inscriptions à une newsletter), cette section mesure le
                        succès avec lequel votre site atteint ces objectifs. Cela inclut le suivi des transactions, des
                        revenus et des taux de conversion.
                    </li>
                </ul>
                </p>
            </li>
            <li>
                <b>Exploiter les Données pour l'Optimisation</b>
                <p>
                    L'utilisation efficace de Google Analytics réside dans l'exploitation des données collectées pour
                    prendre des décisions éclairées. En identifiant les sources de trafic les plus rentables, les
                    contenus
                    qui captivent le plus l'attention des visiteurs, ou encore les points de friction qui entravent les
                    conversions, les propriétaires de sites peuvent ajuster leurs stratégies pour améliorer l'expérience
                    utilisateur, optimiser le contenu et augmenter la rentabilité.
                </p>
            </li>
            <li>
                <b>Rapports de performance </b>
                <p>
                    L'exploitation stratégique des données recueillies par Google Analytics jouera un rôle prépondérant
                    dans l'élaboration de nos stratégies digitales. En analysant les tendances de trafic, les
                    comportements d'achat et les interactions des utilisateurs avec notre site, nous serons en position
                    de développer des stratégies marketing et de contenu hautement ciblé. Ces stratégies seront
                    conçues pour répondre précisément aux besoins et aux intérêts de notre audience, augmentant
                    ainsi l'engagement, la fidélisation et, ultimement, les conversions. La mise en place d'objectifs
                    spécifiques dans Google Analytics nous permettra également de mesurer l'impact direct de nos
                    actions et d'ajuster nos plans en fonction des résultats obtenus, assurant ainsi une démarche
                    d'amélioration continue et orientée vers la performance.
                </p>
                <p>
                    Google Analytics est un outil indispensable pour tout propriétaire de site web souhaitant mesurer
                    et améliorer la performance de son site. En fournissant des insights précieux sur le comportement
                    des visiteurs et l'efficacité des campagnes marketing, Google Analytics aide les entreprises à
                    optimiser leur présence en ligne et à atteindre leurs objectifs commerciaux.
                </p>
            </li>
        </ul>
    </div>
    <div class="page-break">
        <h1 class="primary-color" style="text-align: center">Maintenance et Mises à Jour </h1>
        <h3 class="primary-color">1. Plan de maintenance </h3>
        <p>
            Dans le cadre de notre engagement à assurer la sécurité et la performance optimales de votre site,
            notre plan de maintenance est conçu pour assurer la sécurité, la performance et la fiabilité de votre
            site web sur le long terme. Une composante essentielle de ce plan est la mise en œuvre régulière
            des mises à jour de sécurité, qui sont cruciales pour protéger votre site contre les vulnérabilités
            nouvelles et émergentes. Ces mises à jour comprennent à la fois le cœur du système de gestion
            de contenu (comme WordPress), les plugins et les thèmes utilisés sur votre site. Nous
            programmons ces mises à jour à une fréquence adaptée à l'activité de votre site et à la criticité des
            corrections à appliquer, garantissant ainsi que votre plateforme bénéficie en permanence des
            dernières protections sans perturber son fonctionnement ou l'expérience utilisateur. Cette vigilance
            constante est votre meilleure défense contre les attaques informatiques et assure la continuité de
            votre activité en ligne.
        </p>
        <p>
            En parallèle des mises à jour de sécurité, notre plan de maintenance inclut également une
            vérification régulière des liens cassés sur votre site. Les liens brisés peuvent non seulement frustrer
            vos visiteurs mais aussi nuire à votre référencement sur les moteurs de recherche. À l'aide d'outils
            spécialisés, nous effectuons des scans périodiques pour identifier et corriger tout lien ne
            fonctionnant plus, qu'il s'agisse de liens internes menant à des pages de votre site ou de liens
            externes pointant vers d'autres sites web. Cette attention portée à la qualité de votre site contribue
            à améliorer l'expérience des utilisateurs et à renforcer l'autorité de votre domaine aux yeux des
            moteurs de recherche.
        </p>
        <p>
            Notre engagement dans un plan de maintenance rigoureux et proactif vise à vous libérer des
            préoccupations techniques pour que vous puissiez vous concentrer sur le développement de votre
            entreprise. En assurant des mises à jour de sécurité fréquentes et en maintenant une structure de
            lien impeccable, nous offrons à votre site web une fondation solide pour sa croissance et son
            succès en ligne. Ce processus continu de maintenance garantit que votre plateforme reste
            performante, sécurisée et conforme aux standards actuels du web, soutenant ainsi vos objectifs
            commerciaux et renforçant la confiance de vos clients.
        </p>
        <h3 class="primary-color">2. Support technique </h3>
        <p>
            Notre service de support technique est dédié à offrir une assistance rapide et efficace, garantissant
            la résolution de tout problème technique que vous pourriez rencontrer avec votre site internet. Nous
            nous engageons à être disponibles pendant les jours ouvrables, assurant une réactivité optimale
            pour répondre à vos besoins. Conscients de l'importance de la continuité de votre activité en ligne,
            nous nous efforçons de répondre à toutes les demandes dans un délai maximal de 24 heures.
            Cette promesse de réactivité vise à minimiser tout impact négatif sur l'expérience utilisateur et sur
            vos opérations commerciales, vous permettant ainsi de maintenir un site web performant et
            accessible en tout temps. Notre équipe de support technique, composée de professionnels
            expérimentés, est prête à vous fournir des solutions rapides et adaptées, quelle que soit la
            complexité de votre demande.
        </p>
    </div>
    <div class="page-break">
        <h1 class="primary-color" style="text-align: center">Budget et Délais </h1>
        <h3 class="primary-color">1. Délais de réalisation </h3>
        <p>
            Le lancement de votre site web est prévu pour {{ $deadline }} après le début effectif du projet, un
            calendrier ambitieux mais réalisable grâce à une planification minutieuse et à une collaboration
            étroite entre nos équipes et la vôtre. Pour atteindre cet objectif, nous avons défini des étapes clés
            qui jalonnent le projet, depuis la phase initiale de conception jusqu'à la mise en ligne. Ces étapes
            comprennent la définition des besoins, la création du design, le développement des fonctionnalités
            essentielles, l'intégration du contenu, les tests de fonctionnement et d'usabilité, ainsi que la révision
            finale. Chaque phase est soigneusement programmée pour s'assurer que le projet avance selon
            le planning établi, tout en maintenant des standards de qualité élevés.

        </p>
        <h3 class="primary-color">2. Estimation du budget </h3>
        <p>
            L'estimation budgétaire pour la création, le développement et la conception du contenu initial de
            votre site internet se positionne entre 5 000 et 10 000 euros. Cette estimation a été rigoureusement
            définie pour s'assurer que chaque phase du projet est exécutée avec un niveau optimal de qualité
            et d'efficacité. Cette gamme budgétaire reflète notre engagement à fournir une solution sur mesure
            qui encapsule fidèlement votre identité de marque, implémente des fonctionnalités spécialement
            conçues pour répondre à vos exigences uniques et développe un contenu engageant qui résonne
            avec votre public cible. Investir dans ces aspects cruciaux du développement de site web est
            fondamental pour établir une présence en ligne à la fois professionnelle et captivante, éléments
            clés pour transformer les visiteurs en clients dévoués.
        </p>
        <p>
            En outre, le budget prévu englobe l'incorporation de systèmes de gestion de contenu (CMS) tels
            que WordPress. Cette inclusion vise à simplifier la gestion post-lancement de votre site, vous
            offrant la possibilité de mettre à jour le contenu de manière indépendante et intuitive. Cette flexibilité
            est essentielle pour maintenir votre site dynamique et en phase avec les attentes de votre
            audience. Parallèlement, une allocation budgétaire est réservée à l'optimisation initiale pour les
            moteurs de recherche (SEO), une étape critique pour assurer une visibilité optimale de votre site
            dès son déploiement. Cette initiative précoce en SEO est cruciale pour positionner
            avantageusement votre site dans les résultats de recherche, attirant ainsi un trafic qualifié dès les
            premiers jours de sa mise en ligne.
        </p>
        <p>
            Il est important de souligner que l'estimation budgétaire fournie peut varier en fonction des
            spécificités du projet, telles que la complexité du développement, les fonctionnalités additionnelles
            souhaitées et les ajustements éventuels découlant de l'évolution de vos besoins durant le
            processus de développement. Nous sommes déterminés à entretenir une communication
            transparente et continue avec vous pour adapter le projet en fonction de votre budget et de vos
            attentes. Notre objectif est de forger un partenariat solide, axé sur la réussite de votre projet web,
            tout en veillant à maximiser votre retour sur investissement et à atteindre vos ambitions
            commerciales avec efficacité.
        </p>

    </div>
    <div class="page-break-off">
        <p>
            Le tableau suivant représente un aperçu clair sur les détails de délais et les budgets estimés pour
            votre site internet :
        </p>
        <table border="2" style="table-layout:fixed;width: 100%; border-collapse: collapse;font-size: 12px;">

            <thead>
                <tr>
                    <td rowspan="15" style="width: 20%;  text-align: center; vertical-align: middle;padding: 10px">
                        Délais
                        &
                        Budgétisation</td>
                    <td style="width: 32%; padding: 2px 10px;">Désignation</td>
                    <td style="width: 16%; padding: 2px 10px; text-align: center;">Nombre de jours</td>
                    <td style="width: 16%; padding: 2px 10px; text-align: center;">Montant unitaire</td>
                    <td style="width: 16%; padding: 2px 10px; text-align: center;">Total HT</td>
                </tr>
                @php
                    $budgetisation = [
                        [
                            'title' => "Installation de l'environnement",
                        ],
                        [
                            'title' => 'Intégration de la structure',
                        ],
                        [
                            'title' => 'Ebauche Des Textes et traductions',
                        ],
                        [
                            'title' => 'Maquettage graphique',
                        ],
                        [
                            'title' => 'Développement & intégrations web',
                        ],
                        [
                            'title' => 'Intégration des textes et images',
                        ],
                        [
                            'title' => "Intégration d'autres pages (contact, catégories ...etc.)",
                        ],
                        [
                            'title' => 'Optimisation de la version Mobile',
                        ],
                        [
                            'title' => 'Intégration du multilingue',
                        ],
                        [
                            'title' => 'Optimisation Pour SEO',
                        ],
                        [
                            'title' => 'Suivi et tests',
                        ],
                        [
                            'title' => 'Gestion de projets',
                        ],
                    ];
                @endphp
                @php
                    $total = 0;
                @endphp

                @foreach ($budgetisation as $item)
                    @php
                        $randomNumber = rand(2, 10);
                        $randomEuroAmount = rand(2000, 10000) / 100;
                        $total += $randomNumber * $randomEuroAmount;
                    @endphp
                    <tr>
                        <td style="padding: 2px 10px;">{{ $item['title'] }}</td>
                        <td style="padding: 2px 10px; text-align: center;">{{ $randomNumber }}</td>
                        <td style="padding: 2px 10px; text-align: center;">
                            {{ number_format($randomEuroAmount, 2, ',', '.') }} €</td>
                        <td style="padding: 2px 10px; text-align: center;">{{ $randomNumber * $randomEuroAmount }} €
                        </td>
                    </tr>
                @endforeach

                <tr>
                    <td style="padding: 2px 10px;">Remise exceptionnelle </td>
                    <td style="padding: 2px 10px; text-align: center;" colspan="3">
                        {{ number_format(rand(2000, 10000) / 100, 2, ',', '.') }} €
                    </td>
                </tr>

                <tr>
                    <td style="padding: 2px 10px;">Total (HT) </td>
                    <td style="padding: 2px 10px; text-align: center;" colspan="3">
                        {{ number_format($total, 2, ',', '.') }} €
                    </td>
                </tr>
            </thead>
        </table>
        <p>
            Afin d'assurer une transparence totale et de faciliter la compréhension de nos modalités de
            collaboration, nous détaillons ci-après les conditions de paiement associées au développement de
            votre site internet. Cette structure est conçue pour aligner les étapes financières sur l'avancement
            du projet, garantissant ainsi une gestion efficace des ressources tout en répondant à vos attentes.
            Les conditions incluent des acomptes, le solde final à la livraison, ainsi que des options pour des
            services complémentaires optionnels. Voici un aperçu clair et structuré des engagements
            financiers à prévoir :
        <ul>
            <li style="background: yellow">
                <b>Acomptes :</b>
                <ul>
                    <li>
                        [Premier acompte] :
                        [valeur de champ de pourcentage] %
                        à la signature du contrat,
                        soit [valeur de prix précalculé] € HT.
                    </li>
                    <li>
                        [Second acompte] :
                        [valeur de champ de pourcentage] %
                        du total, également [valeur de prix précalculé] € HT.
                    </li>
                </ul>
            </li>
            <li style="background: yellow">
                <b>Solde :</b>
                <ul>
                    <li>
                        Paiement du solde : [valeur de prix précalculé] € HT à régler à la fin de la recette
                        globale, validée par un Procès-Verbal (PV) de réception, confirmant la satisfaction
                        du client et l'achèvement du projet.
                    </li>
                </ul>
            </li>
            <li style="background: yellowgreen">
                <b>Mise en place de l'hébergement :</b>
                <ul>
                    <li>
                        Frais de configuration et allocation d'un espace d'hébergement sur nos
                        serveurs sécurisés : 500 € HT.
                    </li>
                </ul>
            </li>
            <li style="background: yellow">
                <b> Maintenance Annuelle : </b>
                <ul>
                    <li>
                        [Valeur de champ de pourcentage] % du coût de développement, applicable
                        à partir de 6 mois suivant la date anniversaire du PV de recette globale.
                        Cette maintenance inclut les évolutions mineures, les mises à jour et les
                        corrections pour une durée d'un an, payable en une fois de [valeur de prix
                        précalculé] € HT
                    </li>
                </ul>
            </li>
            <p>
                Ces conditions ont été soigneusement élaborées pour assurer une gestion financière transparente
                et efficace du projet, tout en offrant des services optionnels pour garantir la sécurité et la
                performance optimale de votre site web sur le long terme.
            </p>
        </ul>
        </p>
        <h3 class="primary-color">3. Planification et réalisation du projet </h3>
        <p>
            La planification précise des délais de réalisation est un élément clé pour le succès de votre projet
            de site internet. Dès la confirmation du cahier des charges, nous établirons une date de début et
            définirons les étapes clés qui jalonneront le développement du site, jusqu'à la date de lancement
            prévue. Cette planification rigoureuse nous permet de structurer le projet en phases distinctes,
            telles que la conception, le développement, les tests et la mise en ligne, en allouant à chacune un
            temps dédié pour son achèvement. L'objectif est de garantir une progression fluide et ordonnée du
            projet, en veillant à respecter les délais convenus tout en laissant la place nécessaire à une
            réalisation qualitative du site.
        </p>
        <p>
            Pour la gestion du projet, nous utilisons Jira, un outil de suivi de projet reconnu pour sa flexibilité
            et son efficacité. Jira nous permet de décomposer le projet en tâches et sous-tâches, assignées à
            différents membres de l'équipe selon leur expertise. Cet outil facilite également la communication
            et le suivi en temps réel de l'avancement du projet, offrant une transparence totale à toutes les
            parties impliquées. En tant que client, vous aurez un aperçu clair des différentes phases du projet,
            des échéances associées à chaque tâche et de l'état d'avancement global. Cette approche
            collaborative assure que vous restez informé et impliqué tout au long du processus de
            développement.
        </p>
        <p>
            Une fois le cahier de charge initial confirmé avec vous, nous élaborerons un calendrier de
            réalisation détaillé, incluant des réunions régulières pour discuter des avancements et ajuster le
            projet si nécessaire. Ces points de rencontre sont cruciaux pour maintenir une bonne
            communication entre vous et notre équipe, permettant d'apporter des modifications en temps réel
            et de s'assurer que le projet évolue conformément à vos attentes. Le calendrier spécifique sera
            conçu pour offrir une visibilité complète sur les différentes étapes du projet, renforçant ainsi notre
            engagement à livrer votre site internet dans les délais convenus, avec le niveau de qualité que
            vous êtes en droit d'attendre.
        </p>
        <p>
            La planification précise des délais de réalisation est un élément clé pour le succès de votre projet
            de site internet. Dès la confirmation du cahier des charges, nous établirons une date de début et
            définirons les étapes clés qui jalonneront le développement du site, jusqu'à la date de lancement
            prévue. Cette planification rigoureuse nous permet de structurer le projet en phases distinctes,
            telles que la conception, le développement, les tests et la mise en ligne, en allouant à chacune un
            temps dédié pour son achèvement. L'objectif est de garantir une progression fluide et ordonnée du
            projet, en veillant à respecter les délais convenus tout en laissant la place nécessaire à une
            réalisation qualitative du site.
        </p>
        <p>
            Pour la gestion du projet, nous utilisons Jira, un outil de suivi de projet reconnu pour sa flexibilité
            et son efficacité. Jira nous permet de décomposer le projet en tâches et sous-tâches, assignées à
            différents membres de l'équipe selon leur expertise. Cet outil facilite également la communication
            et le suivi en temps réel de l'avancement du projet, offrant une transparence totale à toutes les
            parties impliquées. En tant que client, vous aurez un aperçu clair des différentes phases du projet,
            des échéances associées à chaque tâche et de l'état d'avancement global. Cette approche
            collaborative assure que vous restez informé et impliqué tout au long du processus de
            développement.
        </p>
        <p>
            Une fois le cahier de charge initial confirmé avec vous, nous élaborerons un calendrier de
            réalisation détaillé, incluant des réunions régulières pour discuter des avancements et ajuster le
            projet si nécessaire. Ces points de rencontre sont cruciaux pour maintenir une bonne
            communication entre vous et notre équipe, permettant d'apporter des modifications en temps réel
            et de s'assurer que le projet évolue conformément à vos attentes. Le calendrier spécifique sera
            conçu pour offrir une visibilité complète sur les différentes étapes du projet, renforçant ainsi notre
            engagement à livrer votre site internet dans les délais convenus, avec le niveau de qualité que
            vous êtes en droit d'attendre.
        </p>
    </div>
    {{-- <div class="page-break">
        <h1 class="primary-color" style="text-align: center">Maintenance et Mises à Jour </h1>
        <h3 class="primary-color">1. Plateforme de développement </h3>
    </div> --}}
    {{-- <div class="page-break">
        <h1 class="primary-color" style="text-align: center">Maintenance et Mises à Jour </h1>
        <h3 class="primary-color">1. Plateforme de développement </h3>
    </div> --}}
</body>

</html>
