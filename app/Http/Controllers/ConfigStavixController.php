<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use SimpleXMLElement;

class ConfigStavixController extends Controller
{
    public function index()
    {
        //config-stavix-2706-1550.xml
        //cp ./config-stavix-2706-1550.xml ./storage/app/public
        $file = Storage::get('./public/config-stavix-2706-1550.xml');
        $cfg = simplexml_load_string($file);
        $obj = new SimpleXMLElement((string)$file);

        $xml = simplexml_load_string($file, "SimpleXMLElement", LIBXML_NOCDATA);
        $json = json_encode($xml);
        $array = json_decode($json,TRUE);

        return $json;
        dd(
            $json,
            $array['Dir'][80],
            $array['Dir'][80]['Value'],
            $array['Dir'][80]['@attributes'],
        );
    }
}
