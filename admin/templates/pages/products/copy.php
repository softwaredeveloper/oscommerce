<?php
/*
  $Id: $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2007 osCommerce

  Released under the GNU General Public License
*/

  $osC_ObjectInfo = new osC_ObjectInfo(osC_Products_Admin::getData($_GET['pID']));

  $in_categories = array();

  $Qcategories = $osC_Database->query('select categories_id from :table_products_to_categories where products_id = :products_id');
  $Qcategories->bindTable(':table_products_to_categories', TABLE_PRODUCTS_TO_CATEGORIES);
  $Qcategories->bindInt(':products_id', $osC_ObjectInfo->get('products_id'));
  $Qcategories->execute();

  while ($Qcategories->next()) {
    $in_categories[] = $Qcategories->valueInt('categories_id');
  }

  $in_categories_path = '';

  foreach ($in_categories as $category_id) {
    $in_categories_path .= $osC_CategoryTree->getPath($category_id, 0, ' &raquo; ') . '<br />';
  }

  if ( !empty($in_categories_path) ) {
    $in_categories_path = substr($in_categories_path, 0, -6);
  }

  $categories_array = array(array('id' => '0',
                                  'text' => $osC_Language->get('top_category')));

  foreach ($osC_CategoryTree->getTree() as $value) {
    $categories_array[] = array('id' => $value['id'],
                                'text' => $value['title']);
  }
?>

<h1><?php echo osc_link_object(osc_href_link_admin(FILENAME_DEFAULT, $osC_Template->getModule()), $osC_Template->getPageTitle()); ?></h1>

<?php
  if ($osC_MessageStack->size($osC_Template->getModule()) > 0) {
    echo $osC_MessageStack->output($osC_Template->getModule());
  }
?>

<div class="infoBoxHeading"><?php echo osc_icon('copy.png') . ' ' . $osC_ObjectInfo->get('products_name'); ?></div>
<div class="infoBoxContent">
  <form name="pCopy" action="<?php echo osc_href_link_admin(FILENAME_DEFAULT, $osC_Template->getModule() . '&page=' . $_GET['page'] . '&cPath=' . $_GET['cPath'] . '&search=' . $_GET['search'] . '&pID=' . $osC_ObjectInfo->get('products_id') . '&action=copy'); ?>" method="post">

  <p><?php echo $osC_Language->get('introduction_copy_product'); ?></p>

  <p><?php echo '<b>' . $osC_Language->get('field_current_categories') . '</b><br />' . $in_categories_path; ?></p>

  <p><?php echo '<b>' . $osC_Language->get('field_categories') . '</b><br />' . osc_draw_pull_down_menu('new_category_id', $categories_array); ?></p>

  <p><?php echo '<b>' . $osC_Language->get('field_copy_method') . '</b><br />' . osc_draw_radio_field('copy_as', array(array('id' => 'link', 'text' => $osC_Language->get('copy_method_link')), array('id' => 'duplicate', 'text' => $osC_Language->get('copy_method_duplicate'))), 'link', null, '<br />'); ?></p>

  <p align="center"><?php echo osc_draw_hidden_field('subaction', 'confirm') . '<input type="submit" value="' . $osC_Language->get('button_copy') . '" class="operationButton" /> <input type="button" value="' . $osC_Language->get('button_cancel') . '" onclick="document.location.href=\'' . osc_href_link_admin(FILENAME_DEFAULT, $osC_Template->getModule() . '&page=' . $_GET['page'] . '&cPath=' . $_GET['cPath'] . '&search=' . $_GET['search']) . '\';" class="operationButton" />'; ?></p>

  </form>
</div>
