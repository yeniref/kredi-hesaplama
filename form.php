<?php if(isset($_POST['hesapla'])) {
	extract($_POST);
  /* Kredi Tutarı */
    $bul = array(' ',',','.');
    $degistir = array('','','');
	 $kredi = str_replace($bul, $degistir, $kredi); // Bu alanda kredi tutarında boşluk virgül veya nokta varsa onları kaldırıyoruz.
  /* Kredi Tutarı */
  /* Kredi Tutarı */
    $vade = $vade; // Kaç taksit olacak
  /* Kredi Tutarı */
  /* Faiz Oranı */
    $bul = array(',',' ');
    $degistir = array('.','');
    $faiz = str_replace($bul, $degistir, $faiz); // Bu alanda faiz oranı virgül ile yazılıdı ise nokta ile değiştiriyoruz ve boşluk varsa onu siliyoruz.
  /* Faiz Oranı */
  /* (Banka Sigorta Muamele Vergisi) ve (Kredi Kaynak Destekleme Fonu) */
    $bul = array(',',' ');
    $degistir = array('.','');
  	$bsmv = str_replace($bul, $degistir, $bsmv);
  	$kkdf = str_replace($bul, $degistir, $kkdf);
  /* (Banka Sigorta Muamele Vergisi) ve (Kredi Kaynak Destekleme Fonu) */
  /* Vergiiler ile beraber toplam faiz oranı hesaplanıyor */
	  $vergi_faiz = ($faiz / 100) * (1 + $bsmv + $kkdf);
  /* Vergiiler ile beraber toplam faiz oranı hesaplanıyor */
  /* Kredimizin aylık taksit tutarını hesaplıyoruz */
		$deger1 = $vergi_faiz * pow((1+$vergi_faiz),$vade);
		$deger2 = pow((1+$vergi_faiz),$vade) - 1;
		$taksit = $kredi * $deger1/$deger2;
	/* Kredimizin aylık taksit tutarını hesaplıyoruz */
?>
  				<table class="table table-bordered">
  					<tr>
  						<th>Kredi Tutarı</th>
  						<th>Kredi Vadesi</th>
  						<th>Kredi Faizi</th>
  						<th>BSMV</th>
  						<th>KKDF</th>
  						<th>Taksit Tutarı</th>
  					</tr>
  					<tr>
  						<td><?php echo number_format($kredi, 2, ',', '.');?></td>
  						<td><?php echo $vade;?></td>
  						<td><?php echo $faiz;?></td>
  						<td><?php echo $bsmv;?></td>
  						<td><?php echo $kkdf;?></td>
  						<td><?php echo number_format($taksit, 2, ',', '.');?></td>
  					</tr>
  				</table>
  				<table class="table table-bordered table-striped">
  					<tr>
  						<th>Dönem</th>
  						<th>Taksit Tutarı</th>
  						<th>Anapara</th>
  						<th>Faiz</th>
  						<th>KKDF</th>
  						<th>BSMV</th>
  						<th>Kalan Anapara</th>
  					</tr>
  					<?php
  						for ($row = '1'; $row <= $vade; $row++) {
  							if ($row == '1') {
                  // Birinci Satır
	  							$_faiz = $kredi * ($faiz / 100);
	  							$_kkdf = $_faiz * $kkdf;
	  							$_bsmv = $_faiz * $bsmv;
	  							$_anapara = $taksit - ($_faiz + $_kkdf + $_bsmv);
	  							$_kalananapara = $kredi - $_anapara;
	  							echo '<tr>';
	  							echo '<td>'.$row.'</td>';
	  							echo '<td>'.number_format($taksit, 2, ',', '.').' TL</td>';
	  							echo '<td>'.number_format($_anapara, 2, ',', '.').'</td>';
	  							echo '<td>'.number_format($_faiz, 2, ',', '.').'</td>';
	  							echo '<td>'.$_kkdf.'</td>';
	  							echo '<td>'.$_bsmv.'</td>';
	  							echo '<td>'.number_format($_kalananapara, 2, ',', '.').'</td>';
	  							echo '</tr>';
  							}else{
                  // Diğer Satırlar
	  							$_faiz = $_kalananapara * ($faiz / 100);
	  							$_kkdf = $_faiz * $kkdf;
	  							$_bsmv = $_faiz * $bsmv;
	  							$_anapara = $taksit - ($_faiz + $_kkdf + $_bsmv);
	  							$_kalananapara = $_kalananapara - $_anapara;
	  							echo '<tr>';
	  							echo '<td>'.$row.'</td>';
	  							echo '<td>'.number_format($taksit, 2, ',', '.').' TL</td>';
	  							echo '<td>'.number_format($_anapara, 2, ',', '.').'</td>';
	  							echo '<td>'.number_format($_faiz, 2, ',', '.').'</td>';
	  							echo '<td>'.number_format($_kkdf, 2, ',', '.').'</td>';
	  							echo '<td>'.number_format($_bsmv, 2, ',', '.').'</td>';
	  							echo '<td>'.number_format($_kalananapara, 2, ',', '.').'</td>';
	  							echo '</tr>';
  							}
  						}
  					?>
  				</table>
<?php  } ?>
<?php if($bsmv==''){
	$bsmv = "0";
}
if($kkdf==''){
	$kkdf = "0";
}
if($banka_adi!=''){ ?><h3><?php echo $banka_adi;?></h3><?php } ?>
                  <form action="" method="post">
  					<div>
  						<label>Kredi Tutarı</label>
  						<input type="text" class="form-control" name="kredi" placeholder="Kredi Tutarı" required />
  					</div>
  					<div>
  						<label>Vade</label>
  						<select class="form-control" name="vade" required>
  							<option value="12">1 Yıl (12 Ay)</option>
  							<option value="24">2 Yıl (24 Ay)</option>
  							<option value="36">3 Yıl (36 Ay)</option>
  							<option value="48">4 Yıl (48 Ay)</option>
  							<option value="60">5 Yıl (60 Ay)</option>
  							<option value="72">6 Yıl (72 Ay)</option>
  							<option value="84">7 Yıl (84 Ay)</option>
  							<option value="96">8 Yıl (96 Ay)</option>
  							<option value="108">9 Yıl (108 Ay)</option>
  							<option value="120">10 Yıl (120 Ay)</option>

  						</select>
  					</div>
  					<div>
  						<label>Faiz Oranı</label>
  						<input type="text" class="form-control" name="faiz" placeholder="Faiz Oranı" value="<?php echo $faiz_oran;?>" readonly />
  					</div>
  				
  						<input type="hidden" class="form-control" name="bsmv" value="<?php echo $bsmv;?>" placeholder="BSMV" /> 					
  						<input type="hidden" class="form-control" name="kkdf" value="<?php echo $kkdf;?>" placeholder="KKDF" />
  					<div>
  						<button type="submit" name="hesapla" style="float:right;color:white;width:50%;margin-top:1%;margin-bottom:1%;background:#3e843e;height:2em;">Hesapla</button>
  					</div>
  				</form>
				  