<?php

namespace App\Http\Controllers;

use App\Order;
use App\OrderStatus;
use Illuminate\Http\Request;
use App\Repositories\Contract\OrderRepositoryInterface;
use App\Http\Requests\StoreOrder;
use App\Http\Requests\StoreFile;
use Illuminate\Support\Facades\Storage;


class OrderController extends Controller
{
    protected $orderRepository;
    
    /**
     * 
     */
    public function __construct(OrderRepositoryInterface $orderRepository)
    {
        $this->orderRepository = $orderRepository;
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        /*
        return Order::with('customer')->withCount(['items as sum' => function($query) {
            $query->select(\DB::raw('sum(quantity*unit_price_cny)'));
        }])->paginate(20);
        */
        return $this->orderRepository->all($request->keyword);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    /*
    public function create()
    {
        //
    }
    */

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreOrder $request)
    {
        $order = $this->orderRepository->create($request, auth()->user());

        $orderDetail = $this->orderRepository->createDetail($order,   $request->orderItems, $request->exchange_rate);

        return response()->json($order->toArray());
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\OrderModel  $orderModel
     * @return \Illuminate\Http\Response
     */
    public function show(Order $order)
    {
        return Order::with(
            ['customer',
            'address',
            'items', 
            ]
        )->with([
            'items.product' => function($query){
                $query->withTrashed();
            }
            ]
        )
        ->where('id',$order->id)->get();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\OrderModel  $orderModel
     * @return \Illuminate\Http\Response
     */
    public function edit(Order $order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\OrderModel  $orderModel
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Order $order)
    {
        return $order;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\OrderModel  $orderModel
     * @return \Illuminate\Http\Response
     */
    /*
    public function destroy(Order $order)
    {
        //
    }
    */
    public function sent(Order $order)
    {
        $this->authorize('changeStatus', $order);
        return $this->orderRepository->sent($order);
    }

    public function paid(Order $order)
    {
        $this->authorize('changeStatus', $order);
        return $this->orderRepository->paid($order);
    }

    public function uploadFile(StoreFile $request, Order $order)
    {
        
        $uploadedFile = $request->file('file');
        
        $filename = $uploadedFile->getClientOriginalName();
        
        $path = Storage::putFileAs('upload', $request->file('file'), uniqid(). "-" .$filename);
        
        return $path;
    }
}
