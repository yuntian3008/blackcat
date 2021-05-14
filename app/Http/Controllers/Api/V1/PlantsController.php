<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Collection;
use App\Plant;
use App\Components\Helper\ImageProcessing;
use Illuminate\Support\Facades\Storage;

class PlantsController extends Controller
{

    protected $imgProcess;

    function __construct()
    {
        $this->imgProcess = new ImageProcessing();
    }

   /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $plants = Plant::with('category:id,category_name')->get();
        foreach ($plants as $plant) {
            $plant['plant_image'] = Storage::url('public/sm_'.$plant['plant_image'].'.jpg');
            // $id_images = collect(json_decode($plant['plant_image'],true))->collapse();
            // $plant['plant_image'] = self::DRIVE_CONFIG_URL.$id_images['sm'];
            //asset('storage/sm_'.$plant['plant_image']);
        }
        return $plants;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()    
    {
        //USE VUEJS
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->merge([ 
            'plant_image' => $this->imgProcess->run($request->plant_image[0]['dataURL'],'plants'),
            'plant_slug' => $this->sluger($request->plant_name)
        ]);
        $plant = Plant::create($request->all());
        return $plant;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $plant = Plant::findOrFail($id);
        // $id_images = collect(json_decode($plant['plant_image'],true))->collapse();
        // $plant['plant_image'] = self::DRIVE_CONFIG_URL.$id_images['sm'];
        $plant['plant_image'] = Storage::url('public/sm_'.$plant['plant_image'].'.jpg');
        return $plant;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //USE VUEJS
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
        $plant = Plant::findOrFail($id);
        if ($request->plant_image) {
            $request->merge([ 
                'plant_image' => $this->imgProcess->run($request->plant_image[0]['dataURL'],'plants'),
                'plant_slug' => sluger($request->plant_name)
        ]);
            $plant->update($request->all());
        } else {
            $request->merge([ 
                'plant_slug' => sluger($request->plant_name)
            ]);
            $plant->update($request->except(['plant_image']));
        }
        return $plant;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $plant = Plant::findOrFail($id);
        // Storage::disk('local')->delete('public/plants/lg_'.$plant->plant_image);
        // Storage::disk('local')->delete('public/plants/sm_'.$plant->plant_image);
        $plant->delete();
        return '';
    }
}
