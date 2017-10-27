/*
 * Créé par De Backer Jeremy - Police de Mouscron
 * Contact : debacker.jeremy@policemouscron.be
 */

function nonprog(){
    alert('Cette fonction n\'est pas encore programmée');
}

function slide(part){
    var display=($('#'+part).css('display'));
    if(display==='block'){
        $('#'+part).hide(1000);
    }
    else{
        $('#'+part).slideToggle(500);
    }
}

function getFormAddDateRef(user){
    $.ajax({
        type:"GET",
        url:"js/php/fiche/formNewDom.php",
        data:{
            user:user
        },
        success:function(retour){
            showOnlyResult(retour);
        }
    });
}

/*function getVilleByCP(idOwner){
    alert (idOwner);
}*/

function getVilleByCP(idOwner){
    if(typeof idOwner=="undefined"){
        var CP=document.getElementById("CP").value;
        if(CP.length>3){
        $.ajax(
                {
                type: "GET",
                url: "js/php/ville/getVilleByCP.php",
                data:
                        {
                        CP : CP
                        },
                success:function(retour){document.getElementById('inputVille').innerHTML=retour;}
                });
        }
        if((CP==='7700')||(CP==='7711')||(CP==='7712')){
            $.ajax(
                {
                type: "GET",
                url: "js/php/ville/getRuesMsc.php",
                data:
                        {
                        CP : CP
                        },
                success:function(retour){document.getElementById('inputRue').innerHTML=retour;}
                });
        }
        else{
            document.getElementById('inputVille').innerHTML='<input disabled type="text" class="form-control" id="Ville" placeHolder="Ville">';
            document.getElementById('inputRue').innerHTML='<input type="text" class="form-control" id="Rue" placeHolder="Rue">';
        }
    }
    else{
        var Country=document.getElementById('Pays_'+idOwner).value;
        if (Country==='Belgique'){
        var CP=document.getElementById("CP_"+idOwner).value;
        if(CP.length>3){
        $.ajax(
                {
                type: "GET",
                url: "js/php/ville/getVilleByCP.php",
                data:
                        {
                        CP : CP,
                        idOwner : idOwner
                        },
                success:function(retour){document.getElementById('NCity_'+idOwner).innerHTML=retour;}
                });
        }
        if((CP==='7700')||(CP==='7711')||(CP==='7712')){
            $.ajax(
                {
                type: "GET",
                url: "js/php/ville/getRuesMsc.php",
                data:
                        {
                        CP : CP,
                        idOwner : idOwner
                        },
                success:function(retour){document.getElementById('NStreet_'+idOwner).innerHTML=retour;}
                });
        }
        else{
            document.getElementById('NCity_'+idOwner).innerHTML='<input disabled type="text" class="form-control" name="City_'+idOwner+'" id="City_'+idOwner+'" placeHolder="Ville">';
            document.getElementById('NStreet_'+idOwner).innerHTML='<input type="text" class="form-control" name="Street_'+idOwner+'" id="Street_'+idOwner+'" placeHolder="Rue">';
            document.getElementById('Number_'+idOwner).disabled=false;
            document.getElementById('Box_'+idOwner).disabled=false;
        }
    }
    else{
        document.getElementById('City_'+idOwner).disabled=false;
        document.getElementById('Street_'+idOwner).disabled=false;
        document.getElementById('Number_'+idOwner).disabled=false;
        document.getElementById('Box_'+idOwner).disabled=false;
    }
    }
}
function addOwnerToBat(idBat,idUser){
    addToHisto(idUser, 'Ajout propriétaire à une habitation', '', 'Batiment', 'id', idBat);
    var nom=document.getElementById('Nom_').value;
    var prenom=document.getElementById('Prenom_').value;
    var gsm=document.getElementById('GSM_').value;
    var country=document.getElementById('Pays_').value;
    var CP=document.getElementById('CP_').value;
    var Nb=document.getElementById('Number_').value;
    var box=document.getElementById('Box_').value;
    //alert(country);
    if((country=='Belgique')&&((CP=='7700')||(CP=='7711')||(CP=='7712'))){
        var city=document.getElementById("Ville").value;
        //var city=temp.options[temp.selectedIndex].value;
        var temp=document.getElementById("Street");
        var rue=temp.options[temp.selectedIndex].innerHTML;
    }
    else if(country=='Belgique'){
        var temp=document.getElementById("Ville");
        var city=temp.options[temp.selectedIndex].innerHTML;
        var rue=document.getElementById('Street_').value;
    }

    $.ajax({
        type:"GET",
        url:'js/php/adresse/addOwnerToBat.php',
        data:{
            idBat:idBat,
            idUser:idUser,
            Nom:nom,
            Prenom:prenom,
            GSM:gsm,
            Pays:country,
            CP:CP,
            Num:Nb,
            Bte:box,
            Ville:city,
            Rue:rue
        },
        success:function(retour){
            if(retour=='1'){
                verifProp(idUser);
            }
        }
    });
}
function verifAdress(user){
        //resetLocataire();
        if(!!document.getElementById("CP").value || !!document.getElementById("Street")){
        var CP=document.getElementById("CP").value;
        var Street=document.getElementById("Street");
        var selectedStreetId=Street.options[Street.selectedIndex].value;
        var number=document.getElementById("Number").value;
        var boite=document.getElementById("Bte").value;
        var city=document.getElementById("Ville").value;
        //alert(city);
        if(selectedStreetId!=='-1'){
            $.ajax({
                type:"GET",
                url:"js/php/adresse/verifRegisteredByAdress.php",
                data:{
                    idStreet:selectedStreetId,
                    zipCode:CP,
                    number:number,
                    city:city,
                    box:boite,
                    user:user
                },
                success:function(retour){
                    if(retour!=='nobody'){
                        document.getElementById('result').innerHTML=retour;
                        showOnlyResult();
                    }
                    else{
                        hideResult();
                    }
                },
                error:function(){alert('Une erreur s\'est produite');}
            });
        }
    }
}

function showOnlyResult(){
    document.getElementById('result').style.display='block';
    document.getElementById('result').style.visibility='visible';
    document.getElementById('menu').style.visibility='hidden';
    document.getElementById('main').style.visibility='hidden';
}

function hideResult(){
    document.getElementById('result').style.display='none';
    document.getElementById('menu').style.visibility='visible';
    document.getElementById('main').style.visibility='visible';
}

function delRelationCitizenHouse(idPB,user,action){
    var ok=confirm('Etes-vous sûr de vouloir effacer cette liaison ?');
    if(ok){
        $.ajax({
            type:"GET",
            url:"js/php/adresse/delRelationCitizenHouse.php",
            data:{
                idPB:idPB,
                user:user
            },
        success:function(retour){
            if(retour==='1')verifAdress(user);
            else alert('Une erreur s\'est produite');
            }
        });
    }
    else alert('Opération abandonnée');
    if(action==='1'){
        hideResult();
    }
}

function verifCitizenExists(idUser){
    var name=document.getElementById('Name').value;
    var surname=document.getElementById('Surname').value;
    var birth=document.getElementById('Birth').value;
    data=new Array();
    $.ajax({
        type:"GET",
        url:"js/php/personne/verifCitizenExists.php",
        data:{
            name:name,
            surname:surname,
            birth:birth
        },
        success:function(msg){
           data=msg;
           document.getElementById('GSM').value=data["mobile"];
           document.getElementById('Profession').value=data["profession"];
           if(data["employeur"]!==undefined)document.getElementById('Empl').value=data["employeur"];
           if(data["TelEmp"]!==undefined)document.getElementById('EmplCont').value=data["TelEmp"];
           if(data["mobile"]!==''){
               document.getElementById('Profession').focus();
           }
           if(data["oldZip"]!==undefined){
               $.ajax({
                  type:"GET",
                  url:"js/php/personne/showOldAddress.php",
                  data:{
                      oldZip:data["oldZip"],
                      oldCity:data["oldCity"],
                      oldNumber:data["oldNumber"],
                      oldStreet:data["oldStreet"],
                      dateIn:data["DateIn"],
                      idPersBat:data["idPersBat"],
                      idUser:idUser
                  },
                  success:function(retour){
                    document.getElementById('result').innerHTML=retour;
                    showOnlyResult();
                  }
               });
           }
        },
        dataType:"json"
    });
}

function CreateNewHouse(idCity,idStreet,number,box){
    $.ajax({
        type:"GET",
        url:"js/php/adresse/createNewHouse.php",
        data:{
            city:idCity,
            street:idStreet,
            number:number,
            box:box
        },
        success:function(retour){
            if(retour==='1'){
                alert('Enregistrement de nouveau bâtiment effectué');
                hideResult();
            }
            else{
                alert('Une erreur s\'est produite');
            }
        }
    });
}

function verifProp(user){
   // alert(user);
    if(!!document.getElementById("CP").value || !!document.getElementById("Street")){
        var CP=document.getElementById("CP").value;
        var Street=document.getElementById("Street");
        var selectedStreetId=Street.options[Street.selectedIndex].value;
        var number=document.getElementById("Number").value;
        var boite=document.getElementById("Bte").value;
        var city=document.getElementById("Ville").value;
        if(selectedStreetId!=='-1'){
            $.ajax({
                type:"GET",
                url:"js/php/adresse/verifProp.php",
                data:{
                    CP:CP,
                    selectedStreetId:selectedStreetId,
                    number:number,
                    boite:boite,
                    city:city,
                    idUser:user
                },
                success:function(retour){
                    //alert(retour);
                    document.getElementById('result').innerHTML=retour;
                    showOnlyResult();
                }
            });
        }
    }
    else(alert('Veuillez compléter les données de l\'adresse'));
}

function formAddOwner(idBat,idUser){
    addToHisto(idUser,'Ouverture de la fiche ajout propriétaire à une habitation','idBat : '+idBat,'Batiments','id',idBat);
    $.ajax({
        type:"GET",
        url:"js/php/adresse/formAddOwner.php",
        data:{idBat:idBat,user:idUser},
        success:function(retour){document.getElementById('formAddOwner').innerHTML=retour;}
    });
}

function resetLocataire(){
    radiobtn = document.getElementById("locataire");
    //alert(radiobtn);
   if(radiobtn!=='null'){radiobtn.checked = false;}
}

function delRelationOwnerHouse(idBat,idOldOwner,idUser,from){
    var ok=confirm('Etes-vous sûr de vouloir supprimer cette liaison ?');
    if(ok){
        $.ajax({
            type:"GET",
            url:"js/php/adresse/delRelationOwnerHouse.php",
            data:{
                idBat:idBat,
                idOldOwner:idOldOwner,
                idUser:idUser,
                from:from
            },
            success:function(retour){
                if(retour==='1'){
                    //document.getElementById('result').style.display='none';
                    //tempAlert("<h2>Enregistrement en cours</h2>",1500);
                    verifProp(idUser);
                }
                else alert("Une erreur s'est produite");
            }
        });
    }
}

function editProp(idProp,user){
    $.ajax({
        type:"GET",
        url:"js/php/personne/editProp.php",
        data:{
            idOwner:idProp,
            idUser:user
        },
        success:function(retour){
            document.getElementById('result').innerHTML=retour;
            showOnlyResult();}
    });
}

function tempAlert(msg,duration){
    var el = document.createElement("div");
    el.setAttribute("style","position:absolute;top:50%;left:35%;background-color:white;");
    el.innerHTML = msg;
    setTimeout(function(){
        document.getElementById('result').style.display='none';
        hideResult();
        el.parentNode.removeChild(el);
    },duration);

    document.body.appendChild(el);
}

function recordModifOwner(owner){
    var newPhone=document.getElementById("newPhone").value;
    var newMobile=document.getElementById("newMobile").value;
    $.ajax({
        type:"GET",
        url:"js/php/personne/updatePers.php",
        data:{
            newPhone:newPhone,
            newMobile:newMobile,
            id:owner
        },
        success:function(retour){
            alert(retour);
        }
    });
}

function saveModifOwner(idOwner){
    var name=document.getElementById("Nom_"+idOwner).value;
    var firstName=document.getElementById("Prenom_"+idOwner).value;
    var mobile=document.getElementById("GSM_"+idOwner).value;
    var zip=document.getElementById("CP_"+idOwner).value;
    var city=document.getElementById("City_"+idOwner).value;
    var street=document.getElementById("Street_"+idOwner).value;
    var number=document.getElementById("Number_"+idOwner).value;
    var box=document.getElementById("Box_"+idOwner).value;
    $.ajax({
        type:"GET",
        url:"js/php/personne/updateOwner.php",
        data:{
            name:name,
            firstName:firstName,
            mobile:mobile,
            zip:zip,
            city:city,
            street:street,
            number:number,
            box:box,
            owner:idOwner
        },
        success:function(retour){
            if(retour==='1'){
               alert('Les modifications ont été correctement enregistrées.');
            }
            else{
                alert('Une erreur s\'est produite, veuillez en avertir le service informatique.');
            }
        }

    });
}

function gestUsers(acces,idUser){
    $.ajax({
        type:"GET",
        url:"js/php/gestion/gestUsers.php",
        data:{
            acces:acces,
            idUser:idUser
        },
        success:function(retour){
            document.getElementById('Gestplateforme').innerHTML=retour;
        }
    });
}

function gestAcces(acces){
    $.ajax({
        type:"GET",
        url:"js/php/gestion/gestAcces.php",
        data:{
            acces:acces
        },
        success:function(retour){
            document.getElementById('Gestplateforme').innerHTML=retour;
        }
    });
}

function addUser(acces,idUser){
    $.ajax({
        type:"GET",
        url:"js/php/gestion/addUser.php",
        data:{
            acces:acces,
            idUser:idUser
        },
        success:function(retour){
            document.getElementById('Gestplateforme').innerHTML=retour;
        }
    });
}

function editUserHestia(idUser){
    window.open('index.php?component=user&action=formEditUser&user='+idUser+'','Edition d\'un utilisateur','menubar=no, location=0, scrollbars=no, top=100, left=100, width=800, height=775');
}

function editThis(name){
    document.getElementById(name).readOnly=false;
    document.getElementById(name).focus();
}

function attribDroits(niv,idUser){
    $.ajax({
       type:"GET",
       url:"js/php/gestion/attribDroits.php",
       data:{
           niv:niv,
           idUser:idUser
       },
       success:function(retour){
           if(retour==='1'){
               gestAcces('15');
           }
       }
    });
}

function gestAntennes(acces,user){
    addToHisto(user, 'Accès gestion antennes');
    if(acces<'10'){
        alert('Vous n\'avez pas les accès requis pour accéder à ceci.');
    }
    else{
        $.ajax({
            type:"GET",
            url:"js/php/quartier/gestionAntennes.php",
            data:{acces:acces,user:user},
            success:function(retour){document.getElementById('Gestplateforme').innerHTML=retour;}
        });
    }
}

function addToHisto(user, component, action, ftable, typeA, fkey){
    if(typeof(user)==='undefined'){user='-1';}
    if(typeof(component)==='undefined'){component='NC';}
    if(typeof(action)==='undefined'){action='-';}
    if(typeof(ftable)==='undefined'){ftable='-';}
    if(typeof(typeA)==='undefined'){typeA='-';}
    if(typeof(fkey)==='undefined'){fkey='-';}
    var url = location.pathname+location.search;
   $.ajax({
       type:"GET",
       url:"js/php/addToHisto.php",
       data:{
           user : user,
           component:component,
           action: action,
           table:ftable,
           typeA:typeA,
           fkey:fkey,
           url:url
       }
       //success:function(retour){alert(retour);}
   });
}

function verifPersExistsAddPersToBat(idBat,idUser){
    var nom=document.getElementById("Nom_").value;
    var prenom=document.getElementById("Prenom_").value;
    $.ajax({
        type:"GET",
        url:"js/php/personne/verifPersExistsAddPersToBat.php",
        data:{
            Nom:nom,
            Prenom:prenom,
            idBat:idBat,
            idUser:idUser
        },
        success:function(retour){document.getElementById('PersExists').innerHTML=retour;}
    });
}

function addExistsOwnerToBat(idBat,idUser,idPers){
    $.ajax({
        type:"GET",
        url:"js/php/adresse/addOwnerByIds.php",
        data:{
            idBat:idBat,
            idUser:idUser,
            idPers:idPers
        },
        success:function(retour){if(retour=='1'){verifProp(idBat);}}
    });
}

function getFormEditAntenne(idAntenne,acces,user){
    $.ajax({
        type:"GET",
        url:"js/php/quartier/formModifAntenne.php",
        data:{idAntenne:idAntenne, acces:acces, user:user},
        success:function(retour){document.getElementById('antenne'+idAntenne).innerHTML=retour;}
    });
}

function recordEditAntenne(idAntenne,acces,user){
  var temp=document.getElementById("rue");
  var rue=temp.options[temp.selectedIndex].value;
  var num=document.getElementById("newNum").value;
  var temp=document.getElementById("user");
  var resp=temp.options[temp.selectedIndex].value;
  var tel=document.getElementById("newTel").value;
  var fax=document.getElementById("newFax").value;
  $.ajax({
      type:"GET",
      url:"js/php/quartier/recordEditAntenne.php",
      data:{
        idAntenne:idAntenne,
        acces:acces,
        user:user,
        num:num,
        resp:resp,
        rue:rue,
        tel:tel,
        fax:fax
      },
      success:function(retour){
          //if (retour=='1'){
            gestAntennes(acces,user);
            //alert(retour);
          //}
      }
  });
}

function getFormLinkQuAnt(idAntenne,acces,user){
  $.ajax({
      type:"GET",
      url:"js/php/quartier/getFormLinkQuAnt.php",
      data:{idAntenne:idAntenne, acces:acces, user:user},
      success:function(retour){document.getElementById('antenne'+idAntenne).innerHTML=retour;}
  });
}

function getFormEditQuartierById(idQuartier, acces, user){
    $.ajax({
        type:"GET",
        url:"js/php/quartier/getFormEditQuartierById.php",
        data:{
            idQuartier : idQuartier,
            acces : acces,
            user : user
        },
        success:function(retour){alert(retour);}
        
    });
}

function delLinkQuAnt(idAntenne, idQuartier, acces, user){
    var ok=confirm("Êtes-vous sûr de vouloir supprimer cette liaison ?");
    if(ok){
        $.ajax({
            type:"GET",
            url:"js/php/quartier/delLinkQuAnt.php",
            data:{idAntenne:idAntenne, idQuartier:idQuartier, acces:acces, user:user},
            success:function(retour){
                if(retour=='1'){
                    getFormLinkQuAnt(idAntenne,acces,user);
                }
            }
        });
    }
}

function getFormAddAntToQuart(idAntenne, acces, user){
    $.ajax({
        type:"GET",
        url:"js/php/quartier/getFormAddAntToQuart.php",
        data:{idAntenne:idAntenne, acces:acces, user:user},
        success:function(retour){document.getElementById("placeToAddAntToQuart_"+idAntenne).innerHTML=retour;}
    });
    
}

function addLinkAntQuart(idAntenne,idQuartier,acces,user){
    $.ajax({
        type:"GET",
        url:"js/php/quartier/addLinkAntQuart.php",
        data:{idAntenne:idAntenne, idQuartier:idQuartier, acces:acces, user:user},
        success:function(retour){if(retour==='1'){gestAntennes(acces,user);}}
    });
}

function gestRues(acces,user){
    addToHisto(user, 'Accès gestion des rues');
    if(acces<'10'){
        alert('Vous n\'avez pas les accès requis pour accéder à ceci.');
    }
    else{
        $.ajax({
            type:"GET",
            url:"js/php/quartier/gestionRues.php",
            data:{acces:acces,user:user},
            success:function(retour){document.getElementById('Gestplateforme').innerHTML=retour;}
        });
    }
}

function searchRue(){
    var search=document.getElementById('searchRue').value;
    $.ajax({
      type:"GET",
      url:"js/php/quartier/searchRue.php",
      data:{
          search:search
      },
      success:function(retour){
          document.getElementById('resultSearch').innerHTML=retour;
      }
    });
}

function editStreet(idStreet){
    $.ajax({
        type:"GET",
        url:"js/php/quartier/getFormEditStreetById.php",
        data:{idStreet:idStreet},
        success:function(retour){document.getElementById("IdStreetN"+idStreet).innerHTML=retour;}
    });
}

function editStreetFromSelectedStreet(){
    var temp=document.getElementById("ExistStreets");
    var idStreet=temp.options[temp.selectedIndex].value;
    $.ajax({
        type:"GET",
        url:"js/php/quartier/getFormEditStreetById.php",
        data:{idStreet:idStreet},
        success:function(retour){document.getElementById("resultSearch").innerHTML="<div class=\"table-reponsive\"><table class=\"table table-hover\" style=\"margin-left:75px;max-width:745px;cursor:default;\"><tr><th colspan=\"3\" style=\"text-align:center;\">R&eacute;sultat(s)</th></tr><tr id=\"IdStreetN"+idStreet+"\">"+retour+"</table></div>";}
    });
}

function RecEditStreet(idStreet){
    var nom=document.getElementById("newNom"+idStreet).value;
    var naam=document.getElementById("newNaam"+idStreet).value;
    $.ajax({
        type:"GET",url:"js/php/quartier/RecEditStreet.php",
        data:{idStreet:idStreet,nom:nom,naam:naam},
        success:function(){document.getElementById("searchRue").value=nom.toUpperCase();searchRue();}
    });
}

function couplagesRQ(acces,user){
     addToHisto(user, 'Accès couplage rues - quartier');
     $.ajax({
         type:"GET",
         url:"js/php/quartier/couplagesRQ.php",
         data:{acces:acces,user:user},
         success:function(retour){document.getElementById("Gestplateforme").innerHTML=retour;}
     });
}

function searchRueQRSelect(idStreet){
    var idStreet=(typeof idStreet === 'undefined') ? idStreet = -1 : idStreet;
    if(idStreet===-1){
        var temp=document.getElementById("selectStreet");
        var rue=temp.options[temp.selectedIndex].value;
    }
    else{
        var rue=idStreet;
    }
    QRSearchRue(rue);
}

function searchRueQRText(){
    var rue=document.getElementById("searchRue").value;
    QRSearchRue(rue);
}

function QRSearchRue(rue){
    $.ajax({
        type:"GET",url:"js/php/quartier/QRSearchRue.php",
        data:{rue:rue},
        success:function(retour){document.getElementById("resultSearch").innerHTML=retour;}
    });    
}

function modifDecoupe(idrue){
    $.ajax({
        type:"GET",url:"js/php/quartier/modifDecoupe.php",
        data:{IdRue:idrue},
        success:function(retour){document.getElementById("resultSearch").innerHTML=retour;}
    });
}
function modifLimite(side,idStreet,cote,row,idRowLink){
    var value=document.getElementById("row"+row+cote+side).value;
    var verif = value % 2;
    if(cote==='I'){
        if (verif===1){var ok=true;}
        else {var ok=false;}
    }
    else if (cote==='P'){
        if (verif===0){var ok=true;}
        else {var ok=false;}
    }
    if(ok===false){
        alert ('La valeur choisie n\'est pas correcte. (Vérifiez pair / impair)');
    }
    else{
        $.ajax({
            type:"GET",
            url:"js/php/quartier/modifLimite.php",
            data:{
                side:side,
                idStreet:idStreet,
                cote:cote,
                row:row,
                idRowLink:idRowLink,
                value:value
            }
            //success:function(retour){if(retour!='0'){alert(retour);}}
        });
    }
}

function delRowLinkStreetQuartier(idLink,idStreet){
    var ok=confirm('Etes-vous sûr de vouloir supprimer cette découpe ?');
    if(ok){
        $.ajax({
            url:"js/php/quartier/delRowLinkStreetQuartier.php",
            type:"GET",
            data:{
                idLink:idLink
            }
        });
        //modifDecoupe(idStreet);
        searchRueQRSelect(idStreet);
    }
}

function addPortion(IdRue){
    $.ajax({
        type:"GET",
        url:"js/php/quartier/formAddPortion.php",
        data:{IdRue:IdRue},
        success:function(retour){document.getElementById("zoneAddPortion").innerHTML=retour;},
    });
    
}

function addNewPortion(idStreet){
//Vérifier la complétude de chaque champ
    var ok = true;
    var msg='';
    var limiteBasse=document.getElementById("newDownLimit").value;
    var limiteHaute=document.getElementById("newHighLimit").value;
    if (limiteBasse===''){
        msg=msg.concat('La limite basse n\'a pas été complétée.\n');
        var ok = false;
    }
    if (limiteHaute===''){
        msg=msg.concat('La limite haute n\'a pas été complétée.\n');
        var ok = false;
    }
//Si pas ok, message d'erreur
    if(ok===false){
        alert(msg);
    }    
//Si ok :
    else{
    //Récupérer la valeur choisie dans le select pair / impair
    var side=document.getElementById("sideNewPortion").value;
    //En fonction de cette valeur, vérifier la correspondance avec les valeurs introduites
    var verifLB=limiteBasse % 2;
    var verifLH=limiteHaute % 2;
    if(side==='P'){
        if(verifLB===0){
            var okLB = true;
        }
        else{
            var okLB = false;
            msg=msg.concat('La limite basse n\'est pas un nombre pair.\n');
        }
        if(verifLH===0){
            var okLH = true;
        }
        else{
            var okLH = false;
            msg=msg.concat('La limite haute n\'est pas un nombre pair.\n');
        }
    }    
    if(side==='I'){
        if(verifLB!=0){
            var okLB = true;
        }
        else{
            var okLB = false;
            msg=msg.concat('La limite basse n\'est pas un nombre impair.\n');
        }
        if(verifLH!=0){
            var okLH = true;
        }
        else{
            var okLH = false;
            msg=msg.concat('La limite haute n\'est pas un nombre impair.\n');
        }
    //Si erreur, message
    }
    if(!okLB || !okLH){
        alert(msg);
    }
    //Si ok, vérifier que les valeurs introduites ne soient pas déjà comprises dans un intervalle existant
    else{
        $.ajax({
            type:"GET",
            url:"js/php/quartier/verifLimitNewSection.php",
            data:{
                side:side,
                limiteBasse:limiteBasse,
                limiteHaute:limiteHaute,
                idStreet:idStreet
            },
            success:function(retour){
                //alert(retour);
                if(retour==='D'){
                    alert('Les valeurs introduites font déjà partie d\'une autre section');
                }
                else if(retour==='B'){
                    alert('La limite basse introduite fait déjà partie d\'une autre section');
                }
                else if(retour==='H'){
                    alert('La limite haute introduite fait déjà partie d\'une autre section');
                }
                else if(retour==='1'){
                    var temp=document.getElementById("NewQ");
                    var newQ=temp.options[temp.selectedIndex].value;
                    //alert(newQ);
                    $.ajax({
                      type:"GET",
                      url:"js/php/quartier/insertNewSection.php",
                      data:{
                          idStreet:idStreet,
                          side:side,
                          limiteBasse:limiteBasse,
                          limiteHaute:limiteHaute,
                          newQ:newQ
                      },
                      success:function(retour){if(retour==='1'){searchRueQRSelect(idStreet);}}
                    });
                }
            }
        });
    }


//Si erreur, afficher message
//Si ok, enregistrement en base de données et rafraîchissemennt de la section "modifications possibles"
    }
}

function modifQuartierForSection(idRowQR,i){
    var quartier=document.getElementById("selectQuartier"+i).value;
    $.ajax({
        type:"GET",
        url:"js/php/quartier/modifQuartierForSection.php",
        data:{
            idRowQR:idRowQR,
            quartier:quartier
        }
    });
}

function AddNewStreet(acces,user){
    var FR = document.getElementById("nouvelleRue").value;
    var NL = document.getElementById("nieuweStraat").value;
    if(FR===''){
        alert ('Le nom de rue est obligatoire');
    }
    else{
        $.ajax({
            type:"GET",
            url:"js/php/quartier/AddNewStreet.php",
            data:{
                FR:FR,
                NL:NL
            },
            success:function(){
                alert('La rue a été correctement ajoutée');
                gestRues(acces,user);
            }
        });
    }
}

function couplagesAQ(acces,user){
    addToHisto(user, 'Accès couplage AQ - quartier');
    $.ajax({
        type:"GET",
        url:"js/php/quartier/formCouplagesAQ.php",
        data:{acces:acces,user:user},
        success:function(retour){document.getElementById("Gestplateforme").innerHTML=retour;}
    });
}

function deleteLinkQAQ(idLinkQA,acces,user){
    var ok=confirm('Etes-vous sûr de vouloir SUPPRIMER cette relation ?');
    if(ok){
        $.ajax({
            type:"GET",
            url:"js/php/quartier/deleteLinkQAQ.php",
            data:{idLinkQA:idLinkQA},
            success:function(retour){if(retour==='1'){couplagesAQ(acces,user);}}
        });
    }
}

function editLinkQAQ(idLinkQA,acces,user){
    $.ajax({
        type:"GET",
        url:"js/php/quartier/editLinkQAQ.php",
        data:{idLinkQA:idLinkQA,acces:acces,user:user},
        success:function(retour){document.getElementById("linkQA_"+idLinkQA).innerHTML=retour;}
    });
    
}

function modifLinkQAQ(idLinkQA,acces,user){
    var temp=document.getElementById("selectAQ");
    var newAQ=temp.options[temp.selectedIndex].value;
    $.ajax({
        type:"GET",
        url:"js/php/quartier/modifLinkQAQ.php",
        data:{idLinkQA:idLinkQA,acces:acces,user:user,newAQ:newAQ},
        success:function(retour){if(retour==='1'){couplagesAQ(acces,user);}}
    });
}

function addNewLinQAQ(acces,user){
    addToHisto(user, 'Ajout d\'une liaison Quartier - Agent');
    var temp=document.getElementById("selectedQuartier");
    var newQ=temp.options[temp.selectedIndex].value;
    var temp=document.getElementById("selectedUser");
    var newAQ=temp.options[temp.selectedIndex].value;
    $.ajax({
        type:"GET",
        url:"js/php/quartier/addNewLinQAQ.php",
        data:{
            acces:acces,
            users:user,
            newQ:newQ,
            newAQ:newAQ
        },
        success:function(retour){
            if(retour==="1"){
                alert('Enregistrement effectué avec succès');
                couplagesAQ(acces,user);
            }
            else{
                alert('Une erreur s\'est produite.  Veuillez contacter le service informatique si le problème persiste.');
            }
        }
    });
    
}

function getSelectRuesByIdQ(acces,user){
    var temp=document.getElementById("idQuartier");
    var Quart=temp.options[temp.selectedIndex].value;
    $.ajax({
        type:"GET",
        url:"js/php/quartier/getSelectRuesByIdQ.php",
        data:{Quart:Quart},
        success:function(retour){document.getElementById("divRuesByQ").innerHTML=retour;}
    });
    
}

function phonenumber(inputtxt,type)
{
  var test=document.getElementById(inputtxt).value;
  if(type==='FB'){
    var phoneno = /^\+?([0-9]{10})$/;
  }
  if(test.match(phoneno))
        {
            return true;
        }
      else
        {
            alert("Champ obligatoire, veuillez respecter le format \"+3256863000\"");
            document.getElementById(inputtxt).value='';
            return false;
        }
    }