<?php

return array(
	'blog_tools' => "Blog - Herramientas extra",
	
	'blog_tools:toggle:feature' => "Destacar",
	'blog_tools:toggle:unfeature' => "No destacar",
	'blog_tools:readmore' => "Leer mas",
	
	// widget
	'blog_tools:widget:featured' => "¿Mostrar únicamente publicaciones destacadas?",
	
	// notifications
	'blog_tools:notify:publish:subject' => "Un publicación ha sido publicada",
	'blog_tools:notify:publish:message' => "Hola,

tu publicación'%s' ha sido publicada.

Puedes verla en el siguiente enlace:
%s",
	
	'blog_tools:notify:expire:subject' => "La publicación ha expirado",
	'blog_tools:notify:expire:message' => "Hola,

tu publicación'%s' ha expirado y ya no es visible para el resto de la comunidad.

Puedes verla en el siguiente enlace:
%s",
	
	// views
	'blog_tools:view:related' => "Publicaciones relacionadas",
		
		
	// blog edit
	'blog_tools:label:icon:exists' => "Subir nueva imagen destacada (dejar en blanco para mantener la actual)",
	'blog_tools:label:icon:new' => "Subir imagen destacada",
	'blog_tools:label:icon:remove' => "Eliminar imagen destacada",
	
	'blog_tools:label:show_owner' => "Mostrar información sobre ti al pie de la publicación",
	
	'blog_tools:label:publication_options' => "Opciones de publicación",
	'blog_tools:label:publication_date' => "Fecha de publicación (opcional)",
	'blog_tools:publication_date:description' => "Al indicar una fecha futura, la publicación no será públicada hasta ese día.",
	'blog_tools:label:expiration_date' => "Fecha de expiración (opcional)",
	'blog_tools:expiration_date:description' => "La publicación dejará de ser accesible luego de la fecha indicada.",

	// settings
	'blog_tools:settings:image' => "Configuración de imagenes del blog",
	'blog_tools:settings:other' => "Otras configuraciones",
	
	'blog_tools:settings:listing:image_align' => "Alineación de la imagen en el listado de publicaciones",
	'blog_tools:settings:listing:image_size' => "Tamaño de la imagen en el listado de publicaciones",
	
	'blog_tools:settings:full:image_align' => "Alineación de la imagen en la publicación completa",
	'blog_tools:settings:full:image_size' => "Tamaño de la imagen en la publicación completa",
	
	'blog_tools:settings:full' => "Configuración de la vista de la publicación completa",
	'blog_tools:settings:full:show_full_navigation' => "Mostrar links a publicaciones anteriores y siguientes",
	'blog_tools:settings:full:show_full_owner' => "Mostrar información del autor de la publicación",
	'blog_tools:settings:full:show_full_owner:optional' => "Opcional, cada autor decide",
	
	'blog_tools:settings:align:none' => "Sin imagen",
	
	'blog_tools:settings:size:tiny' => "Diminuta (16x16)",
	'blog_tools:settings:size:small' => "Pequeña (40x40)",
	'blog_tools:settings:size:medium' => "Mediana (100x100)",
	'blog_tools:settings:size:large' => "Grande (200x200)",
	'blog_tools:settings:size:master' => "Enorme (550x550)",
	
	'blog_tools:settings:listing:strapline' => "Mostrar línea de información en el listado",
	'blog_tools:settings:strapline:default' => "Por defecto (autor y tags)",
	'blog_tools:settings:strapline:time' => "Solo el tiempo de publicación",
	
	'blog_tools:settings:advanced_publication' => "Permitir opciones avanzadas de publicación",
	'blog_tools:settings:advanced_publication:description' => "Con esto los usuarios pueden elegeri una fecha de publicación futura y de expiración para cada publicación. Requiere configurar correctamente CRON.",
	
	// actions
	'blog_tools:action:toggle_metadata:error' => "Un error desconocido ha ocurrido al editar la publicación, por favor intentelo de nuevo.",
	'blog_tools:action:toggle_metadata:success' => "La publicación se editó correctamente.",
	
	'blog_tools:action:save:error:expiration_date' => "La fecha de expiración no puede ser anterior a la fecha de hoy",
	
	// widget
	'blog_tools:widgets:index_blog:description' => "Muestra las últimas publicaciones en tu sitio",
	
	'blog_tools:widgets:index_blog:view_mode' => "Cómo mostrar las publicaciones",
	'blog_tools:widgets:index_blog:view_mode:list' => "Lista",
	'blog_tools:widgets:index_blog:view_mode:preview' => "Vista previa",
	'blog_tools:widgets:index_blog:view_mode:slider' => "Slider",
	'blog_tools:widgets:index_blog:view_mode:simple' => "Simple",
	
	// upgrades
	'admin:upgrades:blog_tools_move_icons' => "Mover las imagenes destacadas de las publicaciones",
	'admin:upgrades:blog_tools_move_icons:description' => "Las imagenes destacadas de las publicaciones deben ser almacenadas en una nueva ubicación, esta actualización moverá todas las existentes a la nueva ubicación. Si no hay imagenes destacadas definidas, ejecuta esta actualización y ellas volverán (?)",
);
