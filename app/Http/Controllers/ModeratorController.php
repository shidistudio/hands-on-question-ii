<?php

namespace App\Http\Controllers;

use App\Models\Sample;
use App\Models\SampleModerationLabel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use \GuzzleHttp;
use GuzzleHttp\Psr7\Request as PsrRequest;
use Illuminate\Support\Str;

class ModeratorController extends Controller
{
    public function process(Request $request)
    {
        $body = null;
        $valid = false;

        if($request->hasFile('file')){
            if($request->file->isValid()){
                // $body = file_get_contents("https://hips.hearstapps.com/hmg-prod.s3.amazonaws.com/images/javier-di-ez-01-1522355956.jpg?resize=480:*");
                $body = file_get_contents($request->file->getRealPath());
                $valid = true;
            }
        }
        else if($request->file){
            $body = file_get_contents($request->file);
            $valid = true;
        }

        if($valid){
            $client = new GuzzleHttp\Client();

            $headers = ['Content-Type' => 'image/png'];
            $request2 = new PsrRequest('POST', 'https://asia-east2-falcon-293005.cloudfunctions.net/falcon', $headers, $body);
            $promise = $client->send($request2);
            $data = $promise->getBody()->getContents();

            $dataJsonString = str_replace("'",'"',$data);
            $dataJson = json_decode($dataJsonString,true);

            if($dataJson){
                $uniqueID = 'fim_'.Str::random(15).'.jpg';
                $path = Storage::putFileAs('public', $request->file, $uniqueID);

                if($path){
                    // save path

                    // save data table samples
                    $sample = new Sample;
                    $sample->path = $uniqueID;
                    $sample->moderation_data = $dataJsonString;
                    if($sample->save()){
                        $collection = collect($dataJson['ModerationLabels']);
                        $dataMass = $collection->map(function($value,$index) use ($sample){
                                // var_dump($index);
                                return ["name"=>str_replace(" ","-",strtolower($index)),"confidence"=>$value['Confidence']];
                            })->values()->toArray();
                        // $sample->moderationLabels()->create(
                        //     $collection->map(function($value,$index){
                        //         // var_dump($index);
                        //         return ["name"=>str_replace(" ","-"strtolower($index)),"confidence"=>$value['Confidence']];
                        //     })->toArray()
                        // );
                        $sample->moderationLabels()->createMany($dataMass);
                    }
                }
            }

            return $dataJsonString;
        }

        return null;
        

    }
}
