<?php

namespace vihv;

class Color {
	
	private $rgb;
	
	public function __construct($hexRGB) {
		$this->rgb = $this->hexRgbToArray($hexRGB);
	}
	
	public function hexRgbToArray($hexRGB) {
		$hexRGB = str_replace('#', '', $hexRGB);
		$r = substr($hexRGB, 0, 2);
		$g = substr($hexRGB, 2, 2);
		$b = substr($hexRGB, 4, 2);
		return [
		    'r'=>  hexdec($r),
		    'g'=> hexdec($g),
		    'b' => hexdec($b)
		];
	}
	
	public function toNice() {
		$rgb = $this->rgb;
		$l = $this->getIntensity();
		$s = $l-2*min($rgb);
		$f = 0;
		if(min($rgb) == $rgb['b']) {
			$f = $rgb['g']-max($rgb);
		} elseif(min($rgb) == $rgb['r']) {
			$f = $rgb['b'];
		} elseif(min($rgb) == $rgb['g']) {
			$f=$rgb['r']+2*max($rgb);
		}
		$f += max($rgb);
		$f = $f/$l;
		return [$l,$s,$f];
	}
	
	
	public function fromNice($lsf) {
//		$fl = $f*$l;
//		$r;$g;$b;
//		
//		if($f < 0.5) { // max rgb = r
//			$g = $r+$fl;
//		}elseif($f >= 0.5 && $f < 1.5) { // max rgb = g
//			$b =
//		}elseif($f < 3) {
//			
//		}
	}
	
	/**
	 * @return intensity of color 
	 * 
	 * intensity = 85 for 255,0,0 (max red)
	 * intensity = 85 for 127,128,0 (yellow)
	 * intensity = 170 for 255,255,0 (max yellow)
	 * intensity = 255 for 255,255,255 (pure white)
	 */
	public function getIntensity() {
		$sum = 0;
		foreach($this->rgb as $value) {
			$sum += $value;
		}
		return $sum/count($this->rgb);
	}
	
	/**
	 * @return float [0..1]
	 */
	public function getChroma() {
		$rgb = $this->rgb; 
		$min = min($rgb);
		$max = max($rgb);
		foreach($rgb as $key=>$value) {
			$rgb[$key] = ($value-$min)/($max-$min);
		}
		$chroma = 0;
		
		if($rgb['b'] == 0) {
			$chroma = 1+$rgb['g']-$rgb['r'];
		} elseif($rgb['r'] == 0) {
			$chroma = 3+$rgb['b']-$rgb['g'];
		} elseif($rgb['g'] == 0) {
			$chroma = 5+$rgb['r']-$rgb['b'];
		}
		$chroma /= 6;
		return $chroma;
	}
	
	public function addChroma($value) {
		for($i=0;$i<$value;$i++) {
			$this->incChroma();
		}
	}
	
	/**
	 * a few tips
	 * 1. we are trying to use colors of same intensity, 
	 * however if we start with color like (255,255,0)
	 * intensity is MORE than 255. (510,0,0) is impossible, 
	 * so we king of cut extra values during toHexRgb
	 * 2. pure green (0, 255, 0) looks brighter than (255, 0, 0) or (0,0,255)
	 * so there is function fixGreen. It cut green channel in half
	 */
	public function incChroma() {
		$step = 1;
		$rgb = $this->rgb; 
		$min = min($rgb);
		$max = max($rgb);
		if($max == 0) {
			return;
		}
//		$maxStep = 255-$max;
//		var_dump($maxStep);
////		$chroma = $this->getChroma();
////		$step = $value+$chroma;
////		echo " max=";
////		var_dump($max);
//		$modStep = $step % $maxStep;
////		echo " mod=";
////		var_dump($modStep);
//		$divStep = ($step-$modStep)/$maxStep;
////		echo " div=";
////		var_dump($divStep);
//		$sector = $divStep % 3;
////		echo " sector=";
////		var_dump($sector);
//		$labels = ['r','g','b','r'];
//		
//		echo "<br/>".$labels[$sector]." -> ".$labels[$sector+1]."::".$modStep;
//		
//		$this->rgb[$labels[$sector]] -=$modStep;
//		$this->rgb[$labels[$sector+1]] +=$modStep;
//		var_dump($modStep);
//		var_dump($this->rgb);
		
//		$deltaRgb = [];
//		foreach ($rgb as $key=>$value) {
//			$deltaRgb[$key] = $value - $min;
//		}
//		$sumDelta = 0;
//		foreach($deltaRgb as $value) {
//			$sumDelta += $value;
//		}
		
		if($rgb['b'] == $min
			&& $rgb['r'] >= $min+$step ) {
			$this->rgb['r'] -=$step;
			$this->rgb['g'] +=$step;
			return;
		}
		if($rgb['r'] == $min
			&& $rgb['g'] >= $min+$step) {
			$this->rgb['g'] -=$step;
			$this->rgb['b'] +=$step;
			return;
		}
		if($rgb['g'] == $min
			&& $rgb['b'] >= $min+$step) {
			$this->rgb['b'] -=$step;
			$this->rgb['r'] +=$step;
			return;
		}
	}
	
	public function doubleGreen() {
		$this->rgb['g'] *= 2;
	}


	public function fixGreen() {
		$this->rgb['g'] = round($this->rgb['g'] / 2);
	}
	
	/**
	 * hue rely on hexadon, we will rely on triandle, so intensity will be always the same
	 */
//	public function getChroma() {
//		
//	}
	
	public function getSaturation() {
		$rgb = $this->getNormalizedRgb();
		$max = max($rgb);
		$min = min($rgb);
		$d = $max - $min;
		$l = ( $max + $min ) / 2;
		if( $d == 0 ){
			return  0; // achromatic
		} else {
			return round($d*255 / ( 1 - abs( 2 * $l - 1 ) ));
		}
	}
	
	public function getLuminosity() {
		$rgb = $this->getNormalizedRgb();
		$max = max($rgb);
		$min = min($rgb);
		
		return round(( $max + $min )*255 / 2);
	}
	
	public function getHue() {
		$rgb = $this->getNormalizedRgb();
		$max = max($rgb);
		$min = min($rgb);
		
		$h = 0;
		$d = $max - $min;
		if( $d == 0 ){ 
			return 0; //acromatic
		}
		
		switch( $max ){
			case $rgb['r']:
				$h = 60 * fmod( ( ( $g - $b ) / $d ), 6 );
				if ($b > $g) {
					$h += 360;
				}
			break;

			case $rgb['g']:
				$h = 60 * ( ( $b - $r ) / $d + 2 );
			break;

			case $rgb['b']:
				$h = 60 * ( ( $r - $g ) / $d + 4 );
			break;
		}
		return round($h);		
	}
	
	/**
	 * @return array of color values divided by 255
	 */
	public function getNormalizedRgb() {
		$re = [];
		foreach ($this->rgb as $key=>$value) {
			$re[$key] = $value/255;
		}
		return $re;
	}
	
	public function arrayToHex($array) {
		$string = '';
		foreach($array as $value) {
			if($value > 255) {
				$value = 255;
//				throw new Exception('Wut!val '.$value);
			}
			if($value < 0) { 
				throw new Exception('Wut!val '.$value);
			}
			$hex = dechex($value);
			if(strlen($hex) == 1) {
				$hex = "0".$hex;
			}
			if(strlen($hex) !== 2) {
				throw new Exception('Wut!hex '.$hex);
			}
			$string .= $hex;
		}
		return $string;
	}
	
	public function toHsl() {
		$h = $this->getHue();
		$s = $this->getSaturation();
		$l = $this->getLuminosity();
		return ['h'=>$h, 's'=>$s, 'l'=>$l];
	}
	
	
	public function toHexHsl() {
		return $this->arrayToHex($this->toHsl());
	}
	
	public function toRgb() {
		return $this->rgb;
	}
	
	public function toHexRgb() {
		return $this->arrayToHex($this->toRgb());
	}
	
//	function rgbToHsl( $r, $g, $b ) {
//$oldR = $r;
//$oldG = $g;
//$oldB = $b;
// 
//$r /= 255;
//$g /= 255;
//$b /= 255;
// 
//    $max = max( $r, $g, $b );
//$min = min( $r, $g, $b );
// 
//$h;
//$s;
//$l = ( $max + $min ) / 2;
//$d = $max - $min;
// 
//     if( $d == 0 ){
//         $h = $s = 0; // achromatic
//     } else {
//         $s = $d / ( 1 - abs( 2 * $l - 1 ) );
// 
//switch( $max ){
//            case $r:
//             $h = 60 * fmod( ( ( $g - $b ) / $d ), 6 );
//                        if ($b > $g) {
//                    $h += 360;
//                }
//                break;
// 
//            case $g:
//             $h = 60 * ( ( $b - $r ) / $d + 2 );
//             break;
// 
//            case $b:
//             $h = 60 * ( ( $r - $g ) / $d + 4 );
//             break;
//        }	                 
//}
// 
//return array( round( $h, 2 ), round( $s, 2 ), round( $l, 2 ) );
//}


function hslToRgb($h, $s, $l) {
		$r;
		$g;
		$b;
		$c = ( 1 - abs(2 * $l - 1) ) * $s;
		$x = $c * ( 1 - abs(fmod(( $h / 60), 2) - 1) );
		$m = $l - ( $c / 2 );
		if ($h < 60) {
			$r = $c;
			$g = $x;
			$b = 0;
		} else if ($h < 120) {
			$r = $x;
			$g = $c;
			$b = 0;
		} else if ($h < 180) {
			$r = 0;
			$g = $c;
			$b = $x;
		} else if ($h < 240) {
			$r = 0;
			$g = $x;
			$b = $c;
		} else if ($h < 300) {
			$r = $x;
			$g = 0;
			$b = $c;
		} else {
			$r = $c;
			$g = 0;
			$b = $x;
		} $r = ( $r + $m ) * 255;
		$g = ( $g + $m ) * 255;
		$b = ( $b + $m ) * 255;
		return array(floor($r), floor($g), floor($b));
	}

}
