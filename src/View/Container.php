<?php

namespace MHOV\View;

class Container
{
	protected $data;
	protected $center;
	protected $range;
	
	public function __construct()
	{
		$this->reset();
	}
	
	public function reset()
	{
		$this->data = [];
		$this->center = null;
		$this->range = null;
	}
	
	public function setCenter($x, $y, $n)
	{
		$this->center = [$x, $y, $n];
	}
	
	public function setDistanceVue($horizontal, $vertical)
	{
		if ($this->center !== null) {
			$nMax = $this->center[2] + $vertical;
			if ($nMax > 0) {
				$nMax = 0;
			}
			$this->range = [
					[ $this->center[0] - $horizontal, $this->center[0] + $horizontal], // X
					[ $this->center[1] - $horizontal, $this->center[1] + $horizontal], // Y
					[ $this->center[2] - $vertical, $nMax] // N
			];
		}
	}
	
	public function getRange() {
		if ($this->range === null) {
			$this->computeRange();
		}
		return $this->range;
	}
	
	public function computeRange() {
		if ($this->center !== null) {
			$this->range = [
					[ $this->center[0], $this->center[0]], // X
					[ $this->center[1], $this->center[1]], // Y
					[ $this->center[2], $this->center[2]] // N
			];
			foreach ($this->data as $x => $tmp) {
				if ($x < $this->range[0][0]) {
					$this->range[0][0] = $x;
				}
				if ($x > $this->range[0][1]) {
					$this->range[0][1] = $x;
				}
				foreach ($tmp as $y => $tmp2) {
					if ($y < $this->range[1][0]) {
						$this->range[1][0] = $y;
					}
					if ($y > $this->range[1][1]) {
						$this->range[1][1] = $y;
					}
					foreach ($tmp2 as $n => $tmp3) {
						if ($n < $this->range[2][0]) {
							$this->range[2][0] = $n;
						}
						if ($n > $this->range[2][1]) {
							$this->range[2][1] = $n;
						}
					}
				}
			}
		}
	}
	
	public function addMonstre($num, $nom, $x, $y, $n)
	{
		$this->add(
				\MHOV\Constants::CAT_MONSTRE,
				$x,
				$y,
				$n,
				[
						'num' => $num,
						'nom' => $nom
				]
		);
	}
	
	public function addTroll($num, $nom, $niveau, $race, $guilde, $x, $y, $n)
	{
		$this->add(
				\MHOV\Constants::CAT_TROLL,
				$x,
				$y,
				$n,
				[
						'num' => $num,
						'nom' => $nom,
						'niveau' => $niveau,
						'race' => $race,
						'guilde' => $guilde
				]
		);
	}
	
	public function addTresor($num, $nom, $x, $y, $n)
	{
		$this->add(
				\MHOV\Constants::CAT_TRESOR,
				$x,
				$y,
				$n,
				[
						'num' => $num,
						'nom' => $nom
				]
		);
	}
	
	public function addChampignon($nom, $x, $y, $n)
	{
		$this->add(
				\MHOV\Constants::CAT_CHAMPIGNON,
				$x,
				$y,
				$n,
				[
						'nom' => $nom
				]
		);
	}
	
	public function addLieu($num, $nom, $x, $y, $n)
	{
		$this->add(
				\MHOV\Constants::CAT_LIEU,
				$x,
				$y,
				$n,
				[
						'num' => $num,
						'nom' => $nom
				]
		);
	}
	
	public function addCenotaphe($num, $nom, $x, $y, $n)
	{
		$this->add(
				\MHOV\Constants::CAT_CENOTAPHE,
				$x,
				$y,
				$n,
				[
						'num' => $num,
						'nom' => $nom
				]
		);
	}
	
	protected function add($type, $x, $y, $n, $attr)
	{
		$this->data[$x][$y][$n][$type][] = $attr;
	}
	
	public function getXY($x, $y)
	{
		if (isset($this->data[$x][$y])) {
			return $this->data[$x][$y];
		} else {
			return [];
		}
	}
	
	public function getXYN($x, $y, $n)
	{
		if (isset($this->data[$x][$y][$n])) {
			return $this->data[$x][$y][$n];
		} else {
			return [];
		}
	}
	
}