@extends('admin.layouts.app')
@section('content')

<div class="mb-1 mt-2">
      <ul class="breadcrumb">
         <li><a href="/project/tunesline-yii2-1786/">Home</a></li>
         <li class="active">Files</li>
      </ul>
</div>

<div class="dash-home-cards">
	<div class="row">
		<div class="col-12">
			<div class="card">
				<div class="card-header">
					<div class="ProfileHader d-flex flex-wrap align-items-center">
						<h3 class="font_600 font-18 font-md-20 mr-auto pr-20">Files</h3>
					</div>
				</div>
			    <div class="card-body table-responsive">
					<table id="ThemeTable" class="table table-bordered project
                    ">
						<thead>
							<th>Id</th>
							<th>name</th>
							<th>size</th>
							<th>key </th>
							<th>model_type</th>
							<th>model_id</th>
							<th>type_id</th>
							<th>created_at</th>
							<th>updated_at</th>
							<th>created by</th>
							<th>Actions</th>
						</thead>
						<tbody>
							<tr>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>

</div>

@endsection