<?php
/**
 * Created by PhpStorm.
 * User: Francisco Nascimento - d19sp.webdeveloper@outlook.com
 * Date: 22/06/14
 * Time: 17:16
 *
 *  DataSouce : Abre uma conexao com o banco de dados
 *
 *
 *
 */

final class DataSource {

    # Nao existirao instancias de DataSource por isso definido como private

    private function __construct(){}

    # Abre o arquivo de configuração

    private static function getDataConnection($type)
    {
        $data = new Connection();
        $config = $data->xmlData("app.config");
        $db = get_object_vars($config);

        return $db[$type];
    }

    # Recebe o nome do banco de dados e instancia o PDO correspondente

    public static function getConnection($driveConnection)
    {

        $db = self::getDataConnection($driveConnection);

        # le as informações contidas no arquivo de configuração
        $user = isset($db->user)? $db->user : NULL;
        $pass = isset($db->pass)? $db->pass : NULL;
        $name = isset($db->database)? $db->database : NULL;
        $host = isset($db->host)? $db->host : NULL;
        $type = isset($db->type)? $db->type : NULL;
        $port = isset($db->port)? $db->port : NULL;

        # Retorna qual tipo de banco de dados sera conectando

        switch($type)
        {
            case 'pgsql';
                $port = $port ? $port : '5432';
                $conn = new PDO("pgsql:dbname={$name}; user={$user}; password={$pass}; host=$host;port={$port}");
                break;
            case 'mysql';
                $port = $port ? $port : '3306';
                $conn = new PDO("mysql:host=$host;port={$port};dbname={$name}", $user, $pass);
                $conn -> exec("SET CHARACTER SET utf8");
                break;
            case 'sqlite';
                $conn = new PDO("sqlite:{$name}");
                break;
            case 'mssql';
                $conn = new PDO("mssql:host={$host},1433;dbname={$name}", $user, $pass);
                break;

        }

        # define para que o PDO lance excessoes na ocorrencia de erros

        $conn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

        # retorna o objeto instanciado
        return $conn;
    }
}
