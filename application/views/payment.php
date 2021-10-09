
<style>
    .payment-type, .payment-detail{
        padding:10px;
        background-color: white;
        border: solid 1px #43dad5;
        border-radius: 4%;
        margin-left: 32px;
    }
    .payment-type .row{
        text-align: center;
        margin-top: 15px;
    }
    .checkmark{
        left: 110px;
    }
    .p-2{
        padding: 1rem;
    }
    .px-2{
        padding-left: 1rem;
        padding-right: 1rem;
    } 
    .mx-2{
        margin-left: 1rem;
        margin-right:1rem;
    }
    .border-top{
        border-top: solid 1px green;
    }
</style>
<section class="loginAndSignSection selectPlan">
    <div class="container">
        <div class="row">
            <div class="col-lg-2 col-xs-12 col-sm-2"></div>
            <div class="col-lg-12 col-xs-12 col-sm-12">
                <h3 class="selectPlanTitles">Payment</h3>
                <div class="timelineSelectPlan">
                    <div class="circlNum leftNum ">01</div>
                    <div class="circlNum rightNum activeTime">02</div>
                </div>

                <div class="col-lg-12 paymentWrap">
                    <div class="col-lg-5 payment-type">
                        <div class="row">
                            <label class="radioBox">
                                <input type="radio" class="payment_method" name="payment_method" value="paypal" checked >
                                <span class="checkmark" style="margin-top:12px"></span>
                                <img style="width:225px" src="<?=base_url()?>assets/images/paypalbtn.png" alt="Buy now with PayPal" />
                            </label>
                        </div>
                        <div class="row">
                            <label class="radioBox">
                                <input type="radio" class="payment_method" name="payment_method" value="stripe">
                                <span class="checkmark" style="margin-top:12px"></span>
                                <img style="width:225px" alt="Visa Checkout" class="v-button" role="button" src="<?=base_url()?>assets/images/stripebtn.svg">
                            </label>
                        </div>
                        <div class="row" style="padding-left: 50px;padding-right: 50px;">
                            <input type="hidden" id="price" name="price" class="form-control" >
                            <section class="card">
                                <div class="row">
                                    <form id="stripePayment" action="" method="post">
                                        <div class="field-row">
                                            <label>Card Holder Name</label> 
                                            <span id="card-holder-name-info" class="info"></span>
                                            <br> 
                                            <input type="text" id="name" name="name" class="demoInputBox">
                                        </div>
                                        <div class="field-row">
                                            <label>Email</label> <span id="email-info" class="info"></span><br>
                                            <input type="text" id="email" name="email" class="demoInputBox">
                                        </div>
                                        <div class="field-row">
                                            <label>Card Number</label> 
                                            <span id="card-number-info" class="info"></span><br> 
                                            <input type="text" id="card-number" name="card-number" class="demoInputBox">
                                        </div>
                                        <div class="field-row">
                                            <div class="contact-row column-right">
                                                <label>Expiry Month / Year</label> 
                                                <span id="userEmail-info" class="info"></span>
                                                <br> 
                                                <select name="month" id="month" class="demoSelectBox">
                                                    <option value="08">08</option>
                                                    <option value="09">9</option>
                                                    <option value="10">10</option>
                                                    <option value="11">11</option>
                                                    <option value="12">12</option>
                                                </select> 
                                                <select  name="year" id="year"	class="demoSelectBox">
                                                    <option value="18">2018</option>
                                                    <option value="19">2019</option>
                                                    <option value="20">2020</option>
                                                    <option value="21">2021</option>
                                                    <option value="22">2022</option>
                                                    <option value="23">2023</option>
                                                    <option value="24">2024</option>
                                                    <option value="25">2025</option>
                                                    <option value="26">2026</option>
                                                    <option value="27">2027</option>
                                                    <option value="28">2028</option>
                                                    <option value="29">2029</option>
                                                    <option value="30">2030</option>
                                                </select>
                                            </div>
                                            <div class="contact-row cvv-box">
                                                <label>CVC</label> <span id="cvv-info" class="info"></span><br>
                                                <input type="text" name="cvc" id="cvc" class="demoInputBox cvv-input">
                                            </div>
                                        </div>
                                        <input type='hidden' name='type' value='<?=$type?>'> 
                                        <input type='hidden' name='id' value='<?= $id?>'>
                                    </form>
                                </div>
                            </section>
                        </div>
                    </div>
                    <div class="col-lg-6 payment-detail">
                        <div class="col-md-12 col-xl-12 offset-xl-1">
                            <div class="rounded d-flex flex-column p-2">
                                <div class="p-2 me-3">
                                    <h2><?=$title?></h2>
                                </div>
                                <div class="border-top px-2 mx-2"></div>
                                <div class="p-2 d-flex">
                                    <div class="col-8">Description</div>
                                    <div class="ms-auto"><?= $desciption ?></div>
                                </div>
                                <div class="p-2 d-flex">
                                    <div class="col-8">Price</div>
                                    <div class="ms-auto">$<?= $price?></div>
                                </div>
                                <div class="p-2 d-flex">
                                    <div class="col-8">Discount( <?= $discount?>%)</div>
                                    <div class="ms-auto">- $<?=$discount_amount?></div>
                                </div>
                                <div class="border-top px-2 mx-2"></div>
                                <div class="p-2 d-flex">
                                    <div class="col-8">Subtotal</div>
                                    <div class="ms-auto">$<?=$sub_total?></div>
                                </div>
                                <div class="p-2 d-flex">
                                    <div class="col-8">Tax( <?= $tax?><?= $tax_type?> )</div>
                                    <div class="ms-auto">+ $<?= $tax_amount?></div>
                                </div>
                                
                                <div class="border-top px-2 mx-2"></div>
                                <div class="p-2 d-flex pt-3">
                                    <div class="col-8"><b>Total</b></div>
                                    <div class="ms-auto"><b class="text-success"><?=$total?></b></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="wrapNext">
                    <a href="<?= base_url()?>" class="nextBTN outlineBTN">Back</a>
                    <a href="javascript:pay()" class="nextBTN">Payment</a>
                </div>
            </div>
            <div class="col-lg-2 col-xs-12 col-sm-2"></div>
        </div>
    </div>
</section>
<form id="paypalPayment" action="<?= base_url()?>pricing/paypalPayment" method="post">
    <input type="hidden" name = "id" value = "<?= $id?>">
    <input type="hidden" name = "type" value = "<?= $type?>">
</form>
<script>
    var payment_method = 'paypal';
    $(document).ready(function() {
        $("#stripePayment").css("display","none");

        $('input[type=radio][name="payment_method"]').change(function() {
            if($(this).val() == 'paypal'){
                payment_method = 'paypal';
                $("#stripePayment").css("display","none");
            }else{
                payment_method = 'stripe';
                $("#stripePayment").css("display","block");
            }
                
        });
    });

    function pay(){
        if(payment_method == 'paypal'){
            $("#paypalPayment").submit();
        }else{
            
        }
    }
</script>
<!--

<body>
    <div id="subscription-plan">
        <div class="plan-info">Paypal subscription</div>
        <div class="plan-desc">Paypal subscription tutorial using Codeigniter</div>
        <div class="price">$49 / month</div>

        <div>
            <form action="<?= base_url() ?>index.php/payment/subscribe" method="post">
                <input type="hidden" name="plan_name" value="PHP jQuery Tutorials" /> 
                <input type="hidden" name="plan_description" value="Tutorials access to learn PHP with simple examples." />
                <input type="submit" name="subscribe" value="Subscribe" class="btn-subscribe" />
            </form>
        </div>
    </div>

    <div id="subscription-plan">
        <div class="plan-info">Paypal Payment</div>
        <div class="plan-desc">Paypal payment checkout tutorial using Codeigniter</div>
        <div class="price">$10</div>

        <div>
            <form action="<?= base_url() ?>index.php/payment/create_payment" method="post">
                <input type="hidden" name="plan_name" value="PHP jQuery Tutorials" /> 
                <input type="hidden" name="plan_description" value="Tutorials access to learn PHP with simple examples." />
                <input type="submit" name="subscribe" value="Checkout" class="btn-subscribe" />
            </form>
        </div>
    </div>

    <div align="center">
        <a href="https://bd.linkedin.com/in/knrahman" class="fa fa-linkedin" target="_blank"></a>
    </div>
</body>

</html> -->

