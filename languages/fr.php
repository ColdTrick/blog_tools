<?php

return array(
	'blog_tools' => "Outils pour les articles de blogs",
	
	'blog_tools:toggle:feature' => "Sélectionner",
	'blog_tools:toggle:unfeature' => "Dé-sélectionner",
	'blog_tools:readmore' => "lire la suite",
	
	// menu
	'blog_tools:menu:filter:featured' => "Sélectionnés",
		
	// widget
	'blog_tools:widget:featured' => "Montrer les articles sélectionnés uniquement ?",
	
	// notifications
	'blog_tools:notify:publish:subject' => "Un article a été publié",
	'blog_tools:notify:publish:message' => "Bonjour,
	
Votre article \"%s\" a bien été publié.

Vous pouvez lire votre article ici :
%s",
	
	'blog_tools:notify:expire:subject' => "Un article a été dépublié",
	'blog_tools:notify:expire:message' => "Bonjour,
	
votre article \"%s\" a été dépublié et n'est donc plus visible.

Vous pouvez cependant y accéder ici :
%s",
	
	// views
	'blog_tools:view:related' => "Articles connexes",
		
		
	// blog edit
	'blog_tools:label:icon:exists' => "Sélectionnez une image (ne rien sélectionner pour garder l'image actuelle)",
	'blog_tools:label:icon:new' => "Charger une image",
	'blog_tools:label:icon:remove' => "Supprimer l'image",
	
	'blog_tools:label:show_owner' => "Afficher vos informations personnelles en dessous l'article",
	
	'blog_tools:label:publication_options' => "Options de publication",
	'blog_tools:label:publication_date' => "Date de publication (optionnel)",
	'blog_tools:publication_date:description' => "Pour planifier la publication, choisissez une date à venir.",
	'blog_tools:label:expiration_date' => "Date d'expiration (optionnel)",
	'blog_tools:expiration_date:description' => "Votre article sera dépublié, si vous le souhaitez, à la date choisie.",

	// settings
	'blog_tools:settings:image' => "Paramètre de l'image de l'article",
	'blog_tools:settings:other' => "Autres paramètres",
	
	'blog_tools:settings:listing:image_align' => "Alignement de l'image dans un listing",
	'blog_tools:settings:listing:image_size' => "Taille de l'image dans un listing",
	
	'blog_tools:settings:full:image_align' => "Alignement de l'image en affichage pleine page",
	'blog_tools:settings:full:image_size' => "Taille de l'image en affichage pleine page",
	
	'blog_tools:settings:full' => "Paramètres en affichage pleine page",
	'blog_tools:settings:full:show_full_navigation' => "Précédent/suivant",
	'blog_tools:settings:full:show_full_owner' => "Afficher les informations relatives à l'auteur en dessous de l'article",
	'blog_tools:settings:full:show_full_owner:optional' => "Optionnel, selon le choix de l'auteur de l'article",
	'blog_tools:settings:full:show_full_related' => "Afficher les articles connexes",
	'blog_tools:settings:full:show_full_related:full_view' => "Après l'article",
	'blog_tools:settings:full:show_full_related:sidebar' => "Dans la barre latérale",
	
	'blog_tools:settings:align:none' => "Pas d'image",
	'blog_tools:settings:align:left' => "Gauche",
	'blog_tools:settings:align:right' => "Droit",
	
	'blog_tools:settings:size:tiny' => "Très petit (16x16)",
	'blog_tools:settings:size:small' => "Petit (40x40)",
	'blog_tools:settings:size:medium' => "Moyen (100x100)",
	'blog_tools:settings:size:large' => "Large (200x200)",
	'blog_tools:settings:size:master' => "Taille originale (550x550)",
	
	'blog_tools:settings:listing:strapline' => "Afficher une ligne d'informations dans les listings",
	'blog_tools:settings:strapline:default' => "Par défaut (auteur et tags)",
	'blog_tools:settings:strapline:time' => "Date seulement",
	
	'blog_tools:settings:advanced_gatekeeper' => "Utiliser le gestionnaire d'accès avancé des blogs",
	'blog_tools:settings:advanced_gatekeeper:description' => "Cette option permet aux membres non connectés de mieux trouver leur chemin vers un blog en accès restrainet",
	
	'blog_tools:settings:advanced_publication' => "Activer les options de publication avancée",
	'blog_tools:settings:advanced_publication:description' => "Cette option permet aux membres de choisir une date de publication et d'expiration pour leurs articles. Nécessite un CRON quotidien valide.",
	
	// actions
	'blog_tools:action:toggle_metadata:error' => "Une erreur est survenue pendant votre édition, merci de recommencer",
	'blog_tools:action:toggle_metadata:success' => "Le contenu a bien été publié",
	
	'blog_tools:action:save:error:expiration_date' => "La date de dépublication de l'article doit être postérieure à la date de publication",
	
	// widget
	'blog_tools:widgets:index_blog:description' => "Afficher les derniers articles de votre communauté",
	
	'blog_tools:widgets:index_blog:view_mode' => "Comment afficher les articles",
	'blog_tools:widgets:index_blog:view_mode:list' => "Liste",
	'blog_tools:widgets:index_blog:view_mode:preview' => "Aperçu",
	'blog_tools:widgets:index_blog:view_mode:slider' => "Diaporama",
	'blog_tools:widgets:index_blog:view_mode:simple' => "Simple",
);
