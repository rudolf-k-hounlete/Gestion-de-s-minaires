@component('mail::message')
# Bonjour {{ $seminar->presenter->name }},

Votre demande de présentation de séminaire sur le thème **"{{ $seminar->theme }}"** a été acceptée.

La date retenue est **{{ $seminar->scheduled_date->format('d/m/Y') }}**.

Dix jours avant cette date, vous pourrez téléverser le résumé de votre présentation sur la plateforme.

Merci de votre participation,

L’équipe scientifique de l’IMSP.  
@endcomponent
