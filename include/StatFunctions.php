<?php
/**
 * @author Copyright (c) 2012 fvuillemin
 *
 *This file is part of Foobar.

    Foobar is free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    (at your option) any later version.

    Foobar is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with Foobar.  If not, see <http://www.gnu.org/licenses/>.
 */
if (!function_exists('stats_standard_deviation')) {
	/**
	 * This user-land implementation follows the implementation quite strictly;
	 * it does not attempt to improve the code or algorithm in any way. It will
	 * raise a warning if you have fewer than 2 values in your array, just like
	 * the extension does (although as an E_USER_WARNING, not E_WARNING).
	 *
	 * @param array $a
	 * @param bool $sample [optional] Defaults to false
	 * @return float|bool The standard deviation or false on error.
	 */
	function stats_standard_deviation(array $a, $sample = false) {
		$n = count($a);
		if ($n === 0) {
			trigger_error("The array has zero elements", E_USER_WARNING);
			return false;
		}
		if ($sample && $n === 1) {
			trigger_error("The array has only 1 element", E_USER_WARNING);
			return false;
		}
		$mean = array_sum($a) / $n;
		$carry = 0.0;
		foreach ($a as $val) {
			$d = ((double) $val) - $mean;
			$carry += $d * $d;
		};
		if ($sample) {
			--$n;
		}
		return sqrt($carry / $n);
	}
}
function unit_stat(family $my){
	$my->basket = $my->drawers;
	echo "<table style='border: solid 2px black;'><thead><tr style='border: solid 2px black;'><th></th>";
	foreach ($my->members as $nom=>$value){
		echo "<th>$nom</th>";
	}
	echo "<th>Total</th></tr></thead><tbody><";
	$iter = $my->members;
	unset($iter['francoisregis']);
	unset($iter['mariehelene']);
	foreach ($iter as $iter_id=>$iter_menber){
		foreach ($my->members as $id => $member){
			$stat[$id] = 0;
		}
		$failed = 0;
		$elapsed_time = microtime(TRUE);
		$nb_tries=(count($my->basket)-2)*500;
		for($i=0; $i<$nb_tries; $i++){
			$draw=$my->pull($my->members['francoisregis']->id);
			if(FALSE == $draw){
				$failed++;
			}else{
				$stat[$draw->id]++;
			}
		}
		unset($my->basket[$iter_id]);
		$elapsed_time = microtime(TRUE) - $elapsed_time;
		$somme=0;
		echo "<tr><td></td>";
		unset ($stat2);
		foreach ($stat as $id=>$value){
			if (0 != $value) $stat2[] = $value;
			echo "<td>$value</td>";
			$somme += $value;
		}
		echo "<td>sigma:".stats_standard_deviation($stat2)."<br>elapsed time : $elapsed_time<br>failed : $failed</td></tr>";
	}
	echo "</table>";
}
function draw_stat($my){
	$famille2 	= $my->getMembers();
	$basket		= $famille2;
	foreach ($famille2 as $drawer){
		foreach($basket as $drawn){
			$stat[$drawer->id][$drawn->id]=0;
		}
	}
	$failed = 0;
	$elappsed_time = microtime(TRUE);
	if(isset($_REQUEST['count'])){
		$count = $_REQUEST['count'];
	}else{
		$count = 140;
	}
	for($i=0; $i<$count; $i++){
		$gift = $my->getGiftDraw();
		if($gift){
			foreach ($gift as $drawer => $drawn){
				$stat[$drawer][$drawn]++;
			}
		}else
			$failed++;
	}
	$elappsed_time = microtime(TRUE) - $elappsed_time;
	echo "<table class='stat'><thead><tr><th></th>";
	foreach ($famille2 as $nom){
		echo "<th>$nom</th>";
	}
	echo "<th>σ ∕&nbsp;x̅</th></tr></thead><tbody>";
	foreach ($stat as $nom => $elem){
		echo "<tr><th>$nom</th>";
		$somme = 0;
		foreach($elem as $nb){
			echo "<td style=''>$nb</td>";$somme += $nb;
			if($nb!=0) $stat3[]=$nb;
		}
		echo "<td>".sprintf('%.2f%%',100*(stats_standard_deviation($stat3))/($somme/12))."</td></tr>";
	}
	echo "</tbody></table><span>failed : ".sprintf("%d / %d (%.2f %%)", $failed, $count, $failed/$count*100)." - elapsed time : ".sprintf('%.2f s',round($elappsed_time,2))."</span>";
}
?>