<html>

<head>
    <style>
        .btn {
            display: inline-block;
            font-weight: 400;
            color: #212529;
            text-align: center;
            vertical-align: middle;
            user-select: none;
            background-color: transparent;
            border: 1px solid transparent;
            padding: 0.375rem 0.75rem;
            font-size: 1rem;
            line-height: 1.5;
            border-radius: 0.25rem;
            transition: color 0.15s ease-in-out, background-color 0.15s ease-in-out, border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
            text-decoration: none;
        }

        .btn-primary {
            color: #fff;
            background-color: #7367f0;
            border-color: #7367f0;
        }

        .btn-primary:hover {
            color: #fff;
            background-color: #685dd8;
            border-color: #685dd8;
        }

        .btn-primary:focus,
        .btn-primary.focus {
            color: #fff;
            background-color: #685dd8;
            border-color: #685dd8;
            box-shadow: 0 0.125rem 0.25rem rgba(165, 163, 174, 0.3);
        }

        .btn-primary.disabled,
        .btn-primary:disabled {
            color: #fff;
            background-color: #7367f0;
            border-color: #7367f0;
        }
    </style>
</head>

<body>
    <p>{{ auth()->user()->name }}</p>
    <p>
        Nous sommes ravis de vous informer que votre cahier des charges est désormais élaboré et disponible sur notre
        plateforme. Vous pouvez le consulter dès à présent et le télécharger pour une revue détaillée.
    </p>
    <div style="display: flex; justify-content: center; align-items: center;">
        <a href="{{ url('/specifications') }}" class="btn btn-primary" style="color: white; margin: auto;">Accéder au document</a>
    </div>
    <p>
        Une copie du cahier des charges a également été jointe à ce mail pour votre commodité.
    </p>
    <p>
        Nous vous remercions pour votre confiance en MyCDC.fr et nous réjouissons de contribuer à la réussite de votre
        projet.
    </p>
    <p style="font-weight: bold;">
        L'équipe MyCDC.fr
    </p>
</body>

</html>