<div class="modal fade" id="layoutDelete" tabindex="-1">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="{_'default_modal_close'}"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title">{_'layouts_layout_delete'}</h4>
      		</div>
			<div class="layoutDelete" data-api-prevent data-api-load='{"command": "loadModule", "message": false, "module": "admin/layout/delete", "arguments": <?php echo json_encode($return); ?>}'></div>
		</div>
	</div>
</div>