<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

include('../autoload.php');

$city=\filter_input(INPUT_GET, 'city');
$street=\filter_input(INPUT_GET, 'street');
$number=\filter_input(INPUT_GET, 'number');
$box=\filter_input(INPUT_GET, 'box');
$boxV=($box=='-1')?null:$box;
//echo $boxV;
if(isset($city)){
    $req=$pdoH->prepare('INSERT INTO Hestia_Batiment (id_commune, id_rue, Numero, Boite) VALUES (:city, :street, :number, :box)');
    $req->bindValue('city',$city,  PDO::PARAM_INT);
    $req->bindValue('street',$street,  PDO::PARAM_INT);
    $req->bindValue('number',$number,  PDO::PARAM_STR);
    $req->bindValue('box',$boxV,  PDO::PARAM_STR);
    $req->execute();
    echo $req->rowCount();
}