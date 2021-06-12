<?php

class Votos{
	public $txt = 'votacao_secao_1994_BR.txt';
	public $lista = array();
	public $n_colunas = 15;
	public $lista_processada = array();

	public function __construct(){
		$arquivo = glob($this->txt);
		if (count($arquivo) == 0) die("Erro: arquivo (".$this->txt.") nao encontrado.\n");

		$h = fopen($arquivo[0], 'r'); // Abre o arquivo
		if ($h) {
			while (!feof($h)) { // Retorna True quando chegar no final do arquivo
				$registro = fgets($h); // Pega uma linha do arquivo a partir da marcação do ponteiro
				$registro = chop($registro); // Aplido para rtrim(): Retira espaços em branco do final da string
				if (strlen($registro) > 0) {
					$colunas = explode(';', $registro);
					if (count($colunas) == $this->n_colunas) {
						$n_candidato = "candidato_".trim($colunas[13],'"');
	
						// ['candidato_12']['uf']['cidade']['votos']
						$this->lista[$n_candidato] [trim($colunas[5],'"')] [trim($colunas[8],'"')][] = (int) trim($colunas[14],'"');
						
					} else {
						die("Erro: numero de colunas invalido\n");
					}
				}
			}
			fclose($h);
		} else {
			die("Erro: nao foi possivel abrir o arquivo $arquivo\n");
		}
	}

	public function getVotosUF($uf = ''){

		foreach($this->lista as $candidato=>$estados){

			foreach($estados as $sigla_estado=>$cidades){

				foreach($cidades as $nome_cidade=>$votos){
					$qtd_votos[$sigla_estado][$nome_cidade] = array_sum($votos);
				}
			
				if($uf != '' && strtolower($sigla_estado) == strtolower($uf)){
					$lista[$candidato][$uf] = array_sum($qtd_votos[$uf]);
				}else{
					$lista[$candidato][$sigla_estado] = array_sum($qtd_votos[$sigla_estado]);
				}
			}			
		}
		return $this->lista_processada = $lista;
	}

	public function getVotosCidade($cidade = ''){
		foreach($this->lista as $candidato=>$estados){
			foreach($estados as $sigla_estado=>$cidades){
				foreach($cidades as $nome_cidade=>$votos){

					if($cidade != '' && strtolower($nome_cidade) == strtolower($cidade)){
						$lista[$candidato][$sigla_estado][$cidade] = array_sum($votos);
					}else{
						$lista[$candidato][$sigla_estado][$nome_cidade] = array_sum($votos);
					}
				}	
			}
		}
		return $this->lista_processada = $lista;
	}

	public function getDigitosLista(){
		if(count($this->lista_processada) > 0){
			foreach($this->lista_processada as $candidato=>$estado){
				foreach($estado as $sigla_estado=>$cidades){
					if(is_array($cidades)){
						foreach($cidades as $nome_cidade=>$votos){
							$lista[$candidato][] = substr($votos, 0, 1);
						}
					}else{
						$lista[$candidato][] = substr($cidades, 0, 1);
					}
					
				}
			}
			
			return $lista;
		}
	}
}

?>