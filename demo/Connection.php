<?php
/**
 * Created by PhpStorm.
 * User: Francisco Nascimento - d19sp.webdeveloper@outlook.com
 * Date: 25/08/14
 * Time: 17:16
 *              Agregada com a classe DataSource:
 *
 *              Dependencia de um arquivo de configuraçao .xml
 *              com a strututra:
 *
 *              1- Defina uma constante com o nome  PATH_CONFIG com o valor do diretorio onde sera guardado o xml de configuração
 *              2- Crie um arquivo com nome de app.config.xml use a estrutura abaixo:
 *
 *                  <db>
 *                      <nome_do_banco>  // mysql,pgsql,sqlite,mssql
 *                          <host>      nome_do_host_de_conexao_com_o_banco </host>
 *                          <database>  nome_do_banco_de_dados      </database>
 *                          <user>      usuario_do_banco_de_dados   </user>
 *                          <pass>      senha_de_acesso_ao_banco    </pass>
 *                          <type>      tipo_do_banco_de_dados      </type>  // mysql,pgsql,sqlite,mssql
 *                      </nome_do_banco>
 *                  </db>
 *
 *              Sugestões de segurança:
 *
 *              - Onde o arquivo vai ficar armazenado proteja a pasta com .htaccess
 *              - criptografe os dados de conexão
 *              - crie um arquivo index.php ou index.html e coloque uma rotina para redirecionar para uma pagina 404
 *              - se possivel mantenha esse arquivo fora da pasta hoot do seu site ou sistema.
 *
 */
if(!defined('PATH_CONFIGURATION')){define('PATH_CONFIGURATION','system/app.config/');}
class Connection {

    private $config;

    # Retorna os dados de conexao definido no arquivo app.config.xml
    
    private function OpenDataXml($name)
    {
        if(!file_exists(PATH_CONFIGURATION.$name.".xml"))
        {
            trigger_error("O arquivo de configuracao {$name} nao encontrado ou corrompido",E_USER_WARNING);
        }
        else
        {

            $this->config = simplexml_load_file(PATH_CONFIGURATION.$name.".xml");
        }

        return $this->config;
    }

    public function xmlData($name)
    {
        $xml = $this->OpenDataXml($name);

        return $xml;

    }
	
	# Retorna as configurações do ambiente em que esta sendo executado a aplicação
	# Chamada na index.php
	
	# Ambiente Local
	
    public function getDataLocal()
    {
        $xml = $this->OpenDataXml("app.host.config");
        $local = get_object_vars($xml->local);
        $local = str_replace('"',"",$local);
        return $local['host'];

    }

	# Criado para situação especifica onde a aplicação esta embedado dentro do facebook
	
    public function getDataFacebook()
    {
        $xml = $this->OpenDataXml("app.host.config");
        $local = get_object_vars($xml->producao);
        $local = str_replace('"',"",$local);
        return $local['host_https'];

    }

	# Ambiente de desenvolvimento
	
    public function getDataDevloper()
    {
        $xml = $this->OpenDataXml("app.host.config");
        $developer = get_object_vars($xml->developer);
        $developer = str_replace('"',"",$developer);
        return $developer['host'];

    }

	# Ambiente de Produção
	
    public function getDataProduction()
    {
        $xml = $this->OpenDataXml("app.host.config");
        $producao = get_object_vars($xml->producao);
        $producao = str_replace('"',"",$producao);
        return $producao['host'];

    }

} 
