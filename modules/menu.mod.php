<?php
$html='';
if((isset($_SESSION['acces']))&&($_SESSION['acces']>='5')&&(isset($_SESSION['step']))&&($_SESSION['step']>0)){
    $html='<a href="#" class="menuC" onclick="nonprog();"><img class="bMenu" src="./media/icons/bAutresMembres.jpg"><span class="aMasquer">Autres  membres du m&eacute;nage</span></a>'
        . '<a href="#" class="menuC" onclick="nonprog();"><img class="bMenu" src="./media/icons/bPersCont.jpg"><span class="aMasquer">Personne de contact</span></a>'
        . '<a href="#" class="menuC" onclick="nonprog();"><img class="bMenu" src="./media/icons/bIdProprio.jpg"><span class="aMasquer">Identit&eacute; du propri&eacute;taire</span></a>'
        . '<a href="#" class="menuC" onclick="nonprog();"><img class="bMenu" src="./media/icons/bArmes.jpg"><span class="aMasquer">Armes</span></a>'
        . '<a href="#" class="menuC" onclick="nonprog();"><img class="bMenu" src="./media/icons/bAnimaux.jpg"><span class="aMasquer">Animaux</span></a>'
        . '<a href="#" class="menuC" onclick="nonprog();"><img class="bMenu" src="./media/icons/bVehicules.png"><span class="aMasquer">V&eacute;hicules</span></a>'
        . '<a href="#" class="menuC" onclick="nonprog();"><img class="bMenu" src="./media/icons/bDatesPas.png"><span class="aMasquer">Dates de passage</span></a>'
        . '<a href="#" class="menuC" onclick="nonprog();"><img class="bMenu" src="./media/icons/bCom.jpg"><span class="aMasquer">Commentaires</span></a>'
        . '<a href="#" class="menuC" onclick="nonprog();"><img class="bMenu" src="./media/icons/bFicheHab.png"><span class="aMasquer">Fiche habitation</span></a>'
        . '<a href="?component=user&action=retourAccueil" onclick="return(confirm(\'Voulez-vous vraiment quitter ?\n Vérifiez vos enregistrements !\'));" class="menuC"><img class="bMenu" src="./media/icons/bSortir.jpg"><span class="aMasquer">Sortir</span></a>';
}
else if((isset($_SESSION['step']))&&($_SESSION['step']==='gestPlateforme')){
    $acces=$_SESSION['acces'];
    if($acces==='15'){
    $html='<a href="#" class="menuC" onclick="gestUsers(\''.$acces.'\',\''.$_SESSION['idUser'].'\');"><img class="bMenu" src="./media/icons/users-icon.png"><span class="aMasquer">Gestion des utilisateurs</span></a>'
            . '<a href="#" onclick="gestAcces(\''.$acces.'\');" class="menuC"><img class="bMenu" src="./media/icons/access.png"><span class="aMasquer">Gestion des acc&egrave;s</span></a>'
            . '<a href="#" onclick="gestAntennes(\''.$acces.'\',\''.$_SESSION['idUser'].'\');" class="menuC"><img class="bMenu" src="./media/icons/antenne.png"><span class="aMasquer">Gestion des antennes</span></a>'
            . '<a href="#" onclick="gestRues(\''.$acces.'\',\''.$_SESSION['idUser'].'\');" class="menuC"><img class="bMenu" src="./media/icons/rues.png"><span class="aMasquer">Gestion des rues</span></a>'
            . '<a href="#" onclick="couplagesRQ(\''.$acces.'\',\''.$_SESSION['idUser'].'\');" class="menuC"><img class="bMenu" src="./media/icons/couplingRQ.png"><span class="aMasquer">Couplages rues - quartier</span></a>'
            . '<a href="#" onclick="couplagesAQ(\''.$acces.'\',\''.$_SESSION['idUser'].'\');" class="menuC"><img class="bMenu" src="./media/icons/coupling.png"><span class="aMasquer">Couplages AQ - quartier</span></a>'
            . '<a href="?component=user&action=retourAccueil" onclick="return(confirm(\'Voulez-vous vraiment quitter ?\n Vérifiez vos enregistrements !\'));" class="menuC"><img class="bMenu" src="./media/icons/bSortir.jpg"><span class="aMasquer">Sortir</span></a>';
    }
}

if(isset($_GET['component'])&&($_GET['component']=='user')&&($_GET['action']=='formEditUser')){
    $html='<a href="javascript:window.close()" onclick="return(confirm(\'Voulez-vous vraiment quitter ?\'));" class="menuC"><img class="bMenu" src="./media/icons/bSortir.jpg"><span class="aMasquer">Sortir</span></a>';
}
$this->menu=$html;
?>