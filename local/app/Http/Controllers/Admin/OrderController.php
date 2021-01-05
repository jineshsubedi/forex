<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Order;
use App\Models\Product;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use App\Models\CustomerAddress;
use App\Models\ProductAttachment;
use App\Http\Controllers\Controller;
use App\Notifications\OrderPlacedNotification;
use App\Notifications\OrderCancelNotification;
use App\Notifications\OrderCompleteNotification;

class OrderController extends Controller
{
    public function index(Request $request)
    {
    	$data['filter_customer'] = '';
    	$data['filter_payment_mode'] = 0;
    	$data['filter_status'] = '';
    	$data['filter_order_date'] = 0;
    	$data['filter_delivery_date'] = 0;
        $url = url('/backend/order?');


    	$data['status'][] = ['id' => 'order_pending', 'title' => 'Order Pending'];
    	$data['status'][] = ['id' => 'order_place', 'title' => 'Order Place'];
    	$data['status'][] = ['id' => 'order_cancel', 'title' => 'Order Cancel'];
    	$data['status'][] = ['id' => 'order_success', 'title' => 'Order Delivered'];
    	$data['status'][] = ['id' => 'order_complete', 'title' => 'Order Complete'];

    	$data['payment_mode'][] = ['id' => 1, 'title' => 'Cash On Deliver'];
    	$data['payment_mode'][] = ['id' => 2, 'title' => 'Paypal'];

        $orders = Order::orderBy('id', 'desc');
        if($request->filter_customer)
        {
            $users = User::where('role', 'customer')->where('name', 'LIKE', '%'.$request->filter_customer.'%')->pluck('id');
            $orders = $orders->whereIn('customer_id', $users);
            $url .= '&filter_customer='.$request->filter_customer;
            $data['filter_customer'] = $request->filter_customer;
        }
        if($request->filter_status)
        {
            $orders = $orders->where('status', $request->filter_status);
            $url .= '&filter_status='.$request->filter_status;
            $data['filter_status'] = $request->filter_status;
        }
        if($request->filter_order_date)
        {
            $orders = $orders->where('order_date', '<=', $request->filter_order_date);
            $url .= '&filter_order_date='.$request->filter_order_date;
            $data['filter_order_date'] = $request->filter_order_date;
        }
        if($request->filter_delivery_date)
        {
            $orders = $orders->where('delivery_date', '<=', $request->filter_delivery_date);
            $url .= '&filter_delivery_date='.$request->filter_delivery_date;
            $data['filter_delivery_date'] = $request->filter_delivery_date;
        }

        $orders = $orders->paginate(20)->setPath($url);

        return view('admin.order.index', compact('orders'))->with('data', $data);
    }

    public function create()
    {
    	
    }

    public function customerAutocomplete(Request $request)
    {
    	$results = array();
        $term = $request->term;
        $queries = User::where('name', 'LIKE', $term.'%')
                            ->select('id', 'name')
                            ->where('role','customer')
                            ->groupBy('id','name')
                            ->take(10)
                            ->get();
        
        foreach ($queries as $query)
        {
            $results[] = [ 'id' => $query->id, 'value' => $query->name ];
        }
        return response()->json($results);
    }

    public function show($id)
    {
        $datas['order'] = Order::findOrFail($id);
        $datas['order_item'] = OrderItem::where('order_id', $id)->get();
        $datas['order_item']->map(function($item){
            $item['product_name'] = Product::getTitle($item->product_id);
            $item['product_slug'] = Product::getSlug($item->product_id);
            $item['product_image'] = ProductAttachment::getProductSingleImage($item->product_id);
            return $item;
        });
        $datas['customer_address'] = CustomerAddress::where('customer_id', $datas['order']->customer_id)->first();
        $datas['status'][] = ['id' => 'order_pending', 'title' => 'Order Pending'];
        $datas['status'][] = ['id' => 'order_place', 'title' => 'Order Place'];
        $datas['status'][] = ['id' => 'order_cancel', 'title' => 'Order Cancel'];
        $datas['status'][] = ['id' => 'order_success', 'title' => 'Order Delivered'];
        $datas['status'][] = ['id' => 'order_complete', 'title' => 'Order Complete'];

        return view('admin.order.view')->with('datas', $datas);
    }
    public function update($id, Request $request)
    {
        $this->validate($request, [
            'order_status' => 'required',
            'shipping_date' => 'required',
        ]);
        $data = [
            'status' => $request->order_status,
            'delivery_date' => $request->shipping_date
        ];
        $order = Order::findOrFail($id);
        $order->update($data);
        if($order->id)
        {
            $user = User::find($order->customer_id);
            // return $user;
            if($order->status == 'order_place'){
                $user->notify(new OrderPlacedNotification($order));
            }
            if($order->status == 'order_cancel'){
                $user->notify(new OrderCancelNotification($order));
            }
            if($order->status == 'order_complete'){
                $user->notify(new OrderCompleteNotification($order));
            }
        }
        alert()->success('Success', 'Order Updated!');
        return redirect()->back();
    }
    public function destroy($id)
    {
    	$order = Order::findOrFail($id);
    	$order->delete();
    	alert()->success('Success', 'Order Deleted!');
        return redirect()->route('order.index');
    }

    public function notification()
    {
        $notifications = User::find(1)->notifications()->paginate(50);
        return view('admin.order.notification', compact('notifications'));
    }
    public function notification_view($id)
    {
        $notification = User::find(1)->notifications()->where('id', $id)->first();
        if ($notification) {
            $notification->markAsRead();
            return redirect()->route('order.show', $notification->data['order_id']);
        }
        return redirect()->back();
    }
}
