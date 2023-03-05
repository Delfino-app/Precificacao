<?php

//Precificação de projetos usando técnica Markup

class Precificacao{

    private $valorBase;
    private $margemLucro;
    private $impostos;
    private $custosFixos;
    private $valorHora;

    function __construct($valorBase,$margemLucro,$impostos){

        $this->valorBase = $valorBase;
        $this->margemLucro = $margemLucro;
        $this->impostos = $impostos;
    }


    //1- Definindo dados de entrada
    function setValorHora($dias,$horas,$semanas = 4){

        $this->valorHora =  ($this->valorBase)/($dias*$horas*$semanas);
    }

    function getValorHora(){

        return $this->valorHora;
    }

    function setCustosFixos($aluguel,$internet,$alimentacao,$energia,$clientes){
        
        $this->custosFixos = ($aluguel + $internet + $alimentacao + $energia)/ $clientes;
    }

    function getCustosFixos(){

        return $this->custosFixos;
    }

    function precentual(){

        return (100-($this->margemLucro + $this->impostos)) / 100;
    }

    function precoTotal(){

        return ($this->valorBase + $this->getCustosFixos()) / $this->precentual();
    }


    function getResults(){

        $valorTotal = $this->precoTotal();

        $custos = $this->getCustosFixos();
        $impostos = ($valorTotal * $this->impostos) / 100;
        $lucro = ($valorTotal * $this->margemLucro) / 100;

        $salario = ($valorTotal - ($custos + $impostos + $lucro));
        
        return [
            "valorTotal" => $valorTotal,
            "valorHora" => $this->getValorHora(),
            "imposto" => $impostos,
            "lucro" => $lucro,
            "custos" => $custos,
            "salario" => $salario
        ];
    }

}


$precificacao = new Precificacao(100000,30,0); //valorBase, Margem de Lucro, Impostos
$precificacao->setValorHora(3,3); //Dias, Horas

// aluguel,internet,alimentacao,energia,clientes
$precificacao->setCustosFixos(10000,24000,20000,5000,3);

$results = (Object)$precificacao->getResults();


 
echo '
    Valor Total: '.number_format(($results->valorTotal),2, ',', '.').' 
    Valor Hora: '.number_format(($results->valorHora),2, ',', '.').' 
    Imposto: '.number_format(($results->imposto),2, ',', '.').'
    Lucro:  '.number_format(($results->lucro),2, ',', '.').'
    Custos:    '.number_format(($results->custos),2, ',', '.').'
    Salário: '.number_format(($results->salario),2, ',', '.').'
';

