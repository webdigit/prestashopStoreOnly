<?php
if (! defined ( '_PS_VERSION_' ))
	exit ();

class WebdigitStoreOnly extends Module {
	
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
			Shop::setContext ( Shop::CONTEXT_ALL ); // Modifie le contexte pour appliquer les changements qui suivent à toutes les boutiques existantes plus qu'à la seule boutique actuellement utilisée.
		
		// CRÉATION ONGLET : installation des différentes méthodes pour la création de l'onglet
		if (! parent::install() || ! $this->alterTable( 'add' ) || ! $this->registerHook( 'actionAdminControllerSetMedia' ) || ! $this->registerHook( 'actionProductUpdate' ) || ! $this->registerHook( 'displayAdminProductsExtra' ) || ! Configuration::updateValue( 'MYMODULE_NAME', 'WEBDIGIT_STORE_ONLY' ) )
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
				$sql = 'ALTER TABLE ' . _DB_PREFIX_ . 'product ADD `store_only` TINYINT(1) unsigned NOT NULL DEFAULT \'0\''; // Ajoute la colonne 'store_only' dans la table 'product_lang' à l'installation du module
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
	
	// TEST CRÉATION ONGLET
	public function hookDisplayAdminProductsExtra($params){
		if (Validate::isLoadedObject($product = new Product((int)Tools::getValue( 'id_product' )))) {
			return $this->display(__FILE__, 'webdigitstoreonly.tpl');
		}
	}
	
	
	
}