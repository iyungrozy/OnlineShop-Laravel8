<?php

namespace App\Http\Controllers;

use App\Masakan;
use App\Cart;
use App\Order;
use App\DetailOrder;
use App\Kategori;
use Auth;
use Alert;

use Session;

use Illuminate\Http\Request;

class FrontEndController extends Controller
{
    public function index()
    {
    	return view('frontend2.menu');
    }

    public function menu(Request $req)
    {   
    	$data = Masakan::join('kategori','kategori.id','masakan.kategori_id')
            ->orWhere('nama_masakan','like',"%{$req->keyword}%")
            ->orWhere('kategori.id',$req->kategori_id)
            ->select('masakan.*','nama_kategori')
            ->orderBy('updated_at','desc')
            ->paginate(9);
            return view('frontend2.menu', compact('data'));
    }

    public function showCategory($id)
    {
        $data = Masakan::where('kategori_id', $id)
        ->join('kategori','kategori.id','masakan.kategori_id')
        ->select('masakan.*','nama_kategori')
        ->paginate(9);
        return view('frontend2.menu', compact('data'));
    }

    public function showItem(Request $req, $id)
    {
        $oldCart = Session::has('cart') ? Session::get('cart') : null;

        $data = Masakan::where('id',$id)->first();
        return view('frontend2.show', ['data'=>$data]);
    }

    public function AddToCart(Request $req, $id)
    {
        $data = Masakan::findOrFail($id);
        $oldCart = Session::has('cart') ? Session::get('cart') : null;
        $cart = new Cart($oldCart);
        $cart->add($data, $data->id);

        $req->session()->put('cart', $cart);
        //return json_encode($req->session()->get('cart'));

        return back()->with('result','success');
        
    }

    public function getRemoveItem($id)
    {
        $oldCart = Session::has('cart') ? Session::get('cart') : null;
        $cart = new Cart($oldCart);
        $cart->removeItem($id);

        if (count($cart->items) > 0) {
            Session::put('cart', $cart);
        } else {
            Session::forget('cart');
        }
        
        return redirect()->route('shopping.cart');
    }

    public function getReduceByOne($id)
    {
        $oldCart = Session::has('cart') ? Session::get('cart') : null;
        $cart = new Cart($oldCart);
        $cart->reduceByOne($id);

        if (count($cart->items) > 0) {
            Session::put('cart', $cart);
        } else {
            Session::forget('cart');
        }

        return redirect()->route('shopping.cart');
    }

    public function getAddOne($id)
    {
        $oldCart = Session::has('cart') ? Session::get('cart') : null;
        $cart = new Cart($oldCart);
        $cart->addOne($id);

        Session::put('cart', $cart);
        return redirect()->route('shopping.cart');
    }

    public function getCart()
    {
        if (!Session::has('cart')) {
            return view('frontend2.shopping-cart');
        }   
        //$ppn = (['totalPrice']*10%);
        $oldCart = Session::get('cart');
        $cart = new Cart($oldCart);
        return view('frontend2.shopping-cart', ['data' => $cart->items, 'totalPrice'=>$cart->totalPrice]);
        //return response()->json(['data' => $cart->items, 'totalPrice'=>$cart->totalPrice]); 
    }

    public function destroy()
    {
        Session::forget('cart');
        return redirect()->route('menu-masakan')->with('result','clear');
    }

    public function getCheckout()
    {
        if (!Session::has('cart')) {
            return view('frontend2.shopping-cart');
        }
        $oldCart = Session::get('cart');
        $cart = new Cart($oldCart);
        $total = $cart->totalPrice;
        return view('frontend2.checkout', ['data' => $cart->items, 'total' => $total]);
        //return response()->json(['data'=> $cart->items, 'total' => $total]);
    }

    public function postCheckout(Request $req)
    {
     
        $status_order = 'Menunggu Pembayaran'; // Default status

        if(Auth::check() && Auth::user() && Auth::user()->level == 'admin') {
            $status_order = 'Sudah Dibayar';
        }
        if (!Session::has('cart')) {
            return redirect()->route('shopping.cart');
        }

        $oldCart = Session::get('cart');
        $cart = new Cart($oldCart);

        // Pilih nomor meja yang tersedia
        $availableTable = Order::where('status_order', '!=', 'Beres')
                                ->pluck('no_meja')
                                ->toArray();
        $no_meja = $this->findAvailableTable($availableTable);

        // Buat kode order
        $blt = date('ms');
        $kode_ord = 'INV'.$blt;

        try {
            // Insert order
            $order = new Order;
            $order->kode_order = $kode_ord.sprintf("%03s", $req->kode_order);
            $order->no_meja = $no_meja; // Set nomor meja yang dipilih
            $order->id_user = $req->id_user;
            $order->cart = serialize($cart);
            $order->subtotal = $cart->totalPrice;
            $order->keterangan = $req->keterangan;
            $order->status_order = $req->status_order;
            $order->save();
        } catch (Exception $e) {
            // Handle exception
        }
         // Contoh: Simpan status_order ke dalam database
         foreach ($cart->items as $item) {
            $product = Masakan::find($item['item']['id']);
            $product->stok -= $item['qty']; // Kurangi stok berdasarkan jumlah yang dibeli
            $product->save(); // Simpan perubahan stok ke dalam database
        }
    $order = new Order;
    $order->status_order = $status_order;
    // Tambahkan logika lainnya sesuai kebutuhan
        alert()->success('Silahkan lakukan Pembayaran ke Kasir!.', 'Order Berhasil')->persistent('oke');
        Session::forget('cart');
        return redirect()->route('thankyou')->with('result','success');      
    }

    private function findAvailableTable($usedTables)
    {
        $allTables = range(1, 20); // Misalkan ada 20 meja
        $availableTables = array_diff($allTables, $usedTables);
        return $availableTables ? array_shift($availableTables) : null;
    }

    public function thanks()
    {
        $orders = Order::where('id_user',Auth::id())
                ->orderBy('updated_at','desc')->take(1)->get();
        $orders->transform(function($order) {
            $order->cart = unserialize($order->cart);
            return $order;
        });
        return view('frontend2.thanks', compact('orders', 'order'));
    }

    public function history()
    {
        $orders = Order::where('id_user',Auth::id())
                ->orderBy('updated_at','desc')->get();
        $orders->transform(function($order) {
            $order->cart = unserialize($order->cart);
            return $order;
        });
        return view('frontend2.history', compact('orders'));   
    }
    public function showProduct($id)
    {
        $product = Masakan::find($id);
        return view('frontend2.product_detail', ['product' => $product]);
    }  

}
