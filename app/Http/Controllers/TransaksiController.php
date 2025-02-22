<?php

namespace App\Http\Controllers;

use App\Transaksi;
use App\Order;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TransaksiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $req)
    {
        $data = Transaksi::join('users', 'transactions.user_id', 'users.id')
            ->join('orders', 'transactions.order_id_order', '=', 'orders.id_order')
            ->select('transactions.*', 'users.fullname', 'orders.*')
            ->orderBy('transactions.updated_at','desc')
            ->get();
            return view('admin.pages.transaksi.data', ['data'=>$data]);
    }

    public function delete(Request $req)
    {
        $result = Transaksi::find($req->id);

        if ($result->delete() ){
            alert()->success('Data Berhasil Terhapus dari Database.', 'Terhapus!')->autoclose(3000);
            return redirect()->route('admin.transaksi');
        }
    }

    public function kasir(Request $req)
    {
        $orders = Order::where('status_order','Menunggu Pembayaran')->orderBy('updated_at','desc')->get();
            $orders->transform(function($order) {
                $order->cart = unserialize($order->cart);
                return $order;
            });
        
        return view('admin.pages.transaksi.kasir.data', compact('orders'));
    }

    public function payment(Request $req, $id_order)
    {
        $orders =  Order::where('id_order', $id_order)->first();
        return view('admin.pages.transaksi.kasir.payment', ['orders'=>$orders]);
    }

    public function bayar(Request $req)
    {
        $blt = date('ms');
        $kode_ord = 'TSC'.$blt;

        $transaksi = new Transaksi;
        $transaksi->kode_transaksi = $kode_ord.sprintf("%03s", $req->kode_transaksi);
        $transaksi->user_id = $req->user_id;
        $transaksi->order_id_order = $req->order_id_order;
        $transaksi->total_bayar = $req->total_bayar;
        $transaksi->kembalian = $req->kembalian;
        $transaksi->tanggal_transaksi = $req->tanggal_transaksi;

        if ($req->kembalian < 0) {
            return back()->with('result','fail');
        } else {
            
            $transaksi->save();
            return back()->with('result','success');
        }
    }

    public function getFinish($id_order)
    {
        $orders = Order::where('id_order', $id_order)->first();
        $orders->update(['status_order' => 'Pending']);
        alert()->success('Transaksi Telah Berhasil!.','Berhasil')->persistent('oke');
        return redirect()->route('waiter');
    }

    public function create()
    {
        $masakan = Masakan::all(); // Pastikan model Masakan sudah diimport dan nama tabel/model benar
        return view('admin.pages.transaksi.create', compact('masakan'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'user_id' => 'required',
            'order_id_order' => 'required',
            'total_bayar' => 'required|numeric',
            'kembalian' => 'required|numeric',
            'tanggal_transaksi' => 'required|date',
            'masakan' => 'required|array',
            'masakan.*' => 'required|string|max:255' // Validasi setiap item dalam array
        ]);
    
        // Proses penyimpanan data transaksi
        $transaksi = new Transaksi();
        $transaksi->fill($request->except(['masakan']));
        $transaksi->save();
    
        // Proses penyimpanan masakan yang dibeli
        foreach ($data['masakan'] as $item) {
            $masakan = new Masakan(); // Asumsi Anda memiliki model Masakan
            $masakan->transaksi_id = $transaksi->id;
            $masakan->nama_masakan = $item;
            $masakan->save();
        }
    
        return redirect()->route('admin.pages.transaksi.finish', $transaksi->id);
    }

    public function finish($id)
    {
        // Proses penyelesaian transaksi
        $transaksi = Transaksi::find($id);
        // Logika untuk menyelesaikan transaksi
        return view('admin.pages.transaksi.finish', compact('transaksi'));
    }

    
}
