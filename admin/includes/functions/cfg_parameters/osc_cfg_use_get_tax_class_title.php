<?php
/*
  $Id: $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2007 osCommerce

  Released under the GNU General Public License
*/

  function osc_cfg_use_get_tax_class_title($id) {
    global $osC_Database, $osC_Language;

    if ($id < 1) {
      return $osC_Language->get('parameter_none');
    }

    $Qclass = $osC_Database->query('select tax_class_title from :table_tax_class where tax_class_id = :tax_class_id');
    $Qclass->bindTable(':table_tax_class', TABLE_TAX_CLASS);
    $Qclass->bindInt(':tax_class_id', $id);
    $Qclass->execute();

    return $Qclass->value('tax_class_title');
  }
?>
