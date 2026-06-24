<?php
// ... (namespace, use statements)

class FotoController extends Controller
{
    // ... (behaviors, verbs)

    public function actionUploadBukti($uuid)
    {
        // ... (kode untuk mencari surat, validasi, dan simpan file)

        // 5. Update record surat
        $surat->nama_penerima = $request->post('nama_penerima');
        $surat->tanggal_penerimaan = date('Y-m-d H:i:s');
        $surat->foto_bukti = $path_bukti;
        $surat->foto_bukti_original = $path_original;
        // Mengubah status menjadi perlu diulas, bukan diterima
        $surat->status = SuratEkspedisi::STATUS_PERLU_DIULAS; 
        
        if ($surat->save()) {
            return $surat;
        } else {
            // ... (error handling)
        }
    }
}
