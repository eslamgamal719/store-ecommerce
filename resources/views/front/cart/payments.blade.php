@extends('layouts.site')


@section('content')

    <nav data-depth="1" class="breadcrumb-bg">
        <div class="container no-index">
            <div class="breadcrumb">

                <ol itemscope="" itemtype="http://schema.org/BreadcrumbList">
                    <li itemprop="itemListElement" itemscope="" itemtype="http://schema.org/ListItem">
                        <a itemprop="item" href="index-11.htm">
                            <span itemprop="name">Home</span>
                        </a>
                        <meta itemprop="position" content="1">
                    </li>
                </ol>

            </div>
        </div>
    </nav>

    <div class="container no-index">
        <div class="row">
            <div id="content-wrapper" class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <section id="main">
                    <h1 class="page-title">Payment Methods</h1>
                    <div class="cart-grid row">
                        <form class="needs-validation" method="post" action="{{route('payment.process')}}" novalidate="">
                            @csrf
                            <hr class="mb-4">
                            <h4 class="mb-3">Payment</h4>

                            <input type="hidden" name="amount" value="{{$amount}}" >

                            <div class="d-block my-3">
                                <div class="custom-radio">
                                    <input  name="PaymentMethodId" type="radio"  value="2" class="" checked="" required="">
                                    <label class="custom-control-label" for="credit">Visa</label>
                                </div>
                                <div class="custom-radio">
                                    <input name="PaymentMethodId" type="radio" value="2"  class="" required="">
                                    <label class="custom-control-label" for="debit">Master Card</label>
                                </div>
                                <div class="custom-radio">
                                    <input name="PaymentMethodId" type="radio" value="6" class="" required="">
                                    <label class="custom-control-label" for="paypal">Mada</label>
                                </div>
                            </div>


                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="cc-name">Name on card</label>
                                    <input type="text" class="form-control" id="cc-name" placeholder="" required="">
                                    <small class="text-muted">Full name as displayed on card</small>
                                    <div class="invalid-feedback">
                                        Name on card is required
                                    </div>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="cc-number">Credit card number</label>
                                    <input type="text" class="form-control" name="ccNum" id="cc-number" placeholder="" required="">
                                    <div class="invalid-feedback">
                                        Credit card number is required
                                    </div>
                                </div>
                            </div>


                            <div class="row">
                                <div class="col-md-3 mb-3">
                                    <label for="cc-expiration">Expiration</label>
                                    <input type="text" class="form-control" name="ccExp" id="cc-expiration" placeholder="" required="">
                                    <div class="invalid-feedback">
                                        Expiration date required
                                    </div>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label for="cc-expiration">CVV</label>
                                    <input type="text" class="form-control" name="ccCvv" id="cc-cvv" placeholder="" required="">
                                    <div class="invalid-feedback">
                                        Security code required
                                    </div>
                                </div>
                            </div>

                            <hr class="mb-4">
                            <button class="btn btn-primary btn-lg btn-block" type="submit">Continue to checkout</button>
                        </form>
                    </div>
                </section>
            </div>
        </div>
    </div><br>
@stop


@section('scripts')
    <script>




        $(document).on('click', '.remove-from-cart', function (e) {
            e.preventDefault();

            $.ajax({
                type: 'post',
                url: $(this).attr('data-url-product'),
                data: {
                    'product_id': $(this).attr('data-id-product'),
                    '_token': "{{csrf_token()}}",
                },
                success: function (data) {

                }
            });
        });
    </script>

    <script src="https://js.pusher.com/7.0/pusher.min.js"></script>

    <script>
        // Enable pusher logging - don't include this in production
        Pusher.logToConsole = true;

        var pusher = new Pusher('249c38b0cbf5d1ae0340', {
            cluster: 'mt1'
        });
    </script>

@stop





