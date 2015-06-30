@if(!empty($options))
	<script type="text/javascript">
	  var RecaptchaOptions = <?= json_encode($options) ?>
	</script>
@endif

<script src="https://www.google.com/recaptcha/api.js?render=explicit<?= isset($parameters) ? $parameters : '' ?>" async defer></script>