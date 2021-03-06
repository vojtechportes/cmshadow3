<div class="page-list full">
  <div class="clearfix"></div>
  <table class="table">
    <thead>
      <tr>
        <th>{_'pages_page_list_th_title'}</th>
        <th>{_'pages_page_list_th_createdAt'}</th>
        <th>{_'pages_page_list_th_modifiedAt'}</th>
        <th>{_'pages_page_list_th_status'}</th>
        <th class="text-right">{_'pages_page_list_th_actions'}</th>

      </tr>
    </thead>
    <tbody>
   	<tr class="levelup <?php if (array_key_exists('from', $return)) { echo "clickable "; } ?>">
  		<td colspan="5" <?php if (array_key_exists('from', $return)) { ?> data-haschildpages data-arguments='{"parent": "<?php echo $return['from']; ?>"}' <?php } ?>>
  			<span class="glyphicon-alt glyphicon-alt-back glyphicon-larger"></span><span> {_'pages_page_list_level_up'}</span>
  		</td>
  	</tr>   
  <?php
  foreach ($return['pages'] as $id => $page) {
  	?>

  	<tr class="item <?php if ($page['numChildPages'] > 0) { echo "clickable "; } ?>">
  		<td <?php if ((int) $page['numChildPages'] > 0) { echo "data-haschildpages data-arguments='{\"parent\": \"{$page['ID']}\", \"from\": \"{$page['Parent']}\"}'"; } ?>><span style="padding-left: <?php echo $page['Depth'] * 20 ?>px; display: inline-block;"><span title="<?php echo $page['ID']; ?>" class="glyphicon-alt glyphicon-larger <?php if ((int) $page['numChildPages'] === 0) { echo 'glyphicon-alt-file'; } else { echo 'glyphicon-alt-folder-black'; } ?>"></span> <?php echo $page['Title'] ?></span></td>
  		<td><?php echo $page['CreatedAt'] ?></td>
  		<td><?php echo $page['ModifiedAt'] ?></td>
  		<td>
        <span class="glyphicon-alt glyphicon-larger glyphicon-alt-eye <?php if ((int) $page['Visible'] === 0) { echo ' not-visible'; } ?>"></span>
        <span class="glyphicon-alt glyphicon-larger glyphicon-alt-<?php if ((int) $page['Locked'] === 1) { echo 'lock'; } else { echo 'unlock'; } ?>"></span>

      </td>
  		<td class="text-right">
        <?php if ((int) $page['Locked'] === 0) { ?>
          <a href="#"  data-toggle="modal" data-target="#projectQuickEdit" data-arguments='{"pageId": "<?php echo $page['ID']; ?>", "pageName": "<?php echo $page['Title']; ?>"}' class="nolink" data-edit title="{_'pages_page_list_add_to_project'}"><span class="glyphicon-alt glyphicon-larger glyphicon-alt-plus"></span></a>
          <a href="#" class="nolink" data-delete title="{_'pages_page_list_delete_page'}"><span class="glyphicon-alt glyphicon-larger glyphicon-alt-cross"></span></a>
        <?php } ?>
        <a href="#" class="nolink" title="{_'pages_page_list_show_more_info'}"><span class="glyphicon-alt glyphicon-larger glyphicon-alt-selection-down"></span></a>
      </td>
    </tr>	
  	<?php

  }
  ?>
    </tbody>
  </table>
</div>