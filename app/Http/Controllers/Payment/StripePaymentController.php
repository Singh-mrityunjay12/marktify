<?php

namespace App\Http\Controllers\Payment;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Stripe;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
// use Cart;
use App\Models\Frontend\Product;
use Gloudemans\Shoppingcart\Facades\Cart;

class StripePaymentController extends Controller
{
   /**
    * stripe form page
   */
    public $stripe;
    public function __construct()
    {
        $this->stripe = new \Stripe\StripeClient(config('services.STRIPE_SECRET_KEY'));
    }
    public function stripe($request): View
    {
        $setting = getSetting();
        if (Cart::instance('default')->count() ==  0) {
            redirect()->route('frontend.cart.index',app()->getLocale());
        }
        if($setting->is_checked_stripe == 0){  //setting stripe is not checked
            redirect()->route('frontend.cart.index',app()->getLocale());
        }
        $data['stripe_key'] = $setting->stripe_key;
        $symbol = $setting->default_symbol ?? '$';
        $data['total_amount'] = @$symbol.$request['total_amount'];
        return view('frontend.gateways.stripe',$data);
    }
      
   /**
     * success response method.
     *
     * @return \Illuminate\Http\Response
     */
    public function handlePayment($request)
    {
        try {

                $contents = Cart::instance('default')->content()->map(function ($item) {
                    return $item->model->name . ', ' . $item->qty;
                })->values()->toJson();

                $quantity = Cart::instance('default')->count();
        
                $stripeLineItems = [
                    'price_data' => [
                        'currency' => getSettingShortValue('default_currency') ?? 'USD',
                        'product_data' => [
                            'name' => "Order Total",
                        ],
                        'unit_amount' => $request['total_amount'] * 100,
                    ],
                    'quantity' => 1,
                ];

                $data = [
                    'payment_method_types' => ['card'],
                    'line_items' => [$stripeLineItems],
                    'locale' => 'auto',
                    'customer_email' => @$request['email'],
                    'metadata' => [
                        'transactionType' => "SALE",
                        // 'user_id' => $user->id,
                        'contents' => $contents,
                        'quantity' => $quantity,
                        'discount' => session()->has('coupon') ? json_encode(session('coupon')) : null,
                    ],
                    'mode' => 'payment',
                    'success_url' => route('frontend.success.payment',app()->getLocale()).'?session_id={CHECKOUT_SESSION_ID}',
                    'cancel_url' => route('frontend.cancel.payment',app()->getLocale()),
                ];

                $charge = $this->stripe->checkout->sessions->create($data);
                session()->put('stripe_session_id',$charge->id);
                return redirect()->to($charge->url);
        }catch (\Exception $e) {
            return redirect()->route('frontend.cancel.payment',app()->getLocale())->withError('Error ' . $e->getMessage());
        }
         return redirect()->route('frontend.cart.index',app()->getLocale());
    }

//success payment
    public function success(Request $request)
    {
        $stripe_session_id = session()->get('stripe_session_id');
        $data = $this->stripe->checkout->sessions->retrieve(
            $request->session_id
        );
        
        if(!empty($data) && isset($request->session_id) && $request->session_id == $stripe_session_id)
        {
            if($data->payment_status == 'paid'){
                $request->status = 'success';
                $request->subscription_id= $data->subscription;
                $request->stripe_session_id = $stripe_session_id;
                return (new CheckoutController())->paymentSuccess($request);
            }else {
                    return response()->route('frontend.cancel.payment');
                }
        }

    }
}
