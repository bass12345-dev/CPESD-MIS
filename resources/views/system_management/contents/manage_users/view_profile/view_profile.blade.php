@extends('system_management.layout.system_master')
@section('title', $title)
@section('content')
@include('system.dts.includes.title')
<div class="row">
   <div class="col-6 col-md-6">
        @include('system_management.contents.manage_users.view_profile.sections.user_information')
   </div>
   <div class="col-6 col-md-6">
        @include('system_management.contents.manage_users.view_profile.sections.system_authorize')
   </div>
</div>

@endsection
@section('js')
<script>
	table = null;
    $('#authorized_form').on('submit', function(e){
	e.preventDefault();
	items = [];
	$("input[name=system_id]:checked").map(function(item){
		items.push($(this).val());
	});
	var user_id = $('input[name=user_id]').val();
	var url = '/admin/sysm/act/a-s';
	let data = {
				id : items,
				user_id : user_id
	};

	$(this).find('button').attr('disabled',true);
	http_post_i_u(data,url,table);
	$('#program_form').find('button').attr('disabled',false);
	setTimeout(reload_page, 2000)

});
</script>

@endsection
