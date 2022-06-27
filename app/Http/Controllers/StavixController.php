<?php

namespace App\Http\Controllers;

use DOMDocument;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class StavixController extends Controller
{
    public function index()
    {
        return view('ipfilter');
    }

    public function store(Request $request)
    {
        return response()->json(
            $request->all()
        );
    }

    public function sendRequest()
    {
        //$ip = '128.127.105.184';
        $ip = '192.145.126.115';
        $data = [
            'protocol' => '1',
            'filterMode' => 'Deny',
            'sip' => $ip,
            'smask' => null,
            'sfromPort' => null,
            'stoPort' => null,
            'dip' => null,
            'dmask' => null,
            'dfromPort' => null,
            'dtoPort' => null,
            'addFilterIpPort' => 'Add',
            'submit-url' => '\/fw-ipportfilter_rg.asp',
            'postSecurityFlag' => '7994',
        ];

        $response = Http::retry(3, 1000, function ($exception, $request) {
            // Em caso de não houver login no navegador o sistema cria uma sessão
            $resp = Http::withBody(
                'challenge=&username=admin&password=apartamento36&save=Login&submit-url=%2Fadmin%2Flogin.asp&postSecurityFlag=44603', 'application/x-www-form-urlencoded'
            )->post('http://192.168.1.1/boaform/admin/formLogin');

            if ($resp->successful()) {
                return true;
            }
        })
            ->withBody(
                "protocol=1&filterMode=Deny&sip={$ip}&smask=&sfromPort=&stoPort=&dip=&dmask=&dfromPort=&dtoPort=&addFilterIpPort=Add&submit-url=%2Ffw-ipportfilter_rg.asp&postSecurityFlag=7994", 'application/x-www-form-urlencoded'
            )->post('http://192.168.1.1/boaform/formFilter');


        if ($response->failed()) {
            dd(
                $response->body()
            );
        }

        // set error level
        $internalErrors = libxml_use_internal_errors(true);

        $dom = new DOMDocument();
        $dom->loadHTML($response->body());

        // Restore error level
        libxml_use_internal_errors($internalErrors);

        $content = $dom->getElementsByTagName('h4');

        if ($content[0]->textContent === "Invaild! This is a duplicate or conflicting rule!") {
            //o ip já existe na lista de bloqueio
            dd(
                'o ip já existe na lista de bloqueio',
                $response->body(),
                $dom,
                $content[0]->textContent === "Invaild! This is a duplicate or conflicting rule!"
            );
        }

        dd(
            $response->body(),
            $dom,
            $content[0]->textContent === "Invaild! This is a duplicate or conflicting rule!"
        );
    }
}
