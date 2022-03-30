<?php

namespace Rbac\Model\Table;

use Cake\ORM\Table;

class ConversorTable extends Table {
	
    public function initialize(array $config):void
	{
		parent::initialize($config);
	
		$this->setTable(false);
		
	}
	
	/**
	 * Convierte un string camelCase a un string con underscores (e.g. firstName -> first_name)
	 * @param string $str
	 * @return string
	 */
	public function camelCaseToUnderscore($str){
		$str[0] = strtolower($str[0]);
		$delimiter = "_";
		//$func = create_function('$c', 'return "_" . strtolower($c[1]);');
		$func  = function($c) use ($delimiter) {
			return $delimiter . strtolower($c[1]);
		};
		
		
		return preg_replace_callback('/([A-Z])/', $func, $str);
	}
	
	/**
	 * Convierte un string con underscores a un string camelCase (e.g. first_name -> firstName)
	 * @param string $str
	 * @return string
	 */
	public function underscoreToCamelCase($str, $capitalise_first_char = false){
		if($capitalise_first_char) {
			$str[0] = strtoupper($str[0]);
		}
		$delimiter="_";
		//$func = create_function('$c', 'return strtoupper($c[1]);');
		$func  = function($c) use ($delimiter) {
			return $delimiter . strtolower($c[1]);
		};
		
		return preg_replace_callback('/_([a-z])/', $func, $str);
	}
	

}
