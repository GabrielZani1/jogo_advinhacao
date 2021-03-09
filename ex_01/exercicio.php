<?php

iniciaJogo();

function iniciaJogo() {
    while (true) {
        $num_adv = random_int(0, 100);
        $pontuacao = 100;
        $maior_pont = 0;
        $opcao_menu = 0;
        $numero = -1;
        $nome_jogador = "";        
        
        system('clear');
        echo "Bem Vindo ao Jogo!\nPara iniciar o jogo digite '1'\nPara listar o Ranking digite '2'\nPara fechar o jogo precione qualquer tecla\n";
        $opcao_menu = (int) readline(""); 
        system('clear');

        if (isset($opcao_menu) && $opcao_menu == 1) {    
            while (empty($nome_jogador)) {
                $nome_jogador = readline("Informe seu Nome para iniciar a partida: "); 
                system('clear');     
            }

            $inicio_tempo = timeJogo();

            while ($numero != $num_adv) {
                $numero = (int) readline("Informe um número: ");

                if ($numero > $num_adv) {
                    echo $num_adv." Você chutou muito alto. Tente um número menor! \n";          
                    $pontuacao -= 0.2;                          
                }

                if ($numero < $num_adv) {
                    echo $num_adv." Você chutou muita baixo. Tente um número maior! \n";            
                    $pontuacao -= 0.2;                       
                }

                if ($numero == $num_adv) {                                                       
                    $maior_pont = maiorPontuacao(consultaPontuacao(), $nome_jogador);
                    $fim_tempo = timeJogo();
                    $tempo = timeGeral($inicio_tempo, $fim_tempo);

                    if ($pontuacao > $maior_pont) { 
                        system('clear'); 
                        echo"----------------------------------------------------------------\n";  
                        echo "Parabéns ".$nome_jogador." você acertou :)\n";        
                        echo "NOVA PONTUAÇÃO!!!!!!!!! Sua pontuação agora é: ".$pontuacao."\n";
                        echo "Tempo decorrido: ".$tempo."\n";
                        echo"----------------------------------------------------------------\n";
                        gravaPontuacao($pontuacao, $nome_jogador, $tempo);                              
                    } else {                                                        
                        system('clear');
                        echo"----------------------------------------------------------------\n";
                        echo "Gamer Over :(\nVocê não conseguiu atingir uma maior pontuação!\nSua pontuação final foi: ".$pontuacao."\nMaior pontuação: ".$maior_pont."\n";
                        
                        if (validaPontuacao($pontuacao, $nome_jogador, $tempo)) {
                            echo "PARABÉNS o seu tempo foi menor: ".$tempo."\n";
                            echo"----------------------------------------------------------------\n"; 

                            gravaPontuacao($pontuacao, $nome_jogador, $tempo);                           
                        } else {
                            echo "Tempo decorrido: ".$tempo."\n";
                            echo"----------------------------------------------------------------\n";
                        }                 
                    } 
                    
                    readline("Para voltar ao Menu Principal precione qualquer tecla! "); 
                    continue;
                }
            }
        }elseif (isset($opcao_menu) && $opcao_menu == 2) {
            listaPontuacao();
            readline("Para voltar ao Menu Principal precione qualquer tecla! "); 
            continue;
        } else {
            break;
        }    
    }
}
/**
 * Esta função verifica se o jogador alcançou uma pontuação igual ao que já tem registrado no ranking 
 * mais neste caso o sistema valida se existe uma PONTUAÇÃO igual ao do ranking pertencendo ao mesmo JOGADOR
 * e se o tempo que ele levou é menor que a do ranking, CASO a a PONTUAÇÃO seja a mesma, mas o TEMPO seja menor
 * o sistema deve limpar aquele registro antigo com TEMPO MAIOR e inserir com novo tempo (MENOR).
 */
function validaPontuacao($pont_jog, $nome_jog, $tempo_jog) {
    $reg_jog = consultaPontuacao();
    $posicao = -1;       
    $bool = 0;

    foreach ($reg_jog as $pt) {            
        $posicao ++;   
        if (($pt['pontuacao'] == strval($pont_jog)) && ($pt['nome'] == $nome_jog) && ($tempo_jog < $pt['tempo'])) {
            $bool = 1;  
            unset($reg_jog[$posicao]);                                         
        }        
    }
    
    if ($bool) {
        unlink ('pontuacao.txt');        
        $arq_grav = fopen("pontuacao.txt", "a");    

        foreach ($reg_jog as $reg) {
            fwrite($arq_grav, $reg['pontuacao']."|".$reg['nome']."|".$reg['tempo']."\n");        
        }    
        fclose($arq_grav);
    }

    return $bool;    
}

function maiorPontuacao($array, $nome) {
    $max_valor = 0; 
    $array_tmp = [];    

    foreach ($array as $a) {        
        if ($a['nome'] == $nome){
            $array_tmp[] = $a['pontuacao'];
        }          
    }
    $max_valor = (double) current($array_tmp);

    return $max_valor;
}

function gravaPontuacao($pontReg, $nomeReg, $tempoJog) { 
    $arq_grav = fopen("pontuacao.txt", "a");    

    fwrite($arq_grav, $pontReg."|".$nomeReg."|".$tempoJog."\n");        
    fclose($arq_grav);
}

function consultaPontuacao() {      
    $reg_linhas = [];

    if (file_exists("pontuacao.txt")) {
        $arq_list = fopen("pontuacao.txt", "r");

        while (($data = fgetcsv($arq_list, 0, "|")) != false) {                           
            $reg_linhas[] = 
            [
                'pontuacao' => $data[0],
                'nome' => $data[1],
                'tempo' => $data[2]
            ];
        }
        fclose($arq_list);
      
        array_multisort(array_column($reg_linhas, 'pontuacao'), SORT_DESC, array_column($reg_linhas, 'tempo'), SORT_ASC, $reg_linhas);                   
    }
    return $reg_linhas;
}

function listaPontuacao() {
    $registros_pont = consultaPontuacao();
    $count = 1;

    echo "|-----------------------------------------------|\n";
    echo "|                    RANKING                    |\n";
    echo "|-----------------------------------------------|\n";
    echo "| #  |Pontos|Nome Jogador             |Tempo    |\n";
    foreach ($registros_pont as $linha) {
        echo "|".str_pad($count ++."°", 5, " ")."|".str_pad($linha['pontuacao'], 6, " ")."|".str_pad($linha['nome'], 25, " ")."|".str_pad($linha['tempo'], 9, " ")."|\n";
    }
    echo "|-----------------------------------------------|\n";
}

function timeJogo() {
    return microtime(true);
}

function timeGeral($start_time, $endtime) {
    $minutos = "00";        
    $tempo = $endtime - $start_time;    
    
    if ($tempo >= 60) {
        $minutos = sprintf('%02d', ($tempo / 60));    
    }
    $segundos = sprintf('%02d', ($tempo % 60));    
    $milissegundos = substr(strpbrk($tempo, '.'), 1, 2);
    
    return $minutos.":".$segundos.".".$milissegundos;
}

/** 
 * https://pt.stackoverflow.com/questions/27445/removendo-um-elemento-espec%C3%ADfico-em-um-array
 * 
 * http://phpbrasil.com/phorum/read.php?1,171996#:~:text=forma%20ja%20testada.&text=%2F%2FPara%20linha%20%222%22%20e,so%20colocar%20%5B1%5D%20assim.&text=Agora%20e%20so%20torcar%20Diego,ser%20reescrita%20com%20um%20vazio.
 * 
*/

?>

