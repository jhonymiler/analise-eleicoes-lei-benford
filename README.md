# Análise de Eleições via Lei de Benford
 Este Script gera gráficos para detecção de fraude com a Lei de Benford
 
 Para realizar este teste você precisará do arquivo votacao_secao_1994_BR.txt que contém os votos da eleição de 1994. 
 Você pode obter este arquivo através do link: <a href="https://www.tse.jus.br/hotsites/pesquisas-eleitorais/resultados_anos/votacao/votacao_secao_eleitoral_1994.html">Votação por seção eleitoral</a>. Salve o arquivo TXT na pasta raiz e rode o programa. 
 
 Com este método você conseguirar analisar todos os anos e comparar com a <a href="https://pt.wikipedia.org/wiki/Lei_de_Benford">LEI DE BENFORD</a>, porém os dados obtidos dos arquivos TXTs mudam sua posição nas colunas, basta obter o número ou nome do candidato, estado, cidade e quantidade de votos nas colunas dos arquivos TXT alterando o seguinte código no arquivo classVotos.php:
 
```php
 // ['candidato_12']['uf']['cidade']['votos']
$this->lista[$n_candidato] [trim($colunas[5],'"')] [trim($colunas[8],'"')][] = (int) trim($colunas[14],'"');
```
Identifique as colunas correspondentes e altere na linha acima para obter os dados. 

Feito isso, o programa irá funcionar. Qualquer dúvida comente!!

<img src="ScreenHunter 610.jpg"/>

# Video explicativo sobre a Lei de benford

Neste video eu mostro como funciona a lei de Benford utilizando o Excel e depois demonstrando no sistema PHP

[![IMAGE ALT TEXT HERE](https://img.youtube.com/vi/eLZ8xKFpxQ0/0.jpg)](https://www.youtube.com/watch?v=eLZ8xKFpxQ0)
