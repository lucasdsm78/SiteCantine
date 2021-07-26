<?php
/**
 * Vérifie les identifiants de connexion et instancie les variables de session
 
 * @param $loginSaisi 
 * @param $mdpSaisi
 * @return un booléen true si utilisateur connu, false sinon 
*/

function verifierIdentification($loginSaisi,$mdpSaisi ) {
    require "connexion.php" ;
    $sql="select * from elior_utilisateur" ;
    $exec=$bdd->query($sql);
    $trouve = false ;
    $fin=false ;
    while (!$trouve && !$fin)
    {
        if ($ligne = $exec->fetch())
        {

            if ($ligne['login']==$loginSaisi && $ligne['mdp']==$mdpSaisi)
            {
                $trouve = true ;
                $_SESSION['ident']=$ligne['nom'].' '.$ligne['prenom']."&nbsp;&nbsp;&nbsp;&nbsp;" ;
                $_SESSION['idUtil']=$ligne['id'] ;
                $_SESSION['statut']=$ligne['statut'] ;
            }
        }
        else
        {
            $fin = true ;
        }
    }
    return $trouve ;
}

function getLesDatesCommandes($dateLimite, $idUtil)
{
    require "connexion.php" ;
    $sql="select distinct dateMenu "
            . "from elior_menu m "
            . "where dateMenu >= '$dateLimite' "
            . "and exists (select * from elior_commande c where m.dateMenu = c.dateMenu and c.idUtil = $idUtil) "
            . "order by dateMenu ASC" ;
    $exec=$bdd->prepare($sql) ;
    $exec->execute() ;
    $curseur=$exec->fetchAll();
    return $curseur;
}




function getLesDatesNonCommandes($dateLimite, $idUtil)
{
    require "connexion.php" ;
    $sql="select distinct dateMenu "
            . "from elior_menu m "
            . "where dateMenu >= '$dateLimite' "
            . "and not exists (select * from elior_commande c where m.dateMenu = c.dateMenu and c.idUtil = $idUtil) "
            . "order by dateMenu ASC" ;
    $exec=$bdd->prepare($sql) ;
    $exec->execute() ;
    $curseur=$exec->fetchAll();
    return $curseur;
}

function getLesDatesMenus()
{
    require "connexion.php" ;
    $sql="select distinct dateMenu from elior_menu order by dateMenu DESC" ;
    $exec=$bdd->prepare($sql) ;
    $exec->execute() ;
    $curseur=$exec->fetchAll();
    return $curseur;
}

function getLesMenus()
{
    require "connexion.php" ;
    $sql="select * from elior_menu ORDER BY dateMenu DESC, numMenu ASC LIMIT 0 , 120" ;
    $exec=$bdd->prepare($sql) ;   
    $exec->execute() ;
    return $exec;
}

function getTarifAnnulation($date, $idUtil)
{
     require "connexion.php" ;
    $sql="select tarifFormule from elior_formule F INNER JOIN elior_menu M ON F.idFormule = M.idFormule INNER JOIN elior_commande C ON C.dateMenu = M.dateMenu AND C.numMenu = M.numMenu WHERE C.dateMenu = '$date' AND idUtil = '$idUtil' " ;
    $exec=$bdd->prepare($sql) ;
    $exec->execute() ;
    $ligne=$exec->fetch();
    return $ligne;   
}


function getPrixFormule($date, $numMenu)
{
        require "connexion.php" ;
    $sql="select tarifFormule from elior_formule F INNER JOIN elior_menu M ON M.idFormule = F.idFormule WHERE dateMenu = '$date' AND numMenu = '$numMenu' " ;
    $exec=$bdd->prepare($sql) ;
    $exec->execute() ;
    $ligne=$exec->fetch();
    return $ligne;
}

function getLesFormulesMenu($dateJour, $numMenu)
{
    require "connexion.php" ;
    $sql="select * from elior_formule F INNER JOIN elior_menu M ON M.idFormule = F.idFormule WHERE dateMenu = '$dateJour' AND numMenu = '$numMenu' " ;
    $exec=$bdd->prepare($sql) ;
    $exec->execute() ;
    $ligne=$exec->fetch();
    return $ligne;
}

function getLesMenusDate($dateJour)
{
    require "connexion.php" ;
    $sql="select * from elior_menu M inner join elior_formule F ON M.idFormule = F.idFormule where dateMenu = '$dateJour' order by numMenu, libelleFormule" ;
    $exec=$bdd->prepare($sql) ;
    
    $exec->execute() ;
    $curseur=$exec->fetchAll();
    return $curseur;
}

function getLesComptesEleves()
{
    require "connexion.php" ;
    $sql="select nom, prenom, idClasse, creditRepas from elior_utilisateur where (idClasse=1 OR idClasse=2) order by nom, prenom" ;
    $exec=$bdd->prepare($sql) ;  
    $exec->execute() ;
    $curseur=$exec->fetchAll();
    return $curseur;
}

function getLesMenusJour($dateJour)
{
    require "connexion.php" ;
    $sql="select * from elior_menu where dateMenu = '$dateJour' order by numMenu" ;
    $exec=$bdd->prepare($sql) ;
    $exec->execute() ;
    $curseur=$exec->fetchAll();
    return $curseur;
}

function majMenu($dateMenu, $numMenu, $descMenu, $formuleMenu)
{       
    $descMenu = addslashes($descMenu) ;
    require "connexion.php" ;
    $sql="UPDATE elior_menu "
            . "SET descriptionMenu='$descMenu', idFormule = '$formuleMenu' "
            . "where dateMenu = '$dateMenu' and numMenu = $numMenu" ;
    //exécution de la requete
    $exec=$bdd->prepare($sql) ;
    $exec->execute() ;
}

function ajoutMenu($dateMenu, $numMenu, $descMenu, $formuleMenu)
{       
    $descMenu = addslashes($descMenu) ;
    require "connexion.php" ;
    $sql="INSERT INTO elior_menu "
            . "values ('$dateMenu', $numMenu, '$descMenu', '$formuleMenu')" ;
    //exécution de la requete
    $exec=$bdd->prepare($sql) ;
    $exec->execute() ;
}

function supMenu($dateMenu, $numMenu)
{       
    require "connexion.php" ;
    $sql="DELETE FROM elior_menu "
            . "where dateMenu = '$dateMenu' and numMenu = $numMenu" ;
    //exécution de la requete
    $exec=$bdd->prepare($sql) ;
    $exec->execute() ;
}


function listeFormule()
{       
    require "connexion.php" ;
    $sql="SELECT * FROM elior_formule" ;
    $exec=$bdd->prepare($sql) ;  
    $exec->execute() ;
    $curseur=$exec->fetchAll();
    return $curseur;
}

function ajoutFormule($libelle, $tarif)
{
    require "connexion.php" ;
    $sql="INSERT INTO elior_formule (libelleFormule, tarifFormule) VALUES ('". $libelle ."', '". $tarif ."')";
    $exec=$bdd->prepare($sql) ;
    $exec->execute() ;
}

function ajoutFormuleOK($libelleFormule) {
    require "connexion.php" ;
    $sql="select * from elior_formule" ;
    $exec=$bdd->query($sql);
    $trouve = false ;
    $fin=false ;
    while (!$trouve && !$fin)
    {
        if ($ligne = $exec->fetch())
        {

            if ($ligne['libelleFormule'] == $libelleFormule)
            {
                $trouve = true ;
            }
        }
        else
        {
            $fin = true ;
        }
    }
    return $trouve ;
}

function editFormule($id, $libelle, $tarif)
{       
    require "connexion.php" ;
    $sql="UPDATE elior_formule SET libelleFormule = '". $libelle ."', tarifFormule = '". $tarif ."' WHERE idFormule = ". $id ."";
    $exec=$bdd->prepare($sql) ;
    $exec->execute() ;
}

function supFormule($id)
{       
    require "connexion.php" ;
    $sql="DELETE FROM elior_formule WHERE idFormule = ". $id ."";
    $exec=$bdd->prepare($sql) ;
    $exec->execute() ;
}

function supFormuleOK($id)
{       
    require "connexion.php" ;
    $sql="select * from elior_menu" ;
    $exec=$bdd->query($sql);
    $trouve = false ;
    $fin=false ;
    while (!$trouve && !$fin)
    {
        if ($ligne = $exec->fetch())
        {

            if ($ligne['idFormule'] == $id)
            {
                $trouve = true ;
            }
        }
        else
        {
            $fin = true ;
        }
    }
    return $trouve ;
}

function listeUtilisateurs()
{       
    require "connexion.php" ;
    $sql="SELECT * FROM elior_utilisateur" ;
    $exec=$bdd->prepare($sql) ;  
    $exec->execute() ;
    $curseur=$exec->fetchAll();
    return $curseur;
}

function ajoutUtilisateur($nom, $prenom, $login, $pass, $classe, $statut)
{
    require "connexion.php" ;
    $sql="INSERT INTO elior_utilisateur (nom, prenom, login, mdp, idClasse, statut) VALUES ('". $nom ."', '". $prenom ."', '". $login ."', '". $pass ."', '". $classe ."', '". $statut ."')";
    $exec=$bdd->prepare($sql) ;
    $exec->execute() ;
}

function editUtilisateur($id, $nom, $prenom, $login, $classe, $statut)
{       
    require "connexion.php" ;
    $sql="UPDATE elior_utilisateur SET nom = '". $nom ."', prenom = '". $prenom ."', login = '". $login ."', idClasse = '". $classe ."', statut = '". $statut ."' WHERE id = ". $id ."";
    $exec=$bdd->prepare($sql) ;
    $exec->execute() ;
}

function supUtilisateur($id)
{       
    require "connexion.php" ;
    $sql="DELETE FROM elior_utilisateur WHERE id = ". $id ."";
    $exec=$bdd->prepare($sql) ;
    $exec->execute() ;
}

function enrmdp($mdp, $idUtil)
{       
    require "connexion.php" ;
    $mdp=MD5($mdp);
    $sql="UPDATE elior_utilisateur "
            . "SET mdp='$mdp' "
            . "where id = '$idUtil'" ;
    //exécution de la requete
    $exec=$bdd->prepare($sql) ;
    $exec->execute() ;
}

function majParams($heureDebutCde, $nbRepasDecouvert)
{       
    require "connexion.php" ;
    $sql="UPDATE elior_params "
            . "SET heureDebutCde='$heureDebutCde', nbRepasDecouvert=$nbRepasDecouvert" ;
    //exécution de la requete
    $exec=$bdd->prepare($sql) ;
    $exec->execute() ;
}

function getNbMenusDate($dateJour)
{
    require "connexion.php" ;
    $sql="select count(*) as nb from elior_menu where dateMenu = '$dateJour'" ;
    $exec=$bdd->prepare($sql) ;
    $exec->execute() ;
    $curseur=$exec->fetch();
    return $curseur['nb'];
}

function getLesCommandesJour($date)
{
    require "connexion.php" ;
    $sql="select * from elior_commande "
            . "inner join elior_utilisateur on id = idUtil and dateMenu = '$date' order by numMenu, nom, prenom ASC" ;
    $exec=$bdd->query($sql) ;
    return $exec ;
}

function getParams()
{
    require "connexion.php" ;
    $sql="select * from elior_params " ;
    $exec=$bdd->prepare($sql) ;
    $exec->execute() ;
    $curseur=$exec->fetch();
    return $curseur;
}

function getNbMenusJour($date)
{
    require "connexion.php" ;
    $sql="select * from elior_menu "
            . "where dateMenu = '$date'" ;
    $exec=$bdd->query($sql) ;
    return $exec->rowCount() ;
}

function getNbCommandesJour($date)
{
    require "connexion.php" ;
    $sql="select * from elior_commande "
            . "where dateMenu = '$date'" ;
    $exec=$bdd->query($sql) ;
    return $exec->rowCount() ;
}

function getNbCommandesMenuJour($date, $numMenu)
{
    require "connexion.php" ;
    $sql="select * from elior_commande "
            . "where dateMenu = '$date' and numMenu=$numMenu" ;
    $exec=$bdd->query($sql) ;
    return $exec->rowCount() ;
}

function getLesCommandesUtil($idUtil)
{
    require "connexion.php" ;
    $sql="select * from elior_commande c "
            . "inner join elior_menu m on c.dateMenu = m.dateMenu and c.numMenu = m.numMenu where idUtil = $idUtil order by c.dateMenu DESC" ;
    $exec=$bdd->query($sql) ;
    return $exec ;
}

function getNbCommandesUtilMois($mm, $aa, $idUtil)
{
    require "connexion.php" ;
    $sql="select * from elior_commande where idUtil = $idUtil and year(dateMenu) = $aa and month(dateMenu) = $mm" ;
    $exec=$bdd->query($sql) ;
    return $exec->rowCount() ;
}

/*function getLesFormulesAujourdhui($date)
{
    require "connexion.php";
    $sql= "SELECT libelleFormule FROM elior_formule F INNER JOIN elior_menu M ON  ";
    $exec=$bdd->prepare($sql) ;
    $exec->execute() ;
    $ligne=$exec->fetch();
    return $ligne;
}*/

function getCommandeAujourdhui($date, $idUtil)
{
    require "connexion.php" ;
    $sql="select * from elior_commande where idUtil = $idUtil and dateMenu = '$date'" ;
    $exec=$bdd->query($sql) ;
    return $exec->rowCount() ;
}

function enregistrerCommande($dateMenu,$numMenu,$idUtil ) {
    require "connexion.php" ;
    $sql="INSERT INTO elior_commande values ('$dateMenu','$numMenu', '$idUtil')" ;
    //exécution de la requete
    $exec=$bdd->prepare($sql) ;
    $exec->execute() ;
    
    //diminution du crédit repas
    $formulesMenus = getLesFormulesMenu($dateMenu, $numMenu) ;
    $prixRepas = $formulesMenus['tarifFormule'];
    $sql="update elior_utilisateur SET creditRepas = creditRepas - $prixRepas where id=$idUtil" ;
    //exécution de la requete
    $exec=$bdd->prepare($sql) ;
    $exec->execute() ;
 }    

 function annulerCommande ($dateMenu, $idUtil) {
    require "connexion.php" ;  
    
    //augmentation du crédit repas
    $tarifAnnulation = getTarifAnnulation($dateMenu, $idUtil) ;
    $prixRepas = $tarifAnnulation['tarifFormule'];
    $sql="update elior_utilisateur SET creditRepas = creditRepas + $prixRepas where id=$idUtil" ;
    //exécution de la requete
    $exec=$bdd->prepare($sql) ;
    $exec->execute() ;

    $sql="DELETE FROM elior_commande where dateMenu='$dateMenu' and idUtil = '$idUtil' " ;
    //exécution de la requete
    $exec=$bdd->prepare($sql) ;
    $exec->execute() ;  
 }
 
 function getLesEleves()
 {
    require "connexion.php" ;
    $sql="select id, nom, prenom, creditRepas, idClasse "
            . "from elior_utilisateur "
            . "where (idClasse=1 or idClasse=2) "
            . "order by nom, prenom " ;
    $exec=$bdd->prepare($sql) ;
    $exec->execute() ;
    $curseur=$exec->fetchAll();
    return $curseur;
 }
 
 function getUnEtudiant($idEleve)
{
    require "connexion.php" ;
    $sql="select * from elior_utilisateur where id = $idEleve" ;
    $exec=$bdd->prepare($sql) ;
    $exec->execute() ;
    $curseur=$exec->fetch();
    return $curseur;
}

function getLesRepasCumul($dateDebut, $dateFin)
{
    require "connexion.php" ;
    
    //analyse des filtres
    $where = "dateMenu between '$dateDebut' and '$dateFin' " ;
    
    $sql="select dateMenu, COUNT(*) as nbRepas "
            ." from elior_utilisateur "
            ." left join elior_commande on elior_utilisateur.id = idUtil "
            ." where ".$where." "
            . "group by dateMenu " 
            . "order by dateMenu ASC " ;
    $exec=$bdd->prepare($sql) ;
    $exec->execute() ;
    $curseur=$exec->fetchAll();
    return $curseur;
}
//Fonction pour récupérer les repas par formule
 function getLesFormulesCumul($dateDebut, $dateFin)
 {
    require "connexion.php" ;
    
    //analyse des filtres
    $where = " elior_commande.dateMenu between '$dateDebut' and '$dateFin' " ;

    $sql= "select elior_formule.libelleFormule, count(*) as nbRepas "
        ." from elior_commande "
        ." left join elior_menu on elior_commande.numMenu = elior_menu.numMenu and elior_commande.dateMenu = elior_menu.dateMenu "
        ." inner join elior_formule on elior_menu.idFormule = elior_formule.idFormule "
        ." where ".$where." "
        ."group by elior_menu.idFormule "
        ."order by elior_menu.idFormule " ;
    $exec=$bdd->prepare($sql) ;
    $exec->execute() ;
    $curseur=$exec->fetchAll();
    return $curseur;

 }
 
 function getLesRepasDetail($dateDebut, $dateFin)
{
    require "connexion.php" ;
    
    //analyse des filtres
    $where = "dateMenu between '$dateDebut' and '$dateFin' " ;
    
    $sql="select dateMenu, nom, prenom "
            ." from elior_utilisateur "
            ." left join elior_commande on elior_utilisateur.id = idUtil "
            ." where ".$where." "
            . "order by dateMenu ASC " ;
    $exec=$bdd->prepare($sql) ;
    $exec->execute() ;
    $curseur=$exec->fetchAll();
    return $curseur;
 }
 
 function getLesPaiements($dateDebut, $dateFin, $typeReglement, $idEleve)
 {
    require "connexion.php" ;
    
    //analyse des filtres
    $where = "datePaiement between '$dateDebut' and '$dateFin' " ;
    
    if ($typeReglement != 3) $where .= " and typeReglement=".$typeReglement ;
    
    if ($idEleve != 0) $where .= " and idEleve=".$idEleve ;
    
    $sql="select elior_paiement.id, idEleve, nom, prenom, datePaiement, montant, typeReglement, remarques "
            ." from elior_utilisateur "
            ." left join elior_paiement on elior_utilisateur.id = idEleve "
            ." where ".$where." "
            . "order by datePaiement DESC " ;

    $exec=$bdd->prepare($sql) ;
    $exec->execute() ;
    $curseur=$exec->fetchAll();
    return $curseur;
 }
 
 function exportPaiements($dateDebut, $dateFin, $typeReglement, $idEleve)
 {
    require "connexion.php" ;
    
    //analyse des filtres
    $where = "datePaiement between '$dateDebut' and '$dateFin' " ;
    
    if ($typeReglement != 3) $where .= " and typeReglement=".$typeReglement ;
    
    if ($idEleve != 0) $where .= " and idEleve=".$idEleve ;
    
    $sql="select elior_paiement.id, idEleve, nom, prenom, datePaiement, montant, typeReglement, remarques "
            ." from elior_utilisateur "
            ." left join elior_paiement on elior_utilisateur.id = idEleve "
            ." where ".$where." "
            . "order by datePaiement DESC " ;
    $exec=$bdd->prepare($sql) ;
    $exec->execute() ;
    $curseur=$exec->fetchAll();
    
    $nomFichier = "bts_paiements_export.csv" ;
			
    $fp = fopen($nomFichier, 'w');
	
    fwrite($fp, utf8_decode("Date;Nom;Prénom;Montant;Type règlement;Remarques\n"));
    foreach ($curseur as $ligne)
    {
        if ($ligne['typeReglement'] == 1) $typeReglement = "Espèces";
        if ($ligne['typeReglement'] == 2) $typeReglement = "Chèque";
        $ligne_xls=  getDateJMA($ligne['datePaiement']).";".utf8_decode($ligne['nom']).";".utf8_decode($ligne['prenom']).";".$ligne['montant'].";".utf8_decode($typeReglement).";".utf8_decode($ligne['remarques']) ;
        fwrite($fp, $ligne_xls."\n");
    }  
    fclose($fp);
 }
 
 function exportRepas($dateDebut, $dateFin, $typeRepas, $lesRepasPris)
 {
    require "connexion.php" ;
    
    $nomFichier = "bts_listerepas_export.csv" ;
			
    $fp = fopen($nomFichier, 'w');
    
    fwrite($fp, "BTS - Nombre de repas du ".getDateJMA($dateDebut)." au ".getDateJMA($dateFin)."\n\n");
    
    $cumulNbRepas = 0 ;
    if ($typeRepas == 2)
        fwrite($fp, utf8_decode("Date;Nom;Prénom\n"));
    else 
        if($typeRepas == 3)
        {
            fwrite($fp, utf8_decode("LibelleFormule;Nombre de repas\n"));
        }
        else
        fwrite($fp, utf8_decode("Date;Nombre de repas\n"));
    
    foreach ($lesRepasPris as $ligne)
    {
        if ($typeRepas == 2)
        {
            $ligne_xls=  getDateJMA($ligne['dateMenu']).";".utf8_decode($ligne['nom']).";".utf8_decode($ligne['prenom']) ;
            $cumulNbRepas++ ;
        }
        else 
        {
            if($typeRepas == 3)
            {
                $ligne_xls= utf8_decode($ligne['libelleFormule']).";".($ligne['nbRepas']) ;
                $cumulNbRepas += $ligne['nbRepas'] ;
            }
            else{
            $ligne_xls=  getDateJMA($ligne['dateMenu']).";".$ligne['nbRepas'] ;
            $cumulNbRepas += $ligne['nbRepas'] ;}
        }
        fwrite($fp, $ligne_xls."\n");
    }  
    if ($typeRepas == 2)
    {
        fwrite($fp, ";Nombre total de repas;".$cumulNbRepas."\n");
    }
    else 
        if($typeRepas == 3)
        {
            fwrite($fp, ";Nombre total de repas;".$cumulNbRepas."\n");
        }
        else
        fwrite($fp, "Nombre total de repas;".$cumulNbRepas."\n");
    
    fclose($fp);
 }
 
 function getDescriptionMenu($dateMenu,$numMenu) 
 {
     require "connexion.php" ;

    $sql="select descriptionMenu "
            ." from elior_menu "
            ." where dateMenu='$dateMenu' and numMenu=$numMenu" ;

    $exec=$bdd->prepare($sql) ;
    $exec->execute() ;
    $curseur=$exec->fetch();
    return $curseur['descriptionMenu'];
 }
 
 function getSolde($idEleve) 
 {
     require "connexion.php" ;

    $sql="select creditRepas "
            ." from elior_utilisateur "
            ." where id=$idEleve" ;

    $exec=$bdd->prepare($sql) ;
    $exec->execute() ;
    $curseur=$exec->fetch();
    return $curseur['creditRepas'];
 }
 
 function getLePaiement($id)
 {
    require "connexion.php" ;

    $sql="select elior_paiement.id, idEleve, nom, prenom, datePaiement, montant, typeReglement, remarques "
            ." from elior_utilisateur "
            ." left join elior_paiement on elior_utilisateur.id = idEleve "
            ." where elior_paiement.id=$id" ;

    $exec=$bdd->prepare($sql) ;
    $exec->execute() ;
    $curseur=$exec->fetch();
    return $curseur;
 }
 
 function enregistrerPaiement($idEleve, $datePaiement, $montant, $typeReglement, $remarques) 
 {
    require "connexion.php" ;
    $remarques = addslashes($remarques) ;
    $sql="INSERT INTO elior_paiement (idEleve, datePaiement, montant, typeReglement, remarques) "
            . " values ($idEleve, '$datePaiement',$montant, $typeReglement, '$remarques')" ;
    //exécution de la requete
    $exec=$bdd->prepare($sql) ;
    $exec->execute() ;$remarques = addslashes($remarques) ;
    
    //augmenter le crédit repas de l'élève
    $sql="update elior_utilisateur set creditRepas = creditRepas + $montant where id = $idEleve" ;
    //exécution de la requete
    $exec=$bdd->prepare($sql) ;
    $exec->execute() ;
    
 }
 function modifierPaiement($idEleve, $datePaiement, $montant, $typeReglement, $remarques, $id) 
 {
    require "connexion.php" ;
    $remarques = addslashes($remarques) ;
    //récupération ancien montant enregistrer
    $lePaiement = getLePaiement($id) ;
    $montantAvant = $lePaiement['montant'] ;
    $montantApres = $montant ;
    
    //mise à jour du paiement
    $sql="UPDATE elior_paiement 
          SET datePaiement = '$datePaiement', montant=$montant, typeReglement=$typeReglement, remarques='$remarques', idEleve=$idEleve
          WHERE id=$id";

    //exécution de la requete
    $exec=$bdd->prepare($sql) ;
    $exec->execute() ;
    
    //mise à jour du crédit repas de l'élève si le le montant a changé
    $diff = $montantApres - $montantAvant ;
    
    $sql="update elior_utilisateur set creditRepas = creditRepas + $diff where id = $idEleve" ;
    //exécution de la requete
    $exec=$bdd->prepare($sql) ;
    $exec->execute() ;
    
 }
 
  function supprimerPaiement($id) 
 {
    require "connexion.php" ;
    //récupération ancien montant enregistrer
    $lePaiement = getLePaiement($id) ;
    $idEleve = $lePaiement['idEleve'] ;
    $montantAvant = $lePaiement['montant'] ;
    $montantApres = 0;
    
    //mise à jour du paiement
    $sql="DELETE from elior_paiement 
          WHERE id=$id";

    //exécution de la requete
    $exec=$bdd->prepare($sql) ;
    $exec->execute() ;
    
    //mise à jour du crédit repas de l'élève si le le montant a changé
    $diff = $montantApres - $montantAvant ;
    
    $sql="update elior_utilisateur set creditRepas = creditRepas + $diff where id = $idEleve" ;
    //exécution de la requete
    $exec=$bdd->prepare($sql) ;
    $exec->execute() ;
    
 }
?>