@if(!empty($options))
    <script type="text/javascript">
        var RecaptchaOptions = <?php echo json_encode($options) ?>;
    </script>
@endif
<script type="text/javascript"
        src="//www.google.com/recaptcha/api/challenge?k=<?php echo $public_key ?><?php echo( isset( $lang ) ? '&hl=' . $lang : '' ) ?>"></script>
<noscript>
    <iframe src="//www.google.com/recaptcha/api/noscript?k=<?php echo $public_key ?><?php echo( isset( $lang ) ? '&hl=' . $lang : '' ) ?>"
            height="300" width="500" frameborder="0"></iframe>
    <br>
    <textarea name="recaptcha_challenge_field" rows="3" cols="40"></textarea>
    <input type="hidden" name="recaptcha_response_field" value="manual_challenge">
</noscript>
