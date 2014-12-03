@if(!empty($options))
<script type="text/javascript">
	var RecaptchaOptions = {{ json_encode($options) }};
</script>
@endif
	    						<script src='https://www.google.com/recaptcha/api.js'></script>
                                <div class="g-recaptcha" data-sitekey="{{ $public_key }}"></div>
<noscript>
	<iframe src="//www.google.com/recaptcha/api/noscript?k=<?php echo $public_key ?><?php echo (isset($lang) ? '&hl='.$lang : '') ?>" height="300" width="500" frameborder="0"></iframe><br>
	<textarea name="recaptcha_challenge_field" rows="3" cols="40"></textarea>
	<input type="hidden" name="recaptcha_response_field" value="manual_challenge">
</noscript>
