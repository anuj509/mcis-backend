<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Manufacturer;
use App\MModel;
class InventoryController extends Controller
{
    public function index(Request $request){
        $inventory_rows = Manufacturer::join('models','manufacturers.id','=','models.manufacturer_id')
        ->select('models.id','manufacturers.name AS manufacturer_name','models.name AS model_name','models.color','models.year','models.registration_number','models.note','models.count','models.image_url_1','models.image_url_2')
        ->where('models.count',">",0)
        ->get();
        $baseurl = $request->getScheme() . '://' . $request->getHttpHost() . $request->getBasePath()."/";
        //assigning baseurl to image path in all rows
        foreach ($inventory_rows as $key => $value) {
            $inventory_rows[$key]['image_url_1'] = $baseurl.$inventory_rows[$key]['image_url_1'];
            $inventory_rows[$key]['image_url_2'] = $baseurl.$inventory_rows[$key]['image_url_2'];
        }
        return Response()->json($inventory_rows);
    }

    public function markAsSold(Request $request){
        $model_id = $request->model_id;
        $model = MModel::findOrFail($model_id);
        $model->update(['count'=>0]);
        try {
            $model->save();
            return Response()->json([
                "status"=>"success",
                "message"=>"Model marked as Sold."
            ]);
        }
        catch (\Exception $e) {
            return Response()->json([
                "status"=>"error",
                "message"=>$e->getMessage()
            ]);
        }
    }
}
