<?php
App::uses('AppHelper', 'View/Helper');
class BreadcrumbHelper extends AppHelper {
    public $helpers = array('Html','Session');

    public function getLink($menu = NULL) {
        $mainMenus = $this->Session->read('Auth.User.Menus');
		$incVar = 1;$incVarChild=1;$url=NULL;
		foreach ($mainMenus['Menus'] as $mainMenu) {
			if($menu == 'Home') {
				if(empty($mainMenu['childMenu'])) {
					$url = $mainMenu['Aco']['url'];
				} else {
					foreach ($mainMenu['childMenu'] as $chileMenuUrlRedirect) {
						if($incVar == 1) {
							$url = $chileMenuUrlRedirect['Aco']['url'];
						}
						break;
					}
				}
				break;
			} else {
				if($mainMenu['Aco']['alias'] == $menu) {
					foreach ($mainMenu['childMenu'] as $childMenu) {
						if($incVarChild == 1) {
							$url = $childMenu['Aco']['url'];
							break;
						}
					}
				}
			}
			$incVar++;
		}
		return $url;
    }
}
?>