<div class="home">
    <div id="Home_title">Liste des formules pour les repas</div>
    <table class="table">
        <tr>
            <td><a href="index.php?uc=gestion&action=formule_ajout">Ajouter une formule</a></td>
        </tr>

        <?php
        if ($msgAjout != "") {
            echo ''
                .'<tr>'
                .'<td>'. $msgAjout .'</td>'
                .'</tr>';
        }
        ?>

        <tr>
            <th>Libellé</th>
        </tr>
        <?php
            foreach ($lesFormules as $laFormule) {
                echo '<tr>';
                if (isset($_REQUEST['role']) && ($_REQUEST['role'] == "modifier" && isset($_REQUEST['id']) && ($_REQUEST['id']) == $laFormule['idFormule'])){
                    echo ''
                    . '<form method="POST" action="index.php?uc=gestion&action=formule_enregistrer">'
                    . '<td><input type="hidden" name="id" value="'. $_REQUEST['id'] .'"></td>'
                    . '<td>Libellé de la formule : <input type="text" class="input_text2" name="libelle" value="'. $laFormule['libelleFormule'] .'"></td>'
                    . '<td>Tarification de la formule : <input type="text" class="input_text2" name="tarif" value="'. $laFormule['tarifFormule'] .'"></td>'
                    . '<td><input type="submit" class="btn btn-info connectbt" value="Valider"></td>'
                    . '</form>'
                    . '</td>'
                    . '<td></td>';
                }
                else {
                    echo '<td>'
                    . $laFormule['libelleFormule']
                    . '</td>';
                    echo '<td>'
                    . $laFormule['tarifFormule']
                    . '</td>'
                    . '<td>'
                    . '<form method="POST" action="index.php?uc=gestion&action=formule&role=modifier">'
                    . '<td><input type="hidden" class="btn btn-info connectbt" name="id" value="'. $laFormule['idFormule'] .'">'
                    . '<td><input type="submit" class="btn btn-info connectbt" value="Modifier"></td>'
                    . '</form>'
                    . '</td>';
                    echo '<td>'
                        . '<form method="POST" action="index.php?uc=gestion&action=formule_supprimer">'
                        . '<td><input type="hidden" name="id" value="'. $laFormule['idFormule'] .'">'
                        . '<td><input type="submit" class="btn btn-info connectbt" value="Supprimer"></td>'
                        . '</form>'
                    . '</td>';
                }
                echo '</tr>';
            }
        ?>
    </table>
</div>