<div id="header_link">
    <a class="button" href="login/logout">Logout</a>
</div>
<div id="body">
    <div id="header">
		<div id="header_content">
			<h2>Laporan</h2>
		</div>
    </div>
    <?php
        $current_tanggal = "";
		
		$total_omzet = array();
		$total_harga_min = array();
		$total_bonus = array();
		$total_setor = array();
		$total_belum_dibayar = array();
		
		$total_bonus_membership = array();
		
		$total_omzet['all'] = 0;
		$total_harga_min['all'] = 0;
		$total_bonus['all'] = 0;
		$total_setor['all'] = 0;
		$total_belum_dibayar['all'] = 0;
		
		$list_nama_setor = array();
		$list_nama_belum_dibayar = array();
		$list_barang_terjual = array();
		
		// $total_harga_setor = 0;
		// $total_belum_dibayar = 0;
		
		$total_omzet['default'] = 0;
		$total_harga_min['default'] = 0;
		$total_bonus['default'] = 0;
		$total_belum_dibayar['default'] = 0;
		
		$menu_setor = array();
        foreach ($orders as $order)
        {
            if ($current_tanggal != date("d-M-Y", strtotime($order->waktu)))
            {
                //dipisah sesuai tanggal (siapatau ada salah session)
				if ($current_tanggal != "")
				{
					?>
					<hr size="2"/>
					<?php
				}
                $current_tanggal = date("d-M-Y", strtotime($order->waktu));
                ?>
                <div class="tanggal"><h3><?=$current_tanggal?></h3></div>
                <?php
            }
            ?>
            <table id="tabel_order-<?=$order->id?>" onclick="toggle_menu(<?=$order->id?>)">
				<tr>
					<td class="header no_pembeli">#<?=$order->no_pembeli?></td>
					<td class="header nama_pembeli" colspan="2"><?=$order->customer_id?></td>
					<td class="header waktu" colspan="2"><?="<".date("H:i:s", strtotime($order->waktu)).">"?></td>
					<td class="header paid <?=$order->paid?"success":"failure"?>">
						<?=$order->paid?"&#10004; Paid":"&#10008; Not Paid"?>
					</td>
				</tr>
				<tr>
					<td class="header label-keterangan">Keterangan : </td>
					<td class="header keterangan" colspan="5"><?=$order->keterangan?></td>
				</tr>
				<tr>
					<td class="header label-default_discount" colspan="5">Default Discount : </td>
					<td class="header default_discount"><?=$order->default_discount?>%</td>
				</tr>
				<tr class="menu_detail-<?=$order->id?>">
					<td class="menu_header nama_menu_label">Item</td>
					<td class="menu_header jumlah_menu_label">Jml</td>
					<td class="menu_header harga_awal_menu_label">Harga Awal</td>
					<td class="menu_header discount_menu_label">Discount</td>
					<td class="menu_header harga_akhir_menu_label">Harga Akhir</td>
					<td class="menu_header subtotal_menu_label">Subtotal</td>
				<tr/>
					<?php
						//iterasi menu dulu di sini, status paid pas di harga akhir
						$total_harga = 0;
						foreach ($order->menu as $menu)
						{
							?>
							<tr class="menu_detail-<?=$order->id?>">
							<td class="menu nama_menu"><?=$menu->nama?><br/><?=$menu->keterangan?"(".$menu->keterangan.")":""?></td>
							<td class="menu jumlah_menu"><?=$menu->jumlah?></td>
							<td class="menu harga_awal_menu"><?=$text_renderer->to_rupiah($menu->harga_awal)?></td>
							<td class="menu discount_menu"><?=$menu->discount?>%</td>
							<td class="menu harga_akhir_menu"><?=$text_renderer->to_rupiah($menu->harga_akhir)?></td>
							<?php $subtotal = $menu->jumlah * $menu->harga_akhir; ?>
							<?php /*$subtotal_min = $menu->jumlah * $menu->harga_min;*/ ?>
							<td class="menu subtotal_menu"><?=$text_renderer->to_rupiah($subtotal)?></td>
							<?php if ($order->paid) {$total_harga += $subtotal;} ?>
							
							<?php 
								if (!isset($list_barang_terjual[$menu->tipe."-".$menu->id]['nama']))
								{
									$list_barang_terjual[$menu->tipe."-".$menu->id]['nama'] = $menu->nama;
									$list_barang_terjual[$menu->tipe."-".$menu->id]['jumlah'] = $menu->jumlah;
									$list_barang_terjual[$menu->tipe."-".$menu->id]['desc'] = $order->customer_id." (".$menu->jumlah.")";
								}
								else
								{
									$list_barang_terjual[$menu->tipe."-".$menu->id]['jumlah'] += $menu->jumlah;
									$list_barang_terjual[$menu->tipe."-".$menu->id]['desc'] .= ", ".$order->customer_id." (".$menu->jumlah.")";
								}
							?>
							
							<!--<$subtotal_harga_min = $menu->jumlah * $menu->harga_min; ?>-->
							<!--< $subtotal_harga_base = $menu->jumlah * $menu->harga_base; ?-->
							<!--< if (!$order->paid) {$total_belum_dibayar += $subtotal_harga_base;} ?-->
							<?php
								if ($menu->harga_setor > 0) //kalo harus setor titip jual
								{
									//ngecek apa udah ada nama setor yg sama
									if (!isset($menu_setor[$menu->nama_setor]))
									{
										$menu_setor[$menu->nama_setor] = array();
										
										$total_omzet['titip'][$menu->nama_setor] = 0;
										$total_harga_min['titip'][$menu->nama_setor] = 0;
										$total_bonus['titip'][$menu->nama_setor] = 0;
										$total_setor['titip'][$menu->nama_setor] = 0;
										$total_belum_dibayar['titip'][$menu->nama_setor] = 0;
									}
									
									//ngecek apa udah ada nama setor & nama menu yg sama
									if (!isset($menu_setor[$menu->nama_setor][$menu->nama])) // kalo menu di nama setor yg bersangkutan blm ada, masukin aja harga setornya
									{
										$menu_setor[$menu->nama_setor][$menu->nama] = array();
										$menu_setor[$menu->nama_setor][$menu->nama]['jumlah'] = $menu->jumlah;
										$menu_setor[$menu->nama_setor][$menu->nama]['harga_setor'] = $menu->harga_setor;
										$menu_setor[$menu->nama_setor][$menu->nama]['subtotal'] = $menu->jumlah * $menu->harga_setor;
									}
									else // kalo udah ada, dijumlahin
									{
										$menu_setor[$menu->nama_setor][$menu->nama]['jumlah'] += $menu->jumlah;
										$menu_setor[$menu->nama_setor][$menu->nama]['subtotal'] += $menu->jumlah * $menu->harga_setor;
									}
									
									//algoritma
									if ($order->paid)
									{
										if (!in_array($menu->nama_setor, $list_nama_setor)) {$list_nama_setor[] = $menu->nama_setor;} // kalo nama setor blm ada di dalem array
										
										$total_omzet['titip'][$menu->nama_setor] += $menu->jumlah * $menu->harga_akhir;
										$total_harga_min['titip'][$menu->nama_setor] += $menu->jumlah * ($menu->harga_min - $menu->harga_setor);
										$total_bonus['titip'][$menu->nama_setor] += $menu->jumlah * ($menu->harga_akhir - $menu->harga_min);
										$total_setor['titip'][$menu->nama_setor] += $menu->jumlah * $menu->harga_setor;
										
										$total_omzet['all'] += $menu->jumlah * $menu->harga_akhir;
										$total_harga_min['all'] += $menu->jumlah * ($menu->harga_min - $menu->harga_setor);
										$total_bonus['all'] += $menu->jumlah * ($menu->harga_akhir - $menu->harga_min);
									}
									else
									{
										if (!in_array($menu->nama_setor, $list_nama_belum_dibayar)) {$list_nama_belum_dibayar[] = $menu->nama_setor;} // kalo nama setor blm ada di dalem array
										$total_belum_dibayar['titip'][$menu->nama_setor] += $menu->jumlah * $menu->harga_base;
										
										$total_belum_dibayar['all'] += $menu->jumlah * $menu->harga_base;
									}
								}
								else //kalo bukan setoran, masukin harga modal
								{
									//inisialisasi
									if (!isset($total_omzet['default']))
									{
										$total_omzet['default'] = 0;
										$total_harga_min['default'] = 0;
										$total_bonus['default'] = 0;
										$total_belum_dibayar['default'] = 0;
									}
									//algoritma
									if ($order->paid)
									{
										$total_omzet['default'] += $menu->jumlah * $menu->harga_akhir;
										$total_harga_min['default'] += $menu->jumlah * $menu->harga_base;
										
										// if(!$order->customer_id) //bonus default
										// {
											$total_bonus['default'] += $menu->jumlah * ($menu->harga_akhir - $menu->harga_base);
										// }
										// else //bonus membership
										// {
											// $total_bonus_membership['']
										// }
									}
									else
									{
										$total_belum_dibayar['default'] += $menu->jumlah * $menu->harga_base;
									}
								}
							?>
							<tr/>
							<?php
						}
					?>
					<tr class="menu_footer">
						<td class="menu_footer label-total_harga" colspan="5">Total : </td>
						<td class="menu_footer total_harga"><?=$text_renderer->to_rupiah($total_harga)?></td>
					</tr>
            </table>
			<br/>
            <?php
        }
		$total_omzet['all'] += $total_omzet['default'];
		$total_harga_min['all'] += $total_harga_min['default'];
		$total_bonus['all'] += $total_bonus['default'];
		$total_belum_dibayar['all'] += $total_belum_dibayar['default'];
    ?>
	
	<?php
		if (count($menu_setor) > 0)
		{
			?>
			<h3>Setoran :</h3>
			<?php
		}
		$it=0;
		foreach($menu_setor as $nama_setor => $setorans)
		{
			?>
			<table id="tabel_setor-<?=$it?>" onclick="toggle_menu_setor(<?=$it?>)">
				<tr>
					<td class="header label-nama_setor" colspan="3">Nama Setor : </td>
					<td class="header nama_setor"><?=$nama_setor?></td>
				</tr>
				<tr class="menu_setor_detail-<?=$it?>">
					<td class="menu_header nama_menu_label">Menu</td>
					<td class="menu_header jumlah_menu_label">Jml</td>
					<td class="menu_header harga_setor_menu_label">Harga Setor</td>
					<td class="menu_header subtotal_menu_label">Subtotal</td>
				</tr>
				<?php
					$total_harga = 0;
					foreach ($setorans as $nama_menu => $setoran)
					{
						?>
						<tr class="menu_setor_detail-<?=$it?>">
							<td class="menu nama_menu"><?=$nama_menu?></td>
							<td class="menu jumlah_menu"><?=$setoran['jumlah']?></td>
							<td class="menu harga_setor_menu"><?=$text_renderer->to_rupiah($setoran['harga_setor'])?></td>
							<td class="menu subtotal_menu"><?=$text_renderer->to_rupiah($setoran['subtotal'])?></td>
							<?php /*$total_harga += $setoran['subtotal'];*/ ?>
							<?php /*$total_harga_setor += $setoran['subtotal'];*/ ?>
						</tr>
						<?php
					}
				?>
				<tr class="menu_setor_detail-<?=$it?>">
					<td class="menu_footer label-total_omzet" colspan="3">Omzet: </td>
					<td class="menu_footer total_omzet"><?=$text_renderer->to_rupiah($total_omzet['titip'][$nama_setor])?></td>
				</tr>
				<tr class="menu_setor_detail-<?=$it?>">
					<td class="menu_footer label-total_harga_min" colspan="3">Modal: </td>
					<td class="menu_footer total_harga_min"><?=$text_renderer->to_rupiah($total_harga_min['titip'][$nama_setor])?></td>
				</tr>
				<tr class="menu_setor_detail-<?=$it?>">
					<td class="menu_footer label-total_bonus" colspan="3">Bonus: </td>
					<td class="menu_footer total_bonus"><?=$text_renderer->to_rupiah($total_bonus['titip'][$nama_setor])?></td>
				</tr>
				<tr class="menu_footer">
					<td class="menu_footer label-total_harga_setor" colspan="3">Total Setor: </td>
					<td class="menu_footer total_harga_setor"><?=$text_renderer->to_rupiah($total_setor['titip'][$nama_setor])?></td>
				</tr>
			</table>
			<br/>
			<?php
			$it++;
		}
	?>
	
	<br/>
	<hr size=1/>
	
	<?php
	if (count($list_barang_terjual) > 0)
		{
			?>
			<h3>List Barang :</h3>
			<?php
		}
		ksort($list_barang_terjual);
		?>
		<table id="list_barang_terjual">
		<?php
		$last_key = "";
		$it=0;
		foreach($list_barang_terjual as $cur_key => $barang_terjual)
		{
			$cur_key = explode("-", $cur_key)[0];
			if ($last_key != $cur_key)
			{
				?>
				<tr><td colspan=3><h4><?=$cur_key?> :</h4></td></tr>
				<?php
				$last_key = $cur_key;
			}
			?>
			<tr>
				<td><?=$barang_terjual['nama']?></td><td> : </td>
				<td><?=$barang_terjual['jumlah']?></td>
				<td>(<?=$barang_terjual['desc']?>)</td>
			</tr>
			<?php
		}
		?>
		</table>
		<?php
	?>
	
	<br/>
	<hr size=1/>
	
	<h3>Summary :</h3>
	<table id="session_summary">
		<tr class="total_omzet">
			<td>Total Omzet BlackJack</td><td> : </td>
			<td class="tabel_rupiah"><?=$text_renderer->to_rupiah($total_omzet['default'])?></td>
		</tr>
		<tr class="total_bersih">
			<td>&nbsp;&nbsp;&nbsp;Kas Modal (Utama)</td><td> : </td>
			<td class="tabel_rupiah"><?=$text_renderer->to_rupiah($total_harga_min['all'])?></td>
		</tr>
		<?php
			foreach($list_nama_setor as $nama_setor)
			{
				?>
				<tr class="total_harga_setor">
					<td>&nbsp;&nbsp;&nbsp;Kas Modal (<?=$nama_setor?>)</td><td> : </td>
					<td class="tabel_rupiah"><?=$text_renderer->to_rupiah($total_setor['titip'][$nama_setor])?></td>
				</tr>
				<?php
			}
		?>
		<tr class="total_bonus">
			<td>Kas Bonus (All)</td><td> : </td>
			<td class="tabel_rupiah"><?=$text_renderer->to_rupiah($total_bonus['all'])?></td>
		</tr>
		
		<?php
			if ($total_belum_dibayar['default'] != 0)
			{
				?>
				<tr class="total_belum_dibayar">
					<td>&nbsp;&nbsp;&nbsp;Belum Dibayar (Produk)</td><td> : </td>
					<td class="tabel_rupiah"><?=$text_renderer->to_rupiah($total_belum_dibayar['default'])?></td>
				</tr>
				<?php
			}
		?>
		
		<?php
			foreach($list_nama_belum_dibayar as $nama_setor)
			{
				?>
				<tr class="total_belum_dibayar">
					<td>&nbsp;&nbsp;&nbsp;Belum Dibayar (<?=$nama_setor?>)</td><td> : </td>
					<td class="tabel_rupiah"><?=$text_renderer->to_rupiah($total_belum_dibayar['titip'][$nama_setor])?></td>
				</tr>
				<?php
			}
		?>
		<!--tr class="total_belum_dibayar">
			<td>Belum Dibayar (All)</td><td> : </td>
			<td class="tabel_rupiah"><?=$text_renderer->to_rupiah($total_belum_dibayar)?></td>
		</tr-->
		<!--tr class="total_harga_min">
			<td>Capital</td><td> : </td>
			<td class="tabel_rupiah"><?=$text_renderer->to_rupiah($total_harga_min)?></td>
		</tr-->
		<!--tr class="total_harga_setor">
			<td>Setoran</td><td> : </td>
			<td class="tabel_rupiah"><?=$text_renderer->to_rupiah($total_harga_setor)?></td>
		</tr-->
	</table>
	<br/>
	
    <input type="button" value="&#8592; Prev Session" onclick="prev_session()"/>
    <input type="button" value="Next Session &#8594;" onclick="next_session()"/>
	<br/>
	<br/>
</div>