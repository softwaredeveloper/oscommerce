<?php
/*
  $Id: $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2007 osCommerce

  Released under the GNU General Public License
*/

  $osC_ObjectInfo = new osC_ObjectInfo(osC_Countries_Admin::getData($_GET['cID']));
?>

<h1><?php echo osc_link_object(osc_href_link_admin(FILENAME_DEFAULT, $osC_Template->getModule()), $osC_Template->getPageTitle()); ?></h1>

<?php
  if ($osC_MessageStack->size($osC_Template->getModule()) > 0) {
    echo $osC_MessageStack->output($osC_Template->getModule());
  }
?>

<div class="infoBoxHeading"><?php echo osc_icon('trash.png') . ' ' . $osC_ObjectInfo->get('countries_name'); ?></div>
<div class="infoBoxContent">
  <form name="cDelete" action="<?php echo osc_href_link_admin(FILENAME_DEFAULT, $osC_Template->getModule() . '&page=' . $_GET['page'] . '&cID=' . $osC_ObjectInfo->get('countries_id') . '&action=delete'); ?>" method="post">

<?php
  $can_be_deleted = true;

  $Qcheck = $osC_Database->query('select count(*) as total from :table_address_book where entry_country_id = :entry_country_id');
  $Qcheck->bindTable(':table_address_book', TABLE_ADDRESS_BOOK);
  $Qcheck->bindInt(':entry_country_id', $osC_ObjectInfo->get('countries_id'));
  $Qcheck->execute();

  if ( $Qcheck->valueInt('total') > 0 ) {
    $can_be_deleted = false;

    echo '    <p><b>' . sprintf($osC_Language->get('delete_warning_country_in_use_address_book'), $Qcheck->valueInt('total')) . '</b></p>' . "\n";
  }

  $Qcheck = $osC_Database->query('select count(*) as total from :table_zones_to_geo_zones where zone_country_id = :zone_country_id');
  $Qcheck->bindTable(':table_zones_to_geo_zones', TABLE_ZONES_TO_GEO_ZONES);
  $Qcheck->bindInt(':zone_country_id', $osC_ObjectInfo->get('countries_id'));
  $Qcheck->execute();

  if ( $Qcheck->valueInt('total') > 0 ) {
    $can_be_deleted = false;

    echo '<p><b>' . sprintf($osC_Language->get('delete_warning_country_in_use_tax_zone'), $Qcheck->valueInt('total')) . '</b></p>' . "\n";
  }

  if ( $can_be_deleted === true ) {
    $country_name = $osC_ObjectInfo->get('countries_name');

    if ( $osC_ObjectInfo->get('total_zones') > 0 ) {
      $country_name .= ' (' . sprintf($osC_Language->get('total_zones'), $osC_ObjectInfo->get('total_zones')) . ')';
    }

    echo '  <p>' . $osC_Language->get('introduction_delete_country') . '</p>' .
         '  <p><b>' . $country_name . '</b></p>' .
         '  <p align="center">' . osc_draw_hidden_field('subaction', 'confirm') . '<input type="submit" value="' . $osC_Language->get('button_delete') . '" class="operationButton" /> <input type="button" value="' . $osC_Language->get('button_cancel') . '" onclick="document.location.href=\'' . osc_href_link_admin(FILENAME_DEFAULT, $osC_Template->getModule() . '&page=' . $_GET['page']) . '\';" class="operationButton" /></p>';
  } else {
    echo '  <p align="center"><input type="button" value="' . $osC_Language->get('button_back') . '" onclick="document.location.href=\'' . osc_href_link_admin(FILENAME_DEFAULT, $osC_Template->getModule() . '&page=' . $_GET['page']) . '\';" class="operationButton" /></p>';
  }
?>

  </form>
</div>
