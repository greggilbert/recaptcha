<?php
if (!function_exists('renderDataAttributes')) {
    function renderDataAttributes($attributes)
    {
        $mapped = [];
        foreach ($attributes as $key => $value) {
            $mapped[] = 'data-' . $key . '="' . $value . '"';
        };

        return implode(' ', $mapped);
    }
}
?>
@if(!empty($options))
    <script type="text/javascript">
        var RecaptchaOptions = <?=json_encode($options) ?>;

        function laravelRecaptchaInit() {
            var laravelRecaptchaCaptchas = document.querySelectorAll(".g-recaptcha");
            if (laravelRecaptchaCaptchas.length) {
                laravelRecaptchaCaptchas.forEach(function (item, index) {
                    grecaptcha.render(item, {'sitekey': item.getAttribute("data-sitekey")});
                });
            }
        }
    </script>
@endif
<script type="text/javascript">
    if (!window.greggilbertRecaptchaLoaded) {
        (function () {
            var po = document.createElement('script');
            po.type = 'text/javascript';
            po.async = true;
            po.src = 'https://www.google.com/recaptcha/api.js?onload=laravelRecaptchaInit&render=explicit{!! (isset($lang) ? '&hl='.$lang : '') !!}';
            var s = document.getElementsByTagName('script')[0];
            s.parentNode.insertBefore(po, s);
        })();
    }

    window.greggilbertRecaptchaLoaded = true;
</script>
<div class="g-recaptcha" data-sitekey="{{ $public_key }}" <?=renderDataAttributes($dataParams)?>></div>
<noscript>
    <div style="width: 302px; height: 352px;">
        <div style="width: 302px; height: 352px; position: relative;">
            <div style="width: 302px; height: 352px; position: absolute;">
                <iframe src="https://www.google.com/recaptcha/api/fallback?k={{ $public_key }}"
                        frameborder="0" scrolling="no"
                        style="width: 302px; height:352px; border-style: none;">
                </iframe>
            </div>
            <div style="width: 250px; height: 80px; position: absolute; border-style: none;
                  bottom: 21px; left: 25px; margin: 0; padding: 0; right: 25px;">
        <textarea id="g-recaptcha-response" name="g-recaptcha-response"
                  class="g-recaptcha-response"
                  style="width: 250px; height: 80px; border: 1px solid #c1c1c1;
                         margin: 0; padding: 0; resize: none;"></textarea>
            </div>
        </div>
    </div>
</noscript>
