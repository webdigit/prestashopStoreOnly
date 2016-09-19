<?php
if (! defined ( '_PS_VERSION_' ))
	exit ();

class WebdigitStoreOnly extends Module {
	
	// M�thode de construction du module webdigitstoreonly
	
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
	
	// M�thode pour l'installation du module
	
	public function install() {
		//Gestion de la fonctionnalit� multiboutique 
		if (Shop::isFeatureActive ()) // Si le multiboutique est activ� ou non
			Shop::setContext ( Shop::CONTEXT_ALL ); // Modifie le contexte pour appliquer les changements qui suivent � toutes les boutiques existantes plus qu'� la seule boutique actuellement utilis�e.
		
		if (! parent::install() || ! Configuration::updateValue ( 'MYMODULE_NAME', 'WEBDIGIT_STORE_ONLY' ))
			return false;
		
		return true;
	}
	
	// M�thode pour la d�sinstallation du module
	
	public function uninstall() {
		return parent::uninstall() && Configuration::deleteByName ( 'WEBDIGIT_STORE_ONLY' );
	}
	
	
	
	
}