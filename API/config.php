<?php
//error_reporting(0);

// define("DATABASE", "pack_drop");

// define("HOST", "127.0.0.1");

// define("USERNAME", "pack_drop");

// define("PASS", "Pack@2020#");
define("DATABASE", "pack_drop");

define("HOST", "157.245.108.117");

define("USERNAME", "pack_drop");

define("PASS", "Pack@2020#");

class Connect {

	public $connection;

	function __construct() {

		$this->connection = mysqli_connect(HOST, USERNAME, PASS, DATABASE);

		// Check connection

		if (mysqli_connect_errno()) {

			echo "Failed to connect to MySQL: " . mysqli_connect_error();

		}

	}

	function Execute($query) {

		try {

			mysqli_query($this->connection, 'set names utf8');

			return mysqli_query($this->connection, $query);

		} catch (Exception $e) {

			echo "<pre>";

			print_r($e);

		}

	}

	function getAffectedRow() {

		try {

			return mysqli_affected_rows($this->connection);

		} catch (Exception $e) {

			echo "<pre>";

			print_r($e);

		}

	}

	function getInsertedId() {

		try {

			return mysqli_insert_id($this->connection);

		} catch (Exception $e) {

			echo "<pre>";

			print_r($e);

		}

	}

	function escapeString($value) {

		$search = array("\\", "\x00", "\n", "\r", "'", '"', "\x1a");

		$replace = array("\\\\", "\\0", "\\n", "\\r", "\'", '\"', "\\Z");

		return str_replace($search, $replace, $value);

	}

	function getLastError() {

		return mysqli_error($this->connection);

	}

}

$connect = new Connect();

?>