<?php
class circuito
{
	private $aventuras;
	private $logos;
	private $cores;
	private $datas;
	private $jogos;

	function __construct($aventuras)
	{
		$this->aventuras = array_keys($aventuras);
		foreach($this->aventuras as $a) {
			$this->logos[$a] = ( array_key_exists('logo', $aventuras[$a]) ? $aventuras[$a]['logo'] : null );
			$this->cores[$a] = array();
			$this->datas[$a] = array();
			$this->jogos[$a] = array();

			$this->cores[$a][] = ( array_key_exists('cor1', $aventuras[$a]) ? $aventuras[$a]['cor1'] : '#DDD' );
			$this->cores[$a][] = ( array_key_exists('cor2', $aventuras[$a]) ? $aventuras[$a]['cor2'] : '#000' );
			$this->cores[$a][] = ( array_key_exists('cor3', $aventuras[$a]) ? $aventuras[$a]['cor3'] : $this->cores[$a][0] );
			$this->cores[$a][] = ( array_key_exists('cor4', $aventuras[$a]) ? $aventuras[$a]['cor4'] : $this->cores[$a][1] );

			if(is_array($aventuras[$a]['data'])) {
				foreach($aventuras[$a]['data'] as $data) {
					if(preg_match('/^([0-9]{4})-([0-9]{1,2})-([0-9]{1,2})~([0-9]{4})-([0-9]{1,2})-([0-9]{1,2})$/', $data, $matches)) {
						$this->datas[$a][] = array(mktime(0, 0, 0, $matches[2], $matches[3], $matches[1]), mktime(0, 0, 0, $matches[5], $matches[6], $matches[4]));
					}
				}
			}

			if(is_array($aventuras[$a]['jogo'])) {
				foreach($aventuras[$a]['jogo'] as $jogo) {
					if(preg_match('/^([0-9]{4})-([0-9]{1,2})-([0-9]{1,2})$/', $jogo, $matches)) {
						$this->jogos[$a][] = mktime(0, 0, 0, $matches[2], $matches[3], $matches[1]);
					}
				}
			}
		}
	}

	function mes_extenso($mes)
	{
		$meses = array(1 => 'Janeiro', 'Fevereiro', 'Março', 'Abrir',
		'Maio', 'Junho', 'Julho', 'Agosto', 'Setembro', 'Outubro',
		'Novembro', 'Dezembro');
		return $meses[$mes];
	}

	function logo($ano, $mes, $dia)
	{
		$logos = array();
		for($i = 0; $i < 7; $i++) {
			$d = mktime(0, 0, 0, $mes, $dia + $i, $ano);
			foreach($this->aventuras as $a) {
				foreach($this->datas[$a] as $data) {
					if($d == $data[0] && !is_null($this->logos[$a])) {
						$logos[] = $a;
					}
				}
			}
		}
		if(count($logos) > 0) {
			echo "	<tr>\n";
			echo '		<td colspan="7" class="logo">';
			$logos = array_unique($logos);
			foreach($logos as $a) {
				echo '<img src="logo_'.$this->logos[$a].'" alt="'.$a.'" valign="absmiddle" />'."\n";
			}
			echo "		</td>\n";
			echo "	</tr>\n";
		}
	}

	function style($ano, $mes, $dia)
	{
		$d = mktime(0, 0, 0, $mes, $dia, $ano);
		foreach($this->aventuras as $a) {
			$j = false;
			foreach($this->jogos[$a] as $jogo) {
				if($d == $jogo) {
					$j = true;
				}
			}
			foreach($this->datas[$a] as $data) {
				if($d >= $data[0] && $d <= $data[1]) {
					return ' style="'.
						'background-color:'.$this->cores[$a][( $j ? 2 : 0 )].';'.
						'color:'           .$this->cores[$a][( $j ? 3 : 1 )].';'.
						( $j ? 'padding-right:0;padding-left:0;font-weight:bold;text-align:center;background-image:url('.preg_replace('/(^|\\/)([^\\/]+\\.[^.]+)$/', '\1jogo_\2\3', $this->logos[$a]).');background-repeat:no-repear;background-position:50% 1px;' : '' ).
					'"';
				}
			}
		}
		return '';
	}

	function mes($ano, $mes)
	{
		echo '<table border="0" cellspacing="0">'."\n";
		echo "	<tr>\n";
		echo '		<th colspan="7" class="mes">'.$this->mes_extenso($mes)."</th>\n";
		echo "	</tr>\n";
		echo "	<tr>\n";
		echo '		<th class="semana">D</th>'."\n";
		echo '		<th class="semana">S</th>'."\n";
		echo '		<th class="semana">T</th>'."\n";
		echo '		<th class="semana">Q</th>'."\n";
		echo '		<th class="semana">Q</th>'."\n";
		echo '		<th class="semana">S</th>'."\n";
		echo '		<th class="semana">S</th>'."\n";
		echo "	</tr>\n";
		$dias = date('w', mktime(0, 0, 0, $mes, 1, $ano));
		if($dias > 0) {
			echo "	<tr>\n";
			for($i = 0; $i < $dias; $i++) echo '		<td class="dia">&nbsp;</td>'."\n";
		}
		$dias = date('t', mktime(0, 0, 0, $mes, 1, $ano));
		for($i = 1; $i <= $dias; $i++) {
			$w = date('w', mktime(0, 0, 0, $mes, $i, $ano));
			if($w == 0) {
				$this->logo($ano, $mes, $i);
				echo "	<tr>\n";
			}
			echo '		<td class="dia"'.$this->style($ano, $mes, $i).'>'.$i."</td>\n";
			if($w == 6) echo "	</tr>\n";
		}
		$dias = date('w', mktime(0, 0, 0, $mes, $dias, $ano));
		if($dias < 6) {
			for($i = $dias; $i < 6; $i++) echo '		<td class="dia">&nbsp;</td>'."\n";
			echo "	</tr>\n";
		}
		echo "</table>\n";
	}

	function ano($ano)
	{
		echo '<div class="ano">'.$ano."</div>\n";
	}

	function show($de, $ate)
	{
		list($de_ano , $de_mes ) = explode('-', $de);
		list($ate_ano, $ate_mes) = explode('-', $ate);

		$de_mes  = preg_replace('/^0+/', '', $de_mes );
		$ate_mes = preg_replace('/^0+/', '', $ate_mes);

		$this->ano($de_ano);
		for($ano = $de_ano, $mes = $de_mes; $ano < $ate_ano || $mes <= $ate_mes || $mes == 12; $mes++) {
			if($mes == 13) {
				$ano++;
				$mes = 1;
				$this->ano($ano);
			}
			$this->mes($ano, $mes);
		}
	}

}
