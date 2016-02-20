<?php
class ElderXavier_BuscaCorreios_IndexController extends Mage_Core_Controller_Front_Action{
    public function IndexAction() {
      
	  $this->loadLayout();   
	  $this->getLayout()->getBlock("head")->setTitle($this->__("Busca Correios"));
	        $breadcrumbs = $this->getLayout()->getBlock("breadcrumbs");
      $breadcrumbs->addCrumb("home", array(
                "label" => $this->__("Home Page"),
                "title" => $this->__("Home Page"),
                "link"  => Mage::getBaseUrl()
		   ));

      $breadcrumbs->addCrumb("busca correios", array(
                "label" => $this->__("Busca Correios"),
                "title" => $this->__("Busca Correios")
		   ));

      $this->renderLayout(); 
	  
    }
}