<?php

class Conn {

  const HOST = 'localhost';
  const USER = 'root';
  const PASS = '';
  const DBSA = 'envolve';

  private static $Connect = null;

  final function __construct()
  {
  }

  private static function Connect()
  {
    try {
      if (self::$Connect == null) {
        $dsn = 'mysql:host=' . self::HOST . ';dbname=' . self::DBSA;
        $options = [PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES UTF8'];
        self::$Connect = new PDO($dsn, self::USER, self::PASS, $options);
      }
    } catch (PDOException $e) {
      echo 'Erro ao conectar com o banco de dados: ' . $e->getMessage();
    }
    return self::$Connect;
  }

  public static function getConn()
  {
    return self::Connect();
  }

  final function __clone()
  {
  }
}