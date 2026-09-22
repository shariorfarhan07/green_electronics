<link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<!------ Include the above in your HEAD tag ---------->
<style>
    body {
        background: grey;
        margin-top: 120px;
        margin-bottom: 120px;
    }
</style>




<div class="container" id='container1'>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body p-0">
                    <div class="row p-5">
                        <div class="col-md-6">
                            <h1>ElectronicsBagBd.com</h1>
                            <h2>Call:01875589192</h2>
                            <h5>electronicsbagbd.com</h5>

                            <p class="font-weight-bold mb-4">Payment Details</p>
                            <p class="mb-1"><span class="text-muted">Payment: </span>
                                @if($customer['txid']=='cash on delevery')
                                cash on delevery
                                @else
                                paid by bkash
                                @endif

                            </p>
                        </div>

                        <div class="col-md-6 text-right">
                            <p class="font-weight-bold mb-1">Order id#{{$customer['id']}}</p>
                            <p class="text-muted">Order Date:{{$customer['date']}}</p>
                            <p class="font-weight-bold mb-4">Client Information</p>
                            <p class="mb-1">{{$customer['name']}}</p>
                            <p>{{$customer['address']}}</p>
                            <p class="mb-1">{{$customer['city']}},{{$customer['division']}},Zip-{{$customer['zip']}}</p>
                            <p class="mb-1">{{$customer['phone']}}</p>


                        </div>
                    </div>



                    <div class="row p-5">
                        <div class="col-md-12">
                            <table class="table">
                                <thead>
                                <tr class="bg-secondary text-light">
                                    <th class="border-0 text-uppercase small font-weight-bold">ID</th>
                                    <th class="border-0 text-uppercase small font-weight-bold">Item</th>

                                    <th class="border-0 text-uppercase small font-weight-bold">Quantity</th>
                                    <th class="border-0 text-uppercase small font-weight-bold">Unit Cost</th>
                                    <th class="border-0 text-uppercase small font-weight-bold">Total</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($products as $product)
                                <tr>
                                    <td>{{$product['id']}}</td>
                                    <td>{{$product['item_name']}}/td>

                                    <td>{{$product['qty']}}</td>
                                    <td>{{$product['item_price']}}</td>
                                    <td>{{$product['qty']*$product['item_price']}}</td>
                                </tr>
                                @endforeach

                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="d-flex flex-row-reverse   p-4">



                        @if($customer['discount'])
                        <div class="py-3 px-5 text-right">
                            <div class="mb-2">Grand Total</div>
                            <div class="h2 font-weight-light">৳{{$customer['payment']+$customer['shipping']-$customer['discount']}}</div>
                        </div>
                        @else
                        <div class="py-3 px-5 text-right">
                            <div class="mb-2">Grand Total</div>
                            <div class="h2 font-weight-light">৳{{$customer['payment']+$customer['shipping']}}</div>
                        </div>

                        @endif

                        @if($customer['discount'])
                        <div class="py-3 px-5 text-right">
                            <div class="mb-2">Discount</div>
                            <div class="h2 font-weight-light">৳{{$customer['discount']}}</div>
                        </div>
                        @endif
                        <div class="py-3 px-5 text-right">
                            <div class="mb-2">Delevery Charge</div>
                            <div class="h2 font-weight-light">৳{{$customer['shipping']}}</div>
                        </div>



                        <div class="py-3 px-5 text-right">
                            <div class="mb-2">Sub - Total amount</div>
                            <div class="h2 font-weight-light">৳{{$customer['payment']}}</div>
                        </div>


                    </div>
                    <button type="button" onclick="javascript:printLayer()" class="btn btn-dark">Sign</button>
                </div>

            </div>
        </div>
    </div>



</div>



<script>
    function printLayer(){
        window.print();
    }
</script>
