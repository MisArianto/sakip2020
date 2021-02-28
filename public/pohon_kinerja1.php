<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <meta name="description" content="" />
    <meta name="author" content="" />
   
    <title>e-sakip</title>
    <link rel="shortcut icon" href="assets/img/favicon.png">
    <link href="assets/css/bootstrap.css" rel="stylesheet" />
    <link href="assets/css/font-awesome.css" rel="stylesheet" />
    <link href="assets/css/style.css" rel="stylesheet" />
    <link href="assets/js/dataTables/dataTables.bootstrap.css" rel="stylesheet" />
    <link href='assets/css/font.css' rel='stylesheet' type='text/css' />
    <link href="assets/cascading/orgchart.css" rel="stylesheet" type="text/css"/>
	<link rel="stylesheet" href="assets/cascading/css/bootstrap.min.css"/>

</head>
<?php 
error_reporting(0);
mysql_connect("localhost","root","epsakip");
mysql_select_db("e_sakip");

if(!empty( $_SESSION['organisasi_no'])){ $org=$_SESSION['organisasi_no']; }else{ $org=$_POST['organisasi_no']; }

?>




                        
                        
                        <div class="panel-heading">
                             <h3 style="font-weight: bold;">Pohon Kinerja</h3>
                             <a href="/"><button class="btn btn-primary" >Kembali</button></a>
                    <br>
                    <br>
                     
		

		
				<?php if(empty( $_SESSION['organisasi_no'])){ ?>           
					<form action="pohon_kinerja" method="post" >
						<table class="table-responsive">
							<th style="font-size: 13px;">
								<select name="organisasi_no" class=" form-control   " id="organisasi_no" >
									<option value="">Pilih OPD</option>
									<?php 
									$po=mysql_query("select organisasi_nama,organisasi_no from organisasi where organisasi_tipe='ORG' ");
									while ($dpo=mysql_fetch_array($po)) { ?>
										<option value="<?php echo $dpo['organisasi_no'] ?>" <?php if($org == $dpo["organisasi_no"]){ echo "selected='selected'";  }?> ><?php echo $dpo['organisasi_nama'] ?></option>
									<?php  } ?>
									<select>
									</th>
									<th>&nbsp</th>
									<th>&nbsp</th>
									<th>
										<button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
									</th>
									
								</table>
							</form>
						<?php } ?>
						<br>

						<div class="card-body">
							<center>
								<div id="tree-view"></div>
							</center>	
						</div>
						<div class="card-footer text-muted">

						</div>
						

						<ul id="tree-data" style="display:none">
							<li id="root" >
								<?php
								$v=mysql_query("SELECT visi_misi_nama from visi_misi where status='visi' ");
								$dv=mysql_fetch_assoc($v);
								?><?php echo $dv["visi_misi_nama"]; ?>
								<ul>
									<?php 
									$m=mysql_query("SELECT b.visi_misi_nama,b.visi_misi_nomor from renstra a inner join visi_misi b on a.visi_misi_nomor=b.visi_misi_nomor  where a.organisasi_no='$org' and b.status='misi' group by b.visi_misi_nama,b.visi_misi_nomor ");
									while ($dm=mysql_fetch_array($m)) {  ?>
										<li id="node1">
											<?php  echo $dm["visi_misi_nama"]; ?>
											<ul>
												<?php 
												$t=mysql_query("SELECT b.tujuan_nomor from renstra a left join tujuan b on a.tujuan_nomor=b.tujuan_nomor  where a.organisasi_no='$org' and a.visi_misi_nomor='$dm[visi_misi_nomor]' group by b.tujuan_nomor ");
												while ($dt=mysql_fetch_array($t)) {  ?>
													<li id="node2">
														<?php  
														$t2=mysql_query("SELECT tujuan_nama from tujuan where organisasi_no='$org' and  tujuan_nomor='$dt[tujuan_nomor]'");
														$dt2=mysql_fetch_assoc($t2);
														echo $dt["tujuan_nomor"].". ".$dt2["tujuan_nama"]; ?>
														<ul>
															<?php 
															$s=mysql_query("SELECT b.sasaran_nomor from renstra a left join sasaran b on a.sasaran_nomor=b.sasaran_nomor  where a.organisasi_no='$org' and a.visi_misi_nomor='$dm[visi_misi_nomor]' and a.tujuan_nomor='$dt[tujuan_nomor]' group by b.sasaran_nomor ");
															while ($ds=mysql_fetch_array($s)) {  ?>
																<li id="node2">
																	<?php  
																	$s2=mysql_query("SELECT sasaran_nama from sasaran where organisasi_no='$org' and  sasaran_nomor='$ds[sasaran_nomor]'");
																	$ds2=mysql_fetch_assoc($s2);
																	echo $ds["sasaran_nomor"].". ".$ds2["sasaran_nama"]; ?>
																	<ul>
																		<?php 
																		$is=mysql_query("SELECT indikator_sasaran_id from renstra where organisasi_no='$org' and tujuan_nomor='$dt[tujuan_nomor]' and sasaran_nomor='$ds[sasaran_nomor]' group by indikator_sasaran_id");
																		while ($dis=mysql_fetch_array($is)) {  ?>
																			<li id="node2">
																				<?php  
																				$is2=mysql_query("SELECT indikator_sasaran_nama,indikator_sasaran_nomor from indikator_sasaran where organisasi_no='$org' and  indikator_sasaran_id='$dis[indikator_sasaran_id]' ");
																				$dis2=mysql_fetch_assoc($is2);
																				echo $dis2["indikator_sasaran_nama"]; ?>
																				<ul>
																					<?php 
																					$isk=mysql_query("SELECT indikator_kegiatan from renstra where organisasi_no='$org' and indikator_sasaran_id='$dis[indikator_sasaran_id]' ");
																					while ($disk=mysql_fetch_array($isk)) {  ?>
																						<li id="node2">
																							<?php echo $disk[indikator_kegiatan]; ?>

																						</li>
																					<?php 	} ?>
																				</ul>
																			</li>
																		<?php 	} ?>
																	</ul>
																</li>
															<?php 	} ?>
														</ul>
													</li>
												<?php 	} ?>
											</ul>
										</li>
									<?php 	} ?>
								</ul>

							</li>
						</ul>


					</div>
				</div>
			</div>
                            
                        </div>
                    </div>
            </div>
        </div>
    </div>
</div>

<script src="assets/cascading/jquery-1.7.2.min.js"></script>
<script type="text/javascript" src="assets/cascading/orgchart.js"></script> 

<!-- <script src="assets/js/jquery-1.10.2.js"></script> -->
<!-- <script src="assets/js/bootstrap.js"></script> -->

<!-- <script src="assets/js/custom.js"></script> -->
<!-- <script src="assets/js/dataTables/jquery.dataTables.js"></script> -->
<!-- <script src="assets/js/dataTables/dataTables.bootstrap.js"></script> -->
<!-- <script src="../js/jquery-1.10.2.min.js"></script> -->
<script type="text/javascript">
    $(document).ready(function () {
		$("#tree-data").jOrgChart({
			chartElement: $("#tree-view"), 
			nodeClicked: nodeClicked
		});
		// lighting a node in the selection
		function nodeClicked(node, type) {
			node = node || $(this);
			$('.jOrgChart .selected').removeClass('selected');
			node.addClass('selected');
		}
	});

	
  $("#modalrenstra").on('show.bs.modal', function(e){    
      var id = $(e.relatedTarget).data('id');
      $.ajax({
          type: 'post',
          url: "renstra.php",
          data: 'renstra_id=' +id,
          success: function(data){
            $('.fetch-data-renstra').html(data);
        }
    });
  });  

  
</script>
<script type="text/javascript">
    var str1 = "</bo";
    var str2 = "dy>";
    var str3 = "</html>";
    document.write(str1.concat(str2, str3));
</script>
