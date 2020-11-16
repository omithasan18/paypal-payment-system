<!DOCTYPE html>
<html>
<body>

<h2>HTML Forms</h2>

<form action="{{route('create-payment')}}" method="post">
    @csrf
  <input type="submit" value="Pay Now">
</form> 


</body>
</html>


{{-- <div id="paypal-button"></div>
<script src="https://www.paypalobjects.com/api/checkout.js"></script>
<script>
  paypal.Button.render({
    // Configure environment
    env: 'sandbox',
    client: {
      sandbox: 'AUJnPBDuH9XMSh4P1n1cxdbHUQMA5Fmk9vDCaMw2v5Webzick9P8IT6_O5aWvp78OKiLzwsN3iEaOmCO',
      production: 'demo_production_client_id'
    },
    // Customize button (optional)
    locale: 'en_US',
    style: {
      size: 'small',
      color: 'gold',
      shape: 'pill',
    },

    // Enable Pay Now checkout flow (optional)
    commit: true,

    // Set up a payment
    payment: function(data, actions) {
      return actions.payment.create({
              redirect_urls:{
                  return_url:'http://127.0.0.1:8000/execute-payment',
              },
        transactions: [{
          amount: {
            total: '20',
            currency: 'USD'
          }
        }]
      });
    },
    // Execute the payment
    onAuthorize: function(data, actions) {
        return actions.redirect();
    }
  }, '#paypal-button');

</script> --}}