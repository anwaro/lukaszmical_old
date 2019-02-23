<?php
namespace models;

use vendor\db\Db;

/**
 * Class Ajax
 * @package models
 */
class Ajax extends Db {

	public function getBtcPrices(){
		$url_pln = "https://bitbay.net/API/Public/BTCPLN/trades.json?sort=desc&limit=1";
		$url_usd = "https://bitbay.net/API/Public/BTCUSD/trades.json?sort=desc&limit=1";

		$data_pln = file_get_contents($url_pln);
		$data_usd = file_get_contents($url_usd);

		$data_pln = json_decode($data_pln, true);
		$data_usd = json_decode($data_usd, true);

		$pln = $data_pln[0]["price"];
		$usd = $data_usd[0]["price"];

		$date = date("d-m-Y H:i:s", $data_pln[0]["date"]);
		

		return $this->formatPrice($pln)
		. "|" . $this->formatPrice($usd)
		. "|" . $date;
	}

	private function formatPrice($price)
	{
		// return $price;
		return number_format($price, 2);
	}

}