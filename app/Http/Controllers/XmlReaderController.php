<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\XMLdata;

class XmlReaderController extends Controller
{
    public function generatePDFFromXML()
    {
        $xml = simplexml_load_file('../data.xml');
        $dataToInsert = [
            'STRREGION' => $xml->STATUS->STATUSNEW->STRREGION,
            'AMOUNT' => $xml->STATUS->STATUSNEW->AMOUNT,
            'RATE' => $xml->STATUS->STATUSNEW->RATE,
            'NAME' => $xml->STATUS->STATUSNEW->NAME,
            'STR' => $xml->STATUS->STATUSNEW->STR,
            'PAYMENT' => $xml->STATUS->STATUSNEW->PAYMENT,
            'STRPHONE' => $xml->STATUS->STATUSNEW->STRPHONE
        ];
        XMLdata::insert($dataToInsert);
        return XMLdata::get();
    }
}
