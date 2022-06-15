<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Solicitud;

class actualizarEstadoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if($id=="njYLu2HLp2JfTu7kcDkhykI6IiNt5kUN4AmYzqrpa14omyKYWGANIGMCBEkLKXioqyotweDWgjeenYD9xvhtGpDtOETVFRLrlroJmchrcajvTzttcffu1Bu3N9GTN7PuLl3XNIPBglqg7oKoXNZIiKtpeFaJoF2pVL3MBQrDA4Xd3L5LEg4l2RuofxTd9Y5rvYlxFfyQsU1O5LpeYZfk5DiMJFPssReLPACp6JGtARdy5WgMppUOCYxUosSI7AdJ2ygNHm4uPw36LiKA5sxrEG1v6ur7pD4jB80aJyQwtts9izCI8wSpTO4LegElflxd967IZrZU10x3SFkM0Dk33Wvw2zYqDQGyrnhSWL72TwjcLA19lFLiOmoaa7t5DKwUWW0Xk9238r1xS4Is3EEXXqH12CXT6YupmYFPHFhj9SJIvnUryQVbpcNFsCzwwWu5rUpdyMFegCw6MpCamR0DHO5tww4HMoxczX9RY07TaycipBSjOZz5UIcPZWq4I9MQ")
        {
            $vencidas=Solicitud::whereNotIn('estado_id', [3, 4])
            ->where('created_at','<',now()->subDays(30))
            ->update([
                'estado_id' => 3
            ]);

            $pendientes=Solicitud::whereNotIn('estado_id', [2, 3, 4])
            ->where('created_at','<',now()->subDays(15))
            ->update([
                'estado_id' => 2
            ]);
            return response('OK', 200)
                  ->header('Content-Type', 'text/plain');
        }      
        else {
            return response('', 405)
                  ->header('Content-Type', 'text/plain');
        }  
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
