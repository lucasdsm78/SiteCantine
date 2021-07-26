<div class="home">
    <div id="Home_title_ss">
    <?php

    if ($solde < 1)
    {
        echo '<div id="Titles"><b>'.$_SESSION['ident'].'</b>'
                . '<br />Solde = '.$solde.' €.</div>'
                . '<div id="Home_title_struct">Veuillez recharger votre compte.' ;
    }
    else {
        echo '<div id="Titles"><b>'.$_SESSION['ident'].'</b>'
                . '<br />Solde = '.$solde." €</div>";
    }
    ?>
    </div>
</div>