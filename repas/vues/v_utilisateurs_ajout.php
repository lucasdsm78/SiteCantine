<div class="home">
    <div id="Home_title">Ajouter un élève</div>
    <form method="POST" action="index.php?uc=gestion&action=utilisateur_ajout_ok">
        <input type="text" name="nom" class="input_text2" placeholder="Nom"><br>
        <input type="text" name="prenom" class="input_text2" placeholder="Prénom"><br>
        <input type="text" name="login" class="input_text2" placeholder="Login"><br>
        <input type="text" name="pass" class="input_text2" placeholder="Mot de passe"><br>
        <input type="text" name="classe" class="input_text2" placeholder="Classe"><br>
        <input type="text" name="statut" class="input_text2" placeholder="Satut"><br>
        <input type="submit" class="btn btn-info connectbt" name="send" value="Envoyer la donnée">
    </form>
</div>