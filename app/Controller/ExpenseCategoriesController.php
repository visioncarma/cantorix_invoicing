<?php 
App::uses('AppController','Controller');

Class ExpenseCategoriesController extends AppController {

	/**
	 * @property AcpexpenseCategory $AcpexpenseCategory
	 * @property PaginatorComponent $Paginator
	 * @property SessionComponent $Session
	 * @author Ganesh 
	 * */
	public $uses 		= array('AcpExpenseCategory');
	public $component 	= array('Security','Pagination'); 
	
	public function beforeFilter(){
		parent::beforeFilter();
		$this->layout = "sbs_layout";
		$this->permission = $this->Session->read('Auth.AllPermissions.Expense Categories');
		$this->subscriber = $this->Session->read('Auth.User.SbsSubscriber.id');
		$expensesActive = 'active';
		$this->set(compact('expensesActive'));
	}
	
	public function index($categoryName = 0) {
		$permission = $this->permission;
		if($this->permission['_read'] != 1) {
			$this->redirect(array('controller'=>'users','action'=>'noaccess'));
		}
		$menuActive = 'Expense Categories';
		$this->set(compact('menuActive','permission'));
		$this->loadModel('SbsSubscriberSetting');
		$title_for_layout = 'Expense Categories';
		$settings 		= $this->SbsSubscriberSetting->defaultSettings($this->subscriber);
		$limit 			= $settings['SbsSubscriberSetting']['lines_per_page'];
		$conditions 	= array('sbs_subscriber_id'=>$this->subscriber);
		/**Filter Section*/
		if($categoryName) {
			$this->request->data['Filter']['category_name'] = $categoryName;
		}
		if(!empty($this->data['Filter'])) {
			if(!empty($this->request->data['Filter']['category_name'])) {
				$categoryName = trim($this->request->data['Filter']['category_name']);
			}
			$conditions = array('AcpExpenseCategory.sbs_subscriber_id' => $this->subscriber,'AcpExpenseCategory.category_name LIKE' => '%'.$categoryName.'%');
		}	
		/**End Filter Section*/
		$fields = array('AcpExpenseCategory.id','AcpExpenseCategory.category_name','AcpExpenseCategory.description');
		$this->Paginator->settings = array(
		         'fields'=>$fields,
				'conditions'=>$conditions,
				'limit' => $limit,
				'order'=>array('AcpExpenseCategory.category_name' => 'Asc'));
		$expenseCategories = $this->Paginator->paginate('AcpExpenseCategory');
        if(!empty($this->data['AcpExpenseCategory'])) {
			if(empty($this->data['AcpExpenseCategory']['category_name'])) {
				$this->Session->setFlash('<div class="alert alert-danger">Error occurred. Category name cannot be empty.</div>');
				return;
			}
			$this->request->data['AcpExpenseCategory']['sbs_subscriber_id'] = $this->subscriber;
			if($this->AcpExpenseCategory->save($this->data)) {
				$this->Session->setFlash('<div class="alert alert-block alert-success">Expense category has been created.</div>');
			} else {
				$this->Session->setFlash('<div class="alert alert-danger">Error occurred. Couldn\'t create expense category.</div>');
			}
			$this->redirect(array('action'=>'index'));
		}
		$this->set(compact('expenseCategories','title_for_layout','categoryName','permission'));
	}
	
	public function view($id = NULL,$categoryName = 0,$page = 1) {
		$permission = $this->permission;
		if($this->permission['_read'] != 1) {
			$this->redirect(array('controller'=>'users','action'=>'noaccess'));
		}
		$this->AcpExpenseCategory->id = $id;
	 	if (!$this->AcpExpenseCategory->exists()) {
            throw new NotFoundException(__('Invalid category'));
        }
		if(!$this->AcpExpenseCategory->_checkFraud($id)) {
			$this->redirect(array('controller'=>'users','action'=>'accessDenied'));
		}
		$this->set('category',$this->AcpExpenseCategory->findById($id));
	}
	
	public function edit($id = NULL,$categoryName = 0,$page = 1) {
		$permission = $this->permission;
		if($this->permission['_update'] != 1) {
			$this->redirect(array('controller'=>'users','action'=>'noaccess'));
		}
		if(!$this->AcpExpenseCategory->_checkFraud($id)) {
			$this->redirect(array('controller'=>'users','action'=>'accessDenied'));
		}
		$this->AcpExpenseCategory->id = $id;
		if (!$this->AcpExpenseCategory->exists()) {
			throw new NotFoundException(__('Invalid category'));
		}
		if(!$this->AcpExpenseCategory->_checkFraud($id)) {
			$this->redirect(array('controller'=>'users','action'=>'accessDenied'));
		}
		$this->set('category',$this->AcpExpenseCategory->read());
        $this->set(compact('categoryName','page'));
		if (!empty($this->data)) {
			if($this->AcpExpenseCategory->save($this->data)) {
				$this->Session->setFlash('<div class="alert alert-block alert-success">Expense category has been updated.</div>');
			} else {
				$this->Session->setFlash('<div class="alert alert-danger">Internal error occurred. Please try again later.</div>');
			}
			$this->redirect(array('action'=>'index',$categoryName,'page:'.$page));
		}
	}
	
	public function delete($id = NULL,$categoryName = 0,$page = 1) {
		$permission = $this->permission;
		if($this->permission['_delete'] != 1) {
			$this->redirect(array('controller'=>'users','action'=>'noaccess'));
		}
		$this->AcpExpenseCategory->id = $id;
	 	if (!$this->AcpExpenseCategory->exists()) {
            throw new NotFoundException(__('Invalid category'));
        }
		if(!$this->AcpExpenseCategory->_checkFraud($id)) {
			$this->redirect(array('controller'=>'users','action'=>'accessDenied'));
		}
		$this->loadModel('AcpExpense');
		$expenseExist = $this->AcpExpense->find('first',array('conditions'=>array('AcpExpense.acp_expense_category_id'=>$id),'fields'=>array('AcpExpense.id')));
		if(!empty($expenseExist)) {
			$this->Session->setFlash('<div class="alert alert-danger">Error occurred. This expense category has been used in expenses. Couldn\'t delete expense category.</div>');
		} else {
			if($this->AcpExpenseCategory->delete()) {
				$this->Session->setFlash('<div class="alert alert-block alert-success">Expense category has been deleted.</div>');
			} else {
				$this->Session->setFlash('<div class="alert alert-danger">Internal error occurred. Please try again later.</div>');
			}
		}
		$this->redirect(array('action'=>'index',$categoryName,'page:'.$page));
	}

	public function deleteAll() {
		if(!empty($this->data['ExpenseCategory']['Delete'])) {
			$count = 0;
			foreach($this->data['ExpenseCategory']['Delete'] as $categoryID => $delete) {
				if($delete) {
					$deletionIDS[$categoryID] = $categoryID;
				}
			}
			$this->loadModel('AcpExpense');
			$DeleteIDS = $this->AcpExpenseCategory->find('list',array(
				'conditions'=>array('AcpExpenseCategory.id'=>$deletionIDS,'AcpExpenseCategory.sbs_subscriber_id'=>$this->subscriber)
			));
			$expenseIDS = $this->AcpExpense->find('list',array(
				'fields' => array('AcpExpense.acp_expense_category_id','AcpExpense.acp_expense_category_id'),
				'conditions'=>array('AcpExpense.acp_expense_category_id'=>$deletionIDS,'AcpExpense.sbs_subscriber_id'=>$this->subscriber)
			));
			$finalIDS = array_diff_key($DeleteIDS,$expenseIDS);
			$count = count($finalIDS);
			if($count >= 1) {
				$this->AcpExpenseCategory->deleteAll(array('AcpExpenseCategory.id'=> $finalIDS), FALSE);
				if($count == 1) {
					$this->Session->setFlash('<div class="alert alert-block alert-success">1 Expense category has been deleted.</div>');
				} else {
					$this->Session->setFlash('<div class="alert alert-block alert-success">'.$count.' Expense categories has been deleted.</div>');
				}
			} else {
				$this->Session->setFlash('<div class="alert alert-danger">Internal error occurred. Please try again later.</div>');
			}
		} else {
			$this->Session->setFlash('<div class="alert alert-danger">Please select atlease any one category to delete.</div>');
		}
		$this->redirect(array('action'=>'index'));
	}


	public function validateCategory($id = NULL) {
		$this->autoRender = FALSE;
		$name = trim($this->data['AcpExpenseCategory']['category_name']);
		if(!$id) {
			$exist = $this->AcpExpenseCategory->find('first',array('fields'=>array('id'),'conditions'=>array('category_name'=>$name,'sbs_subscriber_id'=>$this->subscriber)));
		} else {
			$exist = $this->AcpExpenseCategory->find('first',array('fields'=>array('id'),'conditions'=>array('category_name'=>$name,'sbs_subscriber_id'=>$this->subscriber,'NOT'=>array('id'=>$id))));
		}
		if(!empty($exist)) {
			return 'false';
		} else {
			return 'true';
		}
	}
	
	/**
	 * @method This method is used in Add Expense and Edit Expense, not in Add Expense category
	 *   
	 * */
	public function add() {
		$this->permission = $this->Session->read('Auth.AllPermissions.Manage Expenses');
		$permission = $this->permission;
		if($this->permission['_create'] != 1) {
			$this->redirect(array('controller'=>'users','action'=>'noaccess'));
		}
		if(!empty($this->data['AcpExpenseCategory']['category_name'])) {
			$findExistingCategory = $this->AcpExpenseCategory->find('first',array('fields'=>array('id'),'conditions'=>array('sbs_subscriber_id'=>$this->subscriber,'category_name'=>$this->data['AcpExpenseCategory']['category_name'])));
			if(empty($findExistingCategory)) {
				$this->request->data['AcpExpenseCategory']['sbs_subscriber_id'] = $this->subscriber;
				if($this->AcpExpenseCategory->save($this->data)) {
					$lastInsertID = $this->AcpExpenseCategory->getLastInsertId();
				}
			} else {
				$lastInsertID = $findExistingCategory['AcpExpenseCategory']['id'];
			}
		}
		$expenseCategories   = $this->AcpExpenseCategory->getList($this->subscriber);
		$this->set(compact('lastInsertID','expenseCategories'));
	}
	
}
?>