<div class="usa-gas-prices-wrapper">
	<h2>U.S. Regular Gasoline Prices</h2>
	<span>(dollars per gallon)</span>
  <div id="usa-gasoline-prices">
		<table>
			<thead>
				<tr>
					<th></th>
					<?php 
						foreach(array_reverse($data['U.S.']) as $d){
							echo "<th>".$d['period']."</th>";
						}
					?>
					<th>week ago</th>
					<th>year ago</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td>U.S.</td>
					<?php 
						foreach(array_reverse($data['U.S.']) as $d){
							echo "<td>".number_format((float)$d['value'], 3, '.', '')."</td>";
						}
						$week_diff = number_format($data['U.S.'][0]['value'] - $data['U.S.'][1]['value'], 3, '.', '');
						$year_diff = number_format($data['U.S.'][0]['value'] - $year_ago['U.S.'][0]['value'], 3, '.', '');
					?>
					<td class="<?php echo $week_diff < 0 ? 'value_down' : 'value_up'; ?>"><?php echo $week_diff; ?></td>
					<td class="<?php echo $year_diff < 0 ? 'value_down' : 'value_up'; ?>"><?php echo $year_diff; ?></td>
				</tr>
				<tr>
					<td>East Coast (PADD1)</td>
					<?php 
						foreach(array_reverse($data['PADD 1']) as $d){
							echo "<td>".number_format((float)$d['value'], 3, '.', '')."</td>";
						}
						$week_diff = number_format($data['PADD 1'][0]['value'] - $data['PADD 1'][1]['value'], 3, '.', '');
						$year_diff = number_format($data['PADD 1'][0]['value'] - $year_ago['PADD 1'][0]['value'], 3, '.', '');
					?>
					<td class="<?php echo $week_diff < 0 ? 'value_down' : 'value_up'; ?>"><?php echo $week_diff; ?></td>
					<td class="<?php echo $year_diff < 0 ? 'value_down' : 'value_up'; ?>"><?php echo $year_diff; ?></td>
				</tr>
				<tr>
					<td class="level-1-indent">New England (PADD1A)</td>
					<?php 
						foreach(array_reverse($data['PADD 1A']) as $d){
							echo "<td>".number_format((float)$d['value'], 3, '.', '')."</td>";
						}
						$week_diff = number_format($data['PADD 1A'][0]['value'] - $data['PADD 1A'][1]['value'], 3, '.', '');
						$year_diff = number_format($data['PADD 1A'][0]['value'] - $year_ago['PADD 1A'][0]['value'], 3, '.', '');
					?>
					<td class="<?php echo $week_diff < 0 ? 'value_down' : 'value_up'; ?>"><?php echo $week_diff; ?></td>
					<td class="<?php echo $year_diff < 0 ? 'value_down' : 'value_up'; ?>"><?php echo $year_diff; ?></td>
				</tr>
				<tr>
					<td class="level-1-indent">Central Atlantic (PADD1B)</td>
					<?php 
						foreach(array_reverse($data['PADD 1B']) as $d){
							echo "<td>".number_format((float)$d['value'], 3, '.', '')."</td>";
						}
						$week_diff = number_format($data['PADD 1B'][0]['value'] - $data['PADD 1B'][1]['value'], 3, '.', '');
						$year_diff = number_format($data['PADD 1B'][0]['value'] - $year_ago['PADD 1B'][0]['value'], 3, '.', '');
					?>
					<td class="<?php echo $week_diff < 0 ? 'value_down' : 'value_up'; ?>"><?php echo $week_diff; ?></td>
					<td class="<?php echo $year_diff < 0 ? 'value_down' : 'value_up'; ?>"><?php echo $year_diff; ?></td>
				</tr>
				<tr>
					<td class="level-1-indent">Lower Atlantic (PADD1C)</td>
					<?php 
						foreach(array_reverse($data['PADD 1C']) as $d){
							echo "<td>".number_format((float)$d['value'], 3, '.', '')."</td>";
						}
						$week_diff = number_format($data['PADD 1C'][0]['value'] - $data['PADD 1C'][1]['value'], 3, '.', '');
						$year_diff = number_format($data['PADD 1C'][0]['value'] - $year_ago['PADD 1C'][0]['value'], 3, '.', '');
					?>
					<td class="<?php echo $week_diff < 0 ? 'value_down' : 'value_up'; ?>"><?php echo $week_diff; ?></td>
					<td class="<?php echo $year_diff < 0 ? 'value_down' : 'value_up'; ?>"><?php echo $year_diff; ?></td>
				</tr>
				<tr>
					<td>Midwest (PADD2)</td>
					<?php 
						foreach(array_reverse($data['PADD 2']) as $d){
							echo "<td>".number_format((float)$d['value'], 3, '.', '')."</td>";
						}
						$week_diff = number_format($data['PADD 2'][0]['value'] - $data['PADD 2'][1]['value'], 3, '.', '');
						$year_diff = number_format($data['PADD 2'][0]['value'] - $year_ago['PADD 2'][0]['value'], 3, '.', '');
					?>
					<td class="<?php echo $week_diff < 0 ? 'value_down' : 'value_up'; ?>"><?php echo $week_diff; ?></td>
					<td class="<?php echo $year_diff < 0 ? 'value_down' : 'value_up'; ?>"><?php echo $year_diff; ?></td>
				</tr>
				<tr>
					<td>Gulf Coast (PADD3)</td>
					<?php 
						foreach(array_reverse($data['PADD 3']) as $d){
							echo "<td>".number_format((float)$d['value'], 3, '.', '')."</td>";
						}
						$week_diff = number_format($data['PADD 3'][0]['value'] - $data['PADD 3'][1]['value'], 3, '.', '');
						$year_diff = number_format($data['PADD 3'][0]['value'] - $year_ago['PADD 3'][0]['value'], 3, '.', '');
					?>
					<td class="<?php echo $week_diff < 0 ? 'value_down' : 'value_up'; ?>"><?php echo $week_diff; ?></td>
					<td class="<?php echo $year_diff < 0 ? 'value_down' : 'value_up'; ?>"><?php echo $year_diff; ?></td>
				</tr>
				<tr>
					<td>Rocky Mountain (PADD4)</td>
					<?php 
						foreach(array_reverse($data['PADD 4']) as $d){
							echo "<td>".number_format((float)$d['value'], 3, '.', '')."</td>";
						}
						$week_diff = number_format($data['PADD 4'][0]['value'] - $data['PADD 4'][1]['value'], 3, '.', '');
						$year_diff = number_format($data['PADD 4'][0]['value'] - $year_ago['PADD 4'][0]['value'], 3, '.', '');
					?>
					<td class="<?php echo $week_diff < 0 ? 'value_down' : 'value_up'; ?>"><?php echo $week_diff; ?></td>
					<td class="<?php echo $year_diff < 0 ? 'value_down' : 'value_up'; ?>"><?php echo $year_diff; ?></td>
				</tr>
				<tr>
					<td>West Coast (PADD5)</td>
					<?php 
						foreach(array_reverse($data['PADD 5']) as $d){
							echo "<td>".number_format((float)$d['value'], 3, '.', '')."</td>";
						}
						$week_diff = number_format($data['PADD 5'][0]['value'] - $data['PADD 5'][1]['value'], 3, '.', '');
						$year_diff = number_format($data['PADD 5'][0]['value'] - $year_ago['PADD 5'][0]['value'], 3, '.', '');
					?>
					<td class="<?php echo $week_diff < 0 ? 'value_down' : 'value_up'; ?>"><?php echo $week_diff; ?></td>
					<td class="<?php echo $year_diff < 0 ? 'value_down' : 'value_up'; ?>"><?php echo $year_diff; ?></td>
				</tr>
				<tr>
					<td class="level-1-indent">West Coast less California</td>
					<?php 
						foreach(array_reverse($data['PADD 5 EXCEPT CALIFORNIA']) as $d){
							echo "<td>".number_format((float)$d['value'], 3, '.', '')."</td>";
						}
						$week_diff = number_format($data['PADD 5 EXCEPT CALIFORNIA'][0]['value'] - $data['PADD 5 EXCEPT CALIFORNIA'][1]['value'], 3, '.', '');
						$year_diff = number_format($data['PADD 5 EXCEPT CALIFORNIA'][0]['value'] - $year_ago['PADD 5 EXCEPT CALIFORNIA'][0]['value'], 3, '.', '');
					?>
					<td class="<?php echo $week_diff < 0 ? 'value_down' : 'value_up'; ?>"><?php echo $week_diff; ?></td>
					<td class="<?php echo $year_diff < 0 ? 'value_down' : 'value_up'; ?>"><?php echo $year_diff; ?></td>
				</tr>
			</tbody>
		</table>
  </div>
</div>