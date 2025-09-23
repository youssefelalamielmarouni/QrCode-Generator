<?php

namespace App\Http\Controllers;

use App\Models\QrCode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Endroid\QrCode\Builder\Builder;
use Endroid\QrCode\Writer\PngWriter;
use App\Http\Requests\StoreQrcodeRequest;
use App\Http\Requests\UpdateQrcodeRequest;


class QrcodeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $qrcodes = QrCode::paginate(1);
        return view('qrcodes.index', compact('qrcodes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('qrcodes.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     * 
     */
    public function store(StoreQrcodeRequest $request)
    {
        $data = $request->validated();
        $data['user_id'] = 1;
        $qrcode = QrCode::create($data);
        $qrCode->qr_code_path = $this->saveQrCode($qrcode);
        $qrcode->save();
        //decremant the number of available qr codes
        //auth()->user()->decrement('number_of_qrcodes');
        return redirect()->route('qrcodes.index')->with('success', 'QR Code created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\QrCode  $qrCode
     * @return \Illuminate\Http\Response
     */
    public function show(QrCode $qrCode)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\QrCode  $qrCode
     * @return \Illuminate\Http\Response
     */
    public function edit(QrCode $qrCode)
    {
        return view('qrcodes.edit')->with('qrcode', $qrCode);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\QrCode  $qrCode
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateQrcodeRequest $request, QrCode $qrCode)
    {
        $data = $request->validated();
        $data['user_id'] = 1;
        $qrCode->update($data);
        $qrCode->qr_code_path = $this->saveQrCode($qrCode);
        $qrCode->save();
        //decremant the number of available qr codes
        //auth()->user()->decrement('number_of_qrcodes');
        return redirect()->route('qrcodes.index')->with('success', 'QR Code updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\QrCode  $qrCode
     * @return \Illuminate\Http\Response
     */
    public function destroy(QrCode $qrCode)
    {
        if(auth()->user()->qrcodes->contain($qrCode)){
            $this->removeQrcodeFromStorege($qrCode->qr_code_path);
        $qrCode->delete();
        return redirect()->route('qrcodes.index')->with('success', 'QR Code deleted successfully.');
      //  }else{
        //    return redirect()->route('qrcodes.index')->with('error', 'somethingwent wrong.');
        }
    }

    //create and save the qr code image to storage
    public function saveQrCode(QrCode $qrcode)
    {
        $builder = Builder::create()
            ->writer(new PngWriter())
            ->data($qrcode->content)
            ->size(150)
            ->build();

        $qrcode = $builder->build();

        //define the qr code path
        $qrCodePath = 'qrcodes/' . $qrcode->id . '.png';

        //save the qr code to storage
        Storage::disk('public')->put($qrCodePath, $qrcode->getString());

        //return file path
        return 'storage/' . $qrCodePath;
    }

    //remove the qr code image from storage

    public function removeQrcodeFromStorege($qrcodeFile){
        $Path = public_path($qrcodeFile);
        if(File::exists($Path)){
            File::delete($Path);
        }
    }
}
