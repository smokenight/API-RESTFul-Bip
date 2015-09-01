<?php
/**
 * Copyright (C) 2013 Pablo Sepúlveda P. <psep.pentauc@gmail.com>
 *
 * This file is part of apis-servicios.
 * apis-servicios is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * any later version.
 *
 * apis-servicios is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with apis-servicios.  If not, see <http://www.gnu.org/licenses/>.
 */
/**
 * Clase de Consulta Tarjeta Bip!.
 * 
 * @author Pablo Sepúlveda P. <psep.pentauc@gmail.com>
 * @version 2.0
 * @package apis-servicios
 * @copyright Copyright (C) 2010-2013 Pablo Sepúlveda P.
 * @license GNU GPLv3 or later
 * @link http://www.psep.cl
 */
class Bip extends AbstractCURL {
	/**
	 * Atributo privado donde recaerá el valor del
	 * ID de la tarjeta BIP!.
	 */
	private $idNumber;
	/**
	 * Constructor de la clase
	 * 
	 * @param $idNumber
	 */
	public function __construct($idNumber){
		$this->idNumber = $idNumber;
	}
	/**
	 * Función que retorna la data de la tarjeta
	 * en formato json. Si no hay data retorna null.
	 * 
	 * @return json
	 */
	public function getData(){
		if($this->idNumber == null && $this->idNumber == "" && is_int($this->idNumber)){
			return null;
		}
		else{
			//URL de consulta oficial del saldo de una tarjeta Bip!
			//A esta URL se le pasan los parámetros necesarios para luego proceder al scrapping del resultado
			$url = "http://pocae.tstgo.cl/PortalCAE-WAR-MODULE/SesionPortalServlet?accion=6&NumDistribuidor=99&NomUsuario=usuInternet&NomHost=AFT&NomDominio=aft.cl&Trx=&RutUsuario=0&NumTarjeta=".$this->idNumber."&bloqueable=";
			$data = Utils::searchTags($this->getCURL($url), '<table width="100%" border="0" align="center" cellpadding="3" cellspacing="1">', '</table>');
			$dom = new DOMDocument();
			$dom->preserveWhiteSpace = false;
			$dom->loadHTML($data);
			$colums = $dom->getElementsByTagName('td');
			$dataArr= array();
			$name = '';
			
			for($i = 0; $i < $colums->length; $i++){
				$objDOM = $colums->item($i);
				
				if($name == ""){
					$name = substr(trim(htmlentities($objDOM->textContent)), 0, -1);
				}
				else{
					switch($name)
					{
						case 'N&Acirc;&ordm; tarjeta bip! ':
						case 'N&ordm; tarjeta bip! ':
							$name = 'numero_tarjeta';
							break;

						case 'Estado de contrato':
							$name = 'estado_contrato';
							break;

						case 'Saldo  tarjeta':
							$name = 'saldo';
							break;

						case 'Fecha saldo':
							$name = 'fecha_saldo';
							break;
					}
					$dataArr[$name] = trim(htmlentities($objDOM->textContent));
					$name = '';
				}
			}
			
			if(count($dataArr) < 4){
				return null;
			}
			return json_encode($dataArr);
		}
	}
}