<?php if($_settings->chk_flashdata('success')): ?>
<script>
	alert_toast("<?php echo $_settings->flashdata('success') ?>",'success')
</script>
<?php endif;?>
<div class="card card-outline rounded-0 card-primary">
	<div class="card-header">
		<h3 class="card-title">Agent List</h3>
	</div>
	<div class="card-body">
        <div class="container-fluid">
			<table class="table table-hover table-striped" id="list">
				<colgroup>
					<col width="18%">
					<col width="16%">
					<col width="12%">
					<col width="27%">
					<col width="27%">
				</colgroup>
				<thead>
					<tr>
						<th>Name</th>
						<th>Email</th>
                        <th>Mobile</th>
						<th>Address</th>
						<th>Agency Name</th>
					</tr>
				</thead>
				<tbody>
					<?php 
					$i = 1;
						$qry = $conn->query("SELECT concat(u.first_name,' ',u.last_name) as fullname, u.email, u.mobile, 
                        concat(u.address_line1,' ',u.city,' ',u.postal_code) as address, a.agency_name
                        from agents a
                        join users u on a.user_id = u.id
                        where u.deleted_date is null ");
						while($row = $qry->fetch_assoc()):
					?>
						<tr>
							<td><?php echo $row['fullname'] ?></td>
                            <td><a href="mailto:<?php echo $row['email'] ?>"> <?php echo $row['email'] ?></a></td>
                            <td><?php echo $row['mobile'] ?></td>
                            <td><?php echo $row['address'] ?></td>
                            <td><?php echo $row['agency_name'] ?></td>
						</tr>
					<?php endwhile; ?>
				</tbody>
			</table>
		</div>
	</div>
</div>