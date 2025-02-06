<?php

$loterias = [
    'Mega-Sena' => [
        'valoresAposta' => [
            6 => 5.00,
            7 => 35.00,
            8 => 140.00,
            9 => 420.00,
            10 => 1050.00,
            11 => 2310.00,
            12 => 4620.00,
            13 => 8580.00,
            14 => 15015.00,
            15 => 25025.00,
            16 => 40040.00,
            17 => 61880.00,
            18 => 92820.00,
            19 => 135660.00,
            20 => 193800.00,
        ],
        'minimoDezenas' => 6,
        'maximoDezenas' => 20,
        'minimoNumeros' => 1,
        'maximoNumeros' => 60,
    ],
    'Quina' => [
        'valoresAposta' => [
            5 => 2.50,
            6 => 15.00,
            7 => 52.50,
            8 => 140.00,
            9 => 315.00,
            10 => 630.00,
            11 => 1155.00,
            12 => 1980.00,
            13 => 3217.50,
            14 => 5005.00,
            15 => 7507.50,
        ],
        'minimoDezenas' => 5,
        'maximoDezenas' => 15,
        'minimoNumeros' => 1,
        'maximoNumeros' => 80,
    ],
    'Lotofácil' => [
        'valoresAposta' => [
            15 => 3.00,
            16 => 48.00,
            17 => 408.00,
            18 => 2448.00,
            19 => 11628.00,
            20 => 46512.00,
        ],
        'minimoDezenas' => 15,
        'maximoDezenas' => 20,
        'minimoNumeros' => 1,
        'maximoNumeros' => 25,
    ],
    'Lotomania' => [
        'valoresAposta' => [
            50 => 3.00,
        ],
        'minimoDezenas' => 50,
        'maximoDezenas' => 50,
        'minimoNumeros' => 1,
        'maximoNumeros' => 100,
    ],
];

function geraApostaAleatoria($minimoNumeros, $maximoNumeros, $numeroDezenas) {
    $aposta = [];

    while (count($aposta) < $numeroDezenas) {
        $dezena = rand($minimoNumeros, $maximoNumeros);
        if (!in_array($dezena, $aposta)) {
            $aposta[] = $dezena;
        }
    }
    sort($aposta);
    return $aposta;
}

function calculaTotalGasto($quantidade, $precoPorAposta) {
    return $quantidade * $precoPorAposta;
}

function exibeNumerosPossiveis($minimoNumeros, $maximoNumeros) {
    
    print "Números possíveis: ";
    for ($i = $minimoNumeros; $i <= $maximoNumeros; $i++) {
        print "$i ";
    }
    print "\n";
}

function verificaResultado($numerosSorteados, $nossaAposta) {
    
    $numerosJogados = count($nossaAposta);
    $numerosAcertados = 0;
    
    for($i=0;$i<$numerosJogados;$i++){

        if(in_array($nossaAposta[$i], $numerosSorteados)){
            $numerosAcertados++;
        }
    }

    if ($numerosAcertados === count($numerosSorteados)) {
        
        print "Parabéns! Você ganhou!\n";

    } else if ($numerosAcertados === 0){
       
        print "Você não acertou nenhuma dezena";

    } else {
        
        print "Você não ganhou, mas você acertou $numerosAcertados dezenas.\n";

    }
}


print "Escolha a loteria:\n";
foreach ($loterias as $loteria => $parametros) {
    print "- $loteria (Quantidade mínima: {$parametros['minimoDezenas']}, Quantidade máxima: {$parametros['maximoDezenas']})\n";
}

$jogoEscolhido = readline("Digite o nome da loteria desejada: ");
if (!isset($loterias[$jogoEscolhido])) {
    print "Loteria não encontrada.\n";
    exit();
}

$parametros = $loterias[$jogoEscolhido];

print "\nNúmeros possíveis para $jogoEscolhido: ";
exibeNumerosPossiveis($parametros['minimoNumeros'], $parametros['maximoNumeros']);

$opcaoApostaAleatoria = readline("Deseja criar uma aposta aleatória? (sim/não): ");
if (strtolower($opcaoApostaAleatoria) === 'sim') {
    
    do {
        $numeroDezenas = intval(readline("Quantos números você quer na aposta? "));

    } while ($numeroDezenas < $parametros['minimoDezenas'] || $numeroDezenas > $parametros['maximoDezenas']);


    $numerosEscolhidos = geraApostaAleatoria($parametros['minimoNumeros'], $parametros['maximoNumeros'], $parametros['minimoDezenas']);
    
    print "Quantidade de apostas desejadas: ";
    $quantidadeApostas = intval(readline());

    $numerosSorteados = geraApostaAleatoria($parametros['minimoNumeros'], $parametros['maximoNumeros'], $parametros['minimoDezenas']);
    
    print "\nNúmeros sorteados: " . join(' ', $numerosSorteados) . "\n";
    
    if ($quantidadeApostas > 1) {
        print "\nApostas aleatórias geradas pelo sistema:\n";
        for ($i = 0; $i < $quantidadeApostas; $i++) {
            $apostaAleatoria = geraApostaAleatoria($parametros['minimoNumeros'], $parametros['maximoNumeros'], $parametros['minimoDezenas']);
            print "Aposta " . ($i + 1) . ": " . join(' ', $apostaAleatoria) . "\n";

            verificaResultado($numerosSorteados, $apostaAleatoria);
            print "\n";
        }
    } else if ($quantidadeApostas == 1){
        print "\nAposta aleatória gerada pelo sistema:\n";
        for ($i = 0; $i < $quantidadeApostas; $i++) {
            $apostaAleatoria = geraApostaAleatoria($parametros['minimoNumeros'], $parametros['maximoNumeros'], $parametros['minimoDezenas']);
            print "Aposta " . ($i + 1) . ": " . join(' ', $apostaAleatoria) . "\n";

            verificaResultado($numerosSorteados, $apostaAleatoria);
            print "\n";
        }
    }
} else if (strtolower($opcaoApostaAleatoria) === 'não'){ 
    
    $numeroDezenas = explode(',', readline("Digite os números da(s) sua(s) aposta(s): "));
    $numerosEscolhidos = array_map('intval', $numeroDezenas);
    

    $quantidadeApostas = intval(readline("Quantidade de apostas que serão realizadas: \n"));
    
    if (count($numerosEscolhidos) < $parametros['minimoDezenas'] || count($numerosEscolhidos) > $parametros['maximoDezenas']) {
        print "Quantidade inválida de números para esta loteria.\n";
        exit();
    }
  
    foreach ($numerosEscolhidos as $numero) {
        if ($numero < $parametros['minNum'] || $numero > $parametros['maxNum']) {
            print "Número fora do intervalo permitido para esta loteria.\n";
            exit();
        }
    }

    $numerosSorteados = geraApostaAleatoria($parametros['minimoNumeros'], $parametros['maximoNumeros'], $parametros['minimoDezenas']);
    
    print "\nNúmeros sorteados: " . join(' ', $numerosSorteados) . "\n";
    
    print "\nAposta escolhida:\n";
    print join(' ', $numerosEscolhidos) . "\n";
    verificaResultado($numerosSorteados, $numerosEscolhidos);
    print "\n";

    
    $numeroDezenas = count($numeroDezenas);

} else {
    print "Opção inválida.\n";
    exit();
}

$totalGasto = calculaTotalGasto($quantidadeApostas, $parametros['valoresAposta'][$numeroDezenas]);
print "Total gasto em reais: R$ $totalGasto\n";
