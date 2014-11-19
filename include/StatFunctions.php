<?php
/**
 * @author Copyright (c) 2012 François-Régis Vuillemin (frv) <frv@miradou.com>
 *
 * This file is part of famille@miradou
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 * 
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 * 
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 */
if (! function_exists ( 'stats_standard_deviation' )) {
	/**
	 * This user-land implementation follows the implementation quite strictly;
	 * it does not attempt to improve the code or algorithm in any way.
	 * It will
	 * raise a warning if you have fewer than 2 values in your array, just like
	 * the extension does (although as an E_USER_WARNING, not E_WARNING).
	 *
	 * @param array $a        	
	 * @param bool $sample
	 *        	[optional] Defaults to false
	 * @return float|bool The standard deviation or false on error.
	 */
	function stats_standard_deviation(array $a, $sample = false) {
		$n = count ( $a );
		if ($n === 0) {
			trigger_error ( "The array has zero elements", E_USER_WARNING );
			return false;
		}
		if ($sample && $n === 1) {
			trigger_error ( "The array has only 1 element", E_USER_WARNING );
			return false;
		}
		$mean = array_sum ( $a ) / $n;
		$carry = 0.0;
		foreach ( $a as $val ) {
			$d = (( double ) $val) - $mean;
			$carry += $d * $d;
		}
		;
		if ($sample) {
			-- $n;
		}
		return sqrt ( $carry / $n );
	}
}
function unit_stat(family $my) {
	$my->basket = $my->drawers;
	echo "<table style='border: solid 2px black;'><thead><tr style='border: solid 2px black;'><th></th>";
	foreach ( $my->members as $nom => $value ) {
		echo "<th>$nom</th>";
	}
	echo "<th>Total</th></tr></thead><tbody><";
	$iter = $my->members;
	unset ( $iter ['francoisregis'] );
	unset ( $iter ['mariehelene'] );
	foreach ( $iter as $iter_id => $iter_menber ) {
		foreach ( $my->members as $id => $member ) {
			$stat [$id] = 0;
		}
		$failed = 0;
		$elapsed_time = microtime ( TRUE );
		$nb_tries = (count ( $my->basket ) - 2) * 500;
		for($i = 0; $i < $nb_tries; $i ++) {
			$draw = $my->pull ( $my->members ['francoisregis']->id );
			if (FALSE == $draw) {
				$failed ++;
			} else {
				$stat [$draw->id] ++;
			}
		}
		unset ( $my->basket [$iter_id] );
		$elapsed_time = microtime ( TRUE ) - $elapsed_time;
		$somme = 0;
		echo "<tr><td></td>";
		unset ( $stat2 );
		foreach ( $stat as $id => $value ) {
			if (0 != $value)
				$stat2 [] = $value;
			echo "<td>$value</td>";
			$somme += $value;
		}
		echo "<td>sigma:" . stats_standard_deviation ( $stat2 ) . "<br>elapsed time : $elapsed_time<br>failed : $failed</td></tr>";
	}
	echo "</table>";
}
function draw_stat($my) {
	$famille2 = $my->getMembers ();
	$basket = $famille2;
	foreach ( $famille2 as $drawer ) {
		foreach ( $basket as $drawn ) {
			$stat [$drawer->id] [$drawn->id] = 0;
		}
	}
	$failed = 0;
	$elappsed_time = microtime ( TRUE );
	if (isset ( $_REQUEST ['count'] )) {
		$count = $_REQUEST ['count'];
	} else {
		$count = 2000;
	}
	for($i = 0; $i < $count; $i ++) {
		$gift = $my->getGiftDraw ();
		if ($gift) {
			foreach ( $gift as $drawer => $drawn ) {
				$stat [$drawer] [$drawn] ++;
			}
		} else
			$failed ++;
	}
	$elappsed_time = microtime ( TRUE ) - $elappsed_time;
	echo "<table class='stat'><thead><tr><th></th>";
	foreach ( $famille2 as $nom ) {
		echo "<th>$nom</th>";
	}
	echo "<th>σ ∕&nbsp;x̅</th></tr></thead><tbody>";
	foreach ( $stat as $nom => $elem ) {
		echo "<tr><th>$nom</th>";
		$somme = 0;
		foreach ( $elem as $nb ) {
			echo "<td style=''>$nb</td>";
			$somme += $nb;
			if ($nb != 0)
				$stat3 [] = $nb;
		}
		echo "<td>" . sprintf ( '%.2f%%', 100 * (stats_standard_deviation ( $stat3 )) / ($somme / 12) ) . "</td></tr>";
	}
	echo "</tbody></table><span>failed : " . sprintf ( "%d / %d (%.2f %%)", $failed, $count, $failed / $count * 100 ) . " - elapsed time : " . sprintf ( '%.2f s', round ( $elappsed_time, 2 ) ) . "</span>";
}
?>
