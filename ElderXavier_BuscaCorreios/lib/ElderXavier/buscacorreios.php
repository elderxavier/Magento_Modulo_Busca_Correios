<?
include('phpQuery-onefile.php');

class BuscarCorreios{

	private function simple_curl($url,$post=array(),$get=array()){
		$url = explode('?',$url,2);
		if(count($url)===2){
			$temp_get = array();
			parse_str($url[1],$temp_get);
			$get = array_merge($get,$temp_get);
		}
		$ch = curl_init($url[0]."?".http_build_query($get));
		curl_setopt ($ch, CURLOPT_POST, 1);
		curl_setopt ($ch, CURLOPT_POSTFIELDS, http_build_query($post));
		curl_setopt ($ch, CURLOPT_FOLLOWLOCATION, 1);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		return curl_exec ($ch);
	}

	function Buscar(){
		$cep = $_GET['buscar'];
		$html = $this->simple_curl('http://m.correios.com.br/movel/buscaCepConfirma.do',array(
			'cepEntrada'=>$cep,
			'tipoCep'=>'',
			'cepTemp'=>'',
			'metodo'=>'buscarCep'
		));

		phpQuery::newDocumentHTML($html, $charset = 'utf-8');

		$dados = array(
		'logradouro'=> trim(pq('.caixacampobranco .resposta:contains("Logradouro: ") + .respostadestaque')->html()),
		'bairro'=> trim(pq('.caixacampobranco .resposta:contains("Bairro: ") + .respostadestaque')->html()),
		'cidade/uf'=> trim(pq('.caixacampobranco .resposta:contains("Localidade / UF: ") + .respostadestaque')->html()),
		'cep'=> trim(pq('.caixacampobranco .resposta:contains("CEP: ") + .respostadestaque')->html()),

		'logradouro2'=> trim(pq('.caixacampoazul .resposta:contains("Logradouro: ") + .respostadestaque')->html()),
		'bairro2'=> trim(pq('.caixacampoazul .resposta:contains("Bairro: ") + .respostadestaque')->html()),
		'cidade/uf2'=> trim(pq('.caixacampoazul .resposta:contains("Localidade / UF: ") + .respostadestaque')->html()),
		'cep2'=> trim(pq('.caixacampoazul .resposta:contains("CEP: ") + .respostadestaque')->html())
		);
		//print_r($dados);

		$dados['cidade/uf'] = explode('/',$dados['cidade/uf']);
		$dados['cidade'] = trim($dados['cidade/uf'][0]);
		$dados['uf'] = trim($dados['cidade/uf'][1]);
		$dados['cidade2'] = trim($dados['cidade/uf2'][0]);
		$dados['uf2'] = trim($dados['cidade/uf2'][1]);
		unset($dados['cidade/uf']);
		unset($dados['cidade/uf2']);
		echo json_encode($dados);		
	}
}


$buscar = new BuscarCorreios();
$buscar->Buscar();