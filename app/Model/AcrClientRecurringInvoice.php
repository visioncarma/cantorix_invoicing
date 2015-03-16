<?php
App::uses('AppModel', 'Model');
/**
 * AcrClientRecurringInvoice Model
 *
 * @property AcrClientInvoice $AcrClientInvoice
 */
class AcrClientRecurringInvoice extends AppModel {


	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'AcrClientInvoice' => array(
			'className' => 'AcrClientInvoice',
			'foreignKey' => 'acr_client_invoice_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
	
	
	public function addRecurringDetail($data){
		if($data){
			$addRecuringDetail->data = null;
			$this->create();
			$addRecuringDetail->data['AcrClientRecurringInvoice']['acr_client_invoice_id'] 	= $data['acr_client_invoice_id'];
			$addRecuringDetail->data['AcrClientRecurringInvoice']['next_invoice_date'] 		= $data['next_invoice_date'];
			$addRecuringDetail->data['AcrClientRecurringInvoice']['last_invoice_date']		= $data['last_invoice_date'];
			$addRecuringDetail->data['AcrClientRecurringInvoice']['invoice_start_date'] 	= $data['invoice_start_date'];
			$addRecuringDetail->data['AcrClientRecurringInvoice']['invoice_end_date'] 		= $data['invoice_end_date'];
			$addRecuringDetail->data['AcrClientRecurringInvoice']['billing_period'] 		= $data['billing_period'];
			$addRecuringDetail->data['AcrClientRecurringInvoice']['billing_frequency'] 		= $data['billing_frequency'];
			$billingCycle = $this->getBillingCycle($data['invoice_start_date'],$data['invoice_end_date'],$data['billing_period'],$data['billing_frequency']);
			$addRecuringDetail->data['AcrClientRecurringInvoice']['billing_cycles'] 		= ceil($billingCycle);
			$addRecuringDetail->data['AcrClientRecurringInvoice']['status'] 				= 'Active';
			if($this->save($addRecuringDetail->data)){
				$recuringDetailId = $this->getLastInsertId();
				return $recuringDetailId;
			}else{
				return false;
			}
		}
	}
	public function updateRecurrence($data){
		if($data){
			
			$billingCycle = $this->getBillingCycle($data['invoice_start_date'],$data['invoice_end_date'],$data['billing_period'],$data['billing_frequency']);
			$updateRecurring->data = null;
			$updateRecurring->data['AcrClientRecurringInvoice']['id'] 				 	= $data['recurring_id'];
			$updateRecurring->data['AcrClientRecurringInvoice']['next_invoice_date'] 	= $data['next_invoice_date'];
			$updateRecurring->data['AcrClientRecurringInvoice']['last_invoice_date'] 	= $data['last_invoice_date'];
			$updateRecurring->data['AcrClientRecurringInvoice']['invoice_start_date'] 	= $data['invoice_start_date'];
			$updateRecurring->data['AcrClientRecurringInvoice']['invoice_end_date'] 	= $data['invoice_end_date'];
			$updateRecurring->data['AcrClientRecurringInvoice']['status'] 				= 'Active';
			$updateRecurring->data['AcrClientRecurringInvoice']['billing_period'] 		= $data['billing_period'];
			$updateRecurring->data['AcrClientRecurringInvoice']['billing_frequency'] 	= $data['billing_frequency'];
			$updateRecurring->data['AcrClientRecurringInvoice']['billing_cycles'] 		= $data['last_invoice_date'];
			$updateRecurring->data['AcrClientRecurringInvoice']['billing_cycles'] 		= ceil($billingCycle);
			if($this->save($updateRecurring->data)){
				return $data['recurring_id'];
			}else{
				return false;
			}
		}
	}
	public function updateRecurrenceOnGenerate($data){
		if($data){
			$updateRecurring->data['AcrClientRecurringInvoice']['id'] 				 = $data['id'];
			$updateRecurring->data['AcrClientRecurringInvoice']['last_invoice_date'] = $data['last_invoice_date'];
			if($this->save($updateRecurring->data)){
				return $data['id'];
			}else{
				return false;
			}
		}
	}
	public function stopInvoiceRecurrence($acrClientRecurrenceId = null){
		if($acrClientRecurrenceId){
			$updateRecurring->data['AcrClientRecurringInvoice']['id'] 				 = $acrClientRecurrenceId;
			$updateRecurring->data['AcrClientRecurringInvoice']['status'] 			 = 'Inactive';
			if($this->save($updateRecurring->data)){
				return $acrClientRecurrenceId;
			}else{
				return false;
			}
		}
	}
	public function startInvoiceRecurrence($acrClientRecurrenceId = null){
		if($acrClientRecurrenceId){
			$updateRecurring->data['AcrClientRecurringInvoice']['id'] 				 = $acrClientRecurrenceId;
			$updateRecurring->data['AcrClientRecurringInvoice']['status'] 			 = 'Active';
			if($this->save($updateRecurring->data)){
				return $acrClientRecurrenceId;
			}else{
				return false;
			}
		}
	}
	public function getBillingCycle($startDate = null,$endDate = null,$billingPeriod = null,$billingFrequency = null){
		
		if($startDate && $endDate && $billingPeriod && $billingFrequency){
			switch($billingPeriod){
				case "Day" 		: 	
     								$numberOfDays =  $this->datediff('d',$startDate,$endDate,false);
     								$billingCycle =  $numberOfDays/$billingFrequency;
									break;
				case "Month"	: 
									
									$diff = $this->datediff('m',$startDate,$endDate,false);
									$billingCycle =  $diff/$billingFrequency;
									break;
				case "Week"		:  
									$diff = $this->datediff('ww',$startDate,$endDate,false);
									$billingCycle =  $diff/$billingFrequency;
									break;
				case "Year"		: 	$diff = $this->datediff('yyyy',$startDate,$endDate,false);
									$billingCycle =  $diff/$billingFrequency;
									break;
			}
			if($billingCycle){
				return $billingCycle;
			}else{
				return false;
			}
     		
		}
			 
	}
	function datediff($interval, $datefrom, $dateto, $using_timestamps = false) {
			    /*
			    $interval can be:
			    yyyy - Number of full years
			    q - Number of full quarters
			    m - Number of full months
			    y - Difference between day numbers
			        (eg 1st Jan 2004 is "1", the first day. 2nd Feb 2003 is "33". The datediff is "-32".)
			    d - Number of full days
			    w - Number of full weekdays
			    ww - Number of full weeks
			    h - Number of full hours
			    n - Number of full minutes
			    s - Number of full seconds (default)
			    */
			    
			    if (!$using_timestamps) {
			        $datefrom = strtotime($datefrom, 0);
			        $dateto = strtotime($dateto, 0);
			    }
			    $difference = $dateto - $datefrom; // Difference in seconds
			     
			    switch($interval) {
			     
			    case 'yyyy': // Number of full years
			        $years_difference = floor($difference / 31536000);
			        if (mktime(date("H", $datefrom), date("i", $datefrom), date("s", $datefrom), date("n", $datefrom), date("j", $datefrom), date("Y", $datefrom)+$years_difference) > $dateto) {
			            $years_difference--;
			        }
			        if (mktime(date("H", $dateto), date("i", $dateto), date("s", $dateto), date("n", $dateto), date("j", $dateto), date("Y", $dateto)-($years_difference+1)) > $datefrom) {
			            $years_difference++;
			        }
			        $datediff = $years_difference;
			        break;
			    case "q": // Number of full quarters
			        $quarters_difference = floor($difference / 8035200);
			        while (mktime(date("H", $datefrom), date("i", $datefrom), date("s", $datefrom), date("n", $datefrom)+($quarters_difference*3), date("j", $dateto), date("Y", $datefrom)) < $dateto) {
			            $months_difference++;
			        }
			        $quarters_difference--;
			        $datediff = $quarters_difference;
			        break;
			    case "m": // Number of full months
			        $months_difference = floor($difference / 2678400);
			        while (mktime(date("H", $datefrom), date("i", $datefrom), date("s", $datefrom), date("n", $datefrom)+($months_difference), date("j", $dateto), date("Y", $datefrom)) < $dateto) {
			            $months_difference++;
			        }
			        $months_difference--;
			        $datediff = $months_difference;
			        break;
			    case 'y': // Difference between day numbers
			        $datediff = date("z", $dateto) - date("z", $datefrom);
			        break;
			    case "d": // Number of full days
			        $datediff = floor($difference / 86400);
			        break;
			    case "w": // Number of full weekdays
			        $days_difference = floor($difference / 86400);
			        $weeks_difference = floor($days_difference / 7); // Complete weeks
			        $first_day = date("w", $datefrom);
			        $days_remainder = floor($days_difference % 7);
			        $odd_days = $first_day + $days_remainder; // Do we have a Saturday or Sunday in the remainder?
			        if ($odd_days > 7) { // Sunday
			            $days_remainder--;
			        }
			        if ($odd_days > 6) { // Saturday
			            $days_remainder--;
			        }
			        $datediff = ($weeks_difference * 5) + $days_remainder;
			        break;
			    case "ww": // Number of full weeks
			        $datediff = floor($difference / 604800);
			        break;
			    case "h": // Number of full hours
			        $datediff = floor($difference / 3600);
			        break;
			    case "n": // Number of full minutes
			        $datediff = floor($difference / 60);
			        break;
			    default: // Number of full seconds (default)
			        $datediff = $difference;
			        break;
			    }    
			    return $datediff;
		}

	public function getTotalInvoicePatternBased($subscriberId,$pattern){
		$getCount = $this->find('count',array('conditions'=>array('AcrClientRecurringInvoice.sbs_subscriber_id'=>$subscriberId,'AcrClientRecurringInvoice.invoice_number like'=>$pattern.'%')));
		return $getCount;
	}
}
