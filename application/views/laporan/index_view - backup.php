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
		$total_omzet = 0;
		$total_harga_min = 0;
		$total_harga_setor = 0;
		$total_belum_dibayar = 0;
		
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
					<td class="header nama_pembeli" colspan="2"><?=$order->nama_pembeli?></td>
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
					<td class="menu_header nama_menu_label">Menu</td>
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
							<?php $subtotal_min = $menu->jumlah * $menu->harga_min; ?>
							<td class="menu subtotal_menu"><?=$text_renderer->to_rupiah($subtotal)?></td>
							<?php if ($order->paid) {$total_harga += $subtotal;} ?>
							
							<?php $subtotal_harga_min = $menu->jumlah * $menu->harga_min; ?>
							<?php $subtotal_harga_base = $menu->jumlah * $menu->harga_base; ?>
							<?php if ($order->paid) {$total_harga_min += $subtotal_harga_min;} ?>
							<?php if (!$order->paid) {$total_belum_dibayar += $subtotal_harga_base;} ?>
							<?php
								if ($menu->harga_setor > 0) //kalo harus setor titip jual
								{
									//ngecek apa udah ada nama setor yg sama
									if (!isset($menu_setor[$menu->nama_setor]))
									{
										$menu_setor[$menu->nama_setor] = array();
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
			$total_omzet += $total_harga;
        }
    ?>
	
	<h3>Setoran :</h3>
	<?php
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
							<?php $total_harga += $setoran['subtotal']; ?>
							<?php $total_harga_setor += $setoran['subtotal']; ?>
						</tr>
						<?php
					}
				?>
				<tr class="menu_footer">
					<td class="menu_footer label-total_harga_setor" colspan="3">Total : </td>
					<td class="menu_footer total_harga_setor"><?=$text_renderer->to_rupiah($total_harga)?></td>
				</tr>
			</table>
			<br/>
			<?php
			$it++;
		}
	?>
	
	<br/>
	<!--hr size="2"/-->
	
	<table id="session_summary">
		<tr class="total_omzet">
			<td>Total Omzet</td><td> : </td>
			<td class="tabel_rupiah"><?=$text_renderer->to_rupiah($total_omzet)?></td>
		</tr>
		<tr class="total_bersih">
			<td>Kas Modal</td><td> : </td>
			<td class="tabel_rupiah"><?=$text_renderer->to_rupiah($total_harga_min - $total_harga_setor)?></td>
		</tr>
		<!--tr class="total_harga_min">
			<td>Capital</td><td> : </td>
			<td class="tabel_rupiah"><?=$text_renderer->to_rupiah($total_harga_min)?></td>
		</tr-->
		<tr class="total_bonus">
			<td>Kas Bonus</td><td> : </td>
			<td class="tabel_rupiah"><?=$text_renderer->to_rupiah($total_omzet - $total_harga_min)?></td>
		</tr>
		<tr class="total_harga_setor">
			<td>Setoran</td><td> : </td>
			<td class="tabel_rupiah"><?=$text_renderer->to_rupiah($total_harga_setor)?></td>
		</tr>
		<tr class="total_belum_dibayar">
			<td>Belum Dibayar (Base)</td><td> : </td>
			<td class="tabel_rupiah"><?=$text_renderer->to_rupiah($total_belum_dibayar)?></td>
		</tr>
	</table>
	<br/>
	
    <input type="button" value="&#8592; Prev Session" onclick="prev_session()"/>
    <input type="button" value="Next Session &#8594;" onclick="next_session()"/>
	<br/>
	<br/>
</div>