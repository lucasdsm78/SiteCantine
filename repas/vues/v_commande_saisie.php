
      <div class="home">
          <form name="repas_saisie" action="index.php?uc=commande&action=valider" method="POST" autocomplete="off">
          <div id="Home_title_ss">
              <?php
              
            if ($solde < 1)
            {
                echo '<div id="Titles"><b>'.$_SESSION['ident'].'</b>'
                        . '<br />Solde = '.$solde.' €.</div>'
                        . '<div id="Home_title_struct">Veuillez recharger votre compte.';
            }
            else {
                echo '<div id="Titles"><b>'.$_SESSION['ident'].'</b>'
                        . '<br />Solde = '.$solde." € </div>";
            }
 
            echo 'Commande repas du '.$ladateJMA.'</br></br>' ;
            echo '<input type="hidden" name="date" value="'.$ladateAMJ.'">' ;
            //echo 'Formule :' $lesRepasTries . '</br>';
              ?>
          </div>
          
        <?php
        if ($nbMenus == 1) $checked = " checked " ; else $checked = "" ;



        foreach ($lesMenus as $leMenu)
        {

                          echo 'Formule : ' . $leMenu['libelleFormule'] . '</br>';
              echo '<input type="radio" name="numMenu" value ="'.$leMenu['numMenu'].'"'.$checked.'>'.$leMenu['numMenu'].'&nbsp;&nbsp;&nbsp;'.$leMenu['descriptionMenu'].'<br />' ;
          
          
        }

        echo '</br>
            <input type="submit" class="btn btn-info connectbt" name="valider" value="Valider">&nbsp;&nbsp;' ;      
        ?>
       
          </form>
      </div>