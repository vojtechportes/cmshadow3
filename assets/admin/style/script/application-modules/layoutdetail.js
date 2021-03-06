(function(){
	var remove = function () {
		var $elements = $('.slotDelete[data-api-load] [data-delete-confirm]');

		if ($elements.length > 0) {
			$elements.off('click.delete.confirm').on('click.delete.confirm', function(e){
				e.preventDefault();
				e.stopPropagation();

				var $this = $(this),
					$parent = $this.parents('[data-api-load]'),
					parentData = $.extend({}, $parent.data('api-load'));
					parentData['arguments'] = $.extend({}, parentData['arguments'], {'deleteConfirm': 1});

				APICommands.call($parent, parentData, true, false, function(){
					if (typeof parentData['arguments']['dependencies'] !== 'undefined') {
						$.each(parentData['arguments']['dependencies'], function(k, module){
							if (module === 'admin/form') {
								$(window).trigger('apiReload.' + module);
							} else {
								$(window).trigger('apiReloadForce.' + module);
							}
						});
					}				
				});
			});
		}
	}

	var update = function () {
		var parent = '.layoutSlots[data-api-load]',
			actions = {'edit': '[data-edit]', 'delete': '[data-delete]', 'add': '[data-add]'};

		if ($(parent).find(actions.delete).length > 0) {
			var $action = $(parent).find(actions.delete);
			
			$action.off('click.delete').on('click.delete', function(e){
				e.preventDefault();

				var $this = $(this),
					arguments = $this.data('arguments'),
					$parent = $($this.data('target')).find('[data-api-load]');

				console.log(arguments);

				if ($parent.length > 0) {
					var parentData = $.extend({}, $parent.data('api-load'));
						parentData['arguments'] = $.extend({}, parentData['arguments'], arguments);

					$parent.data('api-load', parentData);

					APICommands.call($parent, parentData, true);
				}
			});
		}

		if ($(parent).find(actions.edit).length > 0) {
			var $action = $(parent).find(actions.edit);

			$action.off('click.edit').on('click.edit', function(e){
				e.preventDefault();

				var $this = $(this),
					arguments = $this.data('arguments'),
					$parent = $($this.data('target')).find('[data-api-load]');

				if ($parent.length > 0) {
					var parentData = $.extend({}, $parent.data('api-load'));
						parentData['arguments'] = $.extend({}, parentData['arguments'], arguments);

					$parent.data('api-load', parentData);

					APICommands.call($parent, parentData, true);
				}
			});
		}


		if ($(parent).find(actions.add).length > 0) {
			var $action = $(parent).find(actions.add);

			$action.off('click.add').on('click.add', function(e){
				e.preventDefault();

				var $this = $(this),
					arguments = $this.data('arguments'),
					$parent = $($this.data('target')).find('[data-api-load]');

				if ($parent.length > 0) {
					var parentData = $.extend({}, $parent.data('api-load'));
						parentData['arguments'] = $.extend({}, parentData['arguments'], arguments);

					$parent.data('api-load', parentData);

					APICommands.call($parent, parentData, true);
				}
			});
		}
	}

	var reload = function () {
		var parent = '.layoutSlots[data-api-load]';
		$.each($(parent), function(k, el){
			var parentData = $('.layoutSlots' + parent).data('api-load');
			APICommands.call($(el), parentData, true);
		});		
	}

	$(document).ready(function(){
		update();
	});

	$(window).on('apiReload.admin/layout/slots', function(){
		update();
	});	

	$(window).on('apiReloadForce.admin/layout/slots', function(){
		reload();
	});

	$(window).on('apiReload.admin/layout/delete.slot', function(){
		remove();
	});
})();