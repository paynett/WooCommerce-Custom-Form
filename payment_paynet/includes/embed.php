<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="css/bootstrap.min.css">
  
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>

</head>
<?php

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}
if($gateway_error)
	echo $gateway_error;

$payment_paynet_url = plugins_url() . '/payment_paynet';
echo $form;

if(!$gateway_error){
?>
 <script type="text/javascript">
        $(function () {
            Paynet.events.onCheckBin(function (d) {
                if (d && d.ok) {
                    $('.installment-table').html('');

                    d.bank.installments.sort(function (current, next) {
                        if (current.instalment > next.instalment) return 1;
                        if (current.instalment < next.instalment) return -1;

                        return 0;
                    });

                    $('#data-tds').attr('data-tds', d.bank.tdsEnable);
                    $('#bankLogo').attr('src', d.bank.logoUrl);
                    $('#bankLogo').attr('alt', "");
                   
                    $('.bank_logo').show();

                    for (var i = 0; i < d.bank.installments.length; i++) {
						
						if(d.bank.installments[i].plus_installment > 0 )
						{			
						    $(".installment-table").append("<br><list-style-type: none;> <div class=installment-item data-key=" + d.bank.installments[i].instalment_key + "><input type=radio name=installment /> " + d.bank.installments[i].desc + "(+" + d.bank.installments[i].plus_installment+ ")" +"  -&nbsp;&nbsp;" + d.bank.installments[i].instalment_amount + "&nbsp;TL" + "</div></li> <br>");
						}
						else
						{
							$(".installment-table").append("<br><list-style-type: none;> <div class=installment-item data-key=" + d.bank.installments[i].instalment_key + "><input type=radio name=installment /> " + d.bank.installments[i].desc + "-&nbsp;&nbsp;" + d.bank.installments[i].instalment_amount + "&nbsp;TL" + "</div></li> <br>");
						}
                    }
                
                    $('.installment-table').show();

                    if (d.tdsState == 'required') {
                        $('#tds').attr('checked', 'checked');
                        $('#tds').attr('disabled', 'disabled');

                        $('#isTds').hide();
                    } else if (d.tdsState == 'optional') {
                        $('#tds').attr('checked', 'checked');
                        $('#tds').removeAttr('disabled', 'disabled');

                        $('#isTds').show();
                    }

                } else {
                    $('.installment-table').hide();
                    $('.bank_logo').hide();
                    $('#isTds').hide();
                }
            });
            Paynet.events.validationError(function (e) {
                alert(e.message);
            });

            Paynet.events.onAuthentication(function (c) {
                if (!c.ok) {
                    alert(c.message);
                }
            });

            Paynet.events.onCreateToken(function (c) {
                if (!c.ok) {
                    alert(c.message);
                }
            });

            $('.installment-table').delegate('.installment-item', 'click', function () {
                var $that = $(this);

                $('.installment-item').removeClass('active');

                $that.addClass('active');

                $('#installmentKey').val($that.attr('data-key'));

                $('[name="installment"]').removeAttr('disabled');
                $that.find('[name="installment"]').attr('checked', 'checked');
            });
        });
    </script>
<?php } ?>
<style type="text/css">
input[type=radio] {
    box-sizing: border-box;
    margin: 11px;
    width: 94px;
    height: 18px;
	
}

input[type="text"]{
    font-size: 2.0rem;
	-webkit-appearance: auto;
    -moz-appearance: none;
    background: #fff;
    border-radius: 66px;
    border-style: solid;
    border-width: 0.3rem;
    display: block;
    font-size: 2.3rem;
    letter-spacing: -0.015em;
    margin: 0;
    padding: 1.5rem 1.8rem;
    width: 100%;
}
input[type="password"]{
    -webkit-appearance: auto;
    -moz-appearance: none;
    background: #fff;
    border-radius: 66px;
    border-style: solid;
    border-width: 0.3rem;
    display: block;
    font-size: 2.3rem;
    letter-spacing: -0.015em;
    margin: 0;
    padding: 1.5rem 1.8rem;
    width: 100%;
}

.display3{
	font-size: 3.5rem;
    font-weight: 200;
    line-height: 0;
}

.py5{
  padding-top: 0rem!important;
}


</style>


<body>
<div class="container py-5">

  <!-- For demo purpose -->
  <div class="row mb-4">
    <div class="col-lg-8 mx-auto text-center">
      <h1 class="display-3">Kart Bilgileri</h1>
    </div>
  </div>
  <!-- End -->


  <div class="row">
    <div class="col-lg-6 mx-auto">
      <div class="bg-white rounded-lg shadow-sm p-5">
        
        <!-- Credit card form content -->
        <div class="tab-content">

		<form action="" method="post" name="checkout-form" id="#checkout-form">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
	
		<div class="input-group input-group-lg" >
		 <div id="nav-tab-card" class="tab-pane fade show active">
            <form role="form">
              <div class="form-group">
				<p>Kart Sahibi</p>
                 <input type="text" name="cardHolderName" id="cardHolderName" data-paynet="holderName" class="form-control" placeholder="Card Holder" value="" required autocomplete="off" />
              </div>
			  
	
              <div class="form-group">
                    <p>Kart Numarası</p>
                <div class="input-group">
                            <input type="text" name="cardNumber" maxlength="16" id="cardNumber" data-paynet="number" class="form-control" placeholder="Card Number" value="" />
                </div>				
              </div>

							
			<div class="row align="center">
			
                <div class="col-sm-8">
                  <div class="form-group">
                    <p>Son Kullanım Tarihi</p>
						<div class="input-group">
					<input type="text" name="expMonth" maxlength="2" id="expMonth" data-paynet="exp-month" class="form-control" placeholder="Month" value="" />
					   <input type="text" name="expYear" maxlength="4" id="expYear" data-paynet="exp-year" class="form-control" placeholder="Year" value="" />
						</div>
                  </div>
                </div>
				
				
                <div class="col-sm-4">
                  <div class="form-group mb-4">
                    <p>CVV </p>                
					<input type="password" maxlength="4" name="cvv" id="cvv" data-paynet="cvv" placeholder="CVV" class="form-control" value="" />
                  </div>				  
				</div>
				
			</div>


		   <div class="panel panel-default" id="data-tds" data-tds="">
						<div class="bank_logo col-xs- panel-heading no-padding-left" id="logo" style="display: none;">
							<label>
								<img id="bankLogo" src="" width="100px"/>
							</label>
						</div>
						
						<div class="installment-table col-sm-12 no-padding-left no-padding-right panel-body" style="border-style: ridge;display: none; line-height: 0.2; border-radius:28px; border-color:aliceblue;">
							<ol></ol>
						</div>
			</div>         			
                        <input type="hidden" name="installmentKey" id="installmentKey" data-paynet="installmentKey" value="" />	
						<div>		
						<br>												
                        <button type="submit" class="btn btn-primary btn-lg btn-block" data-paynet="submit" style="padding: 0.5rem 1rem;font-size:1.25rem;line-height: 2.5;border-radius: 2.3rem;">Öde</button>
  


						</div>
                    </form>				
				
		</div>
	</div>
</div>
<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>

</body>
