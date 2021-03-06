<?php
global $M, $Path;

if ((int) $M->_POST('form_open') === 1) {
	$return = concat_property('class', ' in', $return);
}

$message = true;
if (array_key_exists('message', $return)) {
	if (! (bool) $return['arguments']['message'])
		$message = false;
}

$id = false;
$canDisplay = true;
$projectExist = true;
$type = 'create';

if (array_key_exists('type', $return)) {
	if ($return['type'] === 'edit') {
		$type = 'edit';
		$return = concat_property('class', ' in', $return);
		$id = $M->extractID($return['Path']);
		if ($id) {
			$_Project = new Project();
			$Project = $_Project->getProjectByID($id);
			
			if (empty($Project) || (int) $Project['HasRights'] === 0) {
				if (empty($Project))
					$projectExist = false;
				$canDisplay = false;
			} else {
				$OwnerValues = $_Project->getProjectOwners($Project['ID'], 1);
				$OwnerValues = flatten_array($OwnerValues);
				$EditorValues = $_Project->getProjectOwners($Project['ID'], 2);
				$EditorValues = flatten_array($EditorValues);

				$Pages = new Page();
				$Pages->version = $Project['ID'];
				$Pages->getPageTree(false, 0);
				$PageTree = $Page->pagetTree;
				$PageValues = array();
				if (count($PageTree) > 0) {
					foreach ($PageTree as $page) {
						array_push($PageValues, $page['ID']);
					}
				}
			}
		}
	}
}

if ($canDisplay) {
	$Code = new Module();
	$Code->template = '/code';
	$Code->addModule(false, array("html" => '<div class="form-wrapper '.print_property('class', $return, false, true).'"><div class="clearfix"></div>'));
	$Code->output();

	if ($message) {
		$Message = new Module();
		$Message->addModule(new Message(), array("html" => "{_'forms_project_form_help'}", "class" => "alert-info", "OutputStyle" => $return["OutputStyle"], "OutputType" => $return["OutputType"], "Header" => 200));
		$Message->output();
	}

	$Users = new UserList();
	$UserList = $Users->getUsers(array(4, 3));
	$_userlist = array();
	if (count($UserList) > 0) {
		foreach ($UserList as $user) {
			$_userlist[$user['ID']] = $user['Name'];
		}
	}

	$Pages = new Page();
	$Pages->getPageTree(false, 0);
	$PageList = $Pages->pageTree;
	$_pagelist = array();
	$PageDisabledValues = array();

	if (count($PageList) > 0) {
		foreach ($PageList as $page) {
			$_pagelist[$page['ID']] = str_repeat('&nbsp;&nbsp;&nbsp;', $page['Depth']).$page['Title'];
			if ((int) $page['Locked'] === 1) {
				array_push($PageDisabledValues, $page['ID']);
			}
		}
	}

	$form = new Form ('form_project');
	$form->method = 'POST';
	$form->type = 'rows';
	$form->template = '/admin/project/form';
	$form->classInput = 'form-control';

	if ($type === 'create') {
		$form->addElement(new FormElement_Text("{_'forms_project_name'}", "name", array("required" => true)));
		$form->addElement(new FormElement_Text("{_'forms_project_release_date'}", "release_date", array("required" => true)));
		$form->addElement(new FormElement_Textarea("{_'forms_project_description'}", "description", array("required" => false, "styleInput" => "height: 395px;")));	
		$form->addElement(new FormElement_Select("{_'forms_project_owners'}", "owners[]", array("required" => true, "multiple" => true, "options" => $_userlist)));
		$form->addElement(new FormElement_Select("{_'forms_project_editors'}", "editors[]", array("required" => false, "multiple" => true, "options" => $_userlist)));
		$form->addElement(new FormElement_Select("{_'forms_project_pages'}", "pages[]", array("required" => false, "multiple" => true, "options" => $_pagelist, "disabled" => $PageDisabledValues)));			
		$form->addElement(new FormElement_Submit(false, "submit_project", array("value" => "{_'forms_project_submit'}", "classInput" => "btn btn-block btn-primary")));
	} else {
		$form->addElement(new FormElement_Text("{_'forms_project_name'}", "name", array("required" => true, "value" => $Project['Name'])));
		$form->addElement(new FormElement_Text("{_'forms_project_release_date'}", "release_date", array("required" => true, "value" => $Project['ReleaseDate'])));
		$form->addElement(new FormElement_Textarea("{_'forms_project_description'}", "description", array("required" => true, "value" => $Project['Description'], "styleInput" => "height: 395px;")));	
		$form->addElement(new FormElement_Select("{_'forms_project_owners'}", "owners[]", array("required" => true, "multiple" => true, "options" => $_userlist, "selected" => $OwnerValues)));		
		$form->addElement(new FormElement_Select("{_'forms_project_editors'}", "editors[]", array("required" => false, "multiple" => true, "options" => $_userlist, "selected" => $EditorValues)));
		$form->addElement(new FormElement_Select("{_'forms_project_pages'}", "pages[]", array("required" => false, "multiple" => true, "options" => $_pagelist, "selected" => $PageValues, "disabled" => $PageDisabledValues)));			
		$form->addElement(new FormElement_Submit(false, "submit_project", array("value" => "{_'forms_project_submit_edit'}", "classInput" => "btn btn-block btn-primary")));			
	}



	$Output = $form->output($return);

	if ($Output) {
		$Project = new Project();

		/* Project */

		if ($type === 'edit')
			$Project->id = $id;

		$Project->name = filter_input(INPUT_POST, "name");
		$Project->description = filter_input(INPUT_POST, "description");
		$Project->relese_date = filter_input(INPUT_POST, "release_date");

		/* Project Owners */
		$Project->owners = filter_input(INPUT_POST, "owners", FILTER_SANITIZE_STRING, FILTER_REQUIRE_ARRAY);
		$Project->editors = filter_input(INPUT_POST, "editors", FILTER_SANITIZE_STRING, FILTER_REQUIRE_ARRAY);	

		/* Pages */
		$Pages = filter_input(INPUT_POST, "pages", FILTER_SANITIZE_STRING, FILTER_REQUIRE_ARRAY);				

		$Page = new Page();
		$Page->version = 0;
		$PagesFailed = array();

		switch ($type) {
			case 'create':
				if ($Project->createProject() && $Project->setProjectOwners()) {
					if (!empty($Pages)) {
						foreach ($Pages as $page) {
							$page = (int) $page;
							if (!$Page->isLocked($page)) {
								$Page->lockPage($page);
								$Page->clonePage($page, $Project->status);
							} else {
								array_push($PagesFailed, $page);
							}
						}
					}

					if (empty($PagesFailed)) {
						$message = "{_'forms_project_form_created', sprintf([\"{$Project->name}\", \"/admin/projects/edit/{$Project->getCurrentProjectID()}\", \"#\"])}";
					} else {
						$message = "{_'forms_project_form_created_exception', sprintf([\"{$Project->name}\", \"/admin/projects/edit/{$Project->getCurrentProjectID()}\", \"#\", \"".implode(', ', $PagesFailed)."\"])}";
					}
					$Message = new Module();
					$Message->addModule(new Message(), array("html" => $message, "class" => "alert-success", "OutputStyle" => $return["OutputStyle"], "OutputType" => $return["OutputType"], "Header" => 200));
					$Message->output();	
				} else {
					$Message = new Module();
					$Message->addModule(new Message(), array("html" => "{_'forms_project_form_error', sprintf([\"{$Project->name}\", \"#\"])}", "class" => "alert-danger", "OutputStyle" => $return["OutputStyle"], "OutputType" => $return["OutputType"], "Header" => 200));
					$Message->output();	
				}
				break;
			case 'edit':
				if ($Project->updateProject() && $Project->setProjectOwners(true)) {
					if (!empty($Pages)) {
						foreach ($Pages as $page) {
							$page = (int) $page;
							if (!$Page->isLocked($page)) {
								$Page->lockPage($page);
								$Page->clonePage($page, $Project->id);
							} else {
								array_push($PagesFailed, $page);
							}
						}
					}

					if (empty($PagesFailed)) {
						$message = "{_'forms_project_form_updated', sprintf([\"{$Project->name}\", \"#\"])}";
					} else {
						$message = "{_'forms_project_form_updated_exception', sprintf([\"{$Project->name}\", \"#\", \"".implode(', ', $PagesFailed)."\"])}";
					}

					$Message = new Module();
					$Message->addModule(new Message(), array("html" => $message, "class" => "alert-success", "OutputStyle" => $return["OutputStyle"], "OutputType" => $return["OutputType"], "Header" => 200));
					$Message->output();
				} else {
					$Message = new Module();
					$Message->addModule(new Message(), array("html" => "{_'forms_project_form_update_error', sprintf([\"{$Project->name}\", \"#\"])}", "class" => "alert-danger", "OutputStyle" => $return["OutputStyle"], "OutputType" => $return["OutputType"], "Header" => 200));
					$Message->output();	
				}
				break;
		}
	}

	$Code = new Module();
	$Code->template = '/code';
	$Code->addModule(false, array("html" => '<div class="clearfix"></div></div>'));
	$Code->output();
} else {
	if ($projectExist) { $msg = "{_'forms_project_form_cant_modify'}"; } else { $msg = "{_'forms_project_form_doesnt_exist'}"; }
	$Message = new Module();
	$Message->addModule(new Message(), array("html" => $msg, "class" => "alert-danger", "OutputStyle" => $return["OutputStyle"], "OutputType" => $return["OutputType"], "Header" => 200));
	$Message->output();			
}
?>