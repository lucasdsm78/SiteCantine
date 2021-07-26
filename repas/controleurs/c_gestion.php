<?php
if (!isset($_SESSION['idUtil'])) header("Location:index.php");
if (!isset($_SESSION['statut'])) header("Location:index.php");
if (($_SESSION['statut']!=2) && ($_SESSION['statut']!=4)) header("Location:index.php");
if (!isset($_REQUEST['action']))
	$action = "" ;
else
	$action = $_REQUEST['action'] ;
	
switch ($action)
{
	case "afficher" : { 
            //affiche les commandes du jour
            
            $ladateAMJ = date("Y-m-d") ;
            $ladateJMA = date("d/m/Y") ;
            $_SESSION['laDateCde'] = $ladateAMJ ;
            $lesCommandes = getLesCommandesJour($ladateAMJ) ;
            require "vues/v_commande_liste.php" ; 
            break ;             
        }
        
        case "plus" : { 
            //affiche les commandes d'une date choisie
            $lesDates = getLesDatesMenus() ;
            require "vues/v_dates_commande.php" ; 
            break ;             
        }
        
        case "consulter" : { 
            //affiche les commandes d'une date choisie
            $ladateURL = $_REQUEST['date'] ;
            $ladateAMJ = substr($ladateURL,0,4)."-".substr($ladateURL,4,2)."-".substr($ladateURL,6,2) ;
            $ladateJMA = getDateJMA($ladateAMJ) ;
            $_SESSION['laDateCde'] = $ladateAMJ ;
            $lesCommandes = getLesCommandesJour($ladateAMJ) ;
            require "vues/v_commande_liste.php" ;  
            break ;             
        }
        
        case "compte" : { 
            //affiche les comptes des élèves
            $lesComptes = getLesComptesEleves() ;
            require "vues/v_comptes_eleves.php" ;  
            break ;             
        }
        
        case "formule" : { 
            $msgAjout = "";
            $lesFormules = listeFormule();
            require "vues/v_formule.php" ; 
            break ;                         
        }

        case "formule_ajout" : { 
            require "vues/v_formule_ajout.php" ; 
            break ;                         
        }

        case "formule_ajout_ok" : { 
            $laFormule = addslashes($_REQUEST['libelle']);
            $tarifFormule = addslashes($_REQUEST['tarif']);
            
            $verifAjout = ajoutFormuleOK($laFormule);

            if ($verifAjout) {
                $msgAjout = "Erreur : existe déjà en base";
            }
            else {
                ajoutFormule($laFormule, $tarifFormule);
            }

            $lesFormules = listeFormule();
            require "vues/v_formule.php" ; 
            break ;                         
        }

        case "formule_enregistrer" : { 
            $idFormule = $_REQUEST['id'];
            $laFormule = addslashes($_REQUEST['libelle']);
            $tarifFormule = addslashes($_REQUEST['tarif']);
            editFormule($idFormule, $laFormule, $tarifFormule);
            $lesFormules = listeFormule();
            require "vues/v_formule.php" ; 
            break ;                         
        }

        case "formule_supprimer" : { 
            $laFormule = $_REQUEST['id'];

            $verifAjout = supFormuleOK($laFormule);

            if ($verifAjout) {
                $msgAjout = "Erreur : cette formule contient un ou plusieurs menus";
            }
            else {
                supFormule($laFormule);
            }

            $lesFormules = listeFormule();
            require "vues/v_formule.php" ; 
            break ;                         
        }

        case "menusaisir" : { 
            //affiche la vue de saisie des menus
            $ladateURL = $_REQUEST['date'] ;
            $ladateAMJ = substr($ladateURL,0,4)."-".substr($ladateURL,4,2)."-".substr($ladateURL,6,2) ;
            $ladateJMA = getDateJMA($ladateAMJ) ;
            $lesMenus = getLesMenusJour($ladateAMJ) ;
            require "vues/v_saisir_menu.php" ; 
            break ;                          
        }
        
        case "menuenregistrer" : { 
            //affiche la vue de saisie des menus
            $ladateAMJ = $_REQUEST['dateMenu'] ;
            $ladateJMA = getDateJMA($ladateAMJ) ;
            $numMenu = $_REQUEST['numMenu'] ;
            $descMenu = $_REQUEST['descMenu'.$numMenu] ;
            majMenu($ladateAMJ, $numMenu, $descMenu) ;
            $lesMenus = getLesMenusJour($ladateAMJ) ;
            require "vues/v_saisir_menu.php" ; 
            break ;                         
        }
        
        case "menusupprimer" : { 
            //affiche la vue de saisie des menus
            $ladateURL = $_REQUEST['dateMenu'] ;
            $ladateAMJ = substr($ladateURL,0,4)."-".substr($ladateURL,4,2)."-".substr($ladateURL,6,2) ;
            $ladateJMA = getDateJMA($ladateAMJ) ;
            $numMenu = $_REQUEST['numMenu'] ;
            supMenu($ladateAMJ, $numMenu) ;
            $lesMenus = getLesMenusJour($ladateAMJ) ;
            require "vues/v_saisir_menu.php" ; 
            break ;                        
        }
        
        case "menuajouter" : { 
            //affiche la vue de saisie des menus
            $ladateAMJ = $_REQUEST['dateMenu'] ;
            $ladateJMA = getDateJMA($ladateAMJ) ;
            $numMenu = $_REQUEST['numMenu'] ;
            $descMenu = $_REQUEST['descMenu'.$numMenu] ;
            $formuleMenu = $_REQUEST['formuleMenu'.$numMenu] ;
            ajoutMenu($ladateAMJ, $numMenu, $descMenu, $formuleMenu) ;
            $lesMenus = getLesMenusJour($ladateAMJ) ;
            require "vues/v_saisir_menu.php" ; 
            break ;                        
        }
        
        case "utilisateur" : { 
            $lesUtilisateurs = listeUtilisateurs();
            require "vues/v_utilisateurs.php" ; 
            break ;                         
        }

        case "utilisateur_ajout" : { 
            require "vues/v_utilisateurs_ajout.php" ; 
            break ;                         
        }

        case "utilisateur_ajout_ok" : { 
            $nom = $_REQUEST['nom'];
            $prenom = $_REQUEST['prenom'];
            $login = $_REQUEST['login'];
            $pass = md5($_REQUEST['pass']);
            $classe = $_REQUEST['classe'];
            $statut = $_REQUEST['statut'];
            
            ajoutUtilisateur($nom, $prenom, $login, $pass, $classe, $statut);
            $lesUtilisateurs = listeUtilisateurs();
            require "vues/v_utilisateurs.php" ; 
            break ;                         
        }

        case "utilisateur_enregistrer" : { 
            $id = $_REQUEST['id'];
            $nom = $_REQUEST['nom'];
            $prenom = $_REQUEST['prenom'];
            $login = $_REQUEST['login'];
            $classe = $_REQUEST['classe'];
            $statut = $_REQUEST['statut'];

            editUtilisateur($id, $nom, $prenom, $login, $classe, $statut);
            $lesUtilisateurs = listeUtilisateurs();
            require "vues/v_utilisateurs.php" ; 
            break ;                         
        }

        case "utilisateur_supprimer" : { 
            $id = $_REQUEST['id'];
            supUtilisateur($id);
            $lesUtilisateurs = listeUtilisateurs();
            require "vues/v_utilisateurs.php" ; 
            break ;                         
        }

        case "param" : { 
            //affiche la vue de saisie des menus
            $params = getParams() ;
            require "vues/v_params_affich.php" ; 
            break ;                        
        }
        
        case "paramenregistrer" : { 
            //affiche la vue de saisie des menus
            $heureDebutCde = $_REQUEST['heureDebutCde'] ;
            $nbRepasDecouvert = $_REQUEST['nbRepasDecouvert'] ;
            if ($heureDebutCde!="")
            {
                majParams($heureDebutCde, $nbRepasDecouvert) ;
                $params = getParams() ;
                require "vues/v_params_affich.php" ; 
            }
            else 
            { 
                $message = "Veuillez renseigner les paramètres" ;
                require "vues/v_erreur.php" ; 
                require "vues/v_params_affich.php" ; 
            }
            
            break ;                        
        }
        
        case "crediter" : { 
            if (!isset($_REQUEST['role']))
                $role = "choixEleve" ;
            else
                $role = $_REQUEST['role'] ;
            switch($role)
            {
                case "choixEleve" : {
                    
                    //affiche la vue de saisie des crédits des comptes élèves : liste déroulante choix de l'élève
                    $lesEleves = getLesEleves();
                    $messageValid = '' ;
                    $_SESSION['enregistrer'] = false ;
                    require "vues/v_crediter_compte.php" ;
                    break ;                        
                }
        
                case "eleve" : {
                    //affiche le crédit actuel de l'élève et formulaire de saisie du règlement
                    $idEleve = $_REQUEST['id'] ;
                    $leEleve = getUnEtudiant($idEleve) ;
                    $_SESSION['enregistrer'] = false ;
                    require "vues/v_crediter_eleve.php" ;
                    break ;
                }
                
                case "enregistrer" : {
                    $idEleve = $_REQUEST['id'] ;
                    if (isset($_SESSION['enregistrer']) && $_SESSION['enregistrer'] == false)
                    {
                    //affiche le crédit actuel de l'élève et formulaire de saisie du règlement
                        
                        $datePaiement = $_REQUEST['datePaiement'] ;
                        $montant = $_REQUEST['montant'] ;
                        $typeReglement = $_REQUEST['typeReglement'] ;
                        $remarques = $_REQUEST['remarques'] ;
                        $_SESSION['enregistrer'] = true ;
                        //enregistrement du paiement
                        enregistrerPaiement($idEleve, $datePaiement, $montant, $typeReglement, $remarques) ;
                    }
                    
                    $leEleve = getUnEtudiant($idEleve) ;
                    $messageValid = 'Le solde de '.$leEleve['nom'].' '.$leEleve['prenom'].' est maintenant de '.$leEleve['creditRepas'].' €' ;
                    $lesEleves = getLesEleves();
                    require "vues/v_crediter_compte.php" ;
                    break ;
                }
            }
            break ;
        }
        
        case "paiement" : { 
            if (!isset($_REQUEST['role']))
                $role = "afficher" ;
            else
                $role = $_REQUEST['role'] ;
            switch($role)
            {
                case "afficher" : {
                    
                    //affiche la vue de consultation des paiements avec filtres
                    $lesEleves = getLesEleves();
                    $messageValid = '' ;
                    require "vues/v_paiement_filtres.php" ;
                    break ;                        
                }
                case "traiter" : {
                    
                    //récupération des données du filtre d'affichage
                    $dateDebut = $_REQUEST['dateDebut'] ;
                    $dateFin = $_REQUEST['dateFin'] ;
                    $typeReglement = $_REQUEST['typeReglement'] ;
                    $idEleve = $_REQUEST['idEleve'] ;
                    
                    //mise en session des paramètres pour l'export Excel
                    $_SESSION['dateDebut'] = $_REQUEST['dateDebut'] ;
                    $_SESSION['dateFin'] = $_REQUEST['dateFin'] ;
                    $_SESSION['typeReglement']= $_REQUEST['typeReglement'] ;
                    $_SESSION['idEleve'] = $_REQUEST['idEleve'] ;
                    
                    $lesEleves = getLesEleves();
                    $lesPaiements = getLesPaiements($dateDebut, $dateFin, $typeReglement, $idEleve) ;
                    $excel = false ;
                    require "vues/v_paiement_liste.php" ;
                    break ;                        
                }
                
                case "export" : {
                    
                    //récupération des données du filtre d'affichage
                    $dateDebut = $_SESSION['dateDebut'];
                    $dateFin = $_SESSION['dateFin'] ;
                    $typeReglement = $_SESSION['typeReglement'] ;
                    $idEleve = $_SESSION['idEleve'] ;

                    $lesEleves = getLesEleves();
                    $lesPaiements = getLesPaiements($dateDebut, $dateFin, $typeReglement, $idEleve) ;
                    exportPaiements($dateDebut, $dateFin, $typeReglement, $idEleve) ;
                    $excel = true ;
                    require "vues/v_paiement_liste.php" ;
                    break ;                        
                }
                
                case "maj" : {
                    
                    //récupération des données du filtre d'affichage
                    $id = $_REQUEST['id'] ;
                    $lePaiement = getLePaiement($id) ;
                    $lesEleves = getLesEleves();
                    $_SESSION['enregistrer'] = false ;
                    require "vues/v_paiement_maj.php" ;
                    break ;                        
                }
                
                case "modifier" : {
                    
                    if ($_SESSION['enregistrer'] == false)
                    {
                        //récupération des données du filtre d'affichage
                        $id = $_REQUEST['id'] ;
                        $datePaiement = $_REQUEST['datePaiement'] ;
                        $montant = $_REQUEST['montant'] ;
                        $typeReglement = $_REQUEST['typeReglement'] ;
                        $remarques = $_REQUEST['remarques'] ;
                        $idEleve = $_REQUEST['idEleve'] ;

                        //enregistrement du paiement
                        modifierPaiement($idEleve, $datePaiement, $montant, $typeReglement, $remarques, $id) ;
                        $_SESSION['enregistrer'] = true ;
                        $leEleve = getUnEtudiant($idEleve) ;
                    }
                    
                    
                    $lesEleves = getLesEleves();
                    $messageValid = 'Le paiement a bien été modifié' ;
                    require "vues/v_paiement_filtres.php" ;
                    break ;                        
                }
                
                case "suppr" : {
                    
                    //récupération des données du filtre d'affichage
                    $id = $_REQUEST['id'] ;
                    //suppression du paiement
                    supprimerPaiement( $id) ;

                    $lesEleves = getLesEleves();
                    $messageValid = 'Le paiement a bien été supprimé' ;
                    require "vues/v_paiement_filtres.php" ;
                    break ;                        
                }
            }
            break ;
        }
        
        case "listerepas" : { 
            if (!isset($_REQUEST['role']))
                $role = "afficher" ;
            else
                $role = $_REQUEST['role'] ;
            switch($role)
            {
                case "afficher" : {
                    
                    //affiche la vue avec filtres
                    $messageValid = '' ;
                    require "vues/v_listerepas_filtres.php" ;
                    break ;                        
                }
                case "traiter" : {
                    
                    //récupération des données du filtre d'affichage
                    $dateDebut = $_REQUEST['dateDebut'] ;
                    $dateFin = $_REQUEST['dateFin'] ;
                    $typeRepas = $_REQUEST['typeRepas'] ;
                    //mise en session des paramètres pour l'export Excel
                    $_SESSION['dateDebut'] = $_REQUEST['dateDebut'] ;
                    $_SESSION['dateFin'] = $_REQUEST['dateFin'] ;
                    $_SESSION['typeRepas'] = $_REQUEST['typeRepas'] ;
                    
                    if ($typeRepas==2)
                        $lesRepasPris = getLesRepasDetail($dateDebut, $dateFin) ;

                    else //appel de la fonction ajoutée
                        if ($typeRepas == 3){
                        $lesRepasPris = getLesFormulesCumul($dateDebut, $dateFin) ;}
                        else{
                        $lesRepasPris = getLesRepasCumul($dateDebut, $dateFin) ;}
                    $excel = false ;
                    require "vues/v_listerepas_liste.php" ;
                    break ;                        
                }                
                case "export" : {
                    
                    //récupération des données du filtre d'affichage
                    $dateDebut = $_SESSION['dateDebut'];
                    $dateFin = $_SESSION['dateFin'] ;
                    $typeRepas = $_SESSION['typeRepas'] ;
                    //mise en session des paramètres pour l'e
                    if ($typeRepas==2)
                        $lesRepasPris = getLesRepasDetail($dateDebut, $dateFin) ;
                    else //Appel de la fonction pour l'exportation
                        if($typeRepas == 3)
                        {
                            $lesRepasPris = getLesFormulesCumul($dateDebut, $dateFin) ;
                        }
                        else{
                        $lesRepasPris = getLesRepasCumul($dateDebut, $dateFin) ;}
                    exportRepas($dateDebut, $dateFin, $typeRepas, $lesRepasPris) ;
                    $excel = true ;
                    require "vues/v_listerepas_liste.php" ;
                    break ;                        
                }               
            }
            break ;
        }
        
        case "mdp" : { 
            //affiche la vue de saisie des menus
            require "vues/v_mdp_saisir.php" ;
            break ;                        
        }
        
        case "mdpenregistrer" : { 
            //affiche la vue de saisie des menus
            $mdp = $_REQUEST['mdp1'] ;
            enrmdp($mdp, $_SESSION['idUtil']);
            $message = "Votre mot de passe a été modifié" ;
            require "vues/v_ok.php" ; 
            break ;                        
        }
}
?>
