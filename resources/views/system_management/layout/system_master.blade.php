<!DOCTYPE html>
<html lang="en">
<head>
	@include('system.global_includes.meta')
	@include('system.dts.includes.css')
</head>
<body>
	<div class="wrapper">
		@include('system_management.layout.includes.system_sidebar')
		<div class="main">
			@include('system_management.layout.includes.system_topbar')
			<main class="content">
				<div class="container-fluid p-0">
					@yield('content')
				</div>
			</main>
		</div>
	</div>
</body>
@include('system.dts.includes.js')
@include('system.global_includes.js')

@yield('js')
</html>