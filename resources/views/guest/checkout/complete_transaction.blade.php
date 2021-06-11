<form action="{{ route('complete_transaction') }}" method="post" id="form">
	@csrf
</form>
<script type="text/javascript">
	document.getElementById("form").submit();
</script>