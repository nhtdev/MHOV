<?php

namespace MHOV\View;

class Parser
{
	
	public function __construct() {
		
	}
	
	public function parse($data) {
		
		$container = new \MHOV\View\Container();
		
		$cat = null;
		$data = explode("\n", $data);
		foreach ($data as $line) {
			
			$read = false;
			
			if ($cat === null) {
				// Infos sur la zone centrale ou la portée de la vue
				if (preg_match('/^Ma Position Actuelle est.*?([0-9\-]+).+?([0-9\-]+).+?([0-9\-]+)/i', $line, $matches)) {
					// Ma Position Actuelle est : X = 12, Y = 34, N = 56
					$container->setCenter((int) $matches[1], (int) $matches[2], (int) $matches[3]);
					$read = true;
				} else if (preg_match('/^Zone centrale cibl.*?([0-9\-]+).+?([0-9\-]+).+?([0-9\-]+)/i', $line, $matches)) {
					// VL : Zone centrale ciblée : X = 12 | Y = 34 | N = -56
					$container->setCenter((int) $matches[1], (int) $matches[2], (int) $matches[3]);
					$read = true;
				} else if (preg_match('/^L\'affichage est limit.*?([0-9\-]+).+?([0-9\-]+)/i', $line, $matches)) {
					// L'affichage est limité à  80 cases horizontalement et 40 verticalement.
					$container->setDistanceVue((int) $matches[1], (int) $matches[2]);
					$read = true;
				}
			}
			
			if (substr($line, 0, 3) === '[-]') {
				// Changement de catégorie
				if (preg_match('/^\[\-\]\s+MONSTRE/', $line)) {
					$cat = \MHOV\Constants::CAT_MONSTRE;
					$read = true;
				} else if (preg_match('/^\[\-\]\s+TR[^\s]+LL/', $line)) {
					$cat = \MHOV\Constants::CAT_TROLL;
					$read = true;
				} else if (preg_match('/^\[\-\]\s+TR[^\s]+SOR/', $line)) {
					$cat = \MHOV\Constants::CAT_TRESOR;
					$read = true;
				} else if (preg_match('/^\[\-\]\s+CHAMPI/', $line)) {
					$cat = \MHOV\Constants::CAT_CHAMPIGNON;
					$read = true;
				} else if (preg_match('/^\[\-\]\s+LIEU/', $line)) {
					$cat = \MHOV\Constants::CAT_LIEU;
					$read = true;
				} else if (preg_match('/^\[\-\]\s+C[^\s]+NOTAPHE/', $line)) {
					$cat = \MHOV\Constants::CAT_CENOTAPHE;
					$read = true;
				}
			}
			
			switch ($cat) {

				case \MHOV\Constants::CAT_TROLL:
					// exemple 11		4078	Mr X	60	Skrim	La guilde	-61	31	-5
					
					//                    dist   action (num)      (nom)  (niv)           (race)        (guilde)(x)          (y)          (n)
					if (preg_match('/^\s*[0-9]+\s[^0-9]*([0-9]+)\s+(.*)\s+([0-9][0-9]?)\s+([a-zA-Z]+)\s+(.*)\s+([0-9\-]+)\s+([0-9\-]+)\s+([0-9\-]+)\s+$/', $line, $matches)) {
						$container->addTroll((int) $matches[1], $matches[2], (int) $matches[3], $matches[4], $matches[5], (int) $matches[6], (int) $matches[7], (int) $matches[8]);
					}
					break;
				
				case \MHOV\Constants::CAT_MONSTRE:
					// exemple : 9		5516786	10	Diablotin de Troisième Cercle [Favori] [Voit le caché] 	-76	40	-9
					
					//                    dist   action (num)      niv-mz   (nom)  (x)          (y)          (n)
					if (preg_match('/^\s*[0-9]+\s[^0-9]*([0-9]+)\s[0-9\-\s]*(.*)\s+([0-9\-]+)\s+([0-9\-]+)\s+([0-9\-]+)\s+$/', $line, $matches)) {
						$container->addMonstre((int) $matches[1], $matches[2], (int) $matches[3], (int) $matches[4], (int) $matches[5]);
						$read = true;
					}
					break;
					
				case \MHOV\Constants::CAT_TRESOR:
					// exemple : 13	Telek	11328211	Arme (2 mains)	-61	47	0

					//                    dist   action (num)      (nom)  (x)          (y)          (n)
					if (preg_match('/^\s*[0-9]+\s[^0-9]*([0-9]+)\s+(.*)\s+([0-9\-]+)\s+([0-9\-]+)\s+([0-9\-]+)\s+$/', $line, $matches)) {
						$container->addTresor((int) $matches[1], $matches[2], (int) $matches[3], (int) $matches[4], (int) $matches[5]);
						$read = true;
					}
					break;
					
				case \MHOV\Constants::CAT_CHAMPIGNON:
					// exemple : 10		1 Champignon inconnu	-74	38	-11

					//                    dist   action    (nom)  (x)          (y)          (n)
					if (preg_match('/^\s*[0-9]+\s[^0-9]*\s+(.*)\s+([0-9\-]+)\s+([0-9\-]+)\s+([0-9\-]+)\s+$/', $line, $matches)) {
						$container->addChampignon($matches[1], (int) $matches[2], (int) $matches[3], (int) $matches[4]);
						$read = true;
					}
					break;
					
				case \MHOV\Constants::CAT_LIEU:
					// exemple : 9	 	1936704	Petite Lice	-63	26	-10

					//                    dist   action (num)      (nom)  (x)          (y)          (n)
					if (preg_match('/^\s*[0-9]+\s[^0-9]*([0-9]+)\s+(.*)\s+([0-9\-]+)\s+([0-9\-]+)\s+([0-9\-]+)\s+$/', $line, $matches)) {
						$container->addLieu((int) $matches[1], $matches[2], (int) $matches[3], (int) $matches[4], (int) $matches[5]);
						$read = true;
					}
					break;
					
				case \MHOV\Constants::CAT_CENOTAPHE:
					// exemple : 48		91595	Cénotaphe de Mr X (4078)	-66	-14	-40

					//                    dist   action (num)      (nom)  (x)          (y)          (n)
					if (preg_match('/^\s*[0-9]+\s[^0-9]*([0-9]+)\s+(.*)\s+([0-9\-]+)\s+([0-9\-]+)\s+([0-9\-]+)\s+$/', $line, $matches)) {
						$container->addCenotaphe((int) $matches[1], $matches[2], (int) $matches[3], (int) $matches[4], (int) $matches[5]);
						$read = true;
					}
					break;
					
				
				case null:
				default:
					break;
					
			}
			
			// DEBUG
			/*
			if ($read) {
				echo '<strong>(' . $cat . ') ' . $line . '</strong><br />' . "\n";
			} else {
				echo $line . '<br />' . "\n";
			}
			*/
			
		}
		
		return $container;
	}
	
}