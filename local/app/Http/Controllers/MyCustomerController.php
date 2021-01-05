<?php

namespace App\Http\Controllers;

use DB;
use Auth;
use App\Models\User;
use App\Models\Cart;
use App\Models\Order;
use App\Models\Product;
use App\Models\CustomerAddress;
use App\Models\OrderItem;
use App\Models\Wishlist;
use App\Models\ProductAttachment;
use Illuminate\Http\Request;
use App\Notifications\OrderNotification;

class MyCustomerController extends Controller
{
    public function index()
    {
    	return view('admin.home');
    }

    public function addCart(Request $request)
    {
    	$this->validate($request, [
    		'product_id' => 'required',
    		'quantity' => 'required',
    		'unit_cost' => 'required',
    	]);
    	$cart = Cart::where('product_id', $request->product_id)->where('customer_id', Auth::user()->id)->first();
    	if(isset($cart->id))
    	{
    		$quantity = $cart->quantity + $request->quantity;
    		$total_cost = $quantity*$request->unit_cost;
    		$data = [
    			'quantity' => $quantity,
    			'total_cost' => $total_cost,
    		];
    		$cart = Cart::find($cart->id)->update($data);
    	}else{
    		$total_cost = $request->quantity > 0 ? $request->quantity*$request->unit_cost : $request->unit_cost;
	    	$data = [
	    		'customer_id' => Auth::user()->id,
	    		'product_id' => $request->product_id,
	    		'quantity' => $request->quantity,
	    		'unit_cost' => $request->unit_cost,
	    		'total_cost' => $total_cost,
	    	];
	    	$cart = Cart::create($data);
    	}
        if($request->ajax()){
            $response = array(
                'status' => 'success',
                'value' => $data
            );
            return response()->json($response);
        }else{
            alert()->success('Success', 'Product added to cart, Succesfully');
            return redirect()->back();
        }
    }

    public function mycart(Request $request)
    {
        // $orders = Cart::where('customer_id', Auth::user()->id)->orderBy('id', 'desc')->paginate(20);
        $mycart['cart'] = Cart::where('customer_id', Auth::user()->id)->orderBy('id', 'desc')->get();
        $mycart['cart']->map(function($cart){
            $cart['product_name'] = Product::getTitle($cart->product_id);
            $cart['product_slug'] = Product::getSlug($cart->product_id);
            $cart['product_inventory'] = Product::getInventory($cart->product_id);
            $cart['product_image'] = ProductAttachment::getProductSingleImage($cart->product_id);
            return $cart;
        });
        $mycart['total'] = Cart::where('customer_id', Auth::user()->id)->sum('total_cost');
        $mycart['tax'] = 0;
        $mycart['shipping_cost'] = 0;
        $mycart['shipping_type'] = 'Free';
        $mycart['net_total'] = $mycart['total'] + $mycart['tax'] + $mycart['shipping_cost'];
        return view('theme.cart')->with('mycart', $mycart);
    }

    public function myorder(Request $request)
    {
        $orders = Order::where('customer_id', Auth::user()->id)->orderBy('id', 'desc')->paginate(20);
        return view('admin.myorder.index', compact('orders'));
    }
    public function view_myorder($id)
    {
        $datas['order'] = Order::findOrFail($id);
        $datas['order_item'] = OrderItem::where('order_id', $id)->get();
        $datas['order_item']->map(function($item){
            $item['product_name'] = Product::getTitle($item->product_id);
            $item['product_slug'] = Product::getSlug($item->product_id);
            $item['product_image'] = ProductAttachment::getProductSingleImage($item->product_id);
            return $item;
        });
        $datas['customer_address'] = CustomerAddress::where('customer_id', auth()->user()->id)->first();
        $datas['status'][] = ['id' => 'order_pending', 'title' => 'Order Pending'];
        $datas['status'][] = ['id' => 'order_place', 'title' => 'Order Place'];
        $datas['status'][] = ['id' => 'order_cancel', 'title' => 'Order Cancel'];
        $datas['status'][] = ['id' => 'order_success', 'title' => 'Order Delivered'];
        $datas['status'][] = ['id' => 'order_complete', 'title' => 'Order Complete'];

        return view('admin.myorder.view')->with('datas', $datas);
    }

    public function checkout(Request $request)
    {
        $datas['cart'] = Cart::where('customer_id', Auth::user()->id)->orderBy('id', 'desc')->get();
        $datas['cart']->map(function($cart){
            $cart['product_name'] = Product::getTitle($cart->product_id);
            $cart['product_slug'] = Product::getSlug($cart->product_id);
            $cart['product_image'] = ProductAttachment::getProductSingleImage($cart->product_id);
            return $cart;
        });
        $datas['total'] = Cart::where('customer_id', Auth::user()->id)->sum('total_cost');
        $datas['tax'] = 0;
        $datas['shipping_cost'] = 0;
        $datas['shipping_type'] = 'Free';
        $datas['net_total'] = $datas['total'] + $datas['tax'] + $datas['shipping_cost'];
        return view('theme.checkout')->with('datas', $datas);
    }

    public function place_order(Request $request)
    {
        // return $request->all();
        $this->validate($request, [
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required',
            'phone_number' => 'required',
            'street' => 'required',
            'city' => 'required',
            'country' => 'required',
            'state' => 'required',
            'zip' => 'required',
            'paymentMethod' => 'required',
            'net_total' => 'required',
        ]);
        DB::beginTransaction();
        try {
            $addressData = [
                'customer_id' => auth()->user()->id,
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'email' => $request->email,
                'phone_number' => $request->phone_number,
                'street' => $request->street,
                'city' => $request->city,
                'country' => $request->country,
                'state' => $request->state,
                'zip' => $request->zip,
            ];
            $customer_address = \App\Models\CustomerAddress::where('customer_id', auth()->user()->id)->latest()->first();
            if(isset($customer_address->id)){
                $customer_address->update($addressData);
            }else{
                $customer_address = \App\Models\CustomerAddress::create($addressData);
            }
            
            $orderData = [
                'customer_id' => auth()->user()->id,
                'total_cost' => $request->net_total,
                'shipping_amount' => $request->shipping_amount,
                'tax_amount' => $request->tax_amount,
                'phone' => $request->phone_number,
                'address' => $request->street.'-'.$request->city.'-'.$request->state.'-'.$request->country,
                'payment_mode' => $request->paymentMethod,
                'status' => 'order_pending',
                'order_date' => Date('Y-m-d'),
            ];
            $cart = Cart::where('customer_id', auth()->user()->id)->get();
            $order = Order::create($orderData);
            foreach($cart as $c)
            {
                $orderItemData = [
                    'order_id' => $order->id,
                    'customer_id' => auth()->user()->id,
                    'product_id' => $c->product_id,
                    'quantity' => $c->quantity,
                    'unit_cost' => $c->unit_cost,
                    'total_cost' => $c->total_cost,
                ];
                OrderItem::create($orderItemData);
                $pd = Product::find($c->product_id);
                $inventory = $pd->inventory - $c->quantity;
                if($inventory < 0){
                    $inventory = 0;
                }
                $pd->update(['inventory' => $inventory]);
                $c->delete();
            }
            $user = User::find(1);
            $user->notify(new OrderNotification($order, 'Admin'));
            $customer = User::find(Auth::user()->id);
            $customer->notify(new OrderNotification($order, 'Customer'));
            DB::commit();
        }catch (\Exception $e) {
            DB::rollback();
            alert()->error('Error', 'Please try again!');
            return redirect()->back();
        }
        alert()->success('Success', 'Thank you! Your order has been placed!');
        return redirect()->route('myorder');
    }

    public function wishlist(Request $request)
    {
        $wishlists = Wishlist::where('customer_id', Auth::user()->id)->paginate(50);
        $wishlists->map(function($wish){
            $wish['product_title'] = Product::getTitle($wish->product_id);
            $wish['product_slug'] = Product::getSlug($wish->product_id);
            $wish['product_price'] = Product::getProductPrice($wish->product_id);
            $wish['product_inventory'] = Product::getProductInventory($wish->product_id);
            $wish['product_image'] = Product::getAttachmentFromId($wish->product_id);
            return $wish;
        });
        return view('admin.wishlist.index', compact('wishlists'));
    }
    public function wishlist_action(Request $request)
    {
        $wishlist = Wishlist::where('customer_id', Auth::user()->id)->where('product_id', $request->product_id)->first();
        if(isset($wishlist->id))
        {
            $wishlist->delete();
            $response = [
                'message' => 'Product Removed From Wishlist!',
                'action' => 'remove'
            ];
            return $response;
        }else{
            $data = [
                'customer_id' => Auth::user()->id,
                'product_id' => $request->product_id
            ];
            Wishlist::create($data);
            $response = [
                'message' => 'Product Wishlisted SUccessfully!',
                'action' => 'add'
            ];
            return $response;
        }
    }
    public function notification()
    {
        $notifications = Auth::User()->notifications()->paginate(50);
        return view('admin.myorder.notification', compact('notifications'));
    }
    public function notification_view($id)
    {
        $notification = Auth::User()->notifications()->where('id', $id)->first();
        if ($notification) {
            $notification->markAsRead();
            return redirect()->route('view_myorder', $notification->data['order_id']);
        }
        return redirect()->back();
    }
}
