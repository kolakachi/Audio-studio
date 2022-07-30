<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Redis;
use MicrosoftAzure\Storage\Blob\BlobRestProxy;
use MicrosoftAzure\Storage\Blob\Models\ListBlobsOptions;

class AzureResourcesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function getSounds(){
        try{

            $files = [];
            $cachedSounds = Redis::get('_audio_sounds');
            if(!isset($cachedSounds)){
                $connectionString = "DefaultEndpointsProtocol=https;AccountName=audiostudio;AccountKey=ZGnZeVC4l/KOjleGQPj6EqFA6a/Lf/P26rQt4zH1rCKnj5K9pgz395aBf85qX5oBrLE9YIDo1KWD+AStYwIPmg==;EndpointSuffix=core.windows.net";
                $blobClient = BlobRestProxy::createBlobService($connectionString);

                $listBlobsOptions = new ListBlobsOptions();
                $listBlobsOptions->setMaxResults(5);

                do {
                    // global $myContainer;
                    $blob_list = $blobClient->listBlobs('sounds', $listBlobsOptions);
                    foreach ($blob_list->getBlobs() as $blob) {
                        $files[] = [
                            'name' => str_replace(".mp3", "", str_replace("-", " ", $blob->getName())),
                            'src' => $blob->getUrl()
                        ];
                        // echo $blob->getName().": ".$blob->getUrl().PHP_EOL;
                    }
        
                    $listBlobsOptions->setContinuationToken($blob_list->getContinuationToken());
                } while ($blob_list->getContinuationToken());
                // \Log::info(json_encode($files));
                // $filesCollectionObj = collect($files);
                // $files = $this->paginate($filesCollectionObj);
                Redis::set('_audio_sounds', json_encode($files));

            }else{
                $files = json_decode($cachedSounds, FALSE);
            }

            $filesCollectionObj = collect($files);
            $files = $this->paginate($filesCollectionObj, 10, request()->c_page);
           
            return response()->json([
                'files' => $files
            ]);
            
        }catch (Exception $error) {
            $message = $error->getMessage();
            \Log::info('AzureResourcesController@getSounds - errorMessage: '. $message);

            return response()->json([
                'message' => 'Unable to get sounds'
            ],500);
           
        }

    }

    public function getMusic(){
        try{

            $files = [];
            $cachedMusic = Redis::get('_audio_music');
            if(!isset($cachedMusic)){
                $connectionString = "DefaultEndpointsProtocol=https;AccountName=audiostudio;AccountKey=ZGnZeVC4l/KOjleGQPj6EqFA6a/Lf/P26rQt4zH1rCKnj5K9pgz395aBf85qX5oBrLE9YIDo1KWD+AStYwIPmg==;EndpointSuffix=core.windows.net";
                $blobClient = BlobRestProxy::createBlobService($connectionString);

                $listBlobsOptions = new ListBlobsOptions();
                $listBlobsOptions->setMaxResults(5);

                do {
                    // global $myContainer;
                    $blob_list = $blobClient->listBlobs('music', $listBlobsOptions);
                    foreach ($blob_list->getBlobs() as $blob) {
                        $files[] = [
                            'name' => str_replace(".mp3", "", str_replace("-", " ", $blob->getName())),
                            'src' => $blob->getUrl()
                        ];
                        // echo $blob->getName().": ".$blob->getUrl().PHP_EOL;
                    }
        
                    $listBlobsOptions->setContinuationToken($blob_list->getContinuationToken());
                } while ($blob_list->getContinuationToken());
    
                Redis::set('_audio_music', json_encode($files));

            }else{
                $files = json_decode($cachedMusic, FALSE);
            }
            $filesCollectionObj = collect($files);
            $files = $this->paginate($filesCollectionObj, 10, request()->c_page);
            // dd($files);
            return response()->json([
                'files' => $files
            ]);
            
        }catch (\Exception $error) {
            $message = $error->getMessage();
            \Log::info('AzureResourcesController@getMusic - errorMessage: '. $message);

            return response()->json([
                'message' => 'Unable to get sounds'
            ], 500);
           
        }

    }
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public function paginate($items, $perPage = 10, $page = null, $options = [])
    {
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
        $items = $items instanceof Collection ? $items : Collection::make($items);
        return new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, $options);
    }
}
