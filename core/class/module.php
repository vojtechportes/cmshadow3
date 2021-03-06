<?php

Class Module Extends Minimal {

	public $templateOutput = DEFAULT_OUTPUT;
	public $template = false;	
	protected $module;
	protected $output = array();

	/*protected function __construct () {
		var_dump($this->output);
	}*/

	public function addModule (Module $Class, $output = array()) {
		$this->output = $output;
		$this->module = $Class;
		
		if ($this->module->output)
			$this->output = $this->output + $this->module->output;
		
		if (!empty($this->module->template))
			$this->template = $this->module->template;

		if (!empty($this->module->templateOutput))
			$this->templateOutput = $this->module->templateOutput;
	}

	public static function checkModuleRights ($module) {
		global $Rights;
		$ModuleRights = array();

		$Res = UserRights::getModuleRights($module);

		//var_dump($module);

		foreach ($Res as $MRight) {
			array_push($ModuleRights, $MRight["Group"]);
		}

		foreach ($Rights['Group'] as $Right) {
			if (in_array($Right, $ModuleRights)) {
				return true;
			}
		}

		return false;
	}	

	public function extendOutput($key, $value) {
		$this->output[$key] = $value;
	}

	public function output ($unescape = true) {
		global $Content;

		if ($this->template !== false) {
			if (array_key_exists("OutputStyle", $this->output))
				$this->templateOutput = $this->output["OutputStyle"];

			$path = DEFAULT_TEMPLATE_PATH.ADMIN_OUTPUT.'/'.$this->templateOutput.$this->template;

			ob_start();
			if (file_exists($path.'.tpl')) {
				parent::load($path, $this->output, true);
			} else {
				$Message = new Module();
				$Message->addModule(new Message(), array("html" => "{_'default_file_missing_error', sprintf($path)}", "class" => "alert-danger"));
				$Message->output();			
			}
			$html = ob_get_contents(); ob_end_clean();
			if ($unescape) {
				echo $html;
			} else {
				echo $html;
			}
		}
	}

}