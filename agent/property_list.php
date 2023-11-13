<?php if($_settings->chk_flashdata('success')): ?>
<script>
	alert_toast("<?php echo $_settings->flashdata('success') ?>",'success')
</script>
<?php endif;?>
<div class="card card-outline rounded-0 card-primary">
	<div class="card-header">
		<h3 class="card-title">Real Estate List</h3>
		<div class="card-tools">
			<a href="?page=property" class="btn btn-flat btn-primary"><span class="fas fa-plus"></span>  Create New</a>
		</div>
	</div>
	<div class="card-body">
		<div class="container-fluid">
        <div class="container-fluid">
			<table class="table table-hover table-striped table-bordered">
				<colgroup>
					<col width="5%">
					<col width="25%">
					<col width="20%">
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
						$qry = $conn->query("select p.id, p.name, pt.type, CONCAT(u.first_name, ' ', u.last_name) as fullname, p.status from properties p join agents a on p.agent_id = a.id join users u on a.user_id = u.id join property_types pt on p.type_id = pt.id where p.agent_id = '{$_settings->userdata('id')}' and p.deleted_date is null");
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
				                    <a class="dropdown-item" href="?page=property&id=<?php echo $row['id'] ?>"><span class="fa fa-edit text-primary"></span> Update</a>
				                    <div class="dropdown-divider"></div>
				                    <a class="dropdown-item delete" href="javascript:void(0)" data-id="<?php echo $row['id'] ?>"><span class="fa fa-trash text-danger"></span> Delete</a>
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
<script>
	$(document).ready(function(){
		$('.delete').click(function(){
			_conf("Are you sure you want to delete this property permanently?","delete_property",[$(this).attr('data-id')])
		})
		$('.table').dataTable({
			columnDefs: [
					{ orderable: false, targets: [5] }
			],
			order:[0,'asc']
		});
		$('.dataTable td,.dataTable th').addClass('py-1 px-2 align-middle')
	})

	function delete_property($id){
		start_loader();
		$.ajax({
			url:_base_url_+"classes/property.php?f=delete",
			method:"POST",
			data:{id: $id},
			dataType:"json",
			error:err=>{
				console.log(err)
				alert_toast("An error occured.",'error');
				end_loader();
			},
			success:function(resp){
				if(typeof resp== 'object' && resp.status == 'success'){
					location.replace('./?page=property_list');
				}else{
					alert_toast("An error occured.",'error');
					end_loader();
				}
			}
		})
	}
</script>