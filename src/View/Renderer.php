<?php

namespace MHOV\View;

class Renderer
{

	public function __construct()
	{
		
	}
	
	public function render(\MHOV\View\Container $container)
	{
		$range = $container->getRange();
		
		echo '<table>' . PHP_EOL;
		
		// Numéros des X
		echo '<tr><th>&nbsp;</th>';
		for ($x = $range[0][0]; $x <= $range[0][1]; $x++) {
			echo '<th>' . $x . '</th>';
		}
		echo '</tr>' . PHP_EOL;
		
		for ($y = $range[1][0]; $y <= $range[1][1]; $y++) {
			echo '<tr><th>' . $y . '</th>' . PHP_EOL;
			for ($x = $range[0][0]; $x <= $range[0][1]; $x++) {
				echo '<td>';
				$this->renderCell($x, $y, $container->getXY($x, $y));
				echo '</td>' . PHP_EOL;
			}
			echo '</tr>' . PHP_EOL;
		}
		
		echo '</table>' . PHP_EOL;
		
	}

	public function renderCell($x, $y, $content) {
		krsort($content);
		foreach ($content as $n => $tmp) {
			foreach ($tmp as $cat => $items) {
				foreach ($items as $item) {
					switch ($cat) {
						case \MHOV\Constants::CAT_TROLL:
							echo '<div class="cat-troll race-' . strtolower(htmlentities($item['race'])) . '">'
									. '<span class="n">' . htmlentities($n) . '</span> '
									. '<span class="num">' . htmlentities($item['num']) .'</span> '
									. '<span class="nom">' . htmlentities($item['nom']) .'</span> '
									. '<span class="race">' . htmlentities($item['race']) .'</span> '
									. '<span class="niveau">' . htmlentities($item['niveau']) .'</span> '
									. '<span class="guilde">' . htmlentities($item['guilde']) .'</span>'
									. '</div>';
							break;
							
						case \MHOV\Constants::CAT_CHAMPIGNON: // pas de num
							echo '<div class="cat-' . htmlentities($cat) . '">'
									. '<span class="n">' . htmlentities($n) . '</span> '
									. '<span class="nom">' . htmlentities($item['nom']) .'</span>'
									. '</div>';
							break;
											
						default:
							echo '<div class="cat-' . htmlentities($cat) . '">'
									. '<span class="n">' . htmlentities($n) . '</span> '
									. '<span class="num">' . htmlentities($item['num']) .'</span> '
									. '<span class="nom">' . htmlentities($item['nom']) .'</span>'
									. '</div>';
							break;
							
					}
				}
			}
		}
	}
	
}
