@if(Auth::check())
	<script>
		var userId = <?php echo Auth::user()->id; ?>;
		var chatStatus = <?php echo Auth::user()->chatstatus; ?>;
		var userName = <?php echo json_encode(Auth::user()->username); ?>;
		var userProfileImage = <?php echo json_encode(Auth::user()->avatar->url('medium')); ?>;
	</script>
@endif
