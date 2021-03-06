<?php

$Template = array(
	"default" => array(
		"Output" => "admin/default-html/default",
		"Slots" => array("main"),
		"Scripts" => array(
			"assets/admin/style/script/require.js",
			"assets/admin/style/script/main.js",
			array("assets/admin/style/script/application-modules/form.js")
		),
		"Styles" => array(
			"assets/admin/style/css/bootstrap.css"
		),
		"Stringtables" => array(
			"stringtable_default",
			"stringtable_pages",
			"stringtable_projects",	
			"stringtable_layouts",	
			"stringtable_templates",	
			"stringtable_navigations",		
			"stringtable_forms",
			"stringtable_settings",
			"stringtable_gadgets"
		),
		"Content" => array(
			"header" => array(
				array(
					"module" => "admin/navigation/show",
					"name" => "RightNavigation",
					"search" => true,
					"brand" => array(
						"image" => false,
						"text" => "{_'default_cms_name'}",
						"href" => "/admin/"
					)
				)
			),
			"breadcrumbs" => array(
				array("module" => "admin/page/api/breadcrumbs.loader", "weight" => 1)
			)
		)
	),
	"login" => array(
		"Output" => "admin/default-html/login",
		"Slots" => array("main"),
		"Scripts" => array(
			"assets/admin/style/script/require.js",
			"assets/admin/style/script/main.js"
		),
		"Styles" => array(
			"assets/admin/style/css/bootstrap.css"
		),
		"Stringtables" => array(
			"stringtable_default",
			"stringtable_forms"
		),
		"Content" => array(
			"main" => array(
				array("module" => "auth/login")
			)
		)
	),
	"error-404" => array(
		"Output" => "admin/default-html/default",
		"Slots" => array("main"),
		"Scripts" => array(
			"assets/admin/style/script/require.js",
			"assets/admin/style/script/main.js"
		),
		"Styles" => array(
			"assets/admin/style/css/bootstrap.css"
		),
		"Stringtables" => array(
			"stringtable_default",
			"stringtable_pages",
			"stringtable_navigations"
		),
		"Content" => array(
			"header" => array(
				array(
					"module" => "admin/navigation/show",
					"name" => "RightNavigation",
					"search" => true,
					"brand" => array(
						"image" => false,
						"text" => "{_'default_cms_name'}",
						"href" => "/admin/"
					)
				)
			),
			"breadcrumbs" => array(
				array("module" => "admin/page/api/breadcrumbs.loader", "weight" => 1)
			),			
			"main" => array(
				array("module" => "message/show", "html" => "{_'default_node_404_error'}", "class" => "alert-danger")
			)
		)
	),
	"error" => array(
		"Output" => "admin/default-html/error",
		"Slots" => array("main"),
		"Scripts" => array(
			"assets/admin/style/script/require.js",
			"assets/admin/style/script/main.js"
		),
		"Styles" => array(
			"assets/admin/style/css/bootstrap.css"
		),
		"Stringtables" => array(
			"stringtable_default"
		),
		"ErrorOverride" => true,	
		"Content" => array(
			"main" => array(
				array("module" => "message/show", "html" => "{_'default_node_right_error'}", "class" => "alert-danger")
			)
		)
	),
	"error-json" => array(
		"Output" => "admin/default-json/json",
		"OutputStyle" => "default-json",
		"OutputType" => "JSON",
		"Slots" => array("main"),
		"ErrorOverride" => true,
		"Stringtables" => array(
			"stringtable_default"
		),
		"Content" => array(
			"main" => array(
				array("module" => "message/show", "html" => "{_'default_node_right_error'}", "class" => "alert-danger")
			)
		)
	),	
	"api" => array(
		"Output" => "admin/default-json/json",
		"OutputStyle" => "default-json",
		"OutputType" => "JSON",
		"Stringtables" => array(
			"stringtable_default",
			"stringtable_pages",	
			"stringtable_projects",	
			"stringtable_layouts",	
			"stringtable_templates",
			"stringtable_navigations",		
			"stringtable_forms",
			"stringtable_settings",
			"stringtable_gadgets",			
			"stringtable_api"
		),
		"Slots" => array("main"),
		"Content" => array()
	)			
)


?>