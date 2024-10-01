<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Transaksi;
use Mpdf\Mpdf;

class PDFController extends Controller
{
    public function cetakStruk($idTransaksi)
    {
        // Ambil data transaksi beserta rincian produk terkait
        $dataTransaksi = Transaksi::with('details.product')->findOrFail($idTransaksi);
        
        $dataBaris = [];
        foreach ($dataTransaksi->details as $detailItem) {
            $dataBaris[] = [
                'nama_produk' => $detailItem->product->name,
                'jumlah' => $detailItem->qty,
                'harga_satuan' => $detailItem->product->harga, 
                'total_harga' => $detailItem->qty * $detailItem->product->harga,
            ];
        }

        $pdfGenerator = new Mpdf();
        
        $viewStruk = view('Struk.pdf', [
            'transaksi' => $dataTransaksi,
            'rows' => $dataBaris,
            'pembayaran' => $dataTransaksi->pembayaran,
            'kembali' => $dataTransaksi->kembalian,
        ])->render();
        
        $pdfGenerator->WriteHTML($viewStruk);
        
        return $pdfGenerator->Output('struk-transaksi.pdf', 'I'); 
    }
}
