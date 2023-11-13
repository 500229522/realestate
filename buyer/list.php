<?php if($_settings->chk_flashdata('success')): ?>
<script>
	alert_toast("<?php echo $_settings->flashdata('success') ?>",'success')
</script>
<?php endif;?>
<div class="card card-outline rounded-0 card-primary">
	<div class="card-header">
		<h3 class="card-title">Real Estate List</h3>
	</div>
	<div class="card-body">
		<div class="container-fluid">
        <div class="container-fluid">
			<table class="table table-hover table-striped table-bordered">
				<colgroup>
					<col width="5%">
					<col width="20%">
					<col width="25%">
					<col width="20%">
					<col width="15%">
					<col width="15%">
				</colgroup>
				<thead>
					<tr>
						<th>#</th>
						<th>Name</th>
						<th>Type</th>
						<th>Agent</th>
						<th>Status</th>
						<th>Action</th>
					</tr>
				</thead>
				<tbody>
					<?php 
					    $i = 1;
						$qry = $conn->query("select p.id, p.name, pt.type, CONCAT(u.first_name, ' ', u.last_name) as fullname, p.status, u.email from properties p join agents a on p.agent_id = a.id join users u on a.user_id = u.id join property_types pt on p.type_id = pt.id where p.deleted_date is null");
						while($row = $qry->fetch_assoc()):
					?>
						<tr>
							<td class="text-center"><?php echo $i++; ?></td>
							<td><p class="m-0 truncate-1"><?= $row['name'] ?></p></td>
							<td><p class="m-0 truncate-1"><?= $row['type'] ?></p></td>
							<td><p class="m-0 truncate-1"><?= $row['fullname'] ?></p></td>
							<td class="text-center">
                                <?php if($row['status'] == "Active"): ?>
                                    <span class="badge badge-success px-3 rounded-pill">Available</span>
                                <?php elseif($row['status'] == "Sold"): ?>
                                    <span class="badge badge-danger px-3 rounded-pill">Unavailable</span>
                                <?php else: ?>
                                    <span class="badge badge-warning px-3 rounded-pill">Pending</span>
                                <?php endif; ?>
                            </td>
							<td align="center">
								 <button type="button" class="btn btn-flat btn-default btn-sm dropdown-toggle dropdown-icon" data-toggle="dropdown">
				                  		Action
				                    <span class="sr-only">Toggle Dropdown</span>
				                  </button>
				                  <div class="dropdown-menu" role="menu">
								  	<a class="dropdown-item" href="?page=view_property&id=<?php echo $row['id'] ?>"><span class="fa fa-eye text-dark"></span> View</a>
				                    <div class="dropdown-divider"></div>
				                    <a class="dropdown-item" href="mailto:<?php echo $row['email'] ?>"><span class="fa fa-phone text-primary"></span> Contact Agent</a>
				                  </div>
							</td>
						</tr>
					<?php endwhile; ?>
				</tbody>
			</table>
		</div>
		</div>
	</div>
</div>