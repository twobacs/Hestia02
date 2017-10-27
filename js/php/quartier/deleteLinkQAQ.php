<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
include('../autoload.php');
$idLinkQA=\filter_input(INPUT_GET,'idLinkQA');
$sql='DELETE FROM z_agent_quartier WHERE id=:idLink';
$req=$pdo->prepare($sql);
$req->bindValue('idLink',$idLinkQA, PDO::PARAM_INT);
$req->execute();
echo $req->rowcount();