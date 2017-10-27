<?php

class VUser extends VBase {

    function __construct($appli, $model) {
        parent::__construct($appli, $model);
    }

    public function datefr($date){
            $a=explode("-", $date);
            $annee=$a[0];
            $mois=$a[1];
            $jour=$a[2];
            $rep=$jour.'-'.$mois.'-'.$annee;
            return $rep;
    }
    
    public function nonDroit(){
        $html='Vous n\'&ecirc;tes pas autoris&eacute; &agrave; acc&eacute;der &agrave cette partie du site, ou votre session &agrave; expir&eacute.<br />'
                . '<a href="index.php">Retour</a>';
        $this->appli->content=$html;
    }

    public function formConnect(){
        $html='
        <form  class="form-horizontal" role="form" action="index.php?component=user&action=login" method="POST" autocomplete="off">
            <div class="form-group">
                <label for="identifiant" class="col-sm-2 control-label">Identifiant</label>
                <div class="col-sm-3">
                    <input type="text" class="form-control" name="login" id="identifiant" placeholder="Identifiant" autofocus/>
                </div>
            </div>
            <div class="form-group">
                <label for="password" class="col-sm-2 control-label">Mot de passe</label>
                <div class="col-sm-3">
                    <input type="password" class="form-control" name="password" id="password" placeholder="Mot de passe"/>
                </div>
            </div>
            <div id="choiceBase"></div>
            <div class="form-group">
                <div class="col-sm-offset-2 col-sm-3">
                    <button type="submit" class="btn btn-primary btn-block btn-large">Entrer</button>
                </div>
            </div>
        </form>';
        $this->appli->content=$html;
    }

    public function menuAccueil($data=0){
        $prenom=(isset($_SESSION['prenom'])) ? $_SESSION['prenom'] : $data['prenom'];
        $acces=(isset($_SESSION['acces'])) ? $_SESSION['acces'] : $data['acces'];
        $idUser=(isset($_SESSION['idUser'])) ? $_SESSION['idUser'] : $data['idUser'];
        //echo $acces.'<br />';
        $html=''
                . '<a class="menuC" href="#" style="cursor:not-allowed;"><img class="bMenu" src="./media/icons/rwi-30-512.png">Bienvenue '.$prenom.'</a>';
        switch($acces){
            case '1': //Niveau 1 -> Niveau de base
                $html.='<a class="menuC" href="#" onclick="nonprog();"><img class="bMenu" src="./media/icons/bRecherches.png">Recherches</a>';
                break;
            case '5':  //Niveau 2 -> INP Proxi
                $html.='<a class="menuC" href="?component=domiciliation&action=getFormAddDateRef" onclick="addToHisto(\''.$idUser.'\',\'domiciliation\',\'getFormAddDateRef\');"><img class="bMenu" src="./media/icons/bNouveau.png">Nouvelle domiciliation dans mon quartier</a>';
                $html.='<a class="menuC" href="#" onclick="nonprog();"><img class="bMenu" src="./media/icons/bRecherches.png">Recherches</a>';
                $html.='<a class="menuC" href="#" onclick="nonprog();"><img class="bMenu" src="./media/icons/bModif.png">Modification d\'une domiciliation existante dans mon quartier</a>';
                $html.='<a class="menuC" href="#" onclick="nonprog();"><img class="bMenu" src="./media/icons/bCommerces.jpg">Commerces de mon quartier</a>';
                $html.='<a class="menuC" href="#" onclick="nonprog();"><img class="bMenu" src="./media/icons/bRecherches.png">Recherches</a>';
                break;
            case '10': //Nivau 3 -> Chef d'antenne
                $html.='<a class="menuC" href="?component=domiciliation&action=getFormAddDateRef" onclick="addToHisto(\''.$idUser.'\',\'domiciliation\',\'getFormAddDateRef\');"><img class="bMenu" src="./media/icons/bNouveau.png">Nouvelle domiciliation dans mon antenne</a>';
                $html.='<a class="menuC" href="#" onclick="nonprog();"><img class="bMenu" src="./media/icons/bRecherches.png">Recherches</a>';
                $html.='<a class="menuC" href="#" onclick="nonprog();"><img class="bMenu" src="./media/icons/bModif.png">Modification d\'une domiciliation existante dans mon antenne</a>';
                $html.='<a class="menuC" href="#" onclick="nonprog();"><img class="bMenu" src="./media/icons/bCommerces.jpg">Commerces de mon antenne</a>';
                $html.='<a class="menuC" href="#" onclick="nonprog();"><img class="bMenu" src="./media/icons/bRecherches.png">Recherches</a>';
                break;
            case '15': //Niveau 4 -> admin général "Dieu"
                $html.='<a class="menuC" href="?component=domiciliation&action=getFormAddDateRef" onclick="addToHisto(\''.$idUser.'\',\'domiciliation\',\'getFormAddDateRef\');"><img class="bMenu" src="./media/icons/bNouveau.png">Nouvelle domiciliation sur l\'entit&eacute;</a>';
                $html.='<a class="menuC" href="#" onclick="nonprog();"><img class="bMenu" src="./media/icons/bRecherches.png">Recherches</a>';
                $html.='<a class="menuC" href="#" onclick="nonprog();"><img class="bMenu" src="./media/icons/bModif.png">Modification d\'une domiciliation existante sur l\'entit&eacute;</a>';
                $html.='<a class="menuC" href="#" onclick="nonprog();"><img class="bMenu" src="./media/icons/bCommerces.jpg">Commerces  de l\'entit&eacute;</a>';
                $html.='<a class="menuC" href="#" onclick="nonprog();"><img class="bMenu" src="./media/icons/bRecherches.png">Recherches</a>';
                $html.='<a class="menuC" href="?component=user&action=gestPlateforme"><img class="bMenu" src="./media/icons/parametres.png">Gestion de la plateforme</a>';
                
        }
                /*. '<a class="menuC" href="?component=domiciliation&action=getFormAddDateRef" onclick="addToHisto(\''.$idUser.'\',\'domiciliation\',\'getFormAddDateRef\');"><img class="bMenu" src="./media/icons/bNouveau.png">Nouvelle domiciliation</a>'
                . '<a class="menuC" href="#" onclick="nonprog();"><img class="bMenu" src="./media/icons/bModif.png">Modification d\'une domiciliation existante
</a>'
                . '<a class="menuC" href="#" onclick="nonprog();"><img class="bMenu" src="./media/icons/bCommerces.jpg">Commerces</a>'
                . '<a class="menuC" href="#" onclick="nonprog();"><img class="bMenu" src="./media/icons/bRecherches.png">Recherches</a>'
                . '<a class="menuC" href="?component=user&action=gestPlateforme"><img class="bMenu" src="./media/icons/parametres.png">Gestion de la plateforme</a>'*/
        $html.='<a class="menuC" href="?component=user&action=logoff" onclick="confirm(\'Voulez-vous vraiment quitter ?\');"><img class="bMenu" src="./media/icons/bSortir.jpg">Sortir</a>';
        $this->appli->content=$html;
    }
    
    public function menuGestPlateforme($acces){
        $html='<div id="Gestplateforme"><p class="boutonC85">Gestion de la plateforme</p>'
                . '<p class="boutonC45">Veuillez effectuer un choix dans le menu de gauche</p></div>';
        $this->appli->content=$html;
    }

    public function errorLog($data){
        switch($data){
            case 1: case 2:
                $this->appli->content='Erreur, veuillez <a href="index.php">recommencer</a>.';
                break;
            case 3:
                $this->appli->content='Compte bloqu&eacute;.';
                break;
        }
    }
    
    public function formEditUser($data, $grades, $services, $idUser){
        $html='<p class="boutonC85">&Eacute;dition d\'un utilisateur</p>';
        $html.='<form style="max-width:680px;" class="form-horizontal" role="form" name="formEditUser" action="index.php?component=user&action=modifUser&user='.$idUser.'" method="POST">';
        foreach($data as $row){
            $html.=''
                    . '<div class="form-group">'
                    . ' <label for="nom" class="col-sm-3 control-label">Nom</label>'
                    . '     <div class="col-sm-6">'
                    . '         <div class="input-group">'
                    . '             <input type="text" class="form-control" id="nom" name="nom" value="'.$row['nom'].'" readonly>'
                    . '             <div class="input-group-addon" onclick="editThis(\'nom\');" style="cursor:pointer;">'
                    . '                 <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>'
                    . '             </div>'
                    . '         </div>'
                    . '     </div>'
                    . '</div>'
                    . '<div class="form-group">'
                    . ' <label for="prenom" class="col-sm-3 control-label">Pr&eacute;nom</label>'
                    . '     <div class="col-sm-6">'
                    . '         <div class="input-group">'
                    . '             <input type="text" class="form-control" id="prenom" name="prenom" value="'.$row['prenom'].'" readonly>'
                    . '             <div class="input-group-addon" onclick="editThis(\'prenom\');" style="cursor:pointer;">'
                    . '                 <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>'
                    . '             </div>'
                    . '         </div>'
                    . '     </div>'
                    . '</div>'
                    . '<div class="form-group">'
                    . ' <label for="matricule" class="col-sm-3 control-label">Matricule</label>'
                    . '     <div class="col-sm-6">'
                    . '         <div class="input-group">'
                    . '             <input type="text" class="form-control" id="matricule" name="matricule" value="'.$row['matricule'].'" readonly>'
                    . '             <div class="input-group-addon" onclick="editThis(\'matricule\');" style="cursor:pointer;">'
                    . '                 <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>'
                    . '             </div>'
                    . '         </div>'
                    . '     </div>'
                    . '</div>'
                    . '<div class="form-group">'
                    . ' <label for="denomination_grade" class="col-sm-3 control-label">Grade</label>'
                    . '     <div class="col-sm-6">'
                    . '         <div class="input-group">'
                    . '             <select class="form-control" id="denomination_grade" name="denomination_grade" readonly>';
                foreach($grades as $rowa){
                    $html.='<option value="'.$rowa['denomination_grade'].'" ';
                    $html.=($row['denomination_grade']==$rowa['denomination_grade']) ? 'selected>' : '>';
                    $html.=$rowa['denomination_grade'].'</option>';
                }
                $html.='            </select>'
                    . '             <div class="input-group-addon" onclick="editThis(\'denomination_grade\');" style="cursor:pointer;">'
                    . '                 <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>'
                    . '             </div>'
                    . '         </div>'
                    . '     </div>'
                    . '</div>'
                    . '<div class="form-group">'
                    . ' <label for="denomination_service" class="col-sm-3 control-label">Service</label>'
                    . '     <div class="col-sm-6">'
                    . '         <div class="input-group">'
                    . '             <select class="form-control" id="denomination_service" name="denomination_service" readonly>';
                 foreach($services as $rowb){
                    $html.='<option value="'.$rowb['id_service'].'" ';
                    $html.=($row['denomination_service']==$rowb['denomination_service']) ? 'selected>' : '>';
                    $html.=$rowb['denomination_service'].'</option>';
                }
                $html.='            </select>'               
                    . '             <div class="input-group-addon" onclick="editThis(\'denomination_service\');" style="cursor:pointer;">'
                    . '                 <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>'
                    . '             </div>'
                    . '         </div>'
                    . '     </div>'
                    . '</div>'
                    . '<div class="form-group">'
                    . ' <label for="mail" class="col-sm-3 control-label">Mail</label>'
                    . '     <div class="col-sm-6">'
                    . '         <div class="input-group">'
                    . '             <input type="text" class="form-control" id="mail" name="mail" value="'.$row['mail'].'" readonly>'
                    . '             <div class="input-group-addon" onclick="editThis(\'mail\');" style="cursor:pointer;">'
                    . '                 <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>'
                    . '             </div>'
                    . '         </div>'
                    . '     </div>'
                    . '</div>'                    
                    . '<div class="form-group">'
                    . ' <label for="fixe" class="col-sm-3 control-label">T&eacute;l&eacute;phone fixe</label>'
                    . '     <div class="col-sm-6">'
                    . '         <div class="input-group">'
                    . '             <input type="text" class="form-control" id="fixe" name="fixe" value="'.$row['fixe'].'" readonly>'
                    . '             <div class="input-group-addon" onclick="editThis(\'fixe\');" style="cursor:pointer;">'
                    . '                 <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>'
                    . '             </div>'
                    . '         </div>'
                    . '     </div>'
                    . '</div>'
                    . '<div class="form-group">'
                    . ' <label for="gsm" class="col-sm-3 control-label">GSM</label>'
                    . '     <div class="col-sm-6">'
                    . '         <div class="input-group">'
                    . '             <input type="text" class="form-control" id="gsm" name="gsm" value="'.$row['gsm'].'" readonly>'
                    . '             <div class="input-group-addon" onclick="editThis(\'gsm\');" style="cursor:pointer;">'
                    . '                 <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>'
                    . '             </div>'
                    . '         </div>'
                    . '     </div>'
                    . '</div>'
                    . '<div class="form-group">'
                    . ' <label for="CP" class="col-sm-3 control-label">Code postal</label>'
                    . '     <div class="col-sm-6">'
                    . '         <div class="input-group">'
                    . '             <input type="text" class="form-control" id="CP" name="CP" value="'.$row['CP'].'" readonly>'
                    . '             <div class="input-group-addon" onclick="editThis(\'CP\');" style="cursor:pointer;">'
                    . '                 <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>'
                    . '             </div>'
                    . '         </div>'
                    . '     </div>'
                    . '</div>'
                    . '<div class="form-group">'
                    . ' <label for="ville" class="col-sm-3 control-label">Ville</label>'
                    . '     <div class="col-sm-6">'
                    . '         <div class="input-group">'
                    . '             <input type="text" class="form-control" id="ville" name="ville" value="'.$row['ville'].'" readonly>'
                    . '             <div class="input-group-addon" onclick="editThis(\'ville\');" style="cursor:pointer;">'
                    . '                 <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>'
                    . '             </div>'
                    . '         </div>'
                    . '     </div>'
                    . '</div><div class="form-group">'
                    . ' <label for="rue" class="col-sm-3 control-label">Rue</label>'
                    . '     <div class="col-sm-6">'
                    . '         <div class="input-group">'
                    . '             <input type="text" class="form-control" id="rue" name="rue" value="'.$row['rue'].'" readonly>'
                    . '             <div class="input-group-addon" onclick="editThis(\'rue\');" style="cursor:pointer;">'
                    . '                 <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>'
                    . '             </div>'
                    . '         </div>'
                    . '     </div>'
                    . '</div><div class="form-group">'
                    . ' <label for="numero" class="col-sm-3 control-label">Num&eacute;ro</label>'
                    . '     <div class="col-sm-6">'
                    . '         <div class="input-group">'
                    . '             <input type="text" class="form-control" id="numero" name="numero" value="'.$row['numero'].'" readonly>'
                    . '             <div class="input-group-addon" onclick="editThis(\'numero\');" style="cursor:pointer;">'
                    . '                 <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>'
                    . '             </div>'
                    . '         </div>'
                    . '     </div>'
                    . '</div>'
                        . '<input type="hidden" name="acces" value="'.$_SESSION['acces'].'">'
                    . '<div class="col-sm-offset-5 col-sm-10">'
                    . '<button type="submit" class="btn btn-default">Enregistrer</button>'
                        . '</div>';
        }
        $html.='</form>';
        $this->appli->content=$html;
    }

}
?>