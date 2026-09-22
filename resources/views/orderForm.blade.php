@extends('layout.app')
@section('content')
<div class="padding">
<div class="container whiteForm padding left">

    <form action="{{route('billingconfirm')}}" method="post"  enctype="multipart/form-data">
        {{csrf_field()}}
        <h2>Billing details</h2>
        <p>Enter your details to the form below to process your order.</p>
        <div class="row">
            <div class="form-group col-md-6 ">
                <label for="inputPassword4">First-Name:</label>
                <strong><sup>*</sup></strong><input type="text"  name="firstname" id="first-name" class="form-control" placeholder="First name">
            </div>
            <div class="form-group col-md-6">
                <label for="inputPassword4">Last-Name:</label> <strong><sup>*</sup></strong>
              <input type="text"   name="last-name" id="lastname"class="form-control" placeholder="Last name">
            </div>
        </div>
        <div class="row">
            <div class="form-group col-md-6">
                <label for="inputPassword4">Phone:</label> <strong><sup>*</sup></strong>
                <input type="text"  name="phone" id="phone" class="form-control" placeholder="017XXXXXXXX">
            </div>
            <div class="form-group col-md-6">
                <label for="inputPassword4">Email:</label> <strong><sup>*</sup></strong>
                <input type="text" name="email" id="email" class="form-control" placeholder="Email">
            </div>
        </div>
        Country:<strong>Bangladesh</strong> <strong><sup>*</sup></strong>

        <div class="form-group">
            <label for="inputAddress">Address</label> <strong><sup>*</sup></strong>
            <input type="text" name="address" class="form-control" id="inputAddress" placeholder="House number and street name">
        </div>
        <div class="form-group">
            <input type="text" name="flat"  class="form-control" id="inputAddress" placeholder="Apartment, suite, unit, etc. (optional)">
        </div>


            <div class="form-group col-md-6">
                <label for="inputCity">City</label> <strong><sup>*</sup></strong>
                <input type="text" class="form-control" id="inputCity" name="city">
            </div>
            <div class="form-group col-md-4">
                <label for="inputState">Division</label> <strong><sup>*</sup></strong>
                <select id="inputState" class="form-control"  name="division">
                    <option selected>Dhaka</option>
                    <option>Khulna</option>
                    <option>Mymensingh</option>
                    <option>Rajshahi </option>
                    <option >Barisal</option>
                    <option>Rangpur </option>
                    <option>Chittagong</option>
                </select>
            </div>
            <div class="form-group col-md-2">
                <label for="inputZip">Zip</label> <strong><sup>*</sup></strong>
                <input type="text" class="form-control" id="inputZip" name="zip" id="zip">
            </div>




        <script type="text/javascript">

        function bkash(){
            document.getElementById("cash").style.display='none';
            document.getElementById("bKash").style.display='block';
        }

        function cash(){
            document.getElementById("cash").style.display='block';
            document.getElementById("bKash").style.display='none';
        }
        </script>


        <div class="container paymentpart paddingbkash">
            <div class="form-group col-md-4 padding">
                <h2>Billing details</h2>
                <ul>
                <li>
                    <input type="radio"  onclick="cash()" id="huey" name="paymentmethod" value="cash On delivery" checked>
                <label class="font1" for="huey">Cash on Delivery</label>
                    <div class="bkash paddi"bkash paddi"bkash padding" id="cash">
                        Pay with cash on the time of delivery.
                    </div>
                </li>
             <li>
                <input type="radio"   onclick="bkash()" id="huey" name="paymentmethod" value="bkash">
                <label class="font1" for="huey">pay in bKash</label>

                 <div class="bkash padding" id="bKash">
                     Please complete your bKash payment at first, then fill up the form below. Also note that 1.85% bKash "SEND MONEY" cost will be added with net price. Total amount you need to send us at ৳ XXX

                     bKash Personal Number : 019XXXXXXX Or 016XXXXXXXXXXXX
                     <label for="formGroupExampleInput">bKash Number</label>
                     <input type="text" class="form-control" id="formGroupExampleInput" name="paymentnumber" placeholder="017XXXXXXXX">
                     <label for="formGroupExampleInput">bKash Transaction ID</label>
                     <input type="text" class="form-control" id="formGroupExampleInput" name="txid" placeholder="f5df4g9h8ryt9g6">
                 </div>
                    </li>
                 </ul>
            </div>
        <div class="col-md-4 redfont">
            <div>Note.</div>
            <div class="">আপনার অবগতির জন্য জানানো যাচ্ছে যে ঢাকা শহরের বাহিরে যেকোনো অর্ডার এর জন্য পূর্বে বিকাশ পেমেন্ট করতে হবে </div>
        </div>

            <div class="col-md-4">

                <div class="cart_totals container paddingbkash payposition">
                    <h2>Cart Totals</h2>
                    <table>
                        <tbody>
                        <tr class="cart-subtotal">
                            <th>Subtotal</th>
                            <td><span class="amount">৳{{ $cartforall->totalPrice  }}</span></td>
                        </tr>
                        <tr>
                            <th>Shipping</th>
                            <td id="shipping_method">
                                select shipping
                            </td>
                        </tr>
                        <tr class="order-total">
                            <th>Total</th>
                            <td>
                                <strong><span class="amount" id="totalc"> select shipping</span></strong>
                            </td>


                        </tr>

                        </tbody>

                    </table>





                </div>
                <button type="submit" name="submit" class="confirmbutton">confirm your order</button>

            </div>

        </div>




    </form>
</div>

</div>
@endsection
