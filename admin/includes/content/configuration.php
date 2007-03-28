<?php
/*
  $Id: $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2007 osCommerce

  Released under the GNU General Public License
*/

  require('includes/classes/configuration.php');

  class osC_Content_Configuration extends osC_Template {

/* Private variables */

    var $_module = 'configuration',
        $_page_title,
        $_page_contents = 'main.php';

/* Class constructor */

    function osC_Content_Configuration() {
      global $osC_Language, $osC_MessageStack;

      $this->_page_title = $osC_Language->get('heading_title');

      if ( !isset($_GET['action']) ) {
        $_GET['action'] = '';
      }

      if ( !isset($_GET['gID']) || (isset($_GET['gID']) && !is_numeric($_GET['gID'])) ) {
        $_GET['gID'] = 1;
      }

      $this->_page_title .= ': ' . osC_Configuration_Admin::getGroupTitle($_GET['gID']);

      if ( !empty($_GET['action']) ) {
        switch ($_GET['action']) {
          case 'save':
            $this->_page_contents = 'edit.php';

            if ( isset($_POST['subaction']) && ($_POST['subaction'] == 'confirm') ) {
              if ( osC_Configuration_Admin::save($_GET['cID'], $_POST['configuration_value']) ) {
                $osC_MessageStack->add_session($this->_module, $osC_Language->get('ms_success_action_performed'), 'success');
              } else {
                $osC_MessageStack->add_session($this->_module, $osC_Language->get('ms_error_action_not_performed'), 'error');
              }

              osc_redirect_admin(osc_href_link_admin(FILENAME_DEFAULT, $this->_module . '&gID=' . $_GET['gID']));
            }

            break;
        }
      }
    }
  }
?>
