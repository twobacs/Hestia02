<?php
include_once ('./constants/constant.php');

class VDomiciliation extends VBase {

    function __construct($appli, $model) {
        parent::__construct($appli, $model);
    }
public function error($err){
    $this->appli->content=$err;
}

function dateFr($date){
return strftime('%d-%m-%Y',strtotime($date));
}

public function getFormAddDateRef($user,$data,$rues,$quartiersByUser){
    $html='';
    if($data['enCours']>0){
        $html.='<p class="boutonC85" onclick="slide(\'DosEnCours\');" style="cursor:pointer;">Reprendre une domiciliation en cours ('.$data['enCours'].')</p>';
        $html.='<div id="DosEnCours" style="display:none;">';
        $html.='<table style="margin-left:75px;max-width:745px;cursor:default;" class="table table-hover">';
        $html.='<tr style="cursor:default;"><th>R&eacute;f&eacute;rence ville</th><th>Date ville</th><th>Rue</th><th>Num&eacute;ro</th></tr>';
        for($i=0;$i<$data['enCours'];$i++){
            $html.='<tr style="cursor:pointer;" onclick="window.location=\'index.php?component=domiciliation&action=goStep1&ref='.$data[$i]['idTable'].'\'">'
                    . '<td>'. $data[$i]['idAdmin'].'</td>'
                    . '<td>'.$this->dateFr($data[$i]['date_ville']).'</td>'
                    . '<td>'.$data[$i]['rue'].'</td>'
                    . '<td>'.$data[$i]['numero'].' '.$data[$i]['boite'].'</td>'
                    . '</tr>';
        }
        $html.='</table></div>';
    }
    
    //Commenté le 23-10-2017 car mise en place d'un nouveau formulaire reprenant les données adresses de la demande
    
    /*$html.='<p class="boutonC85">Nouvelle domiciliation</p>'
            . '<form style="margin-left:10%;" class="form-horizontal" name="infosAdmin" method="POST" action="?component=domiciliation&action=newDomicile">'
            . ' <div class="form-group">'
            . ' <label for="date" class="col-sm-2" control-label" style="width:250px;">Date demande ville</label>'
            . '     <div class="col-sm-3">'
            . '         <input type="date" class="form-control" name="date" id="date" placeHolder="Date demande" required>'
            . '     </div>'
            . ' </div>'
            . ' <div class="form-group">'
            . ' <label for="number" class="col-sm-2" control-label" style="width:250px;">Num&eacute;ro demande ville</label>'
            . '     <div class="col-sm-3">'
            . '         <input type="text" class="form-control" name="number" id="number" placeHolder="Num&eacute;ro demande" required>'
            . '     </div>'
            . ' </div>'
            . ' <div class="form-group">'
            . '<div class="col-sm-offset-2 col-sm-3">'
            . ' <button type="submit" class="btn btn-primary btn-block btn-large">Enregistrer</button>'
            . '</div>'
            . '</form>';*/
    
    //NOUVEAU FORMULAIRE AVEC ADRESSE NOUVELLE DEMANDE
    //Besoin de la liste des rues --> récupération depuis paramètre rues
    //Besoin de la liste des quartiers en rapport avec l'utilisateur
    $html.='<p class="boutonC85" onclick="slide(\'NewDos\');" style="cursor:pointer;">Nouvelle domiciliation</p>';
    $html.='<div id="NewDos" style="display:none;">'
            . '<form method="POST" action="?component=domiciliation&action=newDomicile">'
            . '<table class="table table-hover" style="margin-left:75px;max-width:745px;cursor:default;">'
            . '<tr><th style="width:175px;">Date dossier ville</th><td><input type="date" class="form-control" name="date" id="date" autofocus required></td></tr>'
            . '<tr><th>R&eacute;f&eacute;rence ville</th><td><input type="text" class="form-control" name="numVille" id="numVille" required></td></tr>';
    /*  Modification en vue d'introduire l'adresse, quelle que soit l'adresse -- Suppression des filtres "quartier lié" à l'utilisateur
     * Il sera ainsi possible de vérifer en BDD si l'habitation est déjà existante et de l'ajouter si nécessaire.*/
     
    $html.='<tr><th>Code postal</th><td><input type="text" class="form-control" id="CP" name="CP" placeHolder="CP" onkeyup="getVilleByCP();" required></td></tr>';
    $html.='<tr><th>Ville</th><td><div id="inputVille"><input disabled type="text" class="form-control" name="Ville" id="Ville" placeHolder="Ville"></div></td></tr>';
    $html.='<tr><th>Rue</th><td><div id="inputRue"><input type="text" class="form-control" name="Street" id="Street" placeHolder="Rue"></div></td></tr>';
    $html.='<tr><th>Num&eacute;ro</th><td><input type="text" class="form-control" name="Number" id="Number" placeHolder="N°" required></td></tr>';
    $html.='<tr><th>Bo&icirc;te</th><td><input type="text" class="form-control" name="Bte" id="Bte" placeHolder="Bo&icirc;te"></td></tr>';
    
    /*. '<tr><th>Quartier concern&eacute;</th>';
    //Un seul quartier correspondant pour la personne connectée
    if($quartiersByUser['size']=='1'){
        $html.='<td><input type="text" class="form-control" name="nomQuartier" id="nomQuartier" readonly value="';
        $html.=$quartiersByUser['denomination'].'"><input type="hidden" name="idQuartier" id="idQuartier" value="'.$quartiersByUser['id_quartier'].'"></td>';
        $html.='</tr><tr><th>Rue concern&eacute;e</th><td><select class="form-control" name="idRue" id="idRue">';
        foreach($quartiersByUser['rues'] as $rowq){
            $html.='<option value="'.$rowq['IdRue'].'">'.$rowq['NomRue'].' - C&ocirc;t&eacute; ';
            $html.=($rowq['cote']=='P')?'pair':'impair';
            $html.=', de '.$rowq['limiteBas'].' &agrave; '.$rowq['limiteHaut'].'</option>';
        }
        $html.='</select></td></tr>';
    }
    //Plus d'un quartier
    else{
        $html.='<td><select class="form-control" name="idQuartier" id="idQuartier" onchange="getSelectRuesByIdQ(\''.$_SESSION['acces'].'\',\''.$_SESSION['idUser'].'\');"><option value="-1"></option>';
        foreach($quartiersByUser['quartiers'] as $row){
            $html.='<option value="'.$row['id_quartier'].'">'.$row['denomination'].'</option>';
        }
        $html.='</select></td></tr>';
        $html.='<tr><th>Rue concern&eacute;e</th><td id="divRuesByQ"><input type="text" disabled class="form-control" value="Veuillez choisir un quartier"></td></tr>';
    }
    $html.='<tr><th>Num&eacute;ro d\'habitation</th><td><input type="text" class="form-control" id="numHab" name="numHab" required></td></tr>';
    $html.='<tr><th>Bo&icirc;te</th><td><input type="text" class="form-control" id="boiteNumHab" name="boiteNumHab"></td></tr>';*/
    $html.='<tr><td colspan="2"><p id="bVerifAdresse" class="boutonC45" style="cursor:pointer;" onclick="verifAdress(\''.$_SESSION['idUser'].'\');">V&eacute;rifier adresse</p></td></tr>';
    $html.='<tr><td colspan="2" id="bRecNewDom" style="display:none;"><button type="submit" class="btn btn-primary btn-block btn-large">Enregistrer</button></td></tr>'
            . '</table>'
            . '</form></div>';
    $html.='<div id="result"></div>';
    $this->appli->content=$html;
}
public function menuNewDomicileStep1(){
    $html='<p class="boutonC85">Menu administration - Domiciliation</p>'
            . '<p class="boutonC45">Adresse</p>'
            . '<form class="form-horizontal" name"menuNewDomicileStep1" action="?component=domiciliation&action=recStep1" method="POST">'
            . '<div class="form-group">'
            . '    <label for="CP" class="col-sm-2 control-label">CP</label>'
            . '    <div class="col-sm-2">'
            . '    <input type="text" class="form-control" id="CP" name="CP" placeHolder="CP" onkeyup="getVilleByCP();" onfocusout="resetLocataire();" autofocus required>'
            . '    </div>'            
            . '    <label for="Ville" class="col-sm-2 control-label">Ville</label>'
            . '    <div class="col-sm-5">'
            . '    <div id="inputVille"><input disabled type="text" class="form-control" name="City" id="Ville" placeHolder="Ville"></div>'
            . '    </div>'           
            . ' </div>'
            . ' <div class="form-group">'
            . '    <label for="Rue" class="col-sm-2 control-label">Rue</label>'
            . '    <div class="col-sm-5">'
            . '    <div id="inputRue"><input type="text" class="form-control" name="Street" id="Street" placeHolder="Rue" onfocusout="resetLocataire();"></div>'
            . '    </div>'            
            . '    <label for="Number" class="col-sm-1 control-label">N°</label>'
            . '    <div class="col-sm-1">'
            . '    <input type="text" class="form-control" name="Number" id="Number" placeHolder="N°" onfocusout="resetLocataire();" required>'
            . '    </div>'           
            . '    '
            . '    <div class="col-sm-2">'
            . '    <input type="text" class="form-control" name="Bte" id="Bte"  onfocusout="verifAdress(\''.$_SESSION['idUser'].'\');" placeHolder="Bo&icirc;te">'
            . '    </div>'           
            . '</div>'
            . '<div class="form-group">'
            . '    <label for="Fixe" class="col-sm-2 control-label">T&eacute;l fixe</label>'
            . '    <div class="col-sm-5">'
            . '    <input type="tel" class="form-control" name="Fixe" id="Fixe" placeHolder="T&eacute;l&eacute;phone fixe">'
            . '    </div>'           
            . '</div>'
            . '<p class="boutonC45">Identit&eacute du chef de m&eacute;nage</p>'
            . '<div class="form-group">'
            . '    <label for="Name" class="col-sm-2 control-label">Nom</label>'
            . '    <div class="col-sm-3">'
            . '    <input type="text" class="form-control" name="Name" id="Name" placeHolder="Nom" required>'
            . '    </div>'            
            . '    <label for="Surname" class="col-sm-2 control-label">Pr&eacute;nom</label>'
            . '    <div class="col-sm-4">'
            . '    <input type="text" class="form-control" name="Surname" id="Surname" placeHolder="Pr&eacute;nom" required>'
            . '    </div>'           
            . '</div>'
            . '<div class="form-group">'
            . '    <label for="Birth" class="col-sm-2 control-label">N&eacute;(e) le</label>'
            . '    <div class="col-sm-3">'
            . '    <input type="date" class="form-control" name="birth" id="Birth" required onfocusOut="verifCitizenExists(\''.$_SESSION['idUser'].'\');">'
            . '    </div>'            
            . '    <label for="GSM" class="col-sm-2 control-label">GSM</label>'
            . '    <div class="col-sm-4">'
            . '    <input type="tel" class="form-control" name="GSM" id="GSM" placeHolder="GSM (ex : 32475112233)">'
            . '    </div>'           
            . '</div>'
            . '<div class="form-group">'
            . '    <label for="Profession" class="col-sm-2 control-label">Profession</label>'
            . '    <div class="col-sm-9">'
            . '    <input type="tel" class="form-control" name="Job" id="Profession" placeHolder="Profession">'
            . '    </div>'
            . '</div>'
            . '<div class="form-group">'
            . '    <label for="Empl" class="col-sm-2 control-label">Employeur</label>'
            . '    <div class="col-sm-3">'
            . '    <input type="tel" class="form-control" name="Empl" id="Empl" placeHolder="Employeur">'
            . '    </div>'
            . '    <label for="EmplCont" class="col-sm-2 control-label">Contact</label>'
            . '    <div class="col-sm-4">'
            . '    <input type="tel" class="form-control" name="EmplCont" id="EmplCont" placeHolder="Contact">'
            . '    </div>'  
            . '</div>'
            . '<div class="form-group">'
            . '     <label for="locataire" class="col-sm-2 control-label">Locataire</label>'
            . '     <div class="col-sm-9">'
            . '         <div class="radio">'
            . '              <label class="labelPY">'
            . '              <input type="radio" id="locataire" name="locataire" value="O" required onclick="verifProp(\''.$_SESSION['idUser'].'\');">'
            . '              Oui'
            . '              </label>&nbsp;&nbsp;&nbsp;'
            . '              <label class="labelPN">'
            . '              <input type="radio" id="locataire" name="locataire" value="N" required onclick="verifProp(\''.$_SESSION['idUser'].'\');">'
            . '              Non'
            . '              </label>'
            . '         </div>' 
            . '     </div>'            
            . '</div>'
            . '<center>'
            . '<input class="bMenu2" src="./media/icons/bSave.jpg" type="image" align="center">'
            . '<img class="bMenu2" src="./media/icons/bVfiche.jpg" onclick="nonprog();">'
            . '</center>'
            . '</form>';
    $this->appli->content=$html;
}

}
?>