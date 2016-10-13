<?php
if (! defined ( '_PS_VERSION_' ))
	exit ();

class WebdigitStoreOnly extends Module {
	
	private $storeOnly;
	// Méthode de construction du module webdigitstoreonly
	
	public function __construct() {
		$this->name	= 'webdigitstoreonly';
		$this->tab = 'front_office_features';
		$this->version = '1.0.0';
		$this->author = 'WEBDIGIT sprl';
		$this->need_instance =	0;
		$this->ps_versions_compliancy = array (
				'min' => '1.6',
				'max' => _PS_VERSION_
		);
		$this->bootstrap = true;
		
		parent::__construct ();
		
		$this->displayName = $this->l ( 'Products Store Only' );
		$this->description = $this->l ( 'Give possibility to sell a selected product only through your store (click and mortar)' );
		$this->confirmUninstall = $this->l ( 'Are you sure you want to uninstall?' );
		
		// Gestion des inputs du formulaire
		if (! Configuration::get ( 'WEBDIGIT_STORE_ONLY' ))
			$this->warning = $this->l ( 'No name provided' );
	}
	
	// Méthode pour l'installation du module
	
	public function install() {
		//Gestion de la fonctionnalité multiboutique 
		if (Shop::isFeatureActive ()) // Si le multiboutique est activé ou non
			Shop::setContext ( Shop::CONTEXT_ALL ); // Modifie le contexte pour appliquer les changements qui suivent à toutes les boutiques existantes plus qu'� la seule boutique actuellement utilis�e.
		
		// CREATION ONGLET : installation des différentes méthodes pour la création de l'onglet
		if (! parent::install() || 
				! $this->alterTable ( 'add' ) || 
				! $this->registerHook ( 'actionAdminControllerSetMedia' ) || 
				! $this->registerHook ( 'displayHeader' ) ||
				! $this->registerHook ( 'actionProductUpdate' ) || 
				! $this->registerHook ( 'displayAdminProductsExtra' ) ||
				! Configuration::updateValue ( 'MYMODULE_NAME', 'WEBDIGIT_STORE_ONLY' ) )
			return false;
		
		return true;
	}
	
	// Méthode pour la désinstallation du module
	public function uninstall() {
		return parent::uninstall() && $this->alterTable( 'remove' ) && Configuration::deleteByName ( 'WEBDIGIT_STORE_ONLY' ); 
	}
		
	// Création de la méthode alterTable pour gérer l'ajout ou la suppression
	public function alterTable($method) {
		switch ($method) {
			case 'add':
				$sql = 'ALTER TABLE ' . _DB_PREFIX_ . 'product ADD `store_only` TINYINT(1) unsigned NOT NULL DEFAULT \'0\''; // Ajoute la colonne 'store_only' dans la table 'product_lang' l'installation du module
				break;
			
			case 'remove':
				$sql = ' ALTER TABLE ' . _DB_PREFIX_ . 'product DROP COLUMN `store_only`'; // Supprime la colonne 'store_only' dans la table 'product_lang' à la désinstallation du module
				break;
		}
		// Exécution du sQL 
		if(! Db::getInstance()->Execute($sql))
			return false;
		return true;
	}
	
	public function hookDisplayHeader($params) {
		$allowed_controllers = array (
				'index',
				'product',
				'category'
		);
		$_controller = $this->context->controller;
		
		if (isset( $_controller->php_self ) && in_array ($_controller->php_self, $allowed_controllers)){
			$this->context->controller->addCss ($this->_path . 'views/css/wdstoreonly.css', 'all');
			$this->context->controller->addJs ($this->_path . 'views/js/wdstoreonly.js', 'all');
		}	
		$sql = "SELECT id_product, store_only FROM "._DB_PREFIX_."product WHERE active = '1';";
		
		if($result = Db::getInstance()->ExecuteS($sql)){
			$jsReturn = ''; 
			$jsReturn .= '<script type="text/javascript">';
			$jsReturn .= 'var storeOnly = [];';
			foreach ($result as $row){
				/*
				 * storeOnly['1']=1
				 * storeOnly['2']=0
				 * storeOnly['3']=1
				 */
				$jsReturn .= "storeOnly['".$row['id_product']."']='".$row['store_only']."';";
			}
			
			$jsReturn .= '</script>';			
			return $jsReturn;
		}
	}
	
	public function hookActionAdminControllerSetMedia($params){
	
		$this->context->controller->addJs($this->_path.'views/js/wdstoreonly_admin.js');	
	}
	
	
	public function hookDisplayAdminProductsExtra($params){
		
		if (Tools::isSubmit ('submitTest')){
			$value = Tools::getValue('storeOnly');
			$id_product = Tools::getValue('id_product');
			
			if(!$value){
				$value = 0;
			}			
			Db::getInstance()->update('product', array('store_only'=>$value), 'id_product = '.$id_product);
			
		}else {
			$id_product = $_GET['id_product'];
			$sql = 'SELECT store_only FROM '._DB_PREFIX_.'product WHERE id_product = '.$id_product;
			if (!$result = Db::getInstance()->getRow($sql)){
				die('Erreur etc.');
			}else {
				$value = $result['store_only'];
			}
		}

		$checked = '';
		if($value || $value == 1){
			$checked = 'checked="checked"';
		}
		
		$this->smarty->assign (array(
				'checked' => $checked
		));
		return $this->display(__FILE__, 'wdstoreonly.tpl');
	}	
}