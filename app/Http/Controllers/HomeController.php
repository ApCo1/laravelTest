<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        $smece = ['1979','1908','1098','800','1403','292','797','166','924','782','792','775','721','835','834','837','2454','2108','832','833','1744','1226','831','1882','1887','1884','1886','1883','1885'];
        function what($id){
            if(!$id){
                session(['error' => "Incorrect input"]);
                return view('pages.index');
            }
            $adresa = 'https://www.olx.ba/api/kategorije/';
            $adresa .= $id;
            
            $user = auth()->user();
            if(!$user){
                session(['error' => "Access Denied"]);
                return view('pages.index');
            }
        
            $curl = curl_init();
            $idOLX = '877301020045';
            $tokenOLX = 'mOxqfD48dSTV8dh8830OoccXy54A';
            curl_setopt_array($curl, array(
                CURLOPT_URL => $adresa,
                //CURLOPT_URL => 'https://www.olx.ba/api/brendovi/1887',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_TIMEOUT => 30000,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'GET',
                CURLOPT_HTTPHEADER => array(
                    // Set Here Your Requesred Headers
                    'OLX-CLIENT-ID:' . $idOLX,
                    'OLX-CLIENT-TOKEN:' . $tokenOLX,
                    'Content-Type: application/json',
                ),
            ));
            $response = curl_exec($curl);
            $err = curl_error($curl);
            curl_close($curl);
            if ($err) {
                echo "cURL Error #:" . $err;
            } else {
                //$json = '[' . $response . ']';
                $nresp = json_decode($response, true);
                //$status = $nresp[0]["status"];
                //$status = $this->statusAKS($status);
            }
            return $nresp;
        }
        
        for($i = 0; $i<=28;$i++){
            $nresp[$i] = what($smece[$i]);
        }
        
        return view('home');//->with(compact('data', $data));
        //$this->export($nresp['kategorije'][4]);
        //dd($nresp['kategorije']);
        //return $status;
    }
}
