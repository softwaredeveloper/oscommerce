<?php
/*
  $Id: $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2007 osCommerce

  Released under the GNU General Public License
*/

  class osC_Access_Currencies extends osC_Access {
    var $_module = 'currencies',
        $_group = 'configuration',
        $_icon = 'currencies.png',
        $_title,
        $_sort_order = 500;

    function osC_Access_Currencies() {
      global $osC_Language;

      $this->_title = $osC_Language->get('access_currencies_title');
    }
  }
?>
