<?php
class Likipe_Utility_Model_Observer extends Varien_Event_Observer
{
	public function __construct()
	{
	}
	public function saveCmsPageObserve($observer)
	{
		$event = $observer->getEvent();
		$model = $event->getPage();
		//$model->setData('title','Hello Chao');
		print_r($model->getData());
		die('test');
	}
}
?>