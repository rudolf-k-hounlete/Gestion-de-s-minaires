@component('mail::message')
# Nouveau séminaire à l’IMSP

Un nouveau séminaire a été publié :

- **Thème :** {{ $seminar->theme }}  
- **Présentateur :** {{ $seminar->presenter->name }}  
- **Date :** {{ $seminar->scheduled_date->format('d/m/Y') }}  
- **Résumé :**  
{{ Str::limit(strip_tags(file_get_contents(public_path($seminar->summary_path))), 200, '...') }}

Pour consulter tous les détails, rendez-vous sur la plateforme :  
@component('mail::button', ['url' => route('seminars.student.index')])
Voir les séminaires publiés
@endcomponent

Merci,  
L’équipe scientifique de l’IMSP.  
@endcomponent
