<div class="home">
    <div id="Home_title">Liste des élèves</div>
    <table class="table">
        <tr>
            <td><a href="index.php?uc=gestion&action=utilisateur_ajout">Ajouter un élève</a></td>
        </tr>
        <tr>
            <th>Toutes les informations</th>
        </tr>
        <?php
            foreach ($lesUtilisateurs as $monUtilisateur) {
                echo '<tr>';
                if (isset($_REQUEST['role']) && ($_REQUEST['role'] == "modifier" && isset($_REQUEST['id']) && ($_REQUEST['id']) == $monUtilisateur['id'])){
                    echo ''
                    . '<form method="POST" action="index.php?uc=gestion&action=utilisateur_enregistrer">'
                    . '<td><input type="hidden" name="id" value="'. $_REQUEST['id'] .'"></td>'
                    . '<td>Login : <input type="text" class="input_text2" name="login" value="'. $monUtilisateur['login'] .'"></td>'
                    . '<td>Nom : <input type="text" class="input_text2" name="nom" value="'. $monUtilisateur['nom'] .'"></td>'
                    . '<td>Prénom : <input type="text" class="input_text2" name="prenom" value="'. $monUtilisateur['prenom'] .'"></td>'
                    . '<td>La Classe : <input type="text" class="input_text2" name="classe" value="'. $monUtilisateur['idClasse'] .'"></td>'
                    . '<td>Le statut : <input type="text" class="input_text2" name="statut" value="'. $monUtilisateur['statut'] .'"></td>'
                    . '<td><input type="submit" class="btn btn-info connectbt" value="Valider"></td>'
                    . '</form>'
                    . '</td>'
                    . '<td></td>';
                }
                else {
                    echo '<td>'
                    . $monUtilisateur['nom'] .' '. $monUtilisateur['prenom']
                    . '</td>'
                    . '<td>'
                    . '<form method="POST" action="index.php?uc=gestion&action=utilisateur&role=modifier">'
                    . '<td><input type="hidden" class="btn btn-info connectbt" name="id" value="'. $monUtilisateur['id'] .'">'
                    . '<td><input type="submit" class="btn btn-info connectbt" value="Modifier"></td>'
                    . '</form>'
                    . '</td>';
                    echo '<td>'
                        . '<form method="POST" action="index.php?uc=gestion&action=utilisateur_supprimer">'
                        . '<td><input type="hidden" name="id" value="'. $monUtilisateur['id'] .'">'
                        . '<td><input type="submit" class="btn btn-info connectbt" value="Supprimer"></td>'
                        . '</form>'
                    . '</td>';
                }
                echo '</tr>';
            }
        ?>
    </table>
</div>