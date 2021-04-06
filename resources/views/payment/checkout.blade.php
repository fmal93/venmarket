<form method="post" action="{{ $url }}" id="checkout-form">
    <input type="hidden" name="token_ws" value="{{ $token }}" />
  </form>

  <script>document.getElementById('checkout-form').submit();</script>